<?php

    header('Content-Type: application/force-download');
    header('Content-disposition: attachment; filename=grotrian.csv');

    print $_POST['exportdata'];

?>
