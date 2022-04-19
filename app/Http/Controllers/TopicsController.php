<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Course;
use Illuminate\Http\Request;
use Auth;

class TopicsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $menu_active='topics';
        $topics = null;
        if($user->hasRole('Lecturer'))
        {
            $topics=Topic::whereHas('course',function($query) use($user) {
                $query->where('lecturer_id',$user->id);
            })->paginate(10);
        }
        else
        {
            $topics=Topic::paginate(10);
        }
        return view('backEnd.topics.index',compact('menu_active','topics'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $menu_active='topics';
        $courses = null;
        if($user->hasRole('Lecturer'))
        {
            $courses=Course::where('lecturer_id',$user->id)->get();
        }
        else
        {
            $courses=Course::all();
        }
        return view('backEnd.topics.create',compact('menu_active','courses'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'course_id' => ['required'],
        ]);
        $data=$request->all();
        $topic = Topic::create($data);
        return redirect()->route('topics.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $menu_active='topics';
        $topic=Topic::findOrFail($id);
        $courses = null;
        if($user->hasRole('Lecturer'))
        {
            $courses=Course::where('lecturer_id',$user->id)->get();
        }
        else
        {
            $courses=Course::all();
        }
        return view('backEnd.topics.edit',compact('topic','menu_active','courses'));
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
        $topic=Topic::findOrFail($id);
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'course_id' => ['required'],
        ]);
        
        $input_data=$request->all();
        $topic->update($input_data);
        return redirect()->route('topics.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic=Topic::findOrFail($id);
        $topic->delete();
        return redirect()->route('topics.index')->with('message','Delete Success!');
    }

    public function getTopicsByCourse($cou_id)
    {
        $menu_active = 'topics'; 
        $topics=Topic::where('course_id',$cou_id)->get();
        return view('backEnd.topics.index',compact('menu_active','topics'));
    }
    
}
