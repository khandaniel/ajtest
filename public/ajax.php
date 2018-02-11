<?php

require_once "../app/Controllers/TableController.php";


if (isset($_GET['theregion'])) { ?>
    <select data-placeholder="Choose your city/town" class="chosen-select" id="city" name="city" required onchange="proceedToArea(this.value)">
        <option value=""></option>
        <?php if (empty($cities)) {
            $cities = TableController::getPlaces('city', $_GET['theregion']); // Retrieving areas from DB according to the region's selection
        }
        foreach ($cities as $city): ?>
            <option value="<?= $city['ter_id'] ?>" <?php if (isset($_GET['city']) && $_GET['city'] == $city['ter_id']) {
                echo 'selected';
            } ?>><?= $city['ter_name'] ?></option>
        <?php endforeach; ?>
    </select>
<?php } ?>


<?php
if (isset($_GET['city'])) { ?>
    <select data-placeholder="Choose your area" class="chosen-select" id="area" name="area" required>
        <option value=""></option>
        <?php if (empty($areas)) {
            $areas = TableController::getPlaces('area', $_GET['region']); // Retrieving areas from DB according to regions field selection
        }
        foreach ($areas as $area): ?>
            <option value="<?= $area['ter_id'] ?>" <?php if (isset($_GET['area']) && $_GET['area'] == $area['ter_id']) {
                echo 'selected';
            } ?>><?= $area['ter_name'] ?></option>
        <?php endforeach; ?>
    </select>
<?php } ?>
