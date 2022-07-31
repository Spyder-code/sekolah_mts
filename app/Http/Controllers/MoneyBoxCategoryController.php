<?php

namespace App\Http\Controllers;

use App\Models\MoneyBoxCategory;
use Illuminate\Http\Request;

class MoneyBoxCategoryController extends Controller
{
    public function index()
    {
        $moneyBoxCategories = MoneyBoxCategory::all();
        return view('dashboard.moneybox.category', compact('moneyBoxCategories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        MoneyBoxCategory::create($request->all());
        return redirect()->route('moneyboxcategory.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show(MoneyBoxCategory $moneyBoxCategory)
    {
        //
    }

    public function edit(MoneyBoxCategory $moneyBoxCategory)
    {
        //
    }

    public function update(Request $request, MoneyBoxCategory $moneyboxcategory)
    {
        $moneyboxcategory->update($request->all());
        return redirect()->route('moneyboxcategory.index')->with('success', 'Kategori berhasil diubah');
    }

    public function destroy(MoneyBoxCategory $moneyboxcategory)
    {
        $moneyboxcategory->delete();
        return redirect()->route('moneyboxcategory.index')->with('success', 'Kategori berhasil dihapus');
    }
}
