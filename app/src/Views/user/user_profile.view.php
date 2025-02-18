<?php
include_once __DIR__ . '/../../helpers/session_helper.php';
?>

<h1 class="header">Profil Utilisateur</h1>

<?php flash('user_profile') ?>
<?php flash('evaluation') ?>

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
        <th>Technicien</th>
        <th>Date de création</th>
        <th>Évaluation</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($serviceRequests as $request): ?>
        <tr>
          <td><?php echo $request->service_name; ?></td>
          <td><?php echo $request->location_name . ' (' . $request->location_address . ')'; ?></td>
          <td><?php echo $request->time_range; ?></td>
          <td><?php echo $request->description; ?></td>
          <td><?php echo $request->technician_name ? $request->technician_name : 'Non assigné'; ?></td>
          <td><?php echo $request->created_at; ?></td>
          <td>
            <?php if ($request->completed): ?>
              <?php if (!empty($evaluations[$request->id])): ?>
                <p><strong>Note :</strong> <?php echo $evaluations[$request->id][0]->rating; ?></p>
                <p><strong>Commentaire :</strong> <?php echo $evaluations[$request->id][0]->comment; ?></p>
              <?php else: ?>
                <form method="post" action="/service_request">
                  <input type="hidden" name="type" value="add_evaluation">
                  <input type="hidden" name="service_request_id" value="<?php echo $request->id; ?>">
                  <label for="rating">Note :</label>
                  <select name="rating" id="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                  <label for="comment">Commentaire :</label>
                  <textarea name="comment" id="comment" placeholder="Laissez un commentaire..."></textarea>
                  <button type="submit" name="submit">Envoyer l'évaluation</button>
                </form>
              <?php endif; ?>
            <?php else: ?>
              <p>Évaluation non disponible pour une demande de service non terminée.</p>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>