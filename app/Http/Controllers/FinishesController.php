<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use Illuminate\Http\Request;

class FinishesController extends Controller
{
    public function view()
    {
        return view("pages.finishes", ["finishes" => Finish::all()]);
    }

    public function create(Request $request)
    {
        $finish = new Finish($request->input());
        $finish->saveOrFail();
        return redirect()->route('finishes.index');
    }

    public function update(Request $request)
    {
        $finish = Finish::find($request->input('id'));
        $finish->name = $request->input('name');
        $finish->save();
        return redirect()->route('finishes.index');
    }
    
    public function delete(Request $request)
    {
        $finish = Finish::find($request->input('id'));
        $finish->delete();
        return redirect()->route('finishes.index');
    }
}
