<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\StaticContent;
use App\Models\Faq;
use App\Models\Steps;
use App\Models\Banner;
use App\Models\Video;
use App\Models\Configuration;
use Illuminate\Support\Str;

class SettingController extends Controller
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

    public function staticContent($type, Request $request)
    {
        $data = StaticContent::where('sc_type', $type)->first();
        if ($request->isMethod('post') && $data) {
            $update = StaticContent::where('sc_type', $type)->update(["sc_title" => $request->title, "sc_desc" => $request->description]);
            if ($update) {
                return back()->with(['status' => 'success', 'message' => 'Content Update Successfully,']);
            } else {
                return back()->with(['status' => 'error', 'message' => 'Content Not Update.']);
            }
        }
        return view('setting.static_content', compact('data'));
    }

    public function faqList(Request $request)
    {
        if ($request->ajax()) {
            $query = Faq::latest();

            if ($request->has('question') && !empty($request->question)) {
                $query->where('question', 'like', '%' . $request->question . '%');
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Active') {
                        return '<span class="badge bg-success">' . $row->status . '</span>';
                    } elseif ($row->status == 'Inactive') {
                        return '<span class="badge bg-danger">' . $row->status . '</span>';
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
                              <a class="dropdown-item" href="' . route('edit_faq', [$row->id]) . '"><i class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteFaq(' . $row->id . ')"><i class="icon-base ti tabler-trash me-1"></i>Delete</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);" onclick="changeFaq(' . $row->id . ')"><i class="icon-base ti tabler-progress-check me-1"></i>Change Status</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('setting.faq.faq_list');
    }


    public function addFaq(Request $request)
    {
        return view('setting.faq.add_faq');
    }


    public function faqStore(Request $request)
    {

        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required|numeric',
        ]);

        Faq::create($request->all());
        return redirect()->route('faq_list')->with(['status' => 'success', 'message' => 'FAQ created successfully.']);
    }

    public function editFaq($id)
    {
        $faq = Faq::findOrFail($id);
        return view('setting.faq.edit_faq', compact('faq'));
    }

    public function updateFaq($id, Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'order_by' => 'required|numeric',
        ]);
        $faq = Faq::findOrFail($id);
        $faq->update($request->all());
        return redirect()->route('faq_list')->with(['status' => 'success', 'message' => 'FAQ updated successfully.']);
    }

    public function deleteFaq($id)
    {
        $faq = Faq::findOrFail($id);
        return $faq->delete();
    }

    public function statusFaq($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->status = $faq->status === 'Active' ? 'Inactive' : 'Active';
        return $faq->save();
    }

    public function editConfig()
    {
        $data = Configuration::where('value_type', 'Value')->get();
        return view('setting.update_config', compact('data'));
    }

    public function updateConfig(Request $request)
    {
        $request->request->remove('_token');
        foreach ($request->all() as $inputKey => $value) {
            $settingKey = str_replace('_', '.', $inputKey);
            Configuration::where('name', $settingKey)->update(['value' => $value]);
        }
        return redirect()->route('edit_config')->with(['status' => 'success', 'message' => 'Configuration updated successfully.']);
    }



    public function ticketList(Request $request)
    {
        if ($request->ajax()) {
            $query = Faq::latest();

            if ($request->has('question') && !empty($request->question)) {
                $query->where('question', 'like', '%' . $request->question . '%');
            }

            if ($request->has('status') && !empty($request->status)) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Active') {
                        return '<span class="badge bg-success">' . $row->status . '</span>';
                    } elseif ($row->status == 'Inactive') {
                        return '<span class="badge bg-danger">' . $row->status . '</span>';
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
                              <a class="dropdown-item" href="' . route('edit_faq', [$row->id]) . '"><i class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteFaq(' . $row->id . ')"><i class="icon-base ti tabler-trash me-1"></i>Delete</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);" onclick="changeFaq(' . $row->id . ')"><i class="icon-base ti tabler-progress-check me-1"></i>Change Status</a
                              >
                            </div>
                          </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('setting.faq.faq_list');
    }


    public function stepsList(Request $request)
    {

        if ($request->ajax()) {

            $query = Steps::query();


            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    if ($row->status == 'Active') {
                        return '<span class="badge bg-success">' . $row->status . '</span>';
                    } elseif ($row->status == 'Inactive') {
                        return '<span class="badge bg-danger">' . $row->status . '</span>';
                    } else {
                        return '<span class="badge bg-secondary">' . $row->status . '</span>';
                    }
                })
                ->editColumn('icon', function ($row) {
                    return '<i class="icon-base ti tabler-' . $row->icon . '"></i>';
                })
                ->addColumn('action', function ($row) {

                    $action = '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">';

                    $action .= '

                              <a class="dropdown-item" href="' . route('edit_steps', [$row->id]) . '"
                                ><i class="icon-base ti tabler-pencil me-1"></i> Edit</a
                              >

                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteStep(' . $row->id . ')"><i class="icon-base ti tabler-progress-check me-1"></i> Change Status</a
                              >';

                    $action .= '</div>
                          </div>';
                    return $action;
                })
                ->rawColumns(['action', 'status', 'icon'])
                ->make(true);
        }

        return view('setting.steps.view');
    }

    public function addSteps(Request $request)
    {


        if ($request->method() == 'POST') {


            $request->validate([
                'title' => 'required|unique:steps,title',
                'icon' => 'required',
                'order' => 'required'
            ], [
                'title.required' => 'The title field is required.',
                'title.unique' => 'This title already exists.',

                'icon.required' => 'The icon field is required.',

                'order.required' => 'The order field is required.',
                'order.unique' => 'This order number is already taken.',
            ]);

            $data = [
                'title' => $request->title,
                'icon' => $request->icon,
                'order' => $request->order
            ];

            $insert = Steps::insert($data);
            return to_route('steps_list')->with(['status' => 'success', 'message' => 'Step Added']);
        }

        return view('setting.steps.add');
    }

    public function editSteps($id, Request $request)
    {
        $step = Steps::find($id);

        if ($request->method() == 'POST') {

            $request->validate([
                'title' => 'required|unique:steps,title,' . $id . ',id',
                'icon'  => 'required',
                'order' => 'required',

            ], [
                'title.required' => 'The title field is required.',
                'title.unique' => 'This title already exists.',

                'icon.required' => 'The icon field is required.',

                'order.required' => 'The order field is required.',
                'order.unique' => 'This order number is already taken.',
            ]);

            $data = [
                'title' => $request->title,
                'icon' => $request->icon,
                'order' => $request->order
            ];

            $update = Steps::where('id', $id)->update($data);

            return to_route('steps_list')->with(['status' => 'success', 'message' => 'Steps Updated']);;
        }
        return view('setting.steps.edit', compact('step'));
    }


    public function statusSteps($id)
    {
        $step = Steps::find($id);
        $step->status = $step->status === 'Active' ? 'Inactive' : 'Active';
        $step->save();
    }



    public function imageList(Request $request)
    {
        if ($request->ajax()) {
            $query = Banner::latest();

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
                ->addColumn('image', function ($row) {
                    return '<img src="'.asset("banner/".$row->image).'" alt="Image" class="img-fluid rounded-1" style="width: 30px;" onclick="openImageModal(\'' .asset("banner/".$row->image). '\')">';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base ti tabler-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="' . route('image_edit', [$row->id]) . '"><i class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteImage(' . $row->id . ')"><i class="icon-base ti tabler-exchange me-1"></i> Change Status</a>
                            </div>
                          </div>';
                })
                ->rawColumns(['action', 'image', 'status'])
                ->make(true);
        }

        return view('setting.image.view');
    }

    public function imageCreate()
    {
        return view('setting.image.add');
    }
    
    public function imageStore(Request $request)
    {
        $request->title = Str::slug($request->name);

        $request->validate([
            'name' => 'required|unique:banners,name|max:191',
            'type' => 'required',
            'image' => 'required|max:10048|image|mimes:jpg,jpeg,bmp,png,gif',
        ]);

        $data = [
            "name"=> $request->name,
            "title"=> $request->title,
            "type"=> $request->type,
            "desc"=> $request->description
        ];

        if($request->hasFile('image')){

            $width = ''; $height = '';
            if($request->type == 'Home Slider') { $width = '1200'; $height = '650'; }
            if($request->type == 'Home Abaut Consalt') { $width = '175'; $height = '155'; }
            if($request->type == 'Home Our Testimonials') { $width = '1200'; $height = '1200'; }
            if($request->type == 'Header Banner') { $width = '2880'; $height = '720'; }

            $manager = ImageManager::withDriver(new Driver());
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $destination = public_path('banner/');

            if($width != '' && $height != '')
            {
                $manager->read($image->getPathname())->resize($width, $height)->save($destination . '/' . $filename);
            } 
            else
            {
                $image->move($destination, $filename);
            }

            $data["image"] = $filename;
        }

        $check = Banner::create($data);

        return redirect()->route('image_list')->with(['status' => 'success', 'message' => 'Image created successfully.']);
    }

    public function imageEdit($id)
    {
        $data = Banner::findOrFail($id);
        return view('setting.image.edit', compact('data'));
    }

    public function imageUpdate(Request $request, $id)
    {
        $request->title = Str::slug($request->name);

        $request->validate([
            'name' => 'required|max:191|unique:banners,name,'.$id,
            'type' => 'required',
            'image' => 'nullable|max:10048|image|mimes:jpg,jpeg,bmp,png,gif',
        ]);

        $data = [
            "name"=> $request->name,
            "title"=> $request->title,
            "type"=> $request->type,
            "desc"=> $request->description
        ];

        if($request->hasFile('image')){

            $width = ''; $height = '';
            if($request->type == 'Home Slider') { $width = '1200'; $height = '650'; }
            if($request->type == 'Home Abaut Consalt') { $width = '175'; $height = '155'; }
            if($request->type == 'Home Our Testimonials') { $width = '1200'; $height = '1200'; }
            if($request->type == 'Header Banner') { $width = '2880'; $height = '720'; }

            $manager = ImageManager::withDriver(new Driver());
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $destination = public_path('banner/');

            if($width != '' && $height != '')
            {
                $manager->read($image->getPathname())->resize($width, $height)->save($destination . '/' . $filename);
            } 
            else
            {
                $image->move($destination, $filename);
            }

            $data["image"] = $filename;
        }

        $check = Banner::where('id', $id)->create($data);

        return redirect()->route('image_list')->with(['status' => 'success', 'message' => 'Image updated successfully.']);
    }

    public function imageUpdateStatus($id)
    {
        $data = Banner::findOrFail($id);
        $data->status = $data->status === 'Active' ? 'Inactive' : 'Active';
        $data->save();
        return redirect()->route('image_list')->with(['status' => 'success', 'message' => 'Image status chnage successfully.']);
    }


    
    public function videoList(Request $request)
    {

        if ($request->ajax()) {
            $query = Video::latest();

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
                              <a class="dropdown-item" href="' . route('video_edit', [$row->id]) . '"><i class="icon-base ti tabler-pencil me-1"></i> Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);" onclick="deleteCategory(' . $row->id . ')"><i class="icon-base ti tabler-exchange me-1"></i> Change Status</a>
                            </div>
                          </div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('setting.video.view');
    }

    public function videoCreate()
    {
        return view('setting.video.add');
    }
    
    public function videoStore(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:255',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255'
        ]);

        Video::create($request->all());

        return redirect()->route('video_list')->with(['status' => 'success', 'message' => 'Video created successfully.']);
    }

    public function videoEdit($id)
    {
        $data = Video::findOrFail($id);
        return view('setting.video.edit', compact('data'));
    }

    public function videoUpdate(Request $request, $id)
    {
        $request->validate([
            'url' => 'required|url|max:255',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255'
        ]);

        $data = $request->all();
        unset($data['_token']);
        Video::where('id', $id)->update($data);

        return redirect()->route('video_list')->with(['status' => 'success', 'message' => 'Video updated successfully.']);
    }

    public function videoUpdateStatus($id)
    {
        $data = Video::findOrFail($id);
        $data->status = $data->status === 'Active' ? 'Inactive' : 'Active';
        $data->save();
        return redirect()->route('video_list')->with(['status' => 'success', 'message' => 'Video status chnage successfully.']);
    }

}
