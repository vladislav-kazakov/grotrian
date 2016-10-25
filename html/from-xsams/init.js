
function update_meters(zoom, step) {

    var scroll = $('#wrapper')[0].scrollLeft;

    for (var i = 0; i <= 10; i += step) {
        $('#meter-' + i).text((scroll * 10 / zoom) + 1000 / zoom * i);
    }
 
}
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
    return zoom;
}

function init_ruler(zoom, step) {
    var $ruler = $('#ruler'),
        $meters = $('#meters');

    $ruler.empty();
    $meters.empty()
    for (var i = 0; i <= 10; i += step) {
        $ruler.append("<span id='ruler-" + i + "' style='left:" + i * 100 + "px'>|</span>");
        $meters.append("<span id='meter-" + i + "' style='left:" + i * 100 + "px'>" + i * 1000 / zoom + "</span>");
    }
}

function init(center) {    
    var zoom = get_zoom(),
        max = Number($('#max').val()),
        min = Number($('#min').val()),
        isDrag = 0,
        $wrapper = $('#wrapper'),
        start = 0,
        cnt = waves.length,
        l,
        str = "<svg id='svg' draggable='true'>",
        map_str = "<svg id='svg'>",
        $preview = $('#preview'),
        map_now = max / 10000,
        $map_now = $('#map_now'),
        step = Math.ceil(zoom / 10) < 5 ? Math.ceil(zoom / 10) : 5;

    init_ruler(zoom, step);
    
    for (i = 0; i < cnt; i++) {
        l = Number(waves[i]['length']);
        if (l * 10 > min && l * 10 < max)
       		str += "<line l='" + l + "' propability='" + waves[i]['propability'] + "' oscillator='" + waves[i]['oscillator'] + "' x1='" + l * zoom + "' y1='0' x2='" + l * zoom +
            	"' y2='120' stroke-width='1' stroke='rgb(" + waves[i]['rgb'] + ")'></line>";
    }

    //map

   for (i = 0; i < cnt; i++) {
        l = Number(waves[i]['length']);
        if (l * 10 > min && l * 10 < max)
            map_str += "<line x1='" + l / map_now + "' y1='0' x2='" + l / map_now + "' y2='120' stroke-width='1' stroke='rgb(" + waves[i]['rgb'] + ")'></line>";
   }

    //map
    
    update_meters(zoom, step);
    
    $wrapper.empty();

    $preview.empty();
    
    $wrapper.append(str + "</svg>");

    $preview.append(map_str + "</svg>");

    $map_now.css('width', 1000 / map_now / zoom + 'px');

    $('#wrapper line').hover( 
        function() {
            var l = $(this).attr('l') * 10,
                propability = $(this).attr('propability'),
                oscillator = $(this).attr('oscillator');
            $('#line_info').empty();
            $('#line_info').append('Длина волны: <b>' + l + '</b>' + (propability ? '<br>Вероятность перехода: <b>' + propability +
            '</b>' : '') + (oscillator ? '<br>Сила осциллятора: <b>' + oscillator + '</b>' : ''));
            $(this).attr('stroke-width', 2);
        },
        function() {
            $(this).attr('stroke-width', 1);
        }
    );
    
    $wrapper.on('scroll', function() {
        update_meters(zoom, step);
        $map_now.css('left', this.scrollLeft / map_now / zoom + 'px');
        console.log(this.scrollLeft);
    });
    
    var $svg = $('#svg');
    
    $svg.css('width', max * zoom / 10 + 'px');
    
    $svg.on('mousemove', function(event) {
        if (isDrag) {
            $wrapper[0].scrollLeft = start - event.pageX;
            if (event.pageX > 990) {
                isDrag = 0;
                $(this).css('cursor', 'default');
            }
        }
    });
    
    $svg.on('mousedown', function(event) {
        event.preventDefault();
        $(this).css('cursor', 'move');
        isDrag = 1;
        start = event.pageX + $wrapper[0].scrollLeft;
    });

    
    $svg.on('mouseup', function() {
        $(this).css('cursor', 'default');
        isDrag = 0;
    });

	if (center != undefined) {
        var $center = Number($('#meter-5').text()),
            scroll;

        $wrapper[0].scrollLeft += (center - $center) / (10 / zoom);
    }

}

init();

$('#filter').on('click', function() {
    init(Number($('#meter-5').text()));
});

$('#zoom_container input').on('click', function() {
    if (this.className == 'base')
       $('#zoom_container input.base').removeClass('active');
    $(this).toggleClass('active');
});

