<?php

require 'config.php';

// Устанавливаем соединение с БД
try {
    $dbh = new PDO($dsn, $user, $pass);
    echo '<p>DB connection successful.</p>';
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Создаём экземпляр XML-парсера
$xml = simplexml_load_file($inputPath);
// и подготавливаем запрос вставки
$insertQuery = $dbh->prepare("INSERT INTO users (login, name, email) VALUES (:userLogin, :userName, :userEmail)");

// Перебираем каждого пользователя и вносим записи в БД
foreach ($xml as $user) {
    $insertQuery->bindParam(':userLogin', $user->login);
    $insertQuery->bindParam(':userName', $user->name);
    $insertQuery->bindParam(':userEmail', $user->email);
    try {
        $insertQuery->execute();
        echo "<p>Successfully inserted.</p>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Подготавливаем запрос выборки
$selectQuery = $dbh->prepare("SELECT login, name, email FROM users");
$selectQuery->execute();
// Считываем данные из БД
$results = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
// Получаем строку JSON-представления
$json = json_encode($results);
// Записывает в файл
file_put_contents($outputPath, $json);
