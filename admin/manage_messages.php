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
            case 'mark_read':
                $id = $_POST['id'];
                
                $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
                $stmt->execute([$id]);
                $success_message = "Message marked as read!";
                break;
                
            case 'mark_unread':
                $id = $_POST['id'];
                
                $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 0 WHERE id = ?");
                $stmt->execute([$id]);
                $success_message = "Message marked as unread!";
                break;
                
            case 'delete':
                $id = $_POST['id'];
                
                $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
                $stmt->execute([$id]);
                $success_message = "Message deleted successfully!";
                break;
                
            case 'bulk_action':
                $action = $_POST['bulk_action'];
                $selected_ids = $_POST['selected_messages'] ?? [];
                
                if (!empty($selected_ids)) {
                    $placeholders = str_repeat('?,', count($selected_ids) - 1) . '?';
                    
                    switch ($action) {
                        case 'mark_read':
                            $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id IN ($placeholders)");
                            $stmt->execute($selected_ids);
                            $success_message = count($selected_ids) . " messages marked as read!";
                            break;
                            
                        case 'mark_unread':
                            $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 0 WHERE id IN ($placeholders)");
                            $stmt->execute($selected_ids);
                            $success_message = count($selected_ids) . " messages marked as unread!";
                            break;
                            
                        case 'delete':
                            $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id IN ($placeholders)");
                            $stmt->execute($selected_ids);
                            $success_message = count($selected_ids) . " messages deleted!";
                            break;
                    }
                }
                break;
        }
    }
}

// Get filter parameters
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['search'] ?? '';

// Build query based on filters
$where_conditions = [];
$params = [];

if ($filter === 'unread') {
    $where_conditions[] = "is_read = 0";
} elseif ($filter === 'read') {
    $where_conditions[] = "is_read = 1";
}

if (!empty($search)) {
    $where_conditions[] = "(name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $search_param = "%$search%";
    $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param]);
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Get messages with pagination
$page = $_GET['page'] ?? 1;
$per_page = 20;
$offset = ($page - 1) * $per_page;

$count_query = "SELECT COUNT(*) FROM contact_messages $where_clause";
$stmt = $pdo->prepare($count_query);
$stmt->execute($params);
$total_messages = $stmt->fetchColumn();
$total_pages = ceil($total_messages / $per_page);

