<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $connection = 'mysql';
    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;


    public function category(): BelongsTo{
    return $this->belongsTo(Category::class ,"category_id","id")
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
        'views'
    ];

    public function user() :BelongsTo{
        return $this->belongsTo(User::class);
    }

 public function comments(): HasMany
 {
     return $this->hasMany(Comment::class ,"post_id","id");
 }

 public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
 {
     return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
 } 

 public function content():Attribute
 {
     return new Attribute(
        //  get: fn($value) => strip_tags($value, '<script><h1>'),
         set: fn($value) => strip_tags($value, '<h2><h3><h4><h5><h6><p><br><ul><ol><li><a><strong><em> ')
     );
 }

 
}
