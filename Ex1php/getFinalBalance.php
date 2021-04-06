<?php

function getFinalBalance($path)
{
    $fs = fopen($path, 'r');
    $balance = 0;

    // Заполняем данные о ставках
    $betsNumber = fgets($fs);
    $bets = [];
    for ($i = 0; $i < $betsNumber; $i++) { // Создаём список ставок
        list($gameID, $betAmount, $betResult) = explode(" ", fgets($fs));
        $bets[$gameID]['betAmount'] = (int)$betAmount;
        $bets[$gameID]['betResult'] = trim($betResult, "\n\r");
    }

    // Заполняем данные об играх
    $gamesNumber = fgets($fs);
    $games = [];
    for ($i = 0; $i < $gamesNumber; $i++) { // Создаём список игр
        list($gameID, $gameCoeffL, $gameCoeffR, $gameCoeffD, $gameResult) = explode(" ", fgets($fs));
        $games[$gameID]['gameCoeffL'] = (float)$gameCoeffL;
        $games[$gameID]['gameCoeffR'] = (float)$gameCoeffR;
        $games[$gameID]['gameCoeffD'] = (float)$gameCoeffD;
        $games[$gameID]['gameResult'] = trim($gameResult, "\n\r");
    }

    // Определяем, прошла ли ставка, и изменяем баланс
    foreach ($bets as $gameID => $bet) {
        if ($bet['betResult'] == $games[$gameID]['gameResult']) {
            $balance += ($games[$gameID]['gameCoeff'.$bet['betResult']] - 1) * $bet['betAmount'];
        } else {
            $balance -= $bet['betAmount'];
        }
    }

    return $balance;
}