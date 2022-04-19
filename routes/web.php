<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::fallback(function(){
    return view('FrontEnd.Public.404');
});


Auth::routes(['verify'=>true]);

Route::get('/','IndexController@index')->name('/');
Route::get('/single-course/{id}','IndexController@element');
Route::get('/single_event/{id}','IndexController@event');
Route::get('/all_courses','IndexController@showallCourses')->name('searchCourse');
Route::get('/all_events','IndexController@all_events');
Route::get('/user/{id}','IndexController@user')->name('user');
Route::get('/all_lecturers','IndexController@allUsers')->name('SearchUsers');
Route::get('/all_advertisements','IndexController@allAdvertisements');
Route::get('/single_advertisements/{id}','IndexController@ad');
Route::get('/library','IndexController@library')->name('library');
Route::get('/book/{id}','IndexController@book');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/account','ProfileController@profile')->name('account');
    Route::post('/profileUpdate','ProfileController@update')->name('profile.update');
    Route::get('/profile-page','ProfileController@profilePage')->name('profilePage');
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Temporary Route To Add Data To DB
// Route::get('add','AdminBaseController@addToDb');
// Route::get('del','AdminBaseController@del');
Route::get('python','AdminBaseController@testPython');

//SuperAdministrator Space
Route::group(['middleware' => ['role:superadministrator']], function() {
    
    Route::get('/sa-collages','SuperadministratorProfileController@Collages')->name('SA-Collages');
    Route::get('/sa-collage/{id}','SuperadministratorProfileController@CollageDetails')->name('CollageDetails');
    Route::get('/sa-courses','SuperadministratorProfileController@Courses')->name('SA-Courses');
    Route::get('/sa-category/{id}','SuperadministratorProfileController@CategoryDetails')->name('CategoryDetails');
    Route::get('/sa-events','SuperadministratorProfileController@Events')->name('SA-Events');
    Route::get('/sa-references','SuperadministratorProfileController@References')->name('SA-References');
    Route::get('/sa-pages','SuperadministratorProfileController@Pages')->name('SA-Pages');
    Route::get('/sa-complaints','SuperadministratorProfileController@Complaints')->name('SA-Complaints');

});

//Lecturer
Route::group(['middleware' => ['role:Lecturer']], function() {

    Route::get('/lecturer-courses','LecturerProfileController@LecCourses')->name('LecCourses');
    Route::get('/courseRequests/{id}','LecturerProfileController@CourseRequests')->name('courseRequests');
    Route::post('/block-req','LecturerProfileController@BlockReq')->name('BlockReq');
    Route::post('/accept-req','LecturerProfileController@AcceptReq')->name('AcceptReq');
    Route::get('/lecturer-classes','LecturerProfileController@LecClasses')->name('LecClasses');
    Route::get('/classe-lectures/{id}','LecturerProfileController@ClassLectures')->name('ClassLectures');
    Route::post('/add-lecture','LecturerProfileController@AddLecture')->name('AddLecture');
    Route::post('/update-lecture','LecturerProfileController@UpdateLecture')->name('UpdateLecture');
    Route::post('/del-lecture','LecturerProfileController@DeleteLecture')->name('DeleteLecture');
    Route::post('/del-lecPDF','LecturerProfileController@delLecPDF')->name('delLecPDF');

    Route::post('/add-course','LecturerProfileController@AddCourse')->name('AddCourse');
    Route::post('/update-course','LecturerProfileController@UpdateCourse')->name('UpdateCourse');
    Route::post('/del-course','LecturerProfileController@DeleteCourse')->name('DeleteCourse');
    Route::post('/del-course-image','LecturerProfileController@delCouImg')->name('delCouImg');

    Route::get('/topics-for-course/{id}','LecturerProfileController@courseTopics')->name('courseTopics');
    Route::post('/update-topic','LecturerProfileController@UpdateTopic')->name('UpdateTopic');
    Route::post('/del-topic','LecturerProfileController@DeleteTopic')->name('DeleteTopic');

    Route::get('/contents-for-topic/{id}','LecturerProfileController@TopicContents')->name('TopicContents');
    Route::post('/update-content','LecturerProfileController@UpdateContent')->name('UpdateContent');
    Route::post('/del-content','LecturerProfileController@DeleteContent')->name('DeleteContent');
    Route::post('/del-content-video','LecturerProfileController@delCouVid')->name('delCouVid');
    Route::post('/del-content-appendix','LecturerProfileController@delCouApp')->name('delCouApp');

});

