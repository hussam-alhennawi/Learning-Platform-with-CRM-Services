<?php

namespace App\Http\Controllers;

use View;
use App\Role;
use App\User;
use App\Collage;
use App\Collage_Lecturer;
use App\CheckIn;
use App\Student_Collage;
use App\Student_Class;
use App\Subject;
use App\Category;
use App\Course;
use App\_Class;
use App\Lecture;
use App\Topic;
use App\Content;
use App\Course_Reg;
use App\Course_Student;
use App\Favourite_Lecture;
use App\Favourite_LibProject;
use App\Favourite_Reference;
use App\Lib_project;
use App\Reference;
use App\Event;
use App\Event_Going;
use App\Advertisement;
use App\Complaint;
use DB;
use DateTime;
use Hash;
use Image;
use DNS2D;
use Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
class AdminBaseController extends MainController
{
    public function __construct(Request $request) 
    {
        parent::__construct($request);
        $roles=Role::all();
        View::share ( 'roles', $roles );
    } 
    
    public function del()
    {
        Schema::disableForeignKeyConstraints();
        // Course::truncate();
        $ss = Course::all();
        dd($ss);
        dd(1);
    }

    public function testPython()
    {
        set_time_limit(3000);
        
        $result = shell_exec("C:\\Users\\Yazan\\AppData\\Local\\Programs\\Python\\Python38\\python.exe C:\\wamp64\\www\\myUniversity\\public\\grad_project.py");

        dd($result);
    }

    public function addToDb()
    {
        set_time_limit(3000);
        
    }

    public function addAdvertisements()
    {
        for ($i=0; $i < 30; $i++) 
        { 
            $class = _Class::inRandomOrder()->first();
            $ad['title'] = 'Ad For '.$class->subject->name_en.'('.$class->study_year.') class';
            $ad['description'] = 'Description About this Ad';
            $ad['image'] = rand(1,8).'.jpg';
            $ads = Advertisement::create($ad);
            $ads->classes()->save($class);
        }

        for ($i=0; $i < 30; $i++) 
        { 
            $col = collage::inRandomOrder()->first();
            $ad['title'] = 'Ad For '.$col->name_en.' collage';
            $ad['description'] = 'Description About this Ad';
            $ad['image'] = rand(1,8).'.jpg';
            $ads = Advertisement::create($ad);
            $ads->collages()->save($col);
        }

        for ($i=0; $i < 30; $i++) 
        { 
            $ad['title'] = 'Ad '.($i+1);
            $ad['description'] = 'Description About this Ad';
            $ad['image'] = rand(1,8).'.jpg';
            $ads = Advertisement::create($ad);
        }
    }

    public function addGoingToEvents()
    {
        set_time_limit(3000);
        $events = Event::all();
        $students = User::whereRoleIs('Internal_Student')
            ->whereHas('StudentRegistredAtCollage',
                function(Builder $query){
                    $query->where('date_of_registration','>','2015-1-1');
                    $query->where('date_of_registration','<','2020-1-1');
                }
            )
            ->with('StudentRegistredAtCollage')
            ->get(['id'])->toArray();
            
        $ids = [];
        foreach($students as $s)
        {
            $ids[] = $s['id'];
        }


        foreach($events as $event)
        {
            $n = rand(50,500);
            $indexs = [];

            for($k = 0 ;$k<$n;$k++)
            {
                while(true)
                {
                    $randStudent = array_rand($ids);
                    $s_id = $ids[$randStudent];
                    if(!in_array($s_id,$indexs))
                        goto a;
                }
                a:

                $E_G['student_id'] = $s_id;
                $E_G['event_id'] = $event->id;
                Event_Going::create($E_G);
            }
        }
    }

