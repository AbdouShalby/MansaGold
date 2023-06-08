<?php

namespace App\Http\Controllers\API;

use App\Notifications\FirebaseNotification;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $title = $request->input('title');
        $body = $request->input('body');

        $users = User::all(); // يمكنك تحديد المستلمين حسب الاحتياجات الخاصة بك

        foreach ($users as $user) {
            $user->notify(new FirebaseNotification($title, $body));
        }

        return response()->json(['message' => 'تم إرسال الإشعارات بنجاح.']);
    }
}
