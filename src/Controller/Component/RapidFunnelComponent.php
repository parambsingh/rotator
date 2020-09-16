<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use \Firebase\JWT\JWT;

class RapidFunnelComponent extends Component {

    function generateJWT​($apiKey, $hmacKey, $issuer) {
        $tokenId = base64_encode(bin2hex(openssl_random_pseudo_bytes(32)));
        $issuedAt = time();
        $notBeforeUse = $issuedAt;
        $expireTime = $notBeforeUse + 60;
        $payLoadData = [
            'iat'  => $issuedAt,
            'jti'  => $tokenId,
            'iss'  => $issuer,
            'nbf'  => $notBeforeUse,
            'exp'  => $expireTime,
            'data' => [
                'secretKey' => $apiKey
            ]
        ];
        $hmacEncodedKey = base64_decode($hmacKey);

        $jwtToken = json_encode(JWT::encode($payLoadData, $hmacEncodedKey, 'HS512'));


        return $jwtToken;
    }

    function getRf($url = null, $header = false) {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, $header);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $headers = [
                "Authorization:" . $this->generateJWT​(RF_API_KEY, RF_SECRET_KEY, RF_API_URL),
                "Accept:application/json",
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $serverOutput = curl_exec($ch);

            curl_close($ch);

            return $serverOutput;
    }

    function postRf($url = null, $params = [], $header = false) {


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        $headers = [
            "Authorization:" . $this->generateJWT​(RF_API_KEY, RF_SECRET_KEY, RF_API_URL),
            "Accept:application/json",
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $serverOutput = curl_exec($ch);

        curl_close($ch);

        return $serverOutput;
    }

}

?>