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
        ruler += "<line x1='" + (!i ? i + 2 : (i == max ? i -2 : i)) + "' y1='0' x2='" + (!i ? i + 2 : (i == max ? i -2 : i))
               + "' y2='30' stroke-width='2' stroke='rgb(0, 0, 0)'></line>";
        if (j <= max - min - 100) ruler += "<text x='" + (i == max ? i - 45 : i + 5 - 2) + "' y='26' fill='black'>" + rulerValue + "</text>";
    }

    $wrapper.append(ruler);
}
function fadecolor(color, normal_intensity, logbase)
{
    if (logbase == max_logbase) return color;
    alfa = Math.log2(1+ (Math.pow(2, logbase)-1) * normal_intensity)/logbase;
    return "rgba" + color.substr(3, color.length-3-1) + "," + alfa + ")";
}
function definelength(normal_intensity, logbase)
{
    var maxlength = 120;
    if (logbase == max_logbase) return 0;
    return maxlength - Math.log2(1+ (Math.pow(2, logbase) - 1) * normal_intensity)/logbase * maxlength;
}

function rule_intensity(){
    var barchart = $('#barchart').hasClass('active');
    var intensity_slider_value = $("#range_intensity input").val();
    for (var k = 1; k < lines_data.length; k++) {
        if (barchart) {
            let y1 = definelength(lines_data[k]['i'] / max_intensity, intensity_slider_value / intensity_slider_scale);
            document.getElementById(k).attributes["y1"].value = y1;
            document.getElementById("full-" + k).attributes["y1"].value = y1;
        }
        else {
            let color = fadecolor(lines_data[k]['color'], lines_data[k]['i'] / max_intensity, intensity_slider_value / intensity_slider_scale);
            document.getElementById(k).attributes["stroke"].value = color;
            document.getElementById("full-" + k).attributes["stroke"].value = color;
        }
    }
}

var max_logbase = 20;
var min_logbase = 1;
var intensity_slider_scale = 20;
var default_logbase = 8;

var lines_data;

function init(waves, n) {
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

    var _lines_intensity = new Array();
    var _max_intensity = 0;

    var intensity_slider_value = $("#range_intensity input").val();

    if (n == '')
    {
        for (var key in waves) {
            temp = key;
            re = /\s*-\s*/
            split = temp.split(re);
            l = Number(split[0]);
            i = Number(split[1]);
            if (l > min && l < max) {
                if (i > _max_intensity)
                    _max_intensity = i;
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
            var lower_level_config = split[2].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            var lower_level_term = split[3];
            var upper_level_config = split[4].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            var upper_level_term = split[5];

            if (l > min && l < max) {
                var y1 = 0;
                var newcolor = waves[key];
                if (barchart) {
                    if (_max_intensity > 0) y1 = definelength(i/ _max_intensity, intensity_slider_value / intensity_slider_scale);
                }
                else
                {
                    if (_max_intensity > 0) newcolor = fadecolor(waves[key], i/ _max_intensity, intensity_slider_value / intensity_slider_scale);
                }

                lines_data[id] = new Object();
                lines_data[id]['lower-level-config'] = lower_level_config.replace(/'/g, "&#39;");
                lines_data[id]['upper-level-config'] = upper_level_config.replace(/'/g, "&#39;");
                lines_data[id]['lower-level-term'] = lower_level_term.replace(/'/g, "&#39;");
                lines_data[id]['upper-level-term'] = upper_level_term.replace(/'/g, "&#39;");
                lines_data[id]['l'] = l;
                lines_data[id]['i'] = i;
                lines_data[id]['color'] = waves[key];

                str += "<line id='" + id + "' x1='" + ((l - min)/ 10 * zoom) + "' y1='" + y1 + "' x2='" + ((l-min) / 10 * zoom) +
                    "' y2='120' stroke-width='1' stroke='" + newcolor + "'></line>";
                map_str +="<line id='full-" + id + "' x1='" + ((l - min) / 10 / map_now) + "' y1='" + y1 + "' x2='" + ((l-min) / 10 / map_now) +
                    "' y2='120' stroke-width='1' stroke='" + newcolor + "'></line>";
                _lines_intensity[id] = i;

                id++;
                if (i > _max_intensity)
                    _max_intensity = i;
                // $("#info_intensity #value").attr("max",max_intensity);
                // $("#info_intensity #value").val(max_intensity);
            }
        }
        lines_intensity = _lines_intensity;
        max_intensity = _max_intensity;
    }
    else{
        for (var key in waves) {
            l = Number(key) *10;
            i = Number(waves[key]);
            if (l > min && l < max) {
                if (i > _max_intensity)
                    _max_intensity = i;
            }
        }
        for (var key in waves) {
            l = Number(key) * 10;
            i = Number(waves[key]);
            if (l > min && l < max) {
                str += ' ' + ((l-min)/10 * zoom) + ',' + (121 - (1.2 * waves[key] / perc));
                map_str += ' ' + ((l-min)/10 / map_now ) + ',' + (120 - (1.2 * waves[key] / perc));
                _lines_intensity[id] = i;
                id++;
                if (i > _max_intensity)
                    _max_intensity = i;
            }
        }
        lines_intensity_2 = _lines_intensity;
        max_intensity_2 = _max_intensity;
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
        $map_now.css('left', this.scrollLeft / map_now / zoom + 'px');
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
            var color = fadecolor(lines_data[k]['color'], lines_data[k]['i'] / max_intensity, max_logbase);
            document.getElementById(k).attributes["stroke"].value = color;
            document.getElementById("full-" + k).attributes["stroke"].value = color;
        }
        else {
            var y1 = definelength(lines_data[k]['i'] / max_intensity, max_logbase);
            document.getElementById(k).attributes["y1"].value = y1;
            document.getElementById("full-" + k).attributes["y1"].value = y1;
        }
    }
    rule_intensity();
});

$(document).on("change mousemove", '#range_intensity',function(){
    rule_intensity();
});
