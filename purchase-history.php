<?php
require_once 'database.php';
include 'header.php'; // Include the header

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch purchase history for the logged-in user
    $stmt = $pdo->prepare("SELECT order_id, items, total, status, address, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    die("Failed to fetch purchase history. Please try again later.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History | Wow Gifts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
        
    }

    header {
    position: sticky;
    top: 0;
    z-index: 1000;
    width: 100%;
}

    .purchase-container {
    width: 90%;
    max-width: 1200px;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin: 80px auto; /* Add margin to push content below the header */
}

    .purchase-container h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        overflow: hidden;
        border-radius: 10px;
    }

    table th, table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #e83e8c;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
    }

    table tr:hover {
        background-color: #f9f9f9;
    }

    table td {
        color: #555;
    }

    table td:first-child {
        font-weight: 600;
        color: #333;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        background: #e83e8c;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        margin-top: 20px;
    }

    .btn:hover {
        background: #ff69b4;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
    }

    .empty-message {
        text-align: center;
        font-size: 1.2rem;
        color: #666;
        margin: 20px 0;
    }
    </style>
</head>
<body>
    <div class="purchase-container">
    <h1>Purchase History</h1>
    <?php if (empty($orders)): ?>
        <p class="empty-message">You have not made any purchases yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td>
                            <?php
                            $items = json_decode($order['items'], true);
                            foreach ($items as $item) {
                                echo htmlspecialchars($item['name']) . " (x" . $item['quantity'] . ")<br>";
                            }
                            ?>
                        </td>
                        <td>$<?= htmlspecialchars(number_format($order['total'], 2)) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td><?= htmlspecialchars(date('d M Y, H:i', strtotime($order['created_at']))) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="index.php" class="btn">Back to Home</a>
</div>
</body>
</html>