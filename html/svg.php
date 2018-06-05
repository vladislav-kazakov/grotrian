<?//header("Content-type:text/html; charset=windows-1251");

require_once($_SERVER['DOCUMENT_ROOT']."/configure.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/atom.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/levellist.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/transitionlist.php");

/*FORMATING FUNCTIONS */
function extend_energy($val, $n){
    global $n_breaks, $breaks;
    if ($n < $n_breaks) {
        if ($val < $breaks[$n]['l1']['value']) return extend_energy($val, $n + 1);
        else return extend_energy($val + ($breaks[$n]['l2']['value'] - $breaks[$n]['l1']['value']), $n + 1);
    }
    else return $val;
}

/*convert energy to coordinates*/
function convert_energy($val){ //сложная логика условий. Переделать
    global $min_limit, $n_breaks, $diagram_h, $graph_y, $n_limits, $max_limit, $term_row_h;
    if ($val < $min_limit){
        if ($n_breaks >= 1) return scale_with_breaks($val);
        if ($n_breaks == 0) return round($diagram_h - (($val * $graph_y) / $min_limit), 2);
    }
    elseif ($n_limits == 1) return round($diagram_h - $graph_y, 2);
    elseif ($val > $max_limit) return round($diagram_h - $graph_y - $term_row_h*0.5, 2);
    elseif ($n_limits > 1) return round($diagram_h - $graph_y - ($term_row_h*0.5*($val - $min_limit) / ($max_limit - $min_limit)), 2);
    else return round($diagram_h - $graph_y, 2);
}

function scale_with_breaks($energy){
    global $breaks, $diagram_h, $graph_y, $min_limit, $sum_breaks;
    $val = $energy;
    foreach($breaks as $break){
        if ($energy > $break['l2']['value']) $val -= $break['l2']['value'] - $break['l1']['value'];
        elseif ($energy > $break['l1']['value']) $val -= $energy - $break['l1']['value'];
    }
    return round($diagram_h - (($val*$graph_y) / ($min_limit - $sum_breaks)));
}

function set_labels($x, $dx, $class, $n, $kE, $energy){
    global $n_labels;
    if ($n < $n_labels) {
        $curE = extend_energy($energy /*val*/, 0 /*n*/);
        $curY = convert_energy($curE);
        echo '<text class="' . $class . '" x="' . ($x+$dx) .'" y="' . $curY . '">' . round($curE*$kE, 1) . '</text>' . PHP_EOL;
        echo '<line class="energy" y1="' . $curY . '" y2="' . $curY . '" x1="' . ($x+$dx) . '" x2="' . ($x - 3*$dx) .'"/>' . PHP_EOL;
        set_labels($x, $dx, $class, $n + 1, $kE, (($energy / $n) * ($n + 1)));
    }
}

/*create a string with indexes instead of @{...} (supindex) and ~{...} (subindex)*/
function create_indexes($val){
    global $index_dx, $index_dy;

    $val = preg_replace("/@\{([^\}]*)\}~\{([^\}]*)\}/", '<tspan class="index" dy="' . (-$index_dy) . '" dx="' . (-$index_dx) . '">$1</tspan>'
                                                .'<tspan class="index" dy="' . (2*$index_dy) . '" dx="' . (-$index_dx) . '">$2</tspan>', $val);
    $val = preg_replace("/<\/tspan>([^~@<]*)/", '</tspan><tspan dy="' . (-$index_dy) . '" dx="' . (-$index_dx) . '">$1</tspan>', $val);

    $val = preg_replace("/@\{([^\}]*)\}/", '<tspan class="index" dy="' . (-$index_dy) . '" dx="' . (-$index_dx) . '">$1</tspan>', $val);

    $val = preg_replace("/<\/tspan>([^~@<]+)/", '</tspan><tspan dy="' . ($index_dy) . '" dx="' . (-$index_dx) . '">$1</tspan>', $val);

    $val = preg_replace("/~\{([^\}]*)\}/", '<tspan class="index" dy="' . ($index_dy) . '" dx="' . (-$index_dx) . '">$1</tspan>', $val);
    $val = preg_replace("/<\/tspan>([^~@<]+)/", '</tspan><tspan dy="' . (-$index_dy) . '" dx="' . (-$index_dx) . '">$1</tspan>', $val);

    return $val;
}

