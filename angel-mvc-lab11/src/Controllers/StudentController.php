<?php

namespace App\Controllers;

use App\Models\Student;
use App\Controllers\BaseController;

class StudentController extends BaseController
{
    public function list()
    {
        // Instantiate the Student model
        $obj = new Student();
        // Fetch all students
        $students = $obj->all();

        // Define the template name
        $template = 'students';
        // Pass the students to the view using the correct key ('students')
        $data = [
            'students' => $students // Must use 'students' to match the Mustache template
        ];

        // Render the template with the data
        $output = $this->render($template, $data);

        return $output;
    }
}
