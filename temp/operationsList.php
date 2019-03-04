<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 13.06.2018
 * Time: 12:02
 */

$mysqli = new mysqli('localhost', 'root', 'Gremlin77', 'myfinances');

if ($mysqli->connect_errno) {
	printf("Соединение не удалось: %s\n", $mysqli->connect_error);
	exit();
}

$query = "SELECT id, name FROM transaction_types";

if ($result = $mysqli->query($query)) {
	/* Извлечение ассоциативного массива */
	while ($row = $result->fetch_assoc()) {
		printf("%s - %s<br />", $row['id'], $row['name']);
	}

	$result->free();
}

$mysqli->close();

?>