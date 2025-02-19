<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>

<h1 class="header">Gestion des Commandes</h1>

<?php flash('admin') ?>

<table>
  <thead>
    <tr>
      <th>Type de service</th>
      <th>Lieu d'intervention</th>
      <th>Plage horaire</th>
      <th>Description</th>
      <th>Technicien</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($services as $request): ?>
      <tr>
        <td><?php echo $request->service_name; ?></td>
        <td><?php echo $request->location_name . ' (' . $request->location_address . ')'; ?></td>
        <td>
          <?php
          $timeSlot = array_filter($timeSlots, function($slot) use ($request) {
            return $slot->id == $request->time_slot_id;
          });
          echo $timeSlot ? reset($timeSlot)->time_range : 'N/A';
          ?>
        </td>
        <td><?php echo $request->description; ?></td>
        <td><?php echo isset($request->technician_name) ? $request->technician_name : 'Non assigné'; ?></td>
        <td>
          <form method="post" action="/technician/accept">
            <input type="hidden" name="accept_service_request" value="<?php echo $request->id; ?>">
            <select name="technician_id">
              <?php foreach ($technicians as $technician): ?>
                <option value="<?php echo $technician->id; ?>"><?php echo $technician->name; ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit">Assigner</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>