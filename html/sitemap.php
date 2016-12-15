<?header("Content-Type: text/xml; charset=windows-1251")?>
<?php echo '<?xml version="1.0" encoding="windows-1251"?>'?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>http://grotrian.nsu.ru/ru</loc>
    </url>
    <url>
        <loc>http://grotrian.nsu.ru/en</loc>
    </url>
    <url>
        <loc>http://grotrian.nsu.ru/ru/articles/1</loc>
    </url>
    <url>
        <loc>http://grotrian.nsu.ru/ru/articles/2</loc>
    </url>
    <url>
        <loc>http://grotrian.nsu.ru/en/articles/1</loc>
    </url>
    <url>
        <loc>http://grotrian.nsu.ru/en/articles/2</loc>
    </url>

    <?php
    require_once("configure.php");
    require_once("includes/atomlist.php");

    $atoms = new AtomList;
    //загружаем таблицу элементов с локализованными именами и ст. ионизацией = 0;
    $atoms->LoadForSitemap();
    $atoms_array = $atoms->GetItemsArray();

    foreach ($atoms_array as $atom):
        $atom_name = $atom['ABBR'];
        if ($atom_name !='H' && $atom_name !='D' && $atom_name !='T' )
            $atom_name .= ' ' . numberToRoman(intval($atom['IONIZATION']) + 1);
    ?>
    <url>
        <loc>http://grotrian.nsu.ru/ru/element/<?php echo $atom['ID']?></loc>
        <?if (isset($atom['SPECTRUM_IMG'])):?>
        <image:image>
            <image:loc>http://grotrian.nsu.ru/ru/spectrumpng/<?php echo $atom['ID']?></image:loc>
            <image:caption>Спектр <?if ($atom['IONIZATION']==0) echo 'атома '; else echo 'иона '; echo $atom['NAME_RU_ALT'] . ' (' . $atom_name .')'?></image:caption>
        </image:image>
        <?endif;?>
    </url>
    <url>
        <loc>http://grotrian.nsu.ru/en/element/<?php echo $atom['ID']?></loc>
        <?if (isset($atom['SPECTRUM_IMG'])):?>
        <image:image>
            <image:loc>http://grotrian.nsu.ru/en/spectrumpng/<?php echo $atom['ID']?></image:loc>
            <image:caption>Spectrum of <?echo $atom['NAME_EN'] . ' '; if ($atom['IONIZATION']==0) echo 'atom '; else echo 'ion '; echo '(' . $atom_name .')'?></image:caption>
        </image:image>
        <?endif;?>
    </url>
    <?php endforeach;?>
</urlset>