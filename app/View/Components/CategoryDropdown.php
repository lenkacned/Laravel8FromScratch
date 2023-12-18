<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;
use App\Models\Category;

class CategoryDropdown extends Component
{
    public function render()
    {

        return view('components.category-dropdown',[
            'categories' => Category::all(),
            'currentCategory' => Category::firstWhere('slug', request('category'))
        ]);
    }
}
