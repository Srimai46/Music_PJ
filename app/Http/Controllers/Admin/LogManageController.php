<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
            
class LogManageController extends Controller
{
    public function log()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.logManage.log', compact('logs'));
    }
}
