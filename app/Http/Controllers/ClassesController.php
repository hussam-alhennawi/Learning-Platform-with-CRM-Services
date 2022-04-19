<?php

namespace App\Http\Controllers;

use App\_Class;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ClassesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='classes';
        $classes=_Class::orderBy('subject_id','ASC')->paginate(10);
        return view('backEnd.classes.index',compact('menu_active','classes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='classes';
        $subjects = Subject::all();
        $lecturers = User::whereRoleIs('Lecturer')->get();
        return view('backEnd.classes.create',compact('subjects','menu_active','lecturers'));
    }

    
    public function store(Request $request)
    {
        // dd($request);
        $type = ['practical', 'theoretical'];
        $this->validate($request,[
            'type' => ['required','in_array:type'],
            'semester_number' => ['required','numeric','min:1','max:3'],
            'study_year' => ['required'],
            'subject_id' => ['required'],
            'lecturer_id' => ['required'],
        ]);
        $data=$request->all();
        $class = _Class::create($data);
        return redirect()->route('classes.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='classes';
        $subjects = Subject::all();
        $lecturers = User::whereRoleIs('Lecturer')->get();
        $class=_Class::findOrFail($id);
        return view('backEnd.classes.edit',compact('class','menu_active','subjects','lecturers'));
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
        $class=_Class::findOrFail($id);
        $type = ['practical','theoretical'];
        $this->validate($request,[
            'type' => ['required','in_array:type'],
            'semester_number' => ['required','numeric','min:1','max:3'],
            'study_year' => ['required'],
            'subject_id' => ['required'],
            'lecturer_id' => ['required'],
        ]);
        
        $input_data=$request->all();
        $class->update($input_data);
        return redirect()->route('classes.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class=_Class::findOrFail($id);
        $class->delete();
        return redirect()->route('classes.index')->with('message','Delete Success!');
    }
        
    public function getClassesBySub($sub_id,$year)
    {
        $menu_active = 'classes'; 
        $classes=_Class::where('subject_id',$sub_id)->where('study_year',$year)->orderBy('subject_id','ASC')->get();
        return view('backEnd.classes.index',compact('menu_active','classes'));
    } 
        
    public function getClassesByLecturer($lecturer_id)
    {
        $menu_active = 'classes'; 
        $classes=_Class::where('lecturer_id',$lecturer_id)->orderBy('subject_id','ASC')->get();
        return view('backEnd.classes.index',compact('menu_active','classes'));
    } 
        
    public function getClassesForRegStudent($student_id)
    {
        $menu_active = 'classes'; 
        $student = User::findOrFail($student_id); 
        $classes=_Class::whereHas('StudentsRegistredAtClass',
            function(Builder $query) use($student_id){
                $query->where('student_id',$student_id);
            }
        )
        ->with('StudentsRegistredAtClass')->orderBy('subject_id','ASC')->get();
        
        return view('backEnd.classes.index',compact('menu_active','classes','student'));
    } 

}
