<?php

require_once 'config.php';

try {
    $dbh = new PDO($dsn, $dbUser, $dbPassword);
} catch (PDOException $e) {
    echo 'Произошла ошибка при подключении к базе данных.';
    die();
}

$selectQuery = $dbh->prepare("SELECT * FROM ex4php WHERE ID = " . $_POST['id']);
$status = $selectQuery->execute();

if ($status) {
    $data = $selectQuery->fetchAll();

    foreach ($data as $url) {
        echo 'ID: ' . $url['ID'] . '<br>';
        echo 'URL: ' . $url['reference'] . '<br><br>';
    }
} else {
    echo 'Данные не найдены.';
}
