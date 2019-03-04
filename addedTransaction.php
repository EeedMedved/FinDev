<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 22.06.2018
 * Time: 17:16
 */

require ('funcs/dbconn.php');

$fromBalance = 0;
$toBalance = 0;

if (empty($_POST['inputSum']) || empty($_POST['inputDate'])) {
	echo 'Введите сумму и дату<br />';
	exit();
}

if ($_POST['fromAccount'] == $_POST['toAccount']) {
	echo 'Выберите разные счета<br />';
	exit();
}

if (is_numeric($_POST['fromAccount'])) {
	$fromAccount = $_POST['fromAccount'];
} else {
	exit('Ошибка ввода 2901<br />');
}

if (is_numeric($_POST['toAccount'])) {
	$toAccount = $_POST['toAccount'];
} else {
	exit('Ошибка ввода 2902<br />');
}

if (is_numeric($_POST['inputSum'])) {
	$sum = $_POST['inputSum'];
} else {
	exit('Ошибка ввода 2903<br />');
}

if (!empty($_POST['inputDescription'])) {
	$description = $_POST['inputDescription'];
} else {
	$description = 'Без описания';
}

/// Получаю текущие балансы из базы данных

// Баланс счёта списания
$mysqli = new mysqli($host, $user, $password, $db);

$query = sprintf("SELECT current_balance as balance FROM accounts WHERE id=%d;",
			$fromAccount);

if ($mysqli->connect_errno) {
	exit('Соединение с базой данных не удалось<br />');
}
if ($result = $mysqli->query($query)) {
	if ($row = $result->fetch_row()) {
		$fromBalance = $row[0];
	} else {
		exit('<p>Ошибка 2904</p>');
	}
}

// Баланс счёта начисления
$query = sprintf("SELECT current_balance as balance FROM accounts WHERE id=%d;",
			$toAccount);

if ($result = $mysqli->query($query)) {
	if ($row = $result->fetch_row()) {
		$toBalance = $row[0];
	} else {
		exit('Ошибка 2905<br />');
	}
}

$fromBalance = $fromBalance - $sum;
$toBalance = $toBalance + $sum;

// Сохраняю новые балансы счетов в базе данных

// Сначала с какого счёта
$query = sprintf("UPDATE accounts SET current_balance=%d WHERE id=%d",
				$fromBalance, $fromAccount);
if ($mysqli->query($query)) {
	echo 'Баланс счёта списания обновлен<br />';
} else {
	exit('Ошибка 2906<br />');
}

// Теперь обновляю баланс счёта начисления
$query = sprintf("UPDATE accounts SET current_balance=%d WHERE id=%d",
				$toBalance, $toAccount);
if ($mysqli->query($query)) {
	echo '<p>Баланс счёта начисления обновлён</p>';
} else {
	exit('<p>Error 2907</p>');
}

// Записываю информацию в журнал транзакций
$query = sprintf("INSERT INTO transactions (from_account_id, to_account_id, sum, description, date) 
			VALUES(%d,%d,%d,'%s','%s')", $fromAccount, $toAccount, $sum, $description, $_POST['inputDate']);

echo "<p>Запрос для записи в журнал операций - $query</p>";

if ($mysqli->query($query)) {
	echo '<p>Запись в журнал переводов занесена</p>';
} else {
	exit('<p>Error 2908</p>');
}