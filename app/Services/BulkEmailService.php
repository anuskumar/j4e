<?php

namespace App\Services;

use App\Jobs\SendBulkEmailToRecipientJob;
use App\Models\BulkEmailLog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BulkEmailService
{
    /**
     * Queue bulk emails to be sent in the background.
     *
     * @param  array<int, UploadedFile>  $uploadedFiles
     */
    public function send(string $recipientType, array $userIds, string $subject, string $message, array $uploadedFiles = []): array
    {
        $recipients = User::whereIn('id', $userIds)
            ->where('user_type', $recipientType)
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        if ($recipients->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No valid recipients selected.',
                'sent' => 0,
                'failed' => 0,
                'queued' => 0,
                'http_status' => 422,
            ];
        }

        $storedAttachments = $this->storeAttachments($uploadedFiles);
        $mailAttachments = array_map(function (array $attachment) {
            return [
                'path' => $attachment['path'],
                'name' => $attachment['name'],
            ];
        }, $storedAttachments);

        $attachmentLog = array_map(function (array $attachment) {
            return [
                'name' => $attachment['name'],
                'path' => $attachment['storage_path'],
                'size' => $attachment['size'],
            ];
        }, $storedAttachments);

        $recipientLog = $recipients->map(function (User $recipient) {
            return [
                'user_id' => $recipient->id,
                'name' => $recipient->name,
                'email' => $recipient->email,
                'status' => 'pending',
            ];
        })->values()->all();

        $bulkEmailLog = BulkEmailLog::create([
            'recipient_type' => $recipientType,
            'status' => BulkEmailLog::STATUS_QUEUED,
            'sent_by' => Auth::id(),
            'subject' => $subject,
            'message' => $message,
            'attachments' => $attachmentLog ?: null,
            'recipient_count' => count($recipientLog),
            'sent_count' => 0,
            'failed_count' => 0,
            'recipients' => $recipientLog,
        ]);

        foreach ($recipients as $recipient) {
            SendBulkEmailToRecipientJob::dispatch(
                $bulkEmailLog->id,
                $recipient->id,
                $recipient->email,
                $recipient->name ?? ucfirst($recipientType),
                $subject,
                $message,
                $mailAttachments
            )->afterResponse();
        }

        $label = $recipientType === 'customer' ? 'customer' : 'reseller';
        $count = $recipients->count();

        return [
            'success' => true,
            'message' => "Bulk email queued for {$count} {$label}" . ($count === 1 ? '' : 's') . '. Emails will be sent in the background.',
            'sent' => 0,
            'failed' => 0,
            'queued' => $count,
            'bulk_email_log_id' => $bulkEmailLog->id,
            'http_status' => 202,
        ];
    }

    /**
     * @param  array<int, UploadedFile>  $uploadedFiles
     * @return array<int, array{path: string, name: string, storage_path: string, size: int}>
     */
    private function storeAttachments(array $uploadedFiles): array
    {
        if (empty($uploadedFiles)) {
            return [];
        }

        $folder = 'bulk-email-attachments/' . now()->format('Ymd_His') . '_' . Str::random(8);
        $stored = [];

        foreach ($uploadedFiles as $file) {
            if (! $file instanceof UploadedFile || ! $file->isValid()) {
                continue;
            }

            $originalName = $file->getClientOriginalName();
            $storagePath = $file->storeAs($folder, $originalName, 'local');

            $stored[] = [
                'path' => Storage::disk('local')->path($storagePath),
                'name' => $originalName,
                'storage_path' => $storagePath,
                'size' => $file->getSize(),
            ];
        }

        return $stored;
    }
}
