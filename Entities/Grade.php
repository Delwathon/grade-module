<?php

namespace Modules\Grade\Entities;

use App\Models\Branch;
use App\Models\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    protected static function newFactory()
    {
        return \Modules\Grade\Database\factories\GradeFactory::new ();
    }
}