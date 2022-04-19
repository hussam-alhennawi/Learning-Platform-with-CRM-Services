<?php

namespace App\Http\Controllers;

use App\Course;
use App\Event;
use App\Event_Going;
use App\Advertisement;
use App\Topic;
use App\Content;
use App\Course_Reg;
use App\Course_Student;
use App\Category;
use App\User;
use App\Reference;
use App\Lib_project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

use App\Helpers\General\CollectionHelper;

use Auth;

class IndexController extends MainController
{
    public function index()
    {
        $user = Auth::user();
        
        $all_courses = Course::orderBy('rate', 'desc')->limit(10)->get();
        
        $public_Ads = Advertisement::doesntHave('collages')->doesntHave('classes')->limit(3)->get();
            
        $specific_Ads = Advertisement::
                                        where(function($q) use($user){
                                            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
                                            {
                                                $collection->whereHas('collages',function($query) use($user)
                                                {
                                                    $query->where('collage_id',$user->StudentRegistredAtCollage->collage_id);
                                                });
                                            });
                                        })->
                                        orWhere(function($q) use($user){
                                            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
                                            {
                                                $collection->whereHas('classes',function($query) use($user)
                                                {
                                                    $query->whereIn('class_id',$user->Classes);
                                                });
                                            });
                                        })->
                                        orWhere(function($q) use($user){
                                            $q->when((!$user || !$user->hasRole('Internal_student')),function($collection)
                                            {
                                                $collection->where('id',null);
                                            });
                                        })->limit(3)->get();
        $all_Advertisements = collect([$specific_Ads,$public_Ads])->collapse()->sortBy('created_at')->take(3);
        $lecturers = User::whereRoleIs('Lecturer')->
            whereHas('LecturerRegistredAtCollage')->
            get()->
            sortByDesc(function ($product, $key) {
                return count($product['LecturerRegistredAtCollage']);
            })->take(5);
        $ComingEvents = Event::where('started_at','>',date('Y-m-d'))->orderBy('started_at', 'asc')->limit(2)->get();
        return view('FrontEnd.Public.index',compact('ComingEvents','all_courses','lecturers','all_Advertisements'));
    }
 
    /**
     * Display an object of the resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function element($id)
    {
        $course=Course::findOrFail($id);
        $recomended_courses = null;
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
            if($r->rate != 0)
            {
                $rates[0] += 1;
                $rates[$r->rate] += 1;
            }
        }
        $course->rates = $rates;
        $user = Auth::user();
        if(isset($user) && $user->hasRole(['Internal_student','External_student']))
        {
            $user_id = Auth::user()->id;
            $course->register = Course_Reg::where('course_id',$id)->where('student_id',$user_id)->latest()->first();
            $course->accept = Course_Student::where('course_id',$id)->where('student_id',$user_id)->first();
            $recomended_data = file_get_contents('C:\\wamp64\\www\\myUniversity\\public\\reco.json');
            $list = json_decode($recomended_data);
            foreach($list as $item)
            {
                if((int)$item->Student_ID == $user_id)
                $recomended_courses [] = Course::findOrFail($item->Course_ID);
            }
        }
        $related_courses = Course::where('category_id',$course->category_id)->where('id','!=',$course->id)->orderBy('rate','desc')->limit(10)->get();
        return view('FrontEnd.Public.single-course',compact('course','related_courses','recomended_courses'));
    }

    public function showallCourses(Request $request)
    {
        $recomended_courses = null;
        $categories=Category::whereNotNull('parent_id')->get();
        $mainCategories=Category::whereNull('parent_id')->get();
        $prices = [
            "min_price"=> Course::min('cost'),
            "max_price"=> Course::max('cost')
        ];
        
        $name = $request->course_name;
        $cat_id = $request->cat_id;
        $min_cost = $request->min_cost;
        $max_cost = $request->max_cost;

        $all_courses = Course::when($name, function ($query, $name) {
            return $query->where('title','like', '%'.$name.'%');
        })
        ->when($cat_id, function ($query, $cat_id) {
            return $query->where('category_id', $cat_id);
        })
        ->when($min_cost, function ($query, $min_cost) {
            return $query->where('cost','>=', $min_cost);
        })
        ->when($max_cost, function ($query, $max_cost) {
            return $query->where('cost','<=', $max_cost);
        })
            ->orderBy('rate', 'desc')->paginate(10);

        $user = Auth::user();
        if(isset($user) && $user->hasRole(['Internal_student','External_student']))
        {
            $user_id = Auth::user()->id;
            $recomended_data = file_get_contents('C:\\wamp64\\www\\myUniversity\\public\\reco.json');
            $list = json_decode($recomended_data);
            foreach($list as $item)
            {
                if((int)$item->Student_ID == $user_id)
                $recomended_courses [] = Course::findOrFail($item->Course_ID);
            }
        }
        return view('FrontEnd.Public.all_courses',compact('all_courses','categories','mainCategories','prices','recomended_courses'));
    }

    public function all_events(Request $request)
    {
        $name = $request->title;
        $all_events = Event::orderBy('started_at', 'desc')->
            when($name, function ($query, $name) {
                return $query->where('name','like', '%'.$name.'%');
            })->paginate(10);
        return view('FrontEnd.Public.all_events',compact('all_events'));
    }

    public function event($id)
    {
        $user = Auth::user();
        $event=Event::findOrFail($id);
        if(isset($user) && $user->hasRole(['Internal_student']))
        {
            $user_id = Auth::user()->id;
            $event->going = Event_Going::where('event_id',$id)->where('student_id',$user_id)->first();
        }
        return view('FrontEnd.Public.single_event',compact('event'));

    }

    public function allAdvertisements(Request $request)
    {
        $user = Auth::user();
        $name = $request->name;
        $public_Ads = Advertisement::doesntHave('collages')->doesntHave('classes')->
            when($name, function ($query, $name) {
                return $query->where('title','like', '%'.$name.'%');
            })->get();
        $specific_Ads = Advertisement::
                                        where(function($q) use($user){
                                            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
                                            {
                                                $collection->whereHas('collages',function($query) use($user)
                                                {
                                                    $query->where('collage_id',$user->StudentRegistredAtCollage->collage_id);
                                                });
                                            });
                                        })->
                                        orWhere(function($q) use($user){
                                            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
                                            {
                                                $collection->whereHas('classes',function($query) use($user)
                                                {
                                                    $query->whereIn('class_id',$user->Classes);
                                                });
                                            });
                                        })->
                                        orWhere(function($q) use($user){
                                            $q->when((!$user),function($collection)
                                            {
                                                $collection->where('id',null);
                                            });
                                        })->
                                        when($name, function ($query, $name) {
                                            return $query->where('title','like', '%'.$name.'%');
                                        })->get();
        $collection = collect([$specific_Ads,$public_Ads])->collapse()->sortBy('created_at');
        $last_ads = $collection->take(4);
        $all_Advertisements = CollectionHelper::paginate($collection,10);
        return view('FrontEnd.Public.all_ads',compact('all_Advertisements','last_ads'));

    }

    public function ad($id)
    {
        $user = Auth::user();
        $public_Ads = Advertisement::doesntHave('collages')->doesntHave('classes')->get();
        $specific_Ads = Advertisement::
                                        where(function($q) use($user){
                                            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
                                            {
                                                $collection->whereHas('collages',function($query) use($user)
                                                {
                                                    $query->where('collage_id',$user->StudentRegistredAtCollage->collage_id);
                                                });
                                            });
                                        })->
                                        orWhere(function($q) use($user){
                                            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
                                            {
                                                $collection->whereHas('classes',function($query) use($user)
                                                {
                                                    $query->whereIn('class_id',$user->Classes);
                                                });
                                            });
                                        })->
                                        orWhere(function($q) use($user){
                                            $q->when((!$user),function($collection)
                                            {
                                                $collection->where('id',null);
                                            });
                                        })->get();
        $collection = collect([$specific_Ads,$public_Ads])->collapse()->sortBy('created_at');
        $last_ads = $collection->take(4);
        $ad = Advertisement::findOrFail($id);
        return view('FrontEnd.Public.single-ad',compact('ad','last_ads'));
    }

    public function coursevideos($id)
    {
        $user = Auth::user();
        $content=Content::findOrFail($id);
        $course=Course::findOrFail($content->topic->course_id);
        $c_s = Course_Student::where('student_id',$user->id)->where('course_id',$course->id)->first();
        $CurrentContent = Content::findOrFail($c_s->progress);
        if(!$CurrentContent->next())
        {
            $c_r = Course_Reg::where('student_id',$user->id)->
                                where('course_id',$course->id)->
                                where('active',1)->
                                where('status','Active')->first();
            if($c_r)
            {
                $c_r->status = 'Done'; 
                $c_r->active = 0;
                $c_r->save(); 
            }
        }
        if($CurrentContent->next() != null && $CurrentContent->next()->id == $id)
        {
            $c_s->progress = $id;
            $c_s->save();
        }
        return view('FrontEnd.Public.content_page',compact('content','course'));
    }

    public function user($id)
    {
        $user = User::findOrFail($id);
        return view('FrontEnd.Public.single-lecturers',compact('user'));
    }
    
    public function allUsers()
    {
        $lecturers = User::whereRoleIs('Lecturer')->whereHas('LecturerRegistredAtCollage')->paginate(16);
        return view('FrontEnd.Public.all-lecturers',compact('lecturers'));
    }

    public function ShowCategories()
    {
        $categories=Category::all();
        return view('backEnd.courses.create',compact('categories'));
    }

    public function registerInCourse(Request $request)
    {
        $this->validate($request,[
            'course_id' => ['required']
        ]);
        $user = Auth::user();
        $course = Course::findOrFail($request->course_id);

        if($user->hasRole(['Internal_student','External_student']))
        { 
            set_time_limit(2000);
            $course_reg['course_id'] = $course->id;
            $course_reg['student_id'] = $user->id;
            $course_reg['date'] = date('Y-m-d');
            $course_reg['payment_check'] = NULL;
            if($course->cost > 0)
            {
                $course_reg['status'] = "Pending";
                $course_reg['active'] = 0;
                $this->validate($request,[
                    'payment_check' => ['required'],
                    'payment_check.*' => ['mimes:pdf']
                ]);

                $file_name = str_replace(' ','-',$user->full_name()).time();
                if($request->file('payment_check'))
                {
                    $file = $request->file('payment_check');
                    if($file->isValid())
                    {
                        $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                        $course_reg['payment_check'] = $file_name.'.pdf';
                    }
                }
            }
            else
            {
                $course_reg['status'] = "Active";
                $course_reg['active'] = 1;
                $first_content_for_course = Content::where('topic_id',Topic::where('course_id',$course->id)->first()->id)->first()->id;
                
                $course_student = [
                    "course_id"=>$course->id,
                    "student_id"=>$user->id,
                    "rate"=>0,
                    "progress"=>$first_content_for_course,
                ];
                $CS = Course_Student::create($course_student);
            }
            
            Course_Reg::create($course_reg);

            shell_exec("C:\\Users\\Yazan\\AppData\\Local\\Programs\\Python\\Python38\\python.exe C:\\wamp64\\www\\myUniversity\\public\\courses_recomendation_system.py");

        }
        return redirect()->back();
    }

    public function goToEvent(Request $request)
    {
        $this->validate($request,[
            'event_id' => ['required']
        ]);
        $user = Auth::user();
        $event = Event::findOrFail($request->event_id);

        if($user->hasRole(['Internal_student']))
        {
            $going = Event_Going::where('event_id',$event->id)->where('student_id',$user->id)->first();
            if($going)
            {
                $going->delete();
            }
            else
            {
                Event_Going::create([
                    "student_id"=>$user->id,
                    "event_id"=>$event->id
                ]);
            }
        }
        return redirect()->back();
    }

    public function rate(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole(['Internal_student','External_student']))
        {
            $student_id = $user->id;
            $course_id = $request->course_id;
            $rate = $request->rate;
            if($rate>=1 || $rate<=5)
            {
                $reg = Course_Student::where('course_id',$course_id)->where('student_id',$student_id)->first();
                if($reg)
                {
                    $reg->rate = $request->rate;
                    $reg->save();
                    $course = Course::findOrFail($course_id);
                    $StudentRates = $course->AcceptedStudents;
                    $rates = [
                        0=>0,
                        1=>0,
                        2=>0,
                        3=>0,
                        4=>0,
                        5=>0,
                    ];
                    $total_rate = 0;
                    $n = 0;
                    foreach ($StudentRates as $student) {
                        if($student->rate > 0)
                        {
                            $total_rate += $student->rate;
                            $n++;
                            $rates[0] += 1;
                            $rates[$student->rate] += 1;
                        }
                    }
                    $course_rate = $total_rate/$n;
                    $course->rate = $course_rate;
                    $course->save();
                    $course->rates = $rates;
                    // $response = "{message:\"Rate Done Successfully\",code:1,data:{course_rate:".$course_rate."}}";
                    return  response()->json([
                        'success'=>'Rate Done Successfully',
                        'data'=>$course
                        ]);
                    // return $response;
                }
                $response = "You're not registered in this course";
                return $response;
            }
            $response = "Rate should be between 1 and 5";
            return $response;
        }
        $response = "You're not allowed to rate courses";
        return $response;
    }

    public function library(Request $request)
    {
        $user=Auth::user();
        $title = $request->title;
        $cat = $request->cat;
        $references = Reference::when($title, function ($query, $title) {
                return $query->where('title','like', '%'.$title.'%');
            })->when($cat, function ($query, $cat) {
                return $query->where('category', $cat);
            })->paginate(12);
        $categories = Reference::distinct('category')->get(['category']);
        $bestChoices = Reference::whereHas('FavouriteLists')->
            get()->
            sortByDesc(function ($product, $key) {
                return count($product['FavouriteLists']);
            })->take(3);
        
        return view('FrontEnd.Public.Library',compact(['user','references','categories','bestChoices']));
    }

    public function libProjects(Request $request)
    {
        $user=Auth::user();
        $title = $request->title;
        $libProjects = Lib_project::when($title, function ($query, $title) {
            return $query->where('title_en','like', '%'.$title.'%')->orWhere('title_ar','like', '%'.$title.'%');
        })->
            where(function($q) use($user){
                $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
                {
                    $collection->whereHas('subject',function($query) use($user)
                    {
                        $query->where('collage_id',$user->StudentRegistredAtCollage->collage_id);
                    });
                });
            })->
            orWhere(function($q) use($user){
                $q->when((!$user || !$user->hasRole('Internal_student')),function($collection)
                {
                    $collection->where('id',null);
                });
            })->paginate(6);
        $myLibProjects = Lib_project::where(function($q) use($user){
            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
            {
                $collection->whereHas('students',function($query) use($user)
                {
                    $query->where('student_id',$user->id);
                });
            });
        })->get();
        
        return view('FrontEnd.Public.LibProjects',compact(['user','libProjects','myLibProjects']));
    }

    public function Project($id)
    {
        $user = Auth::user();
        $project = Lib_project::findOrFail($id);
        $related = Lib_project::where('subject_id',$project->subject_id)->limit(7)->get();
        $myLibProjects = Lib_project::where(function($q) use($user){
            $q->when(($user && $user->hasRole('Internal_student')),function($collection) use($user)
            {
                $collection->whereHas('students',function($query) use($user)
                {
                    $query->where('student_id',$user->id);
                });
            });
        })->get();
        return view('FrontEnd.Public.single-proj',compact(['user','project','related','myLibProjects']));

    }

    public function book($id)
    {
        $user=Auth::user();
        $ref = Reference::findOrFail($id);
        $related = Reference::where('id','!=',$id)->where('category',$ref->category)->limit(7)->get();
        $categories = Reference::distinct('category')->get(['category']);
        $bestChoices = Reference::whereHas('FavouriteLists')->
            get()->
            sortByDesc(function ($product, $key) {
                return count($product['FavouriteLists']);
            })->take(3);
        return view('FrontEnd.Public.single-ref',compact(['user','ref','related','categories','bestChoices']));
    }

}
