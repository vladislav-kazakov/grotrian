<?
require_once($_SERVER['DOCUMENT_ROOT']."/configure.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/atom.php");

if(isset($_GET['element_id']))
{
	$element_id = $_GET['element_id'];
	$element = new Atom();
	$element->Load($element_id);

	$xml = new DOMDocument;
 	
	if (!ISLOCAL)
	{
	if ($element_id == 48295)
	{
	$xml->loadXML('<Diagram abbr="Mn I">
  <Levels>
    <column config="3d@{6}ns">
      <atomiccore value="@{5}D">
        <term prefix="6" parity="">
          <group L="D" seq="a" j="9/2">
            <level id="48297" energy="17052.3" j="9/2" long="1" config="4s" />
          </group>
          <group L="D" seq="a" j="7/2">
            <level id="48298" energy="17282" j="7/2" long="1" config="4s" />
          </group>
          <group L="D" seq="a" j="5/2">
            <level id="48299" energy="17451.5" j="5/2" long="1" config="4s" />
          </group>
          <group L="D" seq="a" j="3/2">
            <level id="48300" energy="17568.5" j="3/2" long="1" config="4s" />
          </group>
          <group L="D" seq="a" j="1/2">
            <level id="48301" energy="17637.2" j="1/2" long="1" config="4s" />
          </group>
          <group L="D" seq="i" j="9/2">
            <level id="48522" energy="56189.4" j="9/2" long="" config="5s" />
          </group>
          <group L="D" seq="i" j="7/2">
            <level id="48523" energy="56356.2" j="7/2" long="" config="5s" />
          </group>
          <group L="D" seq="i" j="5/2">
            <level id="48524" energy="56490.8" j="5/2" long="" config="5s" />
          </group>
          <group L="D" seq="i" j="3/2">
            <level id="48525" energy="56567.9" j="3/2" long="" config="5s" />
          </group>
          <group L="D" seq="i" j="1/2">
            <level id="48526" energy="56666.1" j="1/2" long="" config="5s" />
          </group>
        </term>
        <term prefix="4" parity="">
          <group L="D" seq="a" j="7/2">
            <level id="48305" energy="23296.7" j="7/2" long="1" config="4s" />
          </group>
          <group L="D" seq="a" j="5/2">
            <level id="48306" energy="23549.2" j="5/2" long="1" config="4s" />
          </group>
          <group L="D" seq="a" j="3/2">
            <level id="48307" energy="23719.5" j="3/2" long="1" config="4s" />
          </group>
          <group L="D" seq="a" j="1/2">
            <level id="48308" energy="23818.9" j="1/2" long="1" config="4s" />
          </group>
          <group L="D" seq="f" j="7/2">
            <level id="48551" energy="57305.6" j="7/2" long="" config="5s" />
          </group>
          <group L="D" seq="f" j="5/2">
            <level id="48552" energy="57486" j="5/2" long="" config="5s" />
          </group>
          <group L="D" seq="f" j="3/2">
            <level id="48553" energy="57621.9" j="3/2" long="" config="5s" />
          </group>
          <group L="D" seq="f" j="1/2">
            <level id="48554" energy="57705.8" j="1/2" long="" config="5s" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}P2">
        <term prefix="4" parity="">
          <group L="P" seq="b" j="5/2">
            <level id="48326" energy="33825.5" j="5/2" long="1" config="4s" />
          </group>
          <group L="P" seq="b" j="3/2">
            <level id="48327" energy="34463.4" j="3/2" long="1" config="4s" />
          </group>
          <group L="P" seq="b" j="1/2">
            <level id="48328" energy="34845.3" j="1/2" long="1" config="4s" />
          </group>
        </term>
        <term prefix="2" parity="">
          <group L="P" seq="a" j="3/2">
            <level id="48346" energy="37586" j="3/2" long="1" config="4s" />
          </group>
          <group L="P" seq="a" j="1/2">
            <level id="48347" energy="38351.8" j="1/2" long="1" config="4s" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}H">
        <term prefix="4" parity="">
          <group L="H" seq="a" j="13/2">
            <level id="48329" energy="34138.9" j="13/2" long="1" config="4s" />
          </group>
          <group L="H" seq="a" j="11/2">
            <level id="48330" energy="34250.5" j="11/2" long="1" config="4s" />
          </group>
          <group L="H" seq="a" j="9/2">
            <level id="48331" energy="34343.9" j="9/2" long="1" config="4s" />
          </group>
          <group L="H" seq="a" j="7/2">
            <level id="48332" energy="34423.3" j="7/2" long="1" config="4s" />
          </group>
        </term>
        <term prefix="2" parity="">
          <group L="H" seq="a" j="11/2">
            <level id="48348" energy="38008.7" j="11/2" long="1" config="4s" />
          </group>
          <group L="H" seq="a" j="9/2">
            <level id="48349" energy="38120.2" j="9/2" long="1" config="4s" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}F2">
        <term prefix="4" parity="">
          <group L="F" seq="a" j="9/2">
            <level id="48333" energy="34938.7" j="9/2" long="1" config="4s" />
          </group>
          <group L="F" seq="a" j="7/2">
            <level id="48334" energy="35041.4" j="7/2" long="1" config="4s" />
          </group>
          <group L="F" seq="a" j="5/2">
            <level id="48335" energy="35115" j="5/2" long="1" config="4s" />
          </group>
          <group L="F" seq="a" j="3/2">
            <level id="48336" energy="35165.1" j="3/2" long="1" config="4s" />
          </group>
        </term>
        <term prefix="2" parity="">
          <group L="F" seq="a" j="7/2">
            <level id="48350" energy="38669.6" j="7/2" long="1" config="4s" />
          </group>
          <group L="F" seq="a" j="5/2">
            <level id="48351" energy="38934.9" j="5/2" long="1" config="4s" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}G">
        <term prefix="4" parity="">
          <group L="G" seq="b" j="11/2">
            <level id="48342" energy="37420.2" j="11/2" long="1" config="4s" />
          </group>
          <group L="G" seq="b" j="9/2">
            <level id="48343" energy="37630.6" j="9/2" long="1" config="4s" />
          </group>
          <group L="G" seq="b" j="7/2">
            <level id="48344" energy="37737.2" j="7/2" long="1" config="4s" />
          </group>
          <group L="G" seq="b" j="5/2">
            <level id="48345" energy="37789.9" j="5/2" long="1" config="4s" />
          </group>
        </term>
        <term prefix="2" parity="">
          <group L="G" seq="a" j="9/2">
            <level id="48353" energy="41031.5" j="9/2" long="1" config="4s" />
          </group>
          <group L="G" seq="a" j="7/2">
            <level id="48354" energy="41230.3" j="7/2" long="1" config="4s" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{1}I">
        <term prefix="2" parity="">
          <group L="I" seq="b" j="13/2">
            <level id="48361" energy="43053.3" j="13/2" long="1" config="4s" />
          </group>
          <group L="I" seq="b" j="11/2">
            <level id="48362" energy="43139.3" j="11/2" long="1" config="4s" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}4sns">
      <atomiccore value="@{7}S">
        <term prefix="8" parity="">
          <group L="S" seq="e" j="7/2">
            <level id="48352" energy="39431.3" j="7/2" long="" config="5s" />
          </group>
          <group L="S" seq="f" j="7/2">
            <level id="48419" energy="50157.6" j="7/2" long="" config="6s" />
          </group>
          <group L="S" seq="g" j="7/2">
            <level id="48521" energy="56144.2" j="7/2" long="" config="8s" />
          </group>
        </term>
        <term prefix="6" parity="">
          <group L="S" seq="e" j="5/2">
            <level id="48355" energy="41403.9" j="5/2" long="1" config="5s" />
          </group>
          <group L="S" seq="g" j="5/2">
            <level id="48430" energy="50904.7" j="5/2" long="" config="6s" />
          </group>
          <group L="S" seq="h" j="5/2">
            <level id="48481" energy="54460.3" j="5/2" long="" config="7s" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{5}S">
        <term prefix="6" parity="">
          <group L="S" seq="f" j="5/2">
            <level id="48410" energy="49415.3" j="5/2" long="" config="5s" />
          </group>
        </term>
        <term prefix="4" parity="">
          <group L="S" seq="e" j="3/2">
            <level id="48411" energy="49591.5" j="3/2" long="" config="5s" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{5}G">
        <term prefix="4" parity="">
          <group L="G" seq="f" j="11/2">
            <level id="48797" energy="68693" j="11/2" long="" config="5s" />
          </group>
          <group L="G" seq="f" j="9/2">
            <level id="48798" energy="68716.2" j="9/2" long="" config="5s" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}4snd">
      <atomiccore value="@{7}S">
        <term prefix="8" parity="">
          <group L="D" seq="e" j="3/2">
            <level id="48383" energy="46706.1" j="3/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="5/2">
            <level id="48384" energy="46707" j="5/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="7/2">
            <level id="48385" energy="46708.3" j="7/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="9/2">
            <level id="48386" energy="46710.2" j="9/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="11/2">
            <level id="48387" energy="46712.6" j="11/2" long="" config="4d" />
          </group>
          <group L="D" seq="f" j="3/2">
            <level id="48446" energy="52702.5" j="3/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="5/2">
            <level id="48447" energy="52702.5" j="5/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="7/2">
            <level id="48448" energy="52702.5" j="7/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="9/2">
            <level id="48449" energy="52703.1" j="9/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="11/2">
            <level id="48450" energy="52705.2" j="11/2" long="" config="5d" />
          </group>
          <group L="D" seq="g" j="7/2">
            <level id="48495" energy="55374.8" j="7/2" long="" config="6d" />
          </group>
          <group L="D" seq="g" j="9/2">
            <level id="48496" energy="55375.7" j="9/2" long="" config="6d" />
          </group>
          <group L="D" seq="g" j="11/2">
            <level id="48497" energy="55376.7" j="11/2" long="" config="6d" />
          </group>
          <group L="D" seq="h" j="11/2">
            <level id="48535" energy="56801.4" j="11/2" long="" config="7d" />
          </group>
          <group L="D" seq="h" j="3/2">
            <level id="48531" energy="56801.4" j="3/2" long="" config="7d" />
          </group>
          <group L="D" seq="h" j="5/2">
            <level id="48532" energy="56801.4" j="5/2" long="" config="7d" />
          </group>
          <group L="D" seq="h" j="7/2">
            <level id="48533" energy="56801.4" j="7/2" long="" config="7d" />
          </group>
          <group L="D" seq="h" j="9/2">
            <level id="48534" energy="56801.4" j="9/2" long="" config="7d" />
          </group>
        </term>
        <term prefix="6" parity="">
          <group L="D" seq="e" j="9/2">
            <level id="48391" energy="47207.3" j="9/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="7/2">
            <level id="48392" energy="47212.1" j="7/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="5/2">
            <level id="48393" energy="47215.6" j="5/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="3/2">
            <level id="48394" energy="47218.2" j="3/2" long="" config="4d" />
          </group>
          <group L="D" seq="e" j="1/2">
            <level id="48395" energy="47219.6" j="1/2" long="" config="4d" />
          </group>
          <group L="D" seq="f" j="9/2">
            <level id="48451" energy="52726.4" j="9/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="7/2">
            <level id="48452" energy="52730.4" j="7/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="5/2">
            <level id="48453" energy="52733.2" j="5/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="3/2">
            <level id="48454" energy="52735" j="3/2" long="" config="5d" />
          </group>
          <group L="D" seq="f" j="1/2">
            <level id="48455" energy="52735.8" j="1/2" long="" config="5d" />
          </group>
          <group L="D" seq="h" j="9/2">
            <level id="48511" energy="55681.9" j="9/2" long="" config="6d" />
          </group>
          <group L="D" seq="h" j="7/2">
            <level id="48512" energy="55688.1" j="7/2" long="" config="6d" />
          </group>
          <group L="D" seq="h" j="5/2">
            <level id="48513" energy="55690.8" j="5/2" long="" config="6d" />
          </group>
          <group L="D" seq="h" j="3/2">
            <level id="48514" energy="55691.9" j="3/2" long="" config="6d" />
          </group>
          <group L="D" seq="h" j="1/2">
            <level id="48515" energy="55692.4" j="1/2" long="" config="6d" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{5}S">
        <term prefix="6" parity="">
          <group L="D" seq="g" j="9/2">
            <level id="48482" energy="54938.9" j="9/2" long="" config="4d" />
          </group>
          <group L="D" seq="g" j="7/2">
            <level id="48483" energy="54946.6" j="7/2" long="" config="4d" />
          </group>
          <group L="D" seq="g" j="1/2">
            <level id="48484" energy="54949.6" j="1/2" long="" config="4d" />
          </group>
          <group L="D" seq="g" j="5/2">
            <level id="48485" energy="54950.8" j="5/2" long="" config="4d" />
          </group>
          <group L="D" seq="g" j="3/2">
            <level id="48486" energy="54953.2" j="3/2" long="" config="4d" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3p@{6}3d@{7}">
      <atomiccore value="">
        <term prefix="4" parity="">
          <group L="P" seq="e" j="5/2">
            <level id="48438" energy="51638.2" j="5/2" long="" config="" />
          </group>
          <group L="P" seq="e" j="3/2">
            <level id="48439" energy="51718.2" j="3/2" long="" config="" />
          </group>
          <group L="P" seq="e" j="1/2">
            <level id="48440" energy="51787.9" j="1/2" long="" config="" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="?">
      <atomiccore value="?">
        <term prefix="4" parity="">
          <group L="D" seq="e" j="7/2">
            <level id="48527" energy="56462.1" j="7/2" long="" config="" />
          </group>
          <group L="D" seq="e" j="5/2">
            <level id="48528" energy="56561.9" j="5/2" long="" config="" />
          </group>
          <group L="D" seq="e" j="3/2">
            <level id="48529" energy="56601.6" j="3/2" long="" config="" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}4p@{2}">
      <atomiccore value="">
        <term prefix="8" parity="">
          <group L="P" seq="e" j="5/2">
            <level id="48545" energy="57086.3" j="5/2" long="" config="" />
          </group>
          <group L="P" seq="e" j="7/2">
            <level id="48546" energy="57218.2" j="7/2" long="" config="" />
          </group>
          <group L="P" seq="e" j="9/2">
            <level id="48547" energy="57388.9" j="9/2" long="" config="" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{6}4d">
      <atomiccore value="@{5}D">
        <term prefix="6" parity="">
          <group L="F" seq="e" j="11/2">
            <level id="48684" energy="61713.6" j="11/2" long="" config="4d" />
          </group>
          <group L="F" seq="e" j="9/2">
            <level id="48685" energy="62030.2" j="9/2" long="" config="4d" />
          </group>
          <group L="F" seq="e" j="7/2">
            <level id="48686" energy="62294.7" j="7/2" long="" config="4d" />
          </group>
          <group L="F" seq="e" j="5/2">
            <level id="48687" energy="62905.8" j="5/2" long="" config="4d" />
          </group>
          <group L="F" seq="e" j="3/2">
            <level id="48688" energy="63083.2" j="3/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="13/2">
            <level id="48692" energy="62001.1" j="13/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="11/2">
            <level id="48693" energy="62134.4" j="11/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="9/2">
            <level id="48694" energy="62300.6" j="9/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="7/2">
            <level id="48695" energy="62426.5" j="7/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="5/2">
            <level id="48696" energy="62514.6" j="5/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="3/2">
            <level id="48697" energy="62573.1" j="3/2" long="" config="4d" />
          </group>
        </term>
        <term prefix="4" parity="">
          <group L="G" seq="e" j="11/2">
            <level id="48698" energy="62295.4" j="11/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="9/2">
            <level id="48699" energy="62479" j="9/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="7/2">
            <level id="48700" energy="62632.8" j="7/2" long="" config="4d" />
          </group>
          <group L="G" seq="e" j="5/2">
            <level id="48701" energy="62753.4" j="5/2" long="" config="4d" />
          </group>
          <group L="F" seq="e" j="9/2">
            <level id="48716" energy="63231.4" j="9/2" long="" config="4d" />
          </group>
          <group L="F" seq="e" j="7/2">
            <level id="48717" energy="63424" j="7/2" long="" config="4d" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}4s@{2}">
      <atomiccore value="">
        <term prefix="6" parity="">
          <group L="S" seq="a" j="5/2">
            <level id="48296" energy="0" j="5/2" long="1" config="" />
          </group>
        </term>
        <term prefix="4" parity="">
          <group L="G" seq="a" j="11/2">
            <level id="48312" energy="25265.7" j="11/2" long="1" config="" />
          </group>
          <group L="G" seq="a" j="5/2">
            <level id="48313" energy="25281" j="5/2" long="1" config="" />
          </group>
          <group L="G" seq="a" j="9/2">
            <level id="48314" energy="25285.4" j="9/2" long="1" config="" />
          </group>
          <group L="G" seq="a" j="7/2">
            <level id="48315" energy="25287.7" j="7/2" long="1" config="" />
          </group>
          <group L="P" seq="a" j="5/2">
            <level id="48316" energy="27201.5" j="5/2" long="1" config="" />
          </group>
          <group L="P" seq="a" j="3/2">
            <level id="48317" energy="27248" j="3/2" long="1" config="" />
          </group>
          <group L="P" seq="a" j="1/2">
            <level id="48318" energy="27281.8" j="1/2" long="1" config="" />
          </group>
          <group L="D" seq="b" j="7/2">
            <level id="48319" energy="30354.2" j="7/2" long="1" config="" />
          </group>
          <group L="D" seq="b" j="1/2">
            <level id="48320" energy="30411.7" j="1/2" long="1" config="" />
          </group>
          <group L="D" seq="b" j="5/2">
            <level id="48321" energy="30419.6" j="5/2" long="1" config="" />
          </group>
          <group L="D" seq="b" j="3/2">
            <level id="48322" energy="30425.7" j="3/2" long="1" config="" />
          </group>
        </term>
        <term prefix="2" parity="">
          <group L="I" seq="a" j="11/2">
            <level id="48340" energy="37148.7" j="11/2" long="1" config="" />
          </group>
          <group L="I" seq="a" j="13/2">
            <level id="48341" energy="37164.3" j="13/2" long="1" config="" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(@{2}H)4s4p">
      <atomiccore value="@{3}P@{0}">
        <term prefix="4" parity="0">
          <group L="G" seq="t" j="5/2">
            <level id="48789" energy="67965.5" j="5/2" long="" config="4p" />
          </group>
          <group L="G" seq="t" j="7/2">
            <level id="48788" energy="67891.4" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="t" j="9/2">
            <level id="48787" energy="67819.2" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="t" j="11/2">
            <level id="48786" energy="67752.8" j="11/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(a@{2}G)4s4p">
      <atomiccore value="@{3}P@{0}">
        <term prefix="4" parity="0">
          <group L="H" seq="u" j="13/2">
            <level id="48765" energy="66568.6" j="13/2" long="" config="4p" />
          </group>
          <group L="H" seq="u" j="11/2">
            <level id="48764" energy="66418.6" j="11/2" long="" config="4p" />
          </group>
          <group L="H" seq="u" j="9/2">
            <level id="48763" energy="66356.4" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="u" j="7/2">
            <level id="48762" energy="66334.5" j="7/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="?">
      <atomiccore value="?">
        <term prefix="2" parity="0">






          <group L="I" seq="x" j="11/2">
            <level id="48842" energy="69629.9" j="11/2" long="" config="" />
          </group>
          <group L="I" seq="x" j="13/2">
            <level id="48841" energy="69560.9" j="13/2" long="" config="" />
          </group>
          <group L="K" seq="z" j="13/2">
            <level id="48801" energy="68842.5" j="13/2" long="" config="" />
          </group>
          <group L="K" seq="z" j="15/2">
            <level id="48800" energy="68797.6" j="15/2" long="" config="" />
          </group>
        </term>
        <term prefix="" parity="0">
          <group L="(?)" seq="" j="7/2">
            <level id="48750" energy="65305.1" j="7/2" long="" config="" />

          </group>
          <group L="(?)" seq="" j="9/2">
            <level id="48735" energy="64055.4" j="9/2" long="" config="" />
          </group>
          <group L="(?)" seq="" j="5/2">
            <level id="48727" energy="63371.6" j="5/2" long="" config="" />
            <level id="48752" energy="65649.1" j="5/2" long="" config="" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(a@{2}F)4s4p">
      <atomiccore value="@{3}P@{0}">
        <term prefix="2" parity="0">
          <group L="D" seq="" j="5/2">
            <level id="48781" energy="67008.3" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="5/2">
            <level id="48772" energy="66654.3" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="7/2">
            <level id="48771" energy="66600.2" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="w" j="9/2">
            <level id="48742" energy="65262.3" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="w" j="7/2">
            <level id="48741" energy="64649.2" j="7/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="F" seq="" j="9/2">
            <level id="48740" energy="64585.4" j="9/2" long="" config="4p" />
          </group>
          <group L="D" seq="u" j="5/2">
            <level id="48739" energy="64712.9" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="u" j="3/2">
            <level id="48738" energy="64683.9" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="u" j="1/2">
            <level id="48737" energy="64638.7" j="1/2" long="" config="4p" />
          </group>
          <group L="D" seq="u" j="7/2">
            <level id="48736" energy="64409.7" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="11/2">
            <level id="48722" energy="63449.1" j="11/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="9/2">
            <level id="48721" energy="63347.9" j="9/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(@{4}F)4s4p">
      <atomiccore value="@{3}P@{0}">
        <term prefix="4" parity="0">
          <group L="F" seq="" j="7/2">
            <level id="48793" energy="68338.6" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="9/2">
            <level id="48792" energy="68286.4" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="u" j="11/2">
            <level id="48770" energy="66573.6" j="11/2" long="" config="4p" />
          </group>
          <group L="G" seq="u" j="9/2">
            <level id="48769" energy="66522.6" j="9/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="" parity="0">
          <group L="?" seq="" j="7/2">
            <level id="48767" energy="66454.3" j="7/2" long="" config="4p" />
          </group>
          <group L="?" seq="" j="5/2">
            <level id="48766" energy="66395.2" j="5/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="6" parity="0">
          <group L="F" seq="" j="3/2">
            <level id="48731" energy="63583" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="7/2">
            <level id="48730" energy="63546.3" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="5/2">
            <level id="48729" energy="63523" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="9/2">
            <level id="48728" energy="63374.5" j="9/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="7/2">
            <level id="48712" energy="62851.2" j="7/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="3/2">
            <level id="48711" energy="62787.1" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="1/2">
            <level id="48710" energy="62768.2" j="1/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="5/2">
            <level id="48709" energy="62760.7" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="9/2">
            <level id="48708" energy="62670.8" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="11/2">
            <level id="48683" energy="61744" j="11/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="5/2">
            <level id="48682" energy="61727.3" j="5/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="7/2">
            <level id="48681" energy="61711" j="7/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(@{2}I)4s4p">
      <atomiccore value="@{3}P@{0}">
        <term prefix="2" parity="0">
          <group L="I" seq="" j="11/2">
            <level id="48734" energy="64051.9" j="11/2" long="" config="4p" />
          </group>
          <group L="K" seq="" j="13/2">
            <level id="48691" energy="61912.6" j="13/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="I" seq="y" j="11/2">
            <level id="48672" energy="61225.8" j="11/2" long="" config="4p" />
          </group>
          <group L="I" seq="y" j="13/2">
            <level id="48671" energy="61225.6" j="13/2" long="" config="4p" />
          </group>
          <group L="I" seq="y" j="9/2">
            <level id="48670" energy="61211.4" j="9/2" long="" config="4p" />
          </group>
          <group L="I" seq="y" j="15/2">
            <level id="48669" energy="61204.5" j="15/2" long="" config="4p" />
          </group>
          <group L="H" seq="x" j="7/2">
            <level id="48668" energy="60957.2" j="7/2" long="" config="4p" />
          </group>
          <group L="H" seq="x" j="9/2">
            <level id="48667" energy="60955.9" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="x" j="11/2">
            <level id="48666" energy="60933.7" j="11/2" long="" config="4p" />
          </group>
          <group L="H" seq="x" j="13/2">
            <level id="48665" energy="60891.5" j="13/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(a@{2}D)4s4p">
      <atomiccore value="@{3}P@{0}">
        <term prefix="2" parity="0">
          <group L="F" seq="w" j="7/2">
            <level id="48749" energy="64988.2" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="w" j="5/2">
            <level id="48748" energy="64823.1" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="3/2">
            <level id="48733" energy="63845.3" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="5/2">
            <level id="48732" energy="63764.6" j="5/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="F" seq="w" j="9/2">
            <level id="48664" energy="60939" j="9/2" long="" config="4p" />
          </group>
          <group L="F" seq="w" j="7/2">
            <level id="48663" energy="60902.8" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="w" j="5/2">
            <level id="48662" energy="60820.3" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="w" j="3/2">
            <level id="48661" energy="60760.9" j="3/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}4snf">
      <atomiccore value="@{7}S">
        <term prefix="6" parity="0">
          <group L="F" seq="t" j="1/2">
            <level id="48558" energy="57697.2" j="1/2" long="" config="7f" />
          </group>
          <group L="F" seq="t" j="11/2">
            <level id="48563" energy="57697.2" j="11/2" long="" config="7f" />
          </group>
          <group L="F" seq="t" j="3/2">
            <level id="48559" energy="57697.2" j="3/2" long="" config="7f" />
          </group>
          <group L="F" seq="t" j="5/2">
            <level id="48560" energy="57697.2" j="5/2" long="" config="7f" />
          </group>
          <group L="F" seq="t" j="7/2">
            <level id="48561" energy="57697.2" j="7/2" long="" config="7f" />
          </group>
          <group L="F" seq="t" j="9/2">
            <level id="48562" energy="57697.2" j="9/2" long="" config="7f" />
          </group>
          <group L="F" seq="u" j="1/2">
            <level id="48536" energy="56867.1" j="1/2" long="" config="6f" />
          </group>
          <group L="F" seq="u" j="11/2">
            <level id="48541" energy="56867.1" j="11/2" long="" config="6f" />
          </group>
          <group L="F" seq="u" j="3/2">
            <level id="48537" energy="56867.1" j="3/2" long="" config="6f" />
          </group>
          <group L="F" seq="u" j="5/2">
            <level id="48538" energy="56867.1" j="5/2" long="" config="6f" />
          </group>
          <group L="F" seq="u" j="7/2">
            <level id="48539" energy="56867.1" j="7/2" long="" config="6f" />
          </group>
          <group L="F" seq="u" j="9/2">
            <level id="48540" energy="56867.1" j="9/2" long="" config="6f" />
          </group>
          <group L="F" seq="v" j="11/2">
            <level id="48502" energy="55492.7" j="11/2" long="" config="5f" />
          </group>
          <group L="F" seq="v" j="9/2">
            <level id="48501" energy="55492.5" j="9/2" long="" config="5f" />
          </group>
          <group L="F" seq="v" j="7/2">
            <level id="48500" energy="55492.1" j="7/2" long="" config="5f" />
          </group>
          <group L="F" seq="v" j="3/2">
            <level id="48499" energy="55491.9" j="3/2" long="" config="5f" />
          </group>
          <group L="F" seq="v" j="5/2">
            <level id="48498" energy="55491.6" j="5/2" long="" config="5f" />
          </group>
          <group L="F" seq="w" j="5/2">
            <level id="48472" energy="52978" j="5/2" long="" config="4f" />
          </group>
          <group L="F" seq="w" j="3/2">
            <level id="48471" energy="52977.9" j="3/2" long="" config="4f" />
          </group>
          <group L="F" seq="w" j="11/2">
            <level id="48470" energy="52977.9" j="11/2" long="" config="4f" />
          </group>
          <group L="F" seq="w" j="7/2">
            <level id="48469" energy="52977.8" j="7/2" long="" config="4f" />
          </group>
          <group L="F" seq="w" j="9/2">
            <level id="48468" energy="52977.8" j="9/2" long="" config="4f" />
          </group>
        </term>
        <term prefix="8" parity="0">
          <group L="F" seq="y" j="5/2">
            <level id="48510" energy="55499.9" j="5/2" long="" config="5f" />
          </group>
          <group L="F" seq="y" j="3/2">
            <level id="48509" energy="55499.8" j="3/2" long="" config="5f" />
          </group>
          <group L="F" seq="y" j="7/2">
            <level id="48508" energy="55499.5" j="7/2" long="" config="5f" />
          </group>
          <group L="F" seq="y" j="9/2">
            <level id="48507" energy="55499.1" j="9/2" long="" config="5f" />
          </group>
          <group L="F" seq="y" j="11/2">
            <level id="48506" energy="55499.1" j="11/2" long="" config="5f" />
          </group>
          <group L="F" seq="y" j="13/2">
            <level id="48505" energy="55498.5" j="13/2" long="" config="5f" />
          </group>
          <group L="F" seq="z" j="1/2">
            <level id="48461" energy="52974.5" j="1/2" long="" config="4f" />
          </group>
          <group L="F" seq="z" j="11/2">
            <level id="48466" energy="52974.5" j="11/2" long="" config="4f" />
          </group>
          <group L="F" seq="z" j="13/2">
            <level id="48467" energy="52974.5" j="13/2" long="" config="4f" />
          </group>
          <group L="F" seq="z" j="3/2">
            <level id="48462" energy="52974.5" j="3/2" long="" config="4f" />
          </group>
          <group L="F" seq="z" j="5/2">
            <level id="48463" energy="52974.5" j="5/2" long="" config="4f" />
          </group>
          <group L="F" seq="z" j="7/2">
            <level id="48464" energy="52974.5" j="7/2" long="" config="4f" />
          </group>
          <group L="F" seq="z" j="9/2">
            <level id="48465" energy="52974.5" j="9/2" long="" config="4f" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(@{4}D)4s4p">
      <atomiccore value="@{1}P@{0}">
        <term prefix="4" parity="0">
          <group L="D" seq="" j="7/2">
            <level id="48780" energy="66981.3" j="7/2" long="" config="4p" />
          </group>
          <group L="P" seq="" j="5/2">
            <level id="48779" energy="66910.5" j="5/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}P@{0}">
        <term prefix="4" parity="0">
          <group L="P" seq="v" j="5/2">
            <level id="48550" energy="57487.1" j="5/2" long="" config="4p" />
          </group>
          <group L="P" seq="v" j="3/2">
            <level id="48549" energy="57360.7" j="3/2" long="" config="4p" />
          </group>
          <group L="P" seq="v" j="1/2">
            <level id="48548" energy="57228.3" j="1/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="3/2">
            <level id="48489" energy="55279.9" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="5/2">
            <level id="48488" energy="55186.1" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="7/2">
            <level id="48487" energy="55107.5" j="7/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="6" parity="0">
          <group L="D" seq="x" j="3/2">
            <level id="48460" energy="52883.8" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="5/2">
            <level id="48459" energy="52883.8" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="1/2">
            <level id="48458" energy="52883.1" j="1/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="7/2">
            <level id="48457" energy="52870" j="7/2" long="" config="4p" />
          </group>
          <group L="D" seq="x" j="9/2">
            <level id="48456" energy="52758.1" j="9/2" long="" config="4p" />
          </group>
          <group L="P" seq="u" j="7/2">
            <level id="48443" energy="52253.2" j="7/2" long="" config="4p" />
          </group>
          <group L="P" seq="u" j="5/2">
            <level id="48442" energy="52128.6" j="5/2" long="" config="4p" />
          </group>
          <group L="P" seq="u" j="3/2">
            <level id="48441" energy="52015" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="11/2">
            <level id="48429" energy="51169.2" j="11/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="9/2">
            <level id="48428" energy="51100.5" j="9/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="7/2">
            <level id="48427" energy="51014.9" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="5/2">
            <level id="48426" energy="50931.3" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="3/2">
            <level id="48425" energy="50863.5" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="1/2">
            <level id="48424" energy="50818.6" j="1/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(@{4}G)4s4p">
      <atomiccore value="@{1}P@{0}">
        <term prefix="" parity="0">
          <group L="?" seq="" j="7/2">
            <level id="48720" energy="63288.8" j="7/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="H" seq="w" j="11/2">
            <level id="48726" energy="63457.8" j="11/2" long="" config="4p" />
          </group>
          <group L="H" seq="w" j="9/2">
            <level id="48725" energy="63444.6" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="w" j="7/2">
            <level id="48724" energy="63395.4" j="7/2" long="" config="4p" />
          </group>
          <group L="H" seq="w" j="13/2">
            <level id="48723" energy="63363.5" j="13/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="5/2">
            <level id="48715" energy="63139.7" j="5/2" long="" config="4p" />
          </group>
          <group L="G" seq="y" j="5/2">
            <level id="48570" energy="58159.7" j="5/2" long="" config="4p" />
          </group>
          <group L="G" seq="y" j="7/2">
            <level id="48569" energy="58136.7" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="y" j="9/2">
            <level id="48568" energy="58110.2" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="y" j="11/2">
            <level id="48567" energy="58075.1" j="11/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}P@{0}">
        <term prefix="4" parity="0">
          <group L="G" seq="z" j="11/2">
            <level id="48437" energy="51560.9" j="11/2" long="" config="4p" />
          </group>
          <group L="G" seq="z" j="9/2">
            <level id="48436" energy="51546.3" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="z" j="7/2">
            <level id="48435" energy="51530.6" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="z" j="5/2">
            <level id="48434" energy="51515.6" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="3/2">
            <level id="48423" energy="50383.3" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="5/2">
            <level id="48422" energy="50373.2" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="7/2">
            <level id="48421" energy="50359.3" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="9/2">
            <level id="48420" energy="50341.3" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="z" j="13/2">
            <level id="48418" energy="50094.6" j="13/2" long="" config="4p" />
          </group>
          <group L="H" seq="z" j="11/2">
            <level id="48417" energy="50081.3" j="11/2" long="" config="4p" />
          </group>
          <group L="H" seq="z" j="9/2">
            <level id="48416" energy="50072.6" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="z" j="7/2">
            <level id="48415" energy="50065.5" j="7/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="6" parity="0">
          <group L="F" seq="y" j="1/2">
            <level id="48409" energy="48318.1" j="1/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="3/2">
            <level id="48408" energy="48301" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="5/2">
            <level id="48407" energy="48270.9" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="7/2">
            <level id="48406" energy="48226" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="9/2">
            <level id="48405" energy="48168" j="9/2" long="" config="4p" />
          </group>
          <group L="F" seq="y" j="11/2">
            <level id="48404" energy="48021.4" j="11/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(@{4}P)4s4p">
      <atomiccore value="@{1}P@{0}">
        <term prefix="" parity="0">
          <group L="?" seq="" j="3/2">
            <level id="48759" energy="65961.9" j="3/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="S" seq="" j="3/2">
            <level id="48768" energy="66504.9" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="5/2">
            <level id="48758" energy="65946.6" j="5/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}P@{0}">
        <term prefix="4" parity="0">
          <group L="S" seq="z" j="3/2">
            <level id="48480" energy="54218.6" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="7/2">
            <level id="48476" energy="53124" j="7/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="5/2">
            <level id="48475" energy="53109.1" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="3/2">
            <level id="48474" energy="53103.1" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="1/2">
            <level id="48473" energy="53101.3" j="1/2" long="" config="4p" />
          </group>
          <group L="P" seq="x" j="1/2">
            <level id="48433" energy="51552.8" j="1/2" long="" config="4p" />
          </group>
          <group L="P" seq="x" j="3/2">
            <level id="48432" energy="51445.6" j="3/2" long="" config="4p" />
          </group>
          <group L="P" seq="x" j="5/2">
            <level id="48431" energy="51305.3" j="5/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="6" parity="0">
          <group L="P" seq="v" j="3/2">
            <level id="48414" energy="50099" j="3/2" long="" config="4p" />
          </group>
          <group L="P" seq="v" j="5/2">
            <level id="48413" energy="50012.5" j="5/2" long="" config="4p" />
          </group>
          <group L="P" seq="v" j="7/2">
            <level id="48412" energy="49888" j="7/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="9/2">
            <level id="48403" energy="47903.8" j="9/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="7/2">
            <level id="48402" energy="47774.5" j="7/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="5/2">
            <level id="48401" energy="47754" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="3/2">
            <level id="48400" energy="47466.7" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="1/2">
            <level id="48399" energy="47452.2" j="1/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}4snp">
      <atomiccore value="@{5}S">
        <term prefix="6" parity="0">
          <group L="P" seq="" j="">
            <level id="48690" energy="61870.6" j="" long="" config="6p" />
            <level id="48747" energy="64806.7" j="" long="" config="7p" />
            <level id="48782" energy="67102.2" j="" long="" config="9p" />
            <level id="48785" energy="67655.8" j="" long="" config="10p" />
            <level id="48791" energy="68030.4" j="" long="" config="11p" />
            <level id="48794" energy="68306.9" j="" long="" config="12p" />
            <level id="48795" energy="68504.1" j="" long="" config="13p" />
            <level id="48796" energy="68653.6" j="" long="" config="14p" />
            <level id="48799" energy="68769.6" j="" long="" config="15p" />
            <level id="48802" energy="68861.6" j="" long="" config="16p" />
            <level id="48803" energy="68935.8" j="" long="" config="17p" />
            <level id="48804" energy="68996.3" j="" long="" config="18p" />
            <level id="48805" energy="69046.5" j="" long="" config="19p" />
            <level id="48806" energy="69088.5" j="" long="" config="20p" />
            <level id="48807" energy="69123.9" j="" long="" config="21p" />
            <level id="48808" energy="69154.1" j="" long="" config="22p" />
            <level id="48809" energy="69180.1" j="" long="" config="23p" />
            <level id="48810" energy="69202.6" j="" long="" config="24p" />
            <level id="48811" energy="69222.3" j="" long="" config="25p" />
            <level id="48812" energy="69239.4" j="" long="" config="26p" />
            <level id="48813" energy="69254.7" j="" long="" config="27p" />
            <level id="48814" energy="69268.2" j="" long="" config="28p" />
            <level id="48845" energy="69280.2" j="" long="" config="29p" />
            <level id="48815" energy="69290.9" j="" long="" config="30p" />
            <level id="48816" energy="69300.5" j="" long="" config="31p" />
            <level id="48817" energy="69309.2" j="" long="" config="32p" />
            <level id="48818" energy="69317" j="" long="" config="33p" />
            <level id="48819" energy="69324.1" j="" long="" config="34p" />
            <level id="48820" energy="69330.6" j="" long="" config="35p" />
            <level id="48821" energy="69336.5" j="" long="" config="36p" />
            <level id="48822" energy="69341.9" j="" long="" config="37p" />
            <level id="48823" energy="69346.9" j="" long="" config="38p" />
            <level id="48824" energy="69351.6" j="" long="" config="39p" />
            <level id="48825" energy="69355.7" j="" long="" config="40p" />
            <level id="48826" energy="69359.6" j="" long="" config="41p" />
            <level id="48827" energy="69363.2" j="" long="" config="42p" />
            <level id="48828" energy="69366.6" j="" long="" config="43p" />
            <level id="48829" energy="69369.7" j="" long="" config="44p" />
            <level id="48830" energy="69372.6" j="" long="" config="45p" />
            <level id="48831" energy="69375.4" j="" long="" config="46p" />
            <level id="48832" energy="69377.8" j="" long="" config="47p" />
            <level id="48833" energy="69380.2" j="" long="" config="48p" />
            <level id="48834" energy="69382.3" j="" long="" config="49p" />
            <level id="48835" energy="69384.3" j="" long="" config="50p" />
            <level id="48836" energy="69386.1" j="" long="" config="51p" />
            <level id="48837" energy="69387.9" j="" long="" config="52p" />
            <level id="48838" energy="69389.6" j="" long="" config="53p" />
            <level id="48839" energy="69391.2" j="" long="" config="54p" />
            <level id="48840" energy="69392.6" j="" long="" config="55p" />
          </group>
          <group L="P" seq="s" j="7/2">
            <level id="48520" energy="56012.6" j="7/2" long="" config="5p" />
          </group>
          <group L="P" seq="s" j="5/2">
            <level id="48519" energy="56008.2" j="5/2" long="" config="5p" />
          </group>
          <group L="P" seq="s" j="3/2">
            <level id="48518" energy="55996.9" j="3/2" long="" config="5p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="P" seq="" j="3/2">
            <level id="48517" energy="55939.3" j="3/2" long="" config="5p" />
          </group>
          <group L="P" seq="" j="5/2">
            <level id="48516" energy="55924" j="5/2" long="" config="5p" />
          </group>
          <group L="P" seq="w" j="1/2">
            <level id="48494" energy="55457.2" j="1/2" long="" config="5p" />
          </group>
          <group L="P" seq="w" j="5/2">
            <level id="48493" energy="55406" j="5/2" long="" config="5p" />
          </group>
          <group L="P" seq="w" j="3/2">
            <level id="48492" energy="55368.7" j="3/2" long="" config="5p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{7}S">
        <term prefix="6" parity="0">
          <group L="P" seq="" j="">
            <level id="48610" energy="59307.5" j="" long="" config="15p" />
            <level id="48615" energy="59397.3" j="" long="" config="16p" />
            <level id="48621" energy="59470.3" j="" long="" config="17p" />
            <level id="48623" energy="59529.2" j="" long="" config="18p" />
            <level id="48625" energy="59578.4" j="" long="" config="19p" />
            <level id="48631" energy="59619.6" j="" long="" config="20p" />
            <level id="48637" energy="59654.5" j="" long="" config="21p" />
            <level id="48639" energy="59684.3" j="" long="" config="22p" />
            <level id="48640" energy="59709.8" j="" long="" config="23p" />
            <level id="48641" energy="59732" j="" long="" config="24p" />
            <level id="48642" energy="59751.4" j="" long="" config="25p" />
            <level id="48643" energy="59768.4" j="" long="" config="26p" />
            <level id="48644" energy="59783.4" j="" long="" config="27p" />
            <level id="48645" energy="59796.7" j="" long="" config="28p" />
            <level id="48646" energy="59808.6" j="" long="" config="29p" />
            <level id="48647" energy="59819.1" j="" long="" config="30p" />
            <level id="48648" energy="59828.6" j="" long="" config="31p" />
            <level id="48649" energy="59837.3" j="" long="" config="32p" />
            <level id="48650" energy="59845" j="" long="" config="33p" />
            <level id="48651" energy="59852" j="" long="" config="34p" />
            <level id="48652" energy="59858.5" j="" long="" config="35p" />
            <level id="48653" energy="59864.4" j="" long="" config="36p" />
            <level id="48654" energy="59869.7" j="" long="" config="37p" />
            <level id="48655" energy="59874.6" j="" long="" config="38p" />
            <level id="48656" energy="59879" j="" long="" config="39p" />
            <level id="48657" energy="59883.3" j="" long="" config="40p" />
            <level id="48658" energy="59887.1" j="" long="" config="41p" />
          </group>














          <group L="P" seq="" j="3/2">
            <level id="48544" energy="56934.2" j="3/2" long="" config="8p" />
            <level id="48566" energy="57722" j="3/2" long="" config="9p" />
            <level id="48575" energy="58242.2" j="3/2" long="" config="10p" />
            <level id="48584" energy="58600.9" j="3/2" long="" config="11p" />
            <level id="48592" energy="58858.5" j="3/2" long="" config="12p" />
            <level id="48595" energy="59049" j="3/2" long="" config="13p" />
            <level id="48603" energy="59194.3" j="3/2" long="" config="14p" />
          </group>
          <group L="P" seq="" j="5/2">
            <level id="48504" energy="55493.5" j="5/2" long="" config="7p" />
            <level id="48543" energy="56931.1" j="5/2" long="" config="8p" />
            <level id="48565" energy="57719.7" j="5/2" long="" config="9p" />
            <level id="48574" energy="58240.8" j="5/2" long="" config="10p" />
            <level id="48583" energy="58600.3" j="5/2" long="" config="11p" />
            <level id="48591" energy="58858" j="5/2" long="" config="12p" />
            <level id="48596" energy="59049" j="5/2" long="" config="13p" />
            <level id="48604" energy="59194.3" j="5/2" long="" config="14p" />
          </group>
          <group L="P" seq="" j="7/2">
            <level id="48503" energy="55492.4" j="7/2" long="" config="7p" />
            <level id="48542" energy="56926.3" j="7/2" long="" config="8p" />
            <level id="48564" energy="57716.7" j="7/2" long="" config="9p" />
            <level id="48573" energy="58238.8" j="7/2" long="" config="10p" />
            <level id="48582" energy="58598.7" j="7/2" long="" config="11p" />
            <level id="48590" energy="58857" j="7/2" long="" config="12p" />
            <level id="48594" energy="59048.4" j="7/2" long="" config="13p" />
            <level id="48602" energy="59193.8" j="7/2" long="" config="14p" />
          </group>
          <group L="P" seq="t" j="3/2">
            <level id="48479" energy="53311.1" j="3/2" long="" config="6p" />
          </group>
          <group L="P" seq="t" j="5/2">
            <level id="48478" energy="53291.3" j="5/2" long="" config="6p" />
          </group>
          <group L="P" seq="t" j="7/2">
            <level id="48477" energy="53261.1" j="7/2" long="" config="6p" />
          </group>
          <group L="P" seq="w" j="3/2">
            <level id="48398" energy="47782.4" j="3/2" long="" config="5p" />
          </group>
          <group L="P" seq="w" j="5/2">
            <level id="48397" energy="47659.5" j="5/2" long="" config="5p" />
          </group>
          <group L="P" seq="w" j="7/2">
            <level id="48396" energy="47387.6" j="7/2" long="" config="5p" />
          </group>
        </term>
        <term prefix="8" parity="0">
          <group L="P" seq="" j="">
            <level id="48585" energy="58830.7" j="" long="" config="12p" />
            <level id="48593" energy="59029.1" j="" long="" config="13p" />
            <level id="48601" energy="59179.4" j="" long="" config="14p" />
            <level id="48609" energy="59296" j="" long="" config="15p" />
            <level id="48614" energy="59388.5" j="" long="" config="16p" />
            <level id="48616" energy="59462.5" j="" long="" config="17p" />
            <level id="48622" energy="59523.4" j="" long="" config="18p" />
            <level id="48624" energy="59573.8" j="" long="" config="19p" />
            <level id="48628" energy="59615.5" j="" long="" config="20p" />
            <level id="48632" energy="59650.9" j="" long="" config="21p" />
            <level id="48638" energy="59681.2" j="" long="" config="22p" />
          </group>
          <group L="P" seq="" j="7/2">
            <level id="48445" energy="52497.2" j="7/2" long="" config="6p" />
            <level id="48491" energy="55287.6" j="7/2" long="" config="7p" />
            <level id="48530" energy="56755.6" j="7/2" long="" config="8p" />
            <level id="48557" energy="57624.7" j="7/2" long="" config="9p" />
            <level id="48572" energy="58182.2" j="7/2" long="" config="10p" />
            <level id="48581" energy="58561.2" j="7/2" long="" config="11p" />
          </group>
          <group L="P" seq="" j="5/2">
            <level id="48444" energy="52490" j="5/2" long="" config="6p" />
            <level id="48490" energy="55284" j="5/2" long="" config="7p" />
            <level id="48556" energy="57623.3" j="5/2" long="" config="9p" />
            <level id="48571" energy="58182.2" j="5/2" long="" config="10p" />
            <level id="48580" energy="58561.2" j="5/2" long="" config="11p" />
          </group>
          <group L="P" seq="y" j="9/2">
            <level id="48382" energy="46026.8" j="9/2" long="" config="5p" />
          </group>
          <group L="P" seq="y" j="7/2">
            <level id="48381" energy="46000.8" j="7/2" long="" config="5p" />
          </group>
          <group L="P" seq="y" j="5/2">
            <level id="48380" energy="45981.4" j="5/2" long="" config="5p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{6}np">
      <atomiccore value="@{1}I">
        <term prefix="2" parity="0">
          <group L="H" seq="w" j="9/2">
            <level id="48784" energy="67576.8" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="w" j="11/2">
            <level id="48783" energy="67504.9" j="11/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}D">
        <term prefix="4" parity="0">
          <group L="F" seq="u" j="9/2">
            <level id="48778" energy="66855" j="9/2" long="" config="4p" />
          </group>
          <group L="F" seq="u" j="3/2">
            <level id="48777" energy="66840.8" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="u" j="5/2">
            <level id="48776" energy="66837.2" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="u" j="7/2">
            <level id="48775" energy="66783.5" j="7/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="a@{1}G">
        <term prefix="2" parity="0">
          <group L="G" seq="v" j="7/2">
            <level id="48774" energy="66737.8" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="v" j="9/2">
            <level id="48773" energy="66630.9" j="9/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}G">
        <term prefix="" parity="0">
          <group L="?" seq="" j="9/2">
            <level id="48753" energy="65768.8" j="9/2" long="" config="4p" />
          </group>
          <group L="?" seq="" j="7/2">
            <level id="48751" energy="65616.6" j="7/2" long="" config="4p" />
            <level id="48761" energy="66149.1" j="7/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="2" parity="0">
          <group L="F" seq="v" j="5/2">
            <level id="48760" energy="66020.6" j="5/2" long="" config="4p" />
          </group>
          <group L="H" seq="" j="9/2">
            <level id="48719" energy="63548.5" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="" j="11/2">
            <level id="48718" energy="63288.8" j="11/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="H" seq="v" j="7/2">
            <level id="48746" energy="64920.3" j="7/2" long="" config="4p" />
          </group>
          <group L="H" seq="v" j="9/2">
            <level id="48745" energy="64888" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="v" j="11/2">
            <level id="48744" energy="64819.5" j="11/2" long="" config="4p" />
          </group>
          <group L="H" seq="v" j="13/2">
            <level id="48743" energy="64731.9" j="13/2" long="" config="4p" />
          </group>
          <group L="F" seq="v" j="7/2">
            <level id="48707" energy="62505.1" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="v" j="5/2">
            <level id="48706" energy="62487" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="v" j="9/2">
            <level id="48705" energy="62392.8" j="9/2" long="" config="4p" />
          </group>
          <group L="F" seq="v" j="3/2">
            <level id="48704" energy="62390.2" j="3/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="5/2">
            <level id="48676" energy="62075.6" j="5/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="7/2">
            <level id="48675" energy="62034" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="9/2">
            <level id="48674" energy="61714.5" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="11/2">
            <level id="48673" energy="61469.2" j="11/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="a@{3}F">
        <term prefix="2" parity="0">
          <group L="D" seq="y" j="3/2">
            <level id="48714" energy="63114.1" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="y" j="5/2">
            <level id="48713" energy="63081.3" j="5/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="7/2">
            <level id="48680" energy="61785.9" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="" j="9/2">
            <level id="48679" energy="61485.3" j="9/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="7/2">
            <level id="48678" energy="61480.6" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="" j="5/2">
            <level id="48677" energy="61469.7" j="5/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="G" seq="x" j="5/2">
            <level id="48636" energy="59817.7" j="5/2" long="" config="4p" />
          </group>
          <group L="G" seq="x" j="7/2">
            <level id="48635" energy="59784.3" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="x" j="9/2">
            <level id="48634" energy="59731.9" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="x" j="11/2">
            <level id="48633" energy="59652.9" j="11/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="3/2">
            <level id="48608" energy="59416.2" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="5/2">
            <level id="48607" energy="59360.7" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="7/2">
            <level id="48606" energy="59290.1" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="x" j="9/2">
            <level id="48605" energy="59257.4" j="9/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="3/2">
            <level id="48600" energy="59527.9" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="1/2">
            <level id="48599" energy="59527.4" j="1/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="7/2">
            <level id="48598" energy="59339.5" j="7/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="5/2">
            <level id="48597" energy="59116.6" j="5/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}H">
        <term prefix="" parity="0">
          <group L="?" seq="" j="7/2">
            <level id="48755" energy="65876.3" j="7/2" long="" config="4p" />
          </group>
          <group L="?" seq="" j="5/2">
            <level id="48754" energy="65873.4" j="5/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="2" parity="0">
          <group L="H" seq="" j="11/2">
            <level id="48689" energy="61819.1" j="11/2" long="" config="4p" />
          </group>
          <group L="G" seq="z" j="7/2">
            <level id="48660" energy="60739.4" j="7/2" long="" config="4p" />
          </group>
          <group L="G" seq="z" j="9/2">
            <level id="48659" energy="60668.5" j="9/2" long="" config="4p" />
          </group>
          <group L="I" seq="z" j="11/2">
            <level id="48630" energy="59827.9" j="11/2" long="" config="4p" />
          </group>
          <group L="I" seq="z" j="13/2">
            <level id="48629" energy="59617.1" j="13/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="G" seq="v" j="9/2">
            <level id="48757" energy="65908.9" j="9/2" long="" config="4p" />
          </group>
          <group L="G" seq="v" j="11/2">
            <level id="48756" energy="65887.3" j="11/2" long="" config="4p" />
          </group>
          <group L="I" seq="z" j="9/2">
            <level id="48589" energy="58866.7" j="9/2" long="" config="4p" />
          </group>
          <group L="I" seq="z" j="15/2">
            <level id="48588" energy="58852.6" j="15/2" long="" config="4p" />
          </group>
          <group L="I" seq="z" j="11/2">
            <level id="48587" energy="58851.5" j="11/2" long="" config="4p" />
          </group>
          <group L="I" seq="z" j="13/2">
            <level id="48586" energy="58843.4" j="13/2" long="" config="4p" />
          </group>
          <group L="H" seq="y" j="7/2">
            <level id="48579" energy="58519.9" j="7/2" long="" config="4p" />
          </group>
          <group L="H" seq="y" j="9/2">
            <level id="48578" energy="58485.5" j="9/2" long="" config="4p" />
          </group>
          <group L="H" seq="y" j="11/2">
            <level id="48577" energy="58427.3" j="11/2" long="" config="4p" />
          </group>
          <group L="H" seq="y" j="13/2">
            <level id="48576" energy="58338.7" j="13/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="a@{3}P">
        <term prefix="2" parity="0">
          <group L="P" seq="z" j="1/2">
            <level id="48703" energy="62391.1" j="1/2" long="" config="4p" />
          </group>
          <group L="P" seq="z" j="3/2">
            <level id="48702" energy="62354.8" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="3/2">
            <level id="48627" energy="60395.6" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="5/2">
            <level id="48626" energy="59600.3" j="5/2" long="" config="4p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="D" seq="" j="1/2">
            <level id="48620" energy="60142" j="1/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="5/2">
            <level id="48619" energy="60101.7" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="3/2">
            <level id="48618" energy="59989.8" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="" j="7/2">
            <level id="48617" energy="59470.1" j="7/2" long="" config="4p" />
          </group>
          <group L="P" seq="u" j="1/2">
            <level id="48613" energy="59568.3" j="1/2" long="" config="4p" />
          </group>
          <group L="P" seq="u" j="5/2">
            <level id="48612" energy="59480.8" j="5/2" long="" config="4p" />
          </group>
          <group L="P" seq="u" j="3/2">
            <level id="48611" energy="59384.2" j="3/2" long="" config="4p" />
          </group>
          <group L="S" seq="y" j="3/2">
            <level id="48555" energy="57512.1" j="3/2" long="" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{5}D">
        <term prefix="" parity="0">
          <group L="?" seq="" j="">
            <level id="48790" energy="67890" j="" long="" config="6p" />
          </group>
        </term>
        <term prefix="4" parity="0">
          <group L="P" seq="y" j="1/2">
            <level id="48390" energy="47299.3" j="1/2" long="" config="4p" />
          </group>
          <group L="P" seq="y" j="3/2">
            <level id="48389" energy="47154.5" j="3/2" long="" config="4p" />
          </group>
          <group L="P" seq="y" j="5/2">
            <level id="48388" energy="46901.1" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="z" j="1/2">
            <level id="48379" energy="46169.9" j="1/2" long="" config="4p" />
          </group>
          <group L="D" seq="z" j="3/2">
            <level id="48378" energy="46083.9" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="z" j="5/2">
            <level id="48377" energy="45940.9" j="5/2" long="" config="4p" />
          </group>
          <group L="D" seq="z" j="7/2">
            <level id="48376" energy="45754.3" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="z" j="3/2">
            <level id="48372" energy="44814.7" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="z" j="5/2">
            <level id="48371" energy="44696.3" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="z" j="7/2">
            <level id="48370" energy="44523.4" j="7/2" long="1" config="4p" />
          </group>
          <group L="F" seq="z" j="9/2">
            <level id="48369" energy="44288.8" j="9/2" long="1" config="4p" />
          </group>
        </term>
        <term prefix="6" parity="0">
          <group L="P" seq="x" j="3/2">
            <level id="48375" energy="45259.2" j="3/2" long="" config="4p" />
          </group>
          <group L="P" seq="x" j="5/2">
            <level id="48374" energy="45156.1" j="5/2" long="" config="4p" />
          </group>
          <group L="P" seq="x" j="7/2">
            <level id="48373" energy="44993.9" j="7/2" long="" config="4p" />
          </group>
          <group L="F" seq="z" j="1/2">
            <level id="48368" energy="43672.7" j="1/2" long="" config="4p" />
          </group>
          <group L="F" seq="z" j="3/2">
            <level id="48367" energy="43644.4" j="3/2" long="" config="4p" />
          </group>
          <group L="F" seq="z" j="5/2">
            <level id="48366" energy="43595.5" j="5/2" long="" config="4p" />
          </group>
          <group L="F" seq="z" j="7/2">
            <level id="48365" energy="43524.1" j="7/2" long="1" config="4p" />
          </group>
          <group L="F" seq="z" j="9/2">
            <level id="48364" energy="43428.6" j="9/2" long="1" config="4p" />
          </group>
          <group L="F" seq="z" j="11/2">
            <level id="48363" energy="43314.2" j="11/2" long="1" config="4p" />
          </group>
          <group L="D" seq="z" j="1/2">
            <level id="48360" energy="42198.6" j="1/2" long="1" config="4p" />
          </group>
          <group L="D" seq="z" j="3/2">
            <level id="48359" energy="42143.6" j="3/2" long="" config="4p" />
          </group>
          <group L="D" seq="z" j="5/2">
            <level id="48358" energy="42053.7" j="5/2" long="1" config="4p" />
          </group>
          <group L="D" seq="z" j="7/2">
            <level id="48357" energy="41932.6" j="7/2" long="" config="4p" />
          </group>
          <group L="D" seq="z" j="9/2">
            <level id="48356" energy="41789.5" j="9/2" long="1" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
    <column config="3d@{5}(@{6}S)4s4p">
      <atomiccore value="@{1}P@{0}">
        <term prefix="6" parity="0">
          <group L="P" seq="y" j="7/2">
            <level id="48339" energy="35770" j="7/2" long="1" config="4p" />
          </group>
          <group L="P" seq="y" j="5/2">
            <level id="48338" energy="35725.8" j="5/2" long="1" config="4p" />
          </group>
          <group L="P" seq="y" j="3/2">
            <level id="48337" energy="35690" j="3/2" long="1" config="4p" />
          </group>
        </term>
      </atomiccore>
      <atomiccore value="@{3}P@{0}">
        <term prefix="4" parity="0">
          <group L="P" seq="z" j="1/2">
            <level id="48325" energy="31125" j="1/2" long="1" config="4p" />
          </group>
          <group L="P" seq="z" j="3/2">
            <level id="48324" energy="31076.4" j="3/2" long="1" config="4p" />
          </group>
          <group L="P" seq="z" j="5/2">
            <level id="48323" energy="31001.2" j="5/2" long="1" config="4p" />
          </group>
        </term>
        <term prefix="6" parity="0">
          <group L="P" seq="z" j="7/2">
            <level id="48311" energy="24802.3" j="7/2" long="1" config="4p" />
          </group>
          <group L="P" seq="z" j="5/2">
            <level id="48310" energy="24788" j="5/2" long="1" config="4p" />
          </group>
          <group L="P" seq="z" j="3/2">
            <level id="48309" energy="24779.3" j="3/2" long="1" config="4p" />
          </group>
        </term>
        <term prefix="8" parity="0">
          <group L="P" seq="z" j="9/2">
            <level id="48304" energy="18705.4" j="9/2" long="1" config="4p" />
          </group>
          <group L="P" seq="z" j="7/2">
            <level id="48303" energy="18531.6" j="7/2" long="1" config="4p" />
          </group>
          <group L="P" seq="z" j="5/2">
            <level id="48302" energy="18402.5" j="5/2" long="1" config="4p" />
          </group>
        </term>
      </atomiccore>
    </column>
  </Levels>
  <Lines>
    <line id="49234" high_level="48310" low_level="48296" wavelength="4033.06" rating="7" />
    <line id="49235" high_level="48309" low_level="48296" wavelength="4034.48" rating="7" />
    <line id="49232" high_level="48311" low_level="48296" wavelength="4030.75" rating="7" />
    <line id="49299" high_level="48308" low_level="48296" wavelength="4197.17" rating="7" />
    <line id="49407" high_level="48303" low_level="48296" wavelength="5394.68" rating="7" />
    <line id="49412" high_level="48302" low_level="48296" wavelength="5432.55" rating="7" />
    <line id="49425" high_level="48301" low_level="48296" wavelength="5668.28" rating="7" />
    <line id="49426" high_level="48300" low_level="48296" wavelength="5690.43" rating="7" />
    <line id="49427" high_level="48299" low_level="48296" wavelength="5728.57" rating="7" />
    <line id="49432" high_level="48297" low_level="48296" wavelength="5862.69" rating="7" />
    <line id="49430" high_level="48298" low_level="48296" wavelength="5784.76" rating="7" />































    <line id="204637" high_level="48412" low_level="48296" wavelength="2004.49" rating="5" />

    <line id="204638" high_level="48421" low_level="48296" wavelength="1985.74" rating="5" />

    <line id="204639" high_level="48425" low_level="48296" wavelength="1966.05" rating="5" />
    <line id="204640" high_level="48426" low_level="48296" wavelength="1963.43" rating="5" />
    <line id="204641" high_level="48427" low_level="48296" wavelength="1960.21" rating="5" />
    <line id="204642" high_level="48431" low_level="48296" wavelength="1949.12" rating="5" />
    <line id="204643" high_level="48432" low_level="48296" wavelength="1943.80" rating="5" />
    <line id="204644" high_level="48441" low_level="48296" wavelength="1922.52" rating="5" />
    <line id="204645" high_level="48442" low_level="48296" wavelength="1918.33" rating="5" />
    <line id="204646" high_level="48443" low_level="48296" wavelength="1913.76" rating="5" />
    <line id="204647" high_level="48444" low_level="48296" wavelength="1905.13" rating="5" />
    <line id="204648" high_level="48445" low_level="48296" wavelength="1904.86" rating="5" />


    <line id="204649" high_level="48457" low_level="48296" wavelength="1891.43" rating="5" />
    <line id="204650" high_level="48459" low_level="48296" wavelength="1890.94" rating="5" />
    <line id="204651" high_level="48474" low_level="48296" wavelength="1883.13" rating="5" />
    <line id="204652" high_level="48475" low_level="48296" wavelength="1882.92" rating="5" />
    <line id="204653" high_level="48476" low_level="48296" wavelength="1882.39" rating="5" />
    <line id="204654" high_level="48477" low_level="48296" wavelength="1877.55" rating="5" />
    <line id="204655" high_level="48478" low_level="48296" wavelength="1876.48" rating="5" />
    <line id="204656" high_level="48479" low_level="48296" wavelength="1875.78" rating="5" />
    <line id="204657" high_level="48480" low_level="48296" wavelength="1844.39" rating="5" />
    <line id="204658" high_level="48482" low_level="48296" wavelength="1820.20" rating="5" />
    <line id="204659" high_level="48483" low_level="48296" wavelength="1819.95" rating="5" />
    <line id="204660" high_level="48484" low_level="48296" wavelength="1819.85" rating="5" />
    <line id="204661" high_level="48485" low_level="48296" wavelength="1819.81" rating="5" />
    <line id="204662" high_level="48486" low_level="48296" wavelength="1819.73" rating="5" />
    <line id="204663" high_level="48488" low_level="48296" wavelength="1812.05" rating="5" />
    <line id="204664" high_level="48490" low_level="48296" wavelength="1808.84" rating="5" />
    <line id="204665" high_level="48491" low_level="48296" wavelength="1808.72" rating="5" />
    <line id="204666" high_level="48493" low_level="48296" wavelength="1804.86" rating="5" />
    <line id="204667" high_level="48500" low_level="48296" wavelength="1802.05" rating="5" />
    <line id="204668" high_level="48504" low_level="48296" wavelength="1802.01" rating="5" />
    <line id="204669" high_level="48516" low_level="48296" wavelength="1788.14" rating="5" />
    <line id="204670" high_level="48517" low_level="48296" wavelength="1787.65" rating="5" />
    <line id="204671" high_level="48518" low_level="48296" wavelength="1785.81" rating="5" />
    <line id="204672" high_level="48519" low_level="48296" wavelength="1785.45" rating="5" />
    <line id="204673" high_level="48520" low_level="48296" wavelength="1785.31" rating="5" />
    <line id="204674" high_level="48530" low_level="48296" wavelength="1761.94" rating="5" />
    <line id="204675" high_level="48542" low_level="48296" wavelength="1756.66" rating="5" />
    <line id="204676" high_level="48543" low_level="48296" wavelength="1756.51" rating="5" />
    <line id="204677" high_level="48544" low_level="48296" wavelength="1756.41" rating="5" />
    <line id="204678" high_level="48549" low_level="48296" wavelength="1743.35" rating="5" />
    <line id="204679" high_level="48550" low_level="48296" wavelength="1739.52" rating="5" />
    <line id="204680" high_level="48555" low_level="48296" wavelength="1738.77" rating="5" />
    <line id="204681" high_level="48556" low_level="48296" wavelength="1735.41" rating="5" />
    <line id="204682" high_level="48557" low_level="48296" wavelength="1735.37" rating="5" />
    <line id="204683" high_level="48564" low_level="48296" wavelength="1732.60" rating="5" />
    <line id="204684" high_level="48565" low_level="48296" wavelength="1732.51" rating="5" />
    <line id="204685" high_level="48566" low_level="48296" wavelength="1732.44" rating="5" />
    <line id="204686" high_level="48571" low_level="48296" wavelength="1718.74" rating="5" />
    <line id="204687" high_level="48573" low_level="48296" wavelength="1717.07" rating="5" />
    <line id="204688" high_level="48574" low_level="48296" wavelength="1717.01" rating="5" />
    <line id="204689" high_level="48575" low_level="48296" wavelength="1716.97" rating="5" />
    <line id="204690" high_level="48580" low_level="48296" wavelength="1707.62" rating="5" />
    <line id="204691" high_level="48582" low_level="48296" wavelength="1706.52" rating="5" />
    <line id="204692" high_level="48583" low_level="48296" wavelength="1706.48" rating="5" />
    <line id="204693" high_level="48584" low_level="48296" wavelength="1706.46" rating="5" />
    <line id="204694" high_level="48585" low_level="48296" wavelength="1699.79" rating="5" />
    <line id="204695" high_level="48590" low_level="48296" wavelength="1699.03" rating="5" />
    <line id="204696" high_level="48591" low_level="48296" wavelength="1699.00" rating="5" />
    <line id="204697" high_level="48592" low_level="48296" wavelength="1698.99" rating="5" />
    <line id="204698" high_level="48593" low_level="48296" wavelength="1694.08" rating="5" />
    <line id="204699" high_level="48594" low_level="48296" wavelength="1693.53" rating="5" />
    <line id="204700" high_level="48595" low_level="48296" wavelength="1693.51" rating="5" />
    <line id="204701" high_level="48597" low_level="48296" wavelength="1691.57" rating="5" />
    <line id="204702" high_level="48601" low_level="48296" wavelength="1689.78" rating="5" />
    <line id="204703" high_level="48602" low_level="48296" wavelength="1689.37" rating="5" />
    <line id="204704" high_level="48603" low_level="48296" wavelength="1689.35" rating="5" />

    <line id="204705" high_level="48606" low_level="48296" wavelength="1686.62" rating="5" />

    <line id="204706" high_level="48609" low_level="48296" wavelength="1686.45" rating="5" />
    <line id="204707" high_level="48610" low_level="48296" wavelength="1686.13" rating="5" />
    <line id="204708" high_level="48598" low_level="48296" wavelength="1685.22" rating="5" />
    <line id="204709" high_level="48607" low_level="48296" wavelength="1684.62" rating="5" />
    <line id="204710" high_level="48611" low_level="48296" wavelength="1683.95" rating="5" />
    <line id="204711" high_level="48614" low_level="48296" wavelength="1683.83" rating="5" />
    <line id="204712" high_level="48615" low_level="48296" wavelength="1683.58" rating="5" />
    <line id="204713" high_level="48616" low_level="48296" wavelength="1681.73" rating="5" />
    <line id="204714" high_level="48617" low_level="48296" wavelength="1681.51" rating="5" />
    <line id="204715" high_level="48612" low_level="48296" wavelength="1681.22" rating="5" />
    <line id="204716" high_level="48622" low_level="48296" wavelength="1680.01" rating="5" />
    <line id="204717" high_level="48623" low_level="48296" wavelength="1679.85" rating="5" />
    <line id="204718" high_level="48624" low_level="48296" wavelength="1678.59" rating="5" />
    <line id="204719" high_level="48625" low_level="48296" wavelength="1678.46" rating="5" />
    <line id="204720" high_level="48628" low_level="48296" wavelength="1677.42" rating="5" />
    <line id="204721" high_level="48631" low_level="48296" wavelength="1677.30" rating="5" />
    <line id="204722" high_level="48632" low_level="48296" wavelength="1676.42" rating="5" />
    <line id="204723" high_level="48637" low_level="48296" wavelength="1676.32" rating="5" />
    <line id="204724" high_level="48638" low_level="48296" wavelength="1675.57" rating="5" />
    <line id="204725" high_level="48639" low_level="48296" wavelength="1675.48" rating="5" />
    <line id="204726" high_level="48640" low_level="48296" wavelength="1674.77" rating="5" />
    <line id="204727" high_level="48641" low_level="48296" wavelength="1674.14" rating="5" />
    <line id="204728" high_level="48642" low_level="48296" wavelength="1673.60" rating="5" />
    <line id="204779" high_level="48643" low_level="48296" wavelength="1673.13" rating="5" />
    <line id="204780" high_level="48644" low_level="48296" wavelength="1672.71" rating="5" />
    <line id="204781" high_level="48645" low_level="48296" wavelength="1672.33" rating="5" />
    <line id="204782" high_level="48646" low_level="48296" wavelength="1672.00" rating="5" />
    <line id="204783" high_level="48647" low_level="48296" wavelength="1671.71" rating="5" />
    <line id="204784" high_level="48648" low_level="48296" wavelength="1671.44" rating="5" />
    <line id="204785" high_level="48649" low_level="48296" wavelength="1671.20" rating="5" />
    <line id="204786" high_level="48650" low_level="48296" wavelength="1670.98" rating="5" />
    <line id="204787" high_level="48651" low_level="48296" wavelength="1670.79" rating="5" />
    <line id="204788" high_level="48652" low_level="48296" wavelength="1670.61" rating="5" />
    <line id="204789" high_level="48653" low_level="48296" wavelength="1670.44" rating="5" />
    <line id="204790" high_level="48654" low_level="48296" wavelength="1670.30" rating="5" />
    <line id="204791" high_level="48655" low_level="48296" wavelength="1670.16" rating="5" />
    <line id="204792" high_level="48656" low_level="48296" wavelength="1670.03" rating="5" />
    <line id="204793" high_level="48657" low_level="48296" wavelength="1669.92" rating="5" />
    <line id="204794" high_level="48658" low_level="48296" wavelength="1669.81" rating="5" />











    <line id="204795" high_level="48677" low_level="48296" wavelength="1626.82" rating="5" />
    <line id="204796" high_level="48678" low_level="48296" wavelength="1626.53" rating="5" />

    <line id="204797" high_level="48682" low_level="48296" wavelength="1620.03" rating="5" />
    <line id="204627" high_level="48339" low_level="48296" wavelength="2794.82" rating="5" />
    <line id="204628" high_level="48338" low_level="48296" wavelength="2798.27" rating="5" />
    <line id="48848" high_level="48412" low_level="48296" wavelength="2003.85" rating="5" />
    <line id="48849" high_level="48398" low_level="48296" wavelength="2092.16" rating="5" />
    <line id="48851" high_level="48375" low_level="48296" wavelength="2208.81" rating="5" />
    <line id="48852" high_level="48374" low_level="48296" wavelength="2213.85" rating="5" />
    <line id="48853" high_level="48373" low_level="48296" wavelength="2221.84" rating="5" />
    <line id="48846" high_level="48414" low_level="48296" wavelength="1996.06" rating="5" />
    <line id="48880" high_level="48339" low_level="48296" wavelength="2794.82" rating="5" />
    <line id="48881" high_level="48338" low_level="48296" wavelength="2798.27" rating="5" />
    <line id="48883" high_level="48337" low_level="48296" wavelength="2801.08" rating="5" />
    <line id="48985" high_level="48324" low_level="48296" wavelength="3216.95" rating="5" />
    <line id="48986" high_level="48323" low_level="48296" wavelength="3224.76" rating="5" />
    <line id="204632" high_level="48356" low_level="48298" wavelength="4079.24" rating="4" />
    <line id="204634" high_level="48688" low_level="48360" wavelength="4786.87" rating="4" />
    <line id="204635" high_level="48694" low_level="48365" wavelength="5324.32" rating="4" />





    <line id="204636" high_level="48693" low_level="48364" wavelength="5344.44" rating="4" />











    <line id="49446" high_level="48522" low_level="48356" wavelength="6942.52" rating="4" />
    <line id="49447" high_level="48523" low_level="48358" wavelength="6989.96" rating="4" />










    <line id="49451" high_level="48410" low_level="48337" wavelength="7283.82" rating="4" />
    <line id="49452" high_level="48410" low_level="48338" wavelength="7302.89" rating="4" />
    <line id="49453" high_level="48410" low_level="48339" wavelength="7326.51" rating="4" />
    <line id="49454" high_level="48551" low_level="48369" wavelength="7680.20" rating="4" />
    <line id="49455" high_level="48552" low_level="48370" wavelength="7712.42" rating="4" />
    <line id="49456" high_level="48522" low_level="48363" wavelength="7764.72" rating="4" />
    <line id="49433" high_level="48355" low_level="48309" wavelength="6013.51" rating="4" />
    <line id="49434" high_level="48355" low_level="48310" wavelength="6016.64" rating="4" />
    <line id="49435" high_level="48355" low_level="48311" wavelength="6021.82" rating="4" />
    <line id="49419" high_level="48337" low_level="48300" wavelength="5516.77" rating="4" />
    <line id="49420" high_level="48337" low_level="48301" wavelength="5537.76" rating="4" />
    <line id="49421" high_level="48698" low_level="48369" wavelength="5551.98" rating="4" />
    <line id="49422" high_level="48699" low_level="48370" wavelength="5567.76" rating="4" />
    <line id="49413" high_level="48339" low_level="48299" wavelength="5457.47" rating="4" />
    <line id="49414" high_level="48338" low_level="48299" wavelength="5470.64" rating="4" />
    <line id="49415" high_level="48337" low_level="48299" wavelength="5481.40" rating="4" />
    <line id="49404" high_level="48692" low_level="48363" wavelength="5349.88" rating="4" />

    <line id="49405" high_level="48411" low_level="48323" wavelength="5377.63" rating="4" />
    <line id="49417" high_level="48338" low_level="48300" wavelength="5505.87" rating="4" />
    <line id="49408" high_level="48411" low_level="48324" wavelength="5399.49" rating="4" />
    <line id="49409" high_level="48339" low_level="48298" wavelength="5407.42" rating="4" />
    <line id="49361" high_level="48378" low_level="48308" wavelength="4490.09" rating="4" />
    <line id="49402" high_level="48339" low_level="48297" wavelength="5341.06" rating="4" />
    <line id="49324" high_level="48388" low_level="48307" wavelength="4312.55" rating="4" />
    <line id="49340" high_level="48377" low_level="48305" wavelength="4414.89" rating="4" />
    <line id="49316" high_level="48389" low_level="48307" wavelength="4265.92" rating="4" />
    <line id="49344" high_level="48378" low_level="48306" wavelength="4436.36" rating="4" />


    <line id="49345" high_level="48376" low_level="48305" wavelength="4451.59" rating="4" />





    <line id="49347" high_level="48379" low_level="48307" wavelength="4453.01" rating="4" />
    <line id="49348" high_level="48395" low_level="48309" wavelength="4455.01" rating="4" />
    <line id="49349" high_level="48394" low_level="48309" wavelength="4455.32" rating="4" />
    <line id="49350" high_level="48393" low_level="48309" wavelength="4455.81" rating="4" />
    <line id="49351" high_level="48394" low_level="48310" wavelength="4457.04" rating="4" />
    <line id="49352" high_level="48393" low_level="48310" wavelength="4457.55" rating="4" />












    <line id="49353" high_level="48392" low_level="48310" wavelength="4458.25" rating="4" />
    <line id="49354" high_level="48393" low_level="48311" wavelength="4460.38" rating="4" />
    <line id="49355" high_level="48392" low_level="48311" wavelength="4461.08" rating="4" />
    <line id="49356" high_level="48391" low_level="48311" wavelength="4462.03" rating="4" />
    <line id="49357" high_level="48377" low_level="48306" wavelength="4464.68" rating="4" />
    <line id="49358" high_level="48378" low_level="48307" wavelength="4470.14" rating="4" />
    <line id="49359" high_level="48379" low_level="48308" wavelength="4472.81" rating="4" />
    <line id="49363" high_level="48377" low_level="48307" wavelength="4498.90" rating="4" />
    <line id="49364" high_level="48376" low_level="48306" wavelength="4502.21" rating="4" />
    <line id="49372" high_level="48371" low_level="48305" wavelength="4671.67" rating="4" />




    <line id="49373" high_level="48372" low_level="48306" wavelength="4701.13" rating="4" />



    <line id="49374" high_level="48370" low_level="48305" wavelength="4709.71" rating="4" />

    <line id="49375" high_level="48371" low_level="48306" wavelength="4727.46" rating="4" />
    <line id="49376" high_level="48372" low_level="48307" wavelength="4739.09" rating="4" />
    <line id="49377" high_level="48352" low_level="48302" wavelength="4754.04" rating="4" />
    <line id="49378" high_level="48372" low_level="48308" wavelength="4761.51" rating="4" />
    <line id="49379" high_level="48369" low_level="48305" wavelength="4762.37" rating="4" />

    <line id="49380" high_level="48371" low_level="48307" wavelength="4765.85" rating="4" />
    <line id="49381" high_level="48370" low_level="48306" wavelength="4766.42" rating="4" />
    <line id="49382" high_level="48352" low_level="48303" wavelength="4783.43" rating="4" />
    <line id="49384" high_level="48438" low_level="48323" wavelength="4844.32" rating="4" />


    <line id="49385" high_level="48365" low_level="48305" wavelength="4942.41" rating="4" />
    <line id="49386" high_level="48364" low_level="48305" wavelength="4965.85" rating="4" />
    <line id="49387" high_level="48366" low_level="48306" wavelength="4987.06" rating="4" />
    <line id="49388" high_level="48365" low_level="48306" wavelength="5004.89" rating="4" />
    <line id="49389" high_level="48366" low_level="48307" wavelength="5029.80" rating="4" />
    <line id="49390" high_level="48367" low_level="48308" wavelength="5042.58" rating="4" />
    <line id="49246" high_level="48357" low_level="48298" wavelength="4055.54" rating="4" />
    <line id="49247" high_level="48410" low_level="48309" wavelength="4057.95" rating="4" />

    <line id="49248" high_level="48360" low_level="48300" wavelength="4058.93" rating="4" />
    <line id="49249" high_level="48410" low_level="48310" wavelength="4059.39" rating="4" />
    <line id="49250" high_level="48410" low_level="48311" wavelength="4061.73" rating="4" />





    <line id="49251" high_level="48358" low_level="48299" wavelength="4063.53" rating="4" />
    <line id="49308" high_level="48399" low_level="48308" wavelength="4230.13" rating="4" />
    <line id="49309" high_level="48388" low_level="48305" wavelength="4235.29" rating="4" />
    <line id="49310" high_level="48388" low_level="48305" wavelength="4235.30" rating="4" />
    <line id="49311" high_level="48390" low_level="48307" wavelength="4239.73" rating="4" />
    <line id="49312" high_level="48390" low_level="48308" wavelength="4257.67" rating="4" />


    <line id="49254" high_level="48359" low_level="48300" wavelength="4068.01" rating="4" />
    <line id="49255" high_level="48360" low_level="48301" wavelength="4070.28" rating="4" />
    <line id="49319" high_level="48388" low_level="48306" wavelength="4281.10" rating="4" />
    <line id="49320" high_level="48389" low_level="48308" wavelength="4284.09" rating="4" />
    <line id="49258" high_level="48359" low_level="48301" wavelength="4079.41" rating="4" />
    <line id="49259" high_level="48359" low_level="48301" wavelength="4079.42" rating="4" />
    <line id="49260" high_level="48358" low_level="48300" wavelength="4082.94" rating="4" />
    <line id="49261" high_level="48357" low_level="48299" wavelength="4083.63" rating="4" />
    <line id="49283" high_level="48798" low_level="48370" wavelength="4132.30" rating="4" />




    <line id="49238" high_level="48356" low_level="48297" wavelength="4041.36" rating="4" />
    <line id="49241" high_level="48359" low_level="48299" wavelength="4048.74" rating="4" />
    <line id="49236" high_level="48358" low_level="48298" wavelength="4035.73" rating="4" />


    <line id="49226" high_level="48357" low_level="48297" wavelength="4018.10" rating="4" />







    <line id="49411" high_level="48338" low_level="48298" wavelength="5420.35" rating="4" />





































































































    <line id="49431" high_level="48435" low_level="48331" wavelength="5816.84" rating="3" />



































    <line id="49227" high_level="48489" low_level="48320" wavelength="4020.07" rating="3" />
    <line id="49228" high_level="48489" low_level="48321" wavelength="4021.34" rating="3" />
    <line id="49229" high_level="48488" low_level="48319" wavelength="4025.94" rating="3" />
    <line id="49230" high_level="48418" low_level="48312" wavelength="4026.43" rating="3" />
    <line id="49231" high_level="48417" low_level="48312" wavelength="4028.59" rating="3" />
    <line id="49237" high_level="48487" low_level="48319" wavelength="4038.72" rating="3" />
    <line id="49242" high_level="48634" low_level="48334" wavelength="4049.00" rating="3" />
    <line id="49244" high_level="48635" low_level="48335" wavelength="4052.47" rating="3" />
    <line id="49245" high_level="48636" low_level="48336" wavelength="4055.21" rating="3" />
    <line id="49239" high_level="48633" low_level="48333" wavelength="4045.13" rating="3" />
    <line id="49233" high_level="48417" low_level="48314" wavelength="4031.79" rating="3" />
    <line id="49218" high_level="48493" low_level="48321" wavelength="4001.05" rating="3" />
    <line id="49219" high_level="48493" low_level="48322" wavelength="4002.02" rating="3" />
    <line id="49220" high_level="48705" low_level="48342" wavelength="4003.26" rating="3" />
    <line id="49221" high_level="48492" low_level="48321" wavelength="4007.04" rating="3" />
    <line id="49222" high_level="48492" low_level="48322" wavelength="4008.02" rating="3" />
    <line id="49223" high_level="48611" low_level="48327" wavelength="4011.57" rating="3" />
    <line id="49224" high_level="48761" low_level="48354" wavelength="4011.90" rating="3" />
    <line id="49225" high_level="48630" low_level="48333" wavelength="4016.68" rating="3" />





























    <line id="49284" high_level="48577" low_level="48330" wavelength="4135.03" rating="3" />
    <line id="49285" high_level="48432" low_level="48318" wavelength="4137.27" rating="3" />
    <line id="49286" high_level="48578" low_level="48331" wavelength="4141.06" rating="3" />
    <line id="49287" high_level="48431" low_level="48316" wavelength="4147.56" rating="3" />
    <line id="49288" high_level="48579" low_level="48332" wavelength="4148.79" rating="3" />
    <line id="49289" high_level="48681" low_level="48343" wavelength="4151.59" rating="3" />
    <line id="49290" high_level="48679" low_level="48342" wavelength="4154.22" rating="3" />
    <line id="49291" high_level="48431" low_level="48317" wavelength="4155.57" rating="3" />
    <line id="49292" high_level="48703" low_level="48347" wavelength="4158.69" rating="3" />
    <line id="49293" high_level="48702" low_level="48347" wavelength="4164.98" rating="3" />
    <line id="49294" high_level="48680" low_level="48345" wavelength="4166.19" rating="3" />
    <line id="49295" high_level="48682" low_level="48344" wavelength="4167.22" rating="3" />
    <line id="49296" high_level="48567" low_level="48329" wavelength="4176.60" rating="3" />
    <line id="49297" high_level="48691" low_level="48348" wavelength="4182.24" rating="3" />
    <line id="49298" high_level="48568" low_level="48330" wavelength="4189.98" rating="3" />
    <line id="49262" high_level="48715" low_level="48350" wavelength="4085.47" rating="3" />
    <line id="49263" high_level="48783" low_level="48361" wavelength="4088.56" rating="3" />
    <line id="49264" high_level="48589" low_level="48332" wavelength="4089.93" rating="3" />
    <line id="49265" high_level="48612" low_level="48334" wavelength="4090.59" rating="3" />
    <line id="49266" high_level="48617" low_level="48334" wavelength="4092.38" rating="3" />
    <line id="49267" high_level="48752" low_level="48354" wavelength="4094.05" rating="3" />
    <line id="49268" high_level="48675" low_level="48343" wavelength="4096.63" rating="3" />
    <line id="49269" high_level="48751" low_level="48354" wavelength="4099.51" rating="3" />
    <line id="49270" high_level="48606" low_level="48333" wavelength="4105.38" rating="3" />
    <line id="49271" high_level="48679" low_level="48340" wavelength="4107.86" rating="3" />
    <line id="49272" high_level="48605" low_level="48333" wavelength="4110.90" rating="3" />
    <line id="49273" high_level="48608" low_level="48335" wavelength="4113.87" rating="3" />
    <line id="49274" high_level="48598" low_level="48334" wavelength="4114.38" rating="3" />
    <line id="49275" high_level="48676" low_level="48345" wavelength="4116.50" rating="3" />
    <line id="49276" high_level="48433" low_level="48318" wavelength="4118.99" rating="3" />
    <line id="49277" high_level="48608" low_level="48336" wavelength="4122.36" rating="3" />

    <line id="49278" high_level="48606" low_level="48334" wavelength="4122.76" rating="3" />
    <line id="49279" high_level="48607" low_level="48335" wavelength="4123.28" rating="3" />
    <line id="49280" high_level="48432" low_level="48316" wavelength="4123.57" rating="3" />
    <line id="49281" high_level="48742" low_level="48353" wavelength="4125.81" rating="3" />
    <line id="49282" high_level="48576" low_level="48329" wavelength="4131.12" rating="3" />
    <line id="49321" high_level="48666" low_level="48343" wavelength="4290.07" rating="3" />
    <line id="49322" high_level="48659" low_level="48342" wavelength="4300.19" rating="3" />
    <line id="49323" high_level="48667" low_level="48344" wavelength="4305.67" rating="3" />
    <line id="49256" high_level="48611" low_level="48328" wavelength="4074.00" rating="3" />






    <line id="49257" high_level="48617" low_level="48333" wavelength="4075.25" rating="3" />
    <line id="49313" high_level="48679" low_level="48348" wavelength="4258.35" rating="3" />










    <line id="49314" high_level="48665" low_level="48342" wavelength="4259.33" rating="3" />
    <line id="49315" high_level="48673" low_level="48348" wavelength="4261.28" rating="3" />
    <line id="49252" high_level="48586" low_level="48330" wavelength="4065.07" rating="3" />
    <line id="49253" high_level="48751" low_level="48353" wavelength="4066.35" rating="3" />
    <line id="49300" high_level="48569" low_level="48331" wavelength="4201.77" rating="3" />
    <line id="49301" high_level="48666" low_level="48340" wavelength="4203.13" rating="3" />
    <line id="49302" high_level="48749" low_level="48354" wavelength="4207.94" rating="3" />
    <line id="49303" high_level="48570" low_level="48332" wavelength="4211.75" rating="3" />
    <line id="49304" high_level="48555" low_level="48326" wavelength="4220.61" rating="3" />
    <line id="49305" high_level="48677" low_level="48345" wavelength="4221.82" rating="3" />
    <line id="49306" high_level="48680" low_level="48349" wavelength="4224.32" rating="3" />
    <line id="49307" high_level="48550" low_level="48326" wavelength="4225.07" rating="3" />
    <line id="49391" high_level="48388" low_level="48316" wavelength="5074.79" rating="3" />
    <line id="49392" high_level="48372" low_level="48313" wavelength="5117.93" rating="3" />
    <line id="49393" high_level="48371" low_level="48313" wavelength="5149.16" rating="3" />
    <line id="49394" high_level="48371" low_level="48315" wavelength="5150.93" rating="3" />
    <line id="49395" high_level="48370" low_level="48314" wavelength="5196.59" rating="3" />
    <line id="49396" high_level="48370" low_level="48315" wavelength="5197.22" rating="3" />
    <line id="49397" high_level="48369" low_level="48312" wavelength="5255.33" rating="3" />
    <line id="49398" high_level="48369" low_level="48314" wavelength="5260.77" rating="3" />
    <line id="49399" high_level="48379" low_level="48318" wavelength="5292.87" rating="3" />
    <line id="49400" high_level="48378" low_level="48318" wavelength="5317.09" rating="3" />
    <line id="49401" high_level="48377" low_level="48316" wavelength="5334.87" rating="3" />
    <line id="49383" high_level="48352" low_level="48304" wavelength="4823.52" rating="3" />
    <line id="49365" high_level="48629" low_level="48342" wavelength="4503.87" rating="3" />
    <line id="49366" high_level="48634" low_level="48343" wavelength="4523.35" rating="3" />
    <line id="49367" high_level="48660" low_level="48350" wavelength="4529.80" rating="3" />
    <line id="49368" high_level="48659" low_level="48350" wavelength="4544.41" rating="3" />
    <line id="49369" high_level="48630" low_level="48349" wavelength="4605.37" rating="3" />
    <line id="49370" high_level="48629" low_level="48348" wavelength="4626.53" rating="3" />
    <line id="49371" high_level="48633" low_level="48349" wavelength="4642.80" rating="3" />
    <line id="49360" high_level="48719" low_level="48354" wavelength="4479.39" rating="3" />







    <line id="49346" high_level="48629" low_level="48341" wavelength="4452.52" rating="3" />
    <line id="49317" high_level="48679" low_level="48349" wavelength="4278.67" rating="3" />
    <line id="49318" high_level="48678" low_level="48349" wavelength="4279.54" rating="3" />
    <line id="49341" high_level="48660" low_level="48349" wavelength="4419.77" rating="3" />





    <line id="49342" high_level="48659" low_level="48349" wavelength="4433.68" rating="3" />
    <line id="49343" high_level="48678" low_level="48351" wavelength="4434.20" rating="3" />



    <line id="49325" high_level="48660" low_level="48343" wavelength="4326.14" rating="3" />
    <line id="49326" high_level="48672" low_level="48349" wavelength="4326.74" rating="3" />









    <line id="49327" high_level="48675" low_level="48351" wavelength="4327.96" rating="3" />
    <line id="49328" high_level="48569" low_level="48334" wavelength="4328.66" rating="3" />
    <line id="49329" high_level="48670" low_level="48349" wavelength="4329.43" rating="3" />
    <line id="49330" high_level="48555" low_level="48327" wavelength="4337.42" rating="3" />
    <line id="49331" high_level="48659" low_level="48344" wavelength="4359.63" rating="3" />
    <line id="49332" high_level="48664" low_level="48348" wavelength="4359.82" rating="3" />
    <line id="49333" high_level="48665" low_level="48348" wavelength="4368.87" rating="3" />
    <line id="49334" high_level="48414" low_level="48317" wavelength="4374.95" rating="3" />






    <line id="49335" high_level="48679" low_level="48350" wavelength="4381.71" rating="3" />
    <line id="49336" high_level="48663" low_level="48349" wavelength="4388.08" rating="3" />
    <line id="49337" high_level="48630" low_level="48340" wavelength="4408.09" rating="3" />
    <line id="49338" high_level="48555" low_level="48328" wavelength="4410.50" rating="3" />
    <line id="49339" high_level="48659" low_level="48348" wavelength="4411.86" rating="3" />
    <line id="49403" high_level="48377" low_level="48317" wavelength="5348.13" rating="3" />
    <line id="49362" high_level="48633" low_level="48342" wavelength="4496.63" rating="3" />
    <line id="49410" high_level="48411" low_level="48325" wavelength="5413.69" rating="3" />
    <line id="49418" high_level="48364" low_level="48314" wavelength="5510.19" rating="3" />
    <line id="49406" high_level="48376" low_level="48316" wavelength="5388.54" rating="3" />
    <line id="49416" high_level="48364" low_level="48312" wavelength="5504.22" rating="3" />
    <line id="49423" high_level="48474" low_level="48336" wavelength="5573.01" rating="3" />
    <line id="49424" high_level="48473" low_level="48336" wavelength="5573.68" rating="3" />
    <line id="49428" high_level="48437" low_level="48329" wavelength="5738.29" rating="3" />
    <line id="49429" high_level="48436" low_level="48330" wavelength="5780.19" rating="3" />
    <line id="49436" high_level="48379" low_level="48320" wavelength="6344.15" rating="3" />
    <line id="49437" high_level="48379" low_level="48322" wavelength="6349.78" rating="3" />
    <line id="49438" high_level="48378" low_level="48320" wavelength="6378.98" rating="3" />
    <line id="49439" high_level="48378" low_level="48321" wavelength="6382.19" rating="3" />
    <line id="49440" high_level="48378" low_level="48322" wavelength="6384.67" rating="3" />
    <line id="49441" high_level="48377" low_level="48319" wavelength="6413.95" rating="3" />
    <line id="49442" high_level="48377" low_level="48321" wavelength="6440.97" rating="3" />
    <line id="49443" high_level="48377" low_level="48322" wavelength="6443.50" rating="3" />
    <line id="49444" high_level="48376" low_level="48319" wavelength="6491.69" rating="3" />
    <line id="49445" high_level="48376" low_level="48321" wavelength="6519.37" rating="3" />
    <line id="49457" high_level="48395" low_level="48337" wavelength="8670.92" rating="3" />
    <line id="49458" high_level="48394" low_level="48337" wavelength="8672.06" rating="3" />
    <line id="49459" high_level="48393" low_level="48337" wavelength="8673.97" rating="3" />
    <line id="49460" high_level="48393" low_level="48338" wavelength="8701.05" rating="3" />
    <line id="49461" high_level="48392" low_level="48338" wavelength="8703.76" rating="3" />
    <line id="49462" high_level="48391" low_level="48339" wavelength="8740.93" rating="3" />
    <line id="49463" high_level="48307" low_level="48299" wavelength="15949.69" rating="3" />
    <line id="49464" high_level="48306" low_level="48298" wavelength="15951.73" rating="3" />
    <line id="49465" high_level="48308" low_level="48300" wavelength="15994.63" rating="3" />
    <line id="49466" high_level="48305" low_level="48297" wavelength="16010.03" rating="3" />
    <line id="49467" high_level="48308" low_level="48301" wavelength="16172.31" rating="3" />
    <line id="49468" high_level="48307" low_level="48300" wavelength="16252.97" rating="3" />
    <line id="49469" high_level="48306" low_level="48299" wavelength="16395.20" rating="3" />
    <line id="49470" high_level="48307" low_level="48301" wavelength="16436.47" rating="3" />
    <line id="49471" high_level="48305" low_level="48298" wavelength="16621.48" rating="3" />
    <line id="49472" high_level="48306" low_level="48300" wavelength="16715.83" rating="3" />
    <line id="49473" high_level="48305" low_level="48299" wavelength="17103.53" rating="3" />
    <line id="49474" high_level="48306" low_level="48305" wavelength="395993.00" rating="3" />
    <line id="49475" high_level="48307" low_level="48306" wavelength="587130.00" rating="3" />
    <line id="49476" high_level="48308" low_level="48307" wavelength="1006540.00" rating="3" />
    <line id="49448" high_level="48437" low_level="48342" wavelength="7069.84" rating="3" />
    <line id="49449" high_level="48436" low_level="48343" wavelength="7184.25" rating="3" />
    <line id="49450" high_level="48435" low_level="48344" wavelength="7247.82" rating="3" />










    <line id="204622" high_level="48750" low_level="48354" wavelength="4152.56" rating="3" />








    <line id="204623" high_level="48742" low_level="48354" wavelength="4159.96" rating="3" />
    <line id="204624" high_level="48720" low_level="48353" wavelength="4491.65" rating="3" />
    <line id="204625" high_level="48626" low_level="48346" wavelength="4541.26" rating="3" />
    <line id="204626" high_level="48630" low_level="48348" wavelength="4581.85" rating="3" />
    <line id="204629" high_level="48454" low_level="48309" wavelength="3576.07" rating="2" />
    <line id="204630" high_level="48453" low_level="48309" wavelength="3576.30" rating="2" />
    <line id="204631" high_level="48451" low_level="48311" wavelength="3580.11" rating="2" />


    <line id="49206" high_level="48768" low_level="48355" wavelength="3982.79" rating="2" />
    <line id="49157" high_level="48367" low_level="48299" wavelength="3816.74" rating="2" />
    <line id="49158" high_level="48364" low_level="48298" wavelength="3823.51" rating="2" />
    <line id="49159" high_level="48366" low_level="48299" wavelength="3823.89" rating="2" />
    <line id="49160" high_level="48430" low_level="48309" wavelength="3826.61" rating="2" />
    <line id="49161" high_level="48368" low_level="48300" wavelength="3829.72" rating="2" />
    <line id="49162" high_level="48367" low_level="48300" wavelength="3833.86" rating="2" />
    <line id="49163" high_level="48365" low_level="48299" wavelength="3834.36" rating="2" />
    <line id="49181" high_level="48528" low_level="48323" wavelength="3911.13" rating="2" />
    <line id="49152" high_level="48363" low_level="48297" wavelength="3806.71" rating="2" />
    <line id="49154" high_level="48365" low_level="48298" wavelength="3809.59" rating="2" />
    <line id="49189" high_level="48527" low_level="48323" wavelength="3926.47" rating="2" />








    <line id="49196" high_level="48523" low_level="48323" wavelength="3942.87" rating="2" />
    <line id="48987" high_level="48407" low_level="48298" wavelength="3226.03" rating="2" />
    <line id="48968" high_level="48419" low_level="48303" wavelength="3161.04" rating="2" />
    <line id="48969" high_level="48487" low_level="48306" wavelength="3167.82" rating="2" />











    <line id="48975" high_level="48488" low_level="48307" wavelength="3177.06" rating="2" />
    <line id="48976" high_level="48489" low_level="48308" wavelength="3177.61" rating="2" />
    <line id="48983" high_level="48406" low_level="48297" wavelength="3206.91" rating="2" />
    <line id="48984" high_level="48405" low_level="48297" wavelength="3212.88" rating="2" />
    <line id="48989" high_level="48404" low_level="48297" wavelength="3228.09" rating="2" />
    <line id="48991" high_level="48406" low_level="48298" wavelength="3230.71" rating="2" />
    <line id="48992" high_level="48405" low_level="48298" wavelength="3236.78" rating="2" />
    <line id="48994" high_level="48403" low_level="48297" wavelength="3240.40" rating="2" />
    <line id="48995" high_level="48408" low_level="48299" wavelength="3240.61" rating="2" />
    <line id="49000" high_level="48409" low_level="48300" wavelength="3251.13" rating="2" />
    <line id="49001" high_level="48408" low_level="48300" wavelength="3252.95" rating="2" />
    <line id="49002" high_level="48402" low_level="48297" wavelength="3254.03" rating="2" />
    <line id="49004" high_level="48407" low_level="48300" wavelength="3256.13" rating="2" />
    <line id="49005" high_level="48409" low_level="48301" wavelength="3258.41" rating="2" />
    <line id="49006" high_level="48408" low_level="48301" wavelength="3260.23" rating="2" />
    <line id="48884" high_level="48474" low_level="48299" wavelength="2804.10" rating="2" />
    <line id="48954" high_level="48526" low_level="48309" wavelength="3135.19" rating="2" />
    <line id="48916" high_level="48412" low_level="48297" wavelength="3044.58" rating="2" />
    <line id="48956" high_level="48493" low_level="48306" wavelength="3138.14" rating="2" />
    <line id="48957" high_level="48492" low_level="48306" wavelength="3141.82" rating="2" />

    <line id="48958" high_level="48487" low_level="48305" wavelength="3142.67" rating="2" />



    <line id="48959" high_level="48528" low_level="48310" wavelength="3146.33" rating="2" />
    <line id="48960" high_level="48419" low_level="48302" wavelength="3148.18" rating="2" />
    <line id="48962" high_level="48494" low_level="48307" wavelength="3149.92" rating="2" />
    <line id="48966" high_level="48488" low_level="48306" wavelength="3159.95" rating="2" />











    <line id="48898" high_level="48448" low_level="48302" wavelength="2914.60" rating="2" />
    <line id="48899" high_level="48449" low_level="48303" wavelength="2925.57" rating="2" />
    <line id="48882" high_level="48456" low_level="48297" wavelength="2799.84" rating="2" />
    <line id="48867" high_level="48663" low_level="48306" wavelength="2676.33" rating="2" />
    <line id="48873" high_level="48477" low_level="48297" wavelength="2760.93" rating="2" />
    <line id="48874" high_level="48476" low_level="48297" wavelength="2771.44" rating="2" />
    <line id="48875" high_level="48478" low_level="48298" wavelength="2776.23" rating="2" />
    <line id="48876" high_level="48605" low_level="48305" wavelength="2780.00" rating="2" />
    <line id="48877" high_level="48476" low_level="48298" wavelength="2789.20" rating="2" />
    <line id="48878" high_level="48475" low_level="48298" wavelength="2790.36" rating="2" />
    <line id="48879" high_level="48457" low_level="48297" wavelength="2791.08" rating="2" />
    <line id="48886" high_level="48459" low_level="48298" wavelength="2808.02" rating="2" />
    <line id="48887" high_level="48457" low_level="48298" wavelength="2809.11" rating="2" />
    <line id="48888" high_level="48475" low_level="48300" wavelength="2812.84" rating="2" />
    <line id="48889" high_level="48473" low_level="48300" wavelength="2813.47" rating="2" />
    <line id="48890" high_level="48456" low_level="48298" wavelength="2817.97" rating="2" />

    <line id="48891" high_level="48474" low_level="48301" wavelength="2818.77" rating="2" />
    <line id="48892" high_level="48459" low_level="48299" wavelength="2821.45" rating="2" />
    <line id="48893" high_level="48457" low_level="48299" wavelength="2822.55" rating="2" />





    <line id="48894" high_level="48459" low_level="48300" wavelength="2830.79" rating="2" />


    <line id="48895" high_level="48460" low_level="48301" wavelength="2836.31" rating="2" />
    <line id="48896" high_level="48442" low_level="48299" wavelength="2882.90" rating="2" />















    <line id="48847" high_level="48413" low_level="48297" wavelength="1999.51" rating="2" />
    <line id="48855" high_level="48547" low_level="48303" wavelength="2572.76" rating="2" />
    <line id="48856" high_level="48546" low_level="48302" wavelength="2575.51" rating="2" />
    <line id="48858" high_level="48545" low_level="48303" wavelength="2592.94" rating="2" />
    <line id="48863" high_level="48527" low_level="48302" wavelength="2626.64" rating="2" />
    <line id="48922" high_level="48413" low_level="48298" wavelength="3054.37" rating="2" />
    <line id="48923" high_level="48414" low_level="48299" wavelength="3062.13" rating="2" />
    <line id="48924" high_level="48412" low_level="48298" wavelength="3066.03" rating="2" />

    <line id="48925" high_level="48413" low_level="48299" wavelength="3070.27" rating="2" />
    <line id="48926" high_level="48414" low_level="48300" wavelength="3073.14" rating="2" />
    <line id="48927" high_level="48414" low_level="48301" wavelength="3079.64" rating="2" />
    <line id="48928" high_level="48413" low_level="48300" wavelength="3081.34" rating="2" />
    <line id="48929" high_level="48412" low_level="48299" wavelength="3082.05" rating="2" />







    <line id="49008" high_level="48403" low_level="48298" wavelength="3264.71" rating="2" />
    <line id="49014" high_level="48402" low_level="48298" wavelength="3278.55" rating="2" />
    <line id="49015" high_level="48397" low_level="48298" wavelength="3290.96" rating="2" />
    <line id="49016" high_level="48402" low_level="48299" wavelength="3296.88" rating="2" />
    <line id="49021" high_level="48398" low_level="48300" wavelength="3308.78" rating="2" />
    <line id="49022" high_level="48401" low_level="48300" wavelength="3311.89" rating="2" />






    <line id="49023" high_level="48396" low_level="48298" wavelength="3320.69" rating="2" />
    <line id="49024" high_level="48400" low_level="48299" wavelength="3330.69" rating="2" />
    <line id="48997" high_level="48407" low_level="48299" wavelength="3243.78" rating="2" />
    <line id="48998" high_level="48406" low_level="48299" wavelength="3248.52" rating="2" />
    <line id="49026" high_level="48400" low_level="48300" wavelength="3343.72" rating="2" />
    <line id="49028" high_level="48476" low_level="48305" wavelength="3351.67" rating="2" />















    <line id="49047" high_level="48377" low_level="48298" wavelength="3488.32" rating="2" />
    <line id="49048" high_level="48378" low_level="48299" wavelength="3491.55" rating="2" />
    <line id="49050" high_level="48379" low_level="48301" wavelength="3503.74" rating="2" />
    <line id="49051" high_level="48378" low_level="48300" wavelength="3505.87" rating="2" />
    <line id="49056" high_level="48377" low_level="48300" wavelength="3523.54" rating="2" />
    <line id="49057" high_level="48385" low_level="48302" wavelength="3531.85" rating="2" />





    <line id="49059" high_level="48383" low_level="48302" wavelength="3532.12" rating="2" />
    <line id="49062" high_level="48386" low_level="48303" wavelength="3547.80" rating="2" />
    <line id="49063" high_level="48385" low_level="48303" wavelength="3548.03" rating="2" />
    <line id="49064" high_level="48384" low_level="48303" wavelength="3548.20" rating="2" />
    <line id="49069" high_level="48373" low_level="48297" wavelength="3577.87" rating="2" />
    <line id="49070" high_level="48432" low_level="48306" wavelength="3583.68" rating="2" />















    <line id="49071" high_level="48374" low_level="48298" wavelength="3586.54" rating="2" />
    <line id="49072" high_level="48433" low_level="48307" wavelength="3591.80" rating="2" />


    <line id="49073" high_level="48375" low_level="48299" wavelength="3595.11" rating="2" />
    <line id="49075" high_level="48373" low_level="48298" wavelength="3607.53" rating="2" />
    <line id="49076" high_level="48374" low_level="48299" wavelength="3608.48" rating="2" />
    <line id="49077" high_level="48375" low_level="48300" wavelength="3610.29" rating="2" />
    <line id="49053" high_level="48377" low_level="48299" wavelength="3509.07" rating="2" />
    <line id="49054" high_level="48376" low_level="48298" wavelength="3511.18" rating="2" />
    <line id="49079" high_level="48375" low_level="48301" wavelength="3619.28" rating="2" />
    <line id="49080" high_level="48374" low_level="48300" wavelength="3623.78" rating="2" />
    <line id="49082" high_level="48373" low_level="48299" wavelength="3629.73" rating="2" />
    <line id="49084" high_level="48370" low_level="48297" wavelength="3639.14" rating="2" />
    <line id="49089" high_level="48372" low_level="48299" wavelength="3653.50" rating="2" />
    <line id="49096" high_level="48372" low_level="48300" wavelength="3669.18" rating="2" />
    <line id="49097" high_level="48370" low_level="48298" wavelength="3669.83" rating="2" />
    <line id="49098" high_level="48369" low_level="48297" wavelength="3670.50" rating="2" />
    <line id="49101" high_level="48372" low_level="48301" wavelength="3678.46" rating="2" />
    <line id="49086" high_level="48371" low_level="48298" wavelength="3646.69" rating="2" />
    <line id="49105" high_level="48371" low_level="48300" wavelength="3685.20" rating="2" />
    <line id="49107" high_level="48370" low_level="48299" wavelength="3692.81" rating="2" />
    <line id="49109" high_level="48420" low_level="48305" wavelength="3696.54" rating="2" />
    <line id="49111" high_level="48369" low_level="48298" wavelength="3701.72" rating="2" />
    <line id="49124" high_level="48421" low_level="48306" wavelength="3728.88" rating="2" />
    <line id="49122" high_level="48422" low_level="48306" wavelength="3726.94" rating="2" />
    <line id="49129" high_level="48422" low_level="48307" wavelength="3750.76" rating="2" />
    <line id="49133" high_level="48423" low_level="48308" wavelength="3763.37" rating="2" />
    <line id="49134" high_level="48553" low_level="48324" wavelength="3766.05" rating="2" />
    <line id="49131" high_level="48554" low_level="48324" wavelength="3754.18" rating="2" />
    <line id="49140" high_level="48552" low_level="48323" wavelength="3774.68" rating="2" />
    <line id="49142" high_level="48365" low_level="48297" wavelength="3776.53" rating="2" />
    <line id="49143" high_level="48552" low_level="48324" wavelength="3785.43" rating="2" />
    <line id="49145" high_level="48364" low_level="48297" wavelength="3790.21" rating="2" />
    <line id="49147" high_level="48366" low_level="48298" wavelength="3799.25" rating="2" />
    <line id="49148" high_level="48551" low_level="48323" wavelength="3800.56" rating="2" />






    <line id="49165" high_level="48368" low_level="48301" wavelength="3839.82" rating="2" />








    <line id="49166" high_level="48366" low_level="48300" wavelength="3841.07" rating="2" />
    <line id="49167" high_level="48367" low_level="48301" wavelength="3843.98" rating="2" />
    <line id="49168" high_level="48664" low_level="48333" wavelength="3845.02" rating="1" />
    <line id="49169" high_level="48627" low_level="48327" wavelength="3855.11" rating="1" />
    <line id="49170" high_level="48726" low_level="48343" wavelength="3870.78" rating="1" />
    <line id="49171" high_level="48474" low_level="48318" wavelength="3871.68" rating="1" />
    <line id="49172" high_level="48722" low_level="48343" wavelength="3872.09" rating="1" />
    <line id="49173" high_level="48719" low_level="48344" wavelength="3873.18" rating="1" />
    <line id="49174" high_level="48663" low_level="48335" wavelength="3876.70" rating="1" />
    <line id="49175" high_level="48725" low_level="48344" wavelength="3888.83" rating="1" />
    <line id="49176" high_level="48801" low_level="48362" wavelength="3889.46" rating="1" />
    <line id="49177" high_level="48630" low_level="48329" wavelength="3891.61" rating="1" />












    <line id="49178" high_level="48457" low_level="48316" wavelength="3894.73" rating="1" />
    <line id="49179" high_level="48617" low_level="48326" wavelength="3898.34" rating="1" />
    <line id="49180" high_level="48619" low_level="48327" wavelength="3899.31" rating="1" />
    <line id="49149" high_level="48437" low_level="48312" wavelength="3801.90" rating="1" />
    <line id="49150" high_level="48672" low_level="48333" wavelength="3803.07" rating="1" />



    <line id="49151" high_level="48436" low_level="48312" wavelength="3804.02" rating="1" />
    <line id="49146" high_level="48749" low_level="48350" wavelength="3798.51" rating="1" />
    <line id="49144" high_level="48719" low_level="48340" wavelength="3786.83" rating="1" />
    <line id="49141" high_level="48783" low_level="48353" wavelength="3776.30" rating="1" />
    <line id="49132" high_level="48667" low_level="48331" wavelength="3756.64" rating="1" />
    <line id="49135" high_level="48668" low_level="48332" wavelength="3767.69" rating="1" />
    <line id="49136" high_level="48673" low_level="48333" wavelength="3768.18" rating="1" />
    <line id="49137" high_level="48841" low_level="48361" wavelength="3771.43" rating="1" />
    <line id="49138" high_level="48553" low_level="48325" wavelength="3772.95" rating="1" />
    <line id="49139" high_level="48842" low_level="48362" wavelength="3773.86" rating="1" />
    <line id="49130" high_level="48665" low_level="48330" wavelength="3752.55" rating="1" />
    <line id="49123" high_level="48548" low_level="48320" wavelength="3727.98" rating="1" />
    <line id="49125" high_level="48683" low_level="48333" wavelength="3729.54" rating="1" />
    <line id="49126" high_level="48666" low_level="48329" wavelength="3731.00" rating="1" />
    <line id="49127" high_level="48670" low_level="48332" wavelength="3731.93" rating="1" />
    <line id="49128" high_level="48666" low_level="48330" wavelength="3746.61" rating="1" />
    <line id="49112" high_level="48671" low_level="48330" wavelength="3706.08" rating="1" />









    <line id="49113" high_level="48480" low_level="48317" wavelength="3706.68" rating="1" />
    <line id="49114" high_level="48740" low_level="48343" wavelength="3708.86" rating="1" />
    <line id="49115" high_level="48751" low_level="48350" wavelength="3709.93" rating="1" />






    <line id="49116" high_level="48549" low_level="48321" wavelength="3710.74" rating="1" />
    <line id="49117" high_level="48549" low_level="48322" wavelength="3711.58" rating="1" />
















































    <line id="49118" high_level="48675" low_level="48335" wavelength="3713.78" rating="1" />
    <line id="49119" high_level="48734" low_level="48341" wavelength="3718.12" rating="1" />





    <line id="49120" high_level="48672" low_level="48331" wavelength="3718.92" rating="1" />
    <line id="49121" high_level="48670" low_level="48331" wavelength="3720.91" rating="1" />
    <line id="49110" high_level="48480" low_level="48316" wavelength="3700.31" rating="1" />


    <line id="49108" high_level="48669" low_level="48329" wavelength="3693.67" rating="1" />
    <line id="49106" high_level="48673" low_level="48331" wavelength="3685.55" rating="1" />
    <line id="49087" high_level="48744" low_level="48342" wavelength="3648.69" rating="1" />
    <line id="49088" high_level="48706" low_level="48335" wavelength="3652.33" rating="1" />


















    <line id="49102" high_level="48740" low_level="48342" wavelength="3680.13" rating="1" />
    <line id="49103" high_level="48745" low_level="48344" wavelength="3682.09" rating="1" />
    <line id="49104" high_level="48746" low_level="48345" wavelength="3684.85" rating="1" />
    <line id="49099" high_level="48749" low_level="48345" wavelength="3675.66" rating="1" />
    <line id="49100" high_level="48744" low_level="48343" wavelength="3676.92" rating="1" />
    <line id="49090" high_level="48673" low_level="48329" wavelength="3657.90" rating="1" />
    <line id="49091" high_level="48743" low_level="48342" wavelength="3660.40" rating="1" />
    <line id="49092" high_level="48746" low_level="48343" wavelength="3663.34" rating="1" />
    <line id="49093" high_level="48745" low_level="48343" wavelength="3667.69" rating="1" />

    <line id="49094" high_level="48742" low_level="48348" wavelength="3668.20" rating="1" />
    <line id="49095" high_level="48749" low_level="48344" wavelength="3668.55" rating="1" />
    <line id="49085" high_level="48680" low_level="48331" wavelength="3643.01" rating="1" />
    <line id="49083" high_level="48751" low_level="48349" wavelength="3635.80" rating="1" />


    <line id="49081" high_level="48689" low_level="48330" wavelength="3626.29" rating="1" />
    <line id="49055" high_level="48756" low_level="48342" wavelength="3511.83" rating="1" />
    <line id="49078" high_level="48676" low_level="48332" wavelength="3615.31" rating="1" />
    <line id="49074" high_level="48753" low_level="48348" wavelength="3601.26" rating="1" />
    <line id="49065" high_level="48754" low_level="48345" wavelength="3559.80" rating="1" />
    <line id="49066" high_level="48387" low_level="48304" wavelength="3569.49" rating="1" />
    <line id="49067" high_level="48386" low_level="48304" wavelength="3569.80" rating="1" />
    <line id="49060" high_level="48757" low_level="48343" wavelength="3535.27" rating="1" />
    <line id="49061" high_level="48756" low_level="48343" wavelength="3537.97" rating="1" />
    <line id="49052" high_level="48391" low_level="48304" wavelength="3507.53" rating="1" />
    <line id="49049" high_level="48766" low_level="48345" wavelength="3494.86" rating="1" />
    <line id="49029" high_level="48737" low_level="48328" wavelength="3355.48" rating="1" />
    <line id="49030" high_level="48619" low_level="48319" wavelength="3360.67" rating="1" />
    <line id="49031" high_level="48620" low_level="48322" wavelength="3364.19" rating="1" />
    <line id="49032" high_level="48734" low_level="48331" wavelength="3365.13" rating="1" />
    <line id="49033" high_level="48741" low_level="48334" wavelength="3376.51" rating="1" />
    <line id="49034" high_level="48722" low_level="48329" wavelength="3410.80" rating="1" />
    <line id="49035" high_level="48626" low_level="48319" wavelength="3418.27" rating="1" />
    <line id="49036" high_level="48723" low_level="48329" wavelength="3420.79" rating="1" />





    <line id="49037" high_level="48613" low_level="48320" wavelength="3428.78" rating="1" />


















    <line id="49038" high_level="48770" low_level="48342" wavelength="3429.15" rating="1" />
    <line id="49039" high_level="48765" low_level="48342" wavelength="3429.74" rating="1" />
    <line id="49040" high_level="48612" low_level="48321" wavelength="3440.03" rating="1" />
    <line id="49041" high_level="48721" low_level="48331" wavelength="3446.81" rating="1" />
    <line id="49042" high_level="48724" low_level="48332" wavelength="3450.60" rating="1" />
    <line id="49043" high_level="48611" low_level="48321" wavelength="3451.50" rating="1" />
    <line id="49044" high_level="48605" low_level="48319" wavelength="3458.83" rating="1" />
    <line id="49045" high_level="48771" low_level="48344" wavelength="3463.66" rating="1" />
    <line id="49046" high_level="48771" low_level="48345" wavelength="3469.99" rating="1" />
    <line id="49027" high_level="48738" low_level="48328" wavelength="3350.39" rating="1" />
    <line id="48999" high_level="48755" low_level="48335" wavelength="3249.89" rating="1" />
    <line id="49025" high_level="48548" low_level="48317" wavelength="3334.57" rating="1" />
    <line id="49017" high_level="48555" low_level="48316" wavelength="3298.23" rating="1" />
    <line id="49018" high_level="48550" low_level="48316" wavelength="3300.96" rating="1" />
    <line id="49019" high_level="48555" low_level="48317" wavelength="3303.30" rating="1" />
    <line id="49020" high_level="48555" low_level="48318" wavelength="3306.99" rating="1" />
    <line id="49009" high_level="48743" low_level="48329" wavelength="3267.78" rating="1" />
    <line id="49010" high_level="48736" low_level="48326" wavelength="3268.72" rating="1" />
    <line id="49011" high_level="48744" low_level="48330" wavelength="3270.34" rating="1" />
    <line id="49012" high_level="48745" low_level="48331" wavelength="3273.01" rating="1" />
    <line id="49013" high_level="48746" low_level="48332" wavelength="3278.06" rating="1" />
    <line id="48930" high_level="48765" low_level="48329" wavelength="3082.70" rating="1" />
    <line id="48931" high_level="48709" low_level="48321" wavelength="3091.14" rating="1" />
    <line id="48932" high_level="48765" low_level="48330" wavelength="3093.35" rating="1" />
    <line id="48933" high_level="48599" low_level="48317" wavelength="3097.06" rating="1" />
    <line id="48934" high_level="48769" low_level="48330" wavelength="3097.75" rating="1" />
    <line id="48935" high_level="48617" low_level="48316" wavelength="3098.09" rating="1" />
    <line id="48936" high_level="48608" low_level="48316" wavelength="3103.28" rating="1" />
    <line id="48937" high_level="48769" low_level="48331" wavelength="3106.74" rating="1" />
    <line id="48938" high_level="48607" low_level="48316" wavelength="3108.64" rating="1" />
    <line id="48939" high_level="48598" low_level="48316" wavelength="3110.68" rating="1" />
    <line id="48940" high_level="48607" low_level="48317" wavelength="3113.13" rating="1" />
    <line id="48941" high_level="48767" low_level="48331" wavelength="3113.36" rating="1" />
    <line id="48942" high_level="48763" low_level="48330" wavelength="3113.79" rating="1" />
    <line id="48943" high_level="48611" low_level="48318" wavelength="3114.13" rating="1" />
    <line id="48944" high_level="48606" low_level="48316" wavelength="3115.47" rating="1" />
    <line id="48945" high_level="48707" low_level="48321" wavelength="3115.77" rating="1" />
    <line id="48946" high_level="48764" low_level="48331" wavelength="3116.82" rating="1" />
    <line id="48947" high_level="48706" low_level="48321" wavelength="3117.53" rating="1" />
    <line id="48948" high_level="48706" low_level="48322" wavelength="3118.12" rating="1" />
    <line id="48949" high_level="48767" low_level="48332" wavelength="3121.07" rating="1" />
    <line id="48950" high_level="48763" low_level="48331" wavelength="3122.87" rating="1" />
    <line id="48951" high_level="48766" low_level="48332" wavelength="3126.84" rating="1" />
    <line id="48952" high_level="48778" low_level="48333" wavelength="3132.29" rating="1" />
    <line id="48953" high_level="48762" low_level="48332" wavelength="3132.79" rating="1" />
    <line id="48864" high_level="48720" low_level="48313" wavelength="2630.26" rating="1" />
    <line id="48865" high_level="48720" low_level="48314" wavelength="2630.57" rating="1" />
    <line id="48866" high_level="48522" low_level="48304" wavelength="2667.00" rating="1" />
    <line id="48859" high_level="48546" low_level="48304" wavelength="2595.76" rating="1" />
    <line id="48861" high_level="48724" low_level="48313" wavelength="2622.90" rating="1" />
    <line id="48862" high_level="48723" low_level="48312" wavelength="2624.04" rating="1" />
    <line id="48857" high_level="48547" low_level="48304" wavelength="2584.31" rating="1" />
    <line id="48854" high_level="48743" low_level="48312" wavelength="2533.06" rating="1" />
    <line id="48897" high_level="48633" low_level="48312" wavelength="2907.22" rating="1" />
    <line id="48871" high_level="48705" low_level="48312" wavelength="2692.66" rating="1" />
    <line id="48872" high_level="48778" low_level="48319" wavelength="2738.86" rating="1" />
    <line id="48900" high_level="48608" low_level="48313" wavelength="2928.68" rating="1" />
    <line id="48901" high_level="48607" low_level="48315" wavelength="2934.02" rating="1" />
    <line id="48902" high_level="48450" low_level="48304" wavelength="2940.39" rating="1" />
    <line id="48904" high_level="48605" low_level="48312" wavelength="2941.04" rating="1" />
    <line id="48905" high_level="48579" low_level="48313" wavelength="3007.65" rating="1" />
    <line id="48906" high_level="48578" low_level="48314" wavelength="3011.16" rating="1" />
    <line id="48907" high_level="48578" low_level="48315" wavelength="3011.37" rating="1" />
    <line id="48908" high_level="48577" low_level="48312" wavelength="3014.67" rating="1" />
    <line id="48909" high_level="48577" low_level="48314" wavelength="3016.45" rating="1" />
    <line id="48910" high_level="48576" low_level="48312" wavelength="3022.75" rating="1" />
    <line id="48911" high_level="48570" low_level="48313" wavelength="3040.60" rating="1" />
    <line id="48912" high_level="48570" low_level="48315" wavelength="3041.22" rating="1" />
    <line id="48913" high_level="48569" low_level="48313" wavelength="3042.73" rating="1" />
    <line id="48914" high_level="48569" low_level="48314" wavelength="3043.14" rating="1" />
    <line id="48915" high_level="48569" low_level="48315" wavelength="3043.35" rating="1" />
    <line id="48967" high_level="48770" low_level="48333" wavelength="3160.15" rating="1" />

    <line id="48963" high_level="48776" low_level="48335" wavelength="3151.46" rating="1" />
    <line id="48965" high_level="48777" low_level="48336" wavelength="3156.07" rating="1" />
    <line id="48961" high_level="48756" low_level="48329" wavelength="3148.85" rating="1" />
    <line id="48917" high_level="48568" low_level="48314" wavelength="3045.59" rating="1" />
    <line id="48918" high_level="48568" low_level="48315" wavelength="3045.80" rating="1" />












    <line id="48919" high_level="48786" low_level="48333" wavelength="3046.58" rating="1" />
    <line id="48920" high_level="48567" low_level="48312" wavelength="3047.03" rating="1" />
    <line id="48921" high_level="48567" low_level="48314" wavelength="3048.86" rating="1" />
    <line id="48955" high_level="48597" low_level="48317" wavelength="3136.97" rating="1" />
    <line id="48885" high_level="48665" low_level="48312" wavelength="2806.14" rating="1" />
    <line id="49007" high_level="48745" low_level="48330" wavelength="3263.03" rating="1" />
    <line id="49003" high_level="48754" low_level="48336" wavelength="3255.50" rating="1" />
    <line id="48996" high_level="48759" low_level="48335" wavelength="3240.88" rating="1" />
    <line id="48993" high_level="48757" low_level="48334" wavelength="3238.71" rating="1" />
    <line id="48990" high_level="48756" low_level="48333" wavelength="3230.23" rating="1" />
    <line id="48977" high_level="48419" low_level="48304" wavelength="3178.50" rating="1" />
    <line id="48978" high_level="48767" low_level="48335" wavelength="3189.96" rating="1" />




    <line id="48979" high_level="48763" low_level="48334" wavelength="3192.43" rating="1" />









    <line id="48980" high_level="48766" low_level="48336" wavelength="3201.11" rating="1" />
    <line id="48981" high_level="48762" low_level="48335" wavelength="3202.20" rating="1" />
    <line id="48982" high_level="48761" low_level="48333" wavelength="3203.14" rating="1" />







    <line id="48971" high_level="48755" low_level="48331" wavelength="3170.42" rating="1" />






    <line id="48972" high_level="48758" low_level="48327" wavelength="3175.38" rating="1" />
    <line id="48973" high_level="48769" low_level="48334" wavelength="3175.57" rating="1" />
    <line id="48974" high_level="48764" low_level="48333" wavelength="3175.72" rating="1" />

    <line id="48988" high_level="48760" low_level="48334" wavelength="3227.03" rating="1" />
    <line id="49197" high_level="48620" low_level="48328" wavelength="3951.96" rating="1" />
    <line id="49198" high_level="48597" low_level="48326" wavelength="3952.83" rating="1" />
















    <line id="49199" high_level="48718" low_level="48348" wavelength="3954.57" rating="1" />
    <line id="49200" high_level="48618" low_level="48328" wavelength="3975.89" rating="1" />
    <line id="49201" high_level="48626" low_level="48327" wavelength="3977.08" rating="1" />
    <line id="49202" high_level="48617" low_level="48331" wavelength="3978.78" rating="1" />
    <line id="49203" high_level="48761" low_level="48353" wavelength="3980.14" rating="1" />
    <line id="49204" high_level="48613" low_level="48327" wavelength="3982.16" rating="1" />
    <line id="49205" high_level="48423" low_level="48313" wavelength="3982.58" rating="1" />
    <line id="49190" high_level="48726" low_level="48348" wavelength="3928.29" rating="1" />
    <line id="49191" high_level="48635" low_level="48331" wavelength="3929.64" rating="1" />
    <line id="49192" high_level="48719" low_level="48349" wavelength="3931.51" rating="1" />
    <line id="49193" high_level="48633" low_level="48330" wavelength="3935.53" rating="1" />
    <line id="49194" high_level="48636" low_level="48332" wavelength="3936.76" rating="1" />
    <line id="49195" high_level="48634" low_level="48331" wavelength="3937.75" rating="1" />
    <line id="49155" high_level="48434" low_level="48313" wavelength="3810.68" rating="1" />
    <line id="49156" high_level="48434" low_level="48315" wavelength="3811.65" rating="1" />
    <line id="49153" high_level="48435" low_level="48313" wavelength="3808.51" rating="1" />
    <line id="49182" high_level="48627" low_level="48328" wavelength="3912.73" rating="1" />
    <line id="49183" high_level="48526" low_level="48325" wavelength="3914.15" rating="1" />
    <line id="49184" high_level="48633" low_level="48329" wavelength="3918.32" rating="1" />
    <line id="49185" high_level="48774" low_level="48354" wavelength="3919.30" rating="1" />







    <line id="49186" high_level="48720" low_level="48345" wavelength="3920.64" rating="1" />
    <line id="49187" high_level="48634" low_level="48330" wavelength="3923.32" rating="1" />
    <line id="49188" high_level="48529" low_level="48325" wavelength="3924.05" rating="1" />


    <line id="49164" high_level="48749" low_level="48351" wavelength="3837.20" rating="1" />
    <line id="49207" high_level="48422" low_level="48313" wavelength="3984.18" rating="1" />
    <line id="49208" high_level="48422" low_level="48315" wavelength="3985.24" rating="1" />
    <line id="49209" high_level="48420" low_level="48312" wavelength="3986.82" rating="1" />
    <line id="49210" high_level="48421" low_level="48314" wavelength="3987.09" rating="1" />
    <line id="49211" high_level="48421" low_level="48315" wavelength="3987.46" rating="1" />
    <line id="49212" high_level="48420" low_level="48314" wavelength="3989.95" rating="1" />
    <line id="49213" high_level="48493" low_level="48319" wavelength="3990.60" rating="1" />
    <line id="49214" high_level="48494" low_level="48320" wavelength="3991.61" rating="1" />
    <line id="49215" high_level="48494" low_level="48322" wavelength="3993.84" rating="1" />
    <line id="49216" high_level="48612" low_level="48327" wavelength="3996.08" rating="1" />
    <line id="49217" high_level="48598" low_level="48331" wavelength="3999.57" rating="1" />
    <line id="204618" high_level="48691" low_level="48329" wavelength="3599.50" rating="1" />
    <line id="204619" high_level="48761" low_level="48350" wavelength="3638.03" rating="1" />
    <line id="204620" high_level="48678" low_level="48334" wavelength="3781.19" rating="1" />
    <line id="204621" high_level="48781" low_level="48354" wavelength="3878.16" rating="1" />


  </Lines>
  <limits>
    <limit id="l1">59959.40</limit>
    <limit id="l2">69432.37</limit>
  </limits>
</Diagram>');
	
	} else
	{
	
		$element->GetXML($element_id);
 		$elemxml = $element->GetAllProperties();
// 		print_r($elemxml['XML']);
 		$xml->loadXML($elemxml['XML']);
	}
	}
	else
  $xml->load('diagram.xml');

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