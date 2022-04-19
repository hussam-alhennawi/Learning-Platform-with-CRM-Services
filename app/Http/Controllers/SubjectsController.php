<?php

namespace App\Http\Controllers;

use Image;
use App\Subject;
use App\Collage;
use Illuminate\Http\Request;

class SubjectsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='subjects';
        $subjects=Subject::paginate(10);
        return view('backEnd.subjects.index',compact('menu_active','subjects'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='subjects';
        $collages = Collage::all();
        return view('backEnd.subjects.create',compact('collages','menu_active'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'collage_id' => ['required'],
        ]);
        $data=$request->all();
        // $collage = Collage::findOrFail($data->collage_id);
        $subject = Subject::create($data);
        return redirect()->route('subjects.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='subjects';
        $collages = Collage::all();
        $subject=Subject::findOrFail($id);
        return view('backEnd.subjects.edit',compact('subject','menu_active','collages'));
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
        $subject=Subject::findOrFail($id);
        $this->validate($request,[
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'collage_id' => ['required'],
        ]);
        
        $input_data=$request->all();
        $subject->update($input_data);
        return redirect()->route('subjects.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject=Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('subjects.index')->with('message','Delete Success!');
    }
    
    public function getSubjectsByCol($id)
    {
        $menu_active = 'subjects'; 
        $subjects=Subject::where('collage_id',$id)->get();
        return view('backEnd.subjects.index',compact('menu_active','subjects'));
    } 

}
