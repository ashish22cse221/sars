<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    
    $stmt = $pdo->prepare("UPDATE about_us SET title = ?, subtitle = ?, description = ? WHERE id = 1");
    $stmt->execute([$title, $subtitle, $description]);
    
    $success = "About Us section updated successfully!";
}

// Get current about us data
$stmt = $pdo->query("SELECT * FROM about_us WHERE id = 1");
$about = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About Us - SARS Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        }
        
        .admin-header {
            background: rgba(0, 0, 0, 0.9);
            border-bottom: 2px solid var(--cyan-primary);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            color: var(--cyan-primary);
            font-size: 1.8rem;
        }
        
        .back-btn {
            background: transparent;
            color: var(--cyan-primary);
            border: 1px solid var(--cyan-primary);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .back-btn:hover {
            background: rgba(0, 255, 255, 0.1);
        }
        
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .form-container {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            padding: 2rem;
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
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--cyan-dark);
            border-radius: 5px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group textarea {
            min-height: 200px;
            resize: vertical;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--cyan-primary);
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }
        
        .submit-btn {
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
        }
        
        .submit-btn:hover {
            background: rgba(0, 255, 255, 0.1);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        
        .success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1><i class="fas fa-info-circle"></i> Manage About Us</h1>
        <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </header>
    
    <div class="container">
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($about['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" value="<?php echo htmlspecialchars($about['subtitle']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($about['description']); ?></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Update About Us</button>
            </form>
        </div>
    </div>
</body>
</html>
