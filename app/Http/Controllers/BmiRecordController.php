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


    // public function recommendFoods(Request $request)
    // {
    //     $request->validate([
    //         'daily_calories' => 'required|numeric|min:500|max:10000',
    //     ]);

    //     $userId = Auth::id();

    //     // Ambil BMI terakhir
    //     $latestBmi = BmiRecord::where('customer_id', $userId)->latest()->first();

    //     if (!$latestBmi) {
    //         return redirect()->back()->withErrors(['bmi' => 'You must calculate BMI first.']);
    //     }

    //     $bmiCategory = strtolower($latestBmi->category->category); // relasi
    //     $targetPerMeal = $request->daily_calories / 3;

    //     // Ambil semua kategori unik dari tabel food
    //     $foodCategories = Food::select('category')
    //         ->distinct()
    //         ->pluck('category');

    //     $recommendedFoods = [];

    //     foreach (['breakfast', 'lunch', 'dinner'] as $mealTime) {
    //         foreach ($foodCategories as $category) {
    //             $recommendedFoods[$mealTime][$category] = Food::where('bmi_category', $bmiCategory)
    //                 ->where('meal_time', $mealTime)
    //                 ->where('category', $category)
    //                 ->where('calories', '<=', $targetPerMeal)
    //                 ->orderByDesc('calories')
    //                 ->take(3)
    //                 ->get();
    //         }
    //     }

    //     return redirect()->back()->with([
    //         'recommended_foods' => $recommendedFoods,
    //         'daily_calories' => $request->daily_calories,
    //     ]);
    // }

    // public function recommendFoods(Request $request)
    // {
    //     $request->validate([
    //         'daily_calories' => 'required|numeric|min:500|max:10000',
    //         // Validasi untuk setiap kategori alergi
    //         'allergies_protein' => 'nullable|array',
    //         'allergies_protein.*' => 'string|max:255',
    //         'allergies_fruit' => 'nullable|array',
    //         'allergies_fruit.*' => 'string|max:255',
    //         'allergies_vegetable' => 'nullable|array',
    //         'allergies_vegetable.*' => 'string|max:255',
    //     ]);

    //     $userId = Auth::id();

    //     $latestBmi = BmiRecord::where('customer_id', $userId)->latest()->first();

    //     if (!$latestBmi) {
    //         return redirect()->back()->withErrors(['bmi' => 'You must calculate BMI first.']);
    //     }

    //     $bmiCategory = strtolower($latestBmi->category->category);
    //     $targetPerMeal = $request->daily_calories / 3;

    //     // Gabungkan semua input alergi menjadi satu array datar
    //     $allSelectedAllergies = array_merge(
    //         $request->input('allergies_protein', []),
    //         $request->input('allergies_fruit', []),
    //         $request->input('allergies_vegetable', [])
    //     );

    //     // Ubah ke lowercase untuk pencocokan case-insensitive
    //     $allergiesForFilter = array_map('strtolower', $allSelectedAllergies);

    //     // Ambil semua kategori unik dari tabel food
    //     $foodCategories = Food::select('category')
    //         ->distinct()
    //         ->pluck('category');

    //     $recommendedFoods = [];

    //     foreach (['breakfast', 'lunch', 'dinner'] as $mealTime) {
    //         foreach ($foodCategories as $category) {
    //             $query = Food::where('bmi_category', $bmiCategory)
    //                 ->where('meal_time', $mealTime)
    //                 ->where('category', $category)
    //                 ->where('calories', '<=', $targetPerMeal);

    //             // Terapkan filter alergi jika ada alergi yang dipilih
    //             if (!empty($allergiesForFilter)) {
    //                 $query->whereNotIn('name', $allergiesForFilter);
    //             }

    //             $recommendedFoods[$mealTime][$category] = $query->orderByDesc('calories')
    //                 ->take(3)
    //                 ->get();
    //         }
    //     }

    //     return redirect()->back()->with([
    //         'recommended_foods' => $recommendedFoods,
    //         'daily_calories' => $request->daily_calories,
    //         // Penting: Kirim kembali setiap kategori alergi yang dipilih untuk pre-filling form
    //         'selected_allergies_protein' => $request->input('allergies_protein', []),
    //         'selected_allergies_fruit' => $request->input('allergies_fruit', []),
    //         'selected_allergies_vegetable' => $request->input('allergies_vegetable', []),
    //     ]);
    // }
    public function recommendFoods(Request $request)
{
    $request->validate([
        'daily_calories' => 'required|numeric|min:500|max:10000',
        'allergies_protein' => 'nullable|string|max:500', // Changed to string
        'allergies_fruit' => 'nullable|string|max:500',   // Changed to string
        'allergies_vegetable' => 'nullable|string|max:500', // Changed to string
    ]);

    $userId = Auth::id();

    $latestBmi = BmiRecord::where('customer_id', $userId)->latest()->first();

    if (!$latestBmi) {
        return redirect()->back()->withErrors(['bmi' => 'You must calculate BMI first.']);
    }

    $bmiCategory = strtolower($latestBmi->category->category);
    $targetPerMeal = $request->daily_calories / 3;

    // --- NEW LOGIC FOR ALLERGIES ---
    $allergiesProtein = array_filter(array_map('trim', explode(',', strtolower($request->input('allergies_protein', '')))));
    $allergiesFruit = array_filter(array_map('trim', explode(',', strtolower($request->input('allergies_fruit', '')))));
    $allergiesVegetable = array_filter(array_map('trim', explode(',', strtolower($request->input('allergies_vegetable', '')))));

    $foodCategories = Food::select('category')
        ->distinct()
        ->pluck('category');

    $recommendedFoods = [];
    $usedFoodIds = [];

    foreach (['breakfast', 'lunch', 'dinner'] as $mealTime) {
        foreach ($foodCategories as $category) {
            $query = Food::where('bmi_category', $bmiCategory)
                ->where('meal_time', $mealTime)
                ->where('category', $category)
                ->where('calories', '<=', $targetPerMeal)
                ->whereNotIn('id', $usedFoodIds);

            // Apply allergy filter based on category
            if ($category === 'protein' && !empty($allergiesProtein)) {
                foreach ($allergiesProtein as $allergen) {
                    $query->where('name', 'not like', '%' . $allergen . '%');
                }
            } elseif ($category === 'fruit' && !empty($allergiesFruit)) {
                foreach ($allergiesFruit as $allergen) {
                    $query->where('name', 'not like', '%' . $allergen . '%');
                }
            } elseif ($category === 'vegetable' && !empty($allergiesVegetable)) {
                foreach ($allergiesVegetable as $allergen) {
                    $query->where('name', 'not like', '%' . $allergen . '%');
                }
            }

            $foodsForCategory = $query->orderByDesc('calories')
                ->take(3)
                ->get();

            foreach ($foodsForCategory as $food) {
                $usedFoodIds[] = $food->id;
            }

            $recommendedFoods[$mealTime][$category] = $foodsForCategory;
        }
    }

    return redirect()->back()->with([
        'recommended_foods' => $recommendedFoods,
        'daily_calories' => $request->daily_calories,
        // Save the string values back to session for old() to pick up
        'selected_allergies_protein_string' => $request->input('allergies_protein', ''),
        'selected_allergies_fruit_string' => $request->input('allergies_fruit', ''),
        'selected_allergies_vegetable_string' => $request->input('allergies_vegetable', ''),
    ]);
}

