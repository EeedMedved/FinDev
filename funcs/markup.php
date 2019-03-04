<?php
/**
 * Created by PhpStorm.
 * User: medvedev
 * Date: 15.06.2018
 * Time: 15:28
 */

function printHeader( $pageName ) {

	if ( $pageName == "index" ) {
		$indexActive = "active";
	} elseif ( $pageName == "incomes" ) {
		$incomesActive = "active";
	} elseif ( $pageName == "expenses" ) {
		$expensesActive = "active";
	}

	echo "
<header>
	<!-- Fixed navbar -->
	<nav class=\"navbar navbar-expand-md navbar-dark fixed-top bg-dark\">
		<a href=\"#\" class=\"navbar-brand\">Личные финансы - <b>Beta</b></a>
		<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarCollapse\"
		        aria-controls=\"navbarCollapse\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
			<span class=\"navbar-toggler-icon\"></span>
		</button>
		<div class=\"collapse navbar-collapse\" id=\"navbarCollpase\">
			<ul class=\"navbar-nav mr-auto\">
				<li class=\"nav-item $indexActive\">
					<a href=\"index.php\" class=\"nav-link\">Главная</a>
				</li>
				<li class=\"nav-item\">
					<a href=\"#\" class=\"nav-link\">Статистика</a>
				</li>
				<li class=\"nav-item\">
					<a href=\"listOperations.php?type=expenses\" class=\"nav-link $expensesActive\">Все расходы</a>
				</li>
				<li class=\"nav-item\">
					<a href=\"listOperations.php?type=incomes\" class=\"nav-link $incomesActive\">Все приходы</a>
				</li>
			</ul>
		</div>
	</nav>
</header>	
	";
}

function printFooter() {
	echo "
<footer class=\"footer\">
	<div class=\"container\">
		<span class=\"text-muted\">SBS Software. 2018.</span>
	</div>
</footer>
	";
}