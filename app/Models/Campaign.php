<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'target_donasi',
        'total_terkumpul',
        'tanggal_berakhir',
        'gambar',
        'status',
        'laporan_html'
    ];

    protected $casts = [
        'target_donasi' => 'decimal:2',
        'total_terkumpul' => 'decimal:2',
        'tanggal_berakhir' => 'datetime',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function getProgressPercentAttribute()
    {
        if ($this->target_donasi == 0) return 0;
        return min(100, ($this->total_terkumpul / $this->target_donasi) * 100);
    }

    public function getFormattedTargetAttribute()
    {
        return 'Rp ' . number_format($this->target_donasi, 0, ',', '.');
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_terkumpul, 0, ',', '.');
    }
}