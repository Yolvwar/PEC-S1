<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Manage Users</h1>
        <a href="/admin/users/create" class="btn btn-primary">Add User</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <td>
                            <a href="/admin/users/edit/<?= $user->id ?>">Edit</a>
                            <form method="post" action="/admin/users/delete/<?= $user->id ?>" style="display:inline;">
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