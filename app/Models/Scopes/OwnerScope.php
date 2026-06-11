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
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->is_admin) {
            return;
        }

        if (request()->routeIs('dashboard*')) {
            $builder->where('user_id', Auth::id());
        }
    }
}
}
