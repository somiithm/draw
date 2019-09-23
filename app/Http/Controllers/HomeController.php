<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
     * $request Http\Request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = DB::table('lottery_users')->get(['name', 'numbers']);
        foreach ($users as $user) {
            $user->numbers = explode(",", $user->numbers);
        }
        return view('home', ['users' => $users]);
    }

    private function getWinnerByRandGen($users) {
        $n = [];
        foreach ($users as $user) {
            $user->numbers = explode(',', $user->numbers);
            $n = array_merge($n, $user->numbers);
        }
        $val = $n[rand(0, count($n) -1)];
        $possible_winners = [];
        foreach ($users as $user) {
            if(in_array($val, $user->numbers)) {
                array_push($possible_winners, $user);
            }
        }
        $winner = $possible_winners[rand(0, count($possible_winners) -1)];
        return $winner;
    }

    public function draw(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prize_type' => 'required|in:1,2,3,4,5,6',
            'random' => 'required|in:yes,no',
        ]);
        if ($validator->fails()) {
            return redirect('home')
                ->withErrors($validator);
        }
        $prize_type = $request->input('prize_type');
        $random = $request->input('random');
        $wnumber = $request->input('wnumber', null);

        if($random == 'no' && $wnumber == null) {
            return redirect('home')->withErrors("when not in random mode winning number must be provided");
        }

        $prize_type_text_map = [
            "1" => "Grand Prize",
            "2" => "Second Prize, First Winner",
            "3" => "Second Prize, Second Winner",
            "4" => "Third Prize, First Winner",
            "5" => "Third Prize, Second Winner",
            "6" => "Third Prize, Third Winner",
        ];

        if ($random == "no") {
            $users = DB::select("select name from lottery_users where numbers like ". "'%{$wnumber}%'");
            if(count($users) == 0) {
                return redirect('home')->withErrors("Number not found for any user");
            }
            $winner = $users[rand(0, count($users) -1)];
        } else {
            if($prize_type == "1") {
                $res = DB::selectOne("select length(numbers) as len from lottery_users order by length(numbers) desc limit 1");
                $users = DB::select("select name, numbers from lottery_users where length(numbers)=:len", ['len' => $res->len]);
            } else {
                $users = DB::table('lottery_users')->get(['name', 'numbers']);
            }
            $winner = $this->getWinnerByRandGen($users);
        }

        return redirect('home')->with('success', "Winner of {$prize_type_text_map[$prize_type]} is {$winner->name}");
    }
}
