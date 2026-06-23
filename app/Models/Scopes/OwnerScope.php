<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class OwnerScope implements Scope
{

public function apply(Builder $builder, Model $model): void
{
    if (!Auth::check()) return;

    $user = Auth::user();

    if ($user->is_admin) return;

    // 👇 تجاهل الـ scope على الـ subqueries (withCount, with, إلخ)
    if ($builder->getQuery()->wheres) {
        foreach ($builder->getQuery()->wheres as $where) {
            if (isset($where['column']) && str_contains($where['column'], 'post_id')) {
                return; // هاد subquery داخلي، ما نطبق عليه scope
            }
        }
    }

    if (request()->routeIs('dashboard.*')) {
        $builder->where('posts.user_id', Auth::id());
    }
}
}
