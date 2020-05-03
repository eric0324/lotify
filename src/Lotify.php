<?php
namespace Ericwu\Lotify;

class Lotify {
    const DEFAULT_BOT_ENDPOINT_BASE = 'https://notify-bot.line.me';
    const DEFAULT_API_ENDPOINT_BASE = 'https://notify-api.line.me';

    public function __construct(array $args)
    {
        $this->botEndpointBase = Lotify::DEFAULT_BOT_ENDPOINT_BASE;
        $this->apiEndpointBase = Lotify::DEFAULT_API_ENDPOINT_BASE;

        $this->channelSecret = $args['channelSecret'];
        $this->clientId      = $args['clientId'];
        $this->redirectUri   = $args['redirectUri'];
    }

    public function getAuthLink($state)
    {
        $authLink = $this->botEndpointBase.
            '/oauth/authorize?scope=notify&response_type=code'.
            '&client_id=' . $this->clientId.
            '&redirect_uri=' . $this->redirectUri.
            '&state=' . $state;

        return $authLink;
    }

    public function getAccessToken($code)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->botEndpointBase . '/oauth/token');
        curl_setopt($ch, CURLOPT_POST, true);
        $params = [
            "grant_type"    => "authorization_code",
            "code"          => $code,
            "redirect_uri"  => $this->redirectUri,
            "client_id"     => $this->clientId,
            "client_secret" => $this->channelSecret
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); 
        curl_close($ch);
        $json = json_decode($result, true);
        $token = $json['access_token'];
        return $token;
    }

    public function getStatus($accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiEndpointBase . '/api/status');
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $accessToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); 
        curl_close($ch);
        return json_decode($result, true);
    }

    public function sendMessage($accessToken, $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiEndpointBase . '/api/notify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $accessToken
        ));
        $params = [
            'message' => $message
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); 
        curl_close($ch);
        return json_decode($result, true);   
    }

    public function sendMessageWithSticker(
        $accessToken,
        $message,
        $stickerId,
        $stickerPackageId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiEndpointBase . '/api/notify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $accessToken
        ));
        $params = [
            'message'          => $message,
            'stickerId'        => $stickerId,
            'stickerPackageId' => $stickerPackageId
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); 
        curl_close($ch);
        return json_decode($result, true);  
    }

    public function sendMessageWithImageUrl(
        $accessToken,
        $message,
        $imageThumbnail,
        $imageFullsize
    )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiEndpointBase . '/api/notify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $accessToken
        ));
        $params = [
            'message'        => $message,
            'imageFullsize'  => $imageFullsize,
            'imageThumbnail' => $imageThumbnail
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); 
        curl_close($ch);
        return json_decode($result, true);  
    }

    public function revoke($accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiEndpointBase . '/api/revoke');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $accessToken
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); 
        curl_close($ch);
        return json_decode($result, true); 
    }

}