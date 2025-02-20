<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Techniciens - Doc 2 Wheels</title>
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
                <li class="active">
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
                <li>
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
                <input type="text" placeholder="Rechercher un technicien...">
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

        <!-- Technicians Content -->
        <div class="admin-content">
            <div class="content-header">
                <h1>Gestion des Techniciens</h1>
                <a href="/admin/technicians/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un technicien
                </a>
            </div>

            <div class="card">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Technicien</th>
                                <th>Spécialité</th>
                                <th>Contact</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($technicians as $technician): ?>
                                <tr>
                                    <td><?= $technician->id ?></td>
                                    <td>
                                        <div class="technician-info">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($technician->name) ?>&background=random" 
                                                 alt="<?= $technician->name ?>">
                                            <div>
                                                <span class="name"><?= $technician->name ?></span>
                                                <span class="email"><?= $technician->email ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="specialty-badge">
                                            <?php 
                                            $icon = match($technician->speciality) {
                                                'Mécanique' => 'fa-wrench',
                                                'Électrique' => 'fa-bolt',
                                                'Carrosserie' => 'fa-car',
                                                default => 'fa-tools'
                                            };
                                            ?>
                                            <i class="fas <?= $icon ?>"></i>
                                            <?= $technician->speciality ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <div><i class="fas fa-phone"></i> <?= $technician->phone ?></div>
                                            <div><i class="fas fa-envelope"></i> <?= $technician->email ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge <?= strtolower($technician->status ?? 'available') ?>">
                                            <i class="fas fa-circle"></i>
                                            <?= $technician->status ?? 'Disponible' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="/admin/technicians/edit/<?= $technician->id ?>" 
                                               class="btn-icon" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="post" 
                                                  action="/admin/technicians/delete/<?= $technician->id ?>" 
                                                  class="delete-form" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce technicien ?');">
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