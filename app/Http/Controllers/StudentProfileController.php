<?php

namespace App\Http\Controllers;

use App\User;
use App\Course_Student;
use App\Course_Reg;
use App\Course;
use App\Lecture;
use App\_Class;
use App\Favourite_Lecture;
use App\Favourite_LibProject;
use App\Favourite_Reference;
use App\CheckIn;
use App\Student_Class;
use App\Complaint;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

use DB;
use Storage;
use Auth;

class StudentProfileController extends MainController
{
    
    public function activeCourses()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student','External_student']))
            {
                $active = Course_Reg::where('student_id',$user->id)->where('status','=','Active')->get(['course_id'])->toArray();
                $active_courses = Course_Student::where('student_id',$user->id)->whereIn('course_id',$active)->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.activeCourses',compact(['active_courses']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);
            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function otherCourses()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student','External_student']))
            {
                $other_courses = Course_Reg::where('student_id',$user->id)->where('status','!=','Active')->orderby('date','DESC')->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.otherCourses',compact(['other_courses']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);
            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function Classes()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student']))
            {
                $classes=_Class::whereHas('StudentsRegistredAtClass',
                    function(Builder $query) use($user){
                        $query->where('student_id',$user->id);
                    }
                )
                ->with('StudentsRegistredAtClass')->orderBy('subject_id','ASC')->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.Classes',compact(['user','classes']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);
            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function StudClassLectures($id)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student']))
            {
                $lectures=Lecture::where('class_id',$id)->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.StudClassLecs',compact(['user','lectures']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);

            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function FavLecs()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student']))
            {
                $favorite_lecs = Favourite_Lecture::where('student_id',$user->id)->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.FavLecs',compact(['user','favorite_lecs']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);

            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function FavRefs()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student']))
            {
                $favorite_refs = Favourite_Reference::where('student_id',$user->id)->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.FavRefs',compact(['user','favorite_refs']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);

            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function FavProjs()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student']))
            {
                $favorite_projs = Favourite_LibProject::where('student_id',$user->id)->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.FavProjs',compact(['user','favorite_projs']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);
            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page "; 
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function RemoveLecFromFavourite(Request $request)
    {
        $message = "";
        $user = Auth::user();
        $fav = Favourite_Lecture::where('lecture_id',$request->item)->where('student_id',$user->id)->first();
        if($fav)
        {
            if($fav->delete())
                return response()->json([
                    'success'=>'Remove From Favourite Done Successfully',
                    'data'=>"lec".$request->item
                    ]);
        }
        else
        {
            $message .= "This Lecture isn't in favourite list"; 
        }
        return $message;
    }

    public function AddLecToFavourite(Request $request)
    {
        $message = "";
        $user = Auth::user();
        $fav = Favourite_Lecture::create(['lecture_id'=>$request->item,'student_id'=>$user->id]);
        if($fav)
        {
            return response()->json([
                'success'=>'Add To Favourite Done Successfully',
                'data'=>"lec".$request->item
                ]);
        }
        else
        {
            $message .= "This Lecture isn't in favourite list"; 
        }
        return $message;
    }

    public function RemoveRefFromFavourite(Request $request)
    {
        $message = "";
        $user = Auth::user();
        $fav = Favourite_Reference::where('reference_id',$request->item)->where('student_id',$user->id)->first();
        if($fav)
        {
            if($fav->delete())
                return response()->json([
                    'success'=>'Remove From Favourite Done Successfully',
                    'data'=>"ref".$request->item
                    ]);
        }
        else
        {
            $message .= "This Reference isn't in favourite list"; 
        }
        return $message;
    }

    public function AddRefToFavourite(Request $request)
    {
        $message = "";
        $user = Auth::user();
        $isfav = Favourite_Reference::where('reference_id',$request->item)->where('student_id',$user->id)->first();
        // echo $isfav->id;
        if(!$isfav)
        {
            $fav = Favourite_Reference::create(['reference_id'=>$request->item,'student_id'=>$user->id]);
            if($fav)
            {
                return response()->json([
                    'success'=>'Add To Favourite Done Successfully',
                    'data'=>"ref".$request->item
                    ]);
            }
            else
            {
                $message .= "This Reference isn't in favourite list"; 
            }
        }
        else
        {
            $message .= "This Reference is already in favourite list"; 
        }
        return $message;
    }

    public function RemoveProjFromFavourite(Request $request)
    {
        $message = "";
        $user = Auth::user();
        $fav = Favourite_LibProject::where('lib_project_id',$request->item)->where('student_id',$user->id)->first();
        if($fav)
        {
            if($fav->delete())
                return response()->json([
                    'success'=>'Remove From Favourite Done Successfully',
                    'data'=>"proj".$request->item
                    ]);
        }
        else
        {
            $message .= "This Project isn't in favourite list"; 
        }
        return $message;
    }

    public function AddProjToFavourite(Request $request)
    {
        $message = "";
        $user = Auth::user();
        $isfav = Favourite_LibProject::where('lib_project_id',$request->item)->where('student_id',$user->id)->first();
        // echo $isfav->id;
        if(!$isfav)
        {
            $fav = Favourite_LibProject::create(['lib_project_id'=>$request->item,'student_id'=>$user->id]);
            if($fav)
            {
                return response()->json([
                    'success'=>'Add To Favourite Done Successfully',
                    'data'=>"ref".$request->item
                    ]);
            }
            else
            {
                $message .= "This Project isn't in favourite list"; 
            }
        }
        else
        {
            $message .= "This Project is already in favourite list"; 
        }
        return $message;
    }

    public function ScanQrCode()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student']))
            {
                $page = (string)view('FrontEnd.Private.scanner',compact(['user']));
                return response()->json([
                    'success'=>true,
                    'data'=> $page
                    ]);
            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return $message;
    }

    public function CheckInLecture(Request $request)
    {
        // dd($request);
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Internal_student']))
            {
                $lecture = Lecture::findOrFail($request->lec_id);
                $sc = Student_Class::where('student_id',$request->student_id)->where('class_id',$lecture->class_id)->first();
                if($sc)
                {
                    $CH = CheckIn::where('student_class_id',$sc->id)->where('lecture_id',$request->lec_id)->first();
                    if(!$CH)
                    {
                        $ch['student_class_id'] = $sc->id;
                        $ch['lecture_id'] = $request->lec_id;
                        CheckIn::create($ch);
                        $message .= "Checked Successfully In The Lecture(".$lecture->title.")";
                    }
                    else
                    {
                        $message .= "You are Checked In Already";
                    }
                }
                else
                {
                    $message .= "Sorry!! You are Not Registered At This Class";
                }
            }
            else
            {
                $message .= "Sorry!! You are Not Allowed To Access This Page";
            }
        }
        else
        {
            $message .= "Sorry!! Please Try Later"; 
        }
        return redirect()->back()->with('message',$message);
    }
    
    public function sendComplaint(Request $request)
    {
        $this->validate($request,[
            'message'=>['required','string']
        ]);
        $comp['complaint_text'] = $request->message;
        $comp['student_id'] = Auth::user()->id;
        Complaint::create($comp);
        return redirect()->back();
    }
}
