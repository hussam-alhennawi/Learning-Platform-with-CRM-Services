<?php

namespace App\Http\Controllers;

use Image;
use App\Collage;
use Illuminate\Http\Request;

class CollagesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='collages';
        $collages=Collage::paginate(10);
        return view('backEnd.collages.index',compact('menu_active','collages'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='collages';
        return view('backEnd.collages.create',compact('menu_active'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
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
                    $image=public_path('photos/collages/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $data['image']=$fileName;
                }
            }       
        }
        
        $collage = Collage::create($data);
        return redirect()->route('collages.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='collages';
        $collage=Collage::findOrFail($id);
        return view('backEnd.collages.edit',compact('collage','menu_active'));
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
        $collage=Collage::findOrFail($id);
        $this->validate($request,[
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],

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
                    $image=public_path('photos/collages/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $input_data['image']=$fileName;
                }
            }       
        }
        $collage->update($input_data);
        return redirect()->route('collages.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collage=Collage::findOrFail($id);
        if($collage->image != 'null')
        {
            $image=public_path('photos/collages/').$collage->image;
            unlink($image);
        }
        $collage->delete();
        return redirect()->route('collages.index')->with('message','Delete Success!');
    }
    
    public function deleteImage($id)
    {
        $collage=Collage::findOrFail($id);
        $input_data['image'] = 'null';
        
        $image=public_path('photos/collages/').$collage->image;
        if($collage->update($input_data)){
            ////// delete image ///
            unlink($image);
        }
        
        return back();
    }
}
