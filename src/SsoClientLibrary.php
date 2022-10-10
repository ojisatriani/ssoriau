<?php

namespace OjiSatriani\SsoRiau;

/*
 * Nama   : File SSO Riau client library
 * Tujuan : File ini dibuat dalam bentuk class objek sehingga dapat di integrasikan
 *          dengan aplikasi pihak ketiga yang ingin terhubung menggunakan aplikasi SSO
 * Deskripsi Variable :
 *  $clientId
 *  - merupakan identitas unik ID yang diperoleh saat mendaftarkan
 *    aplikasi pihak ketiga pada aplikasi SSO
 *  $clientSecret
 *  - merupakan identitas unik Secret (rahasia) yang digunakan saat akses 
 *    kepada aplikasi SSO sehingga diizinkan
 *  $redirectUri
 *  - merupakan alamat url yang akan mengelola hasil informasi login SSO
 *  $targetUri
 *  - adalah alamat website aplikasi SSO
 * 
 */

class SsoClientLibrary {

    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    protected $targetUri;

    public function __construct(array $config = []) {
        $this->clientId = $config['client_id'] ?? '';   // 3rd Party client Id
        $this->clientSecret = $config['client_secret'] ?? '';   // 3rd Party client secret
        $this->redirectUri = $config['redirect_uri'] ?? '';  // 3rd Party url redirect or url to handle callback
        $this->targetUri = $config['target_uri'] ?? '';    // SSO Riau portal
    }

    public function ssoRequest() {
        $state = base64_encode(random_bytes(40));
        $query = http_build_query([
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);

        $_url = $this->targetUri ."oauth/authorize?" . $query;
        echo '<pre>';print_r($_url);
        header("Location: " . $_url);
        die();
    }

    public function ssoCallback() {
        if (isset($_GET['code']) && !empty(($_GET['code']))) {
            $_access_token = '';
            $_errors = '';

            $_posts = [
                'grant_type' => 'authorization_code',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri' => $this->redirectUri,
                'code' => $_GET['code'],
            ];
            $arr_token = $this->__runCurl('POST', $this->targetUri."oauth/token", $_posts);
            return $arr_token;
        }
        die('Something went wrong, please trace back your action!');
    }

    public function ssoUserInfo($access_token) {
        if ($access_token != '') {
            $header = [
                'Content-Type: application/json',
                'Authorization: Bearer '.$access_token,
            ];
            $user_info = $this->__runCurl('GET', $this->targetUri."api/userInfo", [], $header);
            return $user_info;
        }
        die('Something went wrong, please trace back your action!');
    }

    public function ssoAsnInfo($access_token, $nip) {
        if ($access_token != '' && $nip != '') {
            $header = [
                'Content-Type: application/json',
                'Authorization: Bearer '.$access_token,
            ];

            $query = http_build_query([
                'nip' => $nip
            ]);
            $asn_info = $this->__runCurl('POST', $this->targetUri."api/userData?".$query, [], $header);
            return $asn_info;
        }
        die('Something went wrong, please trace back your action!');
    }

    private function __runCurl($method = 'GET', $url, $data = [], $header = []) {
        $error = '';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        //curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);
        if (curl_error($ch)) {
            $error = curl_error($ch);
        }
        curl_close($ch);

        if ($error == '' && !empty($response)) {
            return $response;
        } else {
            return $error;
        }
        die('Something went wrong, please trace back your action!');
    }

    public function ssoLogout($url_back = '') {
        $query = http_build_query([
            'url_back' => $url_back,
        ]);

        $_url = $this->targetUri ."sso/logout?" . $query;
        header("Location: " . $_url);
        die();
    }

}