//Librarian Space
Route::group(['middleware' => ['role:Librarian']], function() {



});

//Students Space
Route::group(['middleware' => ['role:Internal_student|External_student']], function() {

    Route::get('/content/{id}','IndexController@coursevideos')->name('courseVideos');
    Route::post('reg-course', 'IndexController@registerInCourse')->name('student.reg');

});

//Internal Students Space
Route::group(['middleware' => ['role:Internal_student']], function() {

    Route::post('event-going', 'IndexController@goToEvent')->name('event.going');
    Route::get('/active-courses','StudentProfileController@activeCourses')->name('activeCourses');
    Route::get('/other-courses','StudentProfileController@otherCourses')->name('otherCourses');
    Route::get('/classes','StudentProfileController@Classes')->name('Classes');
    Route::get('/class-lecs/{id}','StudentProfileController@StudClassLectures')->name('StudClassLectures');
    Route::get('/fav-lecs','StudentProfileController@FavLecs')->name('Fav-Lecs');
    Route::get('/fav-refs','StudentProfileController@FavRefs')->name('Fav-Refs');
    Route::get('/fav-projs','StudentProfileController@FavProjs')->name('Fav-Projs');
    Route::post('/RemoveLecFromFav','StudentProfileController@RemoveLecFromFavourite')->name('rmv-lec-from-fav');
    Route::post('/AddLecToFavourite','StudentProfileController@AddLecToFavourite')->name('add-lec-to-fav');
    Route::post('/RemoveRefFromFav','StudentProfileController@RemoveRefFromFavourite')->name('rmv-ref-from-fav');
    Route::post('/AddRefToFav','StudentProfileController@AddRefToFavourite')->name('add-ref-to-fav');
    Route::post('/RemoveProjFromFav','StudentProfileController@RemoveProjFromFavourite')->name('rmv-proj-from-fav');
    Route::post('/AddProjToFav','StudentProfileController@AddProjToFavourite')->name('add-proj-to-fav');
    Route::post('rate', 'IndexController@rate')->name('rate');
    Route::get('scan-qr-code', 'StudentProfileController@ScanQrCode')->name('scanQR');
    Route::get('check-in-by-scan', 'StudentProfileController@CheckInLecture')->name('checkInLec');
    Route::post('/send-complaint','StudentProfileController@sendComplaint')->name('sendComplaint');
    Route::get('/lib-projects', 'IndexController@libProjects')->name('libProjects');
    Route::get('/project/{id}', 'IndexController@Project')->name('project');


});

