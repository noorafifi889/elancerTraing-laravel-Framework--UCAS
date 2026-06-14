<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function posts():HasMany
    {
return $this->hasMany(Post::class ,"category_id","id");
    }


protected static function booted()
{
    static::restored(function (Category $category) {
        $category->posts()->update([
            'deleted_at' => null,
        ]);
    });

    static::deleted(function (Category $category){
$category->posts()->delete();
    });
}
}