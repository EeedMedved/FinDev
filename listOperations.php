<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 13.06.2018
 * Time: 16:18
 */

require("funcs/markup.php");

if (!empty($_GET['type'])) {
	if ($_GET['type'] == 'incomes') {
		$opType = 1;
		$page = "incomes";
	} elseif ($_GET['type'] == 'expenses') {
		$opType = 2;
		$page = "expenses";
	}
}

$mysqli = new mysqli('localhost', 'root', 'Gremlin77', 'myfinances');

if ($mysqli->connect_errno) {
	printf("Не удалось подключиться: %s<br />", $mysqli->connect_error);
	exit();
}

$query = "SELECT tr.id, tr.op_sum, tr.op_date, tr.op_description, tt.name 
				FROM operations tr 
				LEFT JOIN transaction_types tt ON tr.type_id = tt.id";

if ($opType === 1) {
	$query = $query . ' WHERE tr.type_id = 1';
} elseif ($opType === 2) {
	$query = $query . ' WHERE tr.type_id = 2';
}

//die($query);

$result = $mysqli->query($query);

$ops = array();

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	$ops[] = $row;
}

$result->close();
$mysqli->close();

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
	<title>Список операций</title>
</head>
<body>

<?php printHeader($page); ?>

<!-- Begin page content -->
<main class="container" role="main">
<table class="table table-hover">
	<thead>
	<tr>
		<th scope="col">#</th>
		<th scope="col">Дата</th>
		<th scope="col">Комментарий</th>
		<th scope="col">Сумма</th>
		<th scope="col">Тип</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($ops as $op) {
		echo "<tr>";
		echo '<th scope="row">' . $op['id'] . '</th>';
		echo '<td>' . $op['op_date'] . '</td>';
		echo '<td>' . $op['op_description'] . '</td>';
		echo '<td>' . $op['op_sum'] . '</td>';
		echo '<td>' . $op['name'] . '</td>';
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
