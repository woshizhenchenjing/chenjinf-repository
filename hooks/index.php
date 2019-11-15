<?php

$path = '/usr/share/nginx/html/chenjing';
$requestBody = file_get_contents("php://input");
if (empty($requestBody)) {
    die('send fail');
}
$content = json_decode($requestBody, true);
//若是主分支且提交数大于0
if ($content['ref']=='refs/heads/master') {
    $res = shell_exec("cd {$path}  && git reset --hard origin/master && git fetch --all && sudo git pull");
    $res_log = '-------------------------'.PHP_EOL;
    $res_log .= $content['user_name'] . ' 在' . date('Y-m-d H:i:s') . '向' . $content['repository']['name'] . '项目的' . $content['ref'] . '分支push了' . $content['total_commits_count'] . '个commit：' . PHP_EOL;
    $res_log .= $res.PHP_EOL;
    file_put_contents("git-webhook.log", $res_log, FILE_APPEND);//追加写入
}


