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
            'id' => $craft['id'],
            'result_id' => $craft['result_id'],
            'result_img' => $craft['result_image'],
            'result_name' => $craft['result_name'],
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

function craftForId($dbh, $id)
{
    $sth = $dbh->prepare('
        SELECT 
                c.*,
                i_res.name AS result_name,
                i_res.image AS result_image,
                i_res.id AS result_id,
                i1.image AS image1,
                i1.id as id1,
                i2.image AS image2,
                i2.id as id2,
                i3.image AS image3,
                i3.id as id3,
                i4.image AS image4,
                i4.id as id4,
                i5.image AS image5,
                i5.id as id5,
                i6.image AS image6,
                i6.id as id6,
                i7.image AS image7,
                i7.id as id7,
                i8.image AS image8,
                i8.id as id8,
                i9.image AS image9,
                i9.id as id9
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
            WHERE c.id = ?
    ');
    $sth->execute([$id]);
    $craft = $sth->fetch(PDO::FETCH_ASSOC);

    if (!$craft) {
        echo json_encode(['error' => 'Recipe not found']);
        return;
    }

    echo json_encode([
        'id' => $craft['id'],
        'result_id' => $craft['result_id'],
        'result_name' => $craft['result_name'],
        'result_img' => $craft['result_image'],
        'quantity' => $craft['quantity'] ?? null,
        'slot1' => $craft['image1'] ?? null,
        'id1' => $craft['id1'] ?? null,
        'slot2' => $craft['image2'] ?? null,
        'id2' => $craft['id2'] ?? null,
        'slot3' => $craft['image3'] ?? null,
        'id3' => $craft['id3'] ?? null,
        'slot4' => $craft['image4'] ?? null,
        'id4' => $craft['id4'] ?? null,
        'slot5' => $craft['image5'] ?? null,
        'id5' => $craft['id5'] ?? null,
        'slot6' => $craft['image6'] ?? null,
        'id6' => $craft['id6'] ?? null,
        'slot7' => $craft['image7'] ?? null,
        'id7' => $craft['id7'] ?? null,
        'slot8' => $craft['image8'] ?? null,
        'id8' => $craft['id8'] ?? null,
        'slot9' => $craft['image9'] ?? null,
        'id9' => $craft['id9'] ?? null
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
        echo json_encode(['error' => 'Предмет не участвует в крафтах']);
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

// удаление крафта
function deleteCraft($dbh, $id)
{
    // $sth = $dbh->prepare('
    //     DELETE FROM `crafts`
    //     WHERE `crafts`.`id` = ?');

    $sth = $dbh->prepare('
        DELETE FROM `crafts`
        WHERE `crafts`.`id` = ?');

    $sth->execute([$id]);
    echo json_encode('yay!');
}

// функция вставки крафта в бд
function insertCraft($dbh, $res, $pos_1, $pos_2, $pos_3, $pos_4, $pos_5, $pos_6, $pos_7, $pos_8, $pos_9, $quantity)
{
    if ($quantity <= 0) {
        echo json_encode(['error' => 'Количество не может быть равно или меньше 0']);
        exit();
    }
    if ((int)$quantity > 64) {
        echo json_encode(['error' => 'Количество не может быть больше 64']);
        exit();
    }
    if ($res == 'null') {
        echo json_encode(['error' => 'Выберите предмет для рецепта крафта']);
        exit();
    }

    // проверка на пустоту сетки крафта
    $c = 0;
    $positions = [$pos_1, $pos_2, $pos_3, $pos_4, $pos_5, $pos_6, $pos_7, $pos_8, $pos_9];
    foreach ($positions as $pos) {
        if ($pos == 'null')
            $c++;


        if ($c == 9) {
            echo json_encode(['error' => 'Сетка крафта не может быть пустой']);
            exit;
        }
    }

    $quantity = ($quantity == 'null' || $quantity == '1') ? null : (int)$quantity;
    $pos_1 = ($pos_1 == 'null') ? null : (int)$pos_1;
    $pos_2 = ($pos_2 == 'null') ? null : (int)$pos_2;
    $pos_3 = ($pos_3 == 'null') ? null : (int)$pos_3;
    $pos_4 = ($pos_4 == 'null') ? null : (int)$pos_4;
    $pos_5 = ($pos_5 == 'null') ? null : (int)$pos_5;
    $pos_6 = ($pos_6 == 'null') ? null : (int)$pos_6;
    $pos_7 = ($pos_7 == 'null') ? null : (int)$pos_7;
    $pos_8 = ($pos_8 == 'null') ? null : (int)$pos_8;
    $pos_9 = ($pos_9 == 'null') ? null : (int)$pos_9;

    $sth = $dbh->prepare('INSERT INTO `crafts`
            (`id`, `crafting_item`, `pos_1`, `pos_2`, `pos_3`, `pos_4`, `pos_5`, `pos_6`, `pos_7`, `pos_8`, `pos_9`, `quantity`)
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $sth->execute([$res, $pos_1, $pos_2, $pos_3, $pos_4, $pos_5, $pos_6, $pos_7, $pos_8, $pos_9, $quantity]);
    echo json_encode(['yay!']);
}

// функция обновления крафта
function updateCraft($dbh, $id, $res, $pos_1, $pos_2, $pos_3, $pos_4, $pos_5, $pos_6, $pos_7, $pos_8, $pos_9, $quantity)
{
    if ($quantity <= 0) {
        echo json_encode(['error' => 'Количество не может быть равно или меньше 0']);
        exit();
    }
    if ((int)$quantity > 64) {
        echo json_encode(['error' => 'Количество не может быть больше 64']);
        exit();
    }
    if ($res == 'null') {
        echo json_encode(['error' => 'Выберите предмет для рецепта крафта']);
        exit();
    }

    // проверка на пустоту сетки крафта
    $c = 0;
    $positions = [$pos_1, $pos_2, $pos_3, $pos_4, $pos_5, $pos_6, $pos_7, $pos_8, $pos_9];
    foreach ($positions as $pos) {
        if ($pos == 'null')
            $c++;

        if ($c == 9) {
            echo json_encode(['error' => 'Сетка крафта не может быть пустой']);
            exit;
        }
    }

    $quantity = ($quantity == 'null' || $quantity == '1') ? null : (int)$quantity;
    $pos_1 = ($pos_1 == 'null') ? null : (int)$pos_1;
    $pos_2 = ($pos_2 == 'null') ? null : (int)$pos_2;
    $pos_3 = ($pos_3 == 'null') ? null : (int)$pos_3;
    $pos_4 = ($pos_4 == 'null') ? null : (int)$pos_4;
    $pos_5 = ($pos_5 == 'null') ? null : (int)$pos_5;
    $pos_6 = ($pos_6 == 'null') ? null : (int)$pos_6;
    $pos_7 = ($pos_7 == 'null') ? null : (int)$pos_7;
    $pos_8 = ($pos_8 == 'null') ? null : (int)$pos_8;
    $pos_9 = ($pos_9 == 'null') ? null : (int)$pos_9;

    // var_dump($positions);

    $sth = $dbh->prepare('UPDATE `crafts` 
    SET `crafting_item` = ?, 
    `pos_1` = ?, 
    `pos_2` = ?, 
    `pos_3` = ?, 
    `pos_4` = ?, 
    `pos_5` = ?, 
    `pos_6` = ?, 
    `pos_7` = ?, 
    `pos_8` = ?, 
    `pos_9` = ?, 
    `quantity` = ?
    WHERE `crafts`.`id` = ?');
    $sth->execute([$res, $pos_1, $pos_2, $pos_3, $pos_4, $pos_5, $pos_6, $pos_7, $pos_8, $pos_9, $quantity, $id]);
    echo json_encode(['yay!']);
}

try {
    switch ($data['function']) {
        case 'allCrafts':
            allCrafts($dbh);
            break;

        case 'deleteCraft':
            deleteCraft($dbh, $data['id_craft']);
            break;

        case 'craftForId':
            craftForId($dbh, $data['id_craft']);
            break;

        case 'insertCraft':
            insertCraft(
                $dbh,
                $data['result_id'],
                $data['slot0'],
                $data['slot1'],
                $data['slot2'],
                $data['slot3'],
                $data['slot4'],
                $data['slot5'],
                $data['slot6'],
                $data['slot7'],
                $data['slot8'],
                $data['quantity']
            );
            break;

        case 'updateCraft':
            updateCraft(
                $dbh,
                $data['id_craft'],
                $data['result_id'],
                $data['slot0'],
                $data['slot1'],
                $data['slot2'],
                $data['slot3'],
                $data['slot4'],
                $data['slot5'],
                $data['slot6'],
                $data['slot7'],
                $data['slot8'],
                $data['quantity']
            );
            break;

        default:
            echo 'oopseeee';
            break;
    }
} catch (Throwable $th) {
    echo json_encode(['error' => $th->getMessage()]);
}
