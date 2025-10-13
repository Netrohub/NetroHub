<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubscriptionBadge extends Component
{
    public $user;
    public $size;

    /**
     * Create a new component instance.
     */
    public function __construct($user, $size = 'sm')
    {
        $this->user = $user;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.subscription-badge');
    }

    public function badgeType()
    {
        return $this->user->getBadgeType();
    }

    public function sizeClass()
    {
        return match($this->size) {
            'xs' => 'text-[10px] px-1.5 py-0.5',
            'sm' => 'text-xs px-2 py-0.5',
            'md' => 'text-sm px-2.5 py-1',
            'lg' => 'text-base px-3 py-1.5',
            default => 'text-xs px-2 py-0.5',
        };
    }

    public function iconSize()
    {
        return match($this->size) {
            'xs' => 'w-2.5 h-2.5',
            'sm' => 'w-3 h-3',
            'md' => 'w-4 h-4',
            'lg' => 'w-5 h-5',
            default => 'w-3 h-3',
        };
    }
}

