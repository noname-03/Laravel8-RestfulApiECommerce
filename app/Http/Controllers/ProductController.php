<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $user = auth()->user();
        $categories = $user->categories()->get();
        $user['categories'] = $categories;
        $user->categories->map(function ($obj) {
            $obj['products'] = $obj->productCategories()->get();
            return $obj;
        });
        return response()->json([
            'code' => '200',
            'message' => 'Data berhasil ditampilkan',
            'data' => [
                'user' => $user
            ],
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $user->categories()->findOrFail($request->category_id)->productCategories()->create([
            'user_id' => $user->id,
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->qty,
            'description' => $request->description,
        ]);
        return response()->json([
            'code' => '200',
            'message' => 'Produk berhasil ditambahkan',
            'data' => $data,
        ]);
    }

// public function show($id)
// {
//     $category_id = 8;
//     $product_id = 2;
//     $product = auth()->user()->products()->findOrFail($product_id);
//     $category = $product->category()->get();
//     // $category[0]['product'] = $product;
//     // $category = auth()->user()->categories()->findOrFail($category_id);
//     // $product = $category->productCategories()->findOrFail($product_id);
//     // $category['product'] = $product;
//     return response()->json([
//         'code' => '200',
//         'message' => 'Produk ditampilkan',
//         'data' => $product,
//     ]);
// }

// public function update(CategoryStoreRequest $request, $id)
// {
//     $category = auth()->user()->categories()->findOrFail($id);
//     $category->update([
//         'name' => $request->name,
//     ]);
//     return response()->json([
//         'code' => '200',
//         'message' => 'Produk berhasil diubah',
//         'data' => $category,
//     ]);
// }

// public function destroy($id)
// {
//     $category = auth()->user()->categories()->findOrFail($id);
//     $category->delete();
//     return response()->json([
//         'code' => '200',
//         'message' => 'Produk berhasil dihapus',
//         'data' => $category,
//     ]);
// }

}