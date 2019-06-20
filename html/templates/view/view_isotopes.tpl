<div class="container_12">
    <div class="grid_12" id="main">
        <div class="brake"></div>
        {#foreach item=z from=$isotopes#}
            {#foreach item=isotope from=$z#}
                <h4><a href="element/{#$isotope.ID#}"><sup>{#$isotope.MASS_NUMBER#}</sup>{#$isotope.ELNAME#}</a></h4>
            {#/foreach#}
        <br>
        {#/foreach#}
    </div>
</div>
<!--End of Main -->