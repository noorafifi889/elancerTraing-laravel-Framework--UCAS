<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Http\Request;

class UserMenu extends Component
{
        public $user;
    /**
     * Create a new component instance.
     */
    public function __construct(Request $request)
    {

    $this->user = request()->user();
        // $this->user =Auth::guard('web')->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-menu');
    }
}
