<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = InternshipCategory::withCount('internships')->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:internship_categories'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        InternshipCategory::create($data + ['is_active' => true]);

        return back()->with('status', 'Category created.');
    }

    public function update(InternshipCategory $category, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100',
                              'unique:internship_categories,name,' . $category->id],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $category->update($data);

        return back()->with('status', 'Category updated.');
    }

    public function toggle(InternshipCategory $category): RedirectResponse
    {
        $category->update(['is_active' => ! $category->is_active]);
        $state = $category->is_active ? 'activated' : 'deactivated';

        return back()->with('status', "Category '{$category->name}' {$state}.");
    }
}
