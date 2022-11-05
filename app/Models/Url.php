<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Url extends Model
{
    use HasFactory;

    protected $table = 'short_link';

    protected $fillable = [
        'url',
        'code',
        'expires_at',
        'user_id',
    ];

    public function couldExpire(): bool
    {
        return $this->expires_at !== null;
    }

    public function hasExpired(): bool
    {
        if (! $this->couldExpire()) {
            return false;
        }

        $expiresAt = new Carbon($this->expires_at);

        return ! $expiresAt->isFuture();
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
