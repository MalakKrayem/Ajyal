<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel , WithHeadingRow
{
    protected  $data;



    public function __construct($data){
        $this->data = $data;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new Student([
        // ]);
        $student = new Student();
        $student->first_name = $row['first_name'];
        $student->last_name = $row['last_name'];
        $student->password = Hash::make($row['password']);
        $student->transport = $row['transport'];
        $student->email = $row['email'];
        $student->phone = $row['phone'];
        $student->address = $row['address'];
        $student->gender = $row['gender'];
        $student->save();
        DB::table('student_group')->insert([
            'student_id' => $student->id,
            'group_id' => $this->data->group_id,
        ]);
    }
}
