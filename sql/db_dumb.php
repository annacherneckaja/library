<?php
$login_path = 'backup';
$dbname = 'library';
$file_name = date('Yms-his.') . $dbname . '.sql';
$dir = 'C:/MAMP/db/dump/' . $file_name;
$command = sprintf('C:\\MAMP\\bin\\mysql\\bin\\mysqldump --login-path=%s %s > %s', $login_path, $dbname, $dir);
exec($command);
