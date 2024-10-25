<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\CourseEnrolment;
use App\Models\Student;
use App\Controllers\BaseController;

class EnrolmentController extends BaseController
{
    // Show the enrollment form
    public function enrollmentForm()
    {
        $courseObj = new Course();
        $studentObj = new Student();

        $template = 'enrollment-form';
        $data = [
            'courses' => $courseObj->all(),
            'students' => $studentObj->all()
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    // Enroll a student in a course
    public function enroll()
    {
        $course_code = $_POST['course_code'];
        $student_code = $_POST['student_code'];
        $enrolment_date = $_POST['enrolment_date'];
        $grade = $_POST['grade'] ?? 'NA'; // Default grade is 'NA'

        // Enroll student in the course
        $enrolmentObj = new CourseEnrolment();
        $enrolmentObj->enroll($course_code, $student_code, $enrolment_date, $grade);

        // Redirect back to course details
        header("Location: /courses/{$course_code}");
        exit();
    }
}