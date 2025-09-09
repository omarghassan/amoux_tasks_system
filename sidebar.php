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
        <button class="btn btn-dark m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
            <i class="fas fa-bars"></i> Menu
        </button>
    </div>

    <!-- Desktop Sidebar -->
    <div class="d-none d-md-block position-fixed sidebar">
        <div class="p-4 border-bottom border-secondary">
            <div class="d-flex align-items-center">
                <img src="https://avatarfiles.alphacoders.com/159/159787.png" 
                     alt="User Avatar" class="user-avatar rounded-circle me-3">
                <div>
                    <h6 class="text-white mb-0">Naruto</h6>
                    <small class="user-email">uzumaki@email.com</small>
                </div>
            </div>
        </div>
        
        <ul class="nav nav-pills flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link active" href="dashboard.php">
                    <i class="fas fa-th-large menu-icon"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tasks.php">
                    <i class="fas fa-tasks menu-icon"></i>
                    My Tasks
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settings.php">
                    <i class="fas fa-cog menu-icon"></i>
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt menu-icon"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
        <div class="offcanvas-header border-bottom border-secondary">
            <div class="d-flex align-items-center">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" 
                     alt="User Avatar" class="user-avatar rounded-circle me-3">
                <div>
                    <h6 class="text-white mb-0" id="sidebarLabel">amanuel</h6>
                    <small class="user-email">amanuel@gmail.com</small>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-th-large menu-icon"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tasks.php">
                        <i class="fas fa-tasks menu-icon"></i>
                        My Tasks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">
                        <i class="fas fa-cog menu-icon"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt menu-icon"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>