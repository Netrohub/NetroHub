<?php

namespace App\View\Composers;

use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementComposer
{
    public function compose(View $view): void
    {
        $announcements = collect();

        if (auth()->check()) {
            // Get active announcements for the logged-in user
            $announcements = Announcement::query()
                ->active()
                ->forUser(auth()->user())
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Get announcements for all users (including guests)
            $announcements = Announcement::query()
                ->active()
                ->where('target', 'all')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $view->with('activeAnnouncements', $announcements);
    }
}

