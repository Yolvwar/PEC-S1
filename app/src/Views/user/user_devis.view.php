<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>

<h1 class="header">Mes Devis</h1>

<?php flash('user_devis') ?>

<div>
  <h2>Liste de mes devis</h2>
  <table>
    <thead>
      <tr>
        <th>Service</th>
        <th>Lieu</th>
        <th>Description</th>
        <th>Coût estimé</th>
        <th>Date de création</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($devis as $devis_item): ?>
        <tr>
          <td><?php echo $devis_item->service_name; ?></td>
          <td><?php echo $devis_item->location_address; ?></td>
          <td><?php echo $devis_item->description; ?></td>
          <td><?php echo $devis_item->estimated_cost; ?> €</td>
          <td><?php echo $devis_item->created_at; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>