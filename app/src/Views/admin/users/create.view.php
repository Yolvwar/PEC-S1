<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Create User</h1>
        <form method="post" action="/admin/users/create">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>