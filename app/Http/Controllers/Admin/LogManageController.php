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

    public function clearAll()
    {
        ActivityLog::truncate();
        return redirect()->route('admin.log')->with('success', 'All logs have been cleared.');
    }
}
