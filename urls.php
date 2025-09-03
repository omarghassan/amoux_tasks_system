<?php
    require_once('auth.php');
    check_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Monitored URLs</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-light text-dark">
<?php
    include("sidebar.php");
?>
<div class="container py-5 main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold mb-0">Monitored URLs</h1>
        <p class="text-muted mb-0">Monitor global system endpoints with high visibility and control.</p>
    </div>
    <button class="btn btn-dark d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addUrlModal">
        <i class="bi bi-plus-lg me-2"></i> Add New URL
    </button>
    </div>

    <div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">URL</th>
            <th scope="col">Label</th>
            <!-- <th scope="col">Region</th>
            <th scope="col">Status</th> -->
            <th scope="col" class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody id="urls-body">
            <tr><td colspan="6" class="text-center py-4">Loading...</td></tr>
        </tbody>
        </table>
    </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addUrlModal" tabindex="-1" aria-labelledby="addUrlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow">
        <div class="modal-header bg-dark text-white">
        <h5 class="modal-title fw-semibold" id="addUrlModalLabel">Add New URL</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="addUrlForm" class="row g-3">
            <div class="col-md-6">
            <label class="form-label">Target URL *</label>
            <input type="url" id="add-url" class="form-control" required />
            </div>
            <div class="col-md-6">
            <label class="form-label">Label</label>
            <input type="text" id="add-label" class="form-control" />
            </div>
            <!-- <div class="col-md-6">
            <label class="form-label">Region Hint</label>
            <input type="text" id="add-region" class="form-control" />
            </div>
            <div class="col-md-6">
            <label class="form-label">Status</label>
            <select id="add-status" class="form-select">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            </div> -->
            <div class="col-12 text-end">
            <button type="submit" class="btn btn-dark px-4">Add URL</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUrlModal" tabindex="-1" aria-labelledby="editUrlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow">
        <div class="modal-header bg-dark text-white">
        <h5 class="modal-title fw-semibold" id="editUrlModalLabel">Edit Monitored URL</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="editUrlForm" class="row g-3">
            <input type="hidden" id="edit-id" />
            <div class="col-md-6">
            <label class="form-label">Target URL *</label>
            <input type="url" id="edit-url" class="form-control" required />
            </div>
            <div class="col-md-6">
            <label class="form-label">Label</label>
            <input type="text" id="edit-label" class="form-control" />
            </div>
            <!-- <div class="col-md-6">
            <label class="form-label">Region Hint</label>
            <input type="text" id="edit-region" class="form-control" />
            </div> -->
            <!-- <div class="col-md-6">
            <label class="form-label">Status</label>
            <select id="edit-status" class="form-select">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
            </div> -->
            <div class="col-12 text-end">
            <button type="submit" class="btn btn-dark px-4">Save Changes</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="assets/js/urls.js"></script>
</body>
</html>
