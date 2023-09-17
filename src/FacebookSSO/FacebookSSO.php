<?php

namespace RedDot\FacebookSSO;

class FacebookSSO
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct(string $clientId, string $clientSecret, string $redirectUri)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri; //urn:ietf:wg:oauth:2.0:oob
    }


    //Invoking the Login Dialog and Setting the Redirect URL
    public function getLoginUrl(): string
    {
        $state = "state";
        $response_type = "code"; // code/token/code%20token/granted_scopes 
        $scope = "email public_profile"; 
        $loginUrl = "https://www.facebook.com/v18.0/dialog/oauth?client_id={$this->clientId}&redirect_uri={$this->redirectUri}&state={$state}&scope={$scope}&response_type={$response_type}";
        return $loginUrl;
    }


    // Response data is included as URL parameters and contains
        // code: when server handles the token, <AUTHORIZATION_CODE>
        // token: when client handles the token, <ACCESS_TOKEN>


    //Handling Login Dialog Response
    public function handleCallback(string $code): array
    {
        $accessToken = $this->getAccessToken($code);
        $userData = $this->getUserData($accessToken);
      
        return $userData;
    }


    //Exchanging Code for an Access Token
    private function getAccessToken(string $code): string
    {
        $url = "https://graph.facebook.com/v18.0/oauth/access_token";
        $params = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $code
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Respose: JSON
        // {
        //   "access_token": {access-token}, 
        //   "token_type": {type},
        //   "expires_in":  {seconds-til-expiration}
        // }

        $result = json_decode($response, true);
        $accessToken = $result['access_token'];

        return $accessToken;
    }

    
    //Use Access Token to make requests to Graph API
    private function getUserData(string $accessToken): array
    {
        $url = "https://graph.facebook.com/v18.0/me?fields=id,name,email,picture";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $accessToken]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $userData = json_decode($response, true);
    
        $result = [
            'id' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'picture' => $userData['picture']['data']['url'],
        ];
    
        return $result;
    }
}
?>