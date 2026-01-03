<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        return view('product.index', [
            'products' => $products,
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::all();

        return view('product.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());

        $request->session()->flash('product.id', $product->id);

        return redirect()->route('products.index');
    }

    public function show(Request $request, Product $product)
    {
        return view('product.show', [
            'product' => $product,
        ]);
    }

   public function edit(Request $request, Product $product)
{
    $categories = Category::all(); // <-- dodaj ovo

    return view('product.edit', [
        'product' => $product,
        'categories' => $categories, // <-- prosledi view-u
    ]);
}


    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());

        $request->session()->flash('product.id', $product->id);

        return redirect()->route('products.index');
    }

    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return redirect()->route('products.index');
    }

    public function home()
{
    $products = Product::with('kategorija')->get(); 

    return view('publics.home', compact('products'));
}
}
