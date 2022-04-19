<?php

namespace App\Http\Controllers;

use App\Course;
use App\Course_Reg;
use App\Course_Student;
use App\Content;
use App\Topic;
use App\Category;
use App\User;
use Image;
use Illuminate\Http\Request;

use Auth;
class CoursesController extends AdminBaseController
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $courses = null;
        if($user->hasRole('Lecturer'))
        {
            $courses=Course::where('lecturer_id',$user->id)->paginate(10);
        }
        else
        {
            $courses=Course::paginate(10);
        }
        $menu_active='courses';
        return view('backEnd.courses.index',compact('menu_active','courses'));
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showall()
    {
        $course=Course::findOrFail($id);
        
        $rates = [
            0=>0,
            1=>0,
            2=>0,
            3=>0,
            4=>0,
            5=>0,
        ];
        foreach($course->AcceptedStudents as $r)
        {
            $rates[0] += 1;
            $rates[$r->rate] += 1;
        }
        $course->rates = $rates;
        $related_courses = Course::where('category_id',$course->category_id)->where('id','!=',$course->id)->orderBy('rate','desc')->limit(10)->get();
        return view('FrontEnd.Public.single-course',compact('course','related_courses'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='courses';
        $categories=Category::whereNotNull('parent_id')->get();
        $lecturers = User::whereRoleIs('Lecturer')->get();
        return view('backEnd.courses.create',compact('menu_active','categories','lecturers'));
    }

    
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request,[
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required'],
            'lecturer_id' => ['required_if:isAdministrator,1'],
            'skills' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'image' => ['required'],
            'image.*' => ['mimes:jpg,jpeg,png']
        ]);
        $data=$request->all();

        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image=public_path('photos/courses/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $data['image']=$fileName;
                }
            }       
        } 
        if($user->hasRole('Lecturer'))
        {
            $data['lecturer_id']=$user->id;
        }
        
        $data['rate'] = 0;
        $course = Course::create($data);
        return redirect()->route('courses.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='courses';
        $course=Course::findOrFail($id);
        $categories=Category::whereNotNull('parent_id')->get();
        $lecturers = User::whereRoleIs('Lecturer')->get();
        return view('backEnd.courses.edit',compact('course','menu_active','categories','lecturers'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu_active='courses';
        $courses[]=Course::findOrFail($id);
        return view('backEnd.courses.index',compact('courses','menu_active'));
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
        $course=Course::findOrFail($id);
        $this->validate($request,[
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required'],
            'lecturer_id' => ['required'],
            'skills' => ['required', 'string'],
            'duration' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'image' => ['required_if:countOldMedia,0'],
            'image.*' => ['mimes:jpg,jpeg,png']
        ]);
        
        $input_data=$request->all();
        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image=public_path('photos/courses/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $input_data['image']=$fileName;
                }
            }       
        }
        $course->update($input_data);
        return redirect()->route('courses.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course=Course::findOrFail($id);
        if($course->image != 'null')
        {
            $image=public_path('photos/courses/').$course->image;
            unlink($image);
        }
        $course->delete();
        return redirect()->route('courses.index')->with('message','Delete Success!');
    }
    
    public function deleteImage($id)
    {
        $course=Course::findOrFail($id);
        $input_data['image'] = 'null';
        
        $image=public_path('photos/courses/').$course->image;
        if($course->update($input_data)){
            ////// delete image ///
            unlink($image);
        }
        
        return back();
    }

    public function getCoursesByCat($cat_id)
    {
        $menu_active = 'courses'; 
        $courses=Course::where('category_id',$cat_id)->get();
        return view('backEnd.courses.index',compact('menu_active','courses'));
    }

    public function getCoursesByLec($lec_id)
    {
        $menu_active = 'courses'; 
        $courses=Course::where('lecturer_id',$lec_id)->get();
        return view('backEnd.courses.index',compact('menu_active','courses'));
    }

    public function getRequests()
    {
        $menu_active = 'courses'; 
        $requests=Course_Reg::where('status','Pending')->get();
        return view('backEnd.courses.request',compact('menu_active','requests'));
    }

    public function courseRequests($id)
    {
        $menu_active = 'courses'; 
        $requests=Course_Reg::where('course_id',$id)->get();
        return view('backEnd.courses.request',compact('menu_active','requests'));
    }

    public function acceptRequest($id)
    {
        $request=Course_Reg::findOrFail($id);
        $request->status = "Active";
        $request->active = 1;
        $request->save();
        $first_content_for_course = Content::where('topic_id',Topic::where('course_id',$request->course_id)->first()->id)->first()->id;
        
        $course_student = [
            "course_id"=>$request->course_id,
            "student_id"=>$request->student_id,
            "rate"=>0,
            "progress"=>$first_content_for_course,
        ];
        Course_Student::create($course_student);
        return redirect()->back();
    }

    public function BlockRequest($id)
    {
        $request=Course_Reg::findOrFail($id);
        $request->status = "Blocked";
        $request->save();
        return redirect()->back();
    }
}