public function showForm()
{
    // Ambil nama makanan unik per kategori (Tidak digunakan lagi untuk dropdown, tapi bisa tetap ada jika diperlukan di bagian lain)
    $foodNamesByCategory = [
        'protein' => Food::where('category', 'protein')->distinct()->pluck('name')->sort()->toArray(),
        'fruit' => Food::where('category', 'fruit')->distinct()->pluck('name')->sort()->toArray(),
        'vegetable' => Food::where('category', 'vegetable')->distinct()->pluck('name')->sort()->toArray(),
    ];

    return view('customer.bmi', [
        'foodNamesByCategory' => $foodNamesByCategory, // Ini tidak akan digunakan untuk input alergi lagi
        'daily_calories' => old('daily_calories', session('daily_calories')),
        // Menggunakan string untuk alergi yang tersimpan
        'selected_allergies_protein_string' => old('allergies_protein', session('selected_allergies_protein_string', '')),
        'selected_allergies_fruit_string' => old('allergies_fruit', session('selected_allergies_fruit_string', '')),
        'selected_allergies_vegetable_string' => old('allergies_vegetable', session('selected_allergies_vegetable_string', '')),
    ]);
}
//     public function recommendFoods(Request $request)
//     {
//         $request->validate([
//             'daily_calories' => 'required|numeric|min:500|max:10000',
//             'allergies_protein' => 'nullable|array',
//             'allergies_protein.*' => 'string|max:255',
//             'allergies_fruit' => 'nullable|array',
//             'allergies_fruit.*' => 'string|max:255',
//             'allergies_vegetable' => 'nullable|array',
//             'allergies_vegetable.*' => 'string|max:255',
//         ]);

