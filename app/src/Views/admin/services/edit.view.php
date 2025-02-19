<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit Service</h1>
        <form method="post" action="/admin/services/edit/<?= $service->id ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $service->name ?>" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= $service->description ?></textarea>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>