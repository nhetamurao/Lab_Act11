<?php

namespace App\Controllers;

use App\Models\Course;
use App\Controllers\BaseController;
use FPDF;

class CourseController extends BaseController
{
    // List all courses with the number of enrolled students
    public function list()
    {
        $obj = new Course();
        $courses = $obj->all();

        $template = 'courses';
        $data = [
            'items' => $courses
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    // View details of a specific course and its enrollees
    public function viewCourse($course_code)
    {
        $courseObj = new Course();
        $course = $courseObj->find($course_code);
        $enrollees = $courseObj->getEnrollees($course_code);

        $template = 'single-course'; // Template to display course details and enrollees
        $data = [
            'course' => $course,
            'enrollees' => $enrollees
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    // Export course details and enrollees to PDF
    public function exportCourseToPDF($course_code)
    {
        $courseObj = new Course();
        $course = $courseObj->find($course_code);
        $enrollees = $courseObj->getEnrollees($course_code);

        // Initialize FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Course Title
        $pdf->Cell(0, 10, "Course Information", 0, 1, 'C');
        $pdf->Ln(10);

        // Course Details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'Course Code: ');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, $course->course_code);
        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'Course Name: ');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, $course->course_name);
        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'Description: ');
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, $course->description);
        $pdf->Ln(7);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'Credits: ');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, $course->credits);
        $pdf->Ln(10);

        // Enrollees List
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Enrolled Students:', 0, 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'Student Code');
        $pdf->Cell(60, 10, 'First Name');
        $pdf->Cell(60, 10, 'Last Name');
        $pdf->Ln(10);

        // Loop through the enrollees
        foreach ($enrollees as $student) {
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(40, 10, $student->student_code);
            $pdf->Cell(60, 10, $student->first_name);
            $pdf->Cell(60, 10, $student->last_name);
            $pdf->Ln(7);
        }

        // Output the PDF inline (in the browser)
        $pdf->Output('I', "{$course->course_code}_enrollees.pdf");
    }
}
