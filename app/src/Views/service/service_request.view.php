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
  <label for="location_street">Rue :</label>
  <input type="text" name="location_street" id="location_street" required>

  <label for="location_address">Adresse :</label>
  <input type="text" name="location_address" id="location_address" required>

  <label for="location_city">Ville :</label>
  <input type="text" name="location_city" id="location_city" required>

  <label for="location_postal_code">Code Postal :</label>
  <input type="text" name="location_postal_code" id="location_postal_code" required>

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