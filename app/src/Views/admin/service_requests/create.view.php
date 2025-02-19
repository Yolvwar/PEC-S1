<!DOCTYPE html>
<html>
<head>
    <title>Create Service Request</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Create Service Request</h1>
        <form method="post" action="/admin/service_requests/create">
            <label for="user_id">User ID:</label>
            <input type="text" id="user_id" name="user_id">
            <label for="service_id">Service ID:</label>
            <input type="text" id="service_id" name="service_id">
            <label for="location_id">Location ID:</label>
            <input type="text" id="location_id" name="location_id">
            <label for="time_slot_id">Time Slot ID:</label>
            <input type="text" id="time_slot_id" name="time_slot_id">
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            <button type="submit">Create</button>
        </form>
    </div>
</body>
</html>