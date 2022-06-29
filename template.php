<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDD</title>
    <!-- Bootstrap CSS (jsDelivr CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap Bundle JS (jsDelivr CDN) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="header">
                <a href="index.php" class="btn btn-primary">Билеты ПДД 2022 для категории ABM</a>
            </div>
        </div>
        <div class="row content">
            <div class="row">  
                <div class=" col-lg-3">
                    <a class="btn btn-success switch" href="test.php" name="test">Пройти тест</a>
                </div>
                <div class="col-lg-2">
                    <a class="btn btn-success switch" href="ticket.php"  name="ticket">Билеты</a>
                </div>
                <div class=" col-lg-2">
                    <a  class="btn btn-success switch" href="theme.php" name="theme">По темам</a>
                </div>
                <div class=" col-lg-2">
                    <a class="btn btn-success switch" href="answer.php" name="answer">Ответы</a>
                </div>
                <div class="col-lg-3">
                    <a  class="btn btn-success switch" href="settings.php"  name="settings">Настройки</a>
                </div>
            </div>
        </div>
<?php
include_once("bdconnection.php");
$db = new DataBase();
?>