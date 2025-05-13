<?php

require_once 'database.php';

session_start();
error_log("Session ID: " . session_id()); // Debug log
error_log("Session data: " . json_encode($_SESSION));

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Debugging logs
error_log("Session cart: " . json_encode($_SESSION['cart']));
error_log("Session address: " . $_SESSION['address']);
error_log("Request method: " . $_SERVER['REQUEST_METHOD']);
error_log("POST data: " . json_encode($_POST));

// Fetch cart data from POST request or session
if (isset($_POST['cart_data'])) {
    $_SESSION['cart'] = json_decode($_POST['cart_data'], true);
}
$cart_data = $_SESSION['cart'];

// Debugging: Log cart data
error_log("Cart data in session: " . json_encode($cart_data));

// If cart data is empty, redirect back to cart.php
if (empty($cart_data)) {
    error_log("Cart data is missing. Redirecting to cart.php.");
    header("Location: cart.php");
    exit;
}

// Save total amount in session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['total_amount'])) {
    $_SESSION['total_amount'] = floatval($_POST['total_amount']);
}
$total_amount = $_SESSION['total_amount'] ?? null;

// Debugging: Check if total amount is in the session
if (!$total_amount || $total_amount <= 0) {
    die("Error: Total amount is missing or invalid.");
}

// Calculate total
$subtotal = array_reduce($cart_data, function ($sum, $item) {
    return $sum + ($item['price'] * $item['quantity']);
}, 0);
$tax = $subtotal * 0.1; // 10% tax
$total = $subtotal + $tax;

// Debugging: Log totals
error_log("Subtotal: " . $subtotal);
error_log("Tax: " . $tax);
error_log("Total: " . $total);

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method'])) {
    error_log("Payment form submitted successfully.");
    error_log("Payment method: " . $_POST['payment_method']);
    error_log("Cart data: " . $_POST['cart_data']);
    error_log("Total amount: " . $_POST['total_amount']);

    $payment_method = $_POST['payment_method'] ?? null;
    $cart_data = json_decode($_POST['cart_data'], true) ?? null;
    $upi_id = $_POST['upi_id'] ?? null;
    $card_number = $_POST['card_number'] ?? null;
    $total_amount = $_POST['total_amount'] ?? null;

    if (empty($payment_method)) {
        die("Error: Payment method is missing.");
    }

    if (empty($cart_data)) {
        die("Error: Cart data is missing.");
    }

    if (empty($total_amount)) {
        die("Error: Total amount is missing.");
    }

    // Mask card number
    $masked_card_number = $card_number ? '**** **** **** ' . substr($card_number, -4) : null;

    if ($payment_method === 'UPI') {
    // Validate UPI ID
    if (!preg_match('/^[a-zA-Z0-9._%+-]+@(oksbi|axl)$/', $upi_id)) {
        die("Error: Invalid UPI ID. Please enter a valid UPI ID (e.g., yourname@oksbi or yourname@axl).");
    }
}

    try {
        // Save the order to the database
        $user_id = $_SESSION['user_id'];
        $items = json_encode($cart_data);
        $address = $_SESSION['address']; // Retrieve the address from the session
        error_log("Attempting to insert order into the database...");

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, items, total, status,address) VALUES (?, ?, ?, 'Pending', ?)");
        if ($stmt->execute([$user_id, $items, $total, $address])) {
            $order_id = $pdo->lastInsertId();
            error_log("Order inserted successfully. Order ID: $order_id");

            // Save payment details
            $payment_details = $payment_method === 'UPI' ? $upi_id : $masked_card_number;
            error_log("Attempting to insert payment details...");
            $stmt = $pdo->prepare("INSERT INTO payments (order_id, user_id, payment_method, payment_details, amount, status) VALUES (?, ?, ?, ?, ?, 'Success')");
            $stmt->execute([$order_id, $user_id, $payment_method, $payment_details, $total]);
            error_log("Payment details inserted successfully.");

            // Save order items
            foreach ($cart_data as $item) {
                error_log("Attempting to insert order item: " . json_encode($item));
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $order_id,
                    $item['id'],
                    $item['name'],
                    $item['quantity'],
                    $item['price'],
                ]);
            }
            error_log("Order items inserted successfully.");

            // Clear the cart
            unset($_SESSION['cart']);
            error_log("Cart cleared.");

            // Redirect to success page
            $order_date = date('Y-m-d H:i:s');
            error_log("Redirecting to order-success.php with order_id=$order_id");
            header("Location: order-success.php?order_id=$order_id&order_date=$order_date&order_amount=$total&clear_cart=true");
            exit;
        } else {
            error_log("Failed to insert order into the database.");
            throw new Exception("Failed to insert order into the database.");
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        die("Failed to place the order. Please try again later.");
    } catch (Exception $e) {
        error_log("General Error: " . $e->getMessage());
        die("An unexpected error occurred. Please try again later.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order | Wow Gifts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e83e8c;
            --secondary: #ff69b4;
            --dark: #2d3436;
            --light: #f7f7f7;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --border-radius: 10px;
            --border-radius-sm: 6px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            background: var(--white);
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        h1 {
            text-align: center;
            font-size: 2.2rem;
            color: var(--primary);
            margin-bottom: 30px;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius-sm);
            font-family: 'Montserrat', sans-serif;
            transition: var(--transition);
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232, 62, 140, 0.2);
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1.1rem;
            margin-top: 10px;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(232, 62, 140, 0.4);
        }

        .submit-btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 105, 180, 0.6);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .return-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: #ddd;
    color: #333;
    text-align: center;
    border-radius: 5px;
    font-weight: 600;
    text-decoration: none;
    margin-top: 10px;
    transition: all 0.3s ease;
}

