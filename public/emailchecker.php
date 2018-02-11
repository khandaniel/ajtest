<?php
/**
 * Created by PhpStorm.
 * User: Samir
 * Date: 10.02.2018
 * Time: 21:59
 */

require_once "../app/Controllers/TableController.php";
require_once "../app/Controllers/UserController.php";

if (isset($_GET['email']) && $users = UserController::emailCheck($_GET['email'])) { // Display alert with notification that user already exists
    ?>
    <div class="alert alert-danger">User with such email already exists!</div>
    <table class="table table-striped">
        <thead>
        <tr>
            <td>Name</td>
            <td>Email</td>
            <td>Region</td>
            <td>City</td>
            <td>Area</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) :
            // If there are many users with such email
            //it will iterate over it, though it seems stupid because email is UNIQUE in DB and
            // it wouldn't save data if email is already used in DB
            ?>
            <tr>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= TableController::getTerritoryName(null, $user['region']) ?></td>
                <td><?= TableController::getTerritoryName($user['city']) ?></td>
                <td><?= TableController::getTerritoryName($user['area']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php } ?>