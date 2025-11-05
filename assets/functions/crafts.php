<?php

include('connect.php');

function allCrafts($dbh)
{
    $sth = $dbh->prepare('SELECT 
                c.*,
                i_res.id as result_id,
                i_res.name AS result_name,
                i_res.image AS result_image,
                i1.image AS image1,
                i2.image AS image2,
                i3.image AS image3,
                i4.image AS image4,
                i5.image AS image5,
                i6.image AS image6,
                i7.image AS image7,
                i8.image AS image8,
                i9.image AS image9
            FROM crafts c
            JOIN items i_res ON c.crafting_item = i_res.id
            LEFT JOIN items i1 ON c.pos_1 = i1.id
            LEFT JOIN items i2 ON c.pos_2 = i2.id
            LEFT JOIN items i3 ON c.pos_3 = i3.id
            LEFT JOIN items i4 ON c.pos_4 = i4.id
            LEFT JOIN items i5 ON c.pos_5 = i5.id
            LEFT JOIN items i6 ON c.pos_6 = i6.id
            LEFT JOIN items i7 ON c.pos_7 = i7.id
            LEFT JOIN items i8 ON c.pos_8 = i8.id
            LEFT JOIN items i9 ON c.pos_9 = i9.id');
    $sth->execute();
    $craftsAll = $sth->fetchAll();

    foreach ($craftsAll as $craft) {
        $result[] = [
            'result_id'=> $craft['result_id'],
            'result_img' => $craft['result_image'],
            'quantity' => $craft['quantity'] ?? null,
            'slot1' => $craft['image1'] ?? null,
            'slot2' => $craft['image2'] ?? null,
            'slot3' => $craft['image3'] ?? null,
            'slot4' => $craft['image4'] ?? null,
            'slot5' => $craft['image5'] ?? null,
            'slot6' => $craft['image6'] ?? null,
            'slot7' => $craft['image7'] ?? null,
            'slot8' => $craft['image8'] ?? null,
            'slot9' => $craft['image9'] ?? null
        ];
    }
    
    echo json_encode($result);
}

// по айдишнику крафтящегося предмета выдается изображения предметов
function defeniteCraft($dbh, $id)
{
    $sth = $dbh->prepare('
        SELECT 
                c.*,
                i_res.name AS result_name,
                i_res.image AS result_image,
                i1.image AS image1,
                i2.image AS image2,
                i3.image AS image3,
                i4.image AS image4,
                i5.image AS image5,
                i6.image AS image6,
                i7.image AS image7,
                i8.image AS image8,
                i9.image AS image9
            FROM crafts c
            JOIN items i_res ON c.crafting_item = i_res.id
            LEFT JOIN items i1 ON c.pos_1 = i1.id
            LEFT JOIN items i2 ON c.pos_2 = i2.id
            LEFT JOIN items i3 ON c.pos_3 = i3.id
            LEFT JOIN items i4 ON c.pos_4 = i4.id
            LEFT JOIN items i5 ON c.pos_5 = i5.id
            LEFT JOIN items i6 ON c.pos_6 = i6.id
            LEFT JOIN items i7 ON c.pos_7 = i7.id
            LEFT JOIN items i8 ON c.pos_8 = i8.id
            LEFT JOIN items i9 ON c.pos_9 = i9.id
            WHERE c.crafting_item = ?
    ');
    $sth->execute([$id]);
    $craft = $sth->fetch(PDO::FETCH_ASSOC);

    if (!$craft) {
        echo json_encode(['error' => 'Recipe not found']);
        return;
    }

    echo json_encode([
        'result' => $craft['result_image'],
        'quantity' => $craft['quantity'] ?? null,
        'slot1' => $craft['image1'] ?? null,
        'slot2' => $craft['image2'] ?? null,
        'slot3' => $craft['image3'] ?? null,
        'slot4' => $craft['image4'] ?? null,
        'slot5' => $craft['image5'] ?? null,
        'slot6' => $craft['image6'] ?? null,
        'slot7' => $craft['image7'] ?? null,
        'slot8' => $craft['image8'] ?? null,
        'slot9' => $craft['image9'] ?? null
    ]);
}

// по айдишнику крафтящегося предмета выдается изображения предметов
function allCraftsForId($dbh, $id)
{
    $sth = $dbh->prepare('
        SELECT * FROM `crafts`
        WHERE `crafting_item` = ? 
        OR `pos_1` = ?
        OR `pos_2` = ?
        OR `pos_3` = ?
        OR `pos_4` = ?
        OR `pos_5` = ?
        OR `pos_6` = ?
        OR `pos_7` = ?
        OR `pos_8` = ?
        OR `pos_9` = ?;
    ');
    $sth->execute([$id]);
    $craft = $sth->fetch(PDO::FETCH_ASSOC);

    if ($craft) {
        echo json_encode(['error' => 'Item has a participation craft']);
        return;
    }

    echo json_encode([
        'result' => $craft['result_image'],
        'quantity' => $craft['quantity'] ?? null,
        'slot1' => $craft['image1'] ?? null,
        'slot2' => $craft['image2'] ?? null,
        'slot3' => $craft['image3'] ?? null,
        'slot4' => $craft['image4'] ?? null,
        'slot5' => $craft['image5'] ?? null,
        'slot6' => $craft['image6'] ?? null,
        'slot7' => $craft['image7'] ?? null,
        'slot8' => $craft['image8'] ?? null,
        'slot9' => $craft['image9'] ?? null
    ]);
}

// функция вставки юзера в бд
function insertCraft($dbh, $login, $password, $role)
{
    $sth = $dbh->prepare('INSERT INTO `users`
    (`id`, `login`, `password`, `role`)
    VALUES (NULL, ?, ?, ?)');
    $sth->execute([$login, $password, $role]);
}

switch ($data['function']) {
    case 'allCrafts':
        allCrafts($dbh);
        break;

    case 'defeniteCraft':
        defeniteCraft($dbh, (int)$data['id_item']);
        break;

    default:
        echo 'oopseeee';
        break;
}
