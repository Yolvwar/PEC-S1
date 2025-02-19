<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <nav class="admin-nav">
            <h1>Admin Dashboard</h1>
            <ul>
                <li><a href="/admin/users">Manage Users</a></li>
                <li><a href="/admin/technicians">Manage Technicians</a></li>
                <li><a href="/admin/services">Manage Service</a></li>
                <li><a href="/admin/service_requests">Manage Service Requests</a></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
        
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= count($users) ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Technicians</h3>
                <p><?= count($technicians) ?></p>
            </div>
        </div>
    </div>
</body>
</html>