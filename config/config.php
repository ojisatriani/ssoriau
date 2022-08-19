<?php

return [

    /*
    |--------------------------------------------------------------------------
    | clientId
    |--------------------------------------------------------------------------
    |
    | merupakan identitas unik ID yang diperoleh saat mendaftarkan
    | aplikasi pihak ketiga pada aplikasi SSO
    |
    */

    'client_id' => env('SSO_RIAU_CLIENT_ID', ''),  // 3rd Party client Id

    /*
    |--------------------------------------------------------------------------
    | clientSecret
    |--------------------------------------------------------------------------
    |
    | merupakan identitas unik Secret (rahasia) yang digunakan saat akses 
    | kepada aplikasi SSO sehingga diizinkan
    |
    */

    'client_secret' => env('SSO_RIAU_CLIENT_SECRET', ''),  // 3rd Party client secret

    /*
    |--------------------------------------------------------------------------
    | redirectUri
    |--------------------------------------------------------------------------
    |
    | merupakan alamat url yang akan mengelola hasil informasi login SSO 
    | yang akan diarahkan ke halaman utama aplikasi
    |
    */

    'redirect_uri' => env('SSO_RIAU_REDIRECT_URI', ''),  // 3rd Party url redirect or url to handle callback

    /*
    |--------------------------------------------------------------------------
    | targetUri
    |--------------------------------------------------------------------------
    |
    | adalah alamat website aplikasi SSO 
    | 
    |
    */

    'target_uri' => env('SSO_RIAU_TARGET_URI', ''),    // SSO Riau portal
];