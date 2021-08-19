<?php

require_once 'config.php';

// Шаблон для поиска ссылок
$pattern = "/(\d+-*\d+)/";

// Устанавливаем соединение с БД
try {
    $dbh = new PDO($dsn, $dbUser, $dbPassword);
} catch (PDOException $e) {
    echo 'Произошла ошибка при подключении к базе данных.';
    die();
}

// Формируем запрос выборки из БД
$selectQuery = $dbh->prepare("SELECT * FROM ex4php");
$selectQuery->execute();
$urls = $selectQuery->fetchAll();

// Меняем ссылки по шаблону
foreach ($urls as $url) {
    $newUrlId = [];
    if (preg_match($pattern, $url['reference'], $newUrlId)) {
        $newUrl = 'https://sozd.parlament.gov.ru/bill/' . $newUrlId[0];
        $updateQuery = $dbh->prepare("UPDATE ex4php SET reference = :ref WHERE ID = :id");
        $updateQuery->bindParam(':ref', $newUrl);
        $updateQuery->bindParam(':id', $url['ID']);
        $status = $updateQuery->execute();
        if ($status) {
            echo 'Ссылка ID = ' . $url['ID'] . ' заменена.<br>';
        } else {
            echo 'Ссылка ID = ' . $url['ID'] . ' не заменена.<br>';
        }
    }
}
