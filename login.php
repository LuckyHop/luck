<?php
require_once '../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    if (empty($username) || empty($password)) {
        $error = "Введите имя пользователя и пароль";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header('Location: ../index.php');
            exit;
        } else {
            $error = "Неверное имя пользователя или пароль";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Barbershop</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body style="background:black;">
    <header class="site-header" role="banner">
        <div class="container topbar">
            <nav class="nav-center" role="navigation" aria-label="Главное меню">
                <img src="../img/logo.svg" alt="" style="position:absolute; left: 2rem;">
                <strong>
                    <a href="../index.php">Главная</a>
                    <a href="../price/price.php">Прайс-лист</a>
                    <a href="../catalog/catalog2.php">Магазин</a>
                </strong>
            </nav>
            <div class="login">
                <a href="register.php" title="Регистрация">РЕГИСТРАЦИЯ</a>
            </div>
        </div>
    </header>

    <main class="container" style="max-width: 400px; margin: 50px auto;">
        <div class="card" style="padding: 2rem;">
            <h2 style="text-align: center; margin-bottom: 1.5rem; color: black;">Вход</h2>
            <?php if (isset($error)): ?>
                <div style="color: red; background: #ffeaea; padding: 10px; border-radius: 4px; margin-bottom: 1rem;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form method="post" id="loginForm">
                <div class="field">
                    <label for="username">Имя пользователя:</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                <div class="field">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit" style="width: 100%; margin-top: 1rem;">Войти</button>
            </form>
            <p style="text-align: center; margin-top: 1rem; color:black;" class="blck">
                Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a>
            </p>
            <div class="blck" style="margin-top: 2rem; padding: 1rem; background: #f0f0f0; border-radius: 4px; font-size: 0.9rem; color: black;">
                <strong>Тестовые данные:</strong><br>
                Админ: admin / password<br>
                Пользователь: user1 / password
            </div>
        </div>
    </main>
</body>
</html>