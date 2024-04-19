<?php

namespace App\Http\Controllers;

use App\Models\BuildingsAddress;
use App\Models\Neighbor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    public function signUp(Request $request)
    {
        //валидиране на данните
        $request->validate([
            'firstName' => 'required|min:2|max:20',
            'lastName' => 'required|min:2|max:20',
            'email' => 'required|email|min:5|max:150|unique:users,email',
            'password' => 'required|min:8|max:128',
            'repeatPassword' => 'required|min:8|max:128'
        ]);
        if ($request->password !== $request->repeatPassword) {
            return redirect()->back()->with('error', __('Паролите не съвпадат!'));
        }

        //създаване на нов потребител в БД
        $user = new User();
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        Auth::login($user);

        return redirect('dashboard');
    }

    public function login(Request $request)
    {
        //валидиране на данните
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //проверка за съществуващ потребител
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = User::where('email', $request->email)->first();
            Auth::login($user);
            return redirect('dashboard');
        }

        return redirect()->back()->with('error', __('Не намерихме потребител с въведените имейл и парола!'));
    }

    public function logOut()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required|min:8|max:128',
            'newPassword' => 'required|min:8|max:128',
            'newPasswordConfirmed' => 'required|min:8|max:128|same:newPassword'
        ]);

        if (Hash::check($request->oldPassword, Auth::user()->password)) {
            $user = User::where('id', Auth::user()->id)->first();
            $user->password = Hash::make($request->newPassword);
            $user->update();

            return redirect()->back()->with('success', __('Успешна промяна на паролата') . '!');
        }

        return redirect()->back()->with('error', __('Старата парола е неправилна') . '!');
    }

    public function getProfileInfo()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('profileSettings', ['firstName' => $user->first_name, 'lastName' => $user->last_name, 'email' => $user->email, 'fileName' => $user->file_name]);
    }

    public function changeProfileSettings(Request $request)
    {
        $request->validate([
            'firstName' => 'required|min:2|max:100|regex:/^[\p{L}]+$/u',
            'lastName' => 'required|min:2|max:100|regex:/^[\p{L}]+$/u',
            'fileName.*' => 'image|mimes:jpeg,png,jpg,svg,JPG,PNG,JPEG|max:10240'
        ]);
        $user = User::where('id', Auth::user()->id)->first();
        if ($request->file('fileName') !== null) {
            foreach ($request->file('fileName') as $image) {
                $suffix = $image->getClientOriginalExtension();

                $user->file_name = date_timestamp_get(Carbon::now()) . "." . $suffix;
                $imagesPath = dirname(__DIR__, 3) . env('IMAGES_PATH'); // path of all uploaded images
                if (file_exists($imagesPath . $user->file_name)) unlink($imagesPath . $user->file_name); // delete old image if exists
                $image->move($imagesPath, $user->file_name); // upload new image onto server
            }
        }

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->update();

        return redirect()->back()->with('success', __('Успешно редактиране на профила') . '!');
    }
}