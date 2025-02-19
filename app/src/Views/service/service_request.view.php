<?php
include_once __DIR__ . '/../../Helpers/session_helper.php';
?>

<h1 class="header">Demande de Réparation</h1>

<?php flash('service_request') ?>
<?php flash('evaluation')  ?>

<form method="post" action="/service_request">
  <input type="hidden" name="type" value="create_service_request">

  <label for="service_id">Type de service :</label>
  <select name="service_id" id="service_id">
    <?php foreach ($serviceTypes as $serviceType): ?>
      <option value="<?php echo $serviceType->id; ?>"><?php echo $serviceType->name; ?></option>
    <?php endforeach; ?>
  </select>

  <label for="location_id">Lieu d'intervention :</label>
  <select name="location_id" id="location_id">
    <?php foreach ($locations as $location): ?>
      <option value="<?php echo $location->id; ?>"><?php echo $location->name . ' (' . $location->address . ')'; ?></option>
    <?php endforeach; ?>
  </select>

  <label for="time_slot_id">Plage horaire disponible :</label>
  <select name="time_slot_id" id="time_slot_id">
    <?php foreach ($timeSlots as $timeSlot): ?>
      <option value="<?php echo $timeSlot->id; ?>"><?php echo $timeSlot->time_range; ?></option>
    <?php endforeach; ?>
  </select>

  <label for="description">Description :</label>
  <textarea name="description" id="description" placeholder="Décrivez votre demande..."></textarea>

  <button type="submit" name="submit">Envoyer la demande</button>
</form>