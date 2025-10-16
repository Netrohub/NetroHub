<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::orderBy('slug')->get();
        return view('admin.cms.index', compact('pages'));
    }

    public function edit(CmsPage $page)
    {
        return view('admin.cms.edit', compact('page'));
    }

    public function update(Request $request, CmsPage $page)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:150'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $page->fill($data);
        $page->version = ($page->version ?? 0) + 1;
        $page->updated_by = auth()->id();
        $page->save();

        return redirect()->route('admin.cms.index')->with('success', __('Page updated.'));
    }
}


