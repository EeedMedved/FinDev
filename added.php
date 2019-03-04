<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 13.06.2018
 * Time: 11:34
 */

/** Значения переменных в БД
1 - Приход
2 - Расход
*/

if (!empty($_POST['inputDate']) && !empty($_POST['inputSum']) && !empty($_POST['inputDescription'])) {
	if(!isset($_SERVER['HTTP_REFERER'])) {
		die('Ошибка 1509. Обратитесь в техподдержку.');
	}

	if ($_POST['operationType'] == "1") {
		$operationType = 1;
	} elseif ($_POST['operationType'] == "2") {
		$operationType = 2;
	} else {
		die('Ошибка 1511. Обратитесь в техподдержку.');
	}

} else {
	die('Ошибка 1510. Обратитесь в техподдержку.');
}

$mysqli = new mysqli('localhost', 'root', 'Gremlin77', 'myfinances');

if ($mysqli->connect_errno) {
	printf('Соединение не удалось');
	exit();
}

$sum = htmlspecialchars($_POST['inputSum']);
$description = htmlspecialchars($_POST['inputDescription']);
$date = htmlspecialchars($_POST['inputDate']);

$query = "INSERT INTO operations (type_id, op_sum, op_description, op_date) VALUES($operationType, $sum, '$description', '$date')";

die($query);

if ($mysqli->query($query)) {
	echo 'Данные успешно сохранены!<br />';
} else {
	printf("Ошибка: %s<br />", $mysqli->error);
}

// Получаю текущий баланс счёта
// Вычитаю из него сумму
// Сохраняю результат в базу данных

$accountId = htmlspecialchars($_POST['fromAccount']);
$query2 = "SELECT current_balance as balance FROM accounts WHERE id = $accountId";
echo $query2 . '<br />';
$balance = 0;

if ($result = $mysqli -> query($query2)) {
	while ($row = $result -> fetch_row()) {
		$balance = $row[0];
		echo 'balance ' . $balance;
		echo 'row balance' . $row[0];
	}
} else {
	echo 'Error 1520<br />';
}

echo $balance . '<br />';

if ($operationType == '1') {
	$balance = $balance + $sum;
} elseif ($operationType == '2') {
	$balance = $balance - $sum;
}

$query = "UPDATE accounts SET current_balance=$balance WHERE id=$accountId";

if ($mysqli->query($query)) {
	echo 'Баланс обновлён.<br />';
} else {
	echo 'Error 1521<br />';
}

$mysqli->close();
