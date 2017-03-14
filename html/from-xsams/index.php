<?php
    include('misc.php');
?>
<!doctype html>
<html>
    <head>
        <title>Grotrian</title>
        <meta charset='windows-1251'>
        <link href='style.css' rel='stylesheet'>
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit" name="submit" value="Сформировать">
        </form>
        <?php
            if ($err)
                echo "<div id='err'>", $err, '<div>';
            elseif (isset($waves)) {
        ?>
        <div>
            <div id='toolbar'>
                <div id='range'>
                    <div id='min_container'>
                        <b>Минимум</b><br>
                        <input type='text' id='min' value='0'>
                    </div>
                    <div id='max_container'>
                        <b>Максимум</b><br>
                        <input type='text' id='max' value='30000'>
                    </div>
                </div>
                <div id='zoom_container'>
                    <b>Масштаб</b><br>
                    <input type='button' value='1' class='base active'>
                    <input type='button' value='10' class='base'>
                    <input type='button' value='100' class='base'>
                    <br><br>
                    <input type='button' value='x2'>
                    <input type='button' value='x5'>
                </div>
                <input type='button' id='filter' value='Фильтр'>
            </div>
        </div>
        <div id='line_info'>
		</div>
        <div id="wrapper">
        </div>
        <div id='ruler'>
        </div>
        <div id='meters'>
        </div>
        <div id='map'>
            <div id='preview'></div>
            <div id='map_now'></div>
        </div>
        <script>
            var waves = <?=$waves?>;
        </script>
        <script src='jquery.js'></script>
        <script src='init.js?v2'></script>
        <?php
            }
        ?>
    </body>
</html>