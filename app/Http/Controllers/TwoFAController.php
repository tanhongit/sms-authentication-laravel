<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserCode;

class TwoFAController extends Controller
{
    /**
     * Write code on Method
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View()
     */
    public function index()
    {
        return view('2fa');
    }

    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\RedirectResponse()
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);

        $find = UserCode::where('user_id', auth()->user()->id)
            ->where('code', $request->code)
            ->where('updated_at', '>=', now()->subMinutes(2))
            ->first();

        if (!is_null($find)) {
            Session::put('user_2fa', auth()->user()->id);
            return redirect()->route('home');
        }

        return back()->with('error', 'You entered wrong code.');
    }
    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\RedirectResponse()
     */
    public function resend()
    {
        auth()->user()->generateCode();

        return back()->with('success', 'We sent you code on your mobile number.');
    }
}
