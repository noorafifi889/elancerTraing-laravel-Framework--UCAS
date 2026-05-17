<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecommendedAuthors extends Component
{
    // تعريف المتغيرات التي ستمر إلى الـ View تلقائياً
    public array $authors = [];
    public string $title;

    public array $data = [
        [
            'id' => 1,
            'name' => 'John Doe',
            'username' => 'johndoe',
            'avatar' => 'https://randomuser.me/api/portraits/men/1.jpg' // تم إغلاق النص هنا
        ],
        [
            'id' => 2,
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'avatar' => 'https://randomuser.me/api/portraits/women/2.jpg',
        ],
        [
            'id' => 3,
            'name' => 'Alice Johnson',
            'username' => 'alicej', // تم إكمال وإغلاق العنصر الثالث هنا
            'avatar' => 'https://randomuser.me/api/portraits/women/3.jpg',
        ]
    ]; // تم إغلاق المصفوفة الكبيرة بشكل صحيح

    /**
     * Create a new component instance.
     */
    public function __construct($title = "Recommended Authors" , $authors = [] , $count = 3)
    {
        $this->title = $title;
        $this->authors = $this->data; // تعيين البيانات إلى المتغير الذي سيتم استخدامه في الـ View

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recommended-authors');
    }
}