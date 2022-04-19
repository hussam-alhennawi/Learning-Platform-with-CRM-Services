<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\_Class;
use App\Collage;
use Illuminate\Http\Request;

class AdvertisementsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='advertisements';
        $advertisements=Advertisement::paginate(10);
        return view('backEnd.advertisements.index',compact('menu_active','advertisements'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='advertisements';
        $classes = _Class::all();
        $collages = Collage::all();
        return view('backEnd.advertisements.create',compact('menu_active','classes','collages'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => ['required','string'],
            'description' => ['required','string'],
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
                    $image=public_path('photos/ads/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $data['image']=$fileName;
                }
            }       
        }
        $advertisement = Advertisement::create($data);
        $advertisement->classes()->sync($request->classes);
        $advertisement->collages()->sync($request->collages);
        return redirect()->route('advertisements.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='advertisements';
        $advertisement=Advertisement::findOrFail($id);
        $classes = _Class::all();
        $collages = Collage::all();
        return view('backEnd.advertisements.edit',compact('advertisement','menu_active','classes','collages'));
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
        $advertisement=Advertisement::findOrFail($id);
        $this->validate($request,[
            'title' => ['required','string'],
            'description' => ['required','string'],
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
                    $image=public_path('photos/ads/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $input_data['image']=$fileName;
                }
            }       
        }
        $advertisement->update($input_data);
        $advertisement->classes()->sync($request->classes);
        $advertisement->collages()->sync($request->collages);
        return redirect()->route('advertisements.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement=Advertisement::findOrFail($id);

        if($advertisement->image != null)
        {
            $image=public_path('photos/ads/').$advertisement->image;
            unlink($image);
        }
        $advertisement->delete();
        return redirect()->route('advertisements.index')->with('message','Delete Success!');
    }

    public function deleteImage($id)
    {
        $collage=Collage::findOrFail($id);
        $input_data['image'] = NULL;
        
        $image=public_path('photos/ads/').$collage->image;
        if($collage->update($input_data)){
            ////// delete image ///
            unlink($image);
        }
        
        return back();
    }
}
