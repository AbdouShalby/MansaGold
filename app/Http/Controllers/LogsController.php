<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function logs(Request $request) {
        $logs = Logs::orderByDesc('id')->paginate(20);
        return view('logs', [
            'logs' => $logs,
        ]);
    }
}
