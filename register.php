<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($password)) {
        $error = "Все поля обязательны для заполнения";
    } elseif ($password !== $confirm_password) {
        $error = "Пароли не совпадают";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен быть не менее 6 символов";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Пользователь с таким именем уже существует";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            
            if ($stmt->execute([$username, $hashed_password])) {
                $_SESSION['user'] = $username;
                $_SESSION['user_id'] = $pdo->lastInsertId();
                header('Location: ../index.php');
                exit;
            } else {
                $error = "Ошибка при регистрации";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Barbershop</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
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
                <a href="login.php" title="Вход">ВХОД</a>
            </div>
        </div>
    </header>

    <main class="container" style="max-width: 400px; margin: 50px auto;">
        <div class="card" style="padding: 2rem;">
            <h2 style="text-align: center; margin-bottom: 1.5rem; color: black;">Регистрация</h2>
            
            <?php if (isset($error)): ?>
                <div style="color: red; background: #ffeaea; padding: 10px; border-radius: 4px; margin-bottom: 1rem;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="post" id="registerForm">
                <div class="field">
                    <label for="username">Имя пользователя:</label>
                    <input type="text" id="username" name="username" required 
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                
                <div class="field">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="field">
                    <label for="confirm_password">Подтвердите пароль:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="submit" style="width: 100%; margin-top: 1rem;">Зарегистрироваться</button>
            </form>
            
            <p style="text-align: center; margin-top: 1rem;">
                Уже есть аккаунт? <a href="login.php">Войдите</a>
            </p>
        </div>
    </main>
</body>
</html>