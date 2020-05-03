# Lotify - LINE Notify client SDK

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/eric0324/lotify#contributing)
[![PHP version](https://badge.fury.io/ph/eric0324%2Flotify.svg)](https://badge.fury.io/ph/eric0324%2Flotify)


**Lotify** is a [LINE Notify](https://notify-bot.line.me/doc/en/) client SDK that you can build Notify bot quickly.

# Usage

You need a **LINE account** and create a Notify: [Link](https://notify-bot.line.me/my/services/new)

## Install package

```
composer require eric0324/lotify
```

## Initialize instance

```php
use Ericwu\Lotify\Lotify;

$channelSecret = "<YOUR_CHANNEL_SECRET>";
$clientId = "<YOUR_CLIENT_ID>";
$redirectUri = "<YOUR_REDIRECT_URI>";
$lotify = new Lotify([
    'channelSecret'=> $channelSecret,
    'clientId' => $clientId,
    'redirectUri' => $redirectUri
]);
```

## Get authorizer link

```php
$link = $lotify->getAuthLink('<RANDOM_STRING>');
echo($link);
# https://notify-bot.line.me/oauth/authorize?scope=notify&response_type=code&client_id=QxUxF..........i51eITH&redirect_uri=http%3A%2F%2Flocalhost%3A5000%2Fnotify&state=foo
```

## Get access token

```php
$access_token = $lotify->getAccessToken('<NOTIFY_RESPONSE_CODE>');
echo($access_token);
# N6g50DiQZk5Xh...25FoFzrs2npkU3z
```

## Get Status
```php
$status = $lotify->getStatus('<YOUR_ACCESS_TOKEN>');
echo($status);
# {'status': 200, 'message': 'ok', 'targetType': 'USER', 'target': 'Eric wu'}
```


## Send message

```php
$response = $lotify->sendMessage(access_token='<YOUR_ACCESS_TOKEN>', message='<This is notify message>');
echo($response);
# {'status': 200, 'message': 'ok'}
```

## Send message with Sticker

You can find stickerId and stickerPackageId [here](https://devdocs.line.me/files/sticker_list.pdf)
 
```php
$response = $lotify->sendMessageWithSticker('<YOUR_ACCESS_TOKEN>', '<This is notify message>', '<sticker_id>', '<sticker_package_id>');
echo($response);
# {'status': 200, 'message': 'ok'}
```


## Send message with Image url


```php
$image = $lotify->sendMessageWithImageUrl(
    '<YOUR_ACCESS_TOKEN>',
    '<This is notify message>',
    '<IMAGE_THUMBNAIL_URL>',
    '<IMAGE_FULLSIZE>',
);
echo($image);
# {'status': 200, 'message': 'ok'}
```

## Revoke access token

```php
$revoke = $lotify->revoke('<YOUR_ACCESS_TOKEN>');
echo($revoke);
# {'status': 200, 'message': 'ok'}
```


# License
MIT © [Eric Wu](https://ericwu.asia/about/)
