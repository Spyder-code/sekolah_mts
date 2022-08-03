<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PointController extends Controller
{

    public function index()
    {
        $points = Point::all()->where('user_id', auth()->user()->id);
        return view('dashboard.point.index', compact('points'));
    }
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'course_id' => 'required',
            'user_id' => 'required',
            'point' => 'required|integer'
        ]);

        $cek = Point::where('course_id', $validated['course_id'])->where('user_id', $validated['user_id'])->first();
        if (!$cek) {
            Point::create($validated);
            $user = User::find($validated['user_id']);
            $point = $user->point + 1;
            $user->update([
                'point' => $point
            ]);
        } else {
            return back()->with('success', 'Anda sudah mendapatkan point');
        }
        $point = Point::create($validated);

        return back()->with('success', 'Berhasil Mendapatkan Point');
    }
}
