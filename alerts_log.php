<?php
require_once('auth.php');
check_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Alert Logs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body>
  <?php include("sidebar.php"); ?>

  <div class="main-content">
    <h2 class="mb-4"><i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>Alert Logs</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-light">
          <tr>
            <th>Round ID</th>
            <th>URL</th>
            <th>HTTP Code</th>
            <th>Error</th>
            <th>Logged At</th>
          </tr>
        </thead>
        <tbody id="alerts-body">
          <tr><td colspan="5" class="text-center py-4">Loading...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <script type="module" src="assets/js/alerts.js">
    
  </script>
</body>
</html>
