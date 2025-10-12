<?php

namespace App\View\Components;

use App\Models\User;
use App\Services\EntitlementsService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserBadge extends Component
{
    public ?string $badgeType = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user,
        public string $size = 'sm'
    ) {
        $entitlementsService = app(EntitlementsService::class);
        $this->badgeType = $entitlementsService->getBadgeType($user);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-badge');
    }
}
