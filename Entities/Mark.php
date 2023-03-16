<?php

namespace Modules\Grade\Entities;

use App\Models\Branch;
use App\Models\SClass;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use App\Models\Subject;
use Modules\Grade\Entities\Term;
use Illuminate\Database\Eloquent\Model;
use Modules\Grade\Entities\Distribution;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'section_id',
        's_class_id',
        'session_id',
        'subject_id',
        'term_id',
        'student_id',
        'distribution_id',
        'mark'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }


    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }

    public function class ()
    {
        return $this->belongsTo(SClass::class, 's_class_id');
    }

    protected static function newFactory()
    {
        return \Modules\Grade\Database\factories\MarkFactory::new ();
    }
}