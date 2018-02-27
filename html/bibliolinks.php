<?php
header('Content-Type: text/html; charset=windows-1251');

require_once("configure.php");
//require_once("includes/elementlist.php");
//require_once("includes/atom.php");
require_once("includes/sourcelist.php");

$response = array();
$response['draw'] = intval($_REQUEST['draw']);

$order = "";
if ($_REQUEST['order'][0]['column'] == 1) $order = 'id ' . $_REQUEST['order'][0]['dir'];

$search = "";
if (isset($_REQUEST['columns'][0]['search']['value'])) $search = $_REQUEST['columns'][0]['search']['value'];


$sources = new SourceList;
$sources->LoadPage(intval($_REQUEST['start']), intval($_REQUEST['start']) + intval($_REQUEST['length']), $order, $search);
$assoc_array = $sources->GetItemsArray();
$index_array = array();
for ($i = 0; $i < count($assoc_array); $i++)
{
    $index_array[$i] = array_values($assoc_array[$i]);
}
$response['data'] = $index_array;
$response['recordsTotal'] = $sources->Count();
$response['recordsFiltered'] = $sources->Count($search);


echo json_encode($response);


/*
$elements = new ElementList;
//загружаем таблицу элементов с локализованными именами и ст. ионизацией = 0;	
$elements->LoadPereodicTable($l10n->locale,0);
$table=$elements->GetItemsArray();

    $element_id=$_REQUEST['element_id'];

    //»оны
    $ion_list = new ElementList;
    $ion_list->Loadions($element_id);

    //если удаЄтс€ получить массив ионов
    $ions=$ion_list->GetItemsArray();
    if ($ions)	{
        //получаем им€ элемента
        $elname=$ions[0]['ELNAME'];

        //получаем массив типов элементов(из словар€) и загон€ем его в smarty()			

        //берЄм масив данных о элементе и передаЄм его смарти

        $atom = new Atom;
        $atom->Load($element_id);

        $atom_sys = $atom->GetAllProperties();
        $atom_name = $elname;
        if ($atom_name !='H' && $atom_name !='D' && $atom_name !='T' )
            $atom_name .= ' ' . numberToRoman(intval($atom_sys['IONIZATION']) + 1);
        $smarty->assign('atom', $atom_sys);

        $ichi = '1S/'.$elname;
        $ichi .= !empty($atom_sys['IONIZATION']) ? "/q+".$atom_sys['IONIZATION'] : "";
        //$ichi_key = hash('sha256',$ichi);


        $e_count = intval($atom_sys['Z']) - intval($atom_sys['IONIZATION']);

        $transition_list->LoadWithLevels($element_id);
        $transitions = $transition_list->GetItemsArray();
*/
?>