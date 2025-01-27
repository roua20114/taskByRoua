<?php
function getAccessToken() {
    $url = "https://api.baubuddy.de/index.php/login";
    $postData = json_encode(["username" => "365", "password" => "1"]);
    $headers = [
        "Authorization: Basic QVBJX0V4cGxvcmVyOjEyMzQ1NmlzQUxhbWVQYXNz",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    return $data['oauth']['access_token'];
}

function fetchTasks($accessToken) {
    $url = "https://api.baubuddy.de/dev/index.php/v1/tasks/select";
    $headers = ["Authorization: Bearer $accessToken"];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

$accessToken = getAccessToken();
$tasks = fetchTasks($accessToken);

header('Content-Type: application/json');
echo json_encode($tasks);
?>
