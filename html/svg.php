<?header("Content-type:text/html; charset=windows-1251");

require_once($_SERVER['DOCUMENT_ROOT']."/configure.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/atom.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/levellist.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/transitionlist.php");

/*FORMATING FUNCTIONS */
function extend_energy($val, $n){
    global $n_breaks, $breaks;
    if ($n < $n_breaks) {
        if ($val < $breaks[$n]['l1']) return extend_energy($val, $n + 1);
        else return extend_energy($val + ($breaks[$n]['l2'] - $breaks[$n]['l1']), $n + 1);
    }
    else return $val;
}

/*convert energy to coordinates*/
function convert_energy($val){ //сложная логика условий. Переделать
    global $energy_limit, $n_breaks, $diagram_h, $graph_y, $n_limits, $energy_limit_last, $term_row_h;
    if ($val < $energy_limit){
        if ($n_breaks >= 1) return scale_with_breaks( 0, $val, $val);
        if ($n_breaks == 0) return round($diagram_h - (($val * $graph_y) / $energy_limit), 2);
    }
    elseif ($n_limits == 1) return round($diagram_h - $graph_y, 2);
    elseif ($val > $energy_limit_last) return round($diagram_h - $graph_y - $term_row_h*0.5, 2);
    elseif ($n_limits > 1) return round($diagram_h - $graph_y - ($term_row_h*0.5*($val - $energy_limit) / ($energy_limit_last - $energy_limit)), 2);
    else return round($diagram_h - $graph_y, 2);
}

function scale_with_breaks($n_break, $energy, $val){
    global $breaks, $n_breaks, $diagram_h, $graph_y, $energy_limit, $sum_breaks;
    if ($n_break < $n_breaks){
        if ($energy > $breaks[$n_break]['l2'])
            //Если уровень выше верхней границы предела, то отнимаем от энергии ширину разрыва и идем дальше
            return scale_with_breaks($n_break + 1, $energy, $val - ($breaks[$n_break]['l2'] - $breaks[$n_break]['l1']));
        elseif ($energy >= $breaks[$n_break]['l1'])
            //Если энергия попадает в разрыв, то устанавливаем значение в нижнуюю границу разрыва
            return scale_with_breaks($n_break + 1, $energy, $breaks[$n_break]['l1']);
        else return scale_with_breaks($n_break + 1, $energy, $val);
    }
    else return round($diagram_h - (($val*$graph_y) / ($energy_limit - $sum_breaks)));
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
    if (strpos($val, '{') !== false){
        if (strpos($val, '@') !== false) return create_indexes(substr($val, 0, strpos($val, '@')))
            . '<tspan class="index" dy="' . (-$index_dy) . '" dx="' . (-$index_dx) . '">'
            . substr($val, strpos($val,  '{') + 1, strpos($val, '}') - strpos($val,  '{') - 1)
            . '</tspan>'
            . '<tspan dy="' . $index_dy . '" dx="' . (-$index_dx) .'">'
            .  create_indexes(substr($val, strpos($val, '}') + 1))
            . '</tspan>';
        else return substr($val, 0, strpos($val, '~'))
            . '<tspan class="index" dx="' . (-$index_dx) . '" dy="' . (2*$index_dy) . '">'
            . substr($val, strpos($val,  '{') + 1, strpos($val, '}') - strpos($val,  '{') - 1)
            . '</tspan>'
            . '<tspan dx="' . (-$index_dx) . '" dy="' . (-$index_dy) . '">'
            . create_indexes(substr($val, strpos($val, '}') + 1))
            . '</tspan>';
    }
    else return $val;
}

/*Xml2Array recursive parser*/
function parseNode($node, &$arrayElement, $assocs = null){
    if ($node->hasAttributes())
        foreach ($node->attributes as $attribute)
            $arrayElement[$attribute->nodeName] = $attribute->nodeValue;
    if ($node->hasChildNodes()) {
        foreach ($node->childNodes as $childNode) {
            $childArrayElement = [];
            parseNode($childNode, $childArrayElement, $assocs);
            if (isset($childNode->tagName) && in_array($childNode->tagName, $assocs))
                $arrayElement[$childNode->tagName] = $childArrayElement;
            elseif (isset($childNode->tagName)) $arrayElement[$childNode->tagName][] = $childArrayElement;
            else $arrayElement[] = $childArrayElement;
        }
    }
}

