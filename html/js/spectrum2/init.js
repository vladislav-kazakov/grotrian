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

function init_ruler(zoom, min, max, n) {
    var $wrapper = $('#svg_wrapper' + n),
    max = max * zoom / 10,
    min = min * zoom / 10,
    ruler = "<svg width='" + (max-min) + "' height='30' id='ruler' style='background-color:white;'>";

    rulerMin = Math.ceil(min/100)*100; // round minimum to hundreds in less side
    for (var j = 0; j < max - min; j+= 100) {
        var i = j + rulerMin-min; // i - pixels on ruler
        var rulerValue =  (i+min) * 10 / zoom;
        ruler += "<line x1='" + (!i ? i + 2 : (i == max ? i -2 : i)) + "' y1='0' x2='" + (!i ? i + 2 : (i == max ? i -2 : i)) + "' y2='30' stroke-width='2' stroke='rgb(0, 0, 0)'></line>";
        if (j <= max - min - 100) ruler += "<text x='" + (i == max ? i - 45 : i + 5 - 2) + "' y='26' fill='black'>" + rulerValue + "</text>";
    }

    $wrapper.append(ruler);
}

function init(waves, n) {
    // console.log(waves);
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
    str = "<svg class='svg' id='svg" + n + "' draggable='true' style='background-color:black;' width='"+ (max-min)*zoom/10+"' height='120'>" + (is_experimental ? "<path stroke='white' stroke-width='1' d='M 0,120 L" : ''),
    map_str = "<svg id='map_svg" + n + "'>" + (is_experimental ? "<path stroke='white' stroke-width='1' d='M 0,120 L" : ''),
    $preview = $('#preview'),
//    minRuler = Math.floor(min/100)*100, // round minimum to hundreds in less side
//    maxRuler = Math.ceil(max/100)*100, // round minimum to hundreds in less side
    map_now = (max - min) / 10000,
    $map_now = $('#map_now');

    if (is_experimental)
    	var perc = Math.max.apply(null, Object.keys(waves).map(function(key) { return waves[key];})) / 100;
    id = 1;
    var _lines_intensity = new Array();
    var _max_intensity = 0;

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
            }
        }
        for (var key in waves) {
            var temp = key;
            var re = /\s*-\s*/;
            var split = temp.split(re);
            l = Number(split[0]);
            var i = Number(split[1]);
            var lower_level_config = split[2].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            var lower_level_term = split[3].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            var upper_level_config = split[4].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            var upper_level_term = split[5].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");

            if (l > min && l < max) {
                str += "<line id='" + id + "' l='" + l + "' lower-level-config='" + lower_level_config +
                    "' upper-level-config='" + upper_level_config +
                    "' lower-level-term='" + lower_level_term +
                    "' upper-level-term='" + upper_level_term +
                    "'  x1='" + ((l - min)/ 10 * zoom) + "' y1='" +
                    (barchart ? 120 - i / _max_intensity * 120 : 0) + "' x2='" + ((l-min) / 10 * zoom) +
                    "' y2='120' stroke-width='1' stroke='" + waves[key] + "'></line>";
                map_str +="<line id='full-" + id + "' x1='" + ((l - min) / 10 / map_now) + "' y1='" +
                    (barchart ? 120 - i / _max_intensity * 120 : 0) + "' x2='" + ((l-min) / 10 / map_now) +
                    "' y2='120' stroke-width='1' stroke='" + waves[key] + "'></line>";
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
                // $("#info_intensity #value").attr("max",max_intensity);
                // $("#info_intensity #value").val(max_intensity);
            }
        }
        lines_intensity_2 = _lines_intensity;
        max_intensity_2 = _max_intensity;
    }

// $("#range_intensity").ionRangeSlider({
//     type: "double",
//     grid: true,
//     min: 0,
//     max: max_intensity
// });
max_intensity = Math.round(Math.log2(max_intensity)) * 1000 + 1;
input_range = '<input type="range" min=-1000 max='+max_intensity+' value='+max_intensity+' style="width: 520px;">';
$("#range_intensity").html(input_range);


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

$map_now.css('width', Math.min(1000/ map_now / zoom, 1000) + 'px');

$('#svg_wrapper .svg line').hover( 
    function() {
        var l = $(this).attr('l');

        $('#line_info').empty();
        $('#line_info').append('Wave length: <b>' + l + ' &#8491;</b> Levels: '
            + $(this).attr('lower-level-config') + ":" + $(this).attr('lower-level-term')
            +' - ' + $(this).attr('upper-level-config') + ":" + $(this).attr('lower-level-term'));
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

//$map.css('width', (max-min) * zoom / 10 + 'px');

$svg.css('width', (max-min) * zoom / 10 + 'px');
if (document.getElementById('canvas')) document.getElementById('canvas').width = (max-min) * zoom / 10; //2 = border-left (1px) + border-right (1px)


$svg.mousemove(function(event) {
    if (isDrag) {
       if (n)
          $svg.css('marginLeft', -(start - event.pageX) + 'px');
      else
       $wrapper[0].scrollLeft = start - event.pageX;
            /*if (event.pageX > 1500) {
                isDrag = 0;
                $(this).css('cursor', 'default');
            }*/
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
    if (this.className == 'base')
       $('#zoom_container input.base').removeClass('active');
   $(this).toggleClass('active');
});

$(document).on('click', '#barchart', function() {
    $(this).toggleClass('active');
});

$(document).ready(function() {
    function rule_intensity(value){
        // console.log('значение '+ value);
        // $("#info_intensity #value").val(value);
        value = Math.round(value);
        for (var k = 0; k < lines_intensity.length; k++) {
            // console.log(Math.pow(2,(max_intensity - value)/1000 - 1));
            if(lines_intensity[k] >= Math.pow(2,(max_intensity - value)/1000) - 1 /*|| (lines_intensity[k] == 0 && max_intensity != value)*/){
                // console.log(k +'=>'+lines_intensity[k]);
                $("#"+k).show();
                $("#full-"+k).show();
                // console.log($("#"+k));
            }else{
                $("#"+k).hide();
                $("#full-"+k).hide();
            }
        };
    }
    $(document).on("change mousemove", '#range_intensity',function(){
        value = $("#range_intensity input").val();
        rule_intensity(value)
    });
    // $("#info_intensity #value").click(function(){
    //     value = $("#info_intensity #value").val();
    //     $("#range_intensity input").val(value);
    //     // if()
    //     rule_intensity(value)
    // });                
});