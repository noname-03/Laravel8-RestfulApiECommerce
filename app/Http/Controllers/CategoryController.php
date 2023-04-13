<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryStoreRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $categories = auth()->user()->categories()->get();
        return response()->json([
            'code' => '200',
            'message' => 'Kategori berhasil ditampilkan',
            'data' => $categories,
        ]);
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = auth()->user()->categories()->create([
            'name' => $request->name,
        ]);
        return response()->json([
            'code' => '200',
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category,
        ]);
    }

    public function show($id)
    {
        $category = auth()->user()->categories()->findOrFail($id);
        return response()->json([
            'code' => '200',
            'message' => 'Kategori ditampilkan',
            'data' => $category,
        ]);
    }

    public function update(CategoryStoreRequest $request, $id)
    {
        $category = auth()->user()->categories()->findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'code' => '200',
            'message' => 'Kategori berhasil diubah',
            'data' => $category,
        ]);
    }

    public function destroy($id)
    {
        $category = auth()->user()->categories()->findOrFail($id);
        $category->delete();
        return response()->json([
            'code' => '200',
            'message' => 'Kategori berhasil dihapus',
            'data' => $category,
        ]);
    }

}