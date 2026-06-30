<?php

namespace App\Services;

use App\Mail\AdminBulkMail;
use App\Models\BulkEmailLog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BulkEmailService
{
    /**
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
                'http_status' => 422,
            ];
        }

        $storedAttachments = $this->storeAttachments($uploadedFiles);
        $sent = 0;
        $failed = 0;
        $recipientLog = [];

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(new AdminBulkMail(
                    $subject,
                    $message,
                    $recipient->name ?? ucfirst($recipientType),
                    $storedAttachments
                ));
                $sent++;
                $recipientLog[] = [
                    'user_id' => $recipient->id,
                    'name' => $recipient->name,
                    'email' => $recipient->email,
                    'status' => 'sent',
                ];
            } catch (\Throwable $e) {
                $failed++;
                $recipientLog[] = [
                    'user_id' => $recipient->id,
                    'name' => $recipient->name,
                    'email' => $recipient->email,
                    'status' => 'failed',
                ];
                Log::error('Failed to send bulk email', [
                    'recipient_type' => $recipientType,
                    'user_id' => $recipient->id,
                    'email' => $recipient->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $attachmentLog = array_map(function (array $attachment) {
            return [
                'name' => $attachment['name'],
                'path' => $attachment['storage_path'],
                'size' => $attachment['size'],
            ];
        }, $storedAttachments);

        if ($sent === 0) {
            $this->deleteStoredAttachments($storedAttachments);

            return [
                'success' => false,
                'message' => 'Failed to send email to the selected recipients.',
                'sent' => 0,
                'failed' => $failed,
                'http_status' => 500,
            ];
        }

        BulkEmailLog::create([
            'recipient_type' => $recipientType,
            'sent_by' => Auth::id(),
            'subject' => $subject,
            'message' => $message,
            'attachments' => $attachmentLog ?: null,
            'recipient_count' => count($recipientLog),
            'sent_count' => $sent,
            'failed_count' => $failed,
            'recipients' => $recipientLog,
        ]);

        $label = $recipientType === 'customer' ? 'customer' : 'reseller';
        $responseMessage = "Email sent to {$sent} {$label}" . ($sent === 1 ? '' : 's') . '.';
        if ($failed > 0) {
            $responseMessage .= " {$failed} failed.";
        }

        return [
            'success' => true,
            'message' => $responseMessage,
            'sent' => $sent,
            'failed' => $failed,
            'http_status' => 200,
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

    /**
     * @param  array<int, array{path: string, storage_path: string}>  $storedAttachments
     */
    private function deleteStoredAttachments(array $storedAttachments): void
    {
        foreach ($storedAttachments as $attachment) {
            Storage::disk('local')->delete($attachment['storage_path']);
        }
    }
}
