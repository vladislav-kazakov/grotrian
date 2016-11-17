<?
require_once($_SERVER['DOCUMENT_ROOT']."/configure.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/atom.php");

if(isset($_GET['element_id']))
{
	$element_id = $_GET['element_id'];
	$element = new Atom();
	$element->Load($element_id);

	$xml = new DOMDocument;

	$element->GetXML($element_id);
	$elemxml = $element->GetAllProperties();
// 		print_r($elemxml['XML']);
	$xml->loadXML($elemxml['XML']);


	$xsl = new DOMDocument;
	$xsl->load('xmemo_before_lemma.xsl');

	$xsl1 = new DOMDocument;
	$xsl1->load('xmemo_after_lemma.xsl', LIBXML_NOCDATA);

	$proc = new XSLTProcessor(); 
	$xsl = $proc->importStylesheet($xsl); 
	$xml1 = $proc->transformToXML($xml);
	
	$xml2 = new DOMDocument;	
	$xml2->loadXML($xml1);

	$proc1 = new XsltProcessor(); 
	$xsl1 = $proc1->importStylesheet($xsl1); 
	$newdom = $proc1->transformToXML($xml2); 

	header("Content-type:image/svg+xml");
	echo $newdom;
	
}
?>