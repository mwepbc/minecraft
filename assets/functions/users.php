<?php
include('connect.php');
// функция запроса всех юзеров из бд
function allUsers($dbh)
{
    $sth = $dbh->prepare('SELECT * FROM users');
    $sth->execute();
    $users = $sth->fetchAll();

    return $users;
}

// функция поиска юзера по логину и паролю
function auth($dbh, $login, $password)
{
    if (empty($login) || empty($password)) {
        echo json_encode(["error" => "Заполните все поля"]);
        exit();
    }

    $sth = $dbh->prepare('SELECT *
    FROM users
    WHERE login=?');
    $sth->execute([$login]);
    $user = $sth->fetch();

    if (!$user) {
        echo json_encode(['error' => 'Такого пользователя не существует']);
        exit();
    }

    if (password_verify($password, $user['password']))
        echo json_encode($user);
    else
        echo json_encode(['error' => 'Неверный пароль']);
}

// функция поиска юзера по айди
function userById($dbh, $id)
{
    $sth = $dbh->prepare('SELECT *
    FROM users
    WHERE id=?');
    $sth->execute([$id]);
    $user = $sth->fetch();

    return $user;
}

// функция вставки юзера в бд
function insertUser($dbh, $login, $password)
{
    if (empty($login) || empty($password)) {
        echo json_encode(["error" => "Заполните все поля"]);
        exit();
    }

    $sth = $dbh->prepare('INSERT INTO `users`
    (`id`, `login`, `password`, `role`)
    VALUES (NULL, ?, ?, "user")');
    $sth->execute([$login, password_hash($password, PASSWORD_DEFAULT)]);

    echo json_encode(['yay']);
}

// функция проверки на админские права
function adminVerify($dbh, $id)
{
    if ($id == 0) {
        echo json_encode(false);
        die();
    }

    $sth = $dbh->prepare('SELECT *
    FROM users
    WHERE id=?');
    $sth->execute([$id]);
    $user = $sth->fetch();

    if ($user['role'] == 'admin')
        echo json_encode(true);
    else
        echo json_encode(false);
}

try {
    switch ($function) {
        case 'adminVerify':
            adminVerify($dbh, $data['id_user']);
            break;

        case 'auth':
            auth($dbh, $data['login'], $data['password']);
            break;

        case 'insertUser':
            insertUser($dbh, $data['login'], $data['password']);
            break;
    }
} catch (\Throwable $th) {
    echo json_encode(['error' => $th->getMessage()]);
}
