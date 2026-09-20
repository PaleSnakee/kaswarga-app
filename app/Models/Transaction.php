<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'head_family_id',
        'transaction_type',
        'amount',
        'category',
        'description',
        'transaction_date',
        'anomaly_score',
        'is_anomaly',
        'audit_status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'anomaly_score' => 'decimal:6',
        'is_anomaly' => 'boolean',
    ];

    /**
     * Relationship dengan HeadFamily (Warga)
     */
    public function headFamily()
    {
        return $this->belongsTo(Warga::class, 'head_family_id');
    }
}