//         $userId = Auth::id();

//         $latestBmi = BmiRecord::where('customer_id', $userId)->latest()->first();

//         if (!$latestBmi) {
//             return redirect()->back()->withErrors(['bmi' => 'You must calculate BMI first.']);
//         }

//         $bmiCategory = strtolower($latestBmi->category->category);
//         $targetPerMeal = $request->daily_calories / 3;

//         $allSelectedAllergies = array_merge(
//             $request->input('allergies_protein', []),
//             $request->input('allergies_fruit', []),
//             $request->input('allergies_vegetable', [])
//         );
//         $allergiesForFilter = array_map('strtolower', $allSelectedAllergies);

//         $foodCategories = Food::select('category')
//             ->distinct()
//             ->pluck('category');

//         $recommendedFoods = [];
//         $usedFoodIds = []; // To keep track of food IDs already recommended across all meal times

//         foreach (['breakfast', 'lunch', 'dinner'] as $mealTime) {
//             foreach ($foodCategories as $category) {
//                 $query = Food::where('bmi_category', $bmiCategory)
//                     ->where('meal_time', $mealTime)
//                     ->where('category', $category)
//                     ->where('calories', '<=', $targetPerMeal)
//                     ->whereNotIn('id', $usedFoodIds); // Exclude already used food IDs

//                 if (!empty($allergiesForFilter)) {
//                     $query->whereNotIn('name', $allergiesForFilter);
//                 }

//                 $foodsForCategory = $query->orderByDesc('calories')
//                     ->take(3)
//                     ->get();

//                 // Add the IDs of the newly recommended foods to the used list
//                 foreach ($foodsForCategory as $food) {
//                     $usedFoodIds[] = $food->id;
//                 }

//                 $recommendedFoods[$mealTime][$category] = $foodsForCategory;
//             }
//         }

//         return redirect()->back()->with([
//             'recommended_foods' => $recommendedFoods,
//             'daily_calories' => $request->daily_calories,
//             'selected_allergies_protein' => $request->input('allergies_protein', []),
//             'selected_allergies_fruit' => $request->input('allergies_fruit', []),
//             'selected_allergies_vegetable' => $request->input('allergies_vegetable', []),
//         ]);
//     }

//     public function showForm()
// {
//     // Ambil nama makanan unik per kategori
//     $foodNamesByCategory = [
//         'protein' => Food::where('category', 'protein')->distinct()->pluck('name')->sort()->toArray(),
//         'fruit' => Food::where('category', 'fruit')->distinct()->pluck('name')->sort()->toArray(),
//         'vegetable' => Food::where('category', 'vegetable')->distinct()->pluck('name')->sort()->toArray(),
//         // Tambahkan kategori lain jika ada, misalnya 'carbs', dll.
//     ];

//     return view('customer.bmi', [ // Ganti 'bmi.recommendation' dengan nama view Anda
//         'foodNamesByCategory' => $foodNamesByCategory,
//         // ... data lain yang mungkin Anda butuhkan untuk form
//         // Misalkan Anda ingin mempertahankan nilai daily_calories sebelumnya jika form diakses langsung
//         'daily_calories' => old('daily_calories', session('daily_calories')),
//         // Juga untuk pilihan alergi yang disimpan sebelumnya
//         'selected_allergies_protein' => old('allergies_protein', session('selected_allergies_protein', [])),
//         'selected_allergies_fruit' => old('allergies_fruit', session('selected_allergies_fruit', [])),
//         'selected_allergies_vegetable' => old('allergies_vegetable', session('selected_allergies_vegetable', [])),
//     ]);
// }
}
