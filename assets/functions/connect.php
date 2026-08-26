<?php
include('db_params.php');

$dsn = 'mysql:dbname='.$DB_NAME.';host='.$DB_HOST.';port='.$DB_PORT;

try {
    $dbh = new PDO($dsn, $DB_USER, $DB_PASS, [
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
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

?>