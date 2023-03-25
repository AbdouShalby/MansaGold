<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latestGroups = Group::latest('created_at')->take(5)->get();
        $countOfUsers = count(User::all());
        $countOfGroups = count(Group::all());
        $countOfInvest = Group::pluck('current_subscription')->sum();
        return view('home', [
            'latestGroups' => $latestGroups,
            'totalUsers' => $countOfUsers,
            'totalGroups' => $countOfGroups,
            'totalInvest' => $countOfInvest
        ]);
    }

    public function search(Request $request) {
        $search = $request->search;
        if($search)
        {
            $groups = Group::where('group_name', 'LIKE', '%'. $search .'%')->get();
            $users = User::where('name', 'LIKE', '%'. $search .'%')
                ->orWhere('email', 'LIKE', '%'. $search .'%')->get();
        }
        else
        {
            $groups = Group::get();
            $users = User::get();
        }


        return view('search', [
            'groups' => $groups,
            'users' => $users,
        ]);
    }
}
