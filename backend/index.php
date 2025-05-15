<?php

header("Access-Control-Allow-Origin: *");

$apiUrl = 'http://case-test-api.humanas.io/';
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

function predictByAverageInterval($logins) {
    
    // Tahmin 1: Ortalama Zaman Aralığına Dayalı Tahmin
    // Kullanıcının login zamanları arasındaki tüm sürelerin ortalaması alınır.
    // Bu ortalama, son login zamanı eklenerek bir sonraki olası login zamanı tahmin edilir.

    if (count($logins) < 2) return [null, 0];

    $timestamps = array_map('strtotime', $logins);
    $intervals = [];

    for ($i = 1; $i < count($timestamps); $i++) {
        $intervals[] = $timestamps[$i] - $timestamps[$i - 1];
    }

    $avg = array_sum($intervals) / count($intervals);
    $stdDev = standardDeviation($intervals);
    $confidence = $stdDev < 3600 ? 90 : 65; 

    // Kullanıcı giriş aralıklarının standart sapması küçükse tahmin daha güvenilir olur.
    // Eğer sapma 1 saatten az ise %90 güven, daha fazlası ise %65 güven.

    $lastLogin = end($timestamps);
    return [date('Y-m-d H:i:s', $lastLogin + $avg), $confidence];
}


function predictByMostFrequentHour($logins) {

    // Tahmin 2: En Sık Login Olunan Saate Dayalı Tahmin
    // Kullanıcının login olduğu saatler (örneğin 09:00, 10:00...) sayılarak en sık tekrar eden saat belirlenir. 
    // Son login tarihinin bir sonraki günü, bu saat ile birleştirilerek tahmin edilir.

     if (empty($logins)) return [null, 0];

    $hours = [];

    foreach ($logins as $login) {
        $hour = (int)date('H', strtotime($login));
        $hours[$hour] = ($hours[$hour] ?? 0) + 1;
    }

    
    // Örneğin kullanıcı akşam 20:00 gibi hep aynı saatte giriyorsa alışkanlık haline getirmiştir.
    // Bunu baz alarak eğer o saat 3+ kez tekrar ediyorsa %85, daha az tekrar var ise %60 gücen.

    arsort($hours);
    $mostHour = array_key_first($hours);
    $confidence = max($hours) >= 3 ? 85 : 60; // En az 3 tekrar varsa güven yüksek

    $nextDay = strtotime('+1 day', strtotime(end($logins)));
    $formatted = date('Y-m-d', $nextDay) . " " . str_pad($mostHour, 2, '0', STR_PAD_LEFT) . ":00:00";

    return [$formatted, $confidence];
}

function standardDeviation($array) {
    $n = count($array);
    if ($n === 0) return 0;
    $mean = array_sum($array) / $n;
    $variance = array_sum(array_map(fn($x) => pow($x - $mean, 2), $array)) / $n;
    return sqrt($variance);
}

$result = [];

$users =  $data['data']['rows'];
foreach ($users as $user) {

    $logins = $user['logins'];
    [$pred1, $conf1] = predictByAverageInterval($logins);
    [$pred2, $conf2] = predictByMostFrequentHour($logins);

    $result[] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'lastLogin' => end($logins),
        'prediction1' => $pred1,
        'prediction2' => $pred2,
        'confidence1' => $conf1,
        'confidence2' => $conf2
    ];
}

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);

?>
