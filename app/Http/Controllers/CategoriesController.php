<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function view()
    {
        return view("pages.categories", ["categories" => Category::all()]);
    }

    public function create(Request $request)
    {
        $category = new Category();
        
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->size_on_screen = $request->input('size_on_screen');

        if ($request->input('parent_id') != 'none') {
            $category->parent_id = $request->input('parent_id');
        }

        if ($request->file('image')) {
            $imagePath = $request->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $path = $imagePath->storeAs('uploads', $imageName, 'public');
            $category->image_path = '/storage/'.$path;
        } else {
            $category->image_path = 'no-image.png';
        }
        
        $category->save();
        return redirect()->route('categories.index');
    }

    public function update(Request $request)
    {
        $category = Category::find($request->input('id'));
        
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->size_on_screen = $request->input('size_on_screen');
        $category->parent_id = $request->input('parent_id') == 'none' ? null : $request->input('parent_id');

        if ($request->file('image')) {
            $imagePath = $request->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $path = $imagePath->storeAs('uploads', $imageName, 'public');
            $category->image_path = '/storage/'.$path;
        }
        
        $category->save();
        return redirect()->route('categories.index');
    }
    
    public function delete(Request $request)
    {
        $category = Category::find($request->input('id'));
        $category->delete();
        return redirect()->route('categories.index');
    }
}
