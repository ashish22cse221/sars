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
                $stmt = $pdo->prepare("INSERT INTO achievements (title, description, tab_name, is_featured) VALUES (?, ?, ?, ?)");
                $stmt->execute([$_POST['title'], $_POST['description'], $_POST['tab_name'], isset($_POST['is_featured']) ? 1 : 0]);
                $success = "Achievement added successfully!";
                break;
                
            case 'edit':
                $stmt = $pdo->prepare("UPDATE achievements SET title = ?, description = ?, tab_name = ?, is_featured = ? WHERE id = ?");
                $stmt->execute([$_POST['title'], $_POST['description'], $_POST['tab_name'], isset($_POST['is_featured']) ? 1 : 0, $_POST['id']]);
                $success = "Achievement updated successfully!";
                break;
                
            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM achievements WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $success = "Achievement deleted successfully!";
                break;
        }
    }
}

// Get all achievements
$stmt = $pdo->query("SELECT * FROM achievements ORDER BY created_at DESC");
$achievements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Achievements - SARS Admin</title>
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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        
        .add-form {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
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
            min-height: 120px;
            resize: vertical;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--cyan-primary);
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
        
        .submit-btn {
            padding: 1rem 2rem;
            background: transparent;
            color: var(--cyan-primary);
            border: 2px solid var(--cyan-primary);
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            background: rgba(0, 255, 255, 0.1);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }
        
        .achievements-list {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            padding: 2rem;
        }
        
        .achievement-item {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--cyan-dark);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .achievement-item:hover {
            border-color: var(--cyan-primary);
            transform: translateY(-2px);
        }
        
        .achievement-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .achievement-title {
            color: var(--cyan-primary);
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        
        .achievement-tab {
            background: rgba(0, 255, 255, 0.1);
            color: var(--cyan-primary);
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            border: 1px solid var(--cyan-dark);
        }
        
        .featured-badge {
            background: rgba(255, 215, 0, 0.2);
            color: #ffd700;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            border: 1px solid #ffd700;
            margin-left: 0.5rem;
        }
        
        .achievement-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .edit-btn, .delete-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .edit-btn {
            background: rgba(0, 255, 255, 0.2);
            color: var(--cyan-primary);
            border: 1px solid var(--cyan-primary);
        }
        
        .delete-btn {
            background: rgba(255, 0, 0, 0.2);
            color: #ff4444;
            border: 1px solid #ff4444;
        }
        
        .edit-btn:hover {
            background: rgba(0, 255, 255, 0.3);
        }
        
        .delete-btn:hover {
            background: rgba(255, 0, 0, 0.3);
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
            background: rgba(10, 10, 21, 0.95);
            margin: 5% auto;
            padding: 2rem;
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
        }
        
        .close {
            color: var(--cyan-primary);
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: white;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1><i class="fas fa-trophy"></i> Manage Achievements</h1>
        <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </header>
    
    <div class="container">
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <!-- Add Achievement Form -->
        <div class="add-form">
            <h2 style="color: var(--cyan-primary); margin-bottom: 1.5rem;">Add New Achievement</h2>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="tab_name">Tab Name</label>
                    <input type="text" id="tab_name" name="tab_name" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_featured" name="is_featured">
                        <label for="is_featured">Featured (Show on homepage)</label>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Add Achievement</button>
            </form>
        </div>
        
        <!-- Achievements List -->
        <div class="achievements-list">
            <h2 style="color: var(--cyan-primary); margin-bottom: 1.5rem;">All Achievements</h2>
            
            <?php foreach ($achievements as $achievement): ?>
                <div class="achievement-item">
                    <div class="achievement-header">
                        <div>
                            <h3 class="achievement-title"><?php echo htmlspecialchars($achievement['title']); ?></h3>
                            <span class="achievement-tab"><?php echo htmlspecialchars($achievement['tab_name']); ?></span>
                            <?php if ($achievement['is_featured']): ?>
                                <span class="featured-badge">Featured</span>
                            <?php endif; ?>
                        </div>
                        <div class="achievement-actions">
                            <button class="edit-btn" onclick="editAchievement(<?php echo $achievement['id']; ?>)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this achievement?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $achievement['id']; ?>">
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <p><?php echo htmlspecialchars($achievement['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="color: var(--cyan-primary); margin-bottom: 1.5rem;">Edit Achievement</h2>
            <form method="POST" id="editForm">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_title">Title</label>
                    <input type="text" id="edit_title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_tab_name">Tab Name</label>
                    <input type="text" id="edit_tab_name" name="tab_name" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_description">Description</label>
                    <textarea id="edit_description" name="description" required></textarea>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="edit_is_featured" name="is_featured">
                        <label for="edit_is_featured">Featured (Show on homepage)</label>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Update Achievement</button>
            </form>
        </div>
    </div>
    
    <script>
        const achievements = <?php echo json_encode($achievements); ?>;
        
        function editAchievement(id) {
            const achievement = achievements.find(a => a.id == id);
            if (achievement) {
                document.getElementById('edit_id').value = achievement.id;
                document.getElementById('edit_title').value = achievement.title;
                document.getElementById('edit_tab_name').value = achievement.tab_name;
                document.getElementById('edit_description').value = achievement.description;
                document.getElementById('edit_is_featured').checked = achievement.is_featured == 1;
                
                document.getElementById('editModal').style.display = 'block';
            }
        }
        
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
