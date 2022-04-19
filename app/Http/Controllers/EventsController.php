<?php

namespace App\Http\Controllers;
use Image;
use App\Event;
use Illuminate\Http\Request;

class EventsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='events';
        $events=Event::paginate(10);
        return view('backEnd.events.index',compact('menu_active','events'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='events';
        return view('backEnd.events.create',compact('menu_active'));
    }

    
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request,[
            'name' => ['required','string'],
            'description' => ['required','string'],
            'location' => ['required','string'],
            'started_at' => ['required','date_format:Y-m-d\TH:i','after_or_equal:'.date('Y-m-d H:i')],
            'ended_at' => ['required','date_format:Y-m-d\TH:i','after_or_equal:started_at'],

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
                    $image=public_path('photos/events/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $data['image']=$fileName;
                }
            }       
        }
        
        $event = Event::create($data);
        return redirect()->route('events.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='events';
        $event=Event::findOrFail($id);
        return view('backEnd.events.edit',compact('event','menu_active'));
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
        $event=Event::findOrFail($id);
        $this->validate($request,[
            'name' => ['required','string'],
            'description' => ['required','string'],
            'location' => ['required','string'],
            'started_at' => ['required','date_format:Y-m-d\TH:i','after_or_equal:'.date('Y-m-d\TH:i')],
            'ended_at' => ['required','date_format:Y-m-d\TH:i','after_or_equal:started_at'],

            'image' => 'required_if:countOldMedia,0',
            'image.*' => 'mimes:jpg,jpeg,png'
        ]);

        $input_data=$request->all();
        
        $file_name = str_replace(' ','-',$request->title).time();
        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image=public_path('photos/events/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $input_data['image']=$fileName;
                }
            }       
        }
        $event->update($input_data);
        return redirect()->route('events.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event=Event::findOrFail($id);
        if($event->image != 'null')
        {
            unlink(public_path('photos/events/').$event->image);
        }

        $event->delete();
        return redirect()->route('events.index')->with('message','Delete Success!');
    }

    public function deleteImage($id)
    {
        $event=Event::findOrFail($id);
        $input_data['image'] = 'null';
        
        $image=public_path('photos/events/').$event->image;
        if($event->update($input_data)){
            ////// delete image ///
            unlink($image);
        }
        
        return back();
    }

}
