<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nominal',
        'status'
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedNominalAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'menunggu_verifikasi' => '<span class="badge bg-warning">Menunggu Verifikasi</span>',
            'diverifikasi' => '<span class="badge bg-success">Diverifikasi</span>',
            'ditolak' => '<span class="badge bg-danger">Ditolak</span>',
        };
    }
}
