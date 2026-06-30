<?php

namespace App\Jobs;

use App\Mail\AdminBulkMail;
use App\Models\BulkEmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBulkEmailToRecipientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    /**
     * @param  array<int, array{path: string, name: string}>  $mailAttachments
     */
    public function __construct(
        public int $bulkEmailLogId,
        public int $userId,
        public string $email,
        public string $name,
        public string $subject,
        public string $message,
        public array $mailAttachments = [],
    ) {
        $this->onQueue('mail');
    }

    public function handle(): void
    {
        Mail::to($this->email)->send(new AdminBulkMail(
            $this->subject,
            $this->message,
            $this->name,
            $this->mailAttachments
        ));

        BulkEmailLog::recordRecipientResult($this->bulkEmailLogId, $this->userId, true);
    }

    public function failed(\Throwable $exception): void
    {
        BulkEmailLog::recordRecipientResult($this->bulkEmailLogId, $this->userId, false);

        Log::error('Bulk email recipient job failed', [
            'bulk_email_log_id' => $this->bulkEmailLogId,
            'user_id' => $this->userId,
            'email' => $this->email,
            'error' => $exception->getMessage(),
        ]);
    }
}
