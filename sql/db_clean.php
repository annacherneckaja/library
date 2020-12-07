<?php
$login_path = 'backup';
$dbname = 'library';
$dir = 'C:\MAMP\htdocs\library\sql\0006_db_clean.sql';
$command = sprintf('C:\\MAMP\\bin\\mysql\\bin\\mysql --login-path=%s %s < %s', $login_path, $dbname, $dir);
exec($command);