    public function AddReferencesToFavouriteList()
    {
        set_time_limit(3000);
        
        $refs = Reference::all();

        foreach($refs as $ref)
        {
            $students = User::whereRoleIs('Internal_Student')
            ->orWhere(function($query) {
                $query->whereRoleIs('External_Student')
                ->where('active',1);
            })
            ->get();
            
            $ids = [];
            foreach($students as $s)
            {
                $ids[] = $s->id;
            }

            $n = rand(-50,50);
            
            $indexs = [];
            for($i = 0;$i<$n;$i++)
            {
                while(true)
                {
                    $randStud = array_rand($ids);
                    $s_id = $ids[$randStud];
                    if(!in_array($s_id,$indexs))
                        goto a;
                }
                a:

                $indexs[] = $s_id;

                $favRef['student_id'] = $s_id;
                $favRef['reference_id'] = $ref->id;
                
                Favourite_Reference::create($favRef);
            }
        }
    }

    public function AddLibProjectsToFavouriteList()
    {
        set_time_limit(3000);
        $S_C = Student_Class::distinct('student_id','class_id')->get(['student_id','class_id']);

        foreach($S_C as $s)
        {
            $sc = Student_Class::where('student_id',$s['student_id'])->where('class_id',$s['class_id'])->first();
            $subject_id = _Class::findOrFail($s['class_id'])->subject_id;
            $libs = Lib_project::where('subject_id',$subject_id)->get();
            
            $ids = [];
            foreach($libs as $s)
            {
                $ids[] = $s['id'];
            }

            $n = rand(0,3);
            $indexs = [];
            for($i = 0;$i<$n;$i++)
            {
                while(true)
                {
                    $randLib = array_rand($ids);
                    $l_id = $ids[$randLib];
                    if(!in_array($l_id,$indexs))
                        goto a;
                }
                a:

                $favLib['student_id'] = $sc->student_id;
                $favLib['lib_project_id'] = $l_id;
                
                Favourite_LibProject::create($favLib);

                $indexs[] = $l_id;
            }
        }
    }

    public function AddLibProjects()
    {
        set_time_limit(3000);
        $subjects = Subject::whereHas('classes',
        function(Builder $query){
            $query->whereHas('StudentsRegistredAtClass');
        })->get();

        foreach($subjects as $sub)
        {
            $students = Student_Class::distinct('student_id','class_id')->where('class_id',$sub->classes[0]->id)->get(['student_id','class_id']);
            
            $stu_ids = [];
            foreach($students as $s)
            {
                $stu_ids[] = $s['student_id'];
            }

            $lecturers = User::whereRoleIs('Lecturer')
            ->whereHas('LecturerRegistredAtCollage',
                function(Builder $query) use($sub){
                    $query->where('collage_id','=',$sub->collage_id);
                }
            )
            ->get(['id'])->toArray();
            
            $lecs_ids = [];
            foreach($lecturers as $l)
            {
                $lecs_ids[] = $l['id'];
            }

            $n = rand(count($stu_ids)/6,count($stu_ids)/2);
            
            $indexs = [];
            for($i = 0;$i<$n;$i++)
            {
                $ii = 0;
                $stds = [];
                $numStud = rand(2,4);
                while(true)
                {
                    $randStud = array_rand($stu_ids);
                    $s_id = $stu_ids[$randStud];
                    if(!in_array($s_id,$indexs) && !in_array($s_id,$stds))
                    {
                        $stds[] = $s_id;
                        $indexs[] = $s_id;
                        if($ii == $numStud-1)
                            goto a;
                        else
                            $ii++;
                    }
                    if(count($indexs) == count($stu_ids))
                        goto a;
                }
                a:
                
                $jj = 0;
                $lecs = [];
                $numLecs = rand(1,2);
                while(true)
                {
                    $randLec = array_rand($lecs_ids);
                    $s_id = $lecs_ids[$randLec];
                    if(!in_array($s_id,$lecs))
                    {
                        $lecs[] = $s_id;
                        if($jj == $numLecs-1)
                            goto aa;
                        else
                            $jj++;
                    }
                    
                }
                aa:
                
                if(count($stds))
                {

                    $lib['subject_id'] = $sub->id;
                    $lib['title_en'] = 'Research Project num('.($i+1).') in '.$sub->name_en;
                    $lib['title_ar'] = 'مشروع بحثي رقم('.($i+1).') في '.$sub->name_ar;
                    $lib['pdf_file'] = 'libProject.pdf';
                    $lib['study_year'] = '2019-2020';
                    $lib_project = Lib_project::create($lib);
                    $lib_project->students()->sync($stds);
                    $lib_project->supervisors()->sync($lecs);
                }
            }
        }
    }

