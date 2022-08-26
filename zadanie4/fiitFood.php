<?php

// Read the JSON file
$json = file_get_contents('./storage/restaurant2.json');

// Decode the JSON file
$json_data = json_decode($json, true);

$fiitJedla = $json_data['data'];


$interval = date_diff(DateTime::createFromFormat('U', $json_data['timestamp']), new DateTime());
$timeDifference = (new DateTime())->getTimestamp() - $json_data['timestamp'];
// printing result in days format


if ($timeDifference > 800) {
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, "http://www.freefood.sk/menu/#fiit-food");

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch);

    $dom = new DOMDocument();

    @$dom->loadHTML($output);
    $dom->preserveWhiteSpace = false;
    $fiitFood = $dom->getElementById("fiit-food");
    $ul = $fiitFood->getElementsByTagName('ul')->item(0);
    $fiitJedla = [
        ["date"  => date( 'd.m.Y', strtotime( 'monday this week' ) ), "day" => "Pondelok", "menu" => []],
        ["date"  => date( 'd.m.Y', strtotime( 'tuesday this week' ) ), "day" => "Utorok", "menu" => []],
        ["date"  => date( 'd.m.Y', strtotime( 'wednesday this week' ) ), "day" => "Streda", "menu" => []],
        ["date"  => date( 'd.m.Y', strtotime( 'thursday this week' ) ), "day" => "Štvrtok", "menu" => []],
        ["date"  => date( 'd.m.Y', strtotime( 'friday this week' ) ), "day" => "Piatok", "menu" => []],
        ["date"  => date( 'd.m.Y', strtotime( 'saturday this week' ) ), "day" => "Sobota", "menu" => []],
        ["date"  => date( 'd.m.Y', strtotime( 'sunday this week' ) ), "day" => "Nedeľa", "menu" => []],
    ];

    foreach ($ul->childNodes as $index => $li_den){

        foreach ($li_den->childNodes->item(1)->childNodes as $li_jedlo)
        {
            $typ = trim($li_jedlo->childNodes->item(0)->nodeValue);
            $jedlo = trim($li_jedlo->childNodes->item(1)->nodeValue);
            $cena= trim($li_jedlo->childNodes->item(2)->nodeValue);
            array_push($fiitJedla[$index-1]["menu"], "$typ$jedlo : $cena");

        }

    }

    $data = ["timestamp" => (new DateTime())->getTimestamp(),"restaurant" => "Fiit food", "data" => $fiitJedla];


    $fp = fopen('./storage/restaurant2.json', 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
}
