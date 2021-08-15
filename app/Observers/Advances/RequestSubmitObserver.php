<?php

namespace App\Observers\Advances;

use App\Models\Advanced\Request;
use App\Models\User;
use App\Notifications\Advance\RequestSubmitNotification;
use Illuminate\Support\Facades\Notification;

class RequestSubmitObserver
{
    public function updated(Request $submitRequest)
    {
        $user = User::find($submitRequest->updated_by);
        $resultSubmit = Request::find($submitRequest->id);

        $details = [
            'request_id' => $resultSubmit->id,
            'user_name' => $user->name,
            'code' => $resultSubmit->code,
            'body' => 'Request Approval ' . $resultSubmit->code . ' ' . $resultSubmit->description . ' ' . number_format($resultSubmit->request_amount),
        ];
        //RequestSubmited::dispatch($resultSubmit);
        $delay = now()->addSecond(15);
        Notification::send($user, new RequestSubmitNotification($details));
        
    }
}
