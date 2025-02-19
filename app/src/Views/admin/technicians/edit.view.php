<!DOCTYPE html>
<html>
<head>
    <title>Edit Technician</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit Technician</h1>
        <form method="post" action="/admin/technicians/edit/<?= $technician->id ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $technician->name ?>">
            <label for="speciality">Speciality:</label>
            <input type="text" id="speciality" name="speciality" value="<?= $technician->speciality ?>">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?= $technician->phone ?>">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $technician->email ?>">
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>