    public function AddLecturesToFavouriteList()
    {
        set_time_limit(3000);
        $S_C = Student_Class::distinct('student_id','class_id')->get(['student_id','class_id']);

        foreach($S_C as $s)
        {
            $sc = Student_Class::where('student_id',$s['student_id'])->where('class_id',$s['class_id'])->first();
            $lecs = Lecture::where('class_id',$s['class_id'])->get();
            
            $ids = [];
            foreach($lecs as $s)
            {
                $ids[] = $s['id'];
            }

            $n = rand(0,count($lecs));
            $indexs = [];
            for($i = 0;$i<$n;$i++)
            {
                while(true)
                {
                    $randLec = array_rand($ids);
                    $l_id = $ids[$randLec];
                    if(!in_array($l_id,$indexs))
                        goto a;
                }
                a:

                $favLec['student_id'] = $sc->student_id;
                $favLec['lecture_id'] = $l_id;
                
                Favourite_Lecture::create($favLec);

                $indexs[] = $l_id;
            }
        }
    }

    public function RegisterStudentsInCourses()
    {
        set_time_limit(3000);

        $students = User::whereRoleIs('Internal_Student')
            ->orWhere(function($query) {
                $query->whereRoleIs('External_Student')
                ->where('active',1)
                ->whereNotNull('identity_check');
            })
            ->get();
         
        $ids = [];
        foreach($students as $s)
        {
            $ids[] = $s['id'];
        }

        $status = ['Active','Pending','Blocked','Done'];
        $courses = Course::all();
        $cNum = 0;
        foreach ($courses as $course) 
        {
            if($cNum > 182)
                break;
            $indexs = [];
            $n = rand(12,40);
            $rate = 0;
            $numOfRate = 0;
            for($k = 0 ;$k<$n;$k++)
            {
                while(true)
                {
                    $randStudent = array_rand($ids);
                    $s_id = $ids[$randStudent];
                    if(!in_array($s_id,$indexs))
                        goto a;
                }
                a:
                $course_reg['course_id'] = $course->id;
                $course_reg['student_id'] = $s_id;
                $course_reg['payment_check'] = ($course->cost > 0) ? 'check.pdf' : NULL;
                $course_reg['date'] = $this->randomDate('2018-11-15','2019-6-2');
                if($course->cost > 0)
                    $st = array_rand($status);
                else
                    $st = 0;
                $course_reg['status'] = $status[$st];
                $course_reg['active'] = ($status[$st] == 'Active') ? 1 : 0;
                Course_Reg::create($course_reg);

                $topics = $course->topics;
                $topicsIds = [];
                foreach($topics as $s)
                {
                    $topicsIds[] = $s['id'];
                }

                $contentIds = [];
                foreach($topicsIds as $id)
                {
                    $contents = Topic::findOrFail($id)->contents;
                    foreach($contents as $s)
                    {
                        $contentIds[] = $s['id'];
                    }
                }

                if($status[$st] == 'Active' || $status[$st] == 'Done')
                {
                    $course_student['course_id'] = $course->id;
                    $course_student['student_id'] = $s_id;
                    $ra = rand(1,5);
                    $course_student['rate'] = $ra;
                    $pr = array_rand($contentIds);
                    $course_student['progress'] = $contentIds[$pr];
                    
                    Course_Student::create($course_student);
                    $numOfRate++;
                    $rate += $ra;
                }
            }
            $course->rate = $rate/$numOfRate;
            $course->save();
            $cNum++;
        }
    }

    public function addContents()
    {
        set_time_limit(3000);
        $T = Topic::all();
        foreach ($T as $t) 
        {
            $content['topic_id'] = $t->id;
            $content['title'] = '1st video about '.$t->name;
            $content['description'] = 'Welcome To The '.$t->name;
            $content['video_file'] = NULL;
            $content['appendix'] = NULL;
            $content['sequence'] = 1;
            Content::create($content);

            $content['topic_id'] = $t->id;
            $content['title'] = '2nd video about '.$t->name;
            $content['description'] = 'Let\'s Continue With '.$t->name;
            $content['video_file'] = NULL;
            $content['appendix'] = NULL;
            $content['sequence'] = 2;
            Content::create($content);
            
            $content['topic_id'] = $t->id;
            $content['title'] = '3rd video about '.$t->name;
            $content['description'] = 'We\'re Done With The '.$t->name;
            $content['video_file'] = NULL;
            $content['appendix'] = NULL;
            $content['sequence'] = 3;
            Content::create($content);

        }
    }

