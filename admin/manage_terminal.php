<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $message = $_POST['message'];
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $stmt = $pdo->prepare("INSERT INTO terminal_messages (message, is_active) VALUES (?, ?)");
                $stmt->execute([$message, $is_active]);
                $success_message = "Terminal message added successfully!";
                break;
                
            case 'edit':
                $id = $_POST['id'];
                $message = $_POST['message'];
                $is_active = isset($_POST['is_active']) ? 1 : 0;
                
                $stmt = $pdo->prepare("UPDATE terminal_messages SET message = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$message, $is_active, $id]);
                $success_message = "Terminal message updated successfully!";
                break;
                
            case 'delete':
                $id = $_POST['id'];
                
                $stmt = $pdo->prepare("DELETE FROM terminal_messages WHERE id = ?");
                $stmt->execute([$id]);
                $success_message = "Terminal message deleted successfully!";
                break;
                
            case 'toggle_status':
                $id = $_POST['id'];
                $current_status = $_POST['current_status'];
                $new_status = $current_status == 1 ? 0 : 1;
                
                $stmt = $pdo->prepare("UPDATE terminal_messages SET is_active = ? WHERE id = ?");
                $stmt->execute([$new_status, $id]);
                $success_message = "Message status updated successfully!";
                break;
        }
    }
}

