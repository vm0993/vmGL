<?php

function send_notification_FCM($notification_id, $title, $message, $id,$type) {
 
    $accesstoken = env('FCM_KEY');
 
    $URL = 'https://fcm.googleapis.com/fcm/send';
    $post_data = '{
        "to" : "' . $notification_id . '",
        "data" : {
            "body" : "",
            "title" : "' . $title . '",
            "type" : "' . $type . '",
            "id" : "' . $id . '",
            "message" : "' . $message . '",
        },
        "notification" : {
                "body" : "' . $message . '",
                "title" : "' . $title . '",
                "type" : "' . $type . '",
                "id" : "' . $id . '",
                "message" : "' . $message . '",
            "icon" : "new",
            "sound" : "default"
            },

        }';
    // print_r($post_data);die;
 
    $crl = curl_init();
 
    $headr = array();
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: ' . $accesstoken;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
 
    curl_setopt($crl, CURLOPT_URL, $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
 
    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
 
    $rest = curl_exec($crl);
 
    if ($rest === false) {
        // throw new Exception('Curl error: ' . curl_error($crl));
        //print_r('Curl error: ' . curl_error($crl));
        $result_noti = 0;
    } else {
 
        $result_noti = 1;
    }
 
    //curl_close($crl);
    //print_r($result_noti);die;
    return $result_noti;
}