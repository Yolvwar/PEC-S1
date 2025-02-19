<!DOCTYPE html>
<html>
<head>
    <title>Manage Services</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Manage Services</h1>
        <a href="/admin/services/create">Create New Service</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= $service->name ?></td>
                        <td><?= $service->description ?></td>
                        <td>
                            <a href="/admin/services/edit/<?= $service->id ?>">Edit</a>
                            <form method="post" action="/admin/services/delete/<?= $service->id ?>" style="display:inline;">
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