<?php
require( "funcs/markup.php" );
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/site.css">
    <title>Управление личными финансами - версия для разработки</title>
</head>
<body>
<?php printHeader( "index" ); ?>

<main role="main" class="container">
    <div class="row mt-5">
        <div class="col-md-2">
            <a href="addOperation.php?type=expense" class="btn btn-primary">Добавить расход</a>
        </div>
        <div class="col-md-2">
            <a href="addOperation.php?type=income" class="btn btn-primary">Добавить приход</a>
        </div>
        <div class="col-md-2">
            <a href="transaction.php" class="btn btn-primary">Перевод между счетами</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-2">
            <a href="addAcount.php" class="btn btn-primary">Добавить счёт</a>
        </div>
        <div class="col-md-2">
            <a href="accounts.php" class="btn btn-primary">Список счетов</a>
        </div>
    </div>
</main>

<?php printFooter(); ?>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>