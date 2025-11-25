<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <link href="assets/img/favicon.ico" rel="icon" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Войти — RecipeCraft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
</head>

<body>
    <?php include("assets/includes/header.php") ?>
    <main class="formPage">
        <div class="form">
            <h1>
                ВОЙТИ В АККАУНТ
            </h1>
            <div>
                <label for="login">ЛОГИН</label>
                <input type="text" name="login" id="login">
            </div>
            <div>
                <label for="password">ПАРОЛЬ</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="errorSpan">
                <img src="assets/img/tip.png" alt="tip">
                <p class="error"></p>
            </div>
            <button>ПОДТВЕРДИТЬ</button>
        </div>
    </main>
    <?php include("assets/includes/footer.php") ?>
    
    <script>
    let errorSpan = document.querySelector(".errorSpan");
    let error_p = document.querySelector(".error");
    let submit = document.querySelector('.form button');

    let login = document.querySelector('#login');
    let password = document.querySelector('#password');

    submit.addEventListener('click', () => {
        let form = new FormData();
        form.append("login", login.value);
        form.append("password", password.value);
        form.append("function", 'auth');

        const request1 = new Request("assets/functions/users.php", {
            method: "POST",
            // headers: {
            //     "Content-Type": "application/json",
            // },
            body: form
        });
        post(request1);
    });

    async function post(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();

            if (result.error) {
                error_p.innerHTML = result.error;
                errorSpan.style.display = 'flex';
            } else {
                // кука будет жить полчаса
                document.cookie = `user=${result.id}; max-age=1800; path=/`;

                if (result.role == 'admin') {
                    window.location.href = 'admin.php'
                } else {
                    window.location.href = 'index.php'
                }
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }
</script>
</body>

</html>