<?php

namespace App\Http\Controllers\Admin;

use App\Models\Actor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActorController extends Controller
{
    // List all actors
    public function index(Request $request)
    {
        $query = Actor::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $actors = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.actors.index', compact('actors'));
    }

    // Show add form
    public function create()
    {
        return view('admin.actors.create');
    }

    // Store new actor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Actor::create($request->only('name'));

        return redirect()->route('admin.actors.index')
            ->with('success', 'Actor added successfully');
    }

    // Show edit form
    public function edit($id)
    {
        $actor = Actor::findOrFail($id);
        return view('admin.actors.edit', compact('actor'));
    }

    // Update actor
    public function update(Request $request, $id)
    {
        $actor = Actor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $actor->update($request->only('name'));

        return redirect()->route('admin.actors.index')
            ->with('success', 'Actor updated successfully');
    }

    // Delete actor
    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);

        // Check if actor has movies
        if ($actor->movies()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete actor with assigned movies');
        }

        $actor->delete();

        return redirect()->route('admin.actors.index')
            ->with('success', 'Actor deleted successfully');
    }
}
