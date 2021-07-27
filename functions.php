<?php

require_once 'index.php';

function getTelegramApi($method, $options = null) {
    $str_request = API_URL . TOKEN . '/' . $method;

    if ($options) {
        $str_request .= '?' . http_build_query($options);
    }
    $request = file_get_contents($str_request);

    return json_decode($request, 1);
}

//https://api.telegram.org/bot1932792122:AAExnUJFXFRXdGJE_tj8DC8WujDCkEqMISI/getUpdate

function setHook($set = 1) {
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    printAnswer(
        getTelegramApi('setWebhook',
            [
                'url' => $set?$url:''
            ]
        )
    );
    exit();
}
/* Set Hook */
//setHook(1);


function isSiteAvailible($message) {

    // Проверка правильности URL
    if(!filter_var('https://'.$message, FILTER_VALIDATE_URL)){
        return false;
    }

    // Инициализация cURL
    $curlInit = curl_init($message);

    // Установка параметров запроса
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

    // Получение ответа
    $response = curl_exec($curlInit);

    // закрываем CURL
    curl_close($curlInit);

    return $response ? true : false;
}
