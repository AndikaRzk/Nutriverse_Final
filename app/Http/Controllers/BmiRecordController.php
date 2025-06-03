<?php

namespace App\Http\Controllers;

use App\Models\BmiCategory;
use App\Models\BmiRecord;
use App\Models\Food;
use App\Models\Supplement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BmiRecordController extends Controller
{
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'height' => 'required|numeric|min:50|max:300',
    //         'weight' => 'required|numeric|min:10|max:500',
    //     ]);

    //     $userId = Auth::id(); // get currently logged-in customer id

    //     $heightInMeters = $request->height / 100;
    //     $bmi = $request->weight / ($heightInMeters * $heightInMeters);

    //     $category = BmiCategory::where('min_value', '<=', $bmi)
    //                 ->where('max_value', '>=', $bmi)
    //                 ->first();

    //     if (!$category) {
    //         return redirect()->back()->withErrors(['bmi' => 'BMI category not found'])->withInput();
    //     }

    //     BmiRecord::create([
    //         'customer_id' => $userId,
    //         'height' => $request->height,
    //         'weight' => $request->weight,
    //         'bmi' => round($bmi, 2),
    //         'bmi_category_id' => $category->id,
    //     ]);

    //     return redirect()->back()->with('success', 'BMI data has been saved successfully!');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'height' => 'required|numeric|min:50|max:300',
    //         'weight' => 'required|numeric|min:10|max:500',
    //     ]);

    //     $userId = Auth::id();
    //     $heightInMeters = $request->height / 100;
    //     $bmi = $request->weight / ($heightInMeters * $heightInMeters);

    //     $category = BmiCategory::where('min_value', '<=', $bmi)
    //         ->where('max_value', '>=', $bmi)
    //         ->first();

    //     if (!$category) {
    //         return redirect()->back()->withErrors(['bmi' => 'BMI category not found'])->withInput();
    //     }

    //     BmiRecord::create([
    //         'customer_id' => $userId,
    //         'height' => $request->height,
    //         'weight' => $request->weight,
    //         'bmi' => round($bmi, 2),
    //         'bmi_category_id' => $category->id,
    //     ]);

    //     return redirect()->back()->with([
    //         'success' => 'BMI data has been saved successfully!',
    //         'bmi_result' => round($bmi, 2),
    //         'bmi_category' => $category->category,
    //     ]);
    // }

    public function store(Request $request)
{
    $request->validate([
        'height' => 'required|numeric|min:50|max:300',
        'weight' => 'required|numeric|min:10|max:500',
    ]);

    $userId = Auth::id();
    $heightInMeters = $request->height / 100;
    $bmi = $request->weight / ($heightInMeters * $heightInMeters);

    // Cari kategori BMI sesuai nilai BMI
    $category = BmiCategory::where('min_value', '<=', $bmi)
        ->where('max_value', '>=', $bmi)
        ->first();

    if (!$category) {
        return redirect()->back()->withErrors(['bmi' => 'BMI category not found'])->withInput();
    }

    // Simpan record BMI user
    BmiRecord::create([
        'customer_id' => $userId,
        'height' => $request->height,
        'weight' => $request->weight,
        'bmi' => round($bmi, 2),
        'bmi_category_id' => $category->id,
    ]);

    // Ambil rekomendasi suplemen yang sesuai kategori BMI
    $supplements = Supplement::where('bmi_category', $category->category)
        ->where('stock', '>', 0) // opsional: hanya yang ada stok
        ->orderBy('price', 'asc') // opsional: urutkan harga termurah dulu
        ->take(3)
        ->get();

    return redirect()->back()->with([
        'success' => 'BMI data has been saved successfully!',
        'bmi_result' => round($bmi, 2),
        'bmi_category' => $category->category,
        'supplements' => $supplements,
    ]);
}


    public function recommendFoods(Request $request)
    {
        $request->validate([
            'daily_calories' => 'required|numeric|min:500|max:10000',
        ]);

        $userId = Auth::id();

        // Ambil BMI terakhir
        $latestBmi = BmiRecord::where('customer_id', $userId)->latest()->first();

        if (!$latestBmi) {
            return redirect()->back()->withErrors(['bmi' => 'You must calculate BMI first.']);
        }

        $bmiCategory = strtolower($latestBmi->category->category); // relasi
        $targetPerMeal = $request->daily_calories / 3;

        // Ambil semua kategori unik dari tabel food
        $foodCategories = Food::select('category')
            ->distinct()
            ->pluck('category');

        $recommendedFoods = [];

        foreach (['breakfast', 'lunch', 'dinner'] as $mealTime) {
            foreach ($foodCategories as $category) {
                $recommendedFoods[$mealTime][$category] = Food::where('bmi_category', $bmiCategory)
                    ->where('meal_time', $mealTime)
                    ->where('category', $category)
                    ->where('calories', '<=', $targetPerMeal)
                    ->orderByDesc('calories')
                    ->take(3)
                    ->get();
            }
        }

        return redirect()->back()->with([
            'recommended_foods' => $recommendedFoods,
            'daily_calories' => $request->daily_calories,
        ]);
    }
}
