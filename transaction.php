<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 20.06.2018
 * Time: 17:34
 */

require( 'funcs/markup.php' );
require('funcs/db.php');

$currentDate = getdate();

$mysqli = new mysqli('localhost', 'root', 'Gremlin77', 'myfinances');

if ($myslqi -> connect_errno) {
    echo '<h3>Ошибка подключения к базе данных.</h3>';
    exit();
}

$accounts = getAccounts();

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
    <title>Транзакция - Управление личными финансами</title>
</head>
<body>

<?php printHeader( $page ); ?>

<main class="container" role="main">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mt-5">Перевод со счёта на счёт</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <form method="post" action="addedTransaction.php">
                <div class="form-group">
                    <label for="inputDate">Дата</label>
                    <input type="date" class="form-control" id="inputDate" name="inputDate"
                           value="<?php echo date( "Y-m-d" ); ?>">
                </div>
                <div class="form-group">
                    <label for="inputSum">Сумма</label>
                    <input type="number" class="form-control" name="inputSum" id="inputSum" step=".01">
                </div>
                <div class="form-group">
                    <label for="fromAccount">С какого счёта</label>
                    <select class="form-control" name="fromAccount" id="fromAccount">
                        <?php
                        foreach ($accounts as $account) {
                            echo '<option value="' . $account['id'] . '">' . $account['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="toAccount">На какой счёт</label>
                    <select class="form-control" name="toAccount" id="toAccount">
                        <?php
                        foreach ($accounts as $account) {
                            echo '<option value="' . $account['id'] . '">' . $account['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Комментарий</label>
                    <input type="text" class="form-control" name="inputDescription" id="inputDescription">
                </div>
                <button class="btn btn-primary">Перевести</button>
            </form>
        </div>
    </div>
</main>

<?php printFooter(); ?>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
