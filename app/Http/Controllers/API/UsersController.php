<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Kreait\Firebase\Contract\Storage;

class UsersController extends Controller
{
    public function getUserData(Request $request) {
        $token = $request->get('token');

        if (!empty($token)) {
            $user = User::where('token', $token)->first();
            $balance = UserBalance::where('user_id', $user->id)->first();
            if (!empty($user)) {
                $response['success'] = 'Success';
                $response['message'] = 'User Data';
                $response['user'] = $user;
                $response['balance'] = $balance->balance;
            } else {
                $response['faild'] = 'Faild';
                $response['message'] = 'Wrong Token';
            }
        }
        return response()->json($response);
    }

    public function login(Request $request) {
        $method = $request->get('method');
        $response = [];
        switch ($method){
            case "email":

                $email = $request->get('email');
                $password = $request->get('password');

                if (!empty($email) && !empty($password)) {

                    $user = User::where('email', $email)->where('password', md5($password))->first();

                    if (!empty($user)) {

                        $loggedUser = $user->toArray();
                        $loggedUser['token'] = $this->adduseraccess($loggedUser['id']);
                        $response['success'] = 'Success';
                        $response['message'] = 'Login Sucessfully';
                        $response['user'] = $loggedUser;

                    } else {
                        $response['success'] = 'Failed';
                        $response['error'] = 'Incorrect Password';
                    }
                } else {
                    $response['success'] = false;
                    $response['error'] = 'some fields are missing';
                }
                break;

            case "firebase":
                $uid = $request->get('uid');

                try {
                    $auth = app('firebase.auth');
                    $user = $auth->getUser($uid);

                    $email = $user->email;
                    $phone = $user->phoneNumber;

                    if (!empty($email)) {
                        $user = User::where('email', $email)->first();

                        if (!empty($user)) {
                            $loggedUser = $user->toArray();
                            $loggedUser['token'] = $this->adduseraccess($loggedUser['id']);
                            $response['success'] = 'Success';
                            $response['message'] = 'Login Sucessfully';
                            $response['user'] = $loggedUser;
                        } else {
                            // Insert the user data into the database
                            $id = DB::table('users')->insertGetId(['email' => $email, 'created_at' => now(), 'updated_at' => now()]);
                            DB::table('user_balances')->insert(['user_id' => $id, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()]);

                            // Get the user information from the inserted row
                            $user = User::where('id', $id)->first();

                            $loggedUser = $user->toArray();
                            $loggedUser['token'] = $this->adduseraccess($loggedUser['id']);
                            $response['success'] = 'Success';
                            $response['message'] = 'Login Sucessfully';
                            $response['user'] = $loggedUser;
                            $response['registred'] = true;
                        }
                    }
                    else if (!empty($phone)) {
                        $user = User::where('phone', $phone)->first();

                        if (!empty($user)) {
                            $loggedUser = $user->toArray();
                            $loggedUser['token'] = $this->adduseraccess($loggedUser['id']);
                            $response['success'] = 'Success';
                            $response['message'] = 'Login Sucessfully';
                            $response['user'] = $loggedUser;
                        } else {
                            // Insert the user data into the database
                            $id = DB::table('users')->insertGetId(['phone' => $phone, 'created_at' => now(), 'updated_at' => now()]);
                            DB::table('user_balances')->insert(['user_id' => $id, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()]);

                            // Get the user information from the inserted row
                            $user = User::where('id', $id)->first();

                            $loggedUser = $user->toArray();
                            $loggedUser['token'] = $this->adduseraccess($loggedUser['id']);
                            $response['success'] = 'Success';
                            $response['message'] = 'Login Sucessfully';
                            $response['user'] = $loggedUser;
                            $response['registred'] = true;
                        }
                    } else {
                        $response['success'] = 'Failed';
                        $response['error'] = 'Email Or Phone Not Correct';
                    }
                } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Wrong UID';
                }
                break;
        }
        return response()->json($response);
    }

    public function register(Request $request) {

        $email = $request->get('email');
        $password = $request->get('password');

        if (!empty($email) && !empty($password)) {

            $checkExist = User::where('email', $email)->first();

            if (empty($checkExist)) {
                $hashPassword = md5($password);

                $id = DB::table('users')->insertGetId(['email' => $email, 'password' => $hashPassword, 'created_at' => now(), 'updated_at' => now()]);
                DB::table('user_balances')->insert(['user_id' => $id, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()]);

                $user = User::where('email', $email)->where('password', $hashPassword)->first();

                $registredUser = $user->toArray();
                $registredUser['token'] = $this->adduseraccess($registredUser['id']);
                $response['success'] = 'Success';
                $response['message'] = 'Regsitred Sucessfully';
                $response['user'] = $registredUser;
            } else {
                $response['success'] = false;
                $response['error'] = 'EMail Already Exist';
            }

        } else {
            $response['success'] = false;
            $response['error'] = 'some fields are missing';
        }
        return response()->json($response);
    }

    public function update(Request $request) {
        $token = $request->get('token');
        $name = $request->get('name');
        $country = $request->get('country');
        $userAvatar = $request->file('user_avatar');

        if(!empty($token)) {
            $user = User::where('token', $token)->first();
            if (!empty($user) && !empty($name)) {
                DB::table('users')->where('token', $token)->update(['name' => $name]);
                if (!empty($country)) {
                    DB::table('users')->where('token', $token)->update(['country' => $country]);
                }
                if (!empty($userAvatar)) {
                    if (File::exists($user->user_avatar)) {
                        File::delete($user->user_avatar);
                    }
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $extension = $request->file('user_avatar')->getClientOriginalExtension();

                    if (in_array($extension, $allowedExtensions)) {
                        $path = $userAvatar->move(public_path(). '/avatars/users', $token . '.jpg');
                        $trimmedPath = str_replace(public_path(), env('APP_URL'), $path);
                        DB::table('users')->where('token', $token)->update(['user_avatar' => $trimmedPath]);
                    } else {
                        $response['Faild'] = false;
                        $response['error'] = 'Invalid file type.';
                    }
                }
                $response['success'] = 'Success';
                $response['message'] = 'User Updated Sucessfully';
            } elseif (!empty($user) && !empty($country)){
                DB::table('users')->where('token', $token)->update(['country' => $country]);
                if (!empty($userAvatar)) {
                    if (File::exists($user->user_avatar)) {
                        File::delete($user->user_avatar);
                    }
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    $extension = $request->file('user_avatar')->getClientOriginalExtension();

                    if (in_array($extension, $allowedExtensions)) {
                        $path = $userAvatar->move(public_path(). '/avatars/users', $token . '.jpg');
                        $trimmedPath = str_replace(public_path(), env('APP_URL'), $path);
                        DB::table('users')->where('token', $token)->update(['user_avatar' => $trimmedPath]);
                    } else {
                        $response['Faild'] = false;
                        $response['error'] = 'Invalid file type.';
                    }
                }
                $response['success'] = 'Success';
                $response['message'] = 'User Updated Sucessfully';
            } elseif (!empty($user) && !empty($userAvatar)) {
                if (File::exists($user->user_avatar)) {
                    File::delete($user->user_avatar);
                }
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = $request->file('user_avatar')->getClientOriginalExtension();

                if (in_array($extension, $allowedExtensions)) {
                    $path = $userAvatar->move(public_path(). '/avatars/users', $token . '.jpg');
                    $trimmedPath = str_replace(public_path(), env('APP_URL'), $path);
                    DB::table('users')->where('token', $token)->update(['user_avatar' => $trimmedPath]);

                    $response['success'] = 'Success';
                    $response['message'] = 'Avatar Updated Sucessfully';
                } else {
                    $response['Faild'] = false;
                    $response['error'] = 'Invalid file type.';
                }
            } else {
                $response['Faild'] = false;
                $response['error'] = 'Wrong Data';
            }
        } else {
            $response['success'] = 'Faild';
            $response['message'] = 'Enter Token';
        }
        return response()->json($response);
    }

    public function adduseraccess($user_id)
    {
        $token = $this->getUniqAccessToken();
        $user = DB::table('users')->where('id', $user_id)->first();
        if ($user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['token' => $token]);
        } else {
            DB::table('users')->insert(['id' => $user_id, 'token' => $token]);
        }
        return $token;
    }

    public function getUniqAccessToken()
    {
        $accessget = 0;
        $accessToken = '';
        while ($accessget == 0) {
            $accessToken = md5(uniqid(mt_rand(), true));
            $user = DB::table('users')->where('token', $accessToken)->first();
            if (!$user) {
                $accessget = 1;
            }
        }
        return $accessToken;
    }
}
