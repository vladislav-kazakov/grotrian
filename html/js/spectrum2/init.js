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

function init_ruler(zoom, max, n) {
    var $wrapper = $('#svg_wrapper' + n),
    max = max * zoom / 10,
    ruler = "<svg style='width:" + max + "px' id='ruler'>";

    for (i = 0; i <= max; i+= 100) {
        ruler += "<line x1='" + (!i ? i + 2 : (i == max ? i -2 : i)) + "' y1='0' x2='" + (!i ? i + 2 : (i == max ? i -2 : i)) + "' y2='30' stroke-width='2' stroke='rgb(0, 0, 0)'></line><text x='" + (i == max ? i - 45 : i - 2) + "' y='43' fill='black'>" + (i * 10 / zoom) + "</text>";
    }

    $wrapper.append(ruler);
}

function init(waves, n) {
    // console.log(waves);
    var n = n ? '_' + n : '',
    zoom = get_zoom(),
    max = Number($('#max').val()),
    min = Number($('#min').val()),
    isDrag = 0,
    $wrapper = $('#svg_wrapper'),
    start = 0,
    l,
    is_experimental = waves[Object.keys(waves)[0]].toString().indexOf('rgb') == -1,
    str = "<svg class='svg' id='svg" + n + "' draggable='true'>" + (is_experimental ? "<path stroke='white' stroke-width='1' d='M 0,120 L" : ''),
    map_str = "<svg id='map_svg" + n + "'>" + (is_experimental ? "<path stroke='white' stroke-width='1' d='M 0,120 L" : ''),
    $preview = $('#preview'),
    map_now = max / 10000,
    $map_now = $('#map_now');

    if (is_experimental)
    	var perc = Math.max.apply(null, Object.keys(waves).map(function(key) { return waves[key];})) / 100;
    id = 1;
    lines_intensity = new Array();
    max_intensity = 0;
    for (var key in waves) {
        temp = key;
        re = /\s*-\s*/
        split = temp.split(re);
        l = Number(split[0]);
        i = Number(split[1]);
        if (l > min && l < max) {
           str += is_experimental ? ' ' + (l * zoom) + ',' + (121 - (1.2 * waves[key] / perc)) : "<line id='"+ id +"' l='" + l + "'  x1='" + (l / 10 * zoom) + "' y1='0' x2='" + (l / 10 * zoom) + "' y2='120' stroke-width='1' stroke='" + waves[key] + "'></line>";
           map_str += is_experimental ? ' ' + (l / map_now) + ',' + (120 - (1.2 * waves[key] / perc)) : "<line id='full-"+ id +"' x1='" + (l / 10 / map_now) + "' y1='0' x2='" + (l / 10 / map_now) + "' y2='120' stroke-width='1' stroke='" + waves[key] + "'></line>";
           lines_intensity[id] = i;
           id++;
           if(i > max_intensity)
            max_intensity = i;
            // $("#info_intensity #value").attr("max",max_intensity);
            // $("#info_intensity #value").val(max_intensity);
    }
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

init_ruler(zoom, max, n);

$preview.prepend(map_str + (is_experimental ? "'>" : '') + "</svg>");

$map_now.css('width', 1000 / map_now / zoom + 'px');

$('#svg_wrapper .svg line').hover( 
    function() {
        var l = $(this).attr('l');

        $('#line_info').empty();
        $('#line_info').append('Длина волны: <b>' + l + '</b>');
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

$svg.css('width', max * zoom / 10 + 'px');

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

$('#zoom_container input').live('click',function() {
    if (this.className == 'base')
       $('#zoom_container input.base').removeClass('active');
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
    $("#range_intensity").live("change mousemove",function(){
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