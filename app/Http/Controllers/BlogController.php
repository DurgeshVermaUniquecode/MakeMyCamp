<?php

namespace App\Http\Controllers;
use Intervention\Image\Drivers\Imagick\Driver;

use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function categoryIndex(Request $request)
    {

        if ($request->ajax()) {
            $query = BlogCategory::latest();

            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }


            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Active') {
                        return '<span class="badge bg-success">Active</span>';
                    } elseif ($row->status == 'Inactive') {
                        return '<span class="badge bg-danger">Inactive</span>';
                    } else {
                        return '<span class="badge bg-secondary">' . $row->status . '</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="' . route('blog_categories_edit', [$row->id]) . '"><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteCategory(' . $row->id . ')"
                                ><i class="icon-base ti tabler-exchange me-1"></i> Change Status</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('blog.category.view');
    }


    public function categoryCreate()
    {
        return view('blog.category.add');
    }
    
    public function categoryStore(Request $request)
    {
        $request->slug = Str::slug($request->name);
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'image' => 'nullable|image|max:2048',
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = $request->slug;
        if ($request->hasFile('image')) {
            $manager = ImageManager::withDriver(new Driver());
            $image = $request->file('image');
            $filename = time() . '_' . $category->slug . '.' . $image->getClientOriginalExtension();
            $destination = public_path('blog/category');
            $manager->read($image->getPathname())->resize(200, 200)->save($destination . '/' . $filename);
            $category->image = $imagePath;
        }
        $category->save();

        return redirect()->route('blog_categories')->with(['status' => 'success', 'message' => 'Category created successfully.']);
    }

    public function categoryEdit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('blog.category.edit', compact('category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->slug = Str::slug($request->slug);
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'image' => 'nullable|image|max:2048',
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        if ($request->hasFile('image')) {
            $manager = ImageManager::withDriver(new Driver());
            $filename = time() . '_' . $category->slug . '.' . $image->getClientOriginalExtension();
            $destination = public_path('blog/category');
            $manager->read($image->getPathname())->resize(200, 200)->save($destination . '/' . $filename);
            $category->image = $imagePath;
        }
        $category->save();

        return redirect()->route('blog_categories')->with(['status' => 'success', 'message' => 'Category updated successfully.']);
    }

    public function categoryUpdateStatus($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->status = $category->status === 'Active' ? 'Inactive' : 'Active';
        $category->save();
        return redirect()->route('blog_categories')->with(['status' => 'success', 'message' => 'Category status chnage successfully.']);
    }



    public function blogIndex(Request $request)
    {

        if ($request->ajax()) {
            $query = Blog::with('category')->latest();

            if ($request->has('title') && !empty($request->name)) {
                $query->where('title', 'like', '%' . $request->name . '%');
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category_name', function ($row) {
                    return $row->category?->name ?? '-';
                })
                ->addColumn('image', function ($row) {
                    return '<img src="'.asset("blog/".$row->image).'" alt="Image" class="img-fluid rounded-1" style="width: 30px;" onclick="openImageModal(\'' .asset("blog/".$row->image). '\')">';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Schedule' || $row->status == 'Publish') {
                        return '<span class="badge bg-success">'.$row->status.'</span>';
                    } elseif ($row->status == 'Deleted') {
                        return '<span class="badge bg-danger">'.$row->status.'</span>';
                    } else {
                        return '<span class="badge bg-secondary">' . $row->status . '</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="' . route('blog_edit', [$row->id]) . '"><i class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteBlog(' . $row->id . ')"><i class="icon-base ti tabler-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('blog.view');
    }


    public function blogCreate()
    {
        $categories = BlogCategory::where('status', 'Active')->get();
        return view('blog.add', compact('categories'));
    }


    public function blogStore(Request $request)
    {
        $request->slug = Str::slug($request->title);
     
        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title',
            'content' => 'required',
            'category' => 'required|exists:blog_categories,id',
            'image' => 'required|image|max:2048',
            'schedule_date' => 'required|date',
            'status' => 'required',
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->content = $request->content;
        $blog->category_id = $request->category;
        $blog->publish_datetime = $request->schedule_date;
        if ($request->hasFile('image')) {
            $manager = ImageManager::withDriver(new Driver());
            $filename = time() . '_' . $blog->slug . '.' . $image->getClientOriginalExtension();
            $destination = public_path('blog');
            $manager->read($image->getPathname())->resize(411, 320)->save($destination . '/' . $filename);
            $blog->image = $imagePath;
        }
        $blog->status = $request->status;
        $blog->save();

        return redirect()->route('blog_list')->with(['status' => 'success', 'message' => 'Blog created successfully.']);
    }

  
    public function blogEdit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::where('status', 1)->get();
        return view('blog.edit', compact('blog', 'categories'));
    }


    public function blogUpdate(Request $request, $id)
    {
        $request->slug = Str::slug($request->title);

        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title,' . $id . ',id',
            'content' => 'required',
            'category' => 'required|exists:blog_categories,id',
            'image' => 'required|image|max:4048',
            'schedule_date' => 'nullable|date',
            'status' => 'required',
        ]);

        $blog = Blog::findOrFail($id);
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->content = $request->content;
        $blog->category_id = $request->category;
        $blog->publish_datetime = $request->schedule_date;
        if ($request->hasFile('image')) {
            $manager = ImageManager::withDriver(new Driver());
            $filename = time() . '_' . $blog->slug . '.' . $image->getClientOriginalExtension();
            $destination = public_path('blog');
            $manager->read($image->getPathname())->resize(411, 320)->save($destination . '/' . $filename);
            $blog->image = $imagePath;
        }
        $blog->status = $request->status;
        $blog->save();

        return redirect()->route('blog_list')->with(['status' => 'success', 'message' => 'Blog updated successfully.']);
    }

    // Blog: Delete
    public function blogDestroy($id)
    {
        $blog = Blog::findOrFail($id);
        $check = $blog->delete();
        return $check;
    }

}
