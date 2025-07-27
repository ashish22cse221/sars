<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check credentials
    if ($username === 'sars@admin' && $password === 'sars@2025') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARS Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --cyan-primary: #00ffff;
            --cyan-dark: #00b3b3;
            --dark-bg: #0a0a15;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--dark-bg);
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('../images/img1.jpg');
            background-size: cover;
            background-position: center;
        }
        
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 21, 0.9);
            z-index: -1;
        }
        
        .login-container {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid var(--cyan-primary);
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 0 30px rgba(0, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 400px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo h1 {
            color: var(--cyan-primary);
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 0 10px var(--cyan-primary);
        }
        
        .logo p {
            color: #ccc;
            margin-top: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--cyan-primary);
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--cyan-dark);
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--cyan-primary);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }
        
        .login-btn {
            width: 100%;
            padding: 1rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .login-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: rgba(0, 255, 255, 0.1);
            transition: width 0.4s ease;
            z-index: -1;
        }
        
        .login-btn:hover::before {
            width: 100%;
        }
        
        .login-btn:hover {
            color: white;
            text-shadow: 0 0 5px var(--cyan-primary);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        
        .error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff4444;
            color: #ff4444;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>SARS</h1>
            <p>Admin Panel</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>
