<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


public function followings()
{
    return $this->belongsToMany(
        User::class,
        'followers',
        'follower_id',
        'following_id'
    );
}

public function followers()
{
    return $this->belongsToMany(
        User::class,
        'followers',
        'following_id', // الشخص الذي يتم متابعته
        'follower_id'   // الشخص الذي يتابع
    );
}



    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, "user_id", 'id');
    }
public function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn() => $this->avatar ? Storage::disk('public')->url($this->avatar) : asset('images/avatars/blank.png')
        );
    }
    
}
