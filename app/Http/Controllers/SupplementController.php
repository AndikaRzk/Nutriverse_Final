<?php

namespace App\Http\Controllers;

use App\Models\Supplement;
use Illuminate\Http\Request;

class SupplementController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplement::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        $supplements = $query->orderBy('name')->paginate(9);

        return view('customer.supplement', compact('supplements'));
    }
}
