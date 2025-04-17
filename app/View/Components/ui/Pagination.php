<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?LengthAwarePaginator $paginator)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.pagination', [
            'paginator' => $this->paginator
        ]);
    }
}