    public function addTopics()
    {
        set_time_limit(2000);
        $c = Course::all();
        foreach($c as $cc)
        {
            $topic['course_id'] = $cc->id;
            $topic['name'] = 'Intro to '.$cc->title;
            $topic['description'] = 'Description About '.$topic['name'];
            Topic::create($topic);
            
            $topic['course_id'] = $cc->id;
            $topic['name'] = 'Main Content of '.$cc->title;
            $topic['description'] = 'Description About '.$topic['name'];
            Topic::create($topic);

            $topic['course_id'] = $cc->id;
            $topic['name'] = 'The Future Of '.$cc->title;
            $topic['description'] = 'Description About '.$topic['name'];
            Topic::create($topic);
        }
    }

    public function CheckInLectures()
    {
        set_time_limit(3000);
        $S_C = Student_Class::distinct('student_id','class_id')->get(['student_id','class_id']);
        // dd(count($S_C));
        foreach($S_C as $s)
        {
            $sc = Student_Class::where('student_id',$s['student_id'])->where('class_id',$s['class_id'])->first();
            $lecs = Lecture::where('class_id',$s['class_id'])->get();
            
            $ids = [];
            foreach($lecs as $s)
            {
                $ids[] = $s['id'];
            }

            $n = rand(1,count($lecs));
            $indexs = [];
            for($i = 0;$i<$n;$i++)
            {
                while(true)
                {
                    $randLec = array_rand($ids);
                    $l_id = $ids[$randLec];
                    if(!in_array($l_id,$indexs))
                        goto a;
                }
                a:

                $ch['student_class_id'] = $sc->id;
                $ch['lecture_id'] = $l_id;
                
                CheckIn::create($ch);

                $indexs[] = $l_id;
            }
        }
    }

    public function AddLectures()
    {
        set_time_limit(3000);
        $classes = _Class::whereHas('StudentsRegistredAtClass')->get();
        foreach($classes as $class)
        {
            $lec = [];
            $lec['class_id'] = $class->id;
            $lec['title'] = '1- Intro to '.$class->subject->name_en.'-'.$class->type;
            switch($class->semester_number)
            {
                case 1:
                {
                    $lec['date'] = $this->randomDate('2019-10-1','2019-10-15');
                    break;
                }
                case 2:
                {
                    $lec['date'] = $this->randomDate('2020-2-1','2020-2-15');
                    break;
                }
                case 3:
                {
                    $lec['date'] = $this->randomDate('2020-7-1','2020-7-15');
                    break;
                }
            }
            $lec['pdf_file'] = NULL;
            
            $url = route('checkInLec').'?lec_id='.$lec['id'].'&creationTime='.time();
            Storage::disk('public')->put('/QR-codes/'.$lec['title'].'.png',base64_decode(DNS2D::getBarcodePNG($url, "QRCODE")));
            $lec['qr_code'] = $lec['title'].'.png';
            Lecture::create($lec);

            $rand = rand(3,6);
            for($i=2; $i<=$rand;$i++)
            {
                if($i<$rand)
                    $lec['title'] = $i.'- Lec'.$i.' in '.$class->subject->name_en.'-'.$class->type;
                else
                   $lec['title'] = $i.'- Final Lec in '.$class->subject->name_en.'-'.$class->type;
                $lec['date'] = DateTime::createFromFormat('Y-m-d', $lec['date'])->modify('+7 days')->format('Y-m-d');
                // $url = route('/checkInLec'); To do later ^_^
                $url = 'https://'.$lec['title'];
                Storage::disk('public')->put('/QR-codes/'.$lec['title'].'.png',base64_decode(DNS2D::getBarcodePNG($url, "QRCODE")));
                $lec['qr_code'] = $lec['title'].'.png';
                Lecture::create($lec);
            }
        }        
    }

