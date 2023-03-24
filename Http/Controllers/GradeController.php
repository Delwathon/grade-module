<?php

namespace Modules\Grade\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Modules\Grade\Entities\Grade;
use Illuminate\Routing\Controller;
use Modules\Academics\Entities\Session;
use Illuminate\Contracts\Support\Renderable;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $branches = Branch::get();
        $grades = Grade::with(['branch', 'session'])->get();
        $sessions = Session::get();
        return view('exam.grades', compact(['grades', 'sessions', 'branches']));
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
            'session_id' => 'required|numeric',
            'branch_id' => 'required|numeric',
            'name' => 'required|string',
            'remark' => 'required|string',
            'from' => 'required|numeric',
            'to' => 'required|numeric',
        ]);


        $grade = new Grade();
        $grade->grade = $request->name;
        $grade->branch_id = $request->branch_id;
        $grade->session_id = $request->session_id;
        $grade->to = $request->to;
        $grade->from = $request->from;
        $grade->remark = $request->remark;
        $grade->save();
        return redirect()->back()->with('success', 'Grade created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\Grade\Entities\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\Grade\Entities\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Grade\Entities\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grade $grade)
    {
        //
        $request->validate([
            'session_id' => 'required|numeric',
            'branch_id' => 'required|numeric',
            'name' => 'required|string',
            'remark' => 'required|string',
            'from' => 'required|numeric',
            'to' => 'required|numeric',
        ]);


        $grade->grade = $request->name;
        $grade->branch_id = $request->branch_id;
        $grade->session_id = $request->session_id;
        $grade->to = $request->to;
        $grade->from = $request->from;
        $grade->remark = $request->remark;
        $grade->update();
        return redirect()->back()->with('success', 'Grade updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\Grade\Entities\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grade $grade)
    {
        //
        $grade->delete();
        return redirect()->back()->with('warning', 'Grade deleted successfully');
    }

}