.return-btn:hover {
    background: #bbb;
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

        .form-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    background: var(--white);
    border-radius: 10px;
    box-shadow: var(--shadow);
}

.form-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    color: var(--dark);
    text-align: center;
    margin-bottom: 20px;
}

.address-form .form-group {
    margin-bottom: 20px;
}

.address-form label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--dark);
}

.address-form textarea {
    width: 100%;
    height: 100px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    font-family: 'Montserrat', sans-serif;
    resize: none;
    transition: var(--transition);
}

.address-form textarea:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 5px rgba(232, 62, 140, 0.5);
}

.submit-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    font-size: 1rem;
    text-align: center;
}

.submit-btn:hover {
    background: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 105, 180, 0.6);
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Enter Payment Details</h1>
        <form method="POST" action="order-confirmation.php" class="payment-form">
            <input type="hidden" name="cart_data" value='<?= htmlspecialchars(json_encode($cart_data), ENT_QUOTES, 'UTF-8') ?>'>
            <input type="hidden" name="total_amount" value="<?= htmlspecialchars($total, ENT_QUOTES, 'UTF-8') ?>">

            <div class="form-group">
                <label for="payment-method">Payment Method</label>
                <select name="payment_method" id="payment-method" required>
                    <option value="">Select Payment Method</option>
                    <option value="card">Credit Card</option>
                    <option value="UPI">UPI Payment</option>
                </select>
            </div>

            <div class="form-group" id="card-details" style="display: none;">
                <label for="card-number">Card Number</label>
                <input type="text" name="card_number" id="card-number" placeholder="1234 5678 9012 3456">
            </div>

            <div class="form-group" id="upi-details" style="display: none;">
                <label for="upi-id">UPI ID</label>
                <input type="text" name="upi_id" id="upi-id" placeholder="yourname@upi">
            </div>

            <button type="submit" class="submit-btn">Place Order</button>
            <a href="cart.php" class="return-btn">Return to Cart</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const upiInput = document.getElementById('upi-id');
    const paymentForm = document.querySelector('.payment-form');

    if (upiInput && paymentForm) {
        paymentForm.addEventListener('submit', (e) => {
            const upiValue = upiInput.value.trim();
            const upiRegex = /^[a-zA-Z0-9._%+-]+@(oksbi|axl|sbi|hsbc|icici|pnb|canara|)$/;

            if (!upiRegex.test(upiValue)) {
                e.preventDefault(); // Prevent form submission
                alert("Invalid UPI ID. Please enter a valid UPI ID (e.g., yourname@oksbi or yourname@axl).");
                upiInput.focus();
            }
        });
    }
});
    </script>

    <script>
        const paymentMethod = document.getElementById('payment-method');
        const cardDetails = document.getElementById('card-details');
        const upiDetails = document.getElementById('upi-details');

        if (paymentMethod) {
            paymentMethod.addEventListener('change', () => {
                if (paymentMethod.value === 'card') {
                    cardDetails.style.display = 'block';
                    upiDetails.style.display = 'none';
                } else if (paymentMethod.value === 'UPI') {
                    upiDetails.style.display = 'block';
                    cardDetails.style.display = 'none';
                } else {
                    cardDetails.style.display = 'none';
                    upiDetails.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>