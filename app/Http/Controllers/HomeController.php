<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaticContent;
use App\Models\Video;
use App\Models\Blog;
use App\Models\ContactUs;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blogs = Blog::with('category')->where(function ($query) {
                                        $query->where('status', 'publish')->orWhere(function ($q) {
                                            $q->where('status', 'schedule')->where('publish_datetime', '<=', now());
                                        });
                                    })->latest()->limit(6)->get();
        return view('front.home',compact('blogs'));
    }

    
    public function static_content()
    {
        $routeName = \Route::currentRouteName();

        $data = StaticContent::where('sc_type', $routeName)->first();
        if(!$data) {
            return back();
        } else {
            return view('static_content', compact('data'));
        }
    }

     
    public function videos()
    {
        $data = Video::where('status', 'Active')->latest()->get();
        return view('video-list',compact('data'));
    } 


    public function blogs(Request $request)
    {
        $data = Blog::with('category')
                ->where(function ($query) {
                    $query->where('status', 'publish')
                        ->orWhere(function ($q) {
                            $q->where('status', 'schedule')
                            ->where('publish_datetime', '<=', now());
                        });
                })
                ->latest()
                ->paginate(6);

        if ($request->ajax()) {
            return view('blog-items', compact('data'))->render();
        }
        return view('blog-list', compact('data'));
    } 

    
    public function blogDetails($slug)
    {
        $blog = Blog::with('category')
                ->where(function ($query) {
                    $query->where('status', 'publish')
                        ->orWhere(function ($q) {
                            $q->where('status', 'schedule')
                            ->where('publish_datetime', '<=', now());
                        });
                })->where('slug', $slug)->first();

        $data = Blog::with('category')
                ->where(function ($query) {
                    $query->where('status', 'publish')
                        ->orWhere(function ($q) {
                            $q->where('status', 'schedule')
                            ->where('publish_datetime', '<=', now());
                        });
                })->where('category_id', $blog->category_id)
                ->latest()
                ->paginate(6);

        return view('blog-details',compact('blog','data'));
    } 

    public function contact_us()
    {
        return view('contact-us');
    } 
   
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'phone'         => ['required', 'regex:/^[6-9]\d{9}$/'],
            'email'         => 'required|email',
            'subject'       => 'required|string|max:150',
            'message'       => 'required|string|max:1000',
            'accept_terms'  => 'accepted'
        ]);

        ContactUs::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Your message has been submitted successfully!');
    }
}
