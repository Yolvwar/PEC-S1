<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

            <div class="form-section">
                <h3><i class="fas fa-map-marker-alt"></i> Adresse d'intervention</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="location_street">Rue</label>
                        <input type="text" id="location_street" name="location_street" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="location_address">Complément d'adresse</label>
                        <input type="text" id="location_address" name="location_address" class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="location_city">Ville</label>
                        <input type="text" id="location_city" name="location_city" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="location_postal_code">Code postal</label>
                        <input type="text" id="location_postal_code" name="location_postal_code" 
                               required class="form-control" pattern="[0-9]{5}">
                    </div>
                </div>
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
</body>
</html>