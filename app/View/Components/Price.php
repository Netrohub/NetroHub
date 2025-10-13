<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Price extends Component
{
    public $amount;
    public $size;
    public $showCurrency;

    /**
     * Create a new component instance.
     */
    public function __construct($amount, $size = 'md', $showCurrency = true)
    {
        $this->amount = $amount;
        $this->size = $size;
        $this->showCurrency = $showCurrency;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.price');
    }

    public function sizeClass()
    {
        return match($this->size) {
            'sm' => 'text-sm sm:text-base',
            'md' => 'text-lg sm:text-xl md:text-2xl',
            'lg' => 'text-2xl sm:text-3xl md:text-4xl',
            'xl' => 'text-3xl sm:text-4xl md:text-5xl',
            default => 'text-lg sm:text-xl md:text-2xl',
        };
    }
}