    public function RegisterStudentsInClasses()
    {
        set_time_limit(3000);
        $classes = _Class::all();
        for($i = 0; $i < count($classes) ;$i = $i+2)
        {
            $class = $classes[$i];
            $students = User::whereRoleIs('Internal_Student')
                ->whereHas('StudentRegistredAtCollage',
                    function(Builder $query) use($class){
                        $query->where('date_of_registration','>','2015-1-1');
                        $query->where('date_of_registration','<','2020-1-1');
                        $query->where('collage_id','=',$class->subject->collage_id);
                    }
                )
                ->with('StudentRegistredAtCollage')
                ->get(['id'])->toArray();

            $ids = [];
            foreach($students as $s)
            {
                $ids[] = $s['id'];
            }
            
            $indexs = [];
            $n = rand(count($ids)/2,count($ids));

            for($k = 0 ;$k<$n;$k++)
            {
                while(true)
                {
                    $randStudent = array_rand($ids);
                    $s_id = $ids[$randStudent];
                    if(!in_array($s_id,$indexs))
                        goto a;
                }
                a:
                $mark1 = $mark2 = 0;
                $j = 0;
                while($mark1 + $mark2 < 60 && $j < 3-$class->semester_number)
                {
                    $mark1 = rand(0,70);
                    $mark2 = rand(0,30);
                    $s_c['student_id'] = $s_id;
                    $s_c['class_id'] = $class->id;
                    $s_c['mark'] = $mark1;
                    Student_Class::create($s_c);
    
                    $s_c['class_id'] = $class->id+1;
                    $s_c['mark'] = $mark2;
                    Student_Class::create($s_c);
                    $j++;
                }
    
                if($mark1 + $mark2 < 60)
                {
                    $s_c['student_id'] = $s_id;
                    $s_c['class_id'] = $class->id;
                    $s_c['mark'] = 0;
                    Student_Class::create($s_c);
    
                    $s_c['student_id'] = $s_id;
                    $s_c['class_id'] = $class->id+1;
                    $s_c['mark'] = 0;
                    Student_Class::create($s_c);
                }
                $indexs[] = $s_id;
            }
        }
    }

    public function AddClasses()
    {
        set_time_limit(2000);
        $subjects = Subject::all();
        
        foreach($subjects as $subject)
        {
            $lecturers = User::whereRoleIs('Lecturer')
                ->whereHas('LecturerRegistredAtCollage',
                    function(Builder $query) use($subject){
                        $query->where('collage_id','=',$subject->collage_id);
                    }
                )
                ->get(['id'])->toArray();

                $ids = [];
                foreach($lecturers as $l)
                {
                    $ids[] = $l['id'];
                }
                $randLecturer = array_rand($ids);
                $l_id = $ids[$randLecturer];

                $semester = [1, 2, 3];
                $rand= array_rand($semester);
                $sem = $semester[$rand];

                $class['subject_id'] = $subject->id;
                $class['lecturer_id'] = $l_id;
                $class['study_year'] = '2019-2020';
                $class['semester_number'] = $sem;
                $class['type'] = 'theoretical';

                _Class::create($class);
                
                $randLecturer = array_rand($ids);
                $l_id = $ids[$randLecturer];
                $class['lecturer_id'] = $l_id;
                $class['type'] = 'practical';
                _Class::create($class); 
                
        }
    }

    public function RegisterStudents()
    {
        set_time_limit(2000);
        ######################
        # for register students in collages
        $students = User::whereRoleIs('Internal_Student')->get();
        $collages = Collage::limit(10)->get();
        $total = [];
        $indexs = [];
        foreach($collages as $col)
        {
            $i=0;
            while($i<105)
            {
                while(true)
                {
                    $stuIndex=rand(0,1049);
                    if(!in_array($stuIndex,$indexs))
                        goto a;
                }
                a:
                $s_c['collage_id'] = $col->id;
                $s_c['student_id'] = $students[$stuIndex]->id;
                $s_c['date_of_registration'] = $this->randomDate(
                        DateTime::createFromFormat('Y-m-d',
                             $students[$stuIndex]->DOB)->modify('+18 years')->format('Y-m-d'),
                             DateTime::createFromFormat('Y-m-d',
                                  $students[$stuIndex]->DOB)->modify('+20 years')->format('Y-m-d'));
                $indexs[] = $stuIndex;
                $total[] = $s_c;
                Student_Collage::create($s_c);
                $i++;
            }
        }
        dd($total);
    }

