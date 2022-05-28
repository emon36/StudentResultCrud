<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function subject()
    {
        return $this->hasMany(Subject::class);
    }

    public function getStudentResult($id)
    {
        $studentInfo = StudentResult::where('student_id', $id)->latest()->take('2')->get();
        return $studentInfo->sum('achieve_number');
    }

    public function result()
    {
        return $this->hasMany(StudentResult::class);
    }

}
