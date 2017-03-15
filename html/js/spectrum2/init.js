function get_zoom() {
    var zoom = 0;
    $('#zoom_container input').each(function() {
        var _this = $(this);
        if (_this.hasClass('active')) {
            if (_this.hasClass('base'))
                zoom += Number(_this.val());
            else
                zoom *= Number(_this.val().replace('x', ''));
        }

    });
    return zoom ? zoom : 1;
}

function map_width(){
    var max = Number($('#max').val());
    var min = Number($('#min').val());
    var map_now = (max - min) / 10000;
    return Math.min(1000/ map_now / get_zoom(), 1000);
}

function init_ruler(zoom, min, max, n) {
    var $wrapper = $('#svg_wrapper' + n),
    max = max * zoom / 10,
    min = min * zoom / 10,
    ruler = "<svg width='" + (max-min) + "' height='30' id='ruler' style='background-color:white;'>";

    rulerMin = Math.ceil(min/100)*100; // round minimum to hundreds in less side
    for (var j = 0; j < max - min; j+= 100) {
        var i = j + rulerMin-min; // i - pixels on ruler
        var rulerValue =  (i+min) * 10 / zoom;
        var line_x = !i ? i + 2 : (i == max ? i - 2 : i);
        ruler += "<line x1='" + line_x + "' y1='0' x2='" + line_x + "' y2='30' stroke-width='2' stroke='rgb(0, 0, 0)'></line>";
        if (j <= max - min - 100) {
            var text_x = i == max ? i - 45 : i + 5 - 2;
            ruler += "<text x='" + text_x + "' y='26' fill='black'>" + rulerValue + "</text>";
        }
    }

    $wrapper.append(ruler);
}
function fadecolor(color, normal_intensity, logbase)
{
    if (logbase == max_logbase) return color;
    alfa = Math.round(Math.log(1+ (Math.pow(2, logbase)-1) * normal_intensity)/Math.log(2)/logbase*1000)/1000;
    return "rgba" + color.substr(3, color.length-3-1) + "," + alfa + ")";
}
function definelength(normal_intensity, logbase)
{
    var maxlength = 120;
    if (logbase == max_logbase) return 0;
    return maxlength - Math.log(1+ (Math.pow(2, logbase) - 1) * normal_intensity)/Math.log(2)/logbase * maxlength;
}
function init_serie_selector(element)
{
    if (element == "H" || element == "D" || element == "T")
    {
        var series = new Array();
        for (var i = 1; i < lines_data.length; i++) {
            var llc = lines_data[i]['lower-level-config-original'];
            if (series.indexOf(llc[0]) == -1) series.push(llc[0]);
        }
        series.sort();
        $('#series').empty();
        $('<select>', {'id': 'serieSelector', 'change': function(event){selectserie(element, event.target.value)}}).appendTo($('#series'));
        $('<option>', {'value': 'all', 'text': 'All lines'}).appendTo($('#serieSelector'));
        for (var j = 0; j < series.length; j++) {
            var text = series[j];
            switch (series[j]){
                case "1": text = "Lyman series (n' = 1)"; break;
                case "2": text = "Balmer series (n' = 2)"; break;
                case "3": text = "Paschen series (n' = 3)"; break;
                case "4": text = "Brackett series (n' = 4)"; break;
                case "5": text = "Pfund series (n' = 5)"; break;
                case "6": text = "Humphreys series (n' = 6)"; break;
                default: text = "n' = " + series[j];
            }
            $('<option>', {'value': series[j], 'text': text}).appendTo($('#serieSelector'));
        }
    }
    if (element == "Na I" || element == "Li I")
    {
        $('<select>', {'id': 'serieSelector', 'change': function(event){selectserie(element, event.target.value)}}).appendTo($('#series'));
        $('<option>', {'value': 'all', 'text': 'All lines'}).appendTo($('#serieSelector'));
        $('<option>', {'value': 'sp', 'text': "Principal series (ns - n'p)"}).appendTo($('#serieSelector'));
        $('<option>', {'value': 'ps', 'text': "Sharp series (np - n's)"}).appendTo($('#serieSelector'));
        $('<option>', {'value': 'pd', 'text': "Diffuse series (np - n'd)"}).appendTo($('#serieSelector'));
        $('<option>', {'value': 'df', 'text': "Fundamental series (nd - n'f)"}).appendTo($('#serieSelector'));
    }
}
function selectserie(element, serie)
{
    for (var k = 1; k < lines_data.length; k++) {//сброс длины палочек или затемнения при смене типа отображения
        document.getElementById(k).style.display = "";
        document.getElementById("full-" + k).style.display="";
    }
    //rule_intensity();

    if ((element == "H" || element == "D" || element == "T")&& serie!='all')
    {
        for (var k = 1; k < lines_data.length; k++) {
            var llc = lines_data[k]['lower-level-config-original'];
            if (llc[0] != serie) {
                document.getElementById(k).style.display = "none";
                document.getElementById("full-" + k).style.display = "none";
            }
        }
    }
    if (element == "Na I" || element == "Li I") {
        for (var k = 1; k < lines_data.length; k++) {
            var llc = lines_data[k]['lower-level-config-original'];
            var ulc = lines_data[k]['upper-level-config-original'];
            var ll = llc[llc.search( /[a-z][^a-z@]*$/ )];
            var ul = ulc[ulc.search( /[a-z][^a-z@]*$/ )];
            if (ll != serie[0] || ul != serie[1]) {
                document.getElementById(k).style.display = "none";
                document.getElementById("full-" + k).style.display = "none";
            }
        }
    }
}
function rule_intensity(){
    if (max_intensity == 0) return;
    var barchart = $('#barchart').hasClass('active');
    var intensity_slider_value = $("#range_intensity input").val();
    for (var k = 1; k < lines_data.length; k++) {
        if (barchart) {
            if (max_intensity == 0){
                document.getElementById(k).attributes["y1"].value = 0;
                document.getElementById("full-" + k).attributes["y1"].value = 0;
            }
            else {
                var y1 = definelength(lines_data[k]['i'] / max_intensity, intensity_slider_value / intensity_slider_scale);
                //console.log(lines_data[k].l +": "+ y1);
                document.getElementById(k).attributes["y1"].value = y1;
                document.getElementById("full-" + k).attributes["y1"].value = y1;
            }
        }
        else {
            if (max_intensity == 0){
                document.getElementById(k).attributes["stroke"].value = lines_data[k].color;
                document.getElementById("full-" + k).attributes["stroke"].value = lines_data[k].color;
            }
            else {
                var color = fadecolor(lines_data[k]['color'], lines_data[k]['i'] / max_intensity, intensity_slider_value / intensity_slider_scale);
                document.getElementById(k).attributes["stroke"].value = color;
                document.getElementById("full-" + k).attributes["stroke"].value = color;
            }
        }
    }
}

