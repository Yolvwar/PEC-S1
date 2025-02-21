<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../sass/dist/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  </head>
  <body>
    <nav class="navbar">
      <div class="navbar__container">
      <a href="/" class="navbar__logo">
        <img src="/sass/images/Doc2Wheels-logo-1.png" alt="Doc 2 Wheels Logo" style="height: 65px;">
      </a>

        <button class="navbar__burger">
          <span></span>
          <span></span>
          <span></span>
        </button>

        <ul class="navbar__menu">
                <li class="navbar__item">
                    <a href="/home"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <li class="navbar__item">
                    <a href="/service_request"><i class="fas fa-wrench"></i> Réparation</a>
                </li>
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <li class="navbar__item dropdown">
                        <a href="#" class="dropdown-toggle">
                            <i class="fas fa-user"></i> 
                            <?php echo explode(" ", $_SESSION['user_username'])[0]; ?>
                            <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/user/profile">
                                    <i class="fas fa-id-card"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="/user/devis">
                                    <i class="fas fa-file-invoice"></i> Mes devis
                                </a>
                            </li>
                            <li>
                                <a href="/user/params" class="active">
                                    <i class="fas fa-cog"></i> Paramètres
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="navbar__item">
                        <a href="/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
      </div>
    </nav>

    <div class="container" style="padding-top: 80px">
      <?php flash('user_profile') ?>
      <?php flash('evaluation') ?>

      <div class="profile-grid">
        <div class="profile-card">
          <div class="profile-header">
            <i class="fas fa-user-circle profile-icon"></i>
            <h2>Informations personnelles</h2>
          </div>
          <div class="profile-info">
            <div class="info-group">
              <i class="fas fa-user"></i>
              <div>
                <label>Nom</label>
                <p><?php echo $user->name; ?></p>
              </div>
            </div>
            <div class="info-group">
              <i class="fas fa-envelope"></i>
              <div>
                <label>Email</label>
                <p><?php echo $user->email; ?></p>
              </div>
            </div>
            <div class="info-group">
              <i class="fas fa-user-tag"></i>
              <div>
                <label>Nom d'utilisateur</label>
                <p><?php echo $user->username; ?></p>
              </div>
            </div>
          </div>
        </div>

        <div class="service-history-card">
          <div class="service-header">
            <i class="fas fa-history"></i>
            <h2>Historique des réparations</h2>
          </div>
          
          <div class="service-table-wrapper">
          <table class="service-table">
    <thead>
        <tr>
            <th>Service <i class="fas fa-wrench"></i></th>
            <th>Lieu <i class="fas fa-map-marker-alt"></i></th>
            <th>Horaire <i class="fas fa-clock"></i></th>
            <th>Description <i class="fas fa-comment"></i></th>
            <th>Technicien <i class="fas fa-user-cog"></i></th>
            <th>Date <i class="fas fa-calendar"></i></th>
            <th>Évaluation <i class="fas fa-star"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($serviceRequests as $request): ?>
            <tr>
                <td><?php echo $request->service_name; ?></td>
                <td><?php echo $request->location_street . ', ' . $request->location_city . ', ' . $request->location_postal_code; ?></td>
                <td><?php echo $request->time_range; ?></td>
                <td><?php echo $request->description; ?></td>
                <td><?php echo $request->technician_name ? $request->technician_name : 'Non assigné'; ?></td>
                <td><?php echo date('Y-m-d H:i:s', strtotime($request->created_at)); ?></td>
                <td>
                    <?php if ($request->completed): ?>
                        <?php if (!empty($evaluations[$request->id])): ?>
                            <div class="rating-display">
                                <div class="stars">
                                    <?php 
                                    $rating = $evaluations[$request->id][0]->rating;
                                    for($i = 1; $i <= 5; $i++): 
                                    ?>
                                        <i class="fas fa-star <?php echo $i <= $rating ? 'active' : ''; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="comment"><?php echo $evaluations[$request->id][0]->comment; ?></p>
                            </div>
                        <?php else: ?>
                            <form method="post" action="/service_request" class="inline-rating-form">
                                <input type="hidden" name="type" value="add_evaluation">
                                <input type="hidden" name="service_request_id" value="<?php echo $request->id; ?>">
                                
                                <div class="star-rating">
                                    <?php for($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="star<?php echo $i; ?>_<?php echo $request->id; ?>" 
                                               name="rating" value="<?php echo $i; ?>" required>
                                        <label for="star<?php echo $i; ?>_<?php echo $request->id; ?>">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    <?php endfor; ?>
                                </div>

                                <textarea name="comment" placeholder="Votre commentaire..." required></textarea>
                                
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="pending">
                            <i class="fas fa-clock"></i>
                            En attente de finalisation
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
          </div>
        </div>
      </div>
    </div>

    

    <script src="../../../src/js/navbar.js"></script>
  </body>
</html>