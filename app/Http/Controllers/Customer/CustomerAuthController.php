<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Mail\Websitemail;
use Illuminate\Support\Facades\Redirect;
use Hash;
use Auth;

class CustomerAuthController extends Controller
{
    public function login()
    {
        return view('front.login');
    }

    public function login_submit(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    }

    // Periksa apakah email terdaftar
    $customer = Customer::where('email', $request->email)->first();

    if (!$customer) {
        return redirect()->route('customer_login')->with('error', 'Email or password is incorrect!');
    }

    // Periksa apakah akun belum diverifikasi
    if ($customer->status == 0) {
        return redirect()->route('customer_login')->with('error', 'Your account has not been verified yet. Please wait for admin verification.');
    }

    // Coba autentikasi dengan kredensial
    $credential = [
        'email' => $request->email,
        'password' => $request->password
    ];

    if (Auth::guard('customer')->attempt($credential)) {
        return redirect()->route('home');
    } else {
        return redirect()->route('customer_login')->with('error', 'Email or password is incorrect!');
    }
}




    public function signup()
    {
        return view('front.signup');
    }

    public function signup_submit(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:customers',
        'password' => 'required',
        'retype_password' => 'required|same:password'
    ]);

    // Hash password
    $password = Hash::make($request->password);

    // Save the user's data to the database
    $customer = new Customer();
    $customer->name = $request->name;
    $customer->email = $request->email;
    $customer->password = $password;
    $customer->status = 0; // Status set to active
    $customer->save();

    // Auth::guard('customer')->login($customer);

    // Redirect to the login page with a success message
    return Redirect::route('customer_login')->with('success', 'Registration successful, Please wait until your account is verified.');
}


    public function signup_verify($email,$token)
    {
        $customer_data = Customer::where('email',$email)->where('token',$token)->first();

        if($customer_data) {
            
            $customer_data->token = '';
            $customer_data->status = 1;
            $customer_data->update();

            return redirect()->route('customer_login')->with('success', 'Your account is verified successfully!');

        } else {
            return redirect()->route('customer_login');
        }
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer_login');
    }

    


    public function reset_password($token,$email)
    {
        $customer_data = Customer::where('token',$token)->where('email',$email)->first();
        if(!$customer_data) {
            return redirect()->route('customer_login');
        }

        return view('front.reset_password', compact('token','email'));

    }

    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'retype_password' => 'required|same:password'
        ]);

        $customer_data = Customer::where('token',$request->token)->where('email',$request->email)->first();

        $customer_data->password = Hash::make($request->password);
        $customer_data->token = '';
        $customer_data->update();

        return redirect()->route('customer_login')->with('success', 'Password is reset successfully');

    }

}
