<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $general = [
            'site_name' => SiteSetting::get('site_name', config('app.name', 'NetroHub')),
            'company_name' => SiteSetting::get('company_name', 'NetroHub'),
        ];

        $seo = [
            'seo_title' => SiteSetting::get('seo_title', config('app.name', 'NetroHub')),
            'seo_description' => SiteSetting::get('seo_description', ''),
            'seo_keywords' => SiteSetting::get('seo_keywords', ''),
        ];

        $social = [
            'twitter_handle' => SiteSetting::get('twitter_handle', ''),
            'facebook_url' => SiteSetting::get('facebook_url', ''),
            'instagram_url' => SiteSetting::get('instagram_url', ''),
            'discord_url' => SiteSetting::get('discord_url', ''),
        ];

        return view('admin.settings.index', compact('general', 'seo', 'social'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            // General
            'site_name' => ['required', 'string', 'max:100'],
            'company_name' => ['nullable', 'string', 'max:120'],
            // SEO
            'seo_title' => ['nullable', 'string', 'max:150'],
            'seo_description' => ['nullable', 'string', 'max:300'],
            'seo_keywords' => ['nullable', 'string', 'max:300'],
            // Social
            'twitter_handle' => ['nullable', 'string', 'max:50'],
            'facebook_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'discord_url' => ['nullable', 'url'],
        ]);

        // Persist settings
        SiteSetting::set('site_name', $data['site_name'] ?? null, 'general');
        SiteSetting::set('company_name', $data['company_name'] ?? null, 'general');

        SiteSetting::set('seo_title', $data['seo_title'] ?? null, 'seo');
        SiteSetting::set('seo_description', $data['seo_description'] ?? null, 'seo');
        SiteSetting::set('seo_keywords', $data['seo_keywords'] ?? null, 'seo');

        SiteSetting::set('twitter_handle', $data['twitter_handle'] ?? null, 'social');
        SiteSetting::set('facebook_url', $data['facebook_url'] ?? null, 'social');
        SiteSetting::set('instagram_url', $data['instagram_url'] ?? null, 'social');
        SiteSetting::set('discord_url', $data['discord_url'] ?? null, 'social');

        return redirect()->route('admin.settings.index')->with('success', __('Settings saved successfully.'));
    }
}


