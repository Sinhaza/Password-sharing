<?php

namespace App\Models;

use App\Models\Scopes\NotExpiredScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[ScopedBy([NotExpiredScope::class])]
class Password extends Model
{
    /** @use HasFactory<\Database\Factories\PasswordFactory> */
    use HasFactory;

    public static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    protected $fillable = [
        'uuid',
        'password',
        'expires_at',
        'visit_limit',
        'visit_count',
    ];

    protected $casts = [
        'uuid'        => 'string',
        'expires_at'  => 'datetime',
        'visit_limit' => 'integer',
        'visit_count' => 'integer',
        'password'    => 'encrypted',
    ];
}
