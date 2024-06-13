<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Error;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Favorite;
use App\Tobe\SAjax;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMail;



class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'      => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'     => 'required|string|max:255|unique:users',
            'password'  => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return AppHelper::sendError('Validation Error!', $validator->errors());
        }
        $code = rand(1001, 9999);

        $user = new User;
        $user->first_name = htmlentities($request->input('first_name'));
        $user->last_name = htmlentities($request->input('last_name'));
        $user->verification_code = $code;
        $user->email = htmlentities($request->input('email'));
        $user->password = bcrypt(htmlentities($request->input('password')));

        $profile = new UserProfile;
        $user_success = $user->save();
        $profile->user_id = $user->id;
        $profile_success = $profile->save();

        //create a new favorite when a user is created
        $favorite = new Favorite;
        $favorite->user_id = $user->id;
        $fav_success = $favorite->save();

        $token = $user->createToken('email_verification')->plainTextToken;
        $mail_count = 0;

        mail_sending:

        $mail_data = [
            "user" => "$user->first_name $user->last_name",
            "code"=>  $code,
            "url"=>  "https://verdroof.com/verify?token={$token}&code={$code}",
            "subject"=>"Verify Your Account"
        ];

        $mail_count++;

        $mail = Mail::to($user->email)->send(new AuthMail($mail_data));

        if($mail_count<3 and !$mail){
            goto mail_sending;
        }


        if ($user_success and $profile_success) {
            return AppHelper::sendResponse("$user->first_name $user->last_name", 'User Created Successfully');
        }else{
            return AppHelper::sendError('User creation failed', ['User creation failed'], 400);
        }
    }

    public function loginUser(Request $request)
    {
        // $this->validate($request, [
		// 	'email'=>'required',
		// 	'password'=>'required',
		// ]);

        // return $request;
		// $credentials=$request->only('email','password');
		if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'verified' => 1])){
			// $request->session()->regenerate();
            $user = Auth::user();
            $response = [
                'token' => $user->createToken('MyApp')->plainTextToken,
                'user' => $user->select('first_name', 'last_name', 'email')->first()
            ];
            return AppHelper::sendResponse($response, 'Login Successful');
		}

        $user = User::where('email', $request->email)->first();

        if($user and !$user->verified){
            return AppHelper::sendError('Email not verified', ['Email not verified, verify email and try again']);
        }
		// $request->flashExcept('password');
        return AppHelper::sendError('Authentication failed', ['Login Failed, confirm details and try again'], 401);
    }

    public function logoutUser(Request $Request){
        $user = Auth::user();

    	// Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    	return [
            'message' => 'Logout Successful',
        ];
	}

    public function updateUserProfile(Request $request){
        $user = Auth::user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        $profile->preferred_name = htmlentities($request->input('preferred_name'));
        $profile->phone_number = htmlentities($request->input('phone_number'));
        $profile->government_id = htmlentities($request->input('government_id'));
        $profile->address = htmlentities($request->input('address'));
        $profile->emergency_contact = htmlentities($request->input('emergency_contact'));
        $saved = $profile->save();
        if($saved){
            return AppHelper::sendResponse($profile, 'Profile Updated Successfully');
        }
        return AppHelper::sendError('Profile Update failed', ['Profile Update, try again']);
	}

    public function getUserProfile(Request $Request){
        $profile = Auth::user()->profile;
        return AppHelper::sendResponse($profile, 'Profile Fetched Successfully');
	}

    public function VerifyUser(Request $request, $token){
        [$id, $user_token] = explode('|', $token, 2);
        $pat = PersonalAccessToken::where('token', hash('sha256', $user_token))->first()->tokenable;
        $user = User::find($pat->id);

        // return $user;
        if($user->verification_code === $request->code){
            $user->verified = true;
            // $user[0]->email_verified_at = true;
            $success = $user->save();
            return AppHelper::sendResponse(null, 'Account Verified Successfully');
        }else{
            return AppHelper::sendError('Account Verification failed, invalid otp supplied', ['Account Verification failed'], 400);
        }
	}

    public function verify_email_template($user, $code, $token){
        $url = "https://verdroof.com/verify?token={$token}&code={$code}";
        return "
        ";
    }

    public function uploadImage(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type'=>'required|string'
        ]);

        if ($validator->fails()) {
            return AppHelper::sendError('Validation Error!', $validator->errors());
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path("../../public_html/verdroofAdmin/storage/$request->type"); // Adjust the path to point to public_html/uploads

            // Move the file to the public_html/uploads directory
            $file->move($path, $filename);

            // Generate the URL for the uploaded file
            $url = url("verdroofAdmin/storage/$request->type/$filename");

            // Return the URL in the response
            return AppHelper::sendResponse($url, 'File stored successfully');
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
