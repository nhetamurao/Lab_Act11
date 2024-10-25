<?php

namespace App\Outputs;

interface ProfileFormatter
{
    public function setData($data);
    public function render();
}