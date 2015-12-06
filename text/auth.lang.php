<?php
if(isset($_SERVER['HTTP_REFERER'])) {
    $back = '<p><a href="' . $_SERVER['HTTP_REFERER'] . '" class="back">Powrót</a></p>';
} else {
    $back = null;
}

$lang['auth'][0] = 'Wypełnij wszystkie pola formularza.'.$back;
$lang['auth'][1] = 'Zalogowałeś się pomyślnie. Za chwile nastąpi przekierowanie.';
$lang['auth'][2] = 'Brak podanego użytkownika w bazie danych.'.$back;
$lang['auth'][3] = 'Niepoprawny adres E-mail.'.$back;
$lang['auth'][4] = 'Podany login jest już zajety.'.$back;
$lang['auth'][5] = 'Podany E-mail jest już zajęty.'.$back;
$lang['auth'][6] = 'Zarejestrowano pomyślnie. Teraz możesz się zalogować.';
$lang['auth'][7] = 'Rejestracja zakończyła się niepomyślnie. Spróbuj ponownie za jakiś czas.'.$back;