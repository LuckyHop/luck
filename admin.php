<?php
require_once '../config.php';

// Проверка прав администратора
if (!isAdmin()) {
    header('Location: ../index.php');
    exit;
}

// Получаем список пользователей
$stmt = $pdo->query("SELECT id, username, is_admin, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Barbershop</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header class="site-header" role="banner">
        <div class="container topbar">
            <nav class="nav-center" role="navigation" aria-label="Главное меню">
                <strong>
                    <a href="../index.php">Главная</a>
                    <a href="../price/price.php">Прайс-лист</a>
                    <a href="../catalog/catalog.php">Магазин</a>
                </strong>
            </nav>
            <div class="login">
                <span>Администратор: <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <a href="../auth/logout.php" style="margin-left: 1rem;">Выйти</a>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <h2 style="text-align: center;">Панель администратора</h2>
            
            <div style="margin: 2rem 0;">
                <h3>Список пользователей</h3>
                <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                    <thead>
                        <tr style="background: #f0f0f0;">
                            <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Имя пользователя</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Роль</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Дата регистрации</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $user['id']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <?php echo $user['is_admin'] ? 'Администратор' : 'Пользователь'; ?>
                            </td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <?php echo date('d.m.Y H:i', strtotime($user['created_at'])); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Список товаров пользователей -->
            <div style="margin: 2rem 0;">
                <h3>Управление заказами</h3>
                <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                    <thead>
                        <tr style="background: #f0f0f0;">
                            <th style="padding: 10px; border: 1px solid #ddd;">ID заказа</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Пользователь</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Товар</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Количество</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Статус</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ordersStmt = $pdo->query("
                            SELECT o.*, u.username, p.name as product_name 
                            FROM orders o 
                            JOIN users u ON o.user_id = u.id 
                            JOIN products p ON o.product_id = p.id 
                            ORDER BY o.created_at DESC
                        ");
                        $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($orders as $order):
                        ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $order['id']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['username']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $order['quantity']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo $order['status']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <form action="../update_order_status.php" method="post" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status">
                                        <option value="в корзине" <?php echo $order['status'] == 'в корзине' ? 'selected' : ''; ?>>В корзине</option>
                                        <option value="в сборке" <?php echo $order['status'] == 'в сборке' ? 'selected' : ''; ?>>В сборке</option>
                                        <option value="в пути" <?php echo $order['status'] == 'в пути' ? 'selected' : ''; ?>>В пути</option>
                                        <option value="доставлено" <?php echo $order['status'] == 'доставлено' ? 'selected' : ''; ?>>Доставлено</option>
                                        <option value="отменено" <?php echo $order['status'] == 'отменено' ? 'selected' : ''; ?>>Отменено</option>
                                    </select>
                                    <button type="submit">Обновить</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="../index.php" class="btn">Вернуться на главную</a>
            </div>
        </div>
    </main>
</body>
</html>
