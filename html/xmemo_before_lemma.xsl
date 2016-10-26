<?xml version="1.0" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/2000/svg">
	<xsl:output method="xml" indent="no" omit-xml-declaration="yes"/>
	<!-- Variables -->
	<xsl:variable name="n_terms">
		<xsl:value-of select="count(//group)"/>
	</xsl:variable>
  <xsl:variable name="n_breaks">
    <xsl:value-of select="count(//break)"/>
  </xsl:variable>
    <xsl:variable name="sum_breaks">
    <xsl:value-of select="sum(//break/l2) - sum(//break/l1)"/>
  </xsl:variable>
  <xsl:variable name="n_limits">
    <xsl:value-of select="count(//limit)"/>
  </xsl:variable>
	<xsl:variable name="energy_limit">
		<xsl:value-of select="number(//limit[@id='l1'])"/>
	</xsl:variable>
  <xsl:variable name="n_labels">
    <!-- Количество меток по шкале энергии -->
    <xsl:value-of select="5"/>
  </xsl:variable>
  <xsl:variable name="dE">
    <xsl:value-of select="round(($energy_limit - $sum_breaks) div ($n_labels*100))*100"/>
  </xsl:variable>
  <xsl:variable name="toeV">
    <xsl:value-of select="0.00012398"/>
  </xsl:variable>
  <xsl:variable name="Ecm_row_w">
    <xsl:value-of select="50"/>
  </xsl:variable>
	<xsl:variable name="index_dy">
		<xsl:value-of select="5"/>
	</xsl:variable>
	<xsl:variable name="index_dx">
		<xsl:value-of select="1"/>
	</xsl:variable>
	<xsl:variable name="level_dx">
		<xsl:value-of select="5"/>
	</xsl:variable>
	<xsl:variable name="diagram_w">
		<xsl:value-of select="1000"/>
	</xsl:variable>
	<xsl:variable name="diagram_h">
		<xsl:value-of select="700"/>
	</xsl:variable>
	<xsl:variable name="graph_y">
		<xsl:value-of select="$diagram_h - $core_row_h - $conf_row_h - $term_row_h"/>
	</xsl:variable>
	<xsl:variable name="conf_row_h">
		<xsl:value-of select="50"/>
	</xsl:variable>
	<xsl:variable name="core_row_h">
		<xsl:choose>
			<xsl:when test="(//atomiccore/@value)!=''">50</xsl:when>
			<xsl:otherwise>0</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<xsl:variable name="term_row_h">
		<xsl:value-of select="80"/>
	</xsl:variable>
	<xsl:variable name="term_row_w">
		<xsl:value-of select="30"/>
	</xsl:variable>
	<!--	<xsl:choose>
			<xsl:when test="$n_terms &gt;= 30">30</xsl:when>
			<xsl:otherwise><xsl:value-of select="floor(($diagram_w - 2*$Ecm_row_w) div ($n_terms*10))*10"/></xsl:otherwise>
		</xsl:choose> -->

	<!-- End of variables -->

	<xsl:template match="Diagram">
		<svg version="1.1" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMinYMin" id="svg_with_diagram">
		<!--	<xsl:attribute name="width">
				<xsl:value-of select="$diagram_w"/>
			</xsl:attribute>
			<xsl:attribute name="height">
				<xsl:value-of select="$diagram_h"/>
			</xsl:attribute> -->
			<xsl:attribute name="viewBox">0 0 <xsl:value-of select="$diagram_w"/><xsl:text> </xsl:text><xsl:value-of select="$diagram_h + 2"/>
			</xsl:attribute>
			<desc><xsl:value-of select="@abbr"/></desc>
	<!-- Шкала энергий -->
      <g class="Ecm" id="Ecm">
        <text class="Ecm" x="{0.7*$Ecm_row_w}" y="{0.3*$conf_row_h}">
          U
        </text>
        <text class="Ecm" x="{$Ecm_row_w - 5}" y="{0.6*$conf_row_h}">
          [cm<tspan class="index" dy="{-$index_dy}">-1</tspan><tspan dy="{$index_dy}">]</tspan>
        </text>
        <text class="Ecm" x="{$Ecm_row_w - 5}" y="{$diagram_h}">0</text>
	<text class="Ecm" x="{$Ecm_row_w - 1}" y="{$diagram_h - $graph_y}">
          <xsl:value-of select="//limit[@id='l1']"/>
        </text>
	<!-- for view level energy -->
        <xsl:for-each select="//level">
		<line class="energy" id="lbl_{@id}" x1="{$Ecm_row_w - 1}" x2="{$Ecm_row_w + 3}" display="none">
			<xsl:attribute name="y1"><xsl:call-template name="convert_energy"><xsl:with-param name="val" select="@energy"/></xsl:call-template></xsl:attribute>
			<xsl:attribute name="y2"><xsl:call-template name="convert_energy"><xsl:with-param name="val" select="@energy"/></xsl:call-template></xsl:attribute>
		</line>
		<text class="Ecml" id="txt_lbl_{@id}" x="{$Ecm_row_w - 1}" display="none">
			<xsl:attribute name="y"><xsl:call-template name="convert_energy"><xsl:with-param name="val" select="@energy"/></xsl:call-template></xsl:attribute>
		<xsl:value-of select="format-number(@energy, '0.#')"/></text>
	</xsl:for-each>
	<!-- END for view level energy -->	
        <xsl:if test="$n_limits&gt;1">
          <text class="Ecm" x="{$Ecm_row_w - 1}" y="{$diagram_h - $graph_y - 0.5*$term_row_h}">
            <xsl:value-of select="//limit[last()]"/>
          </text>
        </xsl:if>
        <!-- Устанавливаем рызрывы на шкалу -->
        <xsl:for-each select="//break">
          <text class="break" x="{$Ecm_row_w}">
            <xsl:attribute name="y">
              <xsl:call-template name="convert_energy">
                <xsl:with-param name="val" select="./l1"/>
              </xsl:call-template>
            </xsl:attribute>
            ~<tspan dy="-4" dx="-15">~</tspan>
          </text>
        </xsl:for-each>
        <!-- Устанавливаем метки по шкале энергий -->
        <xsl:call-template name="set_labels">
          <xsl:with-param name="x" select="$Ecm_row_w"/>
          <xsl:with-param name="dx" select="-1"/>
          <xsl:with-param name="class" select="'Ecm'"/>
          <xsl:with-param name="n" select="1"/>
          <xsl:with-param name="kE" select="1"/>
          <xsl:with-param name="energy" select="$dE"/>
        </xsl:call-template>
      </g>
      <g class="Data">
        <xsl:attribute name="transform">
          <xsl:value-of select="concat(concat('translate(', $Ecm_row_w), ', 0)')"/>
        </xsl:attribute>
        <rect class="AllData" id="AllData" width="{$term_row_w*$n_terms}" height="{$diagram_h+2}" y="0" x="0"><xsl:text> </xsl:text></rect>
			  <xsl:apply-templates />
        <text class="name" id="Abbr" x="{$term_row_w*$n_terms - 5}" y="{$diagram_h - 5}">
          <xsl:value-of select="@abbr"/>
        </text>
      </g>
      <g class="Eev" id="EeV">
        <xsl:attribute name="transform">
          <xsl:value-of select="concat(concat('translate(', $n_terms*$term_row_w), ', 0)')"/>
        </xsl:attribute>
        <text class="Eev" x="{0.3*$term_row_w}" y="{0.3*$conf_row_h}">
          U
        </text>
        <text class="Eev" x="5" y="{0.6*$conf_row_h}">
          [eV]
        </text>
        <text class="Eev" x="5" y="{$diagram_h}">0</text>
        <text class="Eev" x="1" y="{$diagram_h - $graph_y}">
          <xsl:value-of select="format-number((//limit[@id='l1'])*$toeV, '0.#')"/>
        </text>
        <xsl:if test="$n_limits&gt;1">
          <text class="Eev" x="1" y="{$diagram_h - $graph_y - 0.5*$term_row_h}">
            <xsl:value-of select="format-number((//limit[last()])*$toeV, '0.#')"/>
          </text>
        </xsl:if>
        <xsl:for-each select="//break">
          <text class="break" x="0">
            <xsl:attribute name="y">
              <xsl:call-template name="convert_energy">
                <xsl:with-param name="val" select="./l1"/>
              </xsl:call-template>
            </xsl:attribute>
            ~<tspan dy="-4" dx="-15">~</tspan>
          </text>
        </xsl:for-each>
        <!-- Устанавливаем разметку по шкале энергии -->
        <xsl:call-template name="set_labels">
          <xsl:with-param name="x" select="0"/>
          <xsl:with-param name="dx" select="1"/>
          <xsl:with-param name="class" select="'Eev'"/>
          <xsl:with-param name="n" select="1"/>
          <xsl:with-param name="kE" select="$toeV"/>
          <xsl:with-param name="energy" select="$dE"/>
        </xsl:call-template>
      </g>
		</svg>
	</xsl:template>

  <xsl:template name="set_labels">
    <xsl:param name="x"/>
    <xsl:param name="dx"/>
    <xsl:param name="class"/>
    <xsl:param name="n"/>
    <xsl:param name="energy"/>
    <xsl:param name="kE"/>
    <xsl:if test="$n&lt;$n_labels">
      <xsl:variable name="curE">
        <xsl:call-template name="extend_energy">
          <xsl:with-param name="val" select="$energy"/>
          <xsl:with-param name="n" select="1"/>
        </xsl:call-template>
      </xsl:variable>
      <xsl:variable name="curY">
        <xsl:call-template name="convert_energy">
          <xsl:with-param name="val" select="$curE"/>
        </xsl:call-template>
      </xsl:variable>
      <text class="{$class}" x="{$x+$dx}" y="{$curY}">
        <xsl:value-of select="format-number($curE*$kE, '0.#')"/>
      </text>
      <line class="energy" y1="{$curY}" y2="{$curY}" x1="{$x+$dx}" x2="{$x - 3*$dx}"/>
      <xsl:call-template name="set_labels">
        <xsl:with-param name="x" select="$x"/>
        <xsl:with-param name="dx" select="$dx"/>
        <xsl:with-param name="class" select="$class"/>
        <xsl:with-param name="n" select="$n + 1"/>
        <xsl:with-param name="kE" select="$kE"/>
        <xsl:with-param name="energy" select="(($energy div $n)*($n+1))"/>
      </xsl:call-template>
    </xsl:if>
  </xsl:template>
	
  <xsl:template match="limits">
    <xsl:for-each select="./*">
    </xsl:for-each>
  </xsl:template> 
	
	
  <xsl:template match="breaks">
    <xsl:for-each select="//break">
    </xsl:for-each>
	</xsl:template>

	<!-- Levels and Config -->
	<xsl:template match="//Levels">
		<xsl:for-each select="./column">
			<xsl:call-template name="column">
				<xsl:with-param name="n_col" select="position()"/>
			</xsl:call-template>
		</xsl:for-each>
	</xsl:template>
	
	<xsl:template name="column">
		<xsl:param name="n_col"/>
		<xsl:variable name="col_w" select="count(./atomiccore/term/group)*$term_row_w"/>
		<g class="column" >
			<xsl:attribute name="id"><xsl:value-of select="concat('col_', $n_col)"/></xsl:attribute>
			<rect y="0" x="0" height="{$conf_row_h}" width="{$col_w}" id="{concat('recConf_', position())}"><xsl:text> </xsl:text></rect>
			<text class="config">
				<xsl:attribute name="y"><xsl:value-of select="0.5*$conf_row_h"/></xsl:attribute>
				<xsl:attribute name="x"><xsl:value-of select="0.5*$col_w"/></xsl:attribute>
				<xsl:attribute name="rec_id"><xsl:value-of select="concat('recConf_', position())"/></xsl:attribute>
				<xsl:call-template name="create_indexes">
					<xsl:with-param name="val" select="@config"/>
				</xsl:call-template>
			</text>
			<xsl:for-each select="./atomiccore">
				<xsl:call-template name="core">
					<xsl:with-param name="shift_x" select="position()"/>
					<xsl:with-param name="n_col" select="$n_col"/>
				</xsl:call-template>
			</xsl:for-each>
		</g>
	</xsl:template>
	
	<xsl:template name="core">
		<xsl:param name="shift_x"/>
		<xsl:param name="n_col"/>
		<xsl:variable name="core_x" select="count(//column[$n_col]/atomiccore[position()&lt;$shift_x]/term/group)*$term_row_w"/>
		<xsl:variable name="core_w" select="count(./term/group)*$term_row_w"/>
		<g class="core">
			<rect x="{$core_x}" height="{$core_row_h}" width="{$core_w}" y="{$conf_row_h}" id="{concat('recCore_', position())}"><xsl:text> </xsl:text></rect>
      <xsl:if test="@value != ''">
			  <text class="config">
				  <xsl:attribute name="y"><xsl:value-of select="0.5*$core_row_h + $conf_row_h"/></xsl:attribute>
				  <xsl:attribute name="x"><xsl:value-of select="$core_x + 0.5*$core_w"/></xsl:attribute>
				  <xsl:attribute name="rec_id"><xsl:value-of select="concat('recCore_', position())"/></xsl:attribute>
				  <xsl:call-template name="create_indexes">
					  <xsl:with-param name="val" select="@value"/>
				  </xsl:call-template>
			  </text>
      </xsl:if>
	
		<xsl:for-each select="./term">
				<xsl:call-template name="term">
					<xsl:with-param name="core_x" select="$core_x"/>
				</xsl:call-template>
			</xsl:for-each>

		</g>
	</xsl:template>
	
	<xsl:template name="term">
		<xsl:param name="core_x"/>
    		<xsl:variable name="pos" select="position()"/>
    		<xsl:variable name="shift" select="count(parent::atomiccore/term[position()&lt;$pos]/group)*$term_row_w"/>
		<g class="term" prefix="{@prefix}" parity="{@parity}">
			<xsl:variable name="pref" select="@prefix"/>
			<xsl:variable name="parity" select="@parity"/>
			<xsl:for-each select="./group">
				<xsl:call-template name="group">
         				<xsl:with-param name="dx" select="$shift"/>
          				<xsl:with-param name="prefix" select="$pref"/>
					<xsl:with-param name="parity" select="$parity"/>
					<xsl:with-param name="core_x" select="$core_x"/>
				</xsl:call-template>
			</xsl:for-each>
		</g>
	</xsl:template>
	
	<xsl:template name="group">
    		<xsl:param name="dx"/>
		<xsl:param name="prefix"/>
		<xsl:param name="parity"/>
		<xsl:param name="core_x"/>
    <xsl:variable name="child_x" select="(position()-0.5)*$term_row_w + $core_x"/>
    <rect x="{(position()-1)*$term_row_w + $core_x + $dx}" y="{$conf_row_h+$core_row_h}" width="{$term_row_w}" id="{concat('recTerm_', position())}" L="{@L}" prefix="{$prefix}" parity="{$parity}" j="{@j}">
	<xsl:attribute name="n_levels"><xsl:value-of select="count(./level)"/></xsl:attribute>
      <xsl:if test="$n_limits=1">
        <xsl:attribute name="height">
          <xsl:value-of select="$term_row_h"/>
        </xsl:attribute>
	<xsl:if test="./level[1]/@energy &gt; $energy_limit">
		<xsl:attribute name="info">no</xsl:attribute>
	</xsl:if>
	</xsl:if>
      <xsl:if test="$n_limits&gt;1">
        <xsl:choose>
          <xsl:when test="./level[last()]/@energy&gt;$energy_limit">
            <xsl:attribute name="height">
              <xsl:value-of select="0.5*$term_row_h"/>
            </xsl:attribute>
            <xsl:attribute name="type">auto</xsl:attribute>
	   </xsl:when>
          <xsl:otherwise>
            <xsl:attribute name="height">
              <xsl:value-of select="$term_row_h"/>
            </xsl:attribute>
	   </xsl:otherwise>
        </xsl:choose>
      </xsl:if>
      <xsl:text> </xsl:text>
    </rect>
			
			<text class="config" x="{$child_x + $dx}" type="full">
				<xsl:choose>
				   <xsl:when test="$n_limits=1">
					<xsl:attribute name="y"><xsl:value-of select="0.5*$term_row_h + $core_row_h + $conf_row_h"/></xsl:attribute>
			          </xsl:when>
			          <xsl:when test="./level[last()]/@energy&gt;$energy_limit">
			            <xsl:attribute name="y"><xsl:value-of select="0.25*$term_row_h + $core_row_h + $conf_row_h"/></xsl:attribute>
			          </xsl:when>
			          <xsl:otherwise>
					<xsl:attribute name="y"><xsl:value-of select="0.5*$term_row_h + $core_row_h + $conf_row_h"/></xsl:attribute>
			          </xsl:otherwise>
			        </xsl:choose>

				<xsl:attribute name="rec_id"><xsl:value-of select="concat('recTerm_', position())"/></xsl:attribute>
				<xsl:value-of select="@seq"/>
				<tspan class="index" dx="{-$index_dx}">
					<xsl:attribute name="dy"><xsl:value-of select="-$index_dy"/></xsl:attribute>
					<xsl:value-of select="$prefix"/>
				</tspan>
        <tspan dx="{-$index_dx}">
					<xsl:attribute name="dy"><xsl:value-of select="$index_dy"/></xsl:attribute>
					<!-- xsl:value-of select="@L"/ -->
					<xsl:call-template name="create_indexes">
						<xsl:with-param name="val" select="@L"/>
					</xsl:call-template>

				</tspan>
				<xsl:choose>
					<xsl:when test="$parity!=''">
						<tspan class="index" dx="{-$index_dx}">
							<xsl:attribute name="dy"><xsl:value-of select="-$index_dy"/></xsl:attribute>
							<xsl:value-of select="$parity"/>
						</tspan>
						<tspan class="index" dx="{-$index_dy}">
							<xsl:attribute name="dy"><xsl:value-of select="2*$index_dy"/></xsl:attribute>
							<xsl:value-of select="@j"/>
						</tspan>
						</xsl:when>
						<xsl:otherwise>
							<tspan class="index" dx="{-$index_dx}">
							<xsl:attribute name="dy"><xsl:value-of select="$index_dy"/></xsl:attribute>
							<xsl:value-of select="@j"/>
						</tspan>
						</xsl:otherwise>
				</xsl:choose>
			</text>
		<g class="levels">
			<line class="level" x1="{$child_x + $dx}" x2="{$child_x + $dx}">
				<xsl:attribute name="y2">
					<xsl:call-template name="convert_energy"><xsl:with-param name="val" select="./level[1]/@energy"/></xsl:call-template>
				</xsl:attribute>
				<xsl:attribute name="y1">
					<xsl:choose>
					   <xsl:when test="$n_limits=1">
				            <xsl:call-template name="convert_energy"><xsl:with-param name="val" select="$energy_limit"/></xsl:call-template>
				          </xsl:when>
				          <xsl:when test="./level[last()]/@energy&gt;=$energy_limit">
				            <xsl:call-template name="convert_energy"><xsl:with-param name="val" select="//limit[last()]"/></xsl:call-template>
				          </xsl:when>
				          <xsl:otherwise>
						<xsl:call-template name="convert_energy"><xsl:with-param name="val" select="$energy_limit"/></xsl:call-template>
				          </xsl:otherwise>
				        </xsl:choose>
				</xsl:attribute>
			</line>
			<xsl:for-each select="./level">
				<line class="level" energy="{@energy}" onmouseover="mouse_on_level(evt, this)" onmouseout="mouse_out_level(evt, this)" config="{@config}" j="{@j}">
					<xsl:attribute name="id"><xsl:value-of select="@id"/></xsl:attribute>
					<xsl:attribute name="y1"><xsl:call-template name="convert_energy"><xsl:with-param name="val" select="@energy"/></xsl:call-template></xsl:attribute>
					<xsl:attribute name="y2"><xsl:call-template name="convert_energy"><xsl:with-param name="val" select="@energy"/></xsl:call-template></xsl:attribute>
				       <xsl:attribute name="x1">
				            <xsl:value-of select="$child_x - $level_dx + $dx"/>
          				</xsl:attribute>
          				<xsl:attribute name="x2">
          				  <xsl:value-of select="$child_x+$level_dx + $dx"/>
          				</xsl:attribute>
          				<xsl:choose>
						<xsl:when test="1=@long"><xsl:attribute name="long"><xsl:value-of select="@long"/></xsl:attribute></xsl:when>
						<xsl:otherwise>
						</xsl:otherwise>
					</xsl:choose>
				</line>
				<text class="namelevel" id="{concat('conf_name_', @id)}" x="{$child_x + $dx}" display="none">
					<xsl:attribute name="y"><xsl:call-template name="convert_energy"><xsl:with-param name="val" select="@energy"/></xsl:call-template></xsl:attribute>
					<xsl:value-of select="@config"/><xsl:if test="'' != @j">, j=<xsl:value-of select="@j"/></xsl:if>
				</text>
			</xsl:for-each>
		</g>
	</xsl:template>
	
	<!-- transitions-->
	<xsl:template match="Lines">
		<g id="transitions">
			<xsl:for-each select="./line">
				<line class="transition" onmouseover="mouse_on_tr(evt, this)" onmouseout="mouse_out_tr(evt, this)">
					<xsl:attribute name="id"><xsl:value-of select="@id"/></xsl:attribute>
					<xsl:attribute name="low_level"><xsl:value-of select="@low_level"/></xsl:attribute>
					<xsl:attribute name="high_level"><xsl:value-of select="@high_level"/></xsl:attribute>
					<xsl:attribute name="rating"><xsl:value-of select="@rating"/></xsl:attribute>
					<xsl:attribute name="dx">0</xsl:attribute>
					<xsl:attribute name="wavelength"><xsl:value-of select="@wavelength"/></xsl:attribute>
				</line>
				
				<rect class="fortext" width="1" height="6" transform="" display="none">
					<xsl:attribute name="id"><xsl:value-of select="concat('rect_', @id)"/></xsl:attribute>
				<xsl:text> </xsl:text>
                </rect>
				<text class="transition" transform="" display="none">
					<xsl:attribute name="id"><xsl:value-of select="concat('txt_', @id)"/></xsl:attribute>
					<xsl:value-of select="@wavelength"/>
				</text>
			</xsl:for-each>
		</g>
	</xsl:template>
	

	<!-- FORMATING FUNCTIONS -->

  <xsl:template name="extend_energy">
    <xsl:param name="val"/>
    <xsl:param name="n"/>
    <xsl:choose>
      <xsl:when test="$n&lt;=$n_breaks">
        <xsl:choose>
          <xsl:when test="$val&lt;(//break[$n]/l1)">
            <xsl:call-template name="extend_energy">
              <xsl:with-param name="n" select="$n+1"/>
              <xsl:with-param name="val" select="$val"/>
            </xsl:call-template>
          </xsl:when>
          <xsl:otherwise>
            <xsl:call-template name="extend_energy">
              <xsl:with-param name="n" select="$n+1"/>
              <xsl:with-param name="val" select="$val + (//break[position()=$n]/l2) - (//break[position()=$n]/l1)"/>
            </xsl:call-template>
          </xsl:otherwise>
        </xsl:choose>
      </xsl:when>
      <xsl:otherwise>
        <xsl:value-of select="$val"/>
      </xsl:otherwise>
    </xsl:choose>

  </xsl:template>
  
	<!-- convert energy to coordinates--> 
	<xsl:template name="convert_energy">
		<xsl:param name="val"/>
		<xsl:variable name="last_limit">
			<xsl:value-of select="//limit[last()]"/>
		</xsl:variable>
		<xsl:choose>
			<xsl:when test="$val&lt;$energy_limit">
        			<xsl:if test="$n_breaks&gt;=1">
	          			<xsl:call-template name="scale_with_breaks">
				            <xsl:with-param name="n_break" select="1"/>
				            <xsl:with-param name="energy" select="$val"/>
				            <xsl:with-param name="val" select="$val"/>
				       </xsl:call-template>
				</xsl:if>
				<xsl:if test="$n_breaks=0">
				       <xsl:value-of select="format-number($diagram_h - (($val*$graph_y) div $energy_limit), '0.00')"/>
				</xsl:if>
			</xsl:when>
			<xsl:when test="$n_limits=1">
				<xsl:value-of select="format-number($diagram_h - $graph_y, '0.##')"/>
			</xsl:when>
			<xsl:when test="$val&gt;$last_limit">
				<xsl:value-of select="format-number($diagram_h - $graph_y - $term_row_h*0.5, '0.##')"/>
			</xsl:when>
      			<xsl:when test="$n_limits&gt;1">
		              <xsl:value-of select="format-number($diagram_h - $graph_y - ($term_row_h*0.5*($val - $energy_limit) div ($last_limit - $energy_limit)), '0.00')"/>
		      </xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="format-number($diagram_h - $graph_y, '0.##')"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
  
  <xsl:template name="scale_with_breaks">
    <xsl:param name="n_break"/>
    <xsl:param name="val"/>
    <xsl:param name="energy"/>
    <xsl:choose>
      <xsl:when test="$n_break&lt;=$n_breaks">
        <xsl:if test="$energy&gt;(//break[position()=$n_break]/l2)">
          <!--Если уровень выше верхней границы предела, то отнимаем от энергии ширину разрыва и идем дальше -->
          <xsl:call-template name="scale_with_breaks">
            <xsl:with-param name="n_break" select="$n_break + 1"/>
            <xsl:with-param name="energy" select="$energy"/>
            <xsl:with-param name="val" select="$val - (//break[position()=$n_break]/l2) + (//break[position()=$n_break]/l1)"/>
          </xsl:call-template>
        </xsl:if>
        <xsl:if test="$energy&lt;(//break[position()=$n_break]/l2)">
          <!-- Если энергия попадает в разрыв, то устанавливаем значение в нижнуюю границу разрыва -->
          <xsl:if test="$energy&gt;=(//break[position()=$n_break]/l1)">
            <xsl:call-template name="scale_with_breaks">
              <xsl:with-param name="n_break" select="$n_break + 1"/>
              <xsl:with-param name="energy" select="$energy"/>
              <xsl:with-param name="val" select="(//break[position()=$n_break]/l1)"/>
            </xsl:call-template>
          </xsl:if>
          <xsl:if test="$energy&lt;(//break[position()=$n_break]/l1)">
            <xsl:call-template name="scale_with_breaks">
              <xsl:with-param name="n_break" select="$n_break + 1"/>
              <xsl:with-param name="energy" select="$energy"/>
              <xsl:with-param name="val" select="$val"/>
            </xsl:call-template>
          </xsl:if>
        </xsl:if>
      </xsl:when>
      <xsl:otherwise>
        
        <xsl:value-of select="format-number($diagram_h - (($val*$graph_y) div ($energy_limit - $sum_breaks)), '0.00')"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
	
	<!-- create a string with indexes instead of @{...} (supindex) and ~{...} (subindex)-->
	<xsl:template name="create_indexes"> 		
    <xsl:param name="val"/>
		<xsl:choose>
			<xsl:when test="contains($val, '{')">
				<xsl:choose>
					<xsl:when test="contains($val, '@')">
							<xsl:call-template name="create_indexes">
								<xsl:with-param name="val" select="substring-before($val, '@')"/>
							</xsl:call-template>
							<tspan class="index" dy="{-$index_dy}" dx="{-$index_dx}">
								<xsl:value-of select="substring-before(substring-after($val, '{'), '}')"/>
							</tspan>
							<tspan dy="{$index_dy}" dx="{-$index_dx}">
								<xsl:call-template name="create_indexes">
									<xsl:with-param name="val" select="substring-after($val, '}')"/>
								</xsl:call-template>
							</tspan>
					</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="substring-before($val, '~')"/>
						<tspan class="index" dx="{-$index_dx}">
							<xsl:attribute name="dy"><xsl:value-of select="2*$index_dy"/></xsl:attribute>
							<xsl:value-of select="substring-before(substring-after($val, '{'), '}')"/>
						</tspan>
            <tspan dx="{-$index_dx}" dy="{-$index_dy}">
              <xsl:call-template name="create_indexes">
                <xsl:with-param name="val" select="substring-after($val, '}')"/>
              </xsl:call-template>
            </tspan>
					</xsl:otherwise>
				</xsl:choose>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$val"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>