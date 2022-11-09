<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use App\Models\User;
use Illuminate\View\View;

class CategoryComposer
{


    public function compose(View $view)
    {
        $category =Category::all();
        $view->with(['category' => $category ]);
    }
}
