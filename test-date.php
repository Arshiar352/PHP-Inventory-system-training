<?php

require_once __DIR__ . '/vendor/autoload.php';

use Hekmatinasser\Verta\Verta;

$dates = [
    '1405/08/19',
    '1405/15/40',
    '1405/12/35',
    'abc',
    '۱۳۸۲/۰۵/۲۰',
];


foreach ($dates as $date) {
    try {

        $date = strtr($date, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9'
        ]);

        $result = Verta::parse($date);
        echo $date . ' => ' . $result . PHP_EOL;
    } catch (Throwable $e) {
        echo $date . ' => Invalid date' . PHP_EOL;
    }
}
