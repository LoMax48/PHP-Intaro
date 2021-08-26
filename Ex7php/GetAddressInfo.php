<?php

if (isset($_POST['address'])) {

    $params = [
        'apikey' => '',
        'geocode' => $_POST['address'],
        'format' => 'json',
    ];

    $response = file_get_contents('https://geocode-maps.yandex.ru/1.x/?' . http_build_query($params));
    $responseObject = json_decode($response, true);
    $addressComponents = $responseObject['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'];
    $addressCoords =  str_replace(' ', ',', $responseObject['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']);

    $params = [
        'apikey' => '',
        'geocode' => $addressCoords,
        'kind' => 'metro',
        'format' => 'json',
        'results' => 1,
    ];

    $response = file_get_contents('https://geocode-maps.yandex.ru/1.x/?' . http_build_query($params));
    $responseMetroObject = json_decode($response, true);
    $metro = $responseMetroObject['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
    
    $result =[];

    foreach ($addressComponents as $component) {
        $result['address'][$component['kind']] = $component['name'];
    }

    $result['coords'] = $addressCoords;
    $result['metro'] = $metro;

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}