function count_length($val){
    $sym = array("@", "~", "{", "}");
    $val = str_replace($sym, "", $val);
    $len = strlen($val) * 7;
    if ($len != 0) $len+=10;
    return $len;
}
/*Xml2Array recursive parser*/
function parseNode($node, $assocs = null, $valueName = 'value'){
    $arrayElement = [];
    if ($node->nodeType == XML_TEXT_NODE)
        if (trim($node->nodeValue) != "") return trim($node->nodeValue);
        else return null;
    if ($node->hasAttributes())
        foreach ($node->attributes as $attribute)
            $arrayElement[$attribute->nodeName] = $attribute->nodeValue;
    if ($node->hasChildNodes()) {
        foreach ($node->childNodes as $childNode) {
            $childArrayElement = parseNode($childNode, $assocs, $valueName);
            if ($childArrayElement === null) continue;
            elseif ($childNode->nodeType == XML_TEXT_NODE) $arrayElement[$valueName] = $childArrayElement;
            elseif (isset($childNode->tagName) && $assocs && in_array($childNode->tagName, $assocs))
                $arrayElement[$childNode->tagName] = $childArrayElement;
            elseif (isset($childNode->tagName)) $arrayElement[$childNode->tagName][] = $childArrayElement;
            else $arrayElement[] = $childArrayElement;
        }
    }
    return $arrayElement;
}

function parseXml($xmlBody, $assocs = null, $valueName = 'value'){
    if (!$xmlBody || $xmlBody == "") return [];
    $DOM = new DOMDocument;
    if (!$DOM->loadXML($xmlBody)) return [];
    return parseNode($DOM, $assocs, $valueName);
}

