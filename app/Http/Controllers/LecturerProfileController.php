<?php

namespace App\Http\Controllers;

use App\User;
use App\Course_Student;
use App\Course_Reg;
use App\Category;
use App\Course;
use App\Content;
use App\Topic;
use App\Lecture;
use App\_Class;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

use DB;
use Image;
use DNS2D;
use Storage;
use Auth;
use Hash;

class LecturerProfileController extends MainController
{
    public function LecCourses()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $courses=Course::where('lecturer_id',$user->id)->paginate(10);
                $categories=Category::whereNotNull('parent_id')->get();
                foreach ($courses as $c) {
                    $rates = [
                        1=>0,
                        2=>0,
                        3=>0,
                        4=>0,
                        5=>0,
                    ];
                    foreach($c->AcceptedStudents as $r)
                    {
                        if($r->rate != 0)
                            $rates[$r->rate] += 1;
                    }
                    $c->rates = $rates;
                }
                $page = (string)view('FrontEnd.Private.tabs.LecCourses',compact(['user','courses','categories']));
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

    public function CourseRequests($id)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $course=Course::findOrfail($id);
                $requests= Course_Reg::where('course_id',$id)->paginate(10);
                $chart = Course_Reg::select(DB::raw('count(id) as value, status as `key`'))->where('course_id',$id)->groupby('status')->get();
                $ChartLabel = "Requests";
                $page = (string)view('FrontEnd.Private.tabs.CourseRequests',compact(['user','course','requests','chart','ChartLabel']));
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

