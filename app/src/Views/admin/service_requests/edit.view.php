<!DOCTYPE html>
<html>
<head>
    <title>Edit Service Request</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit Service Request</h1>
        <form method="post" action="/admin/service_requests/edit/<?= $service_request->id ?>">
            <label for="user_name">User:</label>
            <input type="text" id="user_name" name="user_name" value="<?= $user->name ?>" readonly>
            <input type="hidden" id="user_id" name="user_id" value="<?= $service_request->user_id ?>">

            <label for="service_id">Service:</label>
            <select id="service_id" name="service_id">
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service->id ?>" <?= $service->id == $service_request->service_id ? 'selected' : '' ?>>
                        <?= $service->name ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="location_id">Location:</label>
            <select id="location_id" name="location_id">
                <?php foreach ($locations as $location): ?>
                    <option value="<?= $location->id ?>" <?= $location->id == $service_request->location_id ? 'selected' : '' ?>>
                        <?= $location->name ?> (<?= $location->address ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="time_slot_id">Time Slot:</label>
            <select id="time_slot_id" name="time_slot_id">
                <?php foreach ($timeSlots as $timeSlot): ?>
                    <option value="<?= $timeSlot->id ?>" <?= $timeSlot->id == $service_request->time_slot_id ? 'selected' : '' ?>>
                        <?= $timeSlot->time_range ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?= $service_request->description ?></textarea>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>