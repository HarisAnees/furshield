<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminContentController extends Controller
{
    public function index(Request $request)
    {
        $query = CareContent::query()->latest();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $contents = $query->paginate(12)->withQueryString();
        $categories = CareContent::distinct()->pluck('category')->filter();

        return view('admin.content.index', compact('contents', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        $validated['is_published'] = $request->has('is_published');

        CareContent::create($validated);

        return redirect()->route('admin.content.index')->with('success', 'Care article published successfully.');
    }

    public function update(Request $request, CareContent $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $content->update($validated);

        return redirect()->route('admin.content.index')->with('success', 'Article updated.');
    }

    public function togglePublish(CareContent $content)
    {
        $content->update(['is_published' => !$content->is_published]);

        return back()->with('success', "Article " . ($content->is_published ? 'published' : 'unpublished') . ".");
    }

    public function destroy(CareContent $content)
    {
        $content->delete();

        return redirect()->route('admin.content.index')->with('success', 'Article deleted.');
    }
}
