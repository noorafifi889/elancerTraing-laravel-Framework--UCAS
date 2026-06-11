<?php

namespace App\Models;

use App\Enum\PostStatus;
use App\Models\Scopes\OwnerScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder; // <-- تأكدي أن هذا السطر موجود فوق
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

#[ScopedBy(OwnerScope::class   )]

class Post extends Model
{
use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id", "id")
            ->withDefault([
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
            ])
        ;
    }
    protected $fillable = [
        "id",
        'user_id',
        'category_id',
        'title',
        'content',
        'excerpt',
        'slug',
        'cover_image',
        'status',
        'views',
        'published_at',
        'meta',
    ];
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'meta' => 'json',
            'status' => PostStatus::class,

        ];
    }

    //global scope to filter posts by the authenticated user, unless the user is an admin
    protected static function  booted()
    {

        static::addGlobalScope('owner', new OwnerScope);
    }

public function scopePublished(Builder $builder , $time = null){
    $time =$time ?? now();

$builder->withoutGlobalScope('owner') 
        ->where('status',PostStatus::Published)
        ->where(function ($query) use($time){
          $query->whereNull('published_at')
      ->orwhere('published_at', '<=',$time);
        });

}

public function scopeStatus(Builder $builder, PostStatus $status): void{

    $builder->where('status', $status);
}

public function scopeSlug(Builder $builder, string $slug): void{
    $builder->where('slug', $slug);

}


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, "post_id", "id");
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function content(): Attribute
    {
        return new Attribute(
            //  get: fn($value) => strip_tags($value, '<script><h1>'),
            set: fn($value) => strip_tags($value, '<h2><h3><h4><h5><h6><p><br><ul><ol><li><a><strong><em> ')
        );
    }


    public function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => strip_tags($value),
        );
    }


    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->cover_image
                    ? asset('storage/' . $this->cover_image)
                    : asset('images/default-thumbnail.jpg');
            }
        );
    }


    public function publishedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => new Carbon($value) ?: $this->created_at
        );
    }
}
