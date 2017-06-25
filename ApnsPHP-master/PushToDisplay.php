<?php

date_default_timezone_set('Asia/Tokyo');
require_once('ApnsPHP/Autoload.php');
error_reporting(-1);
echo 'rr';
//Myj's iPad
//067ee4422fb01c002a1754ff0127d70b0663486916603d2eac8e3181cf32333b
//kaicyo's iPhone 5
//2290c9ec028b078755909849a66d1ae2b83ea854eba2880f035395a2bc8c62de
/*
$device_token = '067ee4422fb01c002a1754ff0127d70b0663486916603d2eac8e3181cf32333b';
$url  = 'http://133.2.37.224/Hackason/upload/apple.jpg';
$text = 'didUpperSwipeAnyone';
*/
function pushToDisplay($device_token, $url, $text)
{
    $push = new ApnsPHP_Push(
        ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
        'push_development.pem'
    );

    $push->setRootCertificationAuthority('entrust_root_certification_authority.pem');
    $push->connect();

    $message = new ApnsPHP_Message($device_token);
    $message->setCustomIdentifier("Message-Badge-3");
    $message->setBadge(3);
    $message->setText($text);
    $message->setSound();
    $message->setCustomProperty('url', $url);
    $message->setExpiry(30);

    $push->add($message);
    $push->send();
    $push->disconnect();

    $aErrorQueue = $push->getErrors();
    if (!empty($aErrorQueue)) {
        var_dump($aErrorQueue);
    }
}
