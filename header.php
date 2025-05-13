<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wow Gifts | Premium Custom Gifts for Every Occasion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Dancing+Script:wght@500;600;700&display=swap');

        :root {
            --primary: #e83e8c;
            --secondary: #ff69b4;
            --accent: #ffd166;
            --dark: #2d3436;
            --light: #f7f7f7;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }

        .container {
            margin-top: 80px;
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: var(--white);
            box-shadow: var(--shadow);
            position: relative;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            transition: var(--transition);
        }

        header.scrolled {
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(5px);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Dancing Script', cursive;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo a {
    text-decoration: none; /* Remove underline */
}

        .logo i {
            margin-right: 10px;
            font-size: 1.8rem;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 30px;
            position: relative;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: 1rem;
            transition: var(--transition);
            padding: 5px 0;
        }

        nav ul li a:hover {
            color: var(--primary);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .nav-cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 10px 20px;
            border-radius: 30px;
            margin-left: 20px;
            box-shadow: var(--shadow);
        }

        .nav-cta:hover {
            transform: translateY(-3px);
            color: var(--white);
        }

        .nav-cta:hover::after {
            width: 0;
        }

        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* User Profile - Updated to match reference image */
        .user-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-action {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            color: var(--dark);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .user-action:hover {
            color: var(--primary);
        }

        .user-action a {
        display: flex; /* Use flexbox for alignment */
        flex-direction: column; /* Stack icon and text vertically */
        align-items: center; /* Center-align the icon and text */
        text-decoration: none; /* Remove underline from the link */
        color: var(--dark); /* Set text color */
        font-size: 0.9rem; /* Adjust text size */
        transition: var(--transition); /* Add smooth transition */
        }

        .user-action a:hover {
        color: var(--primary); /* Change color on hover */
        }

        .user-action a i {
        font-size: 1.5rem; /* Adjust icon size */
        margin-bottom: 0.25px; /* Add space between icon and text */
        }

        .user-action a span {
        text-align: center; /* Center-align the text */
        }

        .user-action i {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .user-action span {
            font-size: 0.9rem; /* Adjust text size */
            text-align: center; /* Center-align the text */
            margin-top: 5px; /* Add space between the icon and text */
        }

        .user-action:hover {
            color: inherit; /* Prevent color change on hover */
        }

        .profile-dropdown {
        position: absolute;
    top: 100%;
    right: 0;
    background: var(--white);
    border-radius: 10px;
    box-shadow: var(--shadow);
    padding: 20px;
    width: 250px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
    transform: translateY(10px);
        }

        .profile-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-dropdown-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .profile-dropdown-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .profile-dropdown-header h4 {
            font-size: 1rem;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .profile-dropdown-header p {
            color: #777;
            font-size: 0.8rem;
        }

        .profile-dropdown-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .profile-dropdown-menu li {
            margin-bottom: 10px;
        }

        .profile-dropdown-menu a {
            display: flex;
            align-items: center;
            color: var(--dark);
            text-decoration: none;
            padding: 8px 0;
            transition: var(--transition);
        }

        .profile-dropdown-menu a:hover {
            color: var(--primary);
        }

        .profile-dropdown-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .login-signup {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .login-signup a {
            text-align: center;
            padding: 8px;
            border-radius: 4px;
            text-decoration: none;
            transition: var(--transition);
        }

        .login-signup a:first-child {
            background: var(--primary);
            color: white;
        }

        .login-signup a:last-child {
            border: 1px solid #ddd;
            color: var(--dark);
        }

        .login-signup a:hover {
            opacity: 0.9;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu {  
                display: block;
            }

            nav {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 80%;
                height: calc(100vh - 80px);
                background: var(--white);
                box-shadow: var(--shadow);
                transition: var(--transition);
                z-index: 999;
            }

            nav.active {
                left: 0;
            }

            nav ul {
                flex-direction: column;
                padding: 30px;
            }

            nav ul li {
                margin: 15px 0;
            }

            .nav-cta {
                margin-left: 0;
                display: block;
                text-align: center;
            }

            .hero h1 {
                font-size: 2.8rem;
            }

            .hero-btns {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-form input {
                border-radius: 30px;
                margin-bottom: 10px;
            }

            .newsletter-form button {
                border-radius: 30px;
                padding: 15px;
            }

            .profile-dropdown {
                width: 200px;
                right: 20px;
            }

            .user-actions {
                gap: 15px;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .user-action span {
                display: none;
            }

            .user-action i {
                margin-bottom: 0;
                font-size: 1.5rem;
            }
        }
        #back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--primary);
        color: var(--white);
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.2rem;
        cursor: pointer;
        box-shadow: var(--shadow);
        transition: var(--transition);
        z-index: 1000;
        }

        #back-to-top:hover {
        background: var(--secondary);
        transform: translateY(-3px);
        }
        #logout-btn {
    background: var(--primary);
    color: var(--white);
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: var(--transition);
}

#logout-btn:hover {
    background: var(--secondary);
}
    </style>
</head>
<body>
    <!-- Header -->
    <header id="header">
        <div class="container header-container">
            <a href="index.php" class="logo">
            <i class="fas fa-gift"></i>
            <span>Wow Gifts</span>
        </a>
            
            <!--<nav id="nav">
                <ul>
                    <li><a href="#features">Why Us?</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                </ul>
            </nav>-->
            
            <!-- User Actions Section -->
            <div class="user-actions">
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Show welcome message when logged in -->
                    <div class="user-action" id="user-profile">
                        <i class="fas fa-user-circle"></i>
                        <span>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></span>

                    </div>
                <?php else: ?>
                    <!-- Show login button when not logged in -->
                    <div class="user-action">
                        <a href="login.php">
                            <i class="fas fa-user"></i>
                            <span>Login</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Profile Dropdown -->
            <div id="profile-dropdown" class="profile-dropdown">
                <div id="logged-in-content" style="display: none;">
                    <ul class="profile-dropdown-menu">
                        <li><a href="purchase-history.php"><i class="fas fa-box"></i> Orders</a></li>
                    </ul>
                    <button id="logout-btn" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Logout</button>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Mobile Menu Toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const nav = document.getElementById('nav');
        
        mobileMenu.addEventListener('click', () => {
            nav.classList.toggle('active');
            mobileMenu.innerHTML = nav.classList.contains('active') ? 
                '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
        
        // Header Scroll Effect
        const header = document.getElementById('header');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Animation on Scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.feature-card, .product-card, .testimonial-card');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };
        
        // Set initial state for animated elements
        document.querySelectorAll('.feature-card, .product-card, .testimonial-card').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'all 0.6s ease';
        });
        
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
    </script>

    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userProfile = document.getElementById('user-profile');
            const loginState = document.getElementById('login-state');
            const profileState = document.getElementById('profile-state');
            const profileDropdown = document.getElementById('profile-dropdown');
            const loggedInContent = document.getElementById('logged-in-content');
            const loggedOutContent = document.getElementById('logged-out-content');
            const logoutBtn = document.getElementById('logout-btn');
    
            // Load user data from localStorage
            const userData = JSON.parse(localStorage.getItem('user')) || null;
    
            // Check if user is logged in
            if (userData) {
                // Show profile state
                loginState.style.display = 'none';
                profileState.style.display = 'flex';
                loggedInContent.style.display = 'block';
                loggedOutContent.style.display = 'none';
    
                // Update user info
                document.getElementById('profile-name').textContent = userData.name.split(' ')[0];
                document.getElementById('user-name').textContent = userData.name;
                document.getElementById('user-email').textContent = userData.email;
    
                if (userData.image) {
                    document.getElementById('user-image').src = userData.image;
                }
            } else {
                // Show login state
                loginState.style.display = 'flex';
                profileState.style.display = 'none';
                loggedInContent.style.display = 'none';
                loggedOutContent.style.display = 'block';
            }
    
            // Toggle profile dropdown
            userProfile.addEventListener('click', (e) => {
                if (e.target.closest('.user-action')) {
                    profileDropdown.classList.toggle('active');
                }
            });
    
            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!userProfile.contains(e.target)) {
                    profileDropdown.classList.remove('active');
                }
            });
    
            // Logout functionality
            logoutBtn.addEventListener('click', () => {
                localStorage.removeItem('user');
                location.reload();
            });
    
            // Redirect to login page when clicking on "Login"
            document.querySelectorAll('[href="login.php"]').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = 'login.php';
                });
            });
        });
    </script>
    <script>
    // Smooth Scrolling for Navigation Links
    document.querySelectorAll('nav ul li a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default anchor behavior

            const targetId = this.getAttribute('href'); // Get the target section ID
            const targetElement = document.querySelector(targetId); // Find the target element

            if (targetElement) {
                // Scroll to the target element smoothly
                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Adjust for header height
                    behavior: 'smooth'
                });
            }
        });
    });

    </script>
<script>
        document.addEventListener('DOMContentLoaded', () => {
            const userProfile = document.getElementById('user-profile');
            const profileDropdown = document.getElementById('profile-dropdown');
            const loggedInContent = document.getElementById('logged-in-content');
            const logoutBtn = document.getElementById('logout-btn');

            // Toggle dropdown visibility on click
            userProfile.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent click from propagating to document
                profileDropdown.classList.toggle('active');
                loggedInContent.style.display = profileDropdown.classList.contains('active') ? 'block' : 'none';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!userProfile.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.remove('active');
                    loggedInContent.style.display = 'none';
                }
            });

            // Logout functionality
    logoutBtn.addEventListener('click', () => {
        // Remove user session or localStorage data
        localStorage.removeItem('user');
        // Redirect to logout.php or reload the page
        window.location.href = 'logout.php';
    });
});
</script>

<script>
    const backToTopButton = document.getElementById('back-to-top');

window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        backToTopButton.style.display = 'flex';
    } else {
        backToTopButton.style.display = 'none';
    }
});

backToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>
</body>
</html>