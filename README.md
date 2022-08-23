## SSO Riau
SSO Riau

## Installation

Require the `ojisatriani/ssoriau` package in your `composer.json` and update your dependencies:
```sh
composer require ojisatriani/ssoriau
```

## Configuration Laravel

Open the file `config/app.php`. and then add following service provider (This step is optional if you are using Laravel 5.5+):
```$php
'providers' => [
    // ...
    OjiSatriani\SsoRiau\Laravel\ServiceProvider::class,
],
```

The defaults are set in `config/ssoriau.php`. Publish the config to copy the file to your own config:
```sh
php artisan vendor:publish --provider="OjiSatriani\SsoRiau\Laravel\ServiceProvider" --tag="config"
```

Config Sso Riau:
----

```$php
'client_id' => env('SSO_RIAU_CLIENT_ID', ''),  // 3rd Party client Id
'client_secret' => env('SSO_RIAU_CLIENT_SECRET', ''),  // 3rd Party client secret
'redirect_uri' => env('SSO_RIAU_REDIRECT_URI', ''),  // 3rd Party url redirect or url to handle callback
'target_uri' => env('SSO_RIAU_TARGET_URI', ''),    // SSO Riau portal

```
Check SSO session :
----

```$php
/**
* SSO login : check SSO session
*/
public function check(SsoClientLibrary $sso)
{
    $sso->ssoRequest();
}

```
Consume SSO session :
----

```$php
public function callback(Request $request, SsoClientLibrary $sso)
{
    $data_access_token = $sso->ssoCallback();
    if (!empty($data_access_token)) {
        $data_access_token = json_decode($data_access_token);
        $access_token = $data_access_token->access_token; // store access_token within the session if needed?
    }

    if ($access_token != '') {
        //fetch ssoUserInfo
        $ssoUserInfo = $sso->ssoUserInfo($access_token);
        $ssoUserInfo = json_decode($ssoUserInfo);
        $email = $ssoUserInfo->email;
    }
}

```