var max_logbase = 20;
var min_logbase = 1;
var intensity_slider_scale = 20;
var default_logbase = 8;

var lines_data;

function init(waves, element, n) {
    if (Object.keys(waves).length == 0) return;
    var n = n ? '_' + n : '',
    zoom = get_zoom(),
    barchart = $('#barchart').hasClass('active'),
    max = Number($('#max').val()),
    min = Number($('#min').val()),
    isDrag = 0,
    $wrapper = $('#svg_wrapper'),
    start = 0,
    l,
    is_experimental = waves[Object.keys(waves)[0]].toString().indexOf('rgb') == -1,
    str = "<svg class='svg' id='svg" + n + "' draggable='true' style='background-color:black;' width='"+ (max-min)*zoom/10
         +"' height='120'>" + (is_experimental ? "<path stroke='white' stroke-width='1' d='M 0,120 L" : ''),
    map_str = "<svg id='map_svg" + n + "'>" + (is_experimental ? "<path stroke='white' stroke-width='1' d='M 0,120 L" : ''),
    $preview = $('#preview'),

    map_now = (max - min) / 10000,
    $map_now = $('#map_now');
    lines_count = 0;

    $("#range_intensity input").attr("min", min_logbase * intensity_slider_scale);
    $("#range_intensity input").attr("max", max_logbase * intensity_slider_scale);
    $("#range_intensity input").attr("value", default_logbase * intensity_slider_scale);

    if (is_experimental)
    	var perc = Math.max.apply(null, Object.keys(waves).map(function(key) { return waves[key];})) / 100;

    id = 1;

    var intensity_slider_value = $("#range_intensity input").val();

    if (n == '')
    {
        max_intensity = 0;
        for (var key in waves) {
            temp = key;
            re = /\s*-\s*/
            split = temp.split(re);
            l = Number(split[0]);
            i = Number(split[1]);
            if (l > min && l < max) {
                if (i > max_intensity)
                    max_intensity = i;
                lines_count++;
            }
        }
        lines_data = new Array();
        for (var key in waves) {
            var temp = key;
            var re = /\s*-\s*/;
            var split = temp.split(re);
            l = Number(split[0]);
            var i = Number(split[1]);
            var lower_level_config_original = split[2];
            var lower_level_config = split[2].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            var lower_level_term = split[3];
            var upper_level_config_original = split[4];
            var upper_level_config = split[4].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            var upper_level_term = split[5];

            if (l > min && l < max) {
                var y1 = 0;
                var newcolor = waves[key];
                if (barchart) {
                    if (max_intensity > 0) y1 = definelength(i/ max_intensity, intensity_slider_value / intensity_slider_scale);
                }
                else
                {
                    if (max_intensity > 0) newcolor = fadecolor(waves[key], i/ max_intensity, intensity_slider_value / intensity_slider_scale);
                }

                lines_data[id] = new Object();
                lines_data[id]['lower-level-config-original'] = lower_level_config_original;
                lines_data[id]['lower-level-config'] = lower_level_config.replace(/'/g, "&#39;");
                lines_data[id]['upper-level-config-original'] = upper_level_config_original;
                lines_data[id]['upper-level-config'] = upper_level_config.replace(/'/g, "&#39;");
                lines_data[id]['lower-level-term'] = lower_level_term.replace(/'/g, "&#39;");
                lines_data[id]['upper-level-term'] = upper_level_term.replace(/'/g, "&#39;");
                lines_data[id]['l'] = l;
                lines_data[id]['i'] = i;
                lines_data[id]['color'] = waves[key];
                var x = Math.round(((l - min)/ 10 * zoom)*100)/100;
                var map_x = Math.round(((l - min) / 10 / map_now)*100)/100;
                //console.log(Math.round(((l - min)/ 10 * zoom)*100)/100);

                str += "<line id='" + id + "' x1='" + x + "' y1='" + y1 + "' x2='" + x +
                    "' y2='120' stroke-width='1' stroke='" + newcolor + "'></line>";
                map_str +="<line id='full-" + id + "' x1='" + map_x + "' y1='" + y1 + "' x2='" + map_x +
                    "' y2='120' stroke-width='1' stroke='" + newcolor + "'></line>";

                id++;
            }
        }
    }
    else{
        for (var key in waves) {
            l = Number(key) * 10;
            i = Number(waves[key]);
            if (l > min && l < max) {
                str += ' ' + ((l-min)/10 * zoom) + ',' + (121 - (1.2 * waves[key] / perc));
                map_str += ' ' + ((l-min)/10 / map_now ) + ',' + (120 - (1.2 * waves[key] / perc));
            }
        }
    }

    if (!n) {
       $wrapper.empty();
       $preview.empty();
    }else {
      $wrapper.css('height', '325px');
      $preview.css('height', '300px');
      $map_now.css('height', '240px');
    }

    $wrapper.prepend(str + (is_experimental ? "'>" : '') + "</svg>");

    init_ruler(zoom, min, max, n);

    $preview.prepend(map_str + (is_experimental ? "'>" : '') + "</svg>");

    $map_now.css('width', map_width() + 'px');

    $('#svg_wrapper .svg line').hover(
        function() {
            var id = $(this).attr('id');
            $('#line_info').empty();
            $('#line_info').append('Wave length: <b>' + lines_data[id]['l'] + ' &#8491;</b> Levels: '
                + lines_data[id]['lower-level-config'] + ":" +   lines_data[id]['lower-level-term']
                +' - ' +  lines_data[id]['upper-level-config'] + ":" + lines_data[id]['upper-level-term']
                +'. Intensity: ' + lines_data[id]['i']
            );
            $(this).attr('stroke-width', 2);
        },
        function() {
            $(this).attr('stroke-width', 1);
            $('#line_info').empty();
        }
        );

    $wrapper.scroll(function() {
        $map_now.css('left', Math.round(this.scrollLeft / map_now / zoom * 100)/100 + 'px');
    });

    var $svg = $('#svg' + n);

    $svg.css('width', (max-min) * zoom / 10 + 'px');
    if (document.getElementById('canvas')) document.getElementById('canvas').width = (max-min) * zoom / 10; //2 = border-left (1px) + border-right (1px)

    $svg.mousemove(function(event) {
        if (isDrag) {
           if (n) $svg.css('marginLeft', -(start - event.pageX) + 'px');
           else $wrapper[0].scrollLeft = start - event.pageX;
        }
    });

    $svg.mousedown(function(event) {
        event.preventDefault();
        $(this).css('cursor', 'move');
        isDrag = 1;
        start = n ? event.pageX - parseInt($svg.css('marginLeft')) : event.pageX + $wrapper[0].scrollLeft;
    });

    $svg.mouseup(function() {
        $(this).css('cursor', 'default');
        isDrag = 0;
    });

    init_serie_selector(element);

}

$(document).on('click', '#zoom_container input', function() {
    var middle = ($('#svg_wrapper').prop('scrollLeft') + $('#svg_wrapper').prop('clientWidth')/2)/$('#svg_wrapper').prop('scrollWidth');
    if ($(this).hasClass('base'))
       $('#zoom_container input.base').removeClass('active');
    $(this).toggleClass('active');
    init_all();
    $('#svg_wrapper').prop('scrollLeft', middle * $('#svg_wrapper').prop('scrollWidth') - $('#svg_wrapper').prop('clientWidth')/2);

});

$(document).on('click', '#visible', function() {
    $('#min').prop('value', 3800);
    $('#max').prop('value', 7800);
    $('#zoom_container input').removeClass('active');
    $('#x1').addClass('active');
    $('#x2').addClass('active');
    $('#x5').removeClass('active');
    init_all();
});

$(document).on('click', '#all_spectrum', function() {
    $('#min').prop('value', 0);
    $('#max').prop('value', 30000);
    $('#zoom_container input').removeClass('active');
    $('#x1').addClass('active');
    $('#x2').removeClass('active');
    $('#x2').removeClass('active');
    init_all();
});

$(document).on('click', '#barchart', function() {
    $(this).toggleClass('active');
    var barchart = $('#barchart').hasClass('active');
    for (var k = 1; k < lines_data.length; k++) {//сброс длины палочек или затемнения при смене типа отображения
        if (barchart) {
            if (max_intensity == 0){
                document.getElementById(k).attributes["stroke"].value = lines_data[k].color;
                document.getElementById("full-" + k).attributes["stroke"].value = lines_data[k].color;
            }
            else {
                var color = fadecolor(lines_data[k]['color'], lines_data[k]['i'] / max_intensity, max_logbase);
                document.getElementById(k).attributes["stroke"].value = color;
                document.getElementById("full-" + k).attributes["stroke"].value = color;
            }
        }
        else {
            if (max_intensity == 0){
                document.getElementById(k).attributes["y1"].value = 0;
                document.getElementById("full-" + k).attributes["y1"].value = 0;
            }
            else {
                var y1 = definelength(lines_data[k]['i'] / max_intensity, max_logbase);
                document.getElementById(k).attributes["y1"].value = y1;
                document.getElementById("full-" + k).attributes["y1"].value = y1;
            }
        }
    }
    rule_intensity();
});

$(document).on("change mousemove", '#range_intensity',function(){
    rule_intensity();
});
