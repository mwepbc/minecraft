<header>
    <a href="index.php">
        <img src="assets/img/logo.png" alt="logo" id="logo"/>
    </a>
    <nav>
        <button id="admin" onclick="window.location.href='admin.php'">
            АДМИН-ПАНЕЛЬ
        </button>

        <button id="exit">
            ВЫХОД
        </button>

        <button id="auth" onclick="window.location.href = 'auth.php'">
            ВХОД
        </button>

        <button id="reg" onclick="window.location.href = 'reg.php'">
            РЕГИСТРАЦИЯ
        </button>
    </nav>
</header>
<script src="assets/js/main.js"></script>
<script>
    let exit = document.querySelector('#exit');
    let admin = document.querySelector('#admin');

    // если не существует юзерская кука, то он не авторизован,
    // значит появляются кнопки регистрации и входа
    if (getCookie('user') === undefined) {
        auth.style.display = 'flex';
        reg.style.display = 'flex';
    } else {
        exit.style.display = 'flex';

        // проверка админа
        async function postAdmin(request) {
            try {
                const response = await fetch(request);
                const result = await response.json();
                console.log(result);

                result ? admin.style.display = 'flex' : admin.style.display = 'none';

            } catch (error) {
                console.error(error);
            }
        }
        const requestAdmin = new Request("assets/functions/users.php", {
            method: "POST",
            // headers: {
            //     "Content-Type": "application/json",
            // },
            body: JSON.stringify({
                id_user: getCookie('user'),
                function: 'adminVerify'
            }),
        });
        postAdmin(requestAdmin);
    }

    // при нажатии на кнопку выхода, удаляется кука юзера
    // и его перебрасывает на окно авторизации
    exit.addEventListener('click', () => {
        deleteCookie('user');
        window.location.href = 'auth.php';
    })
</script>