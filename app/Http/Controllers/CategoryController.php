<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
     $categories = Category::all();
     return view('category.index',compact('categories'));

    }
    public function create()
    {
     // dd("hgfds");
     return view('category.create');
    }
    public  function store ( Request   $request)
    {

     $request->validate([
         'question'=> 'required',
         'description'=> 'required',
        'reselt'=> 'required',
     ]);

     $temp=  new Category();
     $temp->question=$request->question;
     $temp->answer=$request->answer;
     $temp->reselt=$request->reselt;
    dd($isSaved = $temp->save()) ;
    $isSaved = $temp->save();

     return redirect()->route('category.index');
 }
    public function edit( $id)
    {
    $temp= Category::findOrFail($id);
    return view('category.edit',compact('temp'));

    }
 public  function update (Request   $request ,int $id)
 {
     $request->validate([
        'question'=> 'required',
        'answer'=> 'required',
         'reselt'=> 'required',
     ]);


     $category=Category::find($id);
     $category->question=$request->question;
     $category->answer=$request->answer;
     $category->reselt=$request->reselt;


     $category->save();

        return redirect( )->route('category.index')->with('status','Categort update');
 }
     public function destroy( int $id)
 {
   $category=Category::findOrFail($id);
   $category->delete();
   return redirect( )->route('category.index')->with('status','delete');
 }
 }
