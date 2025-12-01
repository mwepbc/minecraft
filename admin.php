<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="assets/img/favicon.ico" rel="icon" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
</head>

<body>
    <?php include('assets/includes/header.php') ?>
    <main id="adminMain">
        <div class="adminButtons">
            <button id="itemsSection"
                onclick="itemForm.style.display = 'flex'; craftForm.style.display = 'none'">
                ПРЕДМЕТЫ
            </button>
            <button id="craftsSection" onclick="craftForm.style.display = 'flex'; itemForm.style.display = 'none'">
                КРАФТЫ
            </button>
        </div>
        <div id="adminContainer">
            <div class="list">
                    <div class="search">
                        <img src="assets/img/search.webp" alt="search">
                        <input type="search" placeholder="Поиск...">
                    </div>

                <div class="listCells">
                </div>

                <div class="listfooter">
                    <img src="assets/img/arrow.png" alt="arrowBack" id="arrowBack">
                    <h4>0/0</h4>
                    <img src="assets/img/arrow.png" alt="arrowNext">
                </div>
            </div>
            <div class="actions">
                <div id="itemForm" enctype="multipart/form-data">
                    <span>
                        <input type="text" name="name" id="name" placeholder="Имя предмета...">
                        <input type="file" name="image_url" id="file">
                        <img id="image">
                    </span>
                    <span class="buttons">
                        <button id="apply">Подтвердить</button>
                        <button id="delete">Удалить</button>
                        <button id="add">Создать</button>
                    </span>
                    <div class="errorSpan">
                        <img src="assets/img/tip.png" alt="tip">
                        <p class="error"></p>
                    </div>
                </div>
                <div id="craftForm">
                    <span id="craftDisplay" class="craft">
                        <table class="craftingTable">
                            <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </table>

                        <img src="assets/img/arrow.png" id="arrow">

                        <div class="result">
                        </div>
                        <input type="number" id="quantity">
                    </span>

                    <span class="buttons">
                        <button id="applyCraft">Подтвердить</button>
                        <button id="deleteCraft">Удалить</button>
                        <button id="addCraft">Создать</button>
                    </span>

                    <span class="errorSpan">
                        <img src="assets/img/tip.png" alt="tip">
                        <p class="error"></p>
                    </span>
                </div>
            </div>
        </div>
        <div class="search">
            <img src="assets/img/search.webp" alt="search">
            <input type="search" placeholder="Поиск...">
        </div>
        <div class="craftsList">

        </div>
    </main>
    <?php include('assets/includes/footer.php') ?>
