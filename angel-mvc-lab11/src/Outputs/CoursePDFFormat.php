<?php

namespace App\Outputs;

use FPDF; // Import the FPDF library

class CoursePDFFormat
{
    private $pdf;
    private $course_code;

    public function __construct()
    {
        // Initialize FPDF
        $this->pdf = new FPDF();
    }

    // Set data for the PDF
    public function setData($course_code)
    {
        $this->course_code = $course_code;
    }

    // Render the PDF
    public function render()
    {
        // Add a new page to the PDF
        $this->pdf->AddPage();
        
        // Set the font and add the course code
        $this->pdf->SetFont('Arial', 'B', 16);
        $this->pdf->Cell(40, 10, "Course: {$this->course_code}");
        
        // You can add more details like the list of enrollees here

        // Output the PDF to the browser
        $this->pdf->Output();
    }
}
