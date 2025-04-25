<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Data Products";
        // select * from product LEFT JOIN categories ON categories.id = products.category_id
        // ORM : Object Relation Mapp
        $datas = Products::with('category')->get();
        return view('product.index', compact('title', 'datas'));
    }

    // Menampilkan halaman baru untuk kasir
    public function getProduct()
    {
        $products = Products::where('is_active', 1)->get()->map(function ($product){
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => (int)$product->product_price,
                'image' => $product->product_photo,
                'option' => '',
            ];
        });
        return view('Assets_Kasir.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // select * from categories order by id desc
        $categories = Categories::orderBy('id', 'desc')->get();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_description' => $request->product_description,
            'is-active' => $request->is_active,
        ];
        // hasFile
        // !empty()
        // $_FILES, $request->file
        if ($request->hasFile('product_photo')) {
            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
        }

        Products::create($data);

        return redirect()->to('product');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit = Products::find($id);
        $categories = Categories::orderBy('id', 'asc')->get();
        return view('product.edit', compact('edit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_description' => $request->product_description,
            'is-active' => $request->is_active,
        ];

        $product = Products::find($id);
        if ($request->hasFile('product_photo')) {
            // Jika gambar sudah ada dan mau dirubah maka gambar lama kita hapus di ganti oleh gambar baru
            if ($product->product_photo) {
                file::delete(public_path('storage/' . $product->photo));
            }

            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
        }

        $product->update($data);
        return redirect()->to('categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);
        File::delete(public_path('storage/' . $product->product_photo));
        $product->delete();
        // $category = Categories::find($id);
        // $category->delete();
        return redirect()->to('product');
    }
}
