<?php

namespace Modules\Grade\Entities;

use App\Models\Branch;
use App\Models\SClass;
use App\Models\Section;
use App\Models\Session;
use Modules\Grade\Entities\Mark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'short_name', 'branch_id', 'value'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function class ()
    {
        return $this->belongsTo(SClass::class, 's_class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    public function marks($session, $term, $branch, $class, $section, $subject, $student, $distribution)
    {
        $marks = Mark::where([
            'branch_id' => $branch,
            'section_id' => $section,
            's_class_id' => $class,
            'session_id' => $session,
            'subject_id' => $subject,
            'term_id' => $term,
            'student_id' => $student,
            'distribution_id' => $distribution
        ])->first();

        return $marks;

    }

    protected static function newFactory()
    {
        return \Modules\Grade\Database\factories\DistributionFactory::new ();
    }
}