<?php
// remove_from_cart.php
require_once 'config.php';
if (!isLoggedIn()) {
    header('Location: auth/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = intval($_POST['order_id']);
    $user_id = $_SESSION['user_id'];
    // Проверяем, что заказ принадлежит пользователю и статус "в корзине"
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ? AND status = 'в корзине'");
    $stmt->execute([$order_id, $user_id]);
    $order = $stmt->fetch();
    if ($order) {
        $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
    }
    header('Location: cart.php');
    exit;
}
?>
<!-- В таблице корзины добавить колонку действий -->
<th style="border: 1px solid #ddd; padding: 8px;">Действия</th>
<!-- В цикле вывода товаров -->
<td style="border: 1px solid #ddd; padding: 8px;">
    <?php if ($item['status'] == 'в корзине'): ?>
        <form action="remove_from_cart.php" method="post" style="display: inline;">
            <input type="hidden" name="order_id" value="<?php echo $item['id']; ?>">
            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">
                Удалить
            </button>
        </form>
    <?php else: ?>
        <span style="color: #6c757d;">-</span>
    <?php endif; ?>
</td>