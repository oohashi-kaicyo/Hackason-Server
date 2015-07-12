<?php
/**
 * @file
 * sample_push.php
 *
 * Push demo
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://code.google.com/p/apns-php/wiki/License
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to aldo.armiento@gmail.com so we can send you a copy immediately.
 *
 * @author (C) 2010 Aldo Armiento (aldo.armiento@gmail.com)
 * @version $Id$
 */
echo 'd';
date_default_timezone_set('Asia/Tokyo');
error_reporting(-1);//?
require_once 'ApnsPHP/Autoload.php';

$device_token = '2290c9ec028b078755909849a66d1ae2b83ea854eba2880f035395a2bc8c62de';
$url  = 'http://kaicyo.local/Hackason/ResisterContents.php';
$text = 'didUpperSwipeAnyone';
$push = new ApnsPHP_Push(
    ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
    'push_development.pem'
);

$push->setRootCertificationAuthority('entrust_root_certification_authority.pem');
$push->connect();

/* コンテンツの送信 */
$message = new ApnsPHP_Message($device_token);
$message->setCustomIdentifier("Message-Badge-3");//?
$message->setBadge(3);//?
$message->setText($text);
$message->setSound();// default sound
// Set a custom property, meta data
$message->setCustomProperty('url', $url);
//$message->setCustomProperty('acme3', array('bing', 'bong'));
$message->setExpiry(30);// Set the expiry value to 30 seconds

$push->add($message);
$push->send();
$push->disconnect();

$aErrorQueue = $push->getErrors();
if (!empty($aErrorQueue)) {
    var_dump($aErrorQueue);
}
