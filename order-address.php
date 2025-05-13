<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address1'], $_POST['address2'], $_POST['address3'])) {
    $address1 = trim($_POST['address1']);
    $address2 = trim($_POST['address2']);
    $address3 = trim($_POST['address3']);

    // Combine the address fields into a single string
    $address = $address1;
    if (!empty($address2)) {
        $address .= ', ' . $address2;
    }
    if (!empty($address3)) {
        $address .= ', ' . $address3;
    }

    error_log("Form submitted with POST data: " . json_encode($_POST)); // Debug log
    error_log("Combined Address: " . $address); // Debug log

    if (empty($address1)) {
        $error = "Address Line 1 is required.";
    } else {
        $_SESSION['address'] = $address; // Save combined address in session
        error_log("Address saved in session: " . $_SESSION['address']); // Debug log
        header("Location: order-confirmation.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Address | Wow Gifts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-container h1 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: none;
            height: 100px;
        }
        .form-group .error {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .form-group input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    color: #333;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group input[type="text"]:focus {
    border-color: #e83e8c;
    box-shadow: 0 0 5px rgba(232, 62, 140, 0.5);
    outline: none;
}

        .form-group input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    color: #333;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group input[type="number"]:focus {
    border-color: #e83e8c;
    box-shadow: 0 0 5px rgba(232, 62, 140, 0.5);
    outline: none;
}

        .submit-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #e83e8c;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            background: #ff69b4;
        }
        .return-btn {
    display: block;
    text-align: center;
    margin-top: 15px;
    padding: 12px;
    background: #ddd;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.return-btn:hover {
    background: #bbb;
    color: #000;
}
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Enter Delivery Address</h1>
        <form method="POST" action="">
    <div class="form-group">
        <label for="address1">Address 1</label>
        <input type="text" name="address1" id="address1" placeholder="Enter Address" required value="<?= htmlspecialchars($_SESSION['address1'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label for="address2">City</label>
        <input type="text" name="address2" id="address2" placeholder="Enter City" value="<?= htmlspecialchars($_SESSION['address2'] ?? '') ?>">
    </div>
    <div class="form-group">
        <label for="address3">Zip Code</label>
        <input type="number" name="address3" id="address3" placeholder="Enter Zip Code" value="<?= htmlspecialchars($_SESSION['address3'] ?? '') ?>" required maxlength="6" oninput="validateZipCode(this)">
    </div>
    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <input type="hidden" name="cart_data" value='<?= htmlspecialchars(json_encode($_SESSION['cart'] ?? []), ENT_QUOTES, 'UTF-8') ?>'>
    <input type="hidden" name="total_amount" value="<?= htmlspecialchars($_SESSION['total_amount'] ?? 0, ENT_QUOTES, 'UTF-8') ?>">
    <button type="submit" class="submit-btn">Proceed to Payment</button>
</form>
        <a href="cart.php" class="return-btn">Return to Cart</a>
</div>

<script>
    function validateZipCode(input) {
        const value = input.value;
        if (value.length > 6) {
            input.value = value.slice(0, 6);
        }
    }
</script>

</body>
</html>