</body>
<script src='assets/js/main.js'></script>
<script>
    // блоки управления
    let itemForm = document.querySelector('#itemForm');
    let craftForm = document.querySelector('#craftForm');

    const items = document.querySelector('.listCells');

    let errorSpan = document.querySelectorAll('.errorSpan');
    let error_p = document.querySelectorAll(".error")

    // кнопки справа
    let applyButton = document.querySelector('#apply');
    let deleteButton = document.querySelector('#delete');
    let addButton = document.querySelector('#add');

    let filterButton = document.querySelector('#filter');

    async function postItems(request, sort = 'a-z') {
        try {
            postCrafts(createAllCraftsRequest());
            const response = await fetch(request);
            const resultData = await response.json();

            let result = [];
            resultData.forEach(element => {
                if (element.name.includes(search[0].value))
                    result.push(element);
            });

            items.innerHTML = '';

            result.forEach(element => {
                let cell = document.createElement('div');
                cell.className = "cell";
                cell.setAttribute('id_item', element.id);

                cell.innerHTML = `
                        <img src="assets/img/${element.image}" title="${element.name}" alt="${element.name}" id_item="${element.id}">
                    `;

                cell.addEventListener('click', (event) => {
                    const requestDif = new Request("assets/functions/items.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            id_item: event.target.getAttribute('id_item'),
                            function: 'defeniteItem'
                        })
                    });

                    postDif(requestDif);
                });
                items.appendChild(cell);
            });

            // очистка полей
            nameInput.value = '';
            imageInput.value = '';
            image.src = "";
            deleteCookie('item');
            errorSpan[0].style.display = 'none';

            // возврат кнопки добавления и удаление кнопок удаления и редактирования
            addButton.style.display = 'flex';
            deleteButton.style.display = 'none';
            applyButton.style.display = 'none';

        } catch (error) {
            console.error("Error:", error);
        }
    }

    function createAllItemsRequest() {
        return new Request("assets/functions/items.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                function: "allItems"
            })
        });
    }
    postItems(createAllItemsRequest());

    async function postDif(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            // вывод инфы в поля справа
            nameInput.value = result.name;
            image.src = `assets/img/${result.image}`;
            document.cookie = `item=${result.id}; max-age=3600; path=/`;

            addButton.style.display = 'none';
            deleteButton.style.display = 'flex';
            applyButton.style.display = 'flex';
        } catch (error) {
            console.error("Error:", error);
        }
    }

    let nameInput = document.querySelector('#name');
    let image = document.querySelector('#image');
    let imageInput = document.querySelector('#file');

    // предпросмотр фотки
    imageInput.addEventListener('change', (e) => {
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
            image.src = reader.result;
        }
        reader.readAsDataURL(file);
    })

    // добавление предмета
    addButton.addEventListener('click', () => {
        let name = nameInput.value;
        let image = imageInput.files[0];

        if (!name || !image) {
            error_p[0].innerHTML = "Заполните все поля";
            errorSpan[0].style.display = 'flex';
        } else {
            let formData = new FormData();
            formData.append('function', 'insertItem');
            formData.append('name', name);
            formData.append('image_url', image);

            const requestInsert = new Request("assets/functions/items.php", {
                method: "POST",
                // headers: {
                //     "Content-Type": "application/json",
                // },
                body: formData
            });

            postInsert(requestInsert);
        }
    });
    async function postInsert(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();

            if (result.error) {
                error_p[0].innerHTML = result.error;
                errorSpan[0].style.display = 'flex';
            } else
                postItems(createAllItemsRequest());
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // удаление предмета
    deleteButton.addEventListener('click', () => {
        const requestDelete = new Request("assets/functions/items.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                "id_item": getCookie('item'),
                function: "deleteItem"
            })
        });

        postDelete(requestDelete);
    });
    async function postDelete(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            if (result.error) {
                error_p[0].innerHTML = result.error;
                errorSpan[0].style.display = 'flex';
            } else
                postItems(createAllItemsRequest());
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // изменение предмета
    applyButton.addEventListener('click', () => {
        let name = nameInput.value;
        let image = imageInput.files[0];

        if (!name) {
            errorSpan[0].style.display = 'flex';
            error_p[0].innerHTML = "Имя не должно быть пустым";
        } else {
            let formData = new FormData();
            formData.append('function', 'updateItem');
            formData.append('name', name);
            formData.append('image_url', image);
            formData.append('id_item', getCookie('item'));

            const requestUpdate = new Request("assets/functions/items.php", {
                method: "POST",
                // headers: {
                //     "Content-Type": "application/json",
                // },
                body: formData
            });

            postUpdate(requestUpdate);
        }
    });
    async function postUpdate(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            if (result.error) {
                error_p[0].innerHTML = result.error;
                errorSpan[0].style.display = 'flex';
            } else
                postItems(createAllItemsRequest());
        } catch (error) {
            console.error("Error:", error);
        }
    }



    // КРАФТЫ
    let crafts = document.querySelector('.craftsList');
    async function postCrafts(request, sort = 'a-z') {
        try {
            const response = await fetch(request);
            const resultData = await response.json();

            let result = [];
            resultData.forEach(element => {
                if (element.result_name.includes(search[1].value))
                    result.push(element);
            });

            console.log(result);
            crafts.innerHTML = '';

            result.forEach(element => {
                let cell = document.createElement('div');
                cell.className = "craft";
                cell.setAttribute('id_craft', element.id);
                
                cell.innerHTML = `
                        <table class="craftingTable" id_craft="${element.id}">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    `;
                    
                let ingredients = [element.slot1, element.slot2, element.slot3, element.slot4,
                element.slot5, element.slot6, element.slot7, element.slot8, element.slot9];

                cell.querySelectorAll('td').forEach((e, i) => {
                    e.innerHTML=(ingredients[i] != null) ? `<img src = "assets/img/${ingredients[i]}" alt="${ingredients[i]}" >` : `<img src="assets/img/transparent.png" alt="trans">`;
                    console.log(e);
                });

                if (element.quantity != null) {
                    cell.innerHTML += `
                    <div class="result">
                            <img src="assets/img/${element.result_img}" alt="${element.result_name}" title="${element.result_name}" id_craft="${element.id}">
                            <p>${element.quantity}</p>
                        </div>
                    `;
                } else {
                    cell.innerHTML += `
                    <div class="result">
                            <img src="assets/img/${element.result_img}" alt="${element.result_name}" title="${element.result_name}" id_craft="${element.id}">
                    </div>
                    `;
                }

                cell.addEventListener('click', (event) => {
                    const requestDif = new Request("assets/functions/crafts.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            id_craft: event.target.getAttribute('id_craft'),
                            function: 'craftForId'
                        })
                    });

                    postDifCraft(requestDif);
                });

                crafts.appendChild(cell);
            });

            // очистка полей
            craftingCells.forEach(element => {
                element.innerHTML = '<img src="assets/img/transparent.png" alt="trans">';
            });
            resultCell.innerHTML = '';
            quantity.value = null;
            deleteCookie('craft');
            errorSpan[1].style.display = 'none';

            // возврат кнопки добавления и удаление кнопок удаления и редактирования
            addButtonCraft.style.display = 'flex';
            deleteButtonCraft.style.display = 'none';
            applyButtonCraft.style.display = 'none';

        } catch (error) {
            console.error("Error:", error);
        }
    }

    function createAllCraftsRequest() {
        return new Request("assets/functions/crafts.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                function: "allCrafts"
            })
        });
    }

    const craftingCells = document.querySelectorAll('#craftDisplay .craftingTable td');
    const resultCell = document.querySelector('#craftDisplay .result');
    const quantity = document.querySelector('#quantity');

    // кнопки справа
    let applyButtonCraft = document.querySelector('#applyCraft');
    let deleteButtonCraft = document.querySelector('#deleteCraft');
    let addButtonCraft = document.querySelector('#addCraft');

    //post для отправки selectDif и отображения крафта
    async function postDifCraft(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            let ingredients = [result.slot1, result.slot2, result.slot3, result.slot4,
            result.slot5, result.slot6, result.slot7, result.slot8, result.slot9];
            ingredients.forEach((element, index) => {
                craftingCells[index].innerHTML = (element != null) ? `<img src = "assets/img/${element}" alt="${element}" >` : `<img src="assets/img/transparent.png" alt="trans">`;
            });

            resultCell.innerHTML = `<img src="assets/img/${result.result_img}" title="${result.result_name}" alt="${result.result_name}" id_item="${result.result_id}">`;
            quantity.value = result.quantity;

            document.cookie = `craft=${result.id}; max-age=3600; path=/`;

            addButtonCraft.style.display = 'none';
            deleteButtonCraft.style.display = 'flex';
            applyButtonCraft.style.display = 'flex';

            craftForm.style.display = 'flex';
            itemForm.style.display = 'none';
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // удаление крафта
    deleteButtonCraft.addEventListener('click', () => {
        const requestDelete = new Request("assets/functions/crafts.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                "id_craft": getCookie('craft'),
                function: "deleteCraft"
            })
        });

        postDeleteCraft(requestDelete);
    });

    async function postDeleteCraft(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            if (result.error) {
                error_p[1].innerHTML = result.error;
                errorSpan[1].style.display = 'flex';
            } else
                postCrafts(createAllCraftsRequest());
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // добавление крафта
    // отдельные функции на заполнение ячеек
    craftingCells.forEach(element => {
        element.addEventListener('contextmenu', (event) => {
            event.preventDefault();
            element.innerHTML = '';
        });

        element.addEventListener('click', (event) => {
            if (getCookie('item') !== undefined) {
                async function getItem(request) {
                    try {
                        const response = await fetch(request);
                        const result = await response.json();
                        console.log(result);

                        element.innerHTML = `<img src = "assets/img/${result.image}" alt="${result.name}" id_item="${result.id}">`;
                    } catch (error) {
                        console.error("Error:", error);
                    }
                }
                const requestCurrentItem = new Request("assets/functions/items.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        id_item: getCookie('item'),
                        function: 'defeniteItem'
                    }),
                });

                getItem(requestCurrentItem);
            }
        });
    });
    // отдельно для поля результата
    resultCell.addEventListener('contextmenu', (event) => {
        event.preventDefault();
        resultCell.innerHTML = '';
    });
    resultCell.addEventListener('click', (event) => {
        if (getCookie('item') !== undefined) {
            async function getItem(request) {
                try {
                    const response = await fetch(request);
                    const result = await response.json();
                    console.log(result);

                    resultCell.innerHTML = `<img src = "assets/img/${result.image}" alt="${result.name}" id_item="${result.id}">`;
                } catch (error) {
                    console.error("Error:", error);
                }
            }
            const requestCurrentItem = new Request("assets/functions/items.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id_item: getCookie('item'),
                    function: 'defeniteItem'
                }),
            });

            getItem(requestCurrentItem);
        }
    });

    addButtonCraft.addEventListener('click', () => {
        // создаем формдату и заполняем её всем необходимым
        let formDataCraft = new FormData();

        // сразу обозначаем исполняемую функцию
        formDataCraft.append('function', 'insertCraft');

        // добавление айди результата
        !(resultCell.firstElementChild == null) ? formDataCraft.append('result_id', resultCell.firstElementChild.getAttribute('id_item')): formDataCraft.append('result_id', null);

        // добавление количества
        quantity.value == "" ? formDataCraft.append('quantity', null) : formDataCraft.append('quantity', quantity.value);

        // добавление ячеек крафта
        craftingCells.forEach((element, index) => {
            !(element.firstElementChild == null) ? formDataCraft.append(`slot${index}`, element.firstElementChild.getAttribute('id_item')): formDataCraft.append(`slot${index}`, null);
        });

        const requestInsert = new Request("assets/functions/crafts.php", {
            method: "POST",
            body: formDataCraft
        });

        postInsertCraft(requestInsert);
    });

    async function postInsertCraft(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();

            if (result.error) {
                error_p[1].innerHTML = result.error;
                errorSpan[1].style.display = 'flex';
            } else
                postCrafts(createAllCraftsRequest());

        } catch (error) {
            console.error("Error:", error);
        }
    }

    // изменение крафта
    applyButtonCraft.addEventListener('click', () => {
        // создаем формдату и заполняем её всем необходимым
        let formDataCraft = new FormData();

        // сразу обозначаем исполняемую функцию
        formDataCraft.append('function', 'updateCraft');

        // отправляем айдишник крафта
        formDataCraft.append('id_craft', getCookie('craft'));

        // добавление айди результата
        !(resultCell.firstElementChild == null) ? formDataCraft.append('result_id', resultCell.firstElementChild.getAttribute('id_item')): formDataCraft.append('result_id', null);

        // добавление количества
        quantity.value == "" ? formDataCraft.append('quantity', null) : formDataCraft.append('quantity', quantity.value);

        // добавление ячеек крафта
        craftingCells.forEach((element, index) => {
            !(element.firstElementChild == null) ? formDataCraft.append(`slot${index}`, element.firstElementChild.getAttribute('id_item')): formDataCraft.append(`slot${index}`, null);
        });

        const requestUpdate = new Request("assets/functions/crafts.php", {
            method: "POST",
            body: formDataCraft
        });

        postUpdateCraft(requestUpdate);
    });
    async function postUpdateCraft(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            if (result.error) {
                error_p[1].innerHTML = result.error;
                errorSpan[1].style.display = 'flex';
            } else
                postCrafts(createAllCraftsRequest());
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // поиск
    let search = document.querySelectorAll('.search input');
    // поиск для предметов
    search[0].addEventListener('input', () => {
        postItems(createAllItemsRequest());
    });
    // поиск для крафтов
    search[1].addEventListener('input', () => {
        postCrafts(createAllCraftsRequest());
    });
</script>

</html>