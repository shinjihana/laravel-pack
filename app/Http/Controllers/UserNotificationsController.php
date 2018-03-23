<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserNotificationsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * get notification
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
