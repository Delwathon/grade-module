<?php

namespace Modules\Grade\Http\Controllers;

use App\Models\Branch;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Grade\Entities\Distribution;
use Illuminate\Contracts\Support\Renderable;

class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $branches = Branch::get();
        $distributions = Distribution::with(['branch', 'session', 'class'])->get();
        $sessions = Session::get();
        // return $distributions;
        return view('exam.distribution', compact(['branches', 'distributions', 'sessions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'short_name' => 'required|string',
            'branch_id' => 'required|numeric',
            'session_id' => 'required|numeric',
            'class_id' => 'required|numeric',
            'demo_vertical' => 'required|numeric',
        ], [
                'demo_vertical.required' => 'Value is required',
                'branch_id.required' => 'Branch required to select',
                'session_id.required' => 'Session required to select'

            ]);


        // Distribution::create($request->all());
        $totalValue = Distribution::where(['s_class_id' => $request->class_id, 'branch_id' => $request->branch_id])->sum('value');
        // return $totalValue;
        if ($totalValue > 100) {
            return redirect()->back()->with('danger', 'This class distribution already reach 100 marks');
        }


        if (($totalValue + $request->demo_vertical) > 100) {
            return redirect()->back()->with('danger', 'This class already have ' . $totalValue . ' and adding ' . $request->demo_vertical . ' will exceed 100');
        }


        $existName = Distribution::where(['name' => $request->name, 'branch_id' => $request->branch_id, 's_class_id' => $request->class_id,])->count();
        // return $existName;
        if ($existName > 0) {
            return redirect()->back()->with('danger', 'Distribution name ' . $request->name . ' already existed for selected branch and class');
        }
        $existShort = Distribution::where(['short_name' => $request->short_name, 's_class_id' => $request->class_id, 'branch_id' => $request->branch_id])->count();
        if ($existShort > 0) {
            return redirect()->back()->with('danger', 'Distribution short name ' . $request->name . ' already existed for selected branch and class');
        }

        $dist = new Distribution();
        $dist->name = $request->name;
        $dist->short_name = $request->short_name;
        $dist->branch_id = $request->branch_id;
        $dist->s_class_id = $request->class_id;
        $dist->session_id = $request->session_id;
        $dist->value = $request->demo_vertical;
        $dist->save();
        return redirect()->back()->with(['success' => 'Distribution created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $request->validate([
            'name' => 'required|string',
            'short_name' => 'required|string',
            'branch_id' => 'required|numeric',
            'session_id' => 'required|numeric',
            'demo_vertical' => 'required|numeric'
        ], [
                'demo_vertical.required' => 'Value is required',
                'branch_id.required' => 'Branch required to select',
                'session_id.required' => 'Session required to select'

            ]);


        // Distribution::create($request->all());
        $existName = Distribution::where(['name' => $request->name, 'branch_id' => $request->branch_id])->count();
        // return $existName;
        // if ($existName > 0){
        //     return redirect()->back()->with('danger', 'Distribution name '. $request->name. ' already existed for selected branch');
        // }
        // $existShort = Distribution::where(['short_name'=>$request->short_name, 'branch_id'=>$request->branch_id])->count();
        // if ($existShort > 0){
        //     return redirect()->back()->with('danger', 'Distribution short name '. $request->name. ' already existed for selected branch');
        // }
        $dist = Distribution::find($id);
        $dist->name = $request->name;
        $dist->short_name = $request->short_name;
        $dist->branch_id = $request->branch_id;
        $dist->session_id = $request->session_id;
        $dist->value = $request->demo_vertical;
        $dist->update();
        return redirect()->back()->with(['success' => 'Distribution Updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $dist = Distribution::find($id);
        $dist->delete();
        return redirect()->back()->with('warning', 'Distribution deleted successfully');
    }
}