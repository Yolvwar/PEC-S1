<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Service - Doc 2 Wheels</title>
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
            <ul>
                <li>
                    <a href="/admin">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/users">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/technicians">
                        <i class="fas fa-wrench"></i>
                        <span>Techniciens</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/services">
                        <i class="fas fa-cogs"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li class="active">
                    <a href="/admin/service_requests">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Demandes</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Bar -->
        <header class="admin-header">
            <div class="admin-header__search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher une demande...">
            </div>
            
            <div class="admin-header__profile">
                <div class="profile">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" alt="Profile">
                    <span>Admin</span>
                    <a href="/logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </div>
        </header>

        <!-- Service Requests Content -->
        <div class="admin-content">
            <div class="content-header">
                <h1>Demandes de Service</h1>
                <a href="/admin/service_requests/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle Demande
                </a>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Technicien</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($service_requests as $request): ?>
                                <tr>
                                    <td>
                                        <div class="client-info">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($request->user_name) ?>&background=random" 
                                                 alt="<?= $request->user_name ?>">
                                            <div>
                                                <span class="name"><?= $request->user_name ?></span>
                                                <span class="email"><?= $request->user_email ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="service-info">
                                            <span class="service-name"><?= $request->service_name ?></span>
                                            <div class="location">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <div class="location-details">
                                                    <span class="street"><?= $request->location_street ?></span>
                                                    <?php if ($request->location_address): ?>
                                                        <span class="address"><?= $request->location_address ?></span>
                                                    <?php endif; ?>
                                                    <span class="city-code"><?= $request->location_city ?>, <?= $request->location_postal_code ?></span>
                                                </div>
                                            </div>
                                            <div class="time-slot">
                                                <i class="fas fa-clock"></i>
                                                <?= $request->time_range ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="technician-assignment">
                                            <?php if ($request->technician_name): ?>
                                                <div class="assigned-tech">
                                                    <i class="fas fa-user-check"></i>
                                                    <span class="tech-name"><?= $request->technician_name ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <form method="post" action="/admin/service_requests/assign_technician/<?= $request->id ?>" 
                                                  class="tech-assign-form">
                                                <div class="select-wrapper">
                                                    <i class="fas fa-wrench select-icon"></i>
                                                    <select name="technician_id" class="form-control">
                                                        <option value="">Choisir un technicien</option>
                                                        <?php foreach ($technicians as $technician): ?>
                                                            <option value="<?= $technician->id ?>" 
                                                                    <?= $technician->id == $request->technician_id ? 'selected' : '' ?>>
                                                                <?= $technician->name ?>
                                                                <?php if (!$technician->available): ?> 
                                                                    (Indisponible)
                                                                <?php endif; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                    <span class="status-badge <?= $request->completed ? 'completed' : ($request->technician_id ? 'pending' : 'waiting') ?>">
                                        <i class="fas <?= $request->completed ? 'fa-check-circle' : ($request->technician_id ? 'fa-clock' : 'fa-hourglass-half') ?>"></i>
                                        <?= $request->completed ? 'Terminé' : ($request->technician_id ? 'En cours' : 'En attente') ?>
                                    </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <?php if (!$request->completed): ?>
                                                <form method="post" action="/admin/service_requests/complete/<?= $request->id ?>" 
                                                      class="action-form">
                                                    <button type="submit" class="btn-icon success" title="Marquer comme terminé">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <a href="/admin/service_requests/edit/<?= $request->id ?>" 
                                               class="btn-icon" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="post" action="/admin/service_requests/delete/<?= $request->id ?>" 
                                                  class="action-form"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?');">
                                                <button type="submit" class="btn-icon delete" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>