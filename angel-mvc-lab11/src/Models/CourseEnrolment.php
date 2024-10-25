<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class CourseEnrolment extends BaseModel
{
    // Method to enroll a student in a course
    public function enroll($course_code, $student_code, $enrolment_date, $grade)
    {
        $sql = "INSERT INTO course_enrolments SET 
                    course_code = :course_code,
                    student_code = :student_code,
                    enrolment_date = :enrolment_date,
                    grade = :grade";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            'course_code' => $course_code,
            'student_code' => $student_code,
            'enrolment_date' => $enrolment_date,
            'grade' => $grade
        ]);
    }

    // Method to fetch detailed enrollees by course code
    public function getEnrolleesByCourse($course_code)
    {
        $sql = "SELECT se.student_code, s.full_name 
                FROM course_enrolments se
                JOIN students s ON se.student_code = s.student_code
                WHERE se.course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}