<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une demande de service</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/path/to/your/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Créer une demande de service</h1>
        <form method="post" action="/admin/service_requests/create" class="admin-form">
            <div class="form-group">
                <label for="user_id">Utilisateur</label>
                <select id="user_id" name="user_id" required class="form-control">
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user->id) ?>"><?= htmlspecialchars($user->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="service_id">Service</label>
                <select id="service_id" name="service_id" required class="form-control">
                    <?php foreach ($services as $service): ?>
                        <option value="<?= htmlspecialchars($service->id) ?>"><?= htmlspecialchars($service->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

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
                    <input type="text" id="location_postal_code" name="location_postal_code" required class="form-control" pattern="[0-9]{5}">
                </div>
            </div>

            <div class="form-group">
                <label for="time_slot_id">Créneau horaire</label>
                <select id="time_slot_id" name="time_slot_id" required class="form-control">
                    <?php foreach ($timeSlots as $timeSlot): ?>
                        <option value="<?= htmlspecialchars($timeSlot->id) ?>"><?= htmlspecialchars($timeSlot->time_range) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="vehicle_type">Type de véhicule</label>
                <input type="text" id="vehicle_type" name="vehicle_type" required class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Créer la demande</button>
        </form>
    </div>
</body>
</html>