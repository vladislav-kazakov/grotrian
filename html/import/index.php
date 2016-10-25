<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
// require_once($_SERVER['DOCUMENT_ROOT']."/configure.php");
// require_once($_SERVER['DOCUMENT_ROOT']."/includes/elementlist.php");
// $elements = new ElementList;

// $elements->LoadPereodicTable($l10n->locale,0);
// $table=$elements->GetItemsArray();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Импорт данных</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script> 
	<script type="text/javascript" src="js/main.js"></script>  
	<script type="text/javascript" src="js/scrollup.js"></script>  
</head>
<body>
	<div class="container">		
		<div class="center-text">
			<h1 class="text-muted">Информационная система «Электронная&nbsp;структура&nbsp;атомов»</h1>
		</div>
	</div>
	<div class='container'>		
		<?php
		$_SESSION['password'] = (isset($_POST['password']) ? $_POST['password'] : $_SESSION['password']);
		if($_SESSION['password'] == 'uhjnbr'){
			include 'table.html';
			?>
			<div class="row">
				<div class="col-xs-6">
					<h2>Периодическая таблица</h2>
					<p><input class="btn btn-large btn-success" value="Выбрать элемент" id="chooseelement"></p>
				</div>
				<div class="col-xs-6"id="infoelement" style="display: none">
					<h2></h2>
					<p>Ион: <input type='number' min=1 value=1 id='valion'></p>
				</div>
			</div>
			<hr>
			<div class="row" style="display: none" id="choosetype">
				<div class="col-xs-6">
					<h2>Уровни</h2>
					<p>Импорт уровней является основным и первоначальным этапом актуализации данных элемента</p>
					<p>Диапазон погрешности энергии: <input type='number' id='rangeenergy' step=0.01 value=1 min='0.01'/></p>
					<p><button class="btn" id="btnlevel">Начать импорт уровней »</button></p>
				</div>
				<div class="col-xs-6">
					<h2>Переходы</h2>
					<p>Импорт переходов основывается на импорте уровней, перед тем как приступить к загрузке переходов, убедитесь, что уровни данного атома уже были проанализированы </p>
					<p><button class="btn" id="btntransition">Начать импорт переходов »</button></p>
				</div>
			</div>
			<div class="row center-text">
				<img src="file/ajax-loader.gif" id="preloader">
			</div>

			<div class="row" id="result"></div>


			<?php
		}else{
			?>

			<div class='jumbotron'>
				<p>Вход не выполнен</p>
				<div id='password'><form method='post'><input type='password' name='password' required placeholder="Введите пароль"></form></div>
			</div>
			<?php
		}
		?>
	</div>
	<div id="scrollup" class="center-text"><p>Прокрутить вверх</p></div>
</body>
</html>