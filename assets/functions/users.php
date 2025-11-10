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
    WHERE login=? AND password=?');
    $sth->execute([$login, $password]);
    $user = $sth->fetch();

    if(!$user){
        echo json_encode(['error' => 'Неверный логин или пароль']);
        exit();
    }

    echo json_encode($user);
}

// функция поиска юзера по айди
function userById($dbh, $id)
{
    $sth = $dbh->prepare('SELECT *
    FROM users
    WHERE id=?');
    $sth->execute($id);
    $user = $sth->fetch();

    return $user;
}

// функция вставки юзера в бд
function insertUser($dbh, $login, $password, $role){
    if (empty($login) || empty($password)) {
        echo json_encode(["error" => "Заполните все поля"]);
        exit();
    }

    $sth = $dbh->prepare('INSERT INTO `users`
    (`id`, `login`, `password`, `role`)
    VALUES (NULL, ?, ?, ?)');
    $sth->execute([$login, $password, $role]);

    echo json_encode(['yay']);
}

// функция проверки на админские права
function adminVerify($dbh, $id)
{
    $sth = $dbh->prepare('SELECT *
    FROM users
    WHERE id=?');
    $sth->execute([$id]);
    $user = $sth->fetch();

    if($user['role']=='admin')
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
            insertUser($dbh, $data['login'], $data['password'], $data['role']);
            break;
    }
} catch (\Throwable $th) {
    echo json_encode(['error' => $th->getMessage()]);
}

?>