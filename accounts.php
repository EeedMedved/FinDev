<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 15.06.2018
 * Time: 14:51
 */

require('funcs/markup.php');
require('funcs/db.php');

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
	<title>Список счетов - Управление личными финансами</title>
</head>
<body>

<?php printHeader($page); ?>

<main class="container" role="main">
<div class="row">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Название счёта</th>
            <th scope="col">Текущий остаток</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($accounts as $account) {
            echo "<tr>";
            echo '<td>' . $account['id'] . '</td>';
            echo '<td>' . $account['name'] . '</td>';
            echo '<td>' . $account['balance'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
</main>

<?php printFooter(); ?>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
