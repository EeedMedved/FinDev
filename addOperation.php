<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 09.06.2018
 * Time: 15:18
 */

require ('funcs/markup.php');
require('funcs/db.php');

/** Проверяю, какой тип операции и
    устанавливаю заголовок страницы, текст сообщения
    и переменную для внесения в базу данных */

/** Значения переменных в БД
1 - Приход
2 - Расход
 */

if (!empty($_GET['type'])) {
    if ($_GET['type'] == "expense") {
	    $msgTitle    = "расхода";
	    $msgHeader   = "расхода";
	    $hiddenInput = "2";
	    $accountMsg = "С какого счёта";
    } elseif ($_GET['type'] == 'income') {
        $msgTitle = "прихода";
        $msgHeader = "прихода";
        $hiddenInput = "1";
        $accountMsg = "На какой счёт";
    }
} elseif (!empty($_POST['inputDate']) && !empty($_POST['inputSum']) && !empty($_POST['inputDescription'])) {
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

    $sum = htmlspecialchars($_POST['inputSum']);
    $description = htmlspecialchars($_POST['inputDescription']);
    $date = htmlspecialchars($_POST['inputDate']);

     if (saveOperation($operationType, $sum, $description, $date)) {
         die("Сохранено");
     }

} else {
    die('Ошибка 1510. Обратитесь в техподдержку.');
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
    <title>Добавление <?php echo $msgTitle; ?> - Управление личными финансами</title>
</head>
<body>

<?php printHeader($page); ?>

<!-- Begin page content -->
<main class="container" role="main">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mt-5">Добавление <?php echo $msgHeader; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <form method="post" action="addOperation.php">
                <div class="form-group">
                    <label for="inputDate">Дата</label>
                    <input type="date" class="form-control" id="inputDate" name="inputDate" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="inputSum">Сумма</label>
                    <input type="number" step=".01" class="form-control" id="inputSum" name="inputSum">
                </div>
                <div class="form-group">
                    <label for="fromAccount"><?php echo $accountMsg; ?></label>
                    <select name="fromAccount" id="fromAccount" class="form-control">
                        <?php
                        foreach ($accounts as $account) {
                            echo '<option value="' . $account['id'] . '">' . $account['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputDescription">Комментарий</label>
                    <input type="text" class="form-control" id="inputDescription" name="inputDescription">
                </div>
                <input type="hidden" name="operationType" value="<?php echo $hiddenInput; ?>" />
                <button class="btn-primary btn">Сохранить</button>
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
