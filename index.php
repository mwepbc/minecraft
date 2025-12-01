<!DOCTYPE html>
<html lang="ru">
<html prefix="og: http://ogp.me/ns#">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/favicon.ico" rel="icon" type="image/x-icon">
    <title>Справочник рецептов крафтов Майнкрафт — RecipeCraft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
	<meta name="description" content="Найди любой рецепт крафта в майнкрафт прямо на сетке верстака. Интерактивный справочник прямо из игры."/>
    <meta name="keywords" content="майнкрафт,minecraft,рецепты,как сделать,крафт,рецепт майнкрафт,как сделать в майнкрафте, майнкрафт крафт, верстак">
    <meta property="og:title" content="Справочник рецептов крафтов Майнкрафт — RecipeCraft"/>
    <meta property="og:image" content="https://f1160241.xsph.ru/assets/img/favicon.ico"/>
    <meta property="og:description" content="Найди любой рецепт крафта в майнкрафт прямо на сетке верстака. Интерактивный справочник прямо из игры."/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://f1160241.xsph.ru/index.php" />
</head>

<body>
    <?php include("assets/includes/header.php") ?>
    <main>
        <div class="list">
                <div class="search">
                    <img src="assets/img/search.webp" alt="search">
                    <input type="search" placeholder="Поиск..." id="search">
                </div>
            <div class="listCells">
            </div>

            <div class="listfooter">
                <img src="assets/img/arrow.png" alt="arrowBack" id="arrowBack">
                <h4>0/0</h4>
                <img src="assets/img/arrow.png" alt="arrowNext">
            </div>
        </div>

        <div class="craft" itemscope itemtype="https://schema.org/HowTo">
            <p itemprop="name" style="display: none" >Рецепт крафта верстака</p>
            <p itemprop="description" style="display: none" >Как скрафтить любой предмет? Покажем на сетке верстака</p>

            <table class="craftingTable">
                <tr>
                    <td>
                        <img src="assets/img/planks.png" alt="planks" title="planks" itemprop="step">
                    </td>
                    <td>
                        <img src="assets/img/planks.png" alt="planks" title="planks" itemprop="step">
                    </td>
                    <td>
                        <img src="assets/img/transparent.png" alt="trans">
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="assets/img/planks.png" alt="planks" title="planks" itemprop="step">
                    </td>
                    <td>
                        <img src="assets/img/planks.png" alt="planks" title="planks" itemprop="step">
                    </td>
                    <td>
                        <img src="assets/img/transparent.png" alt="trans">
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="assets/img/transparent.png" alt="trans">
                    </td>
                    <td>
                        <img src="assets/img/transparent.png" alt="trans">
                    </td>
                    <td>
                        <img src="assets/img/transparent.png" alt="trans">
                    </td>
                </tr>
            </table>

            <img src="assets/img/arrow.png" id="arrow">

            <div class="result" >
                <img src="assets/img/crafting_table.webp" alt="crafting_table" title="crafting_table" itemprop="image">
            </div>
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

            let ingredients = [result.slot1, result.slot2, result.slot3, result.slot4,
            result.slot5, result.slot6, result.slot7, result.slot8, result.slot9];
            ingredients.forEach((element, index) => {
                craftingCells[index].innerHTML = (element != null) ? `<img src = "assets/img/${element}" alt="${element}" >` : `<img src="assets/img/transparent.png" alt="trans">`;
            });

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

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "HowTo",
  "name": "Как скрафтить верстак в Minecraft",
  "description": "Пошаговая инструкция, как создать верстак — базовый предмет для крафта других вещей в Minecraft.",
  "image": "http://f1160241.xsph.ru/assets/img/crafting_table.webp",
  "yield": "1 верстак",
  "step": [
    {
      "@type": "HowToStep",
      "text": "Поместите 4 доски по 2x2 схеме",
      "image": "http://f1160241.xsph.ru/assets/img/screenshot.png"
    },
    {
      "@type": "HowToStep",
      "text": "Готовый верстак появится в правом слоте результата. Перетащите его в инвентарь."
    }
  ],
  "tool": [
    {
      "@type": "HowToTool",
      "name": "Инвентарь игрока"
    }
  ],
  "supply": [
    {
      "@type": "HowToSupply",
      "name": "4 доски"
    }
  ]
}
</script>

</html>