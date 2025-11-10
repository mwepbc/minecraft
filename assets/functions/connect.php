<?php

// Подключение к базе
$dsn = 'mysql:dbname=minecraft;host=127.0.0.1;port=3306';
// для опенсервера
// $dsn = 'mysql:dbname=minecampf;host=127.0.0.1;port=3307';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Если есть $_POST['function'] — это FormData
        if (isset($_POST['function'])) {
            $function = $_POST['function'];
            $data = $_POST;
        } else {
            // Иначе — JSON
            $input = json_decode(file_get_contents('php://input'), true);
            $function = $input['function'] ?? null;
            $data = $input;

            foreach ($data as $e) {
                $e = ($e == 'null') ? NULL : $e;
            }
        }
    }

    // $input = file_get_contents('php://input');
    // $data = json_decode($input, true);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

?>