    public function BlockReq(Request $request)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $req=Course_Reg::findOrFail($request->req_id);
                $req->status = "Blocked";
                $req->save();
                return response()->json([
                    'success'=>true,
                    'data'=> $req
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

    public function AcceptReq(Request $request)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $req=Course_Reg::findOrFail($request->req_id);
                $req->status = "Active";
                $req->active = 1;
                $req->save();
                $first_content_for_course = Content::where('topic_id',Topic::where('course_id',$req->course_id)->first()->id)->first()->id;
                
                $course_student = [
                    "course_id"=>$req->course_id,
                    "student_id"=>$req->student_id,
                    "rate"=>0,
                    "progress"=>$first_content_for_course,
                ];
                $CS = Course_Student::create($course_student);
                return response()->json([
                    'success'=>true,
                    'data'=> $CS
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

    public function LecClasses()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $classes=_Class::where('lecturer_id',$user->id)->orderBy('subject_id','ASC')->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.LecClasses',compact(['user','classes']));
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

    public function ClassLectures($id)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lectures=Lecture::where('class_id',$id)->paginate(10);
                $chart = [];
                foreach($lectures as $l)
                {
                    $chart[] = json_decode('{"key":"'.$l->title.'","value":"'.$l->checksIn()->count().'"}');
                }
                $ChartLabel = "Checks In";
                $page = (string)view('FrontEnd.Private.tabs.LecClasseLectures',compact(['user','lectures','chart','ChartLabel']));
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

    public function AddLecture(Request $request)
    {
        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                // dd($request);
                $this->validate($request,[
                    'title' => ['required','string'],
                    'date' => ['required','date'],
                    'class_id' => ['required'],
                    'pdf_file.*' => ['mimes:pdf']
                ]);
                $file_name = str_replace(' ','-',$request->title).time();
                $ispdf = false;
                if($request->file('pdf_file')){
                    $file = $request->file('pdf_file');
                    if($file->isValid())
                    {
                        $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                        $ispdf = true;
                    }
                }
                $data=$request->all();
                if($ispdf)
                    $data['pdf_file'] = $file_name.'.pdf';
                $data['qr_code'] = $file_name.'.png';
                $lecture = Lecture::create($data);
                
                $url = route('checkInLec').'?lec_id='.$lecture->id.'&creationTime='.time();
                Storage::disk('public')->put('/QR-codes/'.$file_name.'.png',base64_decode(DNS2D::getBarcodePNG($url, "QRCODE")));
                
                $LecsCount = Lecture::where('class_id',$request->class_id)->count();
                return response()->json([
                    'success'=>true,
                    'data'=> $LecsCount,
                    'message'=>$request->title.' Added Successfully'
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

    public function DeleteLecture(Request $request)
    {        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lecture=Lecture::findOrFail($request->lec_id);
                
                // $pdf = storage_path('app/public/PDFfiles/'.$lecture->pdf_file);
                
                // if($lecture->pdf_file){
                    ////// delete file ///
                    // unlink($pdf);
                // }
                $lecture->delete();
                return response()->json([
                    'success'=>true,
                    'message'=>'Lecture Deleted Successfully'
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

    public function delLecPDF(Request $request)
    {        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lecture=Lecture::findOrFail($request->lec_id);
                // dd($lecture);
                $input_data['pdf_file'] = NULL;
                $pdf = storage_path('app/public/PDFfiles/'.$lecture->pdf_file);
                // dd($pdf);
                // if($lecture->update($input_data)){
                    ////// delete file ///
                    // unlink($pdf);
                // }
                $lecture->update($input_data);
                return response()->json([
                    'success'=>true,
                    'data'=> $lecture,
                    'message'=>'PDF File Deleted Successfully'
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

    public function UpdateLecture(Request $request)
    {
        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lecture=Lecture::findOrFail($request->lec_id);
                $this->validate($request,[
                    'title' => ['required','string'],
                    'date' => ['required','date'],
                ]);
                $ispdf = false;
                $file_name = str_replace(' ','-',$request->title).time();
                if($request->file('pdf_file')){
                    $file = $request->file('pdf_file');
                    if($file->isValid())
                    {
                        $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                        $ispdf = true;
                    }
                }
                $input_data=$request->all();
                if($ispdf)
                    $input_data['pdf_file'] = $file_name.'.pdf';
                $lecture->update($input_data);
                return response()->json([
                    'success'=>true,
                    'data'=> $lecture,
                    'message'=>$request->title.' Updated Successfully'
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
    
    public function AddCourse(Request $request)
    {
        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $this->validate($request,[
                    'title' => ['required', 'string', 'max:255'],
                    'description' => ['required', 'string'],
                    'category_id' => ['required'],
                    'skills' => ['required', 'string'],
                    'duration' => ['required', 'string'],
                    'cost' => ['required', 'numeric'],
                    'image' => ['required'],
                    'image.*' => ['mimes:jpg,jpeg,png']
                ]);

                $data=$request->all();
                $file_name = str_replace(' ','-',$request->title).time();
                
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
                $data['rate'] = 0;
                $data['lecturer_id'] = $user->id;
                
                $course = Course::create($data);
                return response()->json([
                    'success'=>true,
                    'data'=> $course,
                    'message'=>$course->title.' Added Successfully'
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

    public function UpdateCourse(Request $request)
    {
        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lecture=Lecture::findOrFail($request->lec_id);
                $this->validate($request,[
                    'title' => ['required','string'],
                    'date' => ['required','date'],
                ]);
                $ispdf = false;
                $file_name = str_replace(' ','-',$request->title).time();
                if($request->file('pdf_file')){
                    $file = $request->file('pdf_file');
                    if($file->isValid())
                    {
                        $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                        $ispdf = true;
                    }
                }
                $input_data=$request->all();
                if($ispdf)
                    $input_data['pdf_file'] = $file_name.'.pdf';
                $lecture->update($input_data);
                return response()->json([
                    'success'=>true,
                    'data'=> $lecture,
                    'message'=>$request->title.' Updated Successfully'
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

    public function DeleteCourse(Request $request)
    {        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $course = Course::findOrFail($request->course_id);
                $topics = Topic::where('course_id',$course->id)->get()->toArray();
                $contents = Content::whereIn('topic_id',$topics)->get();
                $requests = Course_Reg::where('course_id',$id)->get();
                $StudentsInCourse = Course_Student::where('course_id',$id)->get();

                foreach ($contents as $content) 
                {
                    $video = storage_path('app/public/ContentsVideos/'.$content->video_file);
                    $appendix = storage_path('app/public/ContentsAppendixFiles/'.$content->appendix);
                
                    if($content->video_file){
                        //// delete file ///
                        // unlink($video);
                    }

                    if($content->appendix){
                        //// delete file ///
                        // unlink($appendix);
                    }
                    $content->delete();
                }

                foreach ($topics as $topic) 
                {
                    $topic->delete();
                }

                foreach ($requests as $request) 
                {
                    $request->delete();
                }

                foreach ($StudentsInCourse as $Student) 
                {
                    $Student->delete();
                }

                $course->delete();
                
                return response()->json([
                    'success'=>true,
                    'message'=>'Course Deleted Successfully'
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
    
    public function delCouImg(Request $request)
    {        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lecture=Lecture::findOrFail($request->lec_id);
                // dd($lecture);
                $input_data['pdf_file'] = NULL;
                $pdf = storage_path('app/public/PDFfiles/'.$lecture->pdf_file);
                // dd($pdf);
                // if($lecture->update($input_data)){
                    ////// delete file ///
                    // unlink($pdf);
                // }
                $lecture->update($input_data);
                return response()->json([
                    'success'=>true,
                    'data'=> $lecture,
                    'message'=>'PDF File Deleted Successfully'
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
    
    public function courseTopics($id)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $topics = Topic::where('course_id',$id)->paginate(10);
                $page = (string)view('FrontEnd.Private.tabs.LecCourseTopics',compact(['user','topics']));
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
    
    public function UpdateTopic(Request $request)
    {
        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $topic = Topic::findOrFail($request->topic_id);
                $this->validate($request,[
                    'name' => ['required','string'],
                    'description' => ['required','string'],
                ]);
                $input_data=$request->all();
                $topic->update($input_data);
                return response()->json([
                    'success'=>true,
                    'data'=> $topic,
                    'message'=>$request->name.' Updated Successfully'
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

    public function DeleteTopic(Request $request)
    {        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $topic = Topic::findOrFail($request->topic_id);
                $contents = Content::where('topic_id',$request->topic_id)->get();

                foreach ($contents as $content) 
                {
                    $video = storage_path('app/public/ContentsVideos/'.$content->video_file);
                    $appendix = storage_path('app/public/ContentsAppendixFiles/'.$content->appendix);
                
                    if($content->video_file){
                        //// delete file ///
                        // unlink($video);
                    }

                    if($content->appendix){
                        //// delete file ///
                        // unlink($appendix);
                    }
                    $content->delete();
                }

                $topic->delete();
                
                
                return response()->json([
                    'success'=>true,
                    'message'=>'Topic Deleted Successfully'
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

    public function delCouVid(Request $request)
    {        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lecture=Lecture::findOrFail($request->lec_id);
                // dd($lecture);
                $input_data['pdf_file'] = NULL;
                $pdf = storage_path('app/public/PDFfiles/'.$lecture->pdf_file);
                // dd($pdf);
                // if($lecture->update($input_data)){
                    ////// delete file ///
                    // unlink($pdf);
                // }
                $lecture->update($input_data);
                return response()->json([
                    'success'=>true,
                    'data'=> $lecture,
                    'message'=>'PDF File Deleted Successfully'
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
    
    public function delCouApp(Request $request)
    {        
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['Lecturer']))
            {
                $lecture=Lecture::findOrFail($request->lec_id);
                // dd($lecture);
                $input_data['pdf_file'] = NULL;
                $pdf = storage_path('app/public/PDFfiles/'.$lecture->pdf_file);
                // dd($pdf);
                // if($lecture->update($input_data)){
                    ////// delete file ///
                    // unlink($pdf);
                // }
                $lecture->update($input_data);
                return response()->json([
                    'success'=>true,
                    'data'=> $lecture,
                    'message'=>'PDF File Deleted Successfully'
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

}
