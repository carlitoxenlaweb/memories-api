<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductFinish;
use App\Models\ProductImage;
use App\Models\Promotion;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function view()
    {
        return view("pages.products", [
            "products" => Product::with(['category', 'prices', 'finishes'])->get(),
            "categories" => Category::all(),
            "finishes" => Finish::all()
        ]);
    }

    public function create(Request $request)
    {
        $product = new Product();

        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->specs = $request->input('specs') ?? '';
        $product->size = $request->input('size');
        $product->paper = $request->input('paper');
        $product->category_id = $request->input('category');
        $product->quantity = $request->has('quantity');
        
        $product->save();

        if($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $image = new ProductImage();

                $imageName = $this->hashFile($file->getClientOriginalName());
                $path = $file->storeAs('uploads', $imageName, 'public');
                
                $image->product_id = $product->id;
                $image->image_name = $imageName;
                $image->image_path = '/storage/'.$path;
                $image->save();
            }
        }

        $prices = $request->input('prices');
        foreach ($prices as $price) {
            $pricex = new ProductPrice();
            $pricex->price = $price['price'];
            $pricex->product_id = $product->id;
            $pricex->min = $price['min'];
            $pricex->max = $price['max'];
            $pricex->priority = $price['priority'];
            $pricex->save();
        }

        $finishes = $request->input('finishes');
        if (!is_null($finishes)) {
            foreach ($finishes as $finish) {
                $finishx = new ProductFinish();
                $finishx->finish_id = $finish;
                $finishx->product_id = $product->id;
                $finishx->save();
            }
        }

        return redirect()->route('products.index');
    }

    public function update(Request $request)
    {
        $product = Product::find($request->input('id'));

        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->specs = $request->input('specs') ?? '';
        $product->size = $request->input('size');
        $product->paper = $request->input('paper');
        $product->category_id = $request->input('category');
        $product->quantity = $request->has('quantity');
        
        $product->save();

        if($request->hasFile('images')) {
            ProductImage::where('product_id', $product->id)->delete();

            $files = $request->file('images');
            foreach ($files as $file) {
                $image = new ProductImage();
                
                $imageName = $this->hashFile($file->getClientOriginalName());
                $path = $file->storeAs('uploads', $imageName, 'public');

                $image->product_id = $product->id;
                $image->image_name = $imageName;
                $image->image_path = '/storage/'.$path;
                $image->save();
            }
        }

        $prices = $request->input('prices');
        ProductPrice::where('product_id', $product->id)->delete();

        foreach ($prices as $price) {
            $pricex = new ProductPrice();
            $pricex->price = $price['price'];
            $pricex->product_id = $product->id;
            $pricex->min = $price['min'];
            $pricex->max = $price['max'];
            $pricex->priority = $price['priority'];
            $pricex->save();
        }

        ProductFinish::where('product_id', $product->id)->delete();

        $finishes = $request->input('finishes');
        if (!is_null($finishes)) {
            foreach ($finishes as $finish) {
                $finishx = new ProductFinish();
                $finishx->finish_id = $finish;
                $finishx->product_id = $product->id;
                $finishx->save();
            }
        }

        return redirect()->route('products.index');
    }
    
    public function delete(Request $request)
    {
        $product = Product::find($request->input('id'));
        $product->delete();
        return redirect()->route('products.index');
    }
    
    public function create_promo(Request $request)
    {
        $product = Product::find($request->input('id'));
        $promotion = new Promotion();

        $promotion->product_id = $product->id;
        $promotion->price = $request->input('price');

        $promotion->save();

        $product->promotion_id = $promotion->id;
        $product->save();

        return redirect()->route('products.index');
    }
    
    public function delete_promo(Request $request)
    {
        $product = Product::find($request->input('id'));
        Promotion::find($product->promotion_id)->delete();
        
        $product->promotion_id = null;
        $product->save();

        return redirect()->route('products.index');
    }
}