$query = "SELECT * FROM contact_messages $where_clause ORDER BY created_at DESC LIMIT $per_page OFFSET $offset";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get statistics
$stats = [];
$stats['total'] = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
$stats['unread'] = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
$stats['read'] = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 1")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages - SARS Admin</title>
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

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 2rem;
            color: var(--cyan-primary);
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #ccc;
            font-size: 0.9rem;
        }

        .filters-section {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filters-row {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group label {
            color: var(--cyan-primary);
            font-weight: bold;
        }

        .form-control {
            padding: 0.5rem;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--cyan-primary);
            border-radius: 5px;
            color: white;
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 255, 255, 0.3);
        }

        .btn {
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn:hover {
            background: rgba(0, 255, 255, 0.1);
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

        .success-message {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
        }

        .bulk-actions {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: none;
        }

        .bulk-actions.show {
            display: block;
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

        .messages-table tr.unread {
            background: rgba(0, 255, 255, 0.02);
            border-left: 3px solid var(--cyan-primary);
        }

        .status-badge {
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-read {
            background: #00ff00;
            color: var(--dark-bg);
        }

        .status-unread {
            background: #ffaa00;
            color: var(--dark-bg);
        }

        .message-preview {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-small {
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 5px;
            color: var(--cyan-primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: rgba(0, 255, 255, 0.1);
        }

        .pagination .current {
            background: var(--cyan-primary);
            color: var(--dark-bg);
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
            overflow-y: auto;
        }

        .modal-content {
            background: var(--dark-secondary);
            margin: 2% auto;
            padding: 2rem;
            border: 2px solid var(--cyan-primary);
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
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

        .message-details {
            line-height: 1.6;
        }

        .message-details h4 {
            color: var(--cyan-primary);
            margin-bottom: 0.5rem;
        }

        .message-details p {
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
            
            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .stats-row {
                grid-template-columns: 1fr;
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
                <li><a href="manage_terminal.php"><i class="fas fa-terminal"></i> Terminal</a></li>
                <li><a href="manage_messages.php" class="active"><i class="fas fa-envelope"></i> Messages</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="page-header">
                <h2 class="page-title">Contact Messages</h2>
            </div>

            <?php if (isset($success_message)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['total']; ?></div>
                    <div class="stat-label">Total Messages</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['unread']; ?></div>
                    <div class="stat-label">Unread Messages</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $stats['read']; ?></div>
                    <div class="stat-label">Read Messages</div>
                </div>
            </div>

            <div class="filters-section">
                <form method="GET" class="filters-row">
                    <div class="filter-group">
                        <label for="filter">Filter:</label>
                        <select name="filter" id="filter" class="form-control">
                            <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>All Messages</option>
                            <option value="unread" <?php echo $filter === 'unread' ? 'selected' : ''; ?>>Unread Only</option>
                            <option value="read" <?php echo $filter === 'read' ? 'selected' : ''; ?>>Read Only</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="search">Search:</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               placeholder="Search messages..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    
                    <button type="submit" class="btn">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    
                    <a href="manage_messages.php" class="btn">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </form>
            </div>

            <div class="bulk-actions" id="bulkActions">
                <form method="POST">
                    <input type="hidden" name="action" value="bulk_action">
                    <div class="filters-row">
                        <span style="color: var(--cyan-primary);">Bulk Actions:</span>
                        <select name="bulk_action" class="form-control" required>
                            <option value="">Select Action</option>
                            <option value="mark_read">Mark as Read</option>
                            <option value="mark_unread">Mark as Unread</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button type="submit" class="btn btn-success">Apply</button>
                        <button type="button" class="btn" onclick="clearSelection()">Clear Selection</button>
                    </div>
                    <div id="selectedMessages"></div>
                </form>
            </div>

            <table class="messages-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                        </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr class="<?php echo !$message['is_read'] ? 'unread' : ''; ?>">
                            <td>
                                <input type="checkbox" class="message-checkbox" value="<?php echo $message['id']; ?>" 
                                       onchange="updateBulkActions()">
                            </td>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo htmlspecialchars($message['email']); ?></td>
                            <td><?php echo htmlspecialchars($message['subject']); ?></td>
                            <td>
                                <div class="message-preview">
                                    <?php echo htmlspecialchars(substr($message['message'], 0, 100)) . '...'; ?>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $message['is_read'] ? 'read' : 'unread'; ?>">
                                    <?php echo $message['is_read'] ? 'Read' : 'Unread'; ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y H:i', strtotime($message['created_at'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-small" onclick="viewMessage(<?php echo htmlspecialchars(json_encode($message)); ?>)">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="<?php echo $message['is_read'] ? 'mark_unread' : 'mark_read'; ?>">
                                        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                        <button type="submit" class="btn <?php echo $message['is_read'] ? 'btn-success' : 'btn-success'; ?> btn-small">
                                            <i class="fas fa-<?php echo $message['is_read'] ? 'envelope' : 'envelope-open'; ?>"></i>
                                            <?php echo $message['is_read'] ? 'Unread' : 'Read'; ?>
                                        </button>
                                    </form>
                                    
                                    <button class="btn btn-danger btn-small" onclick="deleteMessage(<?php echo $message['id']; ?>)">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $page): ?>
                            <span class="current"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&filter=<?php echo $filter; ?>&search=<?php echo urlencode($search); ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- View Message Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('viewModal')">&times;</span>
            <h3 style="color: var(--cyan-primary); margin-bottom: 2rem;">Message Details</h3>
            
            <div class="message-details" id="messageDetails">
                <!-- Message details will be populated here -->
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h3 style="color: #ff4444; margin-bottom: 2rem;">Confirm Delete</h3>
            <p>Are you sure you want to delete this message? This action cannot be undone.</p>
            
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
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.message-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedMessages = document.getElementById('selectedMessages');
            
            if (checkboxes.length > 0) {
                bulkActions.classList.add('show');
                
                // Add hidden inputs for selected message IDs
                selectedMessages.innerHTML = '';
                checkboxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_messages[]';
                    input.value = checkbox.value;
                    selectedMessages.appendChild(input);
                });
            } else {
                bulkActions.classList.remove('show');
            }
        }

        function clearSelection() {
            const checkboxes = document.querySelectorAll('.message-checkbox');
            const selectAll = document.getElementById('selectAll');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAll.checked = false;
            
            updateBulkActions();
        }

        function viewMessage(message) {
            const details = document.getElementById('messageDetails');
            
            details.innerHTML = `
                <div class="message-details">
                    <h4>From:</h4>
                    <p>${message.name} (${message.email})</p>
                    
                    <h4>Subject:</h4>
                    <p>${message.subject}</p>
                    
                    <h4>Date:</h4>
                    <p>${new Date(message.created_at).toLocaleString()}</p>
                    
                    <h4>Status:</h4>
                    <p><span class="status-badge status-${message.is_read ? 'read' : 'unread'}">
                        ${message.is_read ? 'Read' : 'Unread'}
                    </span></p>
                    
                    <h4>Message:</h4>
                    <p style="white-space: pre-wrap; background: rgba(0,0,0,0.3); padding: 1rem; border-radius: 5px; border: 1px solid var(--cyan-primary);">${message.message}</p>
                </div>
            `;
            
            openModal('viewModal');
        }

        function deleteMessage(id) {
            document.getElementById('delete_id').value = id;
            openModal('deleteModal');
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
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

        // Auto-refresh unread count every 30 seconds
        setInterval(function() {
            fetch('api/get_unread_count.php')
                .then(response => response.json())
                .then(data => {
                    if (data.count !== undefined) {
                        const unreadStat = document.querySelector('.stat-card:nth-child(2) .stat-number');
                        if (unreadStat) {
                            unreadStat.textContent = data.count;
                        }
                    }
                })
                .catch(error => console.error('Error fetching unread count:', error));
        }, 30000);
    </script>
</body>
</html>
