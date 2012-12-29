<?php
/**
 * User: tony
 * Date: 21.12.12
 * Time: 15:00
 */ 
class Facebook {

    public static function parseSignedRequest($signed_request, $secret)
    {

        list($encoded_sig, $payload) = explode('.', $signed_request, 2);
        $sig = self::base64UrlDecode($encoded_sig);
        $data = json_decode(self::base64UrlDecode($payload), true);

        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            error_log('Unknown algorithm. Expected HMAC-SHA256');
            return null;
        }

        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;

    }

    protected static function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }


}
