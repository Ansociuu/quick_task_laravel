<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * Whitelist: Các thuộc tính được phép Mass Assignment
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_completed',
    ];

    /**
     * Casts cho các thuộc tính
     */
    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
        ];
    }

    /**
     * Quan hệ 1-N: Task thuộc về 1 User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
