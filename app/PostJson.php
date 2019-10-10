<?php

namespace App;

class PostJson 
{
    public function post(string $url, $data) {
        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result_json = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result_json, true);
        return $result;
    }

    public function get(string $url) {

        $ch = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  

        $result_json = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($result_json, true);

        return $result;
    }
}
