<?php

$path = '/usr/share/nginx/html/chenjing';
shell_exec("cd {$path}  && git reset --hard origin/master && git fetch --all && sudo git pull");


