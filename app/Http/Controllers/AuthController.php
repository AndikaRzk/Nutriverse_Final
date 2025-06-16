<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Consultant;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Supplement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin(){
        return view('components.login');
    }

    public function showRegister(){
        return view('components.register');
    }

    public function dashboard()
    {
        $supplements = Supplement::all();
        $articles = Article::latest()->take(3)->get(); // contoh ambil 3 artikel terbaru

        $totalCustomers = Customer::count();
        $totalCouriers = Courier::count();
        $totalConsultants = Consultant::count();

        return view('components.dashboard', compact('supplements', 'articles', 'totalCustomers', 'totalCouriers', 'totalConsultants'));
    }

    public function register(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date|before:today',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255', // Optional
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Full name is required.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Invalid gender selection.',
            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Invalid date format.',
            'dob.before' => 'Date of birth must be before today.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Create a new customer
        Customer::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully.');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $guards = ['customers', 'couriers', 'consultants'];

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();

            // Jika yang login adalah consultant, update is_online ke true
            if ($guard === 'consultants') {
                $consultant = Auth::guard('consultants')->user();

                if ($consultant instanceof \App\Models\Consultant) {
                    $consultant->is_online = true;
                    $consultant->save();
                }
            }

            // Redirect sesuai guard
            if ($guard === 'couriers') {
                return redirect()->route('courier.deliveries.index');
            } elseif ($guard === 'consultants') { // Tambahkan kondisi ini
                return redirect()->route('articles');
            }

            return redirect()->intended('/');
        }
    }

    throw ValidationException::withMessages([
        'email' => 'The provided credentials do not match our records.',
    ]);
}


    public function logout(Request $request)
    {
        $guards = ['customers', 'couriers', 'consultants'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika yang logout adalah consultant, ubah status online
                if ($guard === 'consultants') {
                    $consultant = Auth::guard('consultants')->user();

                    if ($consultant instanceof \App\Models\Consultant) {
                        $consultant->is_online = false;
                        $consultant->save();
                    }
                }

                Auth::guard($guard)->logout();
            }
        }

        // Invalidate & regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route("dashboard")->with('success', 'You have been logged out.');
    }


    // Menampilkan form edit
    public function editcustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    // Menyimpan perubahan
    public function updatecustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'dob' => 'required|date',
            'email' => 'required|email|unique:customers,email,' . $id,
            'password' => 'nullable|min:6',
            'phone' => 'required|unique:customers,phone,' . $id,
            'address' => 'required|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->gender = $request->gender;
        $customer->dob = $request->dob;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $customer->password = bcrypt($request->password);
        }

        $customer->save();

        return redirect()->back()->with('success', 'Customer updated successfully.');
    }

}
