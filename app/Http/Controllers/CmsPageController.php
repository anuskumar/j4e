<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use Illuminate\Http\Request;

class CmsPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
        $this->middleware('user.type:superadmin')->except(['show']);
    }

    public function index()
    {
        $data = CmsPage::orderBy('title')->get();

        return view('admin.cms_pages.list', compact('data'));
    }

    public function edit(string $id)
    {
        $data = CmsPage::findOrFail($id);

        return view('admin.cms_pages.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:cms_pages,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'is_active' => 'required|in:0,1',
        ]);

        $page = CmsPage::findOrFail($validated['id']);
        $page->title = $validated['title'];
        $page->content = $validated['content'] ?? '';
        $page->is_active = (int) $validated['is_active'];
        $page->save();

        return redirect()
            ->route('admin.cms-pages.index')
            ->with('success', $page->title . ' updated successfully.');
    }

    public function show(string $slug)
    {
        $page = CmsPage::findActiveBySlug($slug);

        if (! $page) {
            abort(404);
        }

        return view('cms_page', compact('page'));
    }

    public function terms()
    {
        return $this->show(CmsPage::SLUG_TERMS);
    }

    public function privacy()
    {
        return $this->show(CmsPage::SLUG_PRIVACY);
    }
}
