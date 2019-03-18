<?php

$COUNT_LAST_ITEMS = 5; // кол-во выводимых новостей

class Tools
{
    public static function request($url)
    {
        $ch = curl_init();
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url
        ];

        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}


$url = 'https://habr.com/ru/rss/best/daily/';

$data = Tools::request($url);

//parsed xml data
$xml_data = simplexml_load_string($data);

$result = [];
for ($i = 0; $i < $COUNT_LAST_ITEMS; $i++) {
    $item = $xml_data->channel->item[$i];
    $result[] = [
        'name' => (string)$item->title,
        'link' => (string)$item->link,
        'anons' => (string)$item->description
    ];
}
unset($item);

foreach ($result as $item) {
    echo "name: {$item['name']}, link: {$item['link']}, anons: {$item['anons']}" . PHP_EOL;
}
