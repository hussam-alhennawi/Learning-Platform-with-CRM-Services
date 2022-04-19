<?php

namespace App\Http\Controllers;

use App\Category;
use Image;
use Illuminate\Http\Request;

class CategoriesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='categories';
        $categories=Category::paginate(10);
        return view('backEnd.categories.index',compact('menu_active','categories'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='categories';
        $categories=Category::all();
        return view('backEnd.categories.create',compact('menu_active','categories'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'image' => 'required',
            'image.*' => 'mimes:jpg,jpeg,png'
        ]);
        $data=$request->all();
            
        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image=public_path('photos/categories/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $data['image']=$fileName;
                }
            }       
        }
        
        $category = Category::create($data);
        return redirect()->route('categories.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='categories';
        $category=Category::findOrFail($id);
        $categories=Category::all();
        return view('backEnd.categories.edit',compact('category','menu_active','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category=Category::findOrFail($id);
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],

                'image' => 'required_if:countOldMedia,0',
                'image.*' => 'mimes:jpg,jpeg,png'
        ]);
        
        $input_data=$request->all();
        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image=public_path('photos/categories/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $input_data['image']=$fileName;
                }
            }       
        }
        $category->update($input_data);
        return redirect()->route('categories.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        if($category->image != 'null')
        {
            $image=public_path('photos/categories/').$category->image;
            unlink($image);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('message','Delete Success!');
    }
    
    public function deleteImage($id)
    {
        $category=Category::findOrFail($id);
        $input_data['image'] = 'null';
        
        $image=public_path('photos/categories/').$category->image;
        if($category->update($input_data)){
            ////// delete image ///
            unlink($image);
        }
        
        return back();
    }
}
