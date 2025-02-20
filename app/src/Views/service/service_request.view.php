<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Demande de réparation - Doc 2 Wheels</title>
    <link rel="stylesheet" href="../../../sass/dist/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  </head>
  <body>
    <nav class="navbar">
      <div class="navbar__container">
        <a href="/" class="navbar__logo">Doc 2 Wheels</a>

        <button class="navbar__burger">
          <span></span>
          <span></span>
          <span></span>
        </button>

        <ul class="navbar__menu">
          <li class="navbar__item">
            <a href="/home"><i class="fas fa-home"></i> Accueil</a>
          </li>
          <li class="navbar__item active">
            <a href="/service_request"><i class="fas fa-wrench"></i> Réparation</a>
          </li>
          <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="navbar__item">
              <a href="/user/profile">
                <i class="fas fa-user"></i> 
                <?php echo explode(" ", $_SESSION['user_username'])[0]; ?>
              </a>
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
      <?php flash('service_request') ?>
      <?php flash('evaluation') ?>

      <form class="repair-form" method="post" action="/service_request">
        <input type="hidden" name="type" value="create_service_request">
        
        <div class="auth-header">
          <h2>Demande de réparation</h2>
          <p>Choisissez le type de service dont vous avez besoin</p>
        </div>

        <div class="service-options">
          <?php foreach ($serviceTypes as $serviceType): ?>
            <div class="service-card">
              <i class="fas fa-tools"></i>
              <h3><?php echo $serviceType->name; ?></h3>
              <input type="radio" name="service_id" value="<?php echo $serviceType->id; ?>" required />
            </div>
          <?php endforeach; ?>
        </div>

        <div class="form-group">
          <label for="location_id">
            <i class="fas fa-map-marker-alt"></i>
            Lieu d'intervention
          </label>
          <select name="location_id" id="location_id" required>
            <?php foreach ($locations as $location): ?>
              <option value="<?php echo $location->id; ?>">
                <?php echo $location->name . ' (' . $location->address . ')'; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="time_slot_id">
            <i class="fas fa-clock"></i>
            Plage horaire disponible
          </label>
          <select name="time_slot_id" id="time_slot_id" required>
            <?php foreach ($timeSlots as $timeSlot): ?>
              <option value="<?php echo $timeSlot->id; ?>">
                <?php echo $timeSlot->time_range; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="description">
            <i class="fas fa-comment"></i>
            Description
          </label>
          <textarea 
            name="description" 
            id="description" 
            placeholder="Décrivez votre demande..."
            required
          ></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-primary btn-block">
          <i class="fas fa-paper-plane"></i> Envoyer la demande
        </button>
      </form>
    </div>

    <script src="../../../src/js/navbar.js"></script>
  </body>
</html>