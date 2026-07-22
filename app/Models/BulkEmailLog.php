<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class BulkEmailLog extends Model
{
    public const STATUS_QUEUED = 'queued';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_PARTIAL = 'partial';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'recipient_type',
        'status',
        'sent_by',
        'subject',
        'message',
        'attachments',
        'recipient_count',
        'sent_count',
        'failed_count',
        'recipients',
    ];

    protected $casts = [
        'recipients' => 'array',
        'attachments' => 'array',
        'recipient_count' => 'integer',
        'sent_count' => 'integer',
        'failed_count' => 'integer',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function recipientTypeLabel(): string
    {
        return match ($this->recipient_type) {
            'customer' => 'Customer',
            'reseller' => 'Reseller',
            default => ucfirst($this->recipient_type),
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status ?? self::STATUS_COMPLETED) {
            self::STATUS_QUEUED => 'Queued',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_PARTIAL => 'Partially Sent',
            self::STATUS_FAILED => 'Failed',
            default => ucfirst((string) $this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status ?? self::STATUS_COMPLETED) {
            self::STATUS_QUEUED => 'bg-secondary-transparent',
            self::STATUS_PROCESSING => 'bg-info-transparent',
            self::STATUS_COMPLETED => 'bg-success-transparent',
            self::STATUS_PARTIAL => 'bg-warning-transparent',
            self::STATUS_FAILED => 'bg-danger-transparent',
            default => 'bg-secondary-transparent',
        };
    }

    public function isInProgress(): bool
    {
        return in_array($this->status ?? self::STATUS_COMPLETED, [self::STATUS_QUEUED, self::STATUS_PROCESSING], true);
    }

    public static function recordRecipientResult(int $logId, int $userId, bool $success): void
    {
        DB::transaction(function () use ($logId, $userId, $success) {
            $log = static::query()->lockForUpdate()->findOrFail($logId);
            $recipients = $log->recipients ?? [];
            $updated = false;

            foreach ($recipients as &$recipient) {
                if ((int) ($recipient['user_id'] ?? 0) !== $userId) {
                    continue;
                }

                if (($recipient['status'] ?? '') !== 'pending') {
                    return;
                }

                $recipient['status'] = $success ? 'sent' : 'failed';
                $updated = true;
                break;
            }
            unset($recipient);

            if (! $updated) {
                return;
            }

            if ($success) {
                $log->sent_count++;
            } else {
                $log->failed_count++;
            }

            $log->recipients = $recipients;

            $pendingCount = collect($recipients)->where('status', 'pending')->count();

            if ($pendingCount > 0) {
                $log->status = self::STATUS_PROCESSING;
            } elseif ($log->sent_count > 0 && $log->failed_count > 0) {
                $log->status = self::STATUS_PARTIAL;
            } elseif ($log->sent_count > 0) {
                $log->status = self::STATUS_COMPLETED;
            } else {
                $log->status = self::STATUS_FAILED;
            }

            $log->save();
        });
    }
}
