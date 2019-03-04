<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 13.06.2018
 * Time: 18:09
 */

$insertOperation = false;   // Флаг, по которому определяем, показывать форму ввода
							// или результат внесения информации в базу данных

if (!empty($_POST['inputName'])) {
	$mysqli = new mysqli('localhost', 'root', 'Gremlin77', 'myfinances');

	if ($mysqli->connect_errno) {
		die('Соединение не удалось');
		exit();
	}

	$accountName = htmlspecialchars($_POST['inputName']);
	$accountName = $mysqli->real_escape_string($accountName);

	$query = "INSERT INTO accounts (name, current_balance) VALUES('$accountName', 0)";

	if ($mysqli->query($query)) {
		$insertOperation = true;
	} else {
		die($mysqli->error);
	}

	$mysqli->close();
}

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
	<title>Добавление счёта</title>
</head>
<body>

<header>
	<!-- Fixed navbar -->
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
		<a href="#" class="navbar-brand">Личные финансы</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
		        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarCollpase">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="index.php" class="nav-link">Главная</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Статистика</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Все расходы</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link">Все приходы</a>
				</li>
			</ul>
		</div>
	</nav>
</header>

<main class="container" role="main">
	<div class="row">
		<div class="col-md-8">
			<h1 class="mt-5">Добавление нового счёта</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<?php if ($insertOperation) {
				?>
			<div class="alert alert-success" role="alert">
				Данные успешно сохранены!
			</div>
			<?php
			} else {
				?>
			<form method="post" action="addAcount.php">
				<div class="form-group">
					<label for="inputName">Название счёта</label>
					<input type="text" class="form-control" id="inputName" name="inputName">
				</div>
				<button class="btn btn-primary">Сохранить</button>
			</form>
			<?php } ?>
		</div>
	</div>
</main>

<footer class="footer">
	<div class="container">
		<span class="text-muted">SBS Software. 2018.</span>
	</div>
</footer>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
