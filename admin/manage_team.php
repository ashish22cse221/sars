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
                $name = $_POST['name'];
                $role = $_POST['role'];
                $bio = $_POST['bio'];
                $linkedin_url = $_POST['linkedin_url'];
                $display_order = $_POST['display_order'];
                
                // Handle image upload
                $image_path = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $upload_dir = '../images/';
                    $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_filename = 'team_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $image_path = 'images/' . $new_filename;
                    }
                }
                
                $stmt = $pdo->prepare("INSERT INTO team_members (name, role, image_path, bio, linkedin_url, display_order) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $role, $image_path, $bio, $linkedin_url, $display_order]);
                $success_message = "Team member added successfully!";
                break;
                
            case 'edit':
                $id = $_POST['id'];
                $name = $_POST['name'];
                $role = $_POST['role'];
                $bio = $_POST['bio'];
                $linkedin_url = $_POST['linkedin_url'];
                $display_order = $_POST['display_order'];
                
                // Handle image upload
                $image_path = $_POST['current_image'];
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $upload_dir = '../images/';
                    $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $new_filename = 'team_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        // Delete old image if exists
                        if ($image_path && file_exists('../' . $image_path)) {
                            unlink('../' . $image_path);
                        }
                        $image_path = 'images/' . $new_filename;
                    }
                }
                
                $stmt = $pdo->prepare("UPDATE team_members SET name = ?, role = ?, image_path = ?, bio = ?, linkedin_url = ?, display_order = ? WHERE id = ?");
                $stmt->execute([$name, $role, $image_path, $bio, $linkedin_url, $display_order, $id]);
                $success_message = "Team member updated successfully!";
                break;
                
            case 'delete':
                $id = $_POST['id'];
                
                // Get image path before deleting
                $stmt = $pdo->prepare("SELECT image_path FROM team_members WHERE id = ?");
                $stmt->execute([$id]);
                $member = $stmt->fetch();
                
                // Delete the team member
                $stmt = $pdo->prepare("DELETE FROM team_members WHERE id = ?");
                $stmt->execute([$id]);
                
                // Delete image file if exists
                if ($member && $member['image_path'] && file_exists('../' . $member['image_path'])) {
                    unlink('../' . $member['image_path']);
                }
                
                $success_message = "Team member deleted successfully!";
                break;
        }
    }
}

// Get all team members
$stmt = $pdo->query("SELECT * FROM team_members ORDER BY display_order ASC");
$team_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Team - SARS Admin</title>
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

        .success-message {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 2rem;
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

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .team-card {
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--cyan-primary);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.2);
        }

        .member-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .member-info {
            padding: 1.5rem;
        }

        .member-name {
            color: var(--cyan-primary);
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .member-role {
            color: #ccc;
            margin-bottom: 1rem;
            font-style: italic;
        }

        .member-bio {
            color: #ddd;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .member-order {
            background: rgba(0, 255, 255, 0.1);
            color: var(--cyan-primary);
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
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
            
            .team-grid {
                grid-template-columns: 1fr;
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
                <li><a href="manage_team.php" class="active"><i class="fas fa-users"></i> Team</a></li>
                <li><a href="manage_terminal.php"><i class="fas fa-terminal"></i> Terminal</a></li>
                <li><a href="manage_messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="page-header">
                <h2 class="page-title">Manage Team</h2>
                <button class="btn" onclick="openModal('addModal')">
                    <i class="fas fa-plus"></i> Add Team Member
                </button>
            </div>

            <?php if (isset($success_message)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <div class="team-grid">
                <?php foreach ($team_members as $member): ?>
                    <div class="team-card">
                        <?php if ($member['image_path']): ?>
                            <img src="../<?php echo htmlspecialchars($member['image_path']); ?>" 
                                 alt="<?php echo htmlspecialchars($member['name']); ?>" class="member-image">
                        <?php else: ?>
                            <div style="width: 100%; height: 250px; background: rgba(0,255,255,0.1); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="font-size: 4rem; color: var(--cyan-primary);"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="member-info">
                            <div class="member-order">Order: <?php echo $member['display_order']; ?></div>
                            <h3 class="member-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                            <p class="member-role"><?php echo htmlspecialchars($member['role']); ?></p>
                            <p class="member-bio"><?php echo htmlspecialchars(substr($member['bio'] ?? '', 0, 150)) . '...'; ?></p>
                            
                            <div class="action-buttons">
                                <button class="btn btn-small" onclick="editMember(<?php echo htmlspecialchars(json_encode($member)); ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-small" onclick="deleteMember(<?php echo $member['id']; ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Add Team Member Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h3 style="color: var(--cyan-primary); margin-bottom: 2rem;">Add Team Member</h3>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" name="role" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" class="form-control"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="linkedin_url">LinkedIn URL</label>
                    <input type="url" id="linkedin_url" name="linkedin_url" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="display_order">Display Order</label>
                    <input type="number" id="display_order" name="display_order" class="form-control" value="0" required>
                </div>
                
                <div class="form-group">
                    <label for="image">Profile Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Add Member
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Team Member Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h3 style="color: var(--cyan-primary); margin-bottom: 2rem;">Edit Team Member</h3>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <input type="hidden" name="current_image" id="edit_current_image">
                
                <div class="form-group">
                    <label for="edit_name">Name</label>
                    <input type="text" id="edit_name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_role">Role</label>
                    <input type="text" id="edit_role" name="role" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_bio">Bio</label>
                    <textarea id="edit_bio" name="bio" class="form-control"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="edit_linkedin_url">LinkedIn URL</label>
                    <input type="url" id="edit_linkedin_url" name="linkedin_url" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="edit_display_order">Display Order</label>
                    <input type="number" id="edit_display_order" name="display_order" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="edit_image">Profile Image (leave empty to keep current)</label>
                    <input type="file" id="edit_image" name="image" class="form-control" accept="image/*">
                    <div id="current_image_preview" style="margin-top: 1rem;"></div>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Update Member
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
            <h3 style="color: #ff4444; margin-bottom: 2rem;">Confirm Delete</h3>
            <p>Are you sure you want to delete this team member? This action cannot be undone.</p>
            
            <form method="POST" style="margin-top: 2rem;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete_id">
                
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Member
                </button>
                <button type="button" class="btn" onclick="closeModal('deleteModal')" style="margin-left: 1rem;">
                    Cancel
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function editMember(member) {
            document.getElementById('edit_id').value = member.id;
            document.getElementById('edit_name').value = member.name;
            document.getElementById('edit_role').value = member.role;
            document.getElementById('edit_bio').value = member.bio || '';
            document.getElementById('edit_linkedin_url').value = member.linkedin_url || '';
            document.getElementById('edit_display_order').value = member.display_order;
            document.getElementById('edit_current_image').value = member.image_path;
            
            // Show current image preview
            const preview = document.getElementById('current_image_preview');
            if (member.image_path) {
                preview.innerHTML = `<img src="../${member.image_path}" style="max-width: 200px; border: 1px solid var(--cyan-primary); border-radius: 5px;">`;
            } else {
                preview.innerHTML = '<p style="color: #ccc;">No current image</p>';
            }
            
            openModal('editModal');
        }

        function deleteMember(id) {
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
    </script>
</body>
</html>
