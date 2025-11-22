<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $categories = Category::when($search, function($query) use ($search) {
            return $query->where('nama', 'like', '%'.$search.'%');
        })->latest()->paginate(10);

        return view('category.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100|unique:categories,nama'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Category::create($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100|unique:categories,nama,'.$id
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}