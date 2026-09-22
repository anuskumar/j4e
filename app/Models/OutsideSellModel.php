<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutsideSellModel extends Model
{

    use HasFactory;
    use SoftDeletes;
    protected $table = 'outsidesell';
    protected $fillable = [
        'event_ticket_tickets_id',
        'ticket_type_id',
        'name',
        'phone',
        'address',
        'date',
        'payment_mode',
        'cost_price',
        'sale_price',
        'email',
        'remark',
        'proof_file',
    ];

    protected $casts = [
        'proof_file' => 'array',
        'cost_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    protected $appends = [
        'proof_urls',
    ];

    public function ticketsGenerated()
    {
        return $this->belongsTo(TicketsGenerated::class, 'event_ticket_tickets_id', 'id');
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }

    public function getProofFilesListAttribute(): array
    {
        $files = $this->proof_file;
        if (empty($files)) {
            return [];
        }

        if (is_string($files)) {
            $decoded = json_decode($files, true);
            if (is_array($decoded)) {
                return array_values(array_filter($decoded));
            }

            return $files !== '' ? [$files] : [];
        }

        return is_array($files) ? array_values(array_filter($files)) : [];
    }

    public function getProofUrlsAttribute(): array
    {
        return array_map(
            fn ($file) => asset('storage/uploads/outside_sell_proof/' . $file),
            $this->proof_files_list
        );
    }
}
