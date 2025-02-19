<!DOCTYPE html>
<html>
<head>
    <title>Create Service</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Create Service</h1>
        <form method="post" action="/admin/services/create">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>