<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mysql';
    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;


    public function category() {
    return $table->belongsTo(Category::class);
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
}
