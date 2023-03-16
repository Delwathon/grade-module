<?php

namespace Modules\Grade\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Modules\Grade\Entities\Term;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $branches = Branch::get();
        $terms = Term::with(['branch'])->orderBy('name', 'asc')->get();
        return view('exam.term', compact(['terms', 'branches']));
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
            'branch_id' => 'required|numeric',
            'terms' => 'required'
        ]);


        foreach ($request->terms as $term) {
            Term::updateOrCreate([
                'name' => $term,
                'branch_id' => $request->branch_id
            ]);
        }



        return redirect()->back()->with('success', 'Term created successfully');
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
        $term = Term::find($id);

        $term->name = $request->term;
        $term->branch_id = $request->branch_id;

        // foreach ($request->terms as $term ){
        // $term->update([

        // ]
        // );
        // $term->name = $term;
        // $term->branch_id = $request->branch_id;
        $term->update();
        // };



        return redirect()->back()->with('success', 'Term updated successfully');

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
        $term = Term::find($id);
        $term->delete();
        return redirect()->back()->with('warning', 'Term successfully deleted');
    }
}