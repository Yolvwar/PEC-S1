<!DOCTYPE html>
<html>
<head>
    <title>Assign Technician</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Assign Technician to Service Request</h1>
        <form method="post" action="/admin/service_requests/assign_technician/<?= $service_request->id ?>">
            <label for="technician_id">Technician:</label>
            <select id="technician_id" name="technician_id">
                <?php foreach ($technicians as $technician): ?>
                    <option value="<?= $technician->id ?>"><?= $technician->name ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Assign</button>
        </form>
    </div>
</body>
</html>