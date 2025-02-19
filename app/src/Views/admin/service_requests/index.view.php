<!DOCTYPE html>
<html>
<head>
    <title>Manage Service Requests</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Manage Service Requests</h1>
        <a href="/admin/service_requests/create" class="btn btn-primary">Add Service Request</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Service</th>
                    <th>Location</th>
                    <th>Time Slot</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($service_requests as $request): ?>
                    <tr>
                        <td><?= $request->id ?></td>
                        <td><?= $request->user_name ?></td>
                        <td><?= $request->service_name ?></td>
                        <td><?= $request->location_name ?></td>
                        <td><?= $request->time_range ?></td>
                        <td><?= $request->description ?></td>
                        <td>
                            <a href="/admin/service_requests/edit/<?= $request->id ?>">Edit</a>
                            <form method="post" action="/admin/service_requests/delete/<?= $request->id ?>" style="display:inline;">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>