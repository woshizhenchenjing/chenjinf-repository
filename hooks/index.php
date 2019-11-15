<?php
error_reporting(1);
// 生产环境web目录
$web_path = '/usr/share/nginx/html/chenjing';

$client_ip = $_SERVER['REMOTE_ADDR'];
$fs = fopen('./auto_hook.log', 'a');
fwrite($fs, 'Request on ['.date("Y-m-d H:i:s").'] from ['.$client_ip.']'.PHP_EOL);

// 头部信息
$data_headers = getallheaders();
// Payload的数据信息
$json_content = file_get_contents('php://input');
// secret
$secret_code = '!@#Cj121256';

$signature = "sha1=".hash_hmac( 'sha1', $json_content,$secret_code);
if(strcmp($signature, $data_headers['X-Hub-Signature']) == 0){
    fwrite($fs, 'X-Hub-Signature:OK '.PHP_EOL);
    $cmd = "cd $web_path && git pull";
    shell_exec($cmd);
}else{
    fwrite($fs, 'X-Hub-Signature:NO '.PHP_EOL);
}


