<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::withTrashed()->ordered();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title_ru', 'like', "%{$s}%")
                  ->orWhere('title_kz', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $request->status === 'trash'
                ? $query = Service::onlyTrashed()->ordered()
                : $query->withoutTrashed()->where('status', $request->status);
        }

        $services = $query->paginate(15)->withQueryString();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);
        return redirect()->route('admin.services.index')->with('success', 'Услуга создана');
    }

    public function show(int $id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    public function edit(int $id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(StoreServiceRequest $request, int $id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);
        return redirect()->route('admin.services.index')->with('success', 'Услуга обновлена');
    }

    public function destroy(int $id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        if ($service->trashed()) {
            if ($service->image) Storage::disk('public')->delete($service->image);
            $service->forceDelete();
            return back()->with('success', 'Услуга удалена окончательно');
        }
        $service->delete();
        return back()->with('success', 'Услуга перемещена в корзину');
    }

    public function preview(int $id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        $locale = 'ru';
        return view('public.services.show', compact('service', 'locale'));
    }
}
