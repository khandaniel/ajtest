<?php
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['theregion']) && isset($_POST['city']) && isset($_POST['area'])) {
//    $success = (UserController::addUser($_POST)) ? true : false; // Creating marker to return alert-success
    UserController::addUser($_POST);
    header('Location: /?success');
}
$success = (isset($_GET['success'])) ? true : false;
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/chosen/chosen.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Тестовое задание на должность PHP junior Developer, Кхан Даниил</title>
    <style>
        .form {
            min-height: 100vh;
            padding-top: 50vh;
        }
    </style>
</head>
<body>
<div class="container text-center form">
    <form method="post" id="form" onsubmit="return checkForm();" action="/">
        <input type="text" name="name" id="name" required value="<?php if (isset($_POST['name'])) {
            echo $_POST['name'];
        } ?>" placeholder="ФИО"/>
        <input type="email" onchange="checkEmail(this.value)" onkeyup="checkEmail(this.value)" name="email" id="email"
               required
               value="<?php if (isset($_POST['email'])) {
                   echo $_POST['email'];
               } ?>" placeholder="EMAIL"/>
        <select data-placeholder="Выберите область..." id="region" class="chosen-select" name="theregion" required
                onchange="proceedToCity(this.value)">
            <option value=""></option>
            <?php
            if (empty($regions)) {
                $regions = TableController::getPlaces('region');
            }
            foreach ($regions as $region):
                ?>
                <option value="<?= $region['reg_id'] ?>" <?php if (isset($_POST['theregion']) && $_POST['theregion'] == $region['reg_id']) {
                    echo 'selected'; // Only needed when XMLHTTPRequest doesn't work so that after page being reloaded selected item would be still selected
                } ?>><?= $region['ter_name'] ?></option>
            <?php
            endforeach;
            ?>
        </select>
        <span id="citySelect"></span>
        <span id="areaSelect"></span>


        <input type="submit" value="Отправить">
    </form>
    <div class="container" style="padding-top: 20px;">
        <div id="warningName"></div>
        <div id="warningEmail"></div>
        <div id="warningAddress"></div>
        <div id="response"></div>
        <?php if ($success) { ?>
            <div class="alert alert-success">
                Ваши данные успешно отправлены!
            </div>
        <?php } ?>

    </div>
</div>

<script src="/assets/chosen/chosen.jquery.js"></script>
<script>
    function checkForm() {
        // define elements with error messages
        var warningNameField = document.getElementById("warningName");
        var warningEmailField = document.getElementById("warningEmail");
        var warningAddressField = document.getElementById("warningAddress");
        var hasErrors = 0;
            // define RegExp's
        var nameCheck = new RegExp('[a-zA-Z]{2}[a-zA-Z]*');
        var emailCheck = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

        // and simply elements to be checked
        var region = document.getElementById("region_chosen");
        var city = document.getElementById("city_chosen");
        var area = document.getElementById("area_chosen");

        // define fields to check
        var nameValue = document.getElementById("name").value;
        var emailValue = document.getElementById("email").value;

        // start check up
        if (!nameCheck.test(nameValue)) {
            warningNameField.innerHTML = "<div class='alert alert-warning'>Что-то пошло не так! Проверьте поле с именем.</div>";
            hasErrors = 1;
        } else {
            warningNameField.innerHTML = "";
        }
        if (!emailCheck.test(emailValue)) {
            warningEmailField.innerHTML = "<div class='alert alert-warning'>Что-то пошло не так! Проверьте поле с почтой.</div>";
            hasErrors = 1;
        } else {
            warningEmailField.innerHTML = "";
        }
        if ( region.innerHTML.search("selected") == -1 || city.innerHTML.search("selected") == -1 || area.innerHTML.search("selected") == -1) {
            // ^ Can't find a way to check if element is selected. This one works. Though it is ugly.
            warningAddressField.innerHTML = "<div class='alert alert-warning'>Что-то пошло не так! Заполните все поля с адресом.</div>";
            hasErrors = 1;
        } else {
            warningAddressField.value = "";
        }
        if ( hasErrors !== 1) {
            return true;
        } else {
            return false;
        }
            }

    function ajaxGetResponse(str, elId, body, filename = "ajax.php") {
        if (str == '') {
            document.getElementById(elId).innerHTML = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById(elId).innerHTML = this.responseText;
                    $(".chosen-select").chosen();
                }
            }
            xmlhttp.open("GET", "/" + filename + "?" + body, true);
            xmlhttp.send();
        }
    }

    function checkEmail(str) {
        var body = 'email=' + encodeURIComponent(str);
        ajaxGetResponse(str, "response", body, "emailchecker.php");
    }

    function proceedToCity(str) {
        var body = 'name=' + encodeURIComponent(document.getElementById("name").value) +
            '&email=' + encodeURIComponent(document.getElementById("email").value) +
            '&theregion=' + encodeURIComponent(document.getElementById("region").value);
        ajaxGetResponse(str, "citySelect", body);
    }

    function proceedToArea(str) {
        var body = 'region=' + encodeURIComponent(document.getElementById("region").value) + '&city=' + encodeURIComponent(str);
        ajaxGetResponse(str, "areaSelect", body);
    }


    $(".chosen-select").chosen();
</script>
</body>
</html>