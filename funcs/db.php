<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 21.06.2018
 * Time: 17:17
 */

require('dbconn.php');

function getMysqli() {
	global $host, $user, $password, $db;

	$mysqli = new mysqli($host, $user, $password, $db);

	if ($mysqli->connect_errno) {
		echo '<h3>Ошибка подключения к базе данных</h3>';
		echo '<p>Обратитесь в техподдержку</p>';
		die();
	}

	return $mysqli;
}

function getAccounts() {

	global $host, $user, $password, $db;

	$mysqli = new mysqli($host, $user, $password, $db);

	if ($mysqli -> connect_errno) {
		echo '<h3>Ошибка подключения к базе данных 17001</h3>';
		echo '<p>Обратитесь в техподдержку</p>';
		exit();
	}

	$query = 'SELECT id, name, current_balance as balance FROM accounts';

	$result = $mysqli -> query($query);

	$accounts = array();

	while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
		$accounts[] = $row;
	}

	$result -> close();
	$mysqli -> close();

	return $accounts;

}

function getAllTransactions() {

	$mysqli = getMysqli();

	$query = "SELECT tr.id, acc.name as from_name, acca.name as to_name, tr.sum, tr.description, tr.date 
		FROM myfinances.transactions tr
		LEFT JOIN myfinances.accounts acc ON acc.id=tr.from_account_id
	    LEFT JOIN myfinances.accounts acca ON acca.id=tr.to_account_id;";

	$result = $mysqli->query($query);
	$transactons = array();

	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$transactons[] = $row;
	}

	$result->close();
	$mysqli->close();

	return $transactons;
}

function saveOperation($operationType, $sum, $description, $date) {
    global $host, $user, $password, $db;

    $mysqli = new mysqli($host, $user, $password, $db);

    if ($mysqli->connect_errno) {
        printf('Соединение не удалось');
        exit();
    }

    $query = "INSERT INTO operations (type_id, op_sum, op_description, op_date) VALUES($operationType, $sum, '$description', '$date')";

    //die($query);

    if (!($mysqli->query($query))) {
        die("Ошибка: " . $mysqli->error . "<br />");
    }

    // Получаю текущий баланс счёта
// Вычитаю из него сумму
// Сохраняю результат в базу данных

    $accountId = htmlspecialchars($_POST['fromAccount']);
    $query2 = "SELECT current_balance as balance FROM accounts WHERE id = $accountId";
//    echo $query2 . '<br />';
    $balance = 0;

    if ($result = $mysqli -> query($query2)) {
        while ($row = $result -> fetch_row()) {
            $balance = $row[0];
            //echo 'balance ' . $balance;
            //echo 'row balance' . $row[0];
        }
    } else {
        echo 'Error 1520<br />';
    }

    //echo $balance . '<br />';

    if ($operationType == '1') {
        $balance = $balance + $sum;
    } elseif ($operationType == '2') {
        $balance = $balance - $sum;
    }

    $query = "UPDATE accounts SET current_balance=$balance WHERE id=$accountId";

    if ($mysqli->query($query)) {
        //echo 'Баланс обновлён.<br />';
    } else {
        echo 'Error 1521<br />';
    }

    $mysqli->close();

    return true;
}