<?php

namespace App\Http\Controllers\Admin;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
    // List all genres
    public function index(Request $request)
    {
        $query = Genre::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $genres = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.genres.index', compact('genres'));
    }

    // Show add form
    public function create()
    {
        return view('admin.genres.create');
    }

    // Store new genre
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres',
        ]);

        Genre::create($request->only('name'));

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre added successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genres.edit', compact('genre'));
    }

    // Update genre
    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $id,
        ]);

        $genre->update($request->only('name'));

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre updated successfully');
    }

    // Delete genre
    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);

        // Check if genre has movies
        if ($genre->movies()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete genre with assigned movies');
        }

        $genre->delete();

        return redirect()->route('admin.genres.index')
            ->with('success', 'Genre deleted successfully');
    }
}
