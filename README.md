## SSO Riau
SSO Riau

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
use SsoRiau\SsoClientLibrary;
$objSso = new SsoClientLibrary();
$objSso->ssoRequest();

```
Consume SSO session :
----

```$php
$objSso = new SsoClientLibrary();
$data_access_token = $objSso->ssoCallback();
if (!empty($data_access_token)) {
    $data_access_token = json_decode($data_access_token);
    $access_token = $data_access_token->access_token; // store access_token within the session if needed?
}

if ($access_token != '') {
    //fetch ssoUserInfo
    $ssoUserInfo = $objSso->ssoUserInfo($access_token);
    $ssoUserInfo = json_decode($ssoUserInfo);
    $email = $ssoUserInfo->email;
}

```