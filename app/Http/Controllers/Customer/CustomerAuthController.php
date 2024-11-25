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

    // Pastikan tidak ada sesi admin yang aktif
    if (Auth::guard('admin')->check()) {
        Auth::guard('admin')->logout();
    }

    $credential = [
        'email' => $request->email,
        'password' => $request->password,
        'status' => 1
    ];

    if (Auth::guard('customer')->attempt($credential)) {
        return redirect()->route('home');
    } else {
        return redirect()->route('customer_login')->with('error', 'Information is not correct!');
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
    $customer->status = 1; // Status set to active
    $customer->save();

    // Auth::guard('customer')->login($customer);

    // Redirect to the login page with a success message
    return Redirect::route('customer_login')->with('success', 'Registration successful, please log in.');
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
