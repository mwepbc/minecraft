<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/favicon.ico" rel="icon" type="image/x-icon">
    <title>Регистрация — RecipeCraft</title>
    <link rel="stylesheet" href="assets/styles/style.css">
</head>

<body>
    <?php
    include("assets/includes/header.php");
    ?>
    <main class="formPage">
        <div class="form">
            <h1>
                РЕГИСТРАЦИЯ
            </h1>
            <div>
                <label for="login">ЛОГИН</label>
                <input type="text" name="login" id="login">
            </div>
            <div>
                <label for="password">ПАРОЛЬ</label>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="role">РОЛЬ</label>
                <select name="role" id="role">
                    <option value="admin">Администратор</option>
                    <option value="user" selected>Пользователь</option>
                </select>
            </div>
            <div class="errorSpan">
                <img src="assets/img/tip.png" alt="tip">
                <p class="error"></p>
            </div>
            <button>ПОДТВЕРДИТЬ</button>
        </div>
    </main>
    <?php include("assets/includes/footer.php") ?>
</body>

<script>
    let errorSpan = document.querySelector(".errorSpan");
    let error_p = document.querySelector(".error")
    let submit = document.querySelector('.form button');

    let login = document.querySelector('#login');
    let password = document.querySelector('#password');
    let role = document.querySelector('#role');

    submit.addEventListener('click', () => {
        let form = new FormData();
        form.append("login", login.value);
        form.append("password", password.value);
        form.append("role", role.value);
        form.append("function", 'insertUser');

        const request1 = new Request("assets/functions/users.php", {
            method: "POST",
            body: form
        });

        post(request1);
    });

    async function post(request) {
        try {
            const response = await fetch(request);
            const result = await response.json();
            console.log(result);

            if (result.error) {
                error_p.innerHTML = result.error;
                errorSpan.style.display = 'flex';
            } else {
                window.location.href = 'auth.php'
            }

        } catch (error) {
            console.error("Error:", error);
        }
    }
</script>

</html>