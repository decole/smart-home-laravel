<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        return view('crud.notification.index', [
            'notifications' => $user->unreadNotifications,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {
        if ($id == 'all') {
            $user = Auth::user();
            foreach ($user->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        }

        return redirect('/notifications')->with([
            'success' => 'Сообщения помечены как прочитанные!',
        ]);
    }

}
