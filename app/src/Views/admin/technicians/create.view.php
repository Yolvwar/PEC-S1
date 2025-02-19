<!DOCTYPE html>
<html>
<head>
    <title>Create Technician</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Create Technician</h1>
        <form method="post" action="/admin/technicians/create">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="speciality">Speciality:</label>
            <input type="text" id="speciality" name="speciality">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>