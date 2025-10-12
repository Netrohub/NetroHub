<?php

namespace App\Http\Controllers;

use App\Models\AdminAudit;
use App\Models\User;
use Illuminate\Http\Request;

class ImpersonationController extends Controller
{
    public function impersonate(Request $request, User $user)
    {
        if (! auth()->user()->can('impersonate_users')) {
            abort(403, 'You do not have permission to impersonate users.');
        }

        // Store the original admin ID
        $request->session()->put('impersonator_id', auth()->id());

        // Log the impersonation
        AdminAudit::log(
            admin: auth()->user(),
            action: 'impersonate_start',
            auditable: $user,
            newValues: ['impersonated_user_id' => $user->id]
        );

        // Login as the target user
        auth()->login($user);

        return redirect('/')->with('impersonating', true);
    }

    public function stopImpersonating(Request $request)
    {
        $impersonatorId = $request->session()->get('impersonator_id');

        if (! $impersonatorId) {
            return redirect('/');
        }

        $impersonatedUserId = auth()->id();

        // Find the original admin
        $admin = User::find($impersonatorId);

        if ($admin) {
            // Log stop impersonation
            AdminAudit::log(
                admin: $admin,
                action: 'impersonate_stop',
                auditable: auth()->user(),
                oldValues: ['impersonated_user_id' => $impersonatedUserId]
            );

            // Login back as admin
            auth()->login($admin);
        }

        // Remove impersonation session data
        $request->session()->forget('impersonator_id');

        return redirect('/admin')->with('message', 'Stopped impersonating user.');
    }
}
