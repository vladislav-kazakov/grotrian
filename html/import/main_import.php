<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
require_once($_SERVER['DOCUMENT_ROOT']."/import/configure.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Импорт данных</title>
	<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>     
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />   
</head>
<body>
	<div id="wrap">
		<?php
		$_SESSION['password'] = (isset($_POST['password']) or isset($_SESSION['password']) ? $_POST['password'] : NULL);

		if(isset($_SESSION['password']) and $_SESSION['password'] = 'uhjnbr'){
			?>

			<div id="form_element">
				<h3>Поиск</h3>
				<b>Импорт:</b> 
				<ul>
					<li><input type="radio" value="level" name="selectmethod" checked>Уровни</li>
					<li><input type="radio" value="line" name="selectmethod">Переходы</li>
				</p>
				<p>
					<div id='block_rangeenergy'>Диапазон погрешности энергии: <input type="number" id='rangeenergy' step="0.01" value="1" min='0.01'/></div>
					Название элемента: <input type="text" id="element" required> 
					ион: <input id="ion" type="number" min="1" max="121" value="1">
					<input type="button" id="import" value="GO">
				</div>
				<div id="general">					
					<div id="block_preloader"><img src="file/ajax-loader.gif" id="preloader"></div>
					<div id='textenergyexatra'>
						Этот уровень был определен с помощью интерполяции или экстраполяции известных экспериментальных значений или с помощью полуэмпирических вычислений. Его абсолютная точность отражена в количестве цифр после запятой
					</div>

					<div id="result"></div>
				</div>
				<script type="text/javascript" src="import_data.js"></script>
				<?php
			}else echo "<div id='password'><form method='post'><p>Введите пароль: <input type='password' name='password' required><input type='submit' value='OK'></p></form></div>";
			?>
		</div>
	</body>
	</html>