<?php

require_once 'functions.php';

$data = json_decode(file_get_contents('php://input'), TRUE);
file_put_contents('file.txt', '$data: '.print_r($data, 1)."\n", FILE_APPEND);

const TOKEN = '';
const API_URL = 'https://api.telegram.org/bot';

$message = $data['message']['text'];
$name = $data["message"]["from"]["username"];
$first_name = $data['message']['from']['first_name'];
$last_name = $data['message']['from']['last_name'];

if($message == '/start') {
    $params = 'Hello, ' .$name. ' this is a bot that checks the availability of sites.';
}else if($message == 'https://t.me/serhii_dmytruk'){
    $params = 'https://t.me/serhii_dmytruk';
}else if(isSiteAvailible($message)){
    $params = 'Site '.$message. ' is available.';
}else if(!filter_var($message, FILTER_VALIDATE_URL)){
    $params = 'Invalid url. Url must contain the https://, site name, period "." and domain. Example https://{your-site}.domain';
}else {
    $params = 'Site '.$message. ' not available.';
}

getTelegramApi('sendMessage',
    [
        'text' =>  $params,
        'chat_id' => $data['message']['chat']['id']
    ]
);

