<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $members = TeamMember::withTrashed()->ordered()->paginate(20);
        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ru'      => 'required|string|max:255',
            'name_kz'      => 'nullable|string|max:255',
            'name_en'      => 'nullable|string|max:255',
            'position_ru'  => 'nullable|string|max:255',
            'position_kz'  => 'nullable|string|max:255',
            'position_en'  => 'nullable|string|max:255',
            'bio_ru'       => 'nullable|string',
            'bio_kz'       => 'nullable|string',
            'bio_en'       => 'nullable|string',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:50',
            'linkedin'     => 'nullable|url|max:255',
            'instagram'    => 'nullable|url|max:255',
            'facebook'     => 'nullable|url|max:255',
            'status'       => 'required|in:draft,published',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($data);
        return redirect()->route('admin.team.index')->with('success', 'Сотрудник добавлен');
    }

    public function edit(int $id)
    {
        $member = TeamMember::withTrashed()->findOrFail($id);
        return view('admin.team.edit', compact('member'));
    }

    public function update(Request $request, int $id)
    {
        $member = TeamMember::withTrashed()->findOrFail($id);

        $data = $request->validate([
            'name_ru'      => 'required|string|max:255',
            'name_kz'      => 'nullable|string|max:255',
            'name_en'      => 'nullable|string|max:255',
            'position_ru'  => 'nullable|string|max:255',
            'position_kz'  => 'nullable|string|max:255',
            'position_en'  => 'nullable|string|max:255',
            'bio_ru'       => 'nullable|string',
            'bio_kz'       => 'nullable|string',
            'bio_en'       => 'nullable|string',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:50',
            'linkedin'     => 'nullable|url|max:255',
            'instagram'    => 'nullable|url|max:255',
            'facebook'     => 'nullable|url|max:255',
            'status'       => 'required|in:draft,published',
            'sort_order'   => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $member->update($data);
        return redirect()->route('admin.team.index')->with('success', 'Сотрудник обновлён');
    }

    public function destroy(int $id)
    {
        $member = TeamMember::withTrashed()->findOrFail($id);
        if ($member->trashed()) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $member->forceDelete();
            return back()->with('success', 'Удалено окончательно');
        }
        $member->delete();
        return back()->with('success', 'Перемещено в корзину');
    }
}
