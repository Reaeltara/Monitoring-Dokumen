<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder ownedBy(int $userId)
 * @method static Builder search(?string $term)
 */
class Document extends Model
{
    protected $fillable = [
        'user_id',
        'nama_dokumen',
        'nomor_dokumen',
        'tanggal_terbit',
        'tanggal_kadaluarsa',
        'keterangan',
        'pdf_path',
        'pdf_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOwnedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        return $query->where(function (Builder $query) use ($term) {
            $query->where('nama_dokumen', 'like', "%{$term}%")
                ->orWhere('nomor_dokumen', 'like', "%{$term}%")
                ->orWhere('keterangan', 'like', "%{$term}%")
                ->orWhere('pdf_name', 'like', "%{$term}%");
        });
    }
}
