<?php

namespace Modules\Grade\Http\Controllers;

use App\Models\Branch;
use App\Models\SClass;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\AssignSubject;
use Modules\Grade\Entities\Mark;
use Modules\Grade\Entities\Term;
use Illuminate\Routing\Controller;
use Modules\Grade\Entities\Distribution;
use Illuminate\Contracts\Support\Renderable;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $branches = Branch::get();
        $sessions = Session::get();
        $terms = Term::get();
        if ($request->session_id) {
            $request->validate([
                'session_id' => 'required|numeric',
                'term_id' => 'required|numeric',
                'branch_id' => 'required|numeric',
                'class_id' => 'required|numeric',
                'section_id' => 'required|numeric',
                'subject_id' => 'required|numeric',
            ]);

            return redirect()->route('student-mark', [$request->session_id, $request->term_id, $request->branch_id, $request->class_id, $request->section_id, $request->subject_id]);
        }
        return view('exam.mark', compact(['branches', 'sessions', 'terms']));
    }

    public function studentMark($session, $term, $branch, $class, $section, $subject)
    {
        $branches = Branch::get();
        $sessions = Session::get();
        $terms = Term::get();
        $term = Term::find($term);
        $section = Section::find($section);
        $branch = Branch::find($branch);
        $class = SClass::find($class);
        // return $class;
        $session = Session::find($session);
        // return $section;
        $subject = Subject::find($subject);
        $students = Student::with(['branch', 'dept', 'user', 'state', 'lga', 'class', 'section', 'guardian'])
            // ->whereHas('', function ($query) use ($section, $branch, $class) {
            // $query
            //    ->orderBy('id', 'desc')


            ->where([
                'branch_id' => $branch->id,
                'section_id' => $section->id,
                's_class_id' => $class->id
            ])
            // })
            ->get();
        // return $students;
        $classes = SClass::whereHas('branches', function ($query) use ($branch) {
            $query->where('branch_id', $branch->id);
        })->get();
        $sections = Section::whereHas('classes', function ($query) use ($class) {
            $query->where('s_class_id', $class->id);
        })->get();
        $subjects = AssignSubject::with(['subject'])->whereHas('section', function ($query) use ($section, $class) {
            $query->where('section_id', $section->id);
            $query->where('s_class_id', $class->id);
        })->get();
        // return $subjects;
        $distributions = Distribution::with([])->where(['branch_id' => $branch->id, 'session_id' => $session->id, 's_class_id' => $class->id])->get();
        // return $distributions;
        foreach ($students as $student) {
            # code...
            // echo $value;
            foreach ($distributions as $distribution) {
                Mark::updateOrCreate([
                    'branch_id' => $branch->id,
                    'section_id' => $section->id,
                    's_class_id' => $class->id,
                    'session_id' => $session->id,
                    'subject_id' => $subject->id,
                    'term_id' => $term->id,
                    'student_id' => $student->id,
                    'distribution_id' => $distribution->id,
                    // 'mark'=>$mark
                ]);
            }
        }

        $marks = Mark::with(['distribution'])->where(['branch_id' => $branch->id, 'session_id' => $session->id, 's_class_id' => $class->id,])->get();
        // return $subject;
        return view('exam.mark', compact([
            'branches',
            'distributions',
            'marks',
            'term',
            'session',
            'students',
            'class',
            'section',
            'branch',
            'sessions',
            'terms',
            'subject',
            'classes',
            'sections',
            'subjects'

        ]));
    }

    public function getStudentMark()
    {

    }
    public function studentMarkEntry(Request $request, $session, $term, $branch, $class, $section, $subject)
    {

        // return $request;
        //
        foreach ($request->distribution as $student_id => $distributions) {
            # code...
            // echo $value;
            foreach ($distributions as $distribution_id => $mark) {

                $mark = Mark::where([
                    'branch_id' => $branch,
                    'section_id' => $section,
                    's_class_id' => $class,
                    'session_id' => $session,
                    'subject_id' => $subject,
                    'term_id' => $term,
                    'student_id' => $student_id,
                    'distribution_id' => $distribution_id,
                ])->update([
                        'mark' => $mark
                    ]);
            }
        }
        // return;
        return redirect()->back()->with('success', 'Mark enter successfully');
        // return view('exam.mark', compact(['branches','distributions','term','session','students','class','section', 'branch', 'sessions', 'terms']));
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
    }
}