    public function RegisterLecturers()
    {
        ######################
        # for register lecturers in collages
        $lecturers = User::whereRoleIs('Lecturer')->get();
        $collages = Collage::limit(12)->get();
        $total = [];
        foreach($collages as $col)
        {
            $i=0;
            $indexs = [];
            while($i<12)
            {
                while(true)
                {
                    $lecIndex=rand(0,49);
                    if(!in_array($lecIndex,$indexs))
                        goto a;
                }
                a:
                $c_l['collage_id'] = $col->id;
                $c_l['lecturer_id'] = $lecturers[$lecIndex]->id;
                $c_l['date_of_registration'] = $this->randomDate(
                            DateTime::createFromFormat('Y-m-d', 
                                $lecturers[$lecIndex]->DOB)->modify('+20 years')->format('Y-m-d'),'2012-1-1');
                $indexs[] = $lecIndex;
                
                $total[] = $c_l['date_of_registration'].' | '.$lecturers[$lecIndex]->DOB;
                Collage_Lecturer::create($c_l);
                $i++;
            }
        }
        dd($total);
    }

    public function addCollagesAndSubjectsAndCoursesAndReferencesAndEventsAndComplaints()
    {
        set_time_limit(2000);
        ######################
        # for insert collages, subjects, categories, courses, references, events, complaints
        # Links:
        #   Collages:
        #       https://www.kaggle.com/ananta/student-performance-dataset?select=Department_Information.csv
        #   Subjects:
        #       https://www.indiaeducation.net/engineering/engineering-branch/list/aerospace-engineering.html
        #       https://www.iitk.ac.in/new/biological-sciences-bioengineering
        #       https://www.ucas.com/explore/subjects/chemical-engineering
        #       https://www.thoughtco.com/chemistry-major-courses-606437
        #       https://educatingengineers.com/degrees/civil-engineering
        #       https://www.shiksha.com/engineering/computer-science-engineering-chp
        #       https://www.bachelorsportal.com/studies/112479/earth-system-science.html#content:contents
        #       https://www.shiksha.com/engineering/electrical-engineering-chp
        #       http://www.besteduchina.com/new_energy_and_engineering.html
        #       https://www.rossmoyne.wa.edu.au/programs/learning-areas/humanities-and-social-sciences/
        #       https://ocw.mit.edu/courses/mathematics/
        #       http://sdc.ac.in/sdit/index.php/departments/mechanical-engineering/subjects/
        #   Categories:
        #       https://alison.com/courses/categories
        #   Courses:
        #       https://www.kaggle.com/mihirs16/coursera-course-data?select=coursera-course-detail-data.csv
        #   References:
        #       From Google Scholar Using (Publish or Perish 7) Tool
        #   Events: (P.S: Not Inserted To DB)
        #       https://data.world/cityofchicago/38sz-xyf4/workspace/file?filename=public-health-department-events-1.csv
        #   Complaints:
        #       Handly Collecting

        $row = 0;
        
        if (($handle = fopen("C:\\Users\\Yazan\\Downloads\\complaints.csv", "r")) !== FALSE) 
        {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {
                $num = count($data);
                
                if($row > 0)
                {
                    
                    #Complaints
                    // $comp['complaint_text'] = $data[0];
                    // if($data[1] == 'ذكر')
                    //     $comp['student_id'] = User::whereRoleIs('Internal_Student')->where('gender','male')->inRandomOrder()->first()->id;
                    // else if($data[1] == 'انثى')
                    //     $comp['student_id'] = User::whereRoleIs('Internal_Student')->where('gender','female')->inRandomOrder()->first()->id;
                    // else
                    //     $comp['student_id'] = User::whereRoleIs('Internal_Student')->inRandomOrder()->first()->id;
                    // Complaint::create($comp);
                    
                    #Events
                    // $event['name'] = $data[0];
                    // $event['started_at'] = date('Y-m-d H:i:s',strtotime($data[1]));
                    // $event['ended_at'] = date('Y-m-d H:i:s',strtotime($data[2]));
                    // $event['location'] = $data[3].', '.$data[4];
                    // $event['description'] = $data[5];
                    // $event['image'] = rand(1,5).'.jpg';
                    // Event::create($event);

                    #References
                    // $ref['author'] = $data[1];
                    // $ref['title'] = $data[2];
                    // $ref['publish_year'] = intval($data[3]);
                    // $ref['publisher'] = $data[5];
                    // $ref['category'] = "Programming";
                    // $ref['pdf_file'] = "reference.pdf";
                    // $ref['description'] = $data[23]." More details in: ".$data[6];
                    // Reference::create($ref);

                    # Courses
                    // $lecturers = User::whereRoleIs('Lecturer')
                    // ->whereHas('LecturerRegistredAtCollage')
                    // ->get(['id'])->toArray();

                    // $L_ids = [];
                    // foreach($lecturers as $l)
                    // {
                    //     $L_ids[] = $l['id'];
                    // }
                    // $randLecturer = array_rand($L_ids);
                    // $l_id = $L_ids[$randLecturer];

                    // $cats = explode(', ',trim($data[5],"[]"));
                    // foreach($cats as $c)
                    //     $categories[] = trim($c,"''");

                    // $randC = array_rand($categories);
                    // $category = $categories[$randC];
                
                    // $c = Category::where('name','like','%'.$category.'%')
                    //     ->whereNotNull('parent_id')
                    //     ->get(['id','name'])->toArray();
                    // $ids = [];
                    // foreach($c as $s)
                    // {
                    //     $ids[] = $s['id'];
                    // }
                    // if(count($ids))
                    // {   
                    //     $course['title'] = $data[1];
                    //     $randCat = array_rand($ids);
                    //     $c_id = $ids[$randCat];
                    //     $course['category_id'] = $c_id;
                    //     $course['lecturer_id'] = $l_id;
                    //     $course['description'] = 'More Description About This Course in '.$data[2];
                    //     $course['level'] = $data[4];
                    //     $course['skills'] = 'More Details About This Course in '.$data[2];
                    //     $course['duration'] = rand(10,30).' Hours';
                    //     $course['cost'] = rand(0,50);
                    //     $course['rate'] = 0;
                    //     $course['image'] = NULL;
                    //     Course::create($course);
                    //     $courses[] = $course;
                    // }

                    # Categories
                    // $cat['parent_id'] = $data[0];
                    // $cat['name'] = $data[1];
                    // $cat['image'] = 'null';
                    // dd($cat);
                    // Category::create($cat);

                    #Subjects
                    // $sub = Subject::findOrFail($row);
                    // $sub->name_ar = $data[0];
                    // $sub->update();

                    // $sub['collage_id'] = 18;
                    // $sub['name_en'] = $data[1];
                    // $sub['name_ar'] = $data[0];
                    // dd($sub);
                    // Subject::create($sub);

                    #Collages
                    // $col['name_ar']  = $col['name_en'] = $col['description'] =$data[1];
                    // $col['image'] = 'null';
                    // Collage::create($col);
                }
                $row++;
            }
            fclose($handle);
        }
        
    }

    public function addUsers()
    {
        
        ###################
        # for insert users
        # Generated With:
        #   https://www.generatedata.com/
        ###################

        $data = DB::table('myuserstable')->get();
        // dd($data);
        foreach($data as $d)
        {
            // dd($d);
            $user = (array)$d;

            $user['middle_name'] = '';
            // $user['active'] = 0;
            $user['email'] = $user['email'];
            $user['username'] = strtolower($user['first_name']).rand(1,200000);
            $user['address'] = $user['city'].', '.$user['street_address'];
            $user['password'] = Hash::make('password');

            $done = User::create($user);
            $done->syncRoles(['Internal_student']);
            $user = NULL;
            $done = NULL;
        }
    }
    
    public function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d', $val);
    }
}
