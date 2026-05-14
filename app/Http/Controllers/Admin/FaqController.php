<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::withTrashed()->ordered()->paginate(20);
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_ru' => 'required|string|max:500',
            'question_kz' => 'nullable|string|max:500',
            'question_en' => 'nullable|string|max:500',
            'answer_ru'   => 'required|string',
            'answer_kz'   => 'nullable|string',
            'answer_en'   => 'nullable|string',
            'category_ru' => 'nullable|string|max:100',
            'category_kz' => 'nullable|string|max:100',
            'category_en' => 'nullable|string|max:100',
            'status'      => 'required|in:draft,published',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        Faq::create($data);
        return redirect()->route('admin.faq.index')->with('success', 'Вопрос добавлен');
    }

    public function edit(int $id)
    {
        $faq = Faq::withTrashed()->findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, int $id)
    {
        $faq = Faq::withTrashed()->findOrFail($id);

        $data = $request->validate([
            'question_ru' => 'required|string|max:500',
            'question_kz' => 'nullable|string|max:500',
            'question_en' => 'nullable|string|max:500',
            'answer_ru'   => 'required|string',
            'answer_kz'   => 'nullable|string',
            'answer_en'   => 'nullable|string',
            'category_ru' => 'nullable|string|max:100',
            'category_kz' => 'nullable|string|max:100',
            'category_en' => 'nullable|string|max:100',
            'status'      => 'required|in:draft,published',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $faq->update($data);
        return redirect()->route('admin.faq.index')->with('success', 'Вопрос обновлён');
    }

    public function destroy(int $id)
    {
        $faq = Faq::withTrashed()->findOrFail($id);
        if ($faq->trashed()) {
            $faq->forceDelete();
            return back()->with('success', 'Удалено окончательно');
        }
        $faq->delete();
        return back()->with('success', 'Перемещено в корзину');
    }
}
