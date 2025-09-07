<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
            
class LogManageController extends Controller
{
   public function log()
    {
        // เรียกไฟล์ view/admin/log.blade.php
        return view('admin.log');
    }
}
