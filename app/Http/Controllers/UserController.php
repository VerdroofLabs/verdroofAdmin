<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Error;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserProfile;
use App\Tobe\SAjax;
use Laravel\Sanctum\PersonalAccessToken;



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

        $token = $user->createToken('email_verification')->plainTextToken;
        $mail_count = 0;

        mail_sending:
        $SAjax = new SAjax();
        $SAjax->setHeaders(["Content-Type: application/json"]);
        $mail_data = [
            "email"=> $user->email,
            "email_data_html"=> $this->verify_email_template($user->first_name, $code, $token),
            "email_data_string"=> "Account Verification email.",
            "subject"=>"Verify Account"
        ];
        $mail_count++;

        $mail = $SAjax->post("https://verdroof-web-next.vercel.app/api/sendEmail", $mail_data, true);

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
        $this->validate($request, [
			'email'=>'required',
			'password'=>'required',
		]);

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
        return AppHelper::sendError('Authentication failed', ['Login Failed, confirm details and try again']);
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
        $profile = Auth::user()->profile;
        $profile->school = htmlentities($request->input('school'));
        $profile->work = htmlentities($request->input('work'));
        $profile->image_url = htmlentities($request->input('image_url'));
        $profile->birthday = htmlentities($request->input('birthday'));
        $profile->favorite_song = htmlentities($request->input('favorite_song'));
        $profile->home = htmlentities($request->input('home'));
        $profile->pet = htmlentities($request->input('pet'));
        $profile->obsessed_with = htmlentities($request->input('obsessed_with'));

        $saved = $profile->save();

        if($saved){
            return AppHelper::sendResponse($profile, 'Profile Updated Successfully');
        }
	}

    public function getUserProfile(Request $Request){
        $user = Auth::user();

    	// Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    	return [
            'message' => 'Logout Successful',
        ];
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
        $url = "https://verdroof-web-next.vercel.app/verify?token={$token}";
        return "
        <!DOCTYPE html>
        <html lang='en'>
            <head>
                <meta charset='UTF-8' />
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <title>Verify Your Account</title>
            </head>
            <body
                style='
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #ffffff;
                color: #000000;
                '
            >
                <table
                    align='center'
                    border='0'
                    cellpadding='0'
                    cellspacing='0'
                    width='600'
                >
                    <tr>
                        <td align='center' bgcolor='#008000' style='padding: 20px 0'>
                            <h1 style='color: #ffffff; margin: 0'>Verify Your Account</h1>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' style='padding: 40px 30px'>
                            <p style='margin: 0'>Dear $user,</p>
                            <p style='margin: 20px 0'>
                                Thank you for registering an account with us.
                            </p>
                            <p style='margin: 20px 0'>
                                Please click the button below to verify your account:
                            </p>
                            <h1 style=' margin:20px 0; font-size:17px'>
                                Verification Code:
                                <span style='color:#008000'>$code</span>
                            </h1>
                            <p style='margin: 20px 0'>
                                <a
                                    href='$url'
                                    style='
                                    background-color: #008000;
                                    color: #ffffff;
                                    padding: 10px 20px;
                                    text-decoration: none;
                                    border-radius: 5px;
                                    '
                                >
                                    Verify Account
                                </a>
                            </p>
                            <p style='margin: 20px 0'>
                                If the button did not work, copy the link: $url to your browser.
                            </p>

                            <p style='margin: 20px 0'>
                                If you did not request this, please ignore this email.
                            </p>
                            <p style='margin: 20px 0'>
                                Best regards,<br />
                                Verdroof Lab
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#008000' style='padding: 20px 30px'>
                            <p style='color: #ffffff; margin: 0; text-align: center'>
                            © 2024 Verdroof. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </body>
        </html>";
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
