<?php

namespace App\Http\Controllers;

use App\Collage;
use App\Subject;
use App\_Class;
use App\Student_Class;
use App\Category;
use App\Course;
use App\Event;
use App\Reference;
use App\Visitor;
use Auth;
use DB;

use Illuminate\Database\Eloquent\Builder;

class SuperadministratorProfileController extends MainController
{
    public function Collages()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $collages=Collage::orWhereHas('Students')->get();
                $page = (string)view('FrontEnd.Private.tabs.Collages',compact(['user','collages']));
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

    public function CollageDetails($id)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $subjects=Subject::where('collage_id',$id)->get();
                $studyYears=_Class::distinct('study_year')->get(['study_year']);
                $page = (string)view('FrontEnd.Private.tabs.CollageDetails',compact(['user','subjects','studyYears']));
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

    public function Courses()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $categories=Category::whereNotNull('parent_id')->
                                        whereHas('courses',function(Builder $query){
                                            $query->whereHas('AcceptedStudents')->
                                            orWhereHas('RegisteredStudents');
                                        })->get();
                $page = (string)view('FrontEnd.Private.tabs.Courses',compact(['user','categories']));
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

    public function CategoryDetails($id)
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $courses=Course::where('category_id',$id)->
                                    where(function($query) {
                                        $query->whereHas('AcceptedStudents')->
                                        orWhereHas('RegisteredStudents');
                                    })->get();
                $page = (string)view('FrontEnd.Private.tabs.CategoryDetails',compact(['user','courses']));
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

    public function Events()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $events=Event::orderBy('started_at', 'desc')->get();
                $page = (string)view('FrontEnd.Private.tabs.Events',compact(['user','events']));
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

    public function References()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $chart = Reference::select(DB::raw('count(id) as value, category as `key`'))->groupby('category')->get();
                $ChartLabel = "References";
                $page = (string)view('FrontEnd.Private.tabs.Chart',compact(['user','chart','ChartLabel']));
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

    public function Complaints()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $complaints_data = file_get_contents('C:\\wamp64\\www\\myUniversity\\public\\complaints (2).json');
                $list = json_decode($complaints_data);
                $chartArray = [];
                foreach($list as $item)
                {
                    $obj = json_decode('{ "key":"" , "value":"" }');
                    $obj->key = $item->name;
                    $obj->value = $item->number;
                    $chartArray[] = $obj;
                }
                $chart = json_decode(json_encode($chartArray));
                $ChartLabel = "Complaints";
                $type = 'bar';
                
                $mainPage = (string)view('FrontEnd.Private.tabs.Chart',compact(['type','user','chart','ChartLabel']));
                
                $row = 0;
        
                if (($handle = fopen("C:\\wamp64\\www\\myUniversity\\public\\complaints (3).csv", "r")) !== FALSE) 
                {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
                    {
                        $num = count($data);
                        $comp = [];
                        if($row > 0)
                        {
                            $comp['complaint'] = $data[0];
                            $comp['gender'] = $data[1];
                            $comp['year'] = $data[2];
                            $complaints[] = $comp;  
                        }
                        $row++;
                    }
                    fclose($handle);
                }

                $collection = collect($complaints);

                $gender = $collection->unique('gender');
                $gender->values()->all();
                $genderArray = [];
                foreach($gender as $g)
                {
                    $obj = json_decode('{ "key":"" , "value":"" }');
                    $obj->key = $g['gender'];
                    $obj->value = $collection->where('gender',$g['gender'])->count();
                    $genderArray[] = $obj;
                }
                $chart = json_decode(json_encode($genderArray));
                $ChartLabel = "ByGender";
                $type = 'pie';
                $genderPage = (string)view('FrontEnd.Private.tabs.Chart',compact(['type','user','chart','ChartLabel']));

                $year = $collection->unique('year');
                $year->values()->all();
                $yearArray = [];
                foreach($year as $g)
                {
                    $obj = json_decode('{ "key":"" , "value":"" }');
                    $obj->key = $g['year'];
                    $obj->value = $collection->where('year',$g['year'])->count();
                    $yearArray[] = $obj;
                }
                $chart = json_decode(json_encode($yearArray));
                $ChartLabel = "ByYear";
                $type = 'line';
                $yearPage = (string)view('FrontEnd.Private.tabs.Chart',compact(['type','user','chart','ChartLabel']));

                return response()->json([
                    'success'=>true,
                    'data'=> $mainPage.'<hr><br><hr>'.$genderPage.'<hr><br><hr>'.$yearPage
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

    public function Pages()
    {
        $message = "";
        $user = Auth::user();
        if($user)
        {
            if($user->hasRole(['superadministrator']))
            {
                $chart = Visitor::select(DB::raw('url as `key` , count as `value`'))->orderBy('count','DESC')->limit(20)->get();
                $ChartLabel = "Clicks";
                $page = (string)view('FrontEnd.Private.tabs.Chart',compact(['user','chart','ChartLabel']));
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
}
