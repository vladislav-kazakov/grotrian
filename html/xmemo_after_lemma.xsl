<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xlink="http://www.w3.org/1999/xlink"
	xmlns="http://www.w3.org/2000/svg"
	xmlns:svg="http://www.w3.org/2000/svg" exclude-result-prefixes="svg">

	<xsl:output method="html" indent="no" omit-xml-declaration="yes"/>

	<xsl:template match="node() | @*">
		<xsl:copy>
			<xsl:apply-templates select="node() | @*"/>
		</xsl:copy>
	</xsl:template>

	<xsl:variable name="t_width">
		<xsl:value-of select="//svg:rect[@class='AllData']/@width"/>
	</xsl:variable>
	<xsl:variable name="t_height">
		<xsl:value-of select="//svg:rect[@class='AllData']/@height"/>
	</xsl:variable>

	<xsl:template match="svg:svg" priority="2">
	<!--svg-->
		<link rel="stylesheet" type="text/css" href="/css/svg.css?v3" />
		<xsl:copy>
			<xsl:apply-templates select="@*"/>
			<xsl:copy-of select="./svg:desc"/>
		    <xsl:copy-of select="./svg:g[@class='Ecm']"/>
		    <g>
		        <xsl:apply-templates select="./svg:g[class='Data']/@*"/>
		        <xsl:copy-of select="./svg:g[@class='Data']/@*"/>
				<xsl:for-each select="//svg:g[@class='column']">
					<xsl:call-template name="shift_columns">
						<xsl:with-param name="cur_pos" select="position()"/>
					</xsl:call-template>
				</xsl:for-each>
      			<xsl:apply-templates select="./*"/>
      		</g>
			<script type="text/ecmascript" scriptImplementation="">
				var table_width = <xsl:value-of select="$t_width"/>;
				var table_height = <xsl:value-of select="$t_height"/>;
				var term_row_w = <xsl:value-of select="//svg:g[@class='term']/svg:rect/@width"/>;
				var term_row_h = <xsl:value-of select="//svg:g[@class='term']/svg:rect/@height"/>;
			</script>
			<![CDATA[ ]]>
			<script type="text/ecmascript" xlink:href="/js/svg.js?v2"></script>
		</xsl:copy>
	<!--/svg-->
	</xsl:template>

	<xsl:template match="//svg:g[@class='Data']">
		<xsl:apply-templates select="./*"/>
	</xsl:template>

	<xsl:template match="//svg:g[@class='column']">
	</xsl:template>

	<xsl:template match="svg:g[@class='Ecm']">
	</xsl:template>

	<!--<xsl:template match="svg:g[@class='Eev']">
	</xsl:template>-->

	<xsl:template match="svg:desc">
	</xsl:template>
			
	<xsl:template name="shift_columns">
		<xsl:param name="cur_pos"/>
		<xsl:variable name="tr_x" select="sum(//svg:g[@class='column'][position()&lt;$cur_pos]/svg:rect/@width)"/>
		<xsl:choose>
			<xsl:when test="$tr_x!=0">
				<g>
					<xsl:attribute name="transform">
						<xsl:value-of select="concat(concat('translate(', $tr_x), ', 0)')"/>
					</xsl:attribute>
					<xsl:apply-templates select="@* | node()"/>
				</g>
			</xsl:when>
			<xsl:otherwise>
				<xsl:copy>
					<xsl:apply-templates select="@* | node()"/>
				</xsl:copy>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

	<xsl:template match="svg:line">
	<xsl:copy>
		<xsl:apply-templates select="@*"/>
	</xsl:copy>
	</xsl:template>
	
</xsl:stylesheet>