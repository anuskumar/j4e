<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulkEmailLog extends Model
{
    protected $fillable = [
        'recipient_type',
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
}
