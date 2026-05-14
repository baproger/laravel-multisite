<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::withTrashed()->ordered()->paginate(20);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ru'        => 'required|string|max:255',
            'name_kz'        => 'nullable|string|max:255',
            'name_en'        => 'nullable|string|max:255',
            'description_ru' => 'nullable|string|max:500',
            'description_kz' => 'nullable|string|max:500',
            'description_en' => 'nullable|string|max:500',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website'        => 'nullable|url|max:255',
            'type'           => 'required|in:partner,client',
            'status'         => 'required|in:draft,published',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($data);
        return redirect()->route('admin.partners.index')->with('success', 'Партнёр добавлен');
    }

    public function edit(int $id)
    {
        $partner = Partner::withTrashed()->findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, int $id)
    {
        $partner = Partner::withTrashed()->findOrFail($id);

        $data = $request->validate([
            'name_ru'        => 'required|string|max:255',
            'name_kz'        => 'nullable|string|max:255',
            'name_en'        => 'nullable|string|max:255',
            'description_ru' => 'nullable|string|max:500',
            'description_kz' => 'nullable|string|max:500',
            'description_en' => 'nullable|string|max:500',
            'logo'           => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'website'        => 'nullable|url|max:255',
            'type'           => 'required|in:partner,client',
            'status'         => 'required|in:draft,published',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo) Storage::disk('public')->delete($partner->logo);
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);
        return redirect()->route('admin.partners.index')->with('success', 'Партнёр обновлён');
    }

    public function destroy(int $id)
    {
        $partner = Partner::withTrashed()->findOrFail($id);
        if ($partner->trashed()) {
            if ($partner->logo) Storage::disk('public')->delete($partner->logo);
            $partner->forceDelete();
            return back()->with('success', 'Удалено окончательно');
        }
        $partner->delete();
        return back()->with('success', 'Перемещено в корзину');
    }
}