//Admin Space
Route::group(['prefix' => 'management', 'middleware' => ['role:superadministrator|Librarian|Employee|Lecturer']], function() {

    Route::get('/', 'AdminController@index')->name('management');
    /// Setting Area
    Route::get('settings', 'AdminController@settings')->name('settings');
    Route::get('/check-pwd','AdminController@chkPassword')->name('chkPassword');
    Route::post('/update-pwd','AdminController@updatAdminPwd')->name('updatAdminPwd');
    Route::group(['middleware' => ['role:superadministrator|Librarian|Lecturer']], function() {

        /// References Area
        Route::resource('/references', 'ReferencesController');
        Route::get('delete-ref/{id}','ReferencesController@destroy');
        Route::get('delete-ref-pdf/{id}','ReferencesController@deletefile');
        Route::get('delete-reference-img/{id}','ReferencesController@deleteImage');

        /// LibProjects Area
        Route::resource('/lib_projects', 'LibProjectsController');
        Route::get('delete-lib/{id}','LibProjectsController@destroy');
        Route::get('delete-lib-pdf/{id}','LibProjectsController@deletefile');
    });

    Route::group(['middleware' => ['role:superadministrator|Lecturer']], function() {

        /// Courses Area
        Route::resource('/courses', 'CoursesController');
        Route::get('delete-course/{id}','CoursesController@destroy');
        Route::get('delete-cour-img/{id}','CoursesController@deleteImage');
        Route::get('get-courses-by-lec/{lec_id}','CoursesController@getCoursesByLec')->name('getCoursesByLec');
        Route::get('get-courses-by-cat/{cat_id}','CoursesController@getCoursesByCat')->name('getCoursesByCat');
        Route::get('requests','CoursesController@getRequests')->name('courses.requests');
        Route::get('courseRequests/{id}','CoursesController@courseRequests')->name('courses.courseRequests');
        Route::get('acceptRequest/{id}','CoursesController@acceptRequest')->name('courses.acceptRequest');
        Route::get('BlockRequest/{id}','CoursesController@BlockRequest')->name('courses.BlockRequest');
        
        /// Topics Area
        Route::resource('/topics', 'TopicsController');
        Route::get('delete-topic/{id}','TopicsController@destroy');
        Route::get('get-topics-by-course/{cou_id}','TopicsController@getTopicsByCourse')->name('getTopicsByCourse');

        /// Contents Area
        Route::resource('/contents', 'ContentsController');
        Route::get('delete-cont/{id}','ContentsController@destroy');
        Route::get('delete-cont-vid/{id}','ContentsController@deleteVideo');
        Route::get('delete-cont-appendix/{id}','ContentsController@deleteAppendix');
        Route::get('get-contents-by-topic/{topic_id}','ContentsController@getContentsByTopic')->name('getContentsByTopic');
        
        /// Lectures Area
        Route::resource('/lectures', 'LecturesController');
        Route::get('delete-lec/{id}','LecturesController@destroy');
        Route::get('delete-lec-pdf/{id}','LecturesController@deletefile');
        Route::get('get-lectures-by-class/{cla_id}','LecturesController@getLecturesByClass')->name('getLecturesByClass');

    });

    Route::group(['middleware' => ['role:superadministrator|Employee']], function() {

        /// Events Area
        Route::resource('/events', 'EventsController');
        Route::get('delete-event/{id}','EventsController@destroy');
        Route::get('delete-event-img/{id}','EventsController@deleteImage');

        /// Advertisements Area
        Route::resource('/advertisements', 'AdvertisementsController');
        Route::get('delete-adv/{id}','AdvertisementsController@destroy');
        Route::get('delete-ads-image/{id}','AdvertisementsController@deleteImage');
        
    });

    Route::group(['middleware' => ['role:superadministrator']], function() {

        
        /// Users Area
        Route::resource('/users', 'UsersController')->except(['destroy']);
        Route::get('/user-activate/{id}','UsersController@ActivateUser')->name('ActivateUser');
        Route::get('/users-type/{id}','UsersController@UsersType')->name('usersByRole');
        Route::get('/user-deactivate/{id}','UsersController@DeactivateUser')->name('DeactivateUser');
        Route::get('/user-block/{id}','UsersController@BlockUser')->name('BlockUser');
        Route::get('/user-unblock/{id}','UsersController@unblockUser')->name('unblockUser');
        /// Checkers
        Route::get('/check_user_name','UsersController@checkUserName');
        Route::get('/check_email','UsersController@checkEmail');
        // Route::get('/check_phone','UsersController@checkPhone');

        /// Collages Area
        Route::resource('/collages', 'CollagesController');
        Route::get('delete-col/{id}','CollagesController@destroy');
        Route::get('delete-col-image/{id}','CollagesController@deleteImage');

        /// Subjects Area
        Route::resource('/subjects', 'SubjectsController');
        Route::get('delete-sub/{id}','SubjectsController@destroy');
        Route::get('get-subjects-by-col/{id}','SubjectsController@getSubjectsByCol')->name('getSubjectsByCol');

        /// Classes Area
        Route::resource('/classes', 'ClassesController');
        Route::get('delete-class/{id}','ClassesController@destroy');
        Route::get('get-classes-by-sub/{sub_id}/{year}','ClassesController@getClassesBySub')->name('getClassesBySub');
        Route::get('get-classes-for-student/{student_id}','ClassesController@getClassesForRegStudent')->name('getClassesForRegStudent');
        Route::get('get-classes-by-lecturer/{lecturer_id}','ClassesController@getClassesByLecturer')->name('getClassesByLecturer');


        /// Categories Area
        Route::resource('/categories', 'CategoriesController');
        Route::get('delete-cat/{id}','CategoriesController@destroy');
        Route::get('delete-cat-img/{id}','CategoriesController@deleteImage');
        
        /// Complaints Area
        Route::resource('/complaints', 'ComplaintsController')->only(['index']);

    });
});
