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
                <div class="listhead">
                    <div class="search">
                        <img src="assets/img/search.webp" alt="search">
                        <input type="search" placeholder="Поиск...">
                    </div>
                    <img src="assets/img/Recipe Button.png" alt="filter" id="filter">
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
                <div class="form" id="itemForm" enctype="multipart/form-data">
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
                    <p class="error"></p>
                </div>
                <div id="craftForm">
                    <span id="craftDisplay">
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
                        <button id="apply">Подтвердить</button>
                        <button id="delete">Удалить</button>
                        <button id="add">Создать</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="craftsList">
            <div class="craft">
                <table class="craftingTable">
                    <tr>
                        <td>
                            <img src="assets/img/${element.image_1}" alt="${element.pos_1}">
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
                <div class="result">
                    <img src="assets/img/cart.webp" alt="">
                </div>
            </div>
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
    let error_p = document.querySelector(".error")

    // кнопки справа
    let applyButton = document.querySelector('#apply');
    let deleteButton = document.querySelector('#delete');
    let addButton = document.querySelector('#add');

    let filterButton = document.querySelector('#filter');

    async function postItems(request, sort = 'a-z') {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            // сортировка
            // switch (sort) {
            //     case "a-z":
            //         result.sort((a, b) => a.name.localeCompare(b.name));
            //         break;

            //     case "z-a":
            //         result.sort((a, b) => a.name.localeCompare(b.name));
            //         break;

            //     default:
            //         break;
            // }

            items.innerHTML = '';

            result.forEach(element => {
                let cell = document.createElement('div');
                cell.className = "cell";
                cell.setAttribute('id_item', element.id);

                cell.innerHTML = `
                        <img src="assets/img/${element.image}" alt="${element.name}" id_item="${element.id}">
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

    addButton.addEventListener('click', () => {
        let name = nameInput.value;
        let image = imageInput.files[0];

        if (!name || !image) {
            error_p.innerHTML = "Заполните все поля";
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

    applyButton.addEventListener('click', () => {
        let name = nameInput.value;
        let image = imageInput.files[0];

        if (!name) {
            error_p.innerHTML = "Имя не должно быть пустым";
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

    //post для отправки selectDif и отображения характеристик предмета
    async function postDif(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            // вывод инфы в поля справа
            nameInput.value = result.name;
            image.src = `assets/img/${result.image}`;
            document.cookie = `item=${result.id}; max-age=3600`;

            addButton.style.display = 'none';
            deleteButton.style.display = 'flex';
            applyButton.style.display = 'flex';
        } catch (error) {
            console.error("Error:", error);
        }
    }

    async function postInsert(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();

            if (result.error) {
                error_p.innerHTML = result.error;
            }

            postItems(createAllItemsRequest());

        } catch (error) {
            console.error("Error:", error);
        }
    }

    async function postDelete(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            if (result.error) {
                error_p.innerHTML = result.error;
            }

            postItems(createAllItemsRequest());
        } catch (error) {
            console.error("Error:", error);
        }
    }

    async function postUpdate(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            if (result.error) {
                error_p.innerHTML = result.error;
            }

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
            const result = await response.json();
            console.log(result);

            crafts.innerHTML = '';

            result.forEach(element => {
                let cell = document.createElement('div');
                cell.className = "craft";
                cell.setAttribute('itemCraftId', element.result_id);

                cell.innerHTML = `
                        <table class="craftingTable" itemCraftId="${element.result_id}">
                            <tr>
                                <td>
                                    <img src="assets/img/${element.slot1}" alt="">
                                </td>
                                <td>
                                    <img src="assets/img/${element.slot2}" alt="">
                                </td>
                                <td>
                                    <img src="assets/img/${element.slot3}" alt="">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <img src="assets/img/${element.slot4}" alt="">
                                </td>
                                <td>
                                    <img src="assets/img/${element.slot5}" alt="">
                                </td>
                                <td>
                                    <img src="assets/img/${element.slot6}" alt="">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <img src="assets/img/${element.slot7}" alt="">
                                </td>
                                <td>
                                    <img src="assets/img/${element.slot8}" alt="">
                                </td>
                                <td>
                                    <img src="assets/img/${element.slot9}" alt="">
                                </td>
                            </tr>
                        </table>
                        <div class="result">
                            <img src="assets/img/${element.result_img}" alt="${element.result_name}" itemCraftId="${element.result_id}">
                        </div>
                    `;

                cell.addEventListener('click', (event) => {
                    const requestDif = new Request("assets/functions/crafts.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            id_item: event.target.getAttribute('itemCraftId'),
                            function: 'defeniteCraft'
                        })
                    });

                    postDif(requestDif);
                });

                crafts.appendChild(cell);
            });

            // // очистка полей
            // nameInput.value = '';
            // imageInput.value = '';
            // image.src = "";

            // // возврат кнопки добавления и удаление кнопок удаления и редактирования
            // addButton.style.display = 'flex';
            // deleteButton.style.display = 'none';
            // applyButton.style.display = 'none';

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
    postCrafts(createAllCraftsRequest());

    const craftingCells = document.querySelectorAll('#craftDisplay .craftingTable td');
    const resultCell = document.querySelector('#craftDisplay .result');

    //post для отправки selectDif и отображения крафта
    async function postDif(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            craftingCells[0].innerHTML = `<img src = "assets/img/${result.slot1}" alt="" >`
            craftingCells[1].innerHTML = `<img src = "assets/img/${result.slot2}" alt="" >`
            craftingCells[2].innerHTML = `<img src = "assets/img/${result.slot3}" alt="" >`
            craftingCells[3].innerHTML = `<img src = "assets/img/${result.slot4}" alt="" >`
            craftingCells[4].innerHTML = `<img src = "assets/img/${result.slot5}" alt="" >`
            craftingCells[5].innerHTML = `<img src = "assets/img/${result.slot6}" alt="" >`
            craftingCells[6].innerHTML = `<img src = "assets/img/${result.slot7}" alt="" >`
            craftingCells[7].innerHTML = `<img src = "assets/img/${result.slot8}" alt="" >`
            craftingCells[8].innerHTML = `<img src = "assets/img/${result.slot9}" alt="" >`

            resultCell.innerHTML = `<img src="assets/img/${result.result}" alt="">`;
            // if (result.quantity != null) {
            //     resultCell.innerHTML += `<p>${result.quantity}</p>`;
            // }
            document.querySelector('#quantity').value = result.quantity;
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // filterButton.addEventListener('click', () => {
    //     postItems(createAllItemsRequest(), 'z-a');
    // })

    // функция для изменения фона выбранного предмета
    // передается список элементов, и если айдишник элемента совпадает с ауди в куке, то
    // элементу придается айдишник выбранного элемента
    // function currentItem(list) {
    //     list.forEach(element => {
    //         if (getCookie(id_item) == element.getAttribute('id_item')) {
    //             element.setAttribute('id_item', 'current')
    //         } else {
    //             element.removeAttribute('id');
    //         }
    //     });
    // }
</script>

</html>