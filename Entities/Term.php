<?php

namespace Modules\Grade\Entities;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Term extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'branch_id'];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    protected static function newFactory()
    {
        return \Modules\Grade\Database\factories\TermFactory::new ();
    }
}