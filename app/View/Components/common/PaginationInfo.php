<?php

namespace App\View\Components\common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class PaginationInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?LengthAwarePaginator $paginator, public ?string $class, public ?string $unit)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.pagination-info', [
            'paginator' => $this->paginator,
            'class' => $this->class,
            'unit' => $this->unit
        ]);
    }
}
