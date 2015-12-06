<!DOCTYPE html>
<html lang="<?php echo core::$config['system']['defaultLang']; ?>">
 <head>
  <meta charset="<?php echo core::$config['system']['charset']; ?>">
  <meta name="description" content="<?php echo core::$config['system']['defaultDescription']; ?>">
  <title><?php echo core::$config['system']['defaultTitle']; ?></title>
  <link href="css/style.css" rel="stylesheet">
 </head>
 <body>
  <header>
   <h1><a href="index.php" title="Strona główna">Skrypt rejestracji i logowania</a></h1>
  </header>
  
  <section class="main-content">
  <div class="left-section">
   <nav>
    <ul>
	 <li><a href="index.php">Strona główna</a></li>
	 <?php if(!$session -> exists('id')) echo '<li><a href="?page=register">Rejestracja</a></li>'; ?>
	 <li><a href="?page=login">Logowanie</a></li>
	 <?php if($session -> exists('id')) echo '<li><a href="?page=user_panel">Panel użytkownika</a></li>';  ?>
	 </ul>
   </nav>
  </div>
  
  <div class="right-section">