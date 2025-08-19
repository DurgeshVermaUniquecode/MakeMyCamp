<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CoursesContoller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CRMController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Controller;



Auth::routes();


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register-otp', [RegisterController::class, 'registerOtp'])->name('register.otp');
Route::get('/register-verification', [RegisterController::class, 'registerVerification'])->name('register.verification');
Route::post('/register', [RegisterController::class, 'register'])->name('register.create');;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/privacy', [HomeController::class, 'static_content'])->name('privacy');
Route::get('/terms', [HomeController::class, 'static_content'])->name('terms');
Route::get('/about-us', [HomeController::class, 'static_content'])->name('about-us');
Route::get('/our-services', [HomeController::class, 'static_content'])->name('our-services');
Route::get('/training', [HomeController::class, 'static_content'])->name('training');
Route::get('/videos', [HomeController::class, 'videos'])->name('videos');
Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact_us');
Route::post('/contact-submit', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogs');
Route::get('/blog/{slug}', [HomeController::class, 'blogDetails'])->name('blog_details');

Route::get('states/{country_id}', [Controller::class, 'states'])->name('states');
Route::get('cities/{state_id}', [Controller::class, 'cities'])->name('cities');

Route::get('/show-pdf/{url}', function($url) {
    return response()->file(storage_path($url));
})->name('show-pdf');

Route::middleware(['roleAuth:Admin'])->group(function () {


    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'index']);
    });


    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');


    Route::prefix('account')->group(function () {
        Route::match(['get', 'post'],'profile', [UserController::class, 'profile'])->name('view_profile');
        Route::match(['get', 'post'], 'profile/{id}', [UserController::class, 'edit_profile'])->name('edit_profile');
        Route::match(['get', 'post'],'change-password', [UserController::class, 'change_password'])->name('change_password');
        Route::get('notifications', [UserController::class, 'notifications'])->name('notifications');
        Route::get('business-plan', [UserController::class, 'business_plan'])->name('business_plan');
    });


    Route::prefix('users')->group(function () {
        Route::match(['get', 'post'], 'list/{type}', [UserController::class, 'userList'])->name('user_list');
        Route::get('view/{id}', [UserController::class, 'viewUser'])->name('view_user');
        Route::match(['get', 'post'], 'add/{type}', [UserController::class, 'addUsers'])->name('add_user');
        Route::match(['get', 'post'], 'edit/{type}/{id}', [UserController::class, 'editUser'])->name('edit_user');
        Route::match(['get', 'post'], 'status/{id}', [UserController::class, 'statusUser'])->name('status_user');
    });

    Route::prefix('users-packages')->group(function () {
        Route::match(['get', 'post'], 'list', [UserController::class, 'userPackageList'])->name('user_package_list');
        Route::match(['get', 'post'], 'add', [UserController::class, 'addUserPackage'])->name('add_user_package');
        Route::match(['get', 'post'], 'edit/{id}', [UserController::class, 'editUserPackage'])->name('edit_user_package');
        Route::match(['get', 'post'], 'status/{id}', [UserController::class, 'statusUserPackage'])->name('status_user_package');
    });

    Route::prefix('users-steps')->group(function () {
        Route::match(['get', 'post'], 'list', [UserController::class, 'userStep'])->name('user_step_list');
        Route::match(['get', 'post'], 'edit/{id}', [UserController::class, 'editStep'])->name('edit_user_step');
    });

    Route::prefix('packages')->group(function () {
        Route::match(['get', 'post'], 'list', [CoursesContoller::class, 'packageList'])->name('package_list');
        Route::match(['get', 'post'], 'add', [CoursesContoller::class, 'addPackage'])->name('add_package');
        Route::match(['get', 'post'], 'edit/{id}', [CoursesContoller::class, 'editPackage'])->name('edit_package');
        Route::match(['get', 'post'], 'status/{id}', [CoursesContoller::class, 'statusPackage'])->name('status_package');
    });

    Route::prefix('business-categories')->group(function () {
        Route::match(['get', 'post'], 'list', [CoursesContoller::class, 'businessCategoriesList'])->name('business_categories_list');
        Route::match(['get', 'post'], 'add', [CoursesContoller::class, 'addBusinessCategory'])->name('add_business_category');
        Route::match(['get', 'post'], 'edit/{id}', [CoursesContoller::class, 'editBusinessCategory'])->name('edit_business_category');
        Route::match(['get', 'post'], 'status/{id}', [CoursesContoller::class, 'statusBusinessCategory'])->name('status_business_category');
    });


    Route::prefix('courses')->group(function () {
        Route::match(['get', 'post'], 'list', [CoursesContoller::class, 'coursesList'])->name('course_list');
        Route::match(['get', 'post'], 'add', [CoursesContoller::class, 'addCourses'])->name('add_course');
        Route::match(['get', 'post'], 'edit/{id}', [CoursesContoller::class, 'editCourses'])->name('edit_course');
        Route::match(['get', 'post'], 'status/{id}', [CoursesContoller::class, 'statusCourses'])->name('status_course');
    });


    Route::prefix('leads')->group(function () {
        Route::match(['get', 'post'], 'list', [CRMController::class, 'leadsList'])->name('lead_list');
        Route::match(['get', 'post'], 'add', [CRMController::class, 'addLeads'])->name('add_lead');
        Route::match(['get', 'post'], 'edit/{id}', [CRMController::class, 'editLeads'])->name('edit_lead');
        Route::post('assign-employee', [CRMController::class, 'assignEmployeeLead'])->name('assign_employee_lead');
        Route::match(['get', 'post'], 'follow-up/{lead_id}', [CRMController::class, 'leadFollowUp'])->name('lead_follow_up');
        Route::post('status', [CRMController::class, 'statusLead'])->name('status_lead');
    });

    Route::prefix('tasks')->group(function () {
        Route::match(['get', 'post'], 'list', [CRMController::class, 'taskList'])->name('task_list');
        Route::match(['get', 'post'], 'add', [CRMController::class, 'addTasks'])->name('add_task');
        Route::match(['get', 'post'], 'edit/{id}', [CRMController::class, 'editTask'])->name('edit_task');
        Route::post('status', [CRMController::class, 'statusTask'])->name('status_task');
    });



    Route::prefix('document-type')->group(function () {
        Route::match(['get', 'post'], 'list', [CRMController::class, 'documentTypeList'])->name('document_type_list');
        Route::match(['get', 'post'], 'add', [CRMController::class, 'addDocumentType'])->name('add_document_type');
        Route::match(['get', 'post'], 'edit/{id}', [CRMController::class, 'editDocumentType'])->name('edit_document_type');
        Route::get('status/{id}', [CRMController::class, 'statusDocumentType'])->name('status_document_type');
    });

    Route::prefix('user-document')->group(function () {
        Route::match(['get', 'post'], 'list', [CRMController::class, 'userDocument'])->name('user_document_list');
        Route::match(['get', 'post'], 'add', [CRMController::class, 'addUserDocument'])->name('add_user_document');
        Route::match(['get', 'post'], 'edit/{id}', [CRMController::class, 'editUserDocument'])->name('edit_user_document');
        Route::get('status/{id}', [CRMController::class, 'statusUserDocument'])->name('status_user_document');
        Route::get('delete/{id}', [CRMController::class, 'deleteUserDocument'])->name('delete_user_document');
    });


    Route::prefix('manage-blogs')->group(function () {
        Route::get('categories', [BlogController::class, 'categoryIndex'])->name('blog_categories');
        Route::get('create-categories', [BlogController::class, 'categoryCreate'])->name('blog_categories_create');
        Route::post('create-categories', [BlogController::class, 'categoryStore'])->name('blog_categories_store');
        Route::get('categories/{id}', [BlogController::class, 'categoryEdit'])->name('blog_categories_edit');
        Route::post('categories/{id}', [BlogController::class, 'categoryUpdate'])->name('blog_categories_update');
        Route::get('categories-update-status/{id}', [BlogController::class, 'categoryUpdateStatus'])->name('blog_categories_update_status');

        Route::get('blogs', [BlogController::class, 'blogIndex'])->name('blog_list');
        Route::get('create-blog', [BlogController::class, 'blogCreate'])->name('blog_create');
        Route::post('create-blog', [BlogController::class, 'blogStore'])->name('blog_store');
        Route::get('blog/{id}', [BlogController::class, 'blogEdit'])->name('blog_edit');
        Route::post('blog/{id}', [BlogController::class, 'blogUpdate'])->name('blog_update');
        Route::get('delete-blog/{id}', [BlogController::class, 'blogDestroy'])->name('blog_destroy');
    });


    Route::prefix('settings')->group(function () {
        Route::match(['get', 'post'], 'static-content/{type}', [SettingController::class, 'staticContent'])->name('static_content');

        //steps master
        Route::match(['get', 'post'], 'steps-master', [SettingController::class, 'stepsMaster'])->name('steps_master');

        Route::prefix('steps-master')->group(function () {
            Route::match(['get', 'post'], 'list', [SettingController::class, 'stepsList'])->name('steps_list');
            Route::match(['get', 'post'], 'add', [SettingController::class, 'addSteps'])->name('add_step');
            Route::match(['get', 'post'], 'edit/{id}', [SettingController::class, 'editSteps'])->name('edit_steps');
            Route::get('status/{id}', [SettingController::class, 'statusSteps'])->name('status_steps');
        });


        Route::get('update-config', [SettingController::class, 'editConfig'])->name('edit_config');
        Route::post('update-config', [SettingController::class, 'updateConfig'])->name('update_config');

        Route::prefix('image')->group(function () {
            Route::get('list', [SettingController::class, 'imageList'])->name('image_list');
            Route::get('create', [SettingController::class, 'imageCreate'])->name('image_create');
            Route::post('store', [SettingController::class, 'imageStore'])->name('image_store');
            Route::get('edit/{id}', [SettingController::class, 'imageEdit'])->name('image_edit');
            Route::post('update/{id}', [SettingController::class, 'imageUpdate'])->name('image_update');
            Route::get('update-status/{id}', [SettingController::class, 'imageUpdateStatus'])->name('image_update_status');
        });

        Route::prefix('video')->group(function () {
            Route::get('list', [SettingController::class, 'videoList'])->name('video_list');
            Route::get('create', [SettingController::class, 'videoCreate'])->name('video_create');
            Route::post('store', [SettingController::class, 'videoStore'])->name('video_store');
            Route::get('edit/{id}', [SettingController::class, 'videoEdit'])->name('video_edit');
            Route::post('update/{id}', [SettingController::class, 'videoUpdate'])->name('video_update');
            Route::get('update-status/{id}', [SettingController::class, 'videoUpdateStatus'])->name('video_update_status');
        });


        Route::prefix('faq')->group(function () {
            Route::get('list', [SettingController::class, 'faqList'])->name('faq_list');
            Route::get('create', [SettingController::class, 'addFaq'])->name('add_faq');
            Route::post('create', [SettingController::class, 'faqStore'])->name('faq_store');
            Route::get('edit/{id}', [SettingController::class, 'editFaq'])->name('edit_faq');
            Route::post('update/{id}', [SettingController::class, 'updateFaq'])->name('update_faq');
            Route::get('delete/{id}', [SettingController::class, 'deleteFaq'])->name('delete_faq');
            Route::get('status/{id}', [SettingController::class, 'statusFaq'])->name('status_faq');
        });
    });

    Route::prefix('commission')->group(function () {
        Route::match(['get', 'post'], 'list', [UserController::class, 'commission'])->name('commission');
    });

    Route::prefix('loans')->group(function () {
        Route::match(['get', 'post'], 'list', [LoanController::class, 'loans'])->name('loans');
        Route::match(['get', 'post'], 'add', [LoanController::class, 'addLoans'])->name('add_loan');
        Route::match(['get', 'post'], 'assign', [LoanController::class, 'assignEmployeeLoan'])->name('assign_employee_loan');
        Route::match(['get', 'post'], 'change-status', [LoanController::class, 'changeLoanStatus'])->name('change_loan_status');
        Route::match(['get', 'post'], 'edit/{id}', [LoanController::class, 'editLoan'])->name('edit_loan');
    });

    Route::prefix('support')->group(function () {
        Route::get('list/{status}', [SupportController::class, 'ticketList'])->name('ticket_list');
        Route::get('create', [SupportController::class, 'createTicket'])->name('create_ticket');
        Route::post('store', [SupportController::class, 'storeTicket'])->name('store_ticket');
        Route::post('assign-employee', [SupportController::class, 'assignEmployeeTicket'])->name('assign_employee_ticket');
        Route::get('reply/{id}', [SupportController::class, 'replyTicket'])->name('reply_ticket');
        Route::post('reply/{id}', [SupportController::class, 'storeReplyTicket'])->name('store_reply_ticket');
        Route::get('status/{id}', [SupportController::class, 'statusTicket'])->name('status_support');
    });

    Route::prefix('user/packages')->group(function () {
        Route::get('list', [UserController::class, 'packagesList'])->name('user_packages_list');
        Route::post('buy', [UserController::class, 'buyPackage'])->name('buy_package');
    });

    Route::match(['get','post'],'user-document-list', [UserController::class, 'userDocumentsList'])->name('user_documents_list');
    Route::match(['get','post'],'user-course-list', [UserController::class, 'userCoursesList'])->name('user_courses_list');

    Route::get('read-notifications',[UserController::class, 'readNotifications'])->name('read_notifications');

});
