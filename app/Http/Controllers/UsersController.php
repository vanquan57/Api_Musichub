<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataUsers = User::all();
        return view('users')->with([
            'title' => "Users Management",
            'dataUsers' => $dataUsers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } else if ($request->input('provider') == 'google') {
            $userExist = User::where('email', $request->input('email'))->first();
            if (!$userExist) {
                $user = User::create([
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'member' => $request->input('member') ? $request->input('member') : 0,
                    'password' => bcrypt($request->input('password')),
                    'provider' => $request->input('provider') ? $request->input('provider') : null,
                    'providerId' => $request->input('providerId') ? $request->input('providerId') : null,
                    'avatarUrl' => $request->input('avatarUrl') ? $request->input('avatarUrl') : "https://upload.wikimedia.org/wikipedia/commons/a/af/Default_avatar_profile.jpg"
                ]);
                if ($user) {
                    return response()->json([
                        'success' => true,
                        'user' => $user
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password'
            ]);
        }
    }
    public function getUserById(Request $request)
    {
        $user = User::find($request->query('userId'));
        if ($user) {
            return response()->json($user);
        }
    }
    public function activateAccount(Request $request)
    {
        $user = User::find($request->input('userId'));
        $value = $request->input('value');
        if ($user) {
            $user->member = $value ? $value : 0;
            $user->save();
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
    // public function updateAccount(Request $request){
    //     $user = User::find($request->input('userId'));
    //     $value = $request->input('value');
    //     if($request->hasFile('image')){
    //         $file = $request->file('image');
    //         $fileName = $file->getClientOriginalName();
    //         
    //     }
        
    // }
    public function updateAccount(Request $request)
    {
        $user = User::find($request->input('userId'));
        $value = $request->input('value');
        Log::error($request->input('value'));
        if ($user) {
            $avatarCurrent = $user->avatarUrl;
            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists($avatarCurrent)) {
                    Storage::disk('public')->delete($avatarCurrent);
                    try {
                        $file = $request->file('image');
                        $fileName = $file->getClientOriginalName();
                        $imagePath = $file->storeAs('uploads', $fileName, 'public');
                        $user->avatarUrl = $imagePath;
                        $user->save();
                    } catch (\Throwable $th) {
                        //throw $th;
                        Log::error($th);
                    }
                }else{
                    try {
                        $file = $request->file('image');
                        $fileName = $file->getClientOriginalName();
                        $imagePath = $file->storeAs('uploads', $fileName, 'public');
                        $user->avatarUrl = $imagePath;
                        $user->save();
                    } catch (\Throwable $th) {
                        //throw $th;
                        Log::error($th);
                    }
                }
            }

            $usernameCleanData = str_replace('"', '', $value);
            $user->username = $usernameCleanData;
            $user->save();
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }
         else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
    public function updatePasswordAccount(Request $request)
    {
        $user = User::find($request->input('userId'));
       
        $value = $request->input('value');

        if ($user) {
            $user->password = bcrypt($value ? $value : '');
            $user->save();
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // create new Account user
        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'member' => $request->input('member') ? $request->input('member') : 0,
            'password' => bcrypt($request->input('password')),
            'provider' => $request->input('provider') ? $request->input('provider') : null,
            'providerId' => $request->input('providerId') ? $request->input('providerId') : null,
            'avatarUrl' => $request->input('avatarUrl') ? $request->input('avatarUrl') : null
        ]);
        if ($user) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }



    public function sentEmailVerification(Request $request)
    {
        $toEmail = $request->query('email');

        $code = rand(1000, 9999);
        $subject = 'Xác thực tài khoản MusicHub';

        $sentMailSuccess =  Mail::send('verificationCustomView', ['code' => $code, 'title' => $subject], function ($email) use ($toEmail) {
            $email->subject('Verify email address from MusicHub');
            $email->to($toEmail);
        });

        if ($sentMailSuccess) {
            return response()->json([
                'success' => true,
                'code' => $code
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
