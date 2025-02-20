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
            <label for="user_id">User:</label>
            <select id="user_id" name="user_id">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->id ?>"><?= $user->name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="service_id">Service:</label>
            <select id="service_id" name="service_id">
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service->id ?>"><?= $service->name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="location_id">Location:</label>
            <select id="location_id" name="location_id" onchange="toggleCustomAddress(this)">
                <?php foreach ($locations as $location): ?>
                    <option value="<?= $location->id ?>"><?= $location->name ?> (<?= $location->address ?>)</option>
                <?php endforeach; ?>
                <option value="custom">Custom Address</option>
            </select>

            <div id="custom_address" style="display:none;">
                <label for="custom_address_input">Custom Address:</label>
                <input type="text" id="custom_address_input" name="custom_address">
            </div>

            <label for="time_slot_id">Time Slot:</label>
            <select id="time_slot_id" name="time_slot_id">
                <?php foreach ($timeSlots as $timeSlot): ?>
                    <option value="<?= $timeSlot->id ?>"><?= $timeSlot->time_range ?></option>
                <?php endforeach; ?>
            </select>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            <button type="submit">Create</button>
        </form>
    </div>

    <script>
        function toggleCustomAddress(select) {
            var customAddressDiv = document.getElementById('custom_address');
            if (select.value === 'custom') {
                customAddressDiv.style.display = 'block';
            } else {
                customAddressDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>