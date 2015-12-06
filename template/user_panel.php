<?php
if(!$session -> exists('id') || !$session -> exists('login'))
{
 return 'Brak uprawnień.';
}
else
{
$user = new User($pdo);
$result = $user -> getUserData();

echo '<p><b>IP:</b> '. $result['ip'].'</p>';
echo '<p><b>User_agent:</b> '. $result['user_agent'].'</p>';
echo '<p><b>Zarejestrowano:</b> '. $result['date'].'</p>';

echo '<p><a href="?page=logout">wyloguj</a></p>';
}
