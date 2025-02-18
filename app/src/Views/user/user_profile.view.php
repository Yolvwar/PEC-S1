<?php
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<h1 class="header">Profil Utilisateur</h1>

<?php flash('user_profile') ?>

<div>
  <h2>Informations de l'utilisateur</h2>
  <p><strong>Nom :</strong> <?php echo $user->name; ?></p>
  <p><strong>Email :</strong> <?php echo $user->email; ?></p>
  <p><strong>Nom d'utilisateur :</strong> <?php echo $user->username; ?></p>
</div>

<div>
  <h2>Historique des demandes de réparations</h2>
  <table>
    <thead>
      <tr>
        <th>Type de service</th>
        <th>Lieu d'intervention</th>
        <th>Plage horaire</th>
        <th>Description</th>
        <th>Date de création</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($serviceRequests as $request): ?>
        <tr>
          <td><?php echo $request->service_name; ?></td>
          <td><?php echo $request->location_name . ' (' . $request->location_address . ')'; ?></td>
          <td><?php echo $request->time_range; ?></td>
          <td><?php echo $request->description; ?></td>
          <td><?php echo $request->created_at; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>