if(isset($_REQUEST['element_id'])) {
    $element_id = $_REQUEST['element_id'];
    $atom = new Atom();
    $atom->Load($element_id);
    $atom_data = $atom->GetAllProperties();
    $abbr = $atom->GetAbbr();

    $limits = parseXml($atom_data['LIMITS'], ["limits", "l1", "l2"]);
    if (isset($limits["limits"]["limit"])) $limits = $limits["limits"]["limit"];
    $n_limits = 0;
    $max_limit = 0;
    $min_limit = 0;
    if (is_array($limits))
        foreach ($limits as $limit)
            if (isset($limit['value'])) {
                if ($limit['value'] > $max_limit) $max_limit = $limit['value'];
                if ($limit['value'] < $min_limit || $min_limit == 0) $min_limit = $limit['value'];
                $n_limits++;
            }

    if (isset($_REQUEST['enmin'])) $min_energy = $_REQUEST['enmin']; else $min_energy = 0;
    if (isset($_REQUEST['enmax'])) $max_energy = $_REQUEST['enmax']; else $max_energy = 0;
    if (isset($_REQUEST['autoStatesOff'])) $max_energy = ($max_energy == 0) ? $min_limit : min($max_energy, $min_limit);

    $levelList = new LevelList();
    $levels = $levelList->LoadGrouped($element_id, $min_energy, $max_energy);
    $levelsOrdered = $levelList->GetItemsArray();
    $transitionList = new TransitionList();
    $lines = $transitionList->LoadForDiagram($element_id);


    $breaks = parseXml($atom_data['BREAKS'], ["breaks", "l1", "l2"]);
    if (isset($breaks["breaks"]["break"])) $breaks = $breaks["breaks"]["break"];
    if (count($breaks) == 0){
        foreach ($levelsOrdered as $level){
            if (isset($prevLevel) && $level['ENERGY'] < $min_limit && $level['ENERGY'] - $prevLevel['ENERGY'] > $min_limit * 0.15){
                $breaks[] = ['l1' =>['value' => round($prevLevel['ENERGY'] + $min_limit*0.05, -1)],
                             'l2' =>['value' => round($level['ENERGY'] - $min_limit*0.02, -1)]];
            }
            $prevLevel = $level;
        }
    }

    $n_breaks = 0;
    $sum_breaks = 0;
    if (is_array($breaks))
        foreach ($breaks as $break)
            if (isset($break['l1']['value']) && $break['l2']['value']) {
                $n_breaks++;
                $sum_breaks += $break['l2']['value'] - $break['l1']['value'];
            }

    $n_labels = 5;
    $toeV = 0.00012398;
    $Ecm_row_w = 50;
    $index_dy = 5;
    $index_dx = 1;
    $level_dx = 5;

    $diagram_w = 1000;
    if (isset($_REQUEST['width'])) $diagram_w = $_REQUEST['width'];

    $diagram_h = 700;
    $term_row_w = 30;

    $dE = round(($min_limit - $sum_breaks) / ($n_labels * 100)) * 100;

    $conf_row_h = 0;
    foreach ($levels as $column)
        if (count_length($column['CELLCONFIG']) > $conf_row_h)
            $conf_row_h = count_length($column['CELLCONFIG']);

    $core_row_h = 0;
    foreach ($levels as $column)
        foreach ($column['atomiccore'] as $atomiccore)
            if (count_length($atomiccore['ATOMICCORE']) > $core_row_h)
                $core_row_h = count_length($atomiccore['ATOMICCORE']);

    $term_row_h = 0;
    $n_terms = 0;
    foreach($levels as $column)
        foreach($column['atomiccore'] as $atomiccore)
            foreach($atomiccore['term'] as $term)
                foreach($term['group'] as $group) {
                    $n_terms++;
                    $str = $group['TERMSECONDPART'] . $term['TERMPREFIX']
                         . $group['TERMFIRSTPART'] . $term['TERMMULTIPLY'] . $group['J'];
                    if (count_length($str) > $term_row_h)
                        $term_row_h = count_length($str);
                }
    if ($n_limits >1) $term_row_h *= 2;

    if ($term_row_w * $n_terms < $diagram_w) $term_row_w = $diagram_w / $n_terms;

    $graph_y = $diagram_h - $core_row_h - $conf_row_h - $term_row_h;
    $t_width = $term_row_w * $n_terms;
    $t_height = $diagram_h + 2;
?>
    <link xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          rel="stylesheet"
          type="text/css"
          href="/css/svg.css?v3">
    </link>
    <svg xmlns="http://www.w3.org/2000/svg"
         preserveAspectRatio="xMinYMin"
         id="svg_with_diagram"
         viewBox="0 0 <?=$diagram_w?> <?=$diagram_h + 2?>">

        <desc><?=$abbr?></desc>

        <!-- Шкала энергий -->
        <g class="Ecm" id="Ecm">
            <text class="Ecm" x="<?=0.7*$Ecm_row_w?>" y="<?=0.3*$conf_row_h?>">U</text><text
                    class="Ecm" x="<?=$Ecm_row_w - 5?>" y="<?=0.6*$conf_row_h?>">[cm<tspan
                        class="index" dy="<?=-$index_dy?>">-1</tspan><tspan dy="<?=$index_dy?>">]</tspan></text><text
                    class="Ecm" x="<?=$Ecm_row_w - 5?>" y="<?=$diagram_h?>">0</text><text
                    class="Ecm" x="<?=$Ecm_row_w - 1?>" y="<?=$diagram_h - $graph_y?>"><?=$min_limit?></text>

            <!-- for view level energy -->
            <?foreach ($levels as $column){
                foreach($column['atomiccore'] as $atomiccore) {
                    foreach ($atomiccore['term'] as $term) {
                        foreach ($term['group'] as $group) {
                            foreach ($group['level'] as $level) { ?>
                                <line class="energy" id="lbl_<?= $level['ID'] ?>" x1="<?= $Ecm_row_w - 1 ?>"
                                      x2="<?= $Ecm_row_w + 3 ?>" display="none"
                                      y1="<?= convert_energy($level['ENERGY']) ?>"
                                      y2="<?= convert_energy($level['ENERGY']) ?>">
                                </line>
                                <text class="Ecml" id="txt_lbl_<?= $level['ID'] ?>" x="<?= $Ecm_row_w - 1 ?>" display="none"
                                      y="<?= convert_energy($level['ENERGY']) ?>"><?= round($level['ENERGY'], 1) ?></text>
                                <?
                            }
                        }
                    }
                }
            }?>
            <!-- END for view level energy -->
            <!-- Кажется рассчитано, максимум на два лимита. Исправить -->
            <?if ($n_limits > 1){?>
                <text class="Ecm" x="<?=$Ecm_row_w - 1?>"
                      y="<?=$diagram_h - $graph_y - 0.5*$term_row_h?>"><?=$max_limit?></text>
            <?}?>
            <!-- Устанавливаем рызрывы на шкалу -->
            <?foreach($breaks as $break){?>
                <text class="break" x="<?=$Ecm_row_w?>" y="<?=convert_energy($break['l1']['value'])?>">~<tspan
                            dy="-4" dx="-15">~</tspan></text>
            <?}?>
            <!-- Устанавливаем метки по шкале энергий -->
            <?set_labels($Ecm_row_w, -1, 'Ecm', 1, 1, $dE);?>
        </g>
        <g class="Data" transform="translate(<?=$Ecm_row_w?>, 0)">
            <?$n_col = 0;
            $translate = 0;
            foreach ($levels as $column){
                $n_col++;
                $n_terms_in_config = 0;
                foreach($column['atomiccore'] as $atomiccore)
                    foreach($atomiccore['term'] as $term)
                        foreach($term['group'] as $group)
                            $n_terms_in_config++;
                $col_w = $n_terms_in_config*$term_row_w;
                ?>
                <g class="column" id="col_<?=$n_col?>" transform="translate(<?=$translate?>, 0)">
                    <rect y="0" x="0" height="<?=$conf_row_h?>" width="<?=$col_w?>" id="recConf_<?=$n_col?>"> </rect>
                    <text class="config" y="<?=0.5*$conf_row_h?>" x="<?=0.5*$col_w?>"
                          rec_id="recConf_<?=$n_col?>"><?=create_indexes($column['CELLCONFIG'])?></text>
                    <?$n_core = 0;
                    $core_x = 0;
                    foreach ($column['atomiccore'] as $atomiccore) {
                        $n_core++;
                        $n_terms_in_core = 0;
                        foreach($atomiccore['term'] as $term)
                            foreach($term['group'] as $group)
                                $n_terms_in_core++;

                        $core_w = $n_terms_in_core*$term_row_w;
                        ?>
                        <g class="core">
                            <rect x="<?=$core_x?>" height="<?=$core_row_h?>" width="<?=$core_w?>" y="<?=$conf_row_h?>"
                                  id="recCore_<?=$n_core?>"></rect>
                            <?if ($atomiccore['ATOMICCORE'] != ''){?>
                                <text class="config" y="<?=0.5*$core_row_h + $conf_row_h?>" x="<?=$core_x + 0.5*$core_w?>"
                                      rec_id="recCore_<?=$n_core?>"><?=create_indexes($atomiccore['ATOMICCORE'])?></text>
                            <?}?>
                            <?
                            $n_term = 0;
                            foreach($atomiccore['term'] as $term) {
                                $dx = 0;
                                ?>
                                <g class="term" prefix="<?=$term['TERMPREFIX']?>" parity="<?=$term['TERMMULTIPLY']?>"><?
                                    foreach ($term['group'] as $group){
                                        $n_term++;
                                        $child_x = ($n_term-0.5) * $term_row_w + $core_x;
                                        $n_levels_in_term = 0;
                                        foreach($group['level'] as $level)
                                            $n_levels_in_term++;
                                        ?><rect x="<?=($n_term-1)*$term_row_w + $core_x + $dx?>" y="<?=$conf_row_h+$core_row_h?>" width="<?=$term_row_w?>" id="recTerm_<?=$n_term?>"
                                                L="<?=$group['TERMFIRSTPART']?>"
                                                prefix="<?=$term['TERMPREFIX']?>"
                                                parity="<?=$term['TERMMULTIPLY']?>"
                                                j="<?=$group['J']?>"
                                                n_levels="<?=$n_levels_in_term?>"
                                        <?
                                        if ($n_limits==1){?>
                                            height="<?=$term_row_h?>"
                                            <?if ($group['level'][0]['ENERGY'] > $min_limit){?> info="no" <?}
                                        }
                                        if ($n_limits > 1){
                                            if ($group['level'][count($group['level'])-1]['ENERGY'] > $min_limit) {?>
                                                height="<?=$term_row_h * 0.5?>" type="auto"
                                            <?} else{?> height="<?=$term_row_h?>" <?}
                                        }
                                        ?>
                                        ></rect>
                                        <text class="config" x="<?=$child_x + $dx?>" type="full"
                                            <?if ($n_limits == 1){?>
                                                y="<?=0.5*$term_row_h + $core_row_h + $conf_row_h?>"
                                            <?}elseif ($group['level'][count($group['level'])-1]['ENERGY'] > $min_limit){?>
                                                y="<?=0.25*$term_row_h + $core_row_h + $conf_row_h?>"
                                            <?}else{?>
                                                y="<?=0.5*$term_row_h + $core_row_h + $conf_row_h?>"
                                            <?}?>
                                              rec_id="recTerm_<?=$n_term?>"><?=$group['TERMSECONDPART']?><tspan class="index" dx="<?=-$index_dx?>"
dy="<?=-$index_dy?>"><?=$term['TERMPREFIX']?></tspan><tspan dx="<?=-$index_dx?>"
dy="<?=$index_dy?>"><?=$group['TERMFIRSTPART']?></tspan><?if ($term['TERMMULTIPLY'] != 0){?><tspan class="index"
dx="<?=-$index_dx?>" dy="<?=-$index_dy?>">o</tspan><tspan class="index"
dx="<?=-$index_dy?>" dy="<?=2*$index_dy?>"><?=$group['J']?></tspan><?}else{?><tspan class="index"
dx="<?=-$index_dx?>" dy="<?=$index_dy?>"><?=$group['J']?></tspan><?}?></text>
<g class="levels"><line class="level" x1="<?=$child_x + $dx?>" x2="<?=$child_x + $dx?>"
                                                                y2="<?=convert_energy($group['level'][0]['ENERGY'])?>"
                                                <?if ($n_limits == 1){?>
                                                    y1="<?=convert_energy($min_limit)?>"
                                                <?}elseif ($group['level'][count($group['level'])-1]['ENERGY'] > $min_limit){?>
                                                    y1="<?=convert_energy($max_limit)?>"
                                                <?}else{?>
                                                    y1="<?=convert_energy($min_limit)?>"
                                                <?}?>
                                            ></line>
                                            <?foreach($group['level'] as $level){?>
                                                <line class="level" energy="<?=$level['ENERGY']?>" onmouseover="mouse_on_level(evt, this)" onmouseout="mouse_out_level(evt, this)"
                                                      config="<?=$level['CONFIG']?>" j="<?=$level['J']?>"
                                                      id="<?=$level['ID']?>"
                                                      y1="<?=convert_energy($level['ENERGY'])?>"
                                                      y2="<?=convert_energy($level['ENERGY'])?>"
                                                      x1="<?=$child_x - $level_dx + $dx?>"
                                                      x2="<?=$child_x + $level_dx + $dx?>"
                                                      <?if($level['long'] == 1){?>long="1"<?}?>
                                                ></line>
                                                <text class="namelevel" id="conf_name_<?=$level['ID']?>" x="<?=$child_x + $level_dx + $dx?>" display="none"
                                                      y="<?=convert_energy($level['ENERGY'])?>"
                                                ><?=create_indexes($level['FULL_CONFIG'])?><?if ($level['J'] != ''){?><?if ($level['CONFIG'] != ''){?>, <?}?>j=<?=$level['J']?><?}?></text>
                                            <?}?>
                                        </g>
                                    <?}?>
                                </g>
                            <?}?>
                        </g>
                        <?$core_x += $core_w;
                    }?>
                </g>
                <?$translate += $col_w;
            }?>
            <rect class="AllData" id="AllData" width="<?=$term_row_w*$n_terms?>" height="<?=$diagram_h+2?>" y="0" x="0"> </rect>

            <!-- transitions-->
            <g id="transitions">
                <?foreach($lines as $line){?>
                    <line class="transition" onmouseover="mouse_on_tr(evt, this)" onmouseout="mouse_out_tr(evt, this)"
                          id="<?=$line['ID']?>"
                          low_level="<?=$line['lower_level_id']?>"
                          high_level="<?=$line['upper_level_id']?>"
                          rating="<?=$line['rating']?>"
                          dx="0"
                          wavelength="<?=$line['WAVELENGTH']?>"></line>
                    <rect class="fortext" width="1" height="6" transform="" display="none"
                          id="rect_<?=$line['ID']?>"></rect>
                    <text class="transition" transform="" display="none"
                          id="txt_<?=$line['ID']?>"><?=$line['WAVELENGTH']?></text>
                <?}?>
            </g>
            <text class="name" id="Abbr" x="<?=$term_row_w*$n_terms - 5?>" y="<?=$diagram_h - 5?>"><?=$abbr?></text>

            <g class="Eev" id="EeV" transform="translate(<?=$n_terms * $term_row_w?>, 0)">
                <text class="Eev" x="<?=0.3*$term_row_w?>" y="<?=0.3*$conf_row_h?>">U</text><text
                        class="Eev" x="5" y="<?=0.6*$conf_row_h?>">[eV]</text><text
                        class="Eev" x="5" y="<?=$diagram_h?>">0</text><text
                        class="Eev" x="1" y="<?=$diagram_h - $graph_y?>"><?=round($min_limit*$toeV, 1)?></text>

                <!-- Кажется рассчитано, максимум на два лимита. Исправить -->
                <?if ($n_limits > 1){ ?>
                    <text class="Eev" x="1" y="<?=$diagram_h - $graph_y - 0.5*$term_row_h?>"
                    ><?=round($max_limit * $toeV, 1)?></text>
                <?}?>

                <!-- Устанавливаем рызрывы на шкалу -->
                <?foreach($breaks as $break){?>
                    <text class="break" x="0" y="<?=convert_energy($break['l1']['value'])?>"
                    >~<tspan dy="-4" dx="-15">~</tspan></text>
                <?}?>
                <!-- Устанавливаем разметку по шкале энергии -->
                <?set_labels(0, 1, 'Eev', 1, $toeV, $dE);?>
            </g>
        </g>
        <script type="text/ecmascript" scriptImplementation="">
            var table_width = <?=$t_width?>;
            var table_height = <?=$t_height?>;
            var term_row_w = <?=$term_row_w?>;
            var term_row_h = <?=$term_row_h?>;
            var core_row_h = <?=$core_row_h?>;
            var conf_row_h = <?=$conf_row_h?>;
            var diagram_w = <?=$diagram_w?>;
        </script>
        <script xmlns:xlink="http://www.w3.org/1999/xlink" type="text/ecmascript" xlink:href="/js/svg.js?v2"></script>
    </svg>
<?}?>