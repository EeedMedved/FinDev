<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 28.06.2018
 * Time: 11:26
 */

require ('funcs/markup.php');
require('funcs/db.php');

$transactions = getAllTransactions();

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
	<title>Список переводов между счетами - Управление личными финансами</title>
</head>
<body>

<?php printHeader($page); ?>

<main class="container" role="main">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Дата</th>
            <th scope="col">Сумма</th>
            <th scope="col">Счёт списания</th>
            <th scope="col">Счёт начисления</th>
            <th scope="col">Комментарий</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($transactions as $transaction) {
            echo '<tr>';
            echo '<td>' . $transaction['date'] . '</td>';
            echo '<td>' . $transaction['sum'] . '</td>';
            echo '<td>' . $transaction['from_name'] . '</td>';
            echo '<td>' . $transaction['to_name'] . '</td>';
            echo '<td>' . $transaction['description'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</main>

<?php printFooter(); ?>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
