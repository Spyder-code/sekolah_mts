<?php

namespace App\Http\Controllers;

use App\Models\MoneyBox;
use App\Models\MoneyBoxCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoneyBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moneyBoxes = MoneyBox::all();
        $categories = MoneyBoxCategory::all();
        $students = User::all()->where('role','siswa');
        return view('dashboard.moneybox.index', compact('moneyBoxes','categories','students'));
    }

    public function siswa()
    {
        $user_id = Auth::id();
        $moneyBoxesTotal = MoneyBox::all()->where('user_id',$user_id)->groupBy('money_box_category_id');
        $moneyBoxes = MoneyBox::all()->where('user_id',$user_id)->sortByDesc('created_at');
        return view('dashboard.moneybox.siswa', compact('moneyBoxes', 'moneyBoxesTotal'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MoneyBox::create($request->all());
        return redirect()->route('moneybox.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MoneyBox  $moneyBox
     * @return \Illuminate\Http\Response
     */
    public function show(MoneyBox $moneyBox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MoneyBox  $moneyBox
     * @return \Illuminate\Http\Response
     */
    public function edit(MoneyBox $moneyBox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MoneyBox  $moneyBox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MoneyBox $moneybox)
    {
        $moneybox->update($request->all());
        return redirect()->route('moneybox.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MoneyBox  $moneyBox
     * @return \Illuminate\Http\Response
     */
    public function destroy(MoneyBox $moneybox)
    {
        $moneybox->delete();
        return redirect()->route('moneybox.index')->with('success', 'Data berhasil dihapus');
    }
}
