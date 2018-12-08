<?php 

$command = escapeshellcmd('python ./Client.py');
$output = shell_exec($command);
echo $output;

?>