<body>
    <div class="admin-container">
        <h1>Service Request Dashboard</h1>
        <a href="/admin/service_requests/create" class="btn btn-primary">Create New Service Request</a>
        <table>
            <thead>
                <tr>
                    <th>User Information</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($service_requests as $request): ?>
                    <tr>
                        <td>
                            <p><strong>Name:</strong> <?= $request->user_name ?></p>
                            <p><strong>Email:</strong> <?= $request->user_email ?></p>
                            <p><strong>Service:</strong> <?= $request->service_name ?></p>
                            <p><strong>Location:</strong> <?= $request->location_street . ', ' . $request->location_address . ', ' . $request->location_city . ', ' . $request->location_postal_code ?></p>
                            <p><strong>Technician assigned:</strong> <?= $request->technician_name ?></p>
                            <p><strong>Time Slot:</strong> <?= $request->time_range ?></p>
                            <p><strong>Description:</strong> <?= $request->description ?></p>

                            <div>
                                <p><strong>Completed:</strong> <?= $request->completed ? 'Yes' : 'No' ?></p>
                            </div>
                        </td>
                        <td>
                            <form method="post" action="/admin/service_requests/assign_technician/<?= $request->id ?>" style="display:inline;">
                                <select name="technician_id">
                                    <?php foreach ($technicians as $technician): ?>
                                        <option value="<?= $technician->id ?>"><?= $technician->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit">Assign Technician</button>
                            </form>
                            <form method="post" action="/admin/service_requests/complete/<?= $request->id ?>" style="display:inline;">
                                <button type="submit">Complete</button>
                            </form>
                            <form method="post" action="/admin/service_requests/delete/<?= $request->id ?>" style="display:inline;">
                                <button type="submit">Delete</button>
                            </form>
                            <a href="/admin/service_requests/edit/<?= $request->id ?>" class="btn btn-secondary">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.admin-container {
    width: 80%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px 0;
    text-decoration: none;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-secondary {
    background-color: #6c757d;
}

.btn-primary {
    background-color: #007bff;
}

form {
    display: inline;
}

select {
    padding: 5px;
    margin-right: 10px;
}
    </style>
</body>