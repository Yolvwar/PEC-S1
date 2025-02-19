<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit User</h1>
        <form method="post" action="/admin/users/edit/<?= $user->id ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $user->name ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= $user->username ?>">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $user->email ?>">
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>