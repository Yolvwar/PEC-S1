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
        <a href="/home" class="navbar__logo">Doc 2 Wheels</a>

        <button class="navbar__burger">
          <span></span>
          <span></span>
          <span></span>
        </button>

        <ul class="navbar__menu">
        <li class="navbar__item active">
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
            </ul>
          </li>
          <li class="navbar__item">
            <a href="/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
          </li>
        <?php else : ?>
          <li class="navbar__item">
            <a href="/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
          </li>
          <li class="navbar__item">
            <a href="/register"><i class="fas fa-user-plus"></i> Inscription</a>
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
        <td>
          <?php 
            $address_parts = [];
            
            if (!empty($request->location_street)) {
              $address_parts[] = htmlspecialchars($request->location_street);
            }
            
            if (!empty($request->location_address)) {
              $address_parts[] = htmlspecialchars($request->location_address);
            }
            
            if (!empty($request->location_city)) {
              $address_parts[] = htmlspecialchars($request->location_city);
            }
            
            if (!empty($request->location_postal_code)) {
              $address_parts[] = htmlspecialchars($request->location_postal_code);
            }
            
            echo !empty($address_parts) ? implode(', ', $address_parts) : 'Adresse non spécifiée';
          ?>
        </td>
        <td><?php echo $request->time_range; ?></td>
        <td><?php echo $request->description; ?></td>
        <td>
          <span class="technician">
            <?php echo $request->technician_name ? $request->technician_name : 'Non assigné'; ?>
          </span>
        </td>
        <td><?php echo $request->created_at; ?></td>
        <td>
                      <?php if ($request->completed): ?>
                        <?php if (!empty($evaluations[$request->id])): ?>
                          <div class="evaluation-display">
                            <div class="rating">
                              <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i <= $evaluations[$request->id][0]->rating ? 'active' : ''; ?>"></i>
                              <?php endfor; ?>
                            </div>
                            <p class="evaluation-comment"><?php echo $evaluations[$request->id][0]->comment; ?></p>
                          </div>
                        <?php else: ?>
                          <form method="post" action="/service_request" class="evaluation-form">
                            <input type="hidden" name="type" value="add_evaluation">
                            <input type="hidden" name="service_request_id" value="<?php echo $request->id; ?>">
                            
                            <div class="rating-input">
                              <label>Note :</label>
                              <select name="rating" required>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                              </select>
                            </div>

                            <textarea 
                              name="comment" 
                              placeholder="Votre commentaire..."
                              required
                            ></textarea>

                            <button type="submit" name="submit" class="btn btn-primary">
                              <i class="fas fa-paper-plane"></i> Évaluer
                            </button>
                          </form>
                        <?php endif; ?>
                      <?php else: ?>
                        <p class="pending-evaluation">
                          <i class="fas fa-clock"></i>
                          En attente de finalisation
                        </p>
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