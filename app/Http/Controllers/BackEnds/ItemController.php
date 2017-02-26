<?php

namespace App\Http\Controllers\BackEnds;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
class ItemController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index(Request $request)
    {
    	$item = Item::orderBy('id','DESC')->paginate(5);
    	return view('BackEnds.items.index',compact('item'))->with('i',($request->input('page',1) - 1) * 5);
    }
    public function create()
    {
    	return view('BackEnds.items.create');
    }
    public function store(Request $request)
    {
    	$this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        Item::create($request->all());
        return redirect()->route('BackEnds.items.index')
                        ->with('success','Item created successfully');


    }
    public function show($id)
    {
    	$item = Item::find($id);
    	return view('BackEnds.items.show',compact('item'));
    }
    public function edit($id)
    {
    	$item = Item::find($id);
        return view('BackEnds.items.edit',compact('item'));
    }
    public function update(Request $request,$id)
    {
    	$this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
    	Item::find($id)->update($request->all());
    	return redirect()->route('BackEnds.items.index')
                        ->with('success','Item updated successfully');
    }
    public function destroy($id)
    {
        Item::find($id)->delete();
        return redirect()->route('BackEnds.items.index')
                        ->with('success','Item deleted successfully');
    }
}
