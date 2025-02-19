<!DOCTYPE html>
<html>
<head>
    <title>Manage Technicians</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Manage Technicians</h1>
        <a href="/admin/technicians/create" class="btn btn-primary">Add Technician</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Speciality</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($technicians as $technician): ?>
                    <tr>
                        <td><?= $technician->id ?></td>
                        <td><?= $technician->name ?></td>
                        <td><?= $technician->speciality ?></td>
                        <td><?= $technician->phone ?></td>
                        <td><?= $technician->email ?></td>
                        <td>
                            <a href="/admin/technicians/edit/<?= $technician->id ?>">Edit</a>
                            <form method="post" action="/admin/technicians/delete/<?= $technician->id ?>" style="display:inline;">
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