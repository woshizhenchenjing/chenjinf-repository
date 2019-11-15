<?php
error_reporting(1);
// 生产环境web目录
$web_path = '/usr/share/nginx/html/chenjing';

//作为接口传输的时候认证的密钥
$valid_token = '!@#Cj121256';

$client_ip = $_SERVER['REMOTE_ADDR'];
$fs = fopen('./auto_hook.log', 'a');
fwrite($fs, 'Request on ['.date("Y-m-d H:i:s").'] from ['.$client_ip.']'.PHP_EOL);

$json_content = file_get_contents('php://input');
$data = json_decode($json_content, true);

fwrite($fs, '[ token='.$data['token'].';'.($data['token'] !== $valid_token).']'.PHP_EOL);

$fs and fclose($fs);

if (empty($data['token']) || $data['token'] !== $valid_token) {
    exit('aInvalid token request');
}

$cmd = "cd $web_path && git pull";
shell_exec($cmd);
