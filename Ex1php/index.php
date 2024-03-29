<?php

require 'getFinalBalance.php';

// Считываем данные тестов
$inputFiles = glob("tests/*.dat");
$outputFiles = glob("tests/*.ans");

$index = 1;

// Создаём массив для сравнения ответов
foreach (array_combine($inputFiles,$outputFiles) as $input => $output) {
    $fs = fopen($output, 'r');
    $rightAnswer = trim(fgets($fs), " \n\r\t");
    $programAnswer = round(getFinalBalance($input));
    echo "<p>Test $index: ";
    if ($rightAnswer == $programAnswer) {
        echo "Passed.</p>";
    } else {
        echo "Failed.</p><p>Correct answer: $rightAnswer.</p><p>Your answer: $programAnswer.</p>";
    }
    $index++;
}