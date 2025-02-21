<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Demande - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../../sass/dist/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar__logo">
            <i class="fas fa-motorcycle"></i>
            <span>Doc 2 Wheels</span>
        </div>
        
        <nav class="admin-sidebar__nav">
            <!-- ... menu items ... -->
        </nav>
    </aside>

    <main class="admin-main">
        <header class="admin-header">
            <div class="breadcrumb">
                <a href="/admin/service_requests">
                    <i class="fas fa-clipboard-list"></i>
                    Demandes
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Modifier</span>
            </div>
            
            <div class="admin-header__profile">
                <!-- ... profile section ... -->
            </div>
        </header>

        <div class="admin-content">
            <div class="content-header">
                <h1>Modifier la Demande de Service</h1>
                <a href="/admin/service_requests" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>

            <div class="card">
                <div class="request-edit-header">
                    <div class="client-info">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user->name) ?>&background=random" 
                             alt="<?= htmlspecialchars($user->name ?? '') ?>">
                        <div>
                            <h2><?= htmlspecialchars($user->name ?? '') ?></h2>
                            <span class="email"><?= htmlspecialchars($user->email ?? '') ?></span>
                        </div>
                    </div>
                </div>

                <form method="post" action="/admin/service_requests/edit/<?= htmlspecialchars($service_request->id ?? '') ?>" class="admin-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="service_id">
                                <i class="fas fa-tools"></i>
                                Service
                            </label>
                            <select id="service_id" name="service_id" required class="form-control">
                                <?php foreach ($services as $service): ?>
                                    <option value="<?= htmlspecialchars($service->id ?? '') ?>" 
                                            <?= $service->id == $service_request->service_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($service->name ?? '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="time_slot_id">
                                <i class="fas fa-clock"></i>
                                Créneau horaire
                            </label>
                            <select id="time_slot_id" name="time_slot_id" required class="form-control">
                                <?php foreach ($timeSlots as $timeSlot): ?>
                                    <option value="<?= htmlspecialchars($timeSlot->id ?? '') ?>" 
                                            <?= $timeSlot->id == $service_request->time_slot_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($timeSlot->time_range ?? '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-map-marker-alt"></i> Adresse d'intervention</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="location_street">Rue</label>
                                <input type="text" id="location_street" name="location_street" 
                                       value="<?= htmlspecialchars($location->street ?? '') ?>" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="location_address">Complément d'adresse</label>
                                <input type="text" id="location_address" name="location_address" 
                                       value="<?= htmlspecialchars($location->address ?? '') ?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="location_city">Ville</label>
                                <input type="text" id="location_city" name="location_city" 
                                       value="<?= htmlspecialchars($location->city ?? '') ?>" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="location_postal_code">Code postal</label>
                                <input type="text" id="location_postal_code" name="location_postal_code" 
                                       value="<?= htmlspecialchars($location->postal_code ?? '') ?>" required class="form-control"
                                       pattern="[0-9]{5}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">
                            <i class="fas fa-comment-alt"></i>
                            Description
                        </label>
                        <textarea id="description" name="description" class="form-control" rows="4"><?= htmlspecialchars($service_request->description ?? '') ?></textarea>
                    </div>

                    <div class="technician-assignment-section">
                        <h3>
                            <i class="fas fa-user-cog"></i>
                            Assignation du technicien
                        </h3>
                        
                        <?php if ($service_request->technician_name): ?>
                            <div class="current-technician">
                                <div class="technician-badge">
                                    <i class="fas fa-user-check"></i>
                                    <span>Technicien actuel :</span>
                                    <strong><?= htmlspecialchars($service_request->technician_name ?? '') ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="/admin/service_requests/assign_technician/<?= htmlspecialchars($service_request->id ?? '') ?>" 
                              class="tech-assign-form">
                            <div class="select-wrapper">
                                <i class="fas fa-wrench select-icon"></i>
                                <select name="technician_id" class="form-control">
                                    <option value="">Choisir un nouveau technicien</option>
                                    <?php foreach ($technicians as $technician): ?>
                                        <option value="<?= htmlspecialchars($technician->id ?? '') ?>" 
                                                <?= $technician->id == $service_request->technician_id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($technician->name ?? '') ?>
                                            <?php if (!$technician->available): ?> 
                                                (Indisponible)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i>
                                Assigner le technicien
                            </button>
                        </form>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>