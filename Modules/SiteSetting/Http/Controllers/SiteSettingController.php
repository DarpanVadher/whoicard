<?php

namespace Modules\SiteSetting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\SiteSetting\Entities\ProfileTemplate;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('sitesetting::index');
    }

    /* User Profile Information Template  */

    public function profileInfoTemp()
    {
        return view('sitesetting::profileInfoTemplate');
    }

    public function getProfileInfoTemp(Request $request)
    {
        // Page Length
        $pageNumber = ($request->start / $request->length) + 1;
        $pageLength = $request->length;
        $skip       = ($pageNumber - 1) * $pageLength;

        // Page Order
        $orderColumnIndex = $request->order[0]['column'] ?? '0';
        $orderBy = $request->order[0]['dir'] ?? 'desc';

        // get data from products table
        $query = DB::table('profile_templates')->select('*');

        // Search
        $search = $request->search;
        $query = $query->where(function ($query) use ($search) {
            $query->orWhere('name', 'like', "%" . $search . "%");
            $query->orWhere('value', 'like', "%" . $search . "%");
        });

        $orderByName = 'id';
        switch ($orderColumnIndex) {
            case '0':
                $orderByName = 'id';
                break;
            case '1':
                $orderByName = 'name';
                break;
            case '2':
                $orderByName = 'value';
                break;
        }
        $query = $query->orderBy($orderByName, $orderBy);
        $recordsFiltered = $recordsTotal = $query->count();
        $users = $query->skip($skip)->take($pageLength)->get();

        return response()->json(["draw" => $request->draw, "recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, 'data' => $users], 200);
    }


    public function profileInfoTempAdd(Request $request)
    {

        $request->validate([
            'templateName' => 'required',
            'templateValue' => 'required',
        ]);

        print_r($request->all());


        $template = new ProfileTemplate();

        $template->name = $request->templateName;
        $template->value = $request->templateValue;
        $template->created_by = Auth::user()->id;
        $template->updated_by = Auth::user()->id;


        print_r($template);

        $template->save();




        return redirect('admin/sitesetting/personalinfo');

    }




    /* Contact Us */

    public function contactus()
    {
        return view('sitesetting::contactus');
    }


    /* Info Side */

    public function getProfileInfo(){
          $getProfileTemplateInfo = ProfileTemplate::all();      
        
          return view('sitesetting::profileInfo',compact('getProfileTemplateInfo'));
    
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sitesetting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('sitesetting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('sitesetting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
