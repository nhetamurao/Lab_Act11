<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Course extends BaseModel
{
    // Fetch all courses and return the number of enrolled students per course
    public function all()
    {
        $sql = "SELECT courses.*, COUNT(course_enrolments.student_code) AS enrolled_students
                FROM courses
                LEFT JOIN course_enrolments ON courses.course_code = course_enrolments.course_code
                GROUP BY courses.id";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    // Find a specific course by course_code
    public function find($course_code)
    {
        $sql = "SELECT * FROM courses WHERE course_code = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$course_code]);
        $result = $statement->fetchObject('\App\Models\Course');
        return $result;
    }

    // Fetch all students enrolled in a specific course
    public function getEnrollees($course_code)
    {
        $sql = "SELECT s.*
                FROM course_enrolments AS ce
                LEFT JOIN students AS s ON s.student_code = ce.student_code
                WHERE ce.course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }
}