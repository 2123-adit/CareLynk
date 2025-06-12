<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'nominal',
        'is_anonymous',    // ✅ TAMBAH
        'donor_name',      // ✅ TAMBAH
        'message'          // ✅ TAMBAH
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'is_anonymous' => 'boolean',  // ✅ TAMBAH
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getFormattedNominalAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    // ✅ TAMBAH: Accessor untuk display name
    public function getDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonim';
        }
        
        return $this->donor_name ?: $this->user->name;
    }
}