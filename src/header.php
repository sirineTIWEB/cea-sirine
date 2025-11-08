<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>site de CEA</title>
    <?php wp_head(); ?>
</head>
<body>
    
<?php
wp_nav_menu(array(
  'container' => false, // Ne pas mettre de container
  'menu_class' => 'navbar-nav fw-bold justify-content-end align-items-center flex-grow-1', // Ajouter des classes à <ul>
  'menu_id' => 'navbar', // Ajouter un ID à <ul>
));
?>