// Get all terminal messages
$stmt = $pdo->query("SELECT * FROM terminal_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Terminal - SARS Admin</title>
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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            color: var(--cyan-primary);
            font-size: 2rem;
        }

        .btn {
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn:hover {
            background: rgba(0, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .btn-danger {
            border-color: #ff4444;
            color: #ff4444;
        }

        .btn-danger:hover {
            background: rgba(255, 68, 68, 0.1);
        }

        .btn-success {
            border-color: #00ff00;
            color: #00ff00;
        }

        .btn-success:hover {
            background: rgba(0, 255, 0, 0.1);
        }

        .btn-warning {
            border-color: #ffaa00;
            color: #ffaa00;
        }

        .btn-warning:hover {
            background: rgba(255, 170, 0, 0.1);
        }

        .success-message {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        .terminal-preview {
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid var(--cyan-primary);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            font-family: 'Courier New', monospace;
        }

        .terminal-preview h3 {
            color: var(--cyan-primary);
            margin-bottom: 1rem;
            font-family: 'Arial', sans-serif;
        }

        .terminal-line {
            display: flex;
            margin-bottom: 10px;
            animation: fadeIn 0.5s ease;
        }

        .terminal-prompt {
            color: var(--cyan-primary);
            margin-right: 8px;
            font-weight: bold;
        }

        .terminal-text {
            color: var(--cyan-primary);
            position: relative;
        }

        .terminal-text::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 0;
            height: 100%;
            width: 8px;
            background-color: var(--cyan-primary);
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background: var(--dark-secondary);
            margin: 5% auto;
            padding: 2rem;
            border: 2px solid var(--cyan-primary);
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .close {
            color: var(--cyan-primary);
            float: right;
            font-size: 2rem;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            right: 1rem;
            top: 1rem;
        }

        .close:hover {
            color: white;
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

        .form-control {
            width: 100%;
            padding: 0.8rem;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--cyan-primary);
            border-radius: 5px;
            color: white;
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
        }

        .messages-table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            overflow: hidden;
        }

        .messages-table th,
        .messages-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(0, 255, 255, 0.3);
        }

        .messages-table th {
            background: rgba(0, 255, 255, 0.1);
            color: var(--cyan-primary);
            font-weight: bold;
        }

        .messages-table tr:hover {
            background: rgba(0, 255, 255, 0.05);
        }

        .status-badge {
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-active {
            background: #00ff00;
            color: var(--dark-bg);
        }

        .status-inactive {
            background: #ff4444;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-small {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
            
            .modal-content {
                width: 95%;
                margin: 2% auto;
            }
            
            .messages-table {
                font-size: 0.9rem;
            }
            
            .action-buttons {
                flex-direction: column;
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
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="manage_about.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                <li><a href="manage_achievements.php"><i class="fas fa-trophy"></i> Achievements</a></li>
                <li><a href="manage_projects.php"><i class="fas fa-project-diagram"></i> Projects</a></li>
                <li><a href="manage_events.php"><i class="fas fa-calendar"></i> Events</a></li>
                <li><a href="manage_team.php"><i class="fas fa-users"></i> Team</a></li>
                <li><a href="manage_terminal.php" class="active"><i class="fas fa-terminal"></i> Terminal</a></li>
                <li><a href="manage_messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="page-header">
                <h2 class="page-title">Manage Terminal Messages</h2>
                <button class="btn" onclick="openModal('addModal')">
                    <i class="fas fa-plus"></i> Add Message
                </button>
            </div>

            <?php if (isset($success_message)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <div class="terminal-preview">
                <h3><i class="fas fa-terminal"></i> Terminal Preview</h3>
                <div id="terminalPreview">
                    <!-- Active messages will be displayed here -->
                </div>
            </div>

            <table class="messages-table">
                <thead>
                    <tr>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($message['message']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $message['is_active'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $message['is_active'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                        <input type="hidden" name="current_status" value="<?php echo $message['is_active']; ?>">
                                        <button type="submit" class="btn <?php echo $message['is_active'] ? 'btn-warning' : 'btn-success'; ?> btn-small">
                                            <i class="fas fa-<?php echo $message['is_active'] ? 'pause' : 'play'; ?>"></i>
                                            <?php echo $message['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                        </button>
                                    </form>
                                    <button class="btn btn-small" onclick="editMessage(<?php echo htmlspecialchars(json_encode($message)); ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-small" onclick="deleteMessage(<?php echo $message['id']; ?>)">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Add Message Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h3 style="color: var(--cyan-primary); margin-bottom: 2rem;">Add Terminal Message</h3>
            
            <form method="POST">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <input type="text" id="message" name="message" class="form-control" required 
                           placeholder="Enter terminal message...">
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" checked>
                        <label for="is_active">Active (will appear in terminal)</label>
                    </div>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Add Message
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Message Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h3 style="color: var(--cyan-primary); margin-bottom: 2rem;">Edit Terminal Message</h3>
            
            <form method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_message">Message</label>
                    <input type="text" id="edit_message" name="message" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="edit_is_active" name="is_active">
                        <label for="edit_is_active">Active (will appear in terminal)</label>
                    </div>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Update Message
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h3 style="color: #ff4444; margin-bottom: 2rem;">Confirm Delete</h3>
            <p>Are you sure you want to delete this terminal message? This action cannot be undone.</p>
            
            <form method="POST" style="margin-top: 2rem;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete_id">
                
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Message
                </button>
                <button type="button" class="btn" onclick="closeModal('deleteModal')" style="margin-left: 1rem;">
                    Cancel
                </button>
            </form>
        </div>
    </div>

    <script>
        // Load active messages for preview
        function loadTerminalPreview() {
            const activeMessages = <?php 
                $active_messages = array_filter($messages, function($msg) { return $msg['is_active']; });
                echo json_encode(array_values($active_messages)); 
            ?>;
            
            const preview = document.getElementById('terminalPreview');
            preview.innerHTML = '';
            
            if (activeMessages.length === 0) {
                preview.innerHTML = '<p style="color: #ccc; font-style: italic;">No active messages</p>';
                return;
            }
            
            activeMessages.forEach((message, index) => {
                setTimeout(() => {
                    const line = document.createElement('div');
                    line.className = 'terminal-line';
                    line.innerHTML = `
                        <span class="terminal-prompt">></span>
                        <span class="terminal-text">${message.message}</span>
                    `;
                    preview.appendChild(line);
                }, index * 1000);
            });
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function editMessage(message) {
            document.getElementById('edit_id').value = message.id;
            document.getElementById('edit_message').value = message.message;
            document.getElementById('edit_is_active').checked = message.is_active == 1;
            
            openModal('editModal');
        }

        function deleteMessage(id) {
            document.getElementById('delete_id').value = id;
            openModal('deleteModal');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });
        }

        // Load terminal preview on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadTerminalPreview();
        });
    </script>
</body>
</html>
