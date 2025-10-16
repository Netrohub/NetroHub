<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $filter = $request->query('filter', 'all');
        $search = $request->query('search', '');
        // Align sort options with UI (latest, name, sales)
        $sort = $request->query('sort', 'latest');

        // Build query for all active users
        $membersQuery = User::with(['seller' => function ($q) {
            $q->withCount('products');
        }])->where('is_active', true);

        // Apply filters
        switch ($filter) {
            case 'sellers':
                $membersQuery->whereHas('seller');
                break;
            case 'buyers':
                $membersQuery->whereDoesntHave('seller');
                break;
            case 'verified':
                $membersQuery->whereNotNull('email_verified_at');
                break;
            default:
                // 'all' - no additional filter
                break;
        }

        // Apply search
        if (! empty($search)) {
            $membersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('seller', function ($sq) use ($search) {
                        $sq->where('display_name', 'like', "%{$search}%");
                    });
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'sales':
                $membersQuery->leftJoin('sellers', 'users.id', '=', 'sellers.user_id')
                    ->orderByRaw('COALESCE(sellers.total_sales, 0) DESC')
                    ->select('users.*');
                break;
            case 'name':
                $membersQuery->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                $membersQuery->latest();
                break;
        }

        // Get total counts for stats
        $totalMembers = User::where('is_active', true)->count();
        $totalSellers = User::where('is_active', true)->whereHas('seller')->count();
        $totalBuyers = $totalMembers - $totalSellers;
        $totalVerified = User::where('is_active', true)->whereNotNull('email_verified_at')->count();

        // Paginate results
        $members = $membersQuery->paginate(24)->appends([
            'filter' => $filter,
            'search' => $search,
            'sort' => $sort,
        ]);

        // Match view expectations: it reads $users
        $users = $members;

        return view('members.index', compact(
            'users',
            'filter',
            'search',
            'sort',
            'totalMembers',
            'totalSellers',
            'totalBuyers',
            'totalVerified'
        ));
    }

    public function show(User $user)
    {
        // Load user with seller relationship and products
        $user->load(['seller.products' => function ($query) {
            $query->where('status', 'published')->latest();
        }]);

        return view('members.show', compact('user'));
    }
}
