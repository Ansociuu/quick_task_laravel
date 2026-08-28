<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Scopes\ActiveScope;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Whitelist: Các thuộc tính được phép Mass Assignment
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Khai báo Global Scope cho Model User
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope());
    }

    /**
     * Local Scope: Lấy ra tất cả người dùng có quyền admin.
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', true);
    }

    /**
     * Accessor & Mutator cho thuộc tính password.
     * Tự động mã hóa bcrypt password trước khi lưu vào CSDL.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::needsRehash($value) ? bcrypt($value) : $value,
        );
    }

    /**
     * Accessor cho thuộc tính name (Ví dụ: Tự động viết hoa chữ cái đầu tiên).
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
        );
    }

    /**
     * Quan hệ 1-N: Một User có nhiều Task
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
