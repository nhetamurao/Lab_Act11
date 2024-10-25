<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class Student extends BaseModel
{
    // Public properties corresponding to the columns in the students table
    public $student_code;
    public $first_name;
    public $last_name;
    public $email;
    public $date_of_birth;
    public $sex;

    // Fetch all students
    public function all()
    {
        $sql = "SELECT * FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
    }

    // Find a specific student by student_code
    public function find($student_code)
    {
        $sql = "SELECT * FROM students WHERE student_code = :student_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['student_code' => $student_code]);
        return $statement->fetchObject('\App\Models\Student');
    }
}
