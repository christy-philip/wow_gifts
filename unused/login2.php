<?php
// Include database connection
require_once 'database.php';

// Handle Signup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userExists) {
        echo "<script>alert('User already exists. Please log in.');</script>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $password])) {
            echo "<script>alert('Sign-Up successful! Please log in.');</script>";
        } else {
            echo "<script>alert('Error: Could not sign up. Please try again.');</script>";
        }
    }
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo "<script>alert('Login successful! Welcome, " . htmlspecialchars($user['username']) . ".');</script>";
    } else {
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup | Wow Gifts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(45deg, rgba(232, 62, 140, 0.1), rgba(255, 255, 255, 0.9)),
                        url('https://images.unsplash.com/photo-1513151233558-d860c5398176?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            animation: backgroundZoom 20s infinite alternate;
        }

        @keyframes backgroundZoom {
            0% { background-size: 100% auto; }
            100% { background-size: 120% auto; }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(232, 62, 140, 0.15);
            width: 100%;
            max-width: 440px;
            transform: translateY(0);
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(232, 62, 140, 0.2);
        }

        h1 {
            text-align: center;
            color: #e83e8c;
            margin-bottom: 30px;
            font-size: 2.2em;
            position: relative;
            padding-bottom: 15px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #e83e8c;
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #555;
            font-size: 1.1em;
        }

        .form-group input {
            width: 85%;
            padding: 14px 20px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
            padding-left: 45px;
        }

        .form-group input:focus {
            border-color: #e83e8c;
            box-shadow: 0 0 10px rgba(232, 62, 140, 0.1);
            outline: none;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 40px;
            color: #999;
            font-size: 1.1em;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #e83e8c, #ff69b4);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1em;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            box-shadow: 0 8px 20px rgba(232, 62, 140, 0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.95em;
        }

        .register-link a {
            color: #e83e8c;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .register-link a:hover {
            text-decoration: none;
            background: rgba(232, 62, 140, 0.1);
            border-color: rgba(232, 62, 140, 0.2);
        }

        #name-group {
            display: none;
            transition: all 0.3s ease;
        }
        </style>
</head>
<body>
    <div class="form-container">
        <h2 id="form-title">Login</h2>
        <form action="login.php" method="POST" id="auth-form">
            <div id="name-group" style="display: none;">
                <input type="text" name="name" placeholder="Name">
            </div>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" id="auth-btn">Login</button>
        </form>
        <p id="toggle-auth">
            Don't have an account? <a href="#" id="toggle-link">Sign Up</a>
        </p>
    </div>

    <script>
        const formTitle = document.getElementById('form-title');
        const nameGroup = document.getElementById('name-group');
        const authBtn = document.getElementById('auth-btn');
        const toggleAuth = document.getElementById('toggle-auth');
        const authForm = document.getElementById('auth-form');

        let isLogin = true;

        toggleAuth.addEventListener('click', (e) => {
            e.preventDefault();
            isLogin = !isLogin;

            if (isLogin) {
                formTitle.textContent = 'Login';
                nameGroup.style.display = 'none';
                authBtn.textContent = 'Login';
                authBtn.setAttribute('name', 'login');
                toggleAuth.innerHTML = `Don't have an account? <a href="#" id="toggle-link">Sign Up</a>`;
            } else {
                formTitle.textContent = 'Sign Up';
                nameGroup.style.display = 'block';
                authBtn.textContent = 'Sign Up';
                authBtn.setAttribute('name', 'signup');
                toggleAuth.innerHTML = `Already have an account? <a href="#" id="toggle-link">Login</a>`;
            }
        });
    </script>
</body>
</html>