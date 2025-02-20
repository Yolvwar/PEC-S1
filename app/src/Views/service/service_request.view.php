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
      <label for="vehicle_type">
        <i class="fas fa-motorcycle"></i>
        Type de véhicule
      </label>
      <select name="vehicle_type" id="vehicle_type" required>
        <option value="moto">Moto</option>
        <option value="scooter">Scooter</option>
      </select>
    </div>

    <div class="form-group">
      <label for="location_street">
        <i class="fas fa-road"></i>
        Rue
      </label>
      <input type="text" name="location_street" id="location_street" required>
    </div>

    <div class="form-group">
      <label for="location_address">
        <i class="fas fa-map-marker-alt"></i>
        Adresse complémentaire
      </label>
      <input type="text" name="location_address" id="location_address" required>
    </div>

    <div class="form-group">
      <label for="location_city">
        <i class="fas fa-city"></i>
        Ville
      </label>
      <input type="text" name="location_city" id="location_city" required>
    </div>

    <div class="form-group">
      <label for="location_postal_code">
        <i class="fas fa-envelope"></i>
        Code Postal
      </label>
      <input type="text" name="location_postal_code" id="location_postal_code" required>
    </div>

    <div class="form-group">
      <label for="time_slot_id">
        <i class="fas fa-clock"></i>
        Plage horaire disponible
      </label>
      <select name="time_slot_id" id="time_slot_id">
        <?php foreach ($timeSlots as $timeSlot): ?>
          <option value="<?php echo $timeSlot->id; ?>"><?php echo $timeSlot->time_range; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="description">
        <i class="fas fa-pencil-alt"></i>
        Description
      </label>
      <textarea name="description" id="description" placeholder="Décrivez votre demande..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary btn-block">
      <i class="fas fa-calculator"></i> Demander un devis
    </button>
  </form>
</div>