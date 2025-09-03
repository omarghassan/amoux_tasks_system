
<!-- Sidebar -->
<div id="sidebar" class="sidebar d-flex flex-column justify-content-between">
  <div>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4><i class="bi bi-shield-check me-2"></i>MonitorSys</h4>
      <button class="btn btn-sm btn-light d-lg-none" id="sidebarClose">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="dashboard.php" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
      </li>
      <li class="nav-item">
        <a href="urls.php" class="nav-link"><i class="bi bi-link-45deg me-2"></i>URLs</a>
      </li>
      <li class="nav-item">
        <a href="rounds.php" class="nav-link"><i class="bi bi-clock-history me-2"></i>Rounds</a>
      </li>
      <li class="nav-item">
        <a href="alerts.php" class="nav-link"><i class="bi bi-exclamation-triangle me-2"></i>Alerts</a>
      </li>
    </ul>
  </div>

  <div class="mt-4">
    <a href="logout.php" class="btn btn-outline-danger w-100">
      <i class="bi bi-box-arrow-right me-2"></i>Logout
    </a>
  </div>
</div>

<!-- Overlay -->
<div id="sidebarOverlay"></div>

<!-- Sidebar Toggle (Mobile) -->
<button class="btn btn-dark d-lg-none" id="sidebarToggle">
  <i class="bi bi-list"></i>
</button>

<script>
  const sidebar = document.getElementById('sidebar');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebarClose = document.getElementById('sidebarClose');

  function openSidebar() {
    sidebar.classList.add('show');
    sidebarOverlay.classList.add('show');
    document.body.classList.add('sidebar-open');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('show');
    sidebarOverlay.classList.remove('show');
    document.body.classList.remove('sidebar-open');
    document.body.style.overflow = '';
  }

  sidebarToggle.addEventListener('click', openSidebar);
  sidebarOverlay.addEventListener('click', closeSidebar);
  if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
</script>