if(isset($_GET['element_id'])) {
    $element_id = $_GET['element_id'];
    $element = new Atom();
    $element->GetXML($element_id);
    $elemxml = $element->GetAllProperties();
    $xml = new DOMDocument;
    $xml->loadXML($elemxml['XML']);
    $xpath = new DOMXPath($xml);

    $diagramArray = [];
    $DOM_diagram = $xml->getElementsByTagName('Diagram')->item(0);
    $assocs = ["Diagram", "Levels", "Lines", "limits", "breaks"];

    parseNode($xml, $diagramArray, $assocs);
    //print_r($diagramArray);
    $atom = new Atom();
    $atom->Load($element_id);
    $atom_data = $atom->GetAllProperties();
    $abbr = $atom_data['ABBR'] .
        (($atom_data['ABBR'] != 'H' && $atom_data['ABBR'] != 'D' && $atom_data['ABBR'] != 'T') ?
            " " . numberToRoman(intval($atom_data['IONIZATION']) + 1) : "");

    $levelList = new LevelList();
    $diagramArray2 = $levelList->LoadGrouped($element_id);
    $transitionList = new TransitionList();
    $lines = $transitionList->LoadForDiagram($element_id);

    $breaks = [];
    foreach($xml->getElementsByTagName('break') as $DOM_break){
        $l1 = $DOM_break->getElementsByTagName('l1')->item(0);
        $l2 = $DOM_break->getElementsByTagName('l2')->item(0);
        $breaks[] = ['l1' => $l1->nodeValue, 'l2' => $l2->nodeValue];
    }

    $n_breaks = $xpath->evaluate("count(//break)");
    $sum_breaks = $xpath->evaluate("sum(//break/l2) - sum(//break/l1)");
    $n_limits = $xpath->evaluate("count(//limit)");
    $energy_limit = $xpath->evaluate("number(//limit[@id='l1'])");
    $energy_limit_last = $xpath->evaluate("number(//limit[last()])");//здесь подозрительное место, а если вначале идет l2 а потом l1?
    $n_labels = 5;
    $toeV = 0.00012398;
    $Ecm_row_w = 50;
    $index_dy = 5;
    $index_dx = 1;
    $level_dx = 5;
    $diagram_w = 1000;
    $diagram_h = 700;
    $term_row_w = 30;
    $term_row_h = 80;
    $conf_row_h = 100;//150
    $dE = round(($energy_limit - $sum_breaks)/($n_labels*100))*100;

    $core_row_h =  0;
    foreach($diagramArray2['Diagram']['Levels']['column'] as $column)
        foreach($column['atomiccore'] as $atomiccore)
            if ($atomiccore['ATOMICCORE'] != "") {
                $core_row_h = 50;
                break 2;
            }
    //print_r($core_row_h);

    $graph_y = $diagram_h - $core_row_h - $conf_row_h - $term_row_h;

    $n_terms = 0;
    foreach($diagramArray2['Diagram']['Levels']['column'] as $column)
        foreach($column['atomiccore'] as $atomiccore)
            foreach($atomiccore['term'] as $term)
                foreach($term['group'] as $group)
                    $n_terms++;
   // print_r($n_terms);

    $t_width = $term_row_w * $n_terms;
    $t_height = $diagram_h + 2;
    //print_r($diagramArray2);

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
            class="Ecm" x="<?=$Ecm_row_w - 1?>" y="<?=$diagram_h - $graph_y?>"><?=$energy_limit?></text>

        <!-- for view level energy -->
        <?foreach ($diagramArray2['Diagram']['Levels']['column'] as $column){
            foreach($column['atomiccore'] as $atomiccore) {
                foreach ($atomiccore['term'] as $term) {
                    foreach ($term['group'] as $group) {
                        foreach ($group['level'] as $level) { ?>
                            <line class="energy" id="lbl_<?= $level['id'] ?>" x1="<?= $Ecm_row_w - 1 ?>"
                                  x2="<?= $Ecm_row_w + 3 ?>" display="none"
                                  y1="<?= convert_energy($level['energy']) ?>"
                                  y2="<?= convert_energy($level['energy']) ?>">
                            </line>
                            <text class="Ecml" id="txt_lbl_<?= $level['id'] ?>" x="<?= $Ecm_row_w - 1 ?>" display="none"
                                  y="<?= convert_energy($level['energy']) ?>"><?= round($level['energy'], 1) ?></text>
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
                  y="<?=$diagram_h - $graph_y - 0.5*$term_row_h?>"><?=$energy_limit_last?></text>
        <?}?>
        <!-- Устанавливаем рызрывы на шкалу -->
        <?foreach($breaks as $break){?>
            <text class="break" x="<?=$Ecm_row_w?>" y="<?=convert_energy($break['l1'])?>">~<tspan
                dy="-4" dx="-15">~</tspan></text>
        <?}?>
        <!-- Устанавливаем метки по шкале энергий -->
        <?set_labels($Ecm_row_w, -1, 'Ecm', 1, 1, $dE);?>
    </g>
    <g class="Data" transform="translate(<?=$Ecm_row_w?>, 0)">
        <?$n_col = 0;
        $translate = 0;
        foreach ($diagramArray2['Diagram']['Levels']['column'] as $column){
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
                   <g class="term" prefix="<?=$term['TERMPREFIX']?>" parity="<?=$term['TERMPARITY']?>"><?
                   foreach ($term['group'] as $group){
                       $n_term++;
                       $child_x = ($n_term-0.5) * $term_row_w + $core_x;
                       $n_levels_in_term = 0;
                       foreach($group['level'] as $level)
                           $n_levels_in_term++;
                       ?><rect x="<?=($n_term-1)*$term_row_w + $core_x + $dx?>" y="<?=$conf_row_h+$core_row_h?>" width="<?=$term_row_w?>" id="recTerm_<?=$n_term?>"
                             L="<?=$group['TERMR']?>"
                             prefix="<?=$term['TERMPREFIX']?>"
                             parity="<?=$term['TERMPARITY']?>"
                             j="<?=$group['JJ']?>"
                             n_levels="<?=$n_levels_in_term?>"
                           <?
                           if ($n_limits==1){?>
                               height="<?=$term_row_h?>"
                               <?if ($group['level'][0]['energy'] > $energy_limit){?> info="no" <?}
                           }
                           if ($n_limits > 1){
                               if ($group['level'][count($group['level'])-1]['energy'] > $energy_limit) {?>
                                   height="<?=$term_row_h * 0.5?>" type="auto"
                               <?} else{?> height="<?=$term_row_h?>" <?}
                           }
                           ?>
                       ></rect>
                       <text class="config" x="<?=$child_x + $dx?>" type="full"
                            <?if ($n_limits == 1){?>
                                y="<?=0.5*$term_row_h + $core_row_h + $conf_row_h?>"
                            <?}elseif ($group['level'][count($group['level'])-1]['energy'] > $energy_limit){?>
                                y="<?=0.25*$term_row_h + $core_row_h + $conf_row_h?>"
                            <?}else{?>
                                y="<?=0.5*$term_row_h + $core_row_h + $conf_row_h?>"
                            <?}?>
                            rec_id="recTerm_<?=$n_term?>"><?=$group['TERMSEQ']?><tspan class="index" dx="<?=-$index_dx?>"
                            dy="<?=-$index_dy?>"><?=$term['TERMPREFIX']?></tspan><tspan dx="<?=-$index_dx?>"
                            dy="<?=$index_dy?>"><?=create_indexes($group['TERMR'])?></tspan><?if ($term['TERMPARITY'] != ''){?><tspan class="index"
                          dx="<?=-$index_dx?>" dy="<?=-$index_dy?>">o</tspan><tspan class="index"
                       dx="<?=-$index_dy?>" dy="<?=2*$index_dy?>"><?=$group['JJ']?></tspan><?}else{?><tspan class="index"
                       dx="<?=-$index_dx?>" dy="<?=$index_dy?>"><?=$group['JJ']?></tspan><?}?></text>
                       <g class="levels"><line class="level" x1="<?=$child_x + $dx?>" x2="<?=$child_x + $dx?>"
                               y2="<?=convert_energy($group['level'][0]['energy'])?>"
                           <?if ($n_limits == 1){?>
                               y1="<?=convert_energy($energy_limit)?>"
                           <?}elseif ($group['level'][count($group['level'])-1]['energy'] > $energy_limit){?>
                               y1="<?=convert_energy($energy_limit_last)?>"
                           <?}else{?>
                               y1="<?=convert_energy($energy_limit)?>"
                           <?}?>
                           ></line>
                       <?foreach($group['level'] as $level){?>
                           <line class="level" energy="<?=$level['energy']?>" onmouseover="mouse_on_level(evt, this)" onmouseout="mouse_out_level(evt, this)"
                                     config="<?=$level['CONFIG']?>" j="<?=$level['JJ']?>"
                                     id="<?=$level['id']?>"
                                     y1="<?=convert_energy($level['energy'])?>"
                                     y2="<?=convert_energy($level['energy'])?>"
                                     x1="<?=$child_x - $level_dx + $dx?>"
                                     x2="<?=$child_x + $level_dx + $dx?>"
                                     <?if($level['long'] == 1){?>long="1"<?}?>
                           ></line>
                           <text class="namelevel" id="conf_name_<?=$level['id']?>" x="<?=$child_x + $level_dx + $dx?>" display="none"
                                y="<?=convert_energy($level['energy'])?>"
                           ><?=create_indexes($level['CONFIG'])?><?if ($level['JJ'] != ''){?><?if ($level['CONFIG'] != ''){?>, <?}?>j=<?=$level['JJ']?><?}?></text>
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
                class="Eev" x="1" y="<?=$diagram_h - $graph_y?>"><?=round($energy_limit*$toeV, 1)?></text>

            <!-- Кажется рассчитано, максимум на два лимита. Исправить -->
            <?if ($n_limits > 1){ ?>
                <text class="Eev" x="1" y="<?=$diagram_h - $graph_y - 0.5*$term_row_h?>"
                ><?=round($energy_limit_last * $toeV, 1)?></text>
            <?}?>

            <!-- Устанавливаем рызрывы на шкалу -->
            <?foreach($breaks as $break){?>
                <text class="break" x="0" y="<?=convert_energy($break['l1'])?>"
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
    </script>
    <script xmlns:xlink="http://www.w3.org/1999/xlink" type="text/ecmascript" xlink:href="/js/svg.js?v2"></script>
</svg>
<?}?>