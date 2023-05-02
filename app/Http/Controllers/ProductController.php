<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        // $user = auth()->user();
        // $categories = $user->categories()->get();
        // $user['categories'] = $categories;
        // $user->categories->map(function ($obj) {
        //     $obj['products'] = $obj->productCategories()->get();
        //     return $obj;
        // });
        $data = auth()->user()->products()->get();
        return response()->json([
            'code' => '200',
            'message' => 'Data berhasil ditampilkan',
            'data' => [
                'product' => $data
            ],
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $fileName = '';
        if ($request->hasFile('photo')) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images/product/'), $fileName);
        }
        $data = $user->categories()->findOrFail($request->category_id)->productCategories()->create([
            'user_id' => $user->id,
            'name' => $request->name,
            'price' => $request->price,
            'price_retail' => $request->price_retail,
            'qty' => $request->qty,
            'description' => $request->description,
            'photo' => $fileName,
        ]);
        return response()->json([
            'code' => '200',
            'message' => 'Produk berhasil ditambahkan',
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        // $category_id = 8;
        // $product_id = 2;
        $product = auth()->user()->products()->findOrFail($id);
        $product['photo'] = asset('images/product/' . $product->photo);
        // $category = $product->category()->get();
        // $category[0]['product'] = $product;
        // $category = auth()->user()->categories()->findOrFail($category_id);
        // $product = $category->productCategories()->findOrFail($product_id);
        // $category['product'] = $product;
        return response()->json([
            'code' => '200',
            'message' => 'Produk ditampilkan',
            'data' => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = auth()->user()->categories()->findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'code' => '200',
            'message' => 'Produk berhasil diubah',
            'data' => $category,
        ]);
    }

    public function destroy($id)
    {
        $data = auth()->user()->products()->findOrFail($id);
        File::delete(public_path('images/product/' . $data->photo));
        $data->delete();
        return response()->json([
            'code' => '200',
            'message' => 'Produk berhasil dihapus',
            'data' => $data,
        ]);
    }
}