<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/favicon.ico" rel="icon" type="image/x-icon">
    <title>Справочник рецептов крафтов Майнкрафт — RecipeCraft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
	<meta name="description" content="Найди любой рецепт крафта в майнкрафт прямо на сетке верстака. Интерактивный справочник прямо из игры."/>
<meta name="keywords" content="майнкрафт,minecraft,рецепты,как сделать,крафт,рецепт майнкрафт,как сделать в майнкрафте, майнкрафт крафт, верстак">
</head>

<body>
    <?php include("assets/includes/header.php") ?>
    <main>
        <div class="list">
            <div class="listhead">
                <div class="search">
                    <img src="assets/img/search.webp" alt="search">
                    <input type="search" placeholder="Поиск..." id="search">
                </div>
            </div>
            <div class="listCells">
            </div>

            <div class="listfooter">
                <img src="assets/img/arrow.png" alt="arrowBack" id="arrowBack">
                <h4>0/0</h4>
                <img src="assets/img/arrow.png" alt="arrowNext">
            </div>
        </div>

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
    </main>

    <?php include("assets/includes/footer.php") ?>
</body>
<script>
    let list = document.querySelector('.listCells');

    async function postCrafts(request) {
        try {
            const response = await fetch(request);
            const resultData = await response.json();

            let result = [];
            resultData.forEach(element => {
                if (element.result_name.includes(search.value))
                    result.push(element);
            });

            list.innerHTML = '';

            result.forEach(element => {
                let cell = document.createElement('div');
                cell.className = "cell";
                cell.setAttribute('id_craft', element.id);

                cell.innerHTML = `
                        <img src="assets/img/${element.result_img}" title="${element.result_name}" alt="${element.result_name}" id_craft="${element.id}">
                    `;

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

                    postDif(requestDif);
                });

                list.appendChild(cell);
            });
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

    const craftingCells = document.querySelectorAll('.craftingTable td');
    const resultCell = document.querySelector('.result');

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

            resultCell.innerHTML = `<img src="assets/img/${result.result_img}" alt="${result.result_name}">`;
            if (result.quantity != null) {
                resultCell.innerHTML += `<p>${result.quantity}</p>`;
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // поиск
    let search = document.querySelector('#search');
    search.addEventListener('input', () => {postCrafts(createAllCraftsRequest());});
</script>

</html>