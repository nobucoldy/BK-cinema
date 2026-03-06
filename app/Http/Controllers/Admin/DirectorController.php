<?php

namespace App\Http\Controllers\Admin;

use App\Models\Director;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DirectorController extends Controller
{
    // List all directors
    public function index(Request $request)
    {
        $query = Director::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $directors = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.directors.index', compact('directors'));
    }

    // Show add form
    public function create()
    {
        return view('admin.directors.create');
    }

    // Store new director
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Director::create($request->only('name'));

        return redirect()->route('admin.directors.index')
            ->with('success', 'Director added successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $director = Director::findOrFail($id);
        return view('admin.directors.edit', compact('director'));
    }

    // Update director
    public function update(Request $request, $id)
    {
        $director = Director::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $director->update($request->only('name'));

        return redirect()->route('admin.directors.index')
            ->with('success', 'Director updated successfully');
    }

    // Delete director
    public function destroy($id)
    {
        $director = Director::findOrFail($id);

        // Check if director has movies
        if ($director->movies()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete director with assigned movies');
        }

        $director->delete();

        return redirect()->route('admin.directors.index')
            ->with('success', 'Director deleted successfully');
    }
}
