<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$dataFields = $_REQUEST;
$name = trim(strip_tags(htmlspecialcharsBack($dataFields['name'])));
$phone = trim(strip_tags(htmlspecialcharsBack($dataFields['phone'])));
$email = trim(strip_tags(htmlspecialcharsBack($dataFields['email'])));
$message = trim(strip_tags(htmlspecialcharsBack($dataFields['message'])));

$arEventFields = array(
    'NAME' => $name,
    'PHONE' => $phone,
    'EMAIL' => $email,
    'MESSAGE' => $message,
);
// отправка сообщений
$event = new CEvent;
$event->Send("FEEDBACKMESSAGE", SITE_ID, $arEventFields);
echo 'Сообщение отправлено';