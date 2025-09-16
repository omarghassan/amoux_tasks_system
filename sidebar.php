<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/sidebar.css">
</head>

<body>
    <!-- Mobile Toggle Button -->
    <div class="d-md-none">
        <button class="btn btn-dark m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
            aria-controls="sidebar">
            <i class="fas fa-bars"></i> Menu
        </button>
    </div>

    <!-- Desktop Sidebar -->
    <div class="d-none d-md-block sidebar">
        <!-- User Profile Section -->
        <div class="user-profile-section">
            <img src="<?php echo htmlspecialchars(getProfilePicture($current_user['profile_picture'] ?? null)); ?>"
                alt="User Avatar" class="user-avatar">
            <div class="user-info">
                <div class="user-name"><?php echo htmlspecialchars($current_user['name'] ?? 'User'); ?></div>
                <div class="user-email"><?php echo htmlspecialchars($current_user['email'] ?? ''); ?></div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="nav-menu">
            <a class="nav-item active" href="dashboard.php">
                <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path>
                </svg>
                <span>Dashboard</span>
            </a>
            <a class="nav-item" href="tasks.php">
                <i class="fas fa-tasks"></i>
                <span>My Tasks</span>
            </a>
            <a class="nav-item" href="settings.php">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            <a class="nav-item" href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
        <div class="offcanvas-header">
            <div class="user-profile-mobile">
                <img src="<?php echo htmlspecialchars(getProfilePicture($current_user['profile_picture'] ?? null)); ?>"
                    alt="User Avatar" class="user-avatar">
                <div class="user-info">
                    <div class="user-name" id="sidebarLabel">
                        <?php echo htmlspecialchars($current_user['name'] ?? 'User'); ?></div>
                    <div class="user-email"><?php echo htmlspecialchars($current_user['email'] ?? ''); ?></div>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="nav-menu">
                <a class="nav-item active" href="dashboard.php">
                    <svg viewBox="0 0 24 24" class="nav-icon-svg">
                        <path fill="currentColor" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z">
                        </path>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a class="nav-item" href="tasks.php">
                    <i class="fas fa-tasks"></i>
                    <span>My Tasks</span>
                </a>
                <a class="nav-item" href="settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <a class="nav-item" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>