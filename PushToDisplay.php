<?php

date_default_timezone_set('Asia/Tokyo');
require_once('ApnsPHP/Autoload.php');
error_reporting(-1);
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
