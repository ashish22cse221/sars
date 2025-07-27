<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

// Get statistics
$stats = [];
$stats['achievements'] = $pdo->query("SELECT COUNT(*) FROM achievements")->fetchColumn();
$stats['projects'] = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$stats['events'] = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$stats['messages'] = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SARS Admin Dashboard</title>
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
            --dark-secondary: #121228;
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
        
        .logout-btn {
            background: transparent;
            color: var(--cyan-primary);
            border: 1px solid var(--cyan-primary);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: rgba(0, 255, 255, 0.1);
        }
        
        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: calc(100vh - 80px);
        }
        
        .sidebar {
            background: rgba(0, 0, 0, 0.8);
            border-right: 1px solid var(--cyan-primary);
            padding: 2rem 0;
        }
        
        .sidebar ul {
            list-style: none;
        }
        
        .sidebar ul li {
            margin-bottom: 0.5rem;
        }
        
        .sidebar ul li a {
            display: block;
            padding: 1rem 2rem;
            color: #e0e0e0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: rgba(0, 255, 255, 0.1);
            border-left-color: var(--cyan-primary);
            color: var(--cyan-primary);
        }
        
        .main-content {
            padding: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.2);
        }
        
        .stat-card i {
            font-size: 3rem;
            color: var(--cyan-primary);
            margin-bottom: 1rem;
        }
        
        .stat-card h3 {
            font-size: 2rem;
            color: var(--cyan-primary);
            margin-bottom: 0.5rem;
        }
        
        .stat-card p {
            color: #ccc;
        }
        
        .welcome-section {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
        }
        
        .welcome-section h2 {
            color: var(--cyan-primary);
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1><i class="fas fa-robot"></i> SARS Admin Dashboard</h1>
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </header>
    
    <div class="dashboard-container">
        <nav class="sidebar">
            <ul>
                <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="manage_about.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="manage_achievements.php"><i class="fas fa-trophy"></i> Achievements</a></li>
                <li><a href="manage_projects.php"><i class="fas fa-project-diagram"></i> Projects</a></li>
                <li><a href="manage_events.php"><i class="fas fa-calendar"></i> Events</a></li>
                <li><a href="manage_team.php"><i class="fas fa-users"></i> Team</a></li>
                <li><a href="manage_terminal.php"><i class="fas fa-terminal"></i> Terminal</a></li>
                <li><a href="manage_messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
            </ul>
        </nav>
        
        <main class="main-content">
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-trophy"></i>
                    <h3><?php echo $stats['achievements']; ?></h3>
                    <p>Achievements</p>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-project-diagram"></i>
                    <h3><?php echo $stats['projects']; ?></h3>
                    <p>Projects</p>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-calendar"></i>
                    <h3><?php echo $stats['events']; ?></h3>
                    <p>Events</p>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-envelope"></i>
                    <h3><?php echo $stats['messages']; ?></h3>
                    <p>Unread Messages</p>
                </div>
            </div>
            
            <div class="welcome-section">
                <h2>Welcome to SARS Admin Panel</h2>
                <p>Manage your website content from this dashboard. Use the sidebar to navigate between different sections.</p>
            </div>
        </main>
    </div>
</body>
</html>
