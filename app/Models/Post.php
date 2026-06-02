<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

 
}
