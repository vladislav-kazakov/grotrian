var crc32=function(r) {
    let hash = 0;
    if (r.length == 0) return hash;
    for (i = 0; i < r.length; i++) {
        let char = r.charCodeAt(i);
        hash = ((hash << 5) - hash) + char;
        hash = hash & hash;
    }
    return hash;
};

var randomColors = ["rgba(255, 0, 0, 1)",
    "rgba(0, 0, 255, 1)",
    "rgba(255, 152, 0, 1)",
    "rgba(255, 114, 255, 1)",
    "rgba(0, 255, 0, 1)",
    "rgba(83, 0, 113, 1)"/*,
    "rgb(255, 255, 0)",
    "rgb(84, 115, 0)",
    "rgb(255, 130, 0)",
    "rgb(0, 255, 255)",
    "rbg(139, 0, 0)",
    "rbg(98, 133, 255)"*/];

var svgColors = ["#FF0000",
    "#008000",
    "#0000FF",
    "#ff8000",
    "#000000"];

var barColors = ["rgba(255,0,0,0.2)",
    "rgba(0,128,0,0.2)",
    "rgba(0,0,255,0.2)",
    "rgba(255,128,0,0.2)",
    "rgba(0,0,0,0.2)"];

function hashStr(transition) {
    return transition.lower_level_config + transition.lower_level_termprefix + transition.lower_level_termfirstpart + transition.lower_level_termmultiply +
        transition.lower_level_termsecondpart + transition.upper_level_config + transition.upper_level_termprefix + transition.upper_level_termfirstpart +
        transition.upper_level_termmultiply + transition.upper_level_termsecondpart;
}

function inArabic(rim) {
    switch (rim) {
        case 'I':
            return 1;
        case 'II':
            return 2;
        case 'III':
            return 3;
        case 'IV':
            return 4;
        case 'V':
            return 5;
        case 'VI':
            return 6;
        case 'VII':
            return 7;
        case 'VIII':
            return 8;
        case 'IX':
            return 9;
        case 'X':
            return 10;
        case 'XI':
            return 11;
        default:
            return 0;
    }
}

var atom,
    isdown = false,
    term = ({lt: "", ut: "", x: "", y: ""}),
    dataSpectr = [],
    intensArray = [],
    markers = [],
    termLabel = [],
    maxVal = 0,
    IP = 0,
    cm = true,
    ev = false,
    selected = false,
    max,
    svgMaxVal = 0,
    idx,
    icon = [],
    randCol = new Array(markers.length),
    hashMap = new Map(),
    hashAtomicResidue = new Map(),
    hashFullConfig = new Map(),
    configTree = {},
    numbOfConfig = 0;
hashTerm = new Map();

var labeleV = "[eV]",
    labelcm = "[1/cm]",
    lable1 = "U (lower level) ",
    lable5 = "for even term: U (lower level) ",
    lable2 = "U (upper level) ",
    lable4 = "for even term: U (upper level) ",
    lable3 = "U (upper level) - U (lower level) ",
    part1Y = lable2,
    part1X = lable1,
    part2 = labelcm;

var scatterChartData;

var colorArr = [],
    eUpcheck = true,
    parity = false,
    eUp_eDcheck = false;

var customTooltips,
    zoomTooltips;

//отображение иинтенсивности прозрачностью
function click_intens(){
    if(document.getElementById('intens').checked){
        fill_icon(markers, icon);
        scatterChartData.datasets[0].pointStyle = icon;
        scatterChartData.datasets[0].pointBackgroundColor = 'rgba(255, 255, 255, 0)';
        scatterChartData.datasets[0].pointBorderColor = colorArr;
        window.myScatter.update();
    }
    else {
        var col = [];
        colorArr.forEach(function(item){
            let a = item.split('a');
            let b = a[1].split(',');
            col.push(a[0]+b[0]+','+b[1]+','+b[2]+')');
        });
        fill_icon(markers, icon);
        scatterChartData.datasets[0].pointStyle = icon;
        scatterChartData.datasets[0].pointBackgroundColor = 'rgba(255, 255, 255, 0)';
        scatterChartData.datasets[0].pointBorderColor = col;
        window.myScatter.update();
    }
}

document.getElementById('eUp').addEventListener('click', function() {
    if(eUpcheck == false) {
        eUpcheck = true;
        part1X = lable1;
        part1Y = lable2;

        if (parity == true) {
            dataSpectr.forEach(function (item, i) {
                let x = 0,
                    y = 0;
                if (item.t) {
                    y = item.x;
                    x = item.y;
                } else {
                    x = item.x;
                    y = item.y;
                }
                term.x = x;
                term.y = y;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                item.x = x;
                item.y = y;
            });
            parity = false;
        }

        if (eUp_eDcheck == true) {
            dataSpectr.forEach(function (item, i) {
                let x = 0,
                    y = 0;
                x = item.x;
                y = item.y + item.x;
                term.x = x;
                term.y = y;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                item.x = x;
                item.y = y;
            });
            eUp_eDcheck = false;
        }

        if (ev == true) {
            IP = atom.atom.IONIZATION_POTENCIAL;
            IP = IP * 1.23977 * Math.pow(10, -4);
        }
        else IP = atom.atom.IONIZATION_POTENCIAL;


        scatterChartData.datasets[1].data[1].x = 0;
        scatterChartData.datasets[1].data[1].y = 0;

        scatterChartData.datasets[0].data = dataSpectr;
        scatterChartData.labels = termLabel;
        myScatter.options.scales.yAxes[0].scaleLabel.labelString = part1Y + part2;
        myScatter.options.scales.xAxes[0].scaleLabel.labelString = part1X + part2;

        maxVal = 0;
        dataSpectr.forEach(function (item) {
            if (maxVal < item.x) maxVal = item.x;
        });

        scatterChartData.datasets[2].data[0].x = IP;
        scatterChartData.datasets[2].data[1].x = 0;
        scatterChartData.datasets[2].data[1].y = IP;
        scatterChartData.datasets[2].data[0].y = IP;

        scatterChartData.datasets[3].data[0].x = IP;
        scatterChartData.datasets[3].data[1].x = IP;
        scatterChartData.datasets[3].data[1].y = 0;
        scatterChartData.datasets[3].data[0].y = IP;

        window.myScatter.update();
    }
});

document.getElementById('parity').addEventListener('click', function() {
    if(parity == false) {
        parity = true;
        part1Y = lable4;
        part1X = lable5;
        maxVal = 0;
        IP = 0;

        if(eUp_eDcheck == true) {
            dataSpectr.forEach(function (item, i) {
                let x = 0,
                    y = 0;
                if (item.t) {
                    y = item.x;
                    x = item.y + item.x;
                } else {
                    x = item.x;
                    y = item.y + item.x;
                }
                term.x = x;
                term.y = y;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                item.x = x;
                item.y = y;
                if (maxVal <x) maxVal = x;
            });

            eUp_eDcheck = false;
        }

        if(eUpcheck == true) {
            dataSpectr.forEach(function (item, i) {
                let x = 0,
                    y = 0;
                if (item.t) {
                    y = item.x;
                    x = item.y;
                } else {
                    x = item.x;
                    y = item.y;
                }
                term.x = x;
                term.y = y;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                item.x = x;
                item.y = y;
                if (maxVal <x) maxVal = x;
            });
            eUpcheck = false;
        }
        if (ev == true){
            scatterChartData.datasets[1].data[1].x = maxVal*1.23977*Math.pow(10,-4);
            scatterChartData.datasets[1].data[1].y = maxVal*1.23977*Math.pow(10,-4);
            IP = atom.atom.IONIZATION_POTENCIAL;
            IP = IP * 1.23977 * Math.pow(10, -4);
        }
        else {
            scatterChartData.datasets[1].data[1].x = maxVal;
            scatterChartData.datasets[1].data[1].y = maxVal;
            IP = atom.atom.IONIZATION_POTENCIAL;
        }


        scatterChartData.datasets[0].data = dataSpectr;
        scatterChartData.labels = termLabel;
        myScatter.options.scales.yAxes[0].scaleLabel.labelString = part1Y + part2;
        myScatter.options.scales.xAxes[0].scaleLabel.labelString = part1X + part2;
        scatterChartData.datasets[1].data[1].x = maxVal;
        scatterChartData.datasets[1].data[1].y = maxVal;

        scatterChartData.datasets[2].data[0].x = IP;
        scatterChartData.datasets[2].data[1].x = 0;
        scatterChartData.datasets[2].data[1].y = IP;
        scatterChartData.datasets[2].data[0].y = IP;

        scatterChartData.datasets[3].data[0].x = IP;
        scatterChartData.datasets[3].data[1].x = IP;
        scatterChartData.datasets[3].data[1].y = IP;
        scatterChartData.datasets[3].data[0].y = 0;

        window.myScatter.update();
    }
});

document.getElementById('eUp_eD').addEventListener('click', function() {
    if(eUp_eDcheck == false) {
        eUp_eDcheck = true;
        part1X = lable1;
        part1Y = lable3;

        if (parity == true) {
            dataSpectr.forEach(function (item, i) {
                let x = 0,
                    y = 0;
                if (item.t) {
                    x = item.y;
                    y = item.x;
                } else {
                    x = item.x;
                    y = item.y;
                }
                term.x = x;
                term.y = y - x;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                item.x = x;
                item.y = y - x;
            });
            parity = false;
        }

        if (eUpcheck == true) {
            dataSpectr.forEach(function (item, i) {
                let x = item.x,
                    y = item.y - item.x;
                term.x = x;
                term.y = y;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                item.x = x;
                item.y = y;
            });
            eUpcheck = false;
        }

        if (ev == true) {
            IP = atom.atom.IONIZATION_POTENCIAL;
            IP = IP * 1.23977 * Math.pow(10, -4);
        }
        else IP = atom.atom.IONIZATION_POTENCIAL;

        scatterChartData.datasets[1].data[1].x = 0;
        scatterChartData.datasets[1].data[1].y = 0;

        scatterChartData.datasets[2].data[0].x = IP;
        scatterChartData.datasets[2].data[0].y = 0;
        scatterChartData.datasets[2].data[1].y = IP;
        scatterChartData.datasets[2].data[1].x = 0;

        scatterChartData.datasets[3].data[0].x = 0;
        scatterChartData.datasets[3].data[1].x = 0;
        scatterChartData.datasets[3].data[1].y = 0;
        scatterChartData.datasets[3].data[0].y = 0;

        scatterChartData.datasets[0].data = dataSpectr;
        scatterChartData.labels = termLabel;
        myScatter.options.scales.yAxes[0].scaleLabel.labelString = part1Y + part2;
        myScatter.options.scales.xAxes[0].scaleLabel.labelString = part1X + part2;
        window.myScatter.update();
    }
});

document.getElementById('resetZoom').addEventListener('click', function() {
    myScatter.resetZoom();
    window.myScatter.update();
    displayWidth();
});

function resize(click) {
    if(click == 0){
        if(document.getElementById('fullScreen').value == 'Full screen') {
            let win_w, win_h, size;
            win_w = window.innerWidth;
            win_h = window.innerHeight;
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            size = Math.floor(size*5/6);
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) {
                window.myScatter.clear();
            }
            $('#zoom_chart').remove();
            $('#chartZoom').append('<canvas id="zoom_chart"><canvas>');
            if (window.zoomChart) window.zoomChart.clear();
            graph(size, size);
        }
        else {
            let win_w, win_h, size;
            win_w = window.innerWidth;
            win_h = window.innerHeight;
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) window.myScatter.clear();
            $('#zoom_chart').remove();
            $('#chartZoom').append('<canvas id="zoom_chart"><canvas>');
            if (window.zoomChart) window.zoomChart.clear();
            graph(size, size);
        }
    }
    else if (click == 1){
        if(document.getElementById('fullScreen').value == 'Full screen') {
            let win_w, win_h, size;
            win_w = window.innerWidth;
            win_h = window.innerHeight;
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) window.myScatter.clear();
            $('#zoom_chart').remove();
            $('#chartZoom').append('<canvas id="zoom_chart"><canvas>');
            if (window.zoomChart) window.zoomChart.clear();
            graph(size, size);
            document.getElementById('fullScreen').value = 'Exit full screen';
        }
        else {
            let win_w, win_h, size;
            win_w = window.innerWidth;
            win_h = window.innerHeight;
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            size = Math.floor(size*5/6);
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) window.myScatter.clear();
            $('#zoom_chart').remove();
            $('#chartZoom').append('<canvas id="zoom_chart"><canvas>');
            if (window.zoomChart) window.zoomChart.clear();
            graph(size, size);
            document.getElementById('fullScreen').value = 'Full screen';
        }
    }

    window.myScatter.options.title.text = '';
    window.myScatter.update();
    displayWidth();
}

//переключение размерности
var rad = document.getElementsByName('myRadios');
for (var i = 0; i < rad.length; i++) {
    rad[i].addEventListener('change', function() {
        if (this.value == 1) {   //размерность cm^-1
            cm = true;
            ev = false;
            part2 = labelcm;
            scatterChartData.datasets[0].data.forEach(function (item, i) {
                item.x = item.x/(1.23977*Math.pow(10,-4));
                item.y = item.y/(1.23977*Math.pow(10,-4));
                term.x = item.x;
                term.y = item.y;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                scatterChartData.datasets[0].data[i].x =item.x;
                scatterChartData.datasets[0].data[i].y =item.y;
            });

            if(eUp_eDcheck == true){
                IP = atom.atom.IONIZATION_POTENCIAL;
                scatterChartData.datasets[2].data[0].x = IP;
                scatterChartData.datasets[2].data[0].y = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[1].x = 0;
            }

            if(parity == true) {
                maxVal = 0;
                dataSpectr.forEach(function (item) {
                    if (maxVal <  item.x) maxVal = item.x;
                });
                scatterChartData.datasets[1].data[1].x = maxVal;
                scatterChartData.datasets[1].data[1].y = maxVal;

                IP = atom.atom.IONIZATION_POTENCIAL;

                scatterChartData.datasets[2].data[0].x = IP;
                scatterChartData.datasets[2].data[1].x = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[0].y = IP;

                scatterChartData.datasets[3].data[0].x = IP;
                scatterChartData.datasets[3].data[1].x = IP;
                scatterChartData.datasets[3].data[1].y = IP;
                scatterChartData.datasets[3].data[0].y = 0;
            }

            if(eUpcheck == true){
                maxVal = 0;
                dataSpectr.forEach(function (item) {
                    if (maxVal <  item.x) maxVal = item.x;
                });
                IP = atom.atom.IONIZATION_POTENCIAL;
                scatterChartData.datasets[2].data[0].x = IP;
                scatterChartData.datasets[2].data[1].x = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[0].y = IP;

                scatterChartData.datasets[3].data[0].x = IP;
                scatterChartData.datasets[3].data[1].x = IP;
                scatterChartData.datasets[3].data[1].y = 0;
                scatterChartData.datasets[3].data[0].y = IP;
            }

            maxVal = 0;
            max = 0;
            dataSpectr.forEach(function (item) {
                if (maxVal <  item.x) maxVal = item.x;
                if (max < item.y) max = item.y;
            });
            if (max < maxVal) max = maxVal;
            myScatter.options.scales.xAxes[0].ticks.suggestedMax = max;
            myScatter.options.scales.yAxes[0].ticks.suggestedMax = max;
            myScatter.resetZoom();
            window.myScatter.update();
            displayWidth();
        }
        else {   //размерность evV
            ev = true;
            cm = false;
            part2 = labeleV;
            scatterChartData.datasets[0].data.forEach(function (item, i) {
                item.x = item.x*1.23977*Math.pow(10,-4);
                item.y = item.y*1.23977*Math.pow(10,-4);
                term.x = item.x;
                term.y = item.y;
                let arr = termLabel[i].split("intensity:");
                let arr1 = arr[1].split("(");
                termLabel[i] = arr[0] + "intensity:" + arr1[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                scatterChartData.datasets[0].data[i].x =item.x;
                scatterChartData.datasets[0].data[i].y =item.y;
            });


            if(eUp_eDcheck == true){
                IP = atom.atom.IONIZATION_POTENCIAL;
                IP = IP*1.23977*Math.pow(10,-4);
                scatterChartData.datasets[2].data[0].x = IP;
                scatterChartData.datasets[2].data[0].y = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[1].x = 0;
            }

            if (parity==true) {
                maxVal = 0;
                dataSpectr.forEach(function (item) {
                    if (maxVal < item.x) maxVal = item.x;
                });
                scatterChartData.datasets[1].data[1].x = maxVal;
                scatterChartData.datasets[1].data[1].y = maxVal;

                IP = atom.atom.IONIZATION_POTENCIAL;
                IP = IP*1.23977*Math.pow(10,-4);

                scatterChartData.datasets[2].data[0].x = IP;
                scatterChartData.datasets[2].data[1].x = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[0].y = IP;

                scatterChartData.datasets[3].data[0].x = IP;
                scatterChartData.datasets[3].data[1].x = IP;
                scatterChartData.datasets[3].data[1].y = IP;
                scatterChartData.datasets[3].data[0].y = 0;
            }

            if(eUpcheck == true){
                maxVal = 0;
                dataSpectr.forEach(function (item) {
                    if (maxVal <  item.x) maxVal = item.x;
                });
                IP = atom.atom.IONIZATION_POTENCIAL;
                IP = IP*1.23977*Math.pow(10,-4);
                scatterChartData.datasets[2].data[0].x = IP;
                scatterChartData.datasets[2].data[1].x = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[0].y = IP;

                scatterChartData.datasets[3].data[0].x = IP;
                scatterChartData.datasets[3].data[1].x = IP;
                scatterChartData.datasets[3].data[1].y = 0;
                scatterChartData.datasets[3].data[0].y = IP;
            }

            maxVal = 0;
            max = 0;
            dataSpectr.forEach(function (item) {
                if (maxVal <  item.x) maxVal = item.x;
                if (max < item.y) max = item.y;
            });
            if (max < maxVal) max = maxVal;
            myScatter.options.scales.xAxes[0].ticks.suggestedMax = max;
            myScatter.options.scales.yAxes[0].ticks.suggestedMax = max;
            myScatter.resetZoom();
            window.myScatter.update();
            displayWidth();
        }
        myScatter.options.scales.yAxes[0].scaleLabel.labelString = part1Y + part2;
        myScatter.options.scales.xAxes[0].scaleLabel.labelString = part1X + part2;
    });
}

function updateChart(new_atom, min, maxW){
    configTree = {};
    hashMap.clear();
    hashAtomicResidue.clear();
    hashFullConfig.clear();
    hashTerm.clear();
    maxVal=0;
    IP = 0;
    cm=true;
    ev=false;
    dataSpectr.length = 0;
    intensArray.length = 0;
    markers.length = 0;
    termLabel.length = 0;
    icon.length = 0;
    colorArr.length = 0;
    svgMaxVal = 0;
    if (new_atom == 1)document.getElementById('intens').checked = true;
    document.getElementById('intens').disabled = false;
    document.getElementById('random').checked = false;
    document.getElementsByName('myRadios')[0].checked = true;
    document.getElementsByName('myRadios')[1].checked = false;
    document.getElementById('eUp_eD').checked = false;
    document.getElementById('parity').checked = false;
    document.getElementById('eUp').checked = true;
    eUpcheck = true;
    parity = false;
    eUp_eDcheck = false;

    function makeTooltip(tooltip, id, tooltipEl, obj){
        if (tooltip.opacity === 0) {
            tooltipEl.style.opacity = 0;
            return;
        }
        tooltipEl.classList.remove('above', 'below', 'no-transform');

        if (tooltip.yAlign) tooltipEl.classList.add(tooltip.yAlign);
        else tooltipEl.classList.add('no-transform');

        function getBody(bodyItem) {return bodyItem.lines;}

        if (tooltip.body) {
            var titleLines = tooltip.title || [];
            var bodyLines = tooltip.body.map(getBody);
            var innerHtml = '<thead>';
            titleLines.forEach(function (title) {
                innerHtml += '<tr><th>' + title + '</th></tr>';
            });
            innerHtml += '</thead><tbody>';
            bodyLines.forEach(function (body, i) {
                innerHtml += '<tr><td>' + body + '</td></tr>';
            });
            innerHtml += '</tbody>';
            var tableRoot = tooltipEl.querySelector('table');
            tableRoot.innerHTML = innerHtml;
        }
        var positionY = obj._chart.canvas.offsetTop;
        var positionX = obj._chart.canvas.offsetLeft;
        tooltipEl.style.opacity = 1;
        tooltipEl.style.left = positionX + tooltip.caretX + 'px';
        tooltipEl.style.top = positionY + tooltip.caretY + 'px';
        tooltipEl.style.fontFamily = tooltip._bodyFontFamily;
        tooltipEl.style.fontSize = tooltip.bodyFontSize;
        tooltipEl.style.fontStyle = tooltip._bodyFontStyle;
        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
    }

    customTooltips = function (tooltip) {
        var tooltipEl = document.getElementById('chartjs-tooltip');
        makeTooltip(tooltip, "chartjs-tooltip-key", tooltipEl, this);
    };

    zoomTooltips = function (tooltip) {
        var tooltipEl = document.getElementById('zoom-tooltip');
        makeTooltip(tooltip, "zoom-tooltip-key", tooltipEl, this);
    };

    if (((min == 0) && (maxW == 0))){
        selected = false;
        let numb =0;
        let len = atom.transitions.length;
        for(let i = 0; i<len;i++){
            let transition = atom.transitions[i];
            if (transition.ID_LOWER_LEVEL && transition.ID_UPPER_LEVEL) {
                if (transition.upper_level_termsecondpart == null) transition.upper_level_termsecondpart = "";
                if (transition.lower_level_termsecondpart == null) transition.lower_level_termsecondpart = "";
                let pref = "",
                    multCol = ({m: '', c: '', l: ''}),
                    len = transition.WAVELENGTH,
                    multUp,
                    second,
                    temp = "",
                    multLow;

                if ((transition.INTENSITY == null) || (transition.INTENSITY == 0))
                    transition.INTENSITY = 0;

                let x = transition.lower_level_energy,
                    y = transition.upper_level_energy;

                multLow = transition.lower_level_termprefix;
                multUp = transition.upper_level_termprefix;

                if (multLow) pref = multLow;
                second = transition.lower_level_termsecondpart;
                let lower_level_config = transition.lower_level_config;
                if((lower_level_config!=null) && (lower_level_config!="")) {
                    temp = lower_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;");
                }
                if (transition.lower_level_termmultiply == 0) {
                    term.lt = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sup>&deg;</sup>" + "<sub>" + transition.lower_level_j + "</sub>";
                    transition.low_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sup>&deg;</sup>";
                } else {
                    transition.low_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>";
                    term.lt = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sub>" + transition.lower_level_j + "</sub>";
                }

                let termforhash = transition.low_l.replace(/\<\/span\>/gi, "").replace(/\<span\>/gi, "");
                fillHashConfigTable(hashTerm, termforhash, x, numb);


                if((lower_level_config!=null) && (lower_level_config!="")) {
                    let configWithoutResidues = temp.replace(/\(([^?]+?)\)/gi, "");
                    fillHashConfigTable(hashAtomicResidue, temp, x, numb);
                    fillHashConfigTable(hashFullConfig, configWithoutResidues, x, numb);
                }

                if (svgMaxVal < x) svgMaxVal = x;

                pref = "";
                temp = "";
                let test = transition.upper_level_termmultiply;
                if (multUp) pref = multUp;
                second = transition.upper_level_termsecondpart;
                let upper_level_config = transition.upper_level_config;
                if((upper_level_config!=null) && (upper_level_config!=""))
                    temp = upper_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;");
                if (test === 0) {
                    transition.up_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sup>&deg;</sup>";
                    term.ut = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sup>&deg;</sup>" + "<sub>" + transition.upper_level_j + "</sub>";
                } else {
                    term.ut = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sub>" + transition.upper_level_j  + "</sub>";
                    transition.up_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>";
                }

                if (multUp != multLow) {
                    multCol.m = 0;
                } else
                    multCol.m = multLow;
                multCol.l = len;
                if ((transition.color.R == 255) && (transition.color.G == 255) &&(transition.color.B == 255)){
                    transition.color.R = 0;
                    transition.color.G = 0;
                    transition.color.B = 0;
                }
                multCol.c = "rgba(" + transition.color.R + "," + transition.color.G + ","  + transition.color.B + ',';
                markers.push(multCol);

                let point = {x: x, y: y, t: test};
                term.x = point.x;
                term.y = point.y;
                termLabel.push(term.lt + "<span> - </span>" + term.ut + "<br>" + "wavelength [?]: " + len + "<br>" + "intensity: " + transition.INTENSITY + "<br>" + "(x: " + term.x + ", y: " + term.y + ")");
                dataSpectr.push(point);
                if (transition.INTENSITY == 0) intensArray.push(0);
                else intensArray.push(Math.log10(transition.INTENSITY));
                let hash = crc32(hashStr(transition));
                if (hashMap.has(hash)){
                    transition.numb = numb;
                    hashMap.get(hash).push(transition);
                }
                else {
                    let tr = [];
                    transition.numb = numb;
                    tr.push(transition);
                    hashMap.set(hash, tr);
                }
                numb++;
            }
        }
    }
    else{
        selected = true;
        let numb = 0;
        let len = atom.transitions.length;
        for(let i = 0; i<len;i++){
            let transition = atom.transitions[i];
            if (transition.ID_LOWER_LEVEL && transition.ID_UPPER_LEVEL && (transition.WAVELENGTH > min) && (transition.WAVELENGTH < maxW)) {
                if (transition.upper_level_termsecondpart == null) transition.upper_level_termsecondpart = "";
                if (transition.lower_level_termsecondpart == null) transition.lower_level_termsecondpart = "";
                let pref = "",
                    multCol = ({m: '', c: '', l: ''}),
                    len = transition.WAVELENGTH,
                    multUp,
                    second,
                    temp = "",
                    multLow;

                if ((transition.INTENSITY == null) || (transition.INTENSITY == 0))
                    transition.INTENSITY = 0;

                let x = transition.lower_level_energy,
                    y = transition.upper_level_energy;

                multLow = transition.lower_level_termprefix;
                multUp = transition.upper_level_termprefix;

                if (multLow) pref = multLow;
                second = transition.lower_level_termsecondpart;
                let lower_level_config = transition.lower_level_config;
                if((lower_level_config!=null) && (lower_level_config!="")) {
                    temp = lower_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;");
                    let configWithoutResidues = temp.replace(/\((.+?)\)/gi, "");
                    fillHashConfigTable(hashAtomicResidue, temp, x, numb);
                    fillHashConfigTable(hashFullConfig, configWithoutResidues, x, numb);
                }
                if (transition.lower_level_termmultiply == 0) {
                    term.lt = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sup>&deg;</sup>" + "<sub>" + transition.lower_level_j + "</sub>";
                    transition.low_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sup>&deg;</sup>";
                } else {
                    transition.low_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>";
                    term.lt = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sub>" + transition.lower_level_j + "</sub>";
                }

                let termforhash = transition.low_l.replace(/\<\/span\>/gi, "").replace(/\<span\>/gi, "");
                fillHashConfigTable(hashTerm, termforhash, x, numb);

                pref = "";
                temp = "";
                let test = transition.upper_level_termmultiply;
                if (multUp) pref = multUp;
                second = transition.upper_level_termsecondpart;
                let upper_level_config = transition.upper_level_config;
                if((upper_level_config!=null) && (upper_level_config!=""))
                    temp = upper_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;");
                if (test === 0) {
                    transition.up_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sup>&deg;</sup>";
                    term.ut = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sup>&deg;</sup>" + "<sub>" + transition.upper_level_j + "</sub>";
                } else {
                    term.ut = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sub>" + transition.upper_level_j  + "</sub>";
                    transition.up_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>";
                }

                if (multUp != multLow) {
                    multCol.m = 0;
                } else
                    multCol.m = multLow;
                if ((transition.color.R == 255) && (transition.color.G == 255) &&(transition.color.B == 255)){
                    transition.color.R = 0;
                    transition.color.G = 0;
                    transition.color.B = 0;
                }
                multCol.c = "rgba(" + transition.color.R + "," + transition.color.G + ","  + transition.color.B + ',';
                multCol.l = len;
                markers.push(multCol);

                let point = {x: x, y: y, t: test};
                term.x = point.x;
                term.y = point.y;
                termLabel.push(term.lt + "<span> - </span>" + term.ut + "<br>" + "wavelength [?]: " + len + "<br>" + "intensity: " + transition.INTENSITY + "<br>" + "(" + term.x + ", " + term.y + ")");
                dataSpectr.push(point);
                if (transition.INTENSITY == 0) intensArray.push(0);
                else intensArray.push(Math.log10(transition.INTENSITY));

                let hash = crc32(hashStr(transition));
                if (hashMap.has(hash)){
                    transition.numb = numb;
                    hashMap.get(hash).push(transition);
                }
                else {
                    let tr = [];
                    transition.numb = numb;
                    tr.push(transition);
                    hashMap.set(hash, tr);
                }
                numb++;
            }
            else delete transition.numb;
        }
    }

    let arr = [];
    for (let key of hashMap.keys()) {
        let sum = 0;
        for (let g = 0; g < hashMap.get(key).length; g++) {
            sum += Number(hashMap.get(key)[g].WAVELENGTH);
        }
        sum = sum/hashMap.get(key).length;
        let el = ({hash: key, wlen: sum});
        arr.push(el);
    }
    arr.sort((prev, next) => prev.wlen - next.wlen);
    let tempMap = new Map();
    for(let i = 0; i<arr.length; i++){
        tempMap.set(arr[i].hash, hashMap.get(arr[i].hash));
    }
    hashMap = tempMap;

    let n = 0;
    for (let key of hashMap.keys()) {
        for (let g = 0; g < hashMap.get(key).length; g++) {
            randCol[hashMap.get(key)[g].numb] = randomColors[n];
        }
        n++;
        if(n==randomColors.length) n = 0;
    }

    var maxItem = Math.max.apply(null, intensArray);
    intensArray.forEach(function (item, i) {
        intensArray[i] = item / maxItem;
    });

    intensArray.forEach(function (item, i) {
        markers[i].c += String(item) + ")";
        colorArr.push(markers[i].c);
    });

    fill_icon(markers, icon);

    maxVal = 0;
    max = 0;
    dataSpectr.forEach(function (item) {
        if (maxVal <  item.x) maxVal = item.x;
        if (max < item.y) max = item.y;
    });
    if (max < maxVal) max = maxVal;
    IP = atom.atom.IONIZATION_POTENCIAL;

    scatterChartData = {
        datasets: [{
            pointBorderWidth: 1,
            pointBackgroundColor: 'rgba(255, 255, 255, 0)',
            pointBorderColor: colorArr,
            pointRadius: 5,
            data: dataSpectr,
            pointStyle: icon
        },{
            pointBorderWidth: 0,
            pointRadius: 0,
            data: [{x: 0, y: 0}, {x: 0, y: 0}],
            showLine: true,
            fill: false,
            borderColor: 'green',
            borderWidth: 1,
            pointHoverRadius: 0,
            pointHitRadius: 0
        },{
            pointBorderWidth: 0,
            pointRadius: 0,
            data: [{x: IP, y: IP}, {x: 0, y: IP}],
            showLine: true,
            fill: false,
            borderDash: [4, 4],
            borderColor: 'black',
            borderWidth: 1,
            pointHoverRadius: 0,
            pointHitRadius: 0
        },{
            pointBorderWidth: 0,
            pointRadius: 0,
            data: [{x: IP, y: IP}, {x: IP, y: 0}],
            showLine: true,
            fill: false,
            borderDash: [4, 4],
            borderColor: 'black',
            borderWidth: 1,
            pointHoverRadius: 0,
            pointHitRadius: 0
        }],
        labels: termLabel,
    };

    let elemArr = document.getElementsByName("width");
    if(elemArr[0].checked) {
        fillDatasets(hashFullConfig);
        drawbottomAxis(hashFullConfig);
    }
    if(elemArr[1].checked) {
        fillDatasets(hashAtomicResidue);
        drawbottomAxis(hashAtomicResidue);
    }
    if(elemArr[2].checked) {
        fillDatasets(hashTerm);
        drawbottomAxis(hashTerm);
    }

    resize(0);

    window.myScatter.options.title.text = '';
    myScatter.options.scales.xAxes[0].ticks.suggestedMax = max;
    myScatter.options.scales.yAxes[0].ticks.suggestedMax = max;
    window.myScatter.update();

    fillArraysForSvgLevels(atom.levels);
    //drawSvgConfig();

}


function defineBorder(obj, x) {
    if(obj.e_min > x) {
        obj.e_min = x;
    }
    if(obj.e_max < x) {
        obj.e_max = x;
    }
}


function fill_icon(markers, icon) {
    icon.length = 0;
    for(var i = 0; i<markers.length; i++){
        let m = markers[i].m;
        switch (m) {
            case 0: icon.push('crossRot');
                break;
            case 1: icon.push('circle');
                break;
            case 2: icon.push('riceGrain');
                break;
            case 3: icon.push('triangle');
                break;
            case 4: icon.push('rect');
                break;
            case 5: icon.push('pentagon');
                break;
            case 6: icon.push('hexagon');
                break;
            case 7: icon.push('heptagon');
                break;
            case 8: icon.push('octagon');
                break;
            default:icon.push('star');
        }
    }
}

function graph(h, w) {
    var ctx = document.getElementById('canvas').getContext('2d');
    var ctxZoom = document.getElementById('zoom_chart').getContext('2d');
    ctx.canvas.height = h;
    ctx.canvas.width = w;

    ctxZoom.canvas.height = 200;
    ctxZoom.canvas.width = 250;

    var clipper = {
        beforeDatasetsDraw:  function( chart) {
            Chart.helpers.canvas.unclipArea( chart.ctx);
        },
        afterDatasetsDraw:  function(chart) {
            Chart.helpers.canvas.unclipArea( chart.ctx);
        }
    };

    window.myScatter = new Chart(ctx, {
        plugins:  [clipper],
        type: 'scatter',
        data: scatterChartData,
        options: {
            elements: {
                line: {
                    tension: 0
                },
            },
            responsive: false,
            bezierCurve: false,
            pan: {
                enabled: true,
                mode: 'xy',
                rangeMin: {
                    x: 0,
                    y: 0
                },
            },
            zoom: {
                enabled: true,
                mode: 'xy',
                rangeMin: {
                    x: 0,
                    y: 0
                },
            },
            tooltips: {
                filter: function (tooltipItem) {
                    return tooltipItem.datasetIndex === 0;
                },
                callbacks:{
                    label: function(tooltipItem, data) {
                        return data.labels[tooltipItem.index] || '';
                    },
                },
                intersect: true,
                enabled: false,
                displayColors: false,
                mode: 'index',
                position: 'nearest',
                custom: customTooltips,
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks:{
                        suggestedMax: max,
                        beginAtZero: true,
                        maxRotation: 0,
                        minRotation: 0,
                        precision: 3,
                        callback: function(value) {
                            if (value == max) return "";
                            if (value >= 0) {
                                let t = value.toFixed(3);
                                return Number(t);
                            }
                            else return "";
                        },
                    },
                    scaleLabel: {
                        display: true,
                        labelString: part1Y + part2
                    },
                    afterTickToLabelConversion: function(scaleInstance) {
                        if(scaleInstance.ticks[scaleInstance.ticks.length - 1] !== 0) {
                            scaleInstance.ticks[scaleInstance.ticks.length - 1] = null;
                            scaleInstance.ticksAsNumbers[scaleInstance.ticksAsNumbers.length - 1] = null;
                        }
                        scaleInstance.ticks[0] = null;
                        scaleInstance.ticksAsNumbers[0] = null;
                    },
                }],
                xAxes: [{
                    position: 'top',
                    ticks:{
                        suggestedMax: max,
                        beginAtZero: true,
                        maxRotation: 0,
                        minRotation: 0,
                        precision: 3,
                        callback: function(value) {
                            let t;
                            if (value >= 0) {
                                t = value.toFixed(3);
                                return Number(t);
                            }
                            else return "";
                        },
                    },
                    scaleLabel: {
                        display: true,
                        labelString: part1X + part2
                    },
                    afterTickToLabelConversion: function(scaleInstance) {
                        if(scaleInstance.ticks[0] !== 0) {
                            scaleInstance.ticks[0] = null;
                            scaleInstance.ticksAsNumbers[0] = null;
                        }
                        scaleInstance.ticks[scaleInstance.ticks.length - 1] = null;
                        scaleInstance.ticksAsNumbers[scaleInstance.ticksAsNumbers.length - 1] = null;
                    },
                }]
            }
        },
    });
    window.myScatter.update();

    window.zoomChart = new Chart(ctxZoom, {
        plugins:  [clipper],
        type: 'scatter',
        data: {
            datasets: [{
                pointBorderWidth: 1,
                pointBackgroundColor: 'rgba(255, 255, 255, 0)',
                pointBorderColor: [],
                pointRadius: 5,
                data: [],
                pointStyle: []
            }],
            labels: [],
        },
        options: {
            elements: {
                line: {
                    tension: 0
                },
            },
            responsive: false,
            bezierCurve: false,
            title: {
                display: false,
            },
            legend: {
                display: false,
            },
            tooltips: {
                filter: function (tooltipItem) {
                    return tooltipItem.datasetIndex === 0;
                },
                callbacks:{
                    label: function(tooltipItem, data) {
                        return data.labels[tooltipItem.index] || '';
                    },
                },
                intersect: true,
                enabled: false,
                displayColors: false,
                mode: 'index',
                position: 'nearest',
                custom: zoomTooltips,
            },
            scales: {
                yAxes: [{
                    ticks:{
                        maxTicksLimit: 4,
                        maxRotation: 0,
                        minRotation: 0,
                        precision: 2,
                        callback: function(value) {
                            if (value == max) return "";
                            if (value >= 0) {
                                let t = value.toFixed(2);
                                return Number(t);
                            }
                            else return "";
                        },
                    },
                    afterTickToLabelConversion: function(scaleInstance) {
                        if(scaleInstance.ticks[scaleInstance.ticks.length - 1] !== 0) {
                            scaleInstance.ticks[scaleInstance.ticks.length - 1] = null;
                            scaleInstance.ticksAsNumbers[scaleInstance.ticksAsNumbers.length - 1] = null;
                        }
                        scaleInstance.ticks[0] = null;
                        scaleInstance.ticksAsNumbers[0] = null;
                    },
                }],
                xAxes: [{
                    ticks:{
                        maxTicksLimit: 4,
                        maxRotation: 0,
                        minRotation: 0,
                        precision: 2,
                        callback: function(value) {
                            let t;
                            if (value >= 0) {
                                t = value.toFixed(2);
                                return Number(t);
                            }
                            else return "";
                        },
                    },
                    afterTickToLabelConversion: function(scaleInstance) {
                        if(scaleInstance.ticks[0] !== 0) {
                            scaleInstance.ticks[0] = null;
                            scaleInstance.ticksAsNumbers[0] = null;
                        }
                        scaleInstance.ticks[scaleInstance.ticks.length - 1] = null;
                        scaleInstance.ticksAsNumbers[scaleInstance.ticksAsNumbers.length - 1] = null;
                    },
                }]
            }
        },
    });
    window.zoomChart.update();
}


function show_selected(){
    let min = document.getElementById("min").value;
    let max = document.getElementById("max").value;
    updateChart(0, min, max);
    click_intens();
}

function show_visible(){
    document.getElementById("max").value = 7600;
    document.getElementById("min").value = 3800;
    updateChart(0, 3800, 7600);
    click_intens();
}

function show_all(){
    updateChart(0, 0, 0);
    click_intens();
}


function click_random() {
    if(document.getElementById('random').checked) {
        document.getElementById('intens').disabled = true;
        let nIcon = [];
        fill_icon(markers, nIcon);
        //scatterChartData.datasets[0].pointBackgroundColor = randCol;
        scatterChartData.datasets[0].pointStyle = nIcon;
        scatterChartData.datasets[0].pointBorderColor = randCol;
        window.myScatter.update();
    }
    else {
        document.getElementById('intens').disabled = false;
        click_intens();
    }
}

updateChart(1, 0, 0);

document.getElementById('chartCont').addEventListener('mousedown', function() {
    isdown = true;
});

document.getElementById('chartCont').addEventListener('mouseup', function() {
    isdown = false;
});

document.getElementById('chartCont').addEventListener('wheel', function() {
    displayWidth();
});

document.getElementById('chartCont').addEventListener('click', function(evt) {
    let point = myScatter.getElementAtEvent(evt)[0];
    let nIcon = [],
        ncolArr = [],
        indexes = [],
        col = [];
    if (point) {
        if(document.getElementById('random').checked) ncolArr = randCol;
        else ncolArr = colorArr;
        let er = 0;
        idx = point._index;
        let minW = document.getElementById("min").value;
        let maxW = document.getElementById("max").value;
        while (idx != atom.transitions[er].numb) er++;

        let hovered = atom.transitions[er];

        $('#up_l').html(hovered.up_l);
        $('#low_l').html(hovered.low_l);

        let hash = crc32(hashStr(hovered));
        if(hashMap.has(hash)) {
            let j = 0;
            if(selected){
                for (let i = 0; i < atom.transitions.length; i++) {
                    if (atom.transitions[i].ID_LOWER_LEVEL && atom.transitions[i].ID_UPPER_LEVEL && (atom.transitions[i].WAVELENGTH > minW) && (atom.transitions[i].WAVELENGTH < maxW)) {
                        let item = ncolArr[j];
                        let b = item.split(',');
                        col.push(b[0] + ',' + b[1] + ',' + b[2] + ', 0.03)');
                        j++;
                    }
                }
                for (let g = 0; g < hashMap.get(hash).length; g++) {
                    if ((hashMap.get(hash)[g].WAVELENGTH > minW) && (hashMap.get(hash)[g].WAVELENGTH < maxW)){
                        let item = ncolArr[hashMap.get(hash)[g].numb];
                        let b = item.split(',');
                        col[hashMap.get(hash)[g].numb] = (b[0] + ',' + b[1] + ',' + b[2] + ', 1.0)');
                        indexes.push(hashMap.get(hash)[g].numb);
                    }
                }
            }
            else {
                for (let i = 0; i < atom.transitions.length; i++) {
                    if (atom.transitions[i].ID_LOWER_LEVEL && atom.transitions[i].ID_UPPER_LEVEL) {
                        let item = ncolArr[j];
                        let b = item.split(',');
                        col.push(b[0] + ',' + b[1] + ',' + b[2] + ', 0.03)');
                        j++;
                    }
                }
                for (let g = 0; g < hashMap.get(hash).length; g++) {
                    let item = ncolArr[hashMap.get(hash)[g].numb];
                    let b = item.split(',');
                    col[hashMap.get(hash)[g].numb] = (b[0] + ',' + b[1] + ',' + b[2] + ', 1.0)');
                    indexes.push(hashMap.get(hash)[g].numb);
                }
            }
        }
        if(document.getElementById('random').checked) {
            //scatterChartData.datasets[0].pointBackgroundColor = col;
            scatterChartData.datasets[0].pointBackgroundColor = 'rgba(255, 255, 255, 0)';
            window.zoomChart.data.datasets[0].pointBackgroundColor = 'rgba(255, 255, 255, 0)';
            fill_icon(markers, nIcon);
        }
        else {
            scatterChartData.datasets[0].pointBackgroundColor = 'rgba(255, 255, 255, 0)';
            window.zoomChart.data.datasets[0].pointBackgroundColor = 'rgba(255, 255, 255, 0)';
            fill_icon(markers, nIcon);
        }
        scatterChartData.datasets[0].pointStyle = nIcon;
        scatterChartData.datasets[0].pointBorderColor = col;
        window.myScatter.update();

        let data = [],
            style = [],
            labels = [],
            bordercolor = [];

        indexes.forEach(function (i) {
            data.push(scatterChartData.datasets[0].data[i]);
            labels.push(scatterChartData.labels[i]);
            style.push(nIcon[i]);
            bordercolor.push(col[i]);
        });

        if(document.getElementById('random').checked) {
            //window.zoomChart.data.datasets[0].pointBackgroundColor = bordercolor;
        }

        window.zoomChart.data.datasets[0].data = data;
        window.zoomChart.data.datasets[0].pointStyle = style;
        window.zoomChart.data.datasets[0].pointBorderColor = bordercolor;
        window.zoomChart.data.labels = labels;
        window.zoomChart.update();
    }
    else {
        if(document.getElementById('random').checked) click_random();
        else click_intens();
    }
});

document.getElementById('chartCont').addEventListener('mousemove', function(evt) {
    if(isdown) displayWidth();
    let point = myScatter.getElementAtEvent(evt)[0];
    if (!point) {
        if(!document.getElementById('chartjs-tooltip').hidden)
            document.getElementById('chartjs-tooltip').hidden=true;
    }
    else document.getElementById('chartjs-tooltip').hidden=false;
});

function displayWidth() {
    var elemArr = document.getElementsByName("width");
    if(elemArr[0].checked) {drawbottomAxis(hashFullConfig);}
    if(elemArr[1].checked) {drawbottomAxis(hashAtomicResidue);}
    if(elemArr[2].checked) {drawbottomAxis(hashTerm);}
}

function drawbottomAxis(table){
    let width = myScatter.canvas.width;
    let ruler = "<svg width='" + width + "' height='65' id='cf_ruler' style='background-color:white;'>";
    let near = [];
    let n = 0;
    for (let elem of table.values()) {
        let max_pixel = myScatter.getDatasetMeta(0).data[elem.n_max]._model.x;
        let min_pixel = myScatter.getDatasetMeta(0).data[elem.n_min]._model.x;
        let pr = (max_pixel - min_pixel) / width*25+7;
        pr = pr > 35 ? 35 : pr;
        if(max_pixel == min_pixel)
            ruler += "<line x1='" + min_pixel + "' y1='0' x2='" + min_pixel + "' y2='" + pr + "' stroke-width='1' stroke='" + svgColors[n] + "'></line>";
        else {
            ruler += "<line x1='" + min_pixel + "' y1='0' x2='" + min_pixel + "' y2='" + pr + "' stroke-width='1' stroke='" + svgColors[n] + "'></line>";
            ruler += "<line x1='" + min_pixel + "' y1='" + pr + "' x2='" + max_pixel + "' y2='" + pr + "' stroke-width='1' stroke='" + svgColors[n] + "'></line>";
            ruler += "<line x1='" + max_pixel + "' y1='0' x2='" + max_pixel + "' y2='" + pr + "' stroke-width='1' stroke='" + svgColors[n] + "'></line>";
        }
        let mid = (max_pixel + min_pixel) / 2;
        let cl = false;
        let gap = elem.config.replace(/\<sub\>/gi, "").replace(/\<\/sub\>/gi, "").replace(/\<sup\>/gi, "").replace(/\<\/sup\>/gi, "").length * 7;
        for(let i = 0; i<near.length; i++){
            if(Math.abs(near[i]-mid)<gap) {
                cl = true;
                break;
            }
        }
        if (!cl){
            ruler += "<text x='" + mid + "' y='" + (pr+20) + "' fill='" + svgColors[n] + "' style='text-anchor: Middle;'><tspan>"
                + elem.config.replace(/\<sup\>/gi, "</tspan><tspan dy='-9' style='font-size:11px;'>")
                    .replace(/\<\/sup\>/gi, "</tspan><tspan dy='9'>")
                    .replace(/\<sub\>/gi, "</tspan><tspan dy='9' style='font-size:11px;'>")
                    .replace(/\<\/sub\>/gi, "</tspan><tspan dy='-9'>")
                + "</tspan></text>";
            near.push(mid);
        }
        n++;
        if(n==svgColors.length) n = 0;
    }
    ruler+= "</svg>";
    $('#cf_ruler').remove();
    $('#chartCont').append(ruler);
}

function fillDatasets(hashMap) {
    if(scatterChartData.datasets.length != 4){
        while (scatterChartData.datasets.length != 4) scatterChartData.datasets.pop();
    }
    let c = 0;
    for (let elem of hashMap.values()) {
        let setOfConfig = {
            pointBorderWidth: 0,
            pointRadius: 0,
            data: [{x: elem.min, y: 0}, {x: elem.min, y: max+10000}, {x: elem.max, y: max+10000}, {x: elem.max, y: 0}],
            showLine: true,
            fill: true,
            borderColor: barColors[c],
            borderWidth: 1,
            backgroundColor: barColors[c],
            pointHoverRadius: 0,
            pointHitRadius: 0
        };
        scatterChartData.datasets.push(setOfConfig);
        c++;
        if(c==svgColors.length) c = 0;
    }
    window.myScatter.update();
}

var widthRad = document.getElementsByName('width');
for (var i = 0; i < widthRad.length; i++) {
    widthRad[i].addEventListener('change', function () {
        if (this.value == 1) {
            fillDatasets(hashFullConfig);
            drawbottomAxis(hashFullConfig);
        }
        if (this.value == 2) {
            fillDatasets(hashAtomicResidue);
            drawbottomAxis(hashAtomicResidue);
        }
        if (this.value == 3) {
            fillDatasets(hashTerm);
            drawbottomAxis(hashTerm);
        }
        if (this.value == 4) {
            if(scatterChartData.datasets.length != 4){
                while (scatterChartData.datasets.length != 4) scatterChartData.datasets.pop();
            }
            $('#cf_ruler').remove();
        }
        window.myScatter.update();
    });
}

function fillHashConfigTable(hashTable, str, x, numb) {
    let hash = crc32(str);
    if (hashTable.has(hash)){
        if(hashTable.get(hash).min > x) {
            hashTable.get(hash).min = x;
            hashTable.get(hash).n_min = numb;
        }
        if(hashTable.get(hash).max < x) {
            hashTable.get(hash).max = x;
            hashTable.get(hash).n_max = numb;
        }
    }
    else {
        let hashEl = {
            config: str,
            min: x,
            max: x,
            n_max: numb,
            n_min: numb,
        };
        hashTable.set(hash, hashEl);
    }
}

/**
 * @return {number}
 */
function EtoPx(E, Emax, Emin, maxPx, minPx) {
    return (maxPx - minPx) * (E - Emin) / (Emax - Emin) + minPx;
}

function fillArraysForSvgLevels(levels){
    numbOfConfig = 0;
    svgMaxVal = 0;
    numbOfConfig= levels.length;
    let len = levels.length;
    for(let i = 0; i<len;i++){
        let level = levels[i];
        if (level.TERMSECONDPART == null) level.TERMSECONDPART = "";

        let pref = "",
            second,
            temp = "",
            x = level.ENERGY;

        if (svgMaxVal < x) svgMaxVal = x;

        if(level.TERMPREFIX) pref = level.TERMPREFIX;
        second = level.TERMSECONDPART;
        let config = level.CONFIG;
        if((config!=null) && (config!="")) temp = config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;");

        if (level.TERMMULTIPLY == 0) level.low_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + level.TERMFIRSTPART + "</span>" + "<sup>&deg;</sup>";
        else level.low_l = "<span>" + temp + ": " + "<span>" + second + "</span>" +"</span>" + "<sup>" + pref + "</sup>" + "<span>" + level.TERMFIRSTPART + "</span>";

        let termforhash = level.low_l.replace(/\<\/span\>/gi, "").replace(/\<span\>/gi, "");

        termforhash = termforhash.split(": ");
        termforhash = termforhash[1];
        let termJ = termforhash+"<sub>"+level.J+"</sub>";
        if((config!=null) && (config!="")) {
            let configWithoutResidues = temp.replace(/\(([^?]+?)\)/gi, "");
            if(configTree[configWithoutResidues] == undefined) {
                configTree[configWithoutResidues]={"e_min": x, "e_max": x};
                configTree[configWithoutResidues][temp]={"e_min": x, "e_max": x};
                configTree[configWithoutResidues][temp][termforhash]={"e_min": x, "e_max": x};
                configTree[configWithoutResidues][temp][termforhash][termJ]={"e_min": x, "e_max": x};
            }
            else {
                defineBorder(configTree[configWithoutResidues], x);
                if(configTree[configWithoutResidues][temp] != undefined){
                    defineBorder(configTree[configWithoutResidues][temp], x);
                    if (configTree[configWithoutResidues][temp][termforhash] != undefined){
                        defineBorder(configTree[configWithoutResidues][temp][termforhash], x);
                        if (configTree[configWithoutResidues][temp][termforhash][termJ] != undefined){
                            defineBorder(configTree[configWithoutResidues][temp][termforhash][termJ], x);
                        }
                        else configTree[configWithoutResidues][temp][termforhash][termJ]={"e_min": x, "e_max": x};
                    }
                    else {
                        configTree[configWithoutResidues][temp][termforhash]={"e_min": x, "e_max": x};
                        configTree[configWithoutResidues][temp][termforhash][termJ]={"e_min": x, "e_max": x};
                    }
                }
                else {
                    configTree[configWithoutResidues][temp]={"e_min": x, "e_max": x};
                    configTree[configWithoutResidues][temp][termforhash]={"e_min": x, "e_max": x};
                    configTree[configWithoutResidues][temp][termforhash][termJ]={"e_min": x, "e_max": x};
                }
            }
        }

    }

    let freePlaceJ = [];
    freePlaceJ.push({h: 30, arr: []});
    freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});

    let freePlace = [];
    freePlace.push({h: 30, arr: []});
    freePlace[0].arr.push({min: 0, max: svgMaxVal});

    let freePlaceConfig = [];
    freePlaceConfig.push({h: 30, arr: []});
    freePlaceConfig[0].arr.push({min: 0, max: svgMaxVal});

    let freePlacemain = [];
    freePlacemain.push({h: 30, arr: []});
    freePlacemain[0].arr.push({min: 0, max: svgMaxVal});

    let fitting = function(config, h, freePlace) {
        let fit = false;
        for (var i = 0; i < freePlace.length; i++) {
            for (var k = 0; k < freePlace[i].arr.length; k++) {
                let item = freePlace[i].arr[k];
                if ((config.e_max <= item.max) && (config.e_min >= item.min)) {
                    if((h <= freePlace[i].h) || (i == freePlace.length-1)) {
                        freePlace[i].arr.push({min: config.e_max, max: item.max});
                        item.max = config.e_min;
                        fit = true;
                        if(freePlace[i].h < h) freePlace[i].h = h;
                        break;
                    }
                }
            }
            if (fit) break;
        }
        if(fit) return 0;
        else {
            freePlace.push({h: h, arr: []});
            freePlace[freePlace.length-1].arr.push({min: 0, max: svgMaxVal});
            fitting(config, h, freePlace);
        }
    };

    for (var configWithoutResidues in configTree) {
        if (configWithoutResidues != "e_min" && configWithoutResidues != "e_max" && configWithoutResidues != "h") {
            for (var fullConfig in configTree[configWithoutResidues]) {
                if (fullConfig != "e_min" && fullConfig != "e_max"  && fullConfig != "h") {
                    for (var term in configTree[configWithoutResidues][fullConfig]) {
                        if (term != "e_min" && term != "e_max" && term != "h") {
                            freePlaceJ.length = 0;
                            freePlaceJ.push({h: 30, arr: []});
                            freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
                            let hei=0;
                            for (var termJ in configTree[configWithoutResidues][fullConfig][term]) {
                                if (termJ != "e_min" && termJ != "e_max" && termJ != "h") {
                                    let j = configTree[configWithoutResidues][fullConfig][term][termJ];
                                    fitting(j,30, freePlaceJ);
                                }
                            }
                            let t = configTree[configWithoutResidues][fullConfig][term];
                            for(var i = 0; i<freePlaceJ.length; i++) hei+=freePlaceJ[i].h;
                            t.h = hei;
                        }
                    }
                }
            }
        }
    }

    for (var configWithoutResidues in configTree) {
        if (configWithoutResidues != "e_min" && configWithoutResidues != "e_max" && configWithoutResidues != "h") {
            for (var fullConfig in configTree[configWithoutResidues]) {
                if (fullConfig != "e_min" && fullConfig != "e_max"  && fullConfig != "h") {

                    freePlace.length = 0;
                    freePlace.push({h: 30, arr: []});
                    freePlace[0].arr.push({min: 0, max: svgMaxVal});
                    let hei=0;
                    for (var term in configTree[configWithoutResidues][fullConfig]) {
                        if (term != "e_min" && term != "e_max" && term != "h") {
                            let t = configTree[configWithoutResidues][fullConfig][term];
                            fitting(t,t.h, freePlace);
                        }
                    }
                    let fc = configTree[configWithoutResidues][fullConfig];
                    for(var i = 0; i<freePlace.length; i++) hei+=freePlace[i].h;
                    fc.h = hei;
                }
            }
        }
    }

    for (var configWithoutResidues in configTree) {
        if (configWithoutResidues != "e_min" && configWithoutResidues != "e_max" && configWithoutResidues != "h") {
            freePlaceConfig.length = 0;
            freePlaceConfig.push({h: 30, arr: []});
            freePlaceConfig[0].arr.push({min: 0, max: svgMaxVal});
            let hei = 0;
            for (var fullConfig in configTree[configWithoutResidues]) {
                if (fullConfig != "e_min" && fullConfig != "e_max" && fullConfig != "h") {
                    let fc = configTree[configWithoutResidues][fullConfig];
                    fitting(fc, fc.h, freePlaceConfig);
                }
            }
            let res = configTree[configWithoutResidues];
            for(var i = 0; i<freePlaceConfig.length; i++) hei+=freePlaceConfig[i].h;
            res.h = hei;
        }
    }
}

// function drawSvgConfig(){
//     let mainsvg;
//     let tooltips = "";
//     let width = $(window).width();
//     let minpx = 50,
//         svgheight = numbOfConfig*43,
//         maxpx = width - 200;
//     svgMaxVal = svgMaxVal.toString().split(".")[0];
//     svgMaxVal = (Number(svgMaxVal.substring(0, 2))+1) * Math.pow(10,svgMaxVal.length-2);
//     let h = svgMaxVal/10;
//     mainsvg = "<svg width='" + width + "' height='"+ svgheight+ "' id='level_svg' style='background-color:white;'>";
//     let heightpx = -40;
//
//
//     mainsvg += "<line x1='" + minpx + "' y1='"+(heightpx+70)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     mainsvg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+65)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     mainsvg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+75)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     for(let w = 0; w <= svgMaxVal; w += h){
//         mainsvg += "<line x1='"+ EtoPx(w, svgMaxVal,0, maxpx, minpx) + "' y1='"+(heightpx+66)+"' x2='" + EtoPx(w, svgMaxVal,0, maxpx, minpx) + "' y2='"+(heightpx+74)+"' stroke-width='2' stroke='black'></line>";
//         mainsvg += "<text x='" + EtoPx(w, svgMaxVal, 0,maxpx, minpx) + "' y='" + (heightpx+59) + "' fill='black' style='text-anchor: Middle;'>" + w+ "</text>";
//     }
//     mainsvg += "<foreignObject x='"+(width-140)+"' y='"+(heightpx+40)+"' width='50' height='40'><div style='text-align: left; border-radius: 0; background-color: white; color: black; padding: 0 0'>cm<sup>-1</sup></div></foreignObject>";
//
//     let freePlace = [];
//     freePlace.push({h: 30, arr: []});
//     freePlace[0].arr.push({min: 0, max: svgMaxVal});
//
//
//     let freePlaceConfig = [];
//     freePlaceConfig.push({h: 30, arr: []});
//     freePlaceConfig[0].arr.push({min: 0, max: svgMaxVal});
//
//     let freePlacemain = [];
//     freePlacemain.push({h: 30, arr: []});
//     freePlacemain[0].arr.push({min: 0, max: svgMaxVal});
//
//     let freePlaceJ = [];
//     freePlaceJ.push({h: 30, arr: []});
//     freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
//
//     let drawfit = function(config, id, h, freePlace, begin, color) {
//         let fit = false;
//         for (var i = 0; i < freePlace.length; i++) {
//             for (var k = 0; k < freePlace[i].arr.length; k++) {
//                 let item = freePlace[i].arr[k];
//                 if ((config.e_max <= item.max) && (config.e_min >= item.min)) {
//                     if((h <= freePlace[i].h) || (i == freePlace.length-1)) {
//                         freePlace[i].arr.push({min: config.e_max, max: item.max});
//                         item.max = config.e_min;
//                         fit = true;
//                         let offset = 0;
//                         for (var v = 0; v < i; v++) offset += freePlace[v].h;
//                         if (freePlace[i].h < h) freePlace[i].h = h;
//                         config.b = offset + begin;
//                         if (color == "blue") mainsvg += "<line id='" + id + "' class='line' x1='" + EtoPx(config.e_min, svgMaxVal, 0, maxpx, minpx) + "' y1='" + (offset + begin) + "' x2='" +  EtoPx(config.e_min, svgMaxVal, 0, maxpx, minpx) + "' y2='" +(offset + begin+h-3) + "' style='stroke:" + color + ";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'></line>";
//                         else {
//                             mainsvg += "<rect id='" + id + "' class='rect' x='" + EtoPx(config.e_min, svgMaxVal, 0, maxpx, minpx) + "' y='" + (offset + begin) + "' width='" + (EtoPx(config.e_max, svgMaxVal, 0, maxpx, minpx) - EtoPx(config.e_min, svgMaxVal, 0, maxpx, minpx) + 1) + "' style='stroke:" + color + ";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'";
//                             if (color == "green") mainsvg += " height='" + (h-3) + "'onclick='showfullConfig(this);'></rect>";
//                             else if (color == "black") mainsvg += "height='" + (h-3) + "' onclick='showterm(this);'></rect>";
//                             else if (color == "red") mainsvg += "height='" + (h-3) + "' onclick='showConfig(this);'></rect>";
//                             else mainsvg += "></rect>";
//                         }
//                         tooltips += "<foreignObject id='" + id + "_tooltip" + "' display='none' x='" + (EtoPx(config.e_max, svgMaxVal, 0, maxpx, minpx) + 1) + "' y='" + (offset+begin)+ "' width='150' height='100'><div>" + id + "<br>E<sub>min</sub>: " + config.e_min + " cm<sup>-1</sup><br>E<sub>max</sub>: " + config.e_max + " cm<sup>-1</sup></div></foreignObject>";
//                         break;
//                     }
//                 }
//             }
//             if (fit) break;
//         }
//         if(fit) return 0;
//         else {
//             freePlace.push({h: h, arr: []});
//             freePlace[freePlace.length-1].arr.push({min: 0, max: svgMaxVal});
//             drawfit(config, id, h, freePlace, begin, color);
//         }
//     };
//
//     freePlacemain = [];
//     freePlacemain.push({h: 30, arr: []});
//     freePlacemain[0].arr.push({min: 0, max: svgMaxVal});
//
//     for (var configWithoutResidues in configTree) {
//         if (configWithoutResidues != "e_min" && configWithoutResidues != "e_max" && configWithoutResidues != "b" && configWithoutResidues != "h") {
//             let res = configTree[configWithoutResidues];
//             drawfit(res, configWithoutResidues, res.h, freePlacemain, 60, "red");
//             freePlaceConfig = [];
//             freePlaceConfig.push({h: 30, arr: []});
//             freePlaceConfig[0].arr.push({min: 0, max: svgMaxVal});
//
//             for (var fullConfig in configTree[configWithoutResidues]) {
//                 if (fullConfig != "e_min" && fullConfig != "e_max" && fullConfig != "b" && fullConfig != "h") {
//                     let fc = configTree[configWithoutResidues][fullConfig];
//                     drawfit(fc, fullConfig, fc.h, freePlaceConfig, res.b, "green");
//                     freePlace = [];
//                     freePlace.push({h: 30, arr: []});
//                     freePlace[0].arr.push({min: 0, max: svgMaxVal});
//                     for (var term in configTree[configWithoutResidues][fullConfig]) {
//                         if (term != "e_min" && term != "e_max" && term != "b" && term != "h") {
//                             let t = configTree[configWithoutResidues][fullConfig][term];
//                             drawfit(t, fullConfig + ": " + term, t.h, freePlace, fc.b, "black");
//                             freePlaceJ = [];
//                             freePlaceJ.push({h: 30, arr: []});
//                             freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
//                             for (var termJ in configTree[configWithoutResidues][fullConfig][term]) {
//                                 if (termJ != "e_min" && termJ != "e_max" && termJ != "h" && termJ != "b") {
//                                     let j = configTree[configWithoutResidues][fullConfig][term][termJ];
//                                     drawfit(j,fullConfig + ": " + termJ, 30, freePlaceJ, t.b, "blue");
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }
//         }
//     }
//
//
//     mainsvg += tooltips;
//     let lines = "<line id='line1' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
//     lines += "<line id='line2' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
//     mainsvg += lines;
//     mainsvg += "</svg>";
//     $('#level_svg').remove();
//     $('#svg-holder').append(mainsvg);
// }

function showtooltip(elem) {
    let id = elem.getAttribute("id")+"_tooltip";
    let tooltip = document.getElementById(id);
    tooltip.setAttribute("display", "true");

    if(elem.getAttribute("class")=="rect") {
        let line1 = document.getElementById("line1");
        let line2 = document.getElementById("line2");
        line1.setAttribute("x1", elem.getAttribute("x"));
        line1.setAttribute("y1", elem.getAttribute("y"));
        line1.setAttribute("x2", elem.getAttribute("x"));
        line1.setAttribute("y2", 30);
        line1.setAttribute("display", "true");

        line2.setAttribute("x1", Number(elem.getAttribute("x")) + Number(elem.getAttribute("width")));
        line2.setAttribute("y1", elem.getAttribute("y"));
        line2.setAttribute("x2", Number(elem.getAttribute("x")) + Number(elem.getAttribute("width")));
        line2.setAttribute("y2", 30);
        line2.setAttribute("display", "true");
    }

}

function hidetooltip(rect) {
    let id = rect.getAttribute("id")+"_tooltip";
    let tooltip = document.getElementById(id);
    tooltip.setAttribute("display", "none");
}

// document.oncontextmenu = function () {
//     return false;
// };
//
// function backtomain() {
//     if(lvl == 1) {
//         drawSvgConfig();
//         lvl--;
//     }
//     else if(lvl == 2){
//         lvl--;
//         showConfig(prevConfigWithoutResidues);
//     }
//     else if(lvl == 3){
//         lvl--;
//         showfullConfig(prevfullConfig);
//     }
//     return false;
// }

// var lvl = 0;
// function showConfig(config) {
//     lvl = 1;
//     let configWithoutResidues;
//     if (typeof config === "string" || config instanceof String) {
//         configWithoutResidues = config;
//     }
//     else configWithoutResidues = config.getAttribute("id");
//     let svg="";
//     let tooltips = "";
//     let width = $(window).width();
//     let minpx = 50,
//         svgheight = 1000,
//         maxpx = width - 200;
//     let maxE = configTree[configWithoutResidues].e_max;
//     maxE = maxE.toString().split(".")[0];
//     maxE = Number(maxE)+2;
//     let minE = configTree[configWithoutResidues].e_min;
//     minE = minE.toString().split(".")[0];
//     minE = Number(minE)-2;
//     let h = (maxE - minE)/10;
//     svg = "<svg width='" + width + "' height='"+ svgheight+ "' id='level_svg' style='background-color:white;'>";
//     let heightpx = -40;
//
//     svg += "<line x1='" + minpx + "' y1='"+(heightpx+70)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     svg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+65)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     svg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+75)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     for(let w = minE; w <= maxE; w += h){
//         svg += "<line x1='"+ EtoPx(w, maxE, minE,maxpx, minpx) + "' y1='"+(heightpx+66)+"' x2='" + EtoPx(w, maxE, minE,maxpx, minpx) + "' y2='"+(heightpx+74)+"' stroke-width='2' stroke='black'></line>";
//         svg += "<text x='" + EtoPx(w, maxE,minE, maxpx, minpx) + "' y='" + (heightpx+59) + "' fill='black' style='text-anchor: Middle;'>" + w.toFixed(1) + "</text>";
//     }
//     svg += "<foreignObject x='"+(width-140)+"' y='"+(heightpx+40)+"' width='50' height='40'><div style='text-align: left; border-radius: 0; background-color: white; color: black; padding: 0 0'>cm<sup>-1</sup></div></foreignObject>";
//
//     let freePlace = [];
//     freePlace.push({h: 30, arr: []});
//     freePlace[0].arr.push({min: 0, max: svgMaxVal});
//
//     let freePlaceConfig = [];
//     freePlaceConfig.push({h: 30, arr: []});
//     freePlaceConfig[0].arr.push({min: 0, max: svgMaxVal});
//
//     let freePlacemain = [];
//     freePlacemain.push({h: 30, arr: []});
//     freePlacemain[0].arr.push({min: 0, max: svgMaxVal});
//
//     let freePlaceJ = [];
//     freePlaceJ.push({h: 30, arr: []});
//     freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
//
//     let drawfit = function(config, id, h, freePlace, begin, color) {
//         let fit = false;
//         for (var i = 0; i < freePlace.length; i++) {
//             for (var k = 0; k < freePlace[i].arr.length; k++) {
//                 let item = freePlace[i].arr[k];
//                 if ((config.e_max <= item.max) && (config.e_min >= item.min)) {
//                     if((h <= freePlace[i].h) || (i == freePlace.length-1)) {
//                         freePlace[i].arr.push({min: config.e_max, max: item.max});
//                         item.max = config.e_min;
//                         fit = true;
//                         let offset = 0;
//                         for(var v = 0; v<i; v++) offset+=freePlace[v].h;
//                         if(freePlace[i].h < h) freePlace[i].h = h;
//                         config.b = offset + begin;
//                         if (color == "blue") svg += "<line id='" + id + "' class='line' x1='" + EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y1='" + (offset + begin) + "' x2='" +  EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y2='" +(offset + begin+h-3) + "' style='stroke:" + color + ";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'></line>";
//                         else {
//                             svg += "<rect id='" + id + "' x='" + EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y='" + (offset + begin) + "' width='" + (EtoPx(config.e_max, maxE, minE, maxpx, minpx) - EtoPx(config.e_min, maxE, minE, maxpx, minpx) + 1) + "' height='" + (h-3) + "' style='stroke:" + color + ";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'";
//                             if (color == "green") svg += "onclick='showfullConfig(this);'></rect>";
//                             else if (color == "black") svg += "onclick='showterm(this);'></rect>";
//                             else svg += "></rect>";
//                         }
//                         tooltips += "<foreignObject id='" + id + "_tooltip" + "' display='none' x='" + (EtoPx(config.e_max, maxE, minE, maxpx, minpx) + 1) + "' y='" + (offset+begin)+ "' width='150' height='100'><div>" + id + "<br>E<sub>min</sub>: " + config.e_min + " cm<sup>-1</sup><br>E<sub>max</sub>: " + config.e_max + " cm<sup>-1</sup></div></foreignObject>";
//                         break;
//                     }
//                 }
//             }
//             if (fit) break;
//         }
//         if(fit) return 0;
//         else {
//             freePlace.push({h: h, arr: []});
//             freePlace[freePlace.length-1].arr.push({min: 0, max: svgMaxVal});
//             drawfit(config, id, h, freePlace, begin, color);
//         }
//     };
//
//     freePlacemain = [];
//     freePlacemain.push({h: 30, arr: []});
//     freePlacemain[0].arr.push({min: 0, max: svgMaxVal});
//
//     let res = configTree[configWithoutResidues];
//     drawfit(res, configWithoutResidues, res.h, freePlacemain, 60, "red");
//     freePlaceConfig = [];
//     freePlaceConfig.push({h: 30, arr: []});
//     freePlaceConfig[0].arr.push({min: 0, max: svgMaxVal});
//
//     for (var fullConfig in configTree[configWithoutResidues]) {
//         if (fullConfig != "e_min" && fullConfig != "e_max" && fullConfig != "b" && fullConfig != "h") {
//             let fc = configTree[configWithoutResidues][fullConfig];
//             drawfit(fc, fullConfig, fc.h, freePlaceConfig, res.b, "green");
//             freePlace = [];
//             freePlace.push({h: 30, arr: []});
//             freePlace[0].arr.push({min: 0, max: svgMaxVal});
//             for (var term in configTree[configWithoutResidues][fullConfig]) {
//                 if (term != "e_min" && term != "e_max" && term != "b" && term != "h") {
//                     let t = configTree[configWithoutResidues][fullConfig][term];
//                     drawfit(t, fullConfig + ": " + term, t.h, freePlace, fc.b, "black");
//                     freePlaceJ = [];
//                     freePlaceJ.push({h: 30, arr: []});
//                     freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
//                     for (var termJ in configTree[configWithoutResidues][fullConfig][term]) {
//                         if (termJ != "e_min" && termJ != "e_max" && termJ != "h" && termJ != "b") {
//                             let j = configTree[configWithoutResidues][fullConfig][term][termJ];
//                             drawfit(j,fullConfig + ": " + termJ, 30, freePlaceJ, t.b, "blue");
//                         }
//                     }
//                 }
//             }
//         }
//     }
//
//     svg += tooltips;
//     let lines = "<line id='line1' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
//     lines += "<line id='line2' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
//     svg += lines;
//     svg += "</svg>";
//     $('#level_svg').remove();
//     $('#svg-holder').append(svg);
// }
//
// var prevConfigWithoutResidues;
//
// function showfullConfig(elem){
//     lvl = 2;
//     let fullConfig;
//     if (typeof elem === "string" || elem instanceof String) {
//         fullConfig = elem;
//     }
//     else fullConfig = elem.getAttribute("id");
//     fullConfig = fullConfig.replace(/°/gi, "&deg;");
//     let configWithoutResidues = fullConfig.replace(/\(([^?]+?)\)/gi, "");
//     prevConfigWithoutResidues = configWithoutResidues;
//     let svg;
//     let tooltips = "";
//     let width = $(window).width();
//     let minpx = 50,
//         svgheight = 1000,
//         maxpx = width - 200;
//     let maxE = configTree[configWithoutResidues][fullConfig].e_max;
//     maxE = maxE.toString().split(".")[0];
//     maxE = Number(maxE)+2;
//     let minE = configTree[configWithoutResidues][fullConfig].e_min;
//     minE = minE.toString().split(".")[0];
//     minE = Number(minE)-2;
//     let h = (maxE - minE)/10;
//     svg = "<svg width='" + width + "' height='"+ svgheight+ "' id='level_svg' style='background-color:white;'>";
//     let heightpx = -40;
//
//     svg += "<line x1='" + minpx + "' y1='"+(heightpx+70)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     svg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+65)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     svg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+75)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
//     for(let w = minE; w <= maxE; w += h){
//         svg += "<line x1='"+ EtoPx(w, maxE, minE,maxpx, minpx) + "' y1='"+(heightpx+66)+"' x2='" + EtoPx(w, maxE, minE, maxpx, minpx) + "' y2='"+(heightpx+74)+"' stroke-width='2' stroke='black'></line>";
//         svg += "<text x='" + EtoPx(w, maxE, minE, maxpx, minpx) + "' y='" + (heightpx+59) + "' fill='black' style='text-anchor: Middle;'>" + w.toFixed(1) + "</text>";
//     }
//     svg += "<foreignObject x='"+(width-140)+"' y='"+(heightpx+40)+"' width='50' height='40'><div style='text-align: left; border-radius: 0; background-color: white; color: black; padding: 0 0'>cm<sup>-1</sup></div></foreignObject>";
//
//     let freePlace = [];
//     freePlace.push({h: 30, arr: []});
//     freePlace[0].arr.push({min: 0, max: svgMaxVal});
//
//     let freePlaceConfig = [];
//     freePlaceConfig.push({h: 30, arr: []});
//     freePlaceConfig[0].arr.push({min: 0, max: svgMaxVal});
//
//
//     let freePlaceJ = [];
//     freePlaceJ.push({h: 30, arr: []});
//     freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
//
//     let drawfit = function(config, id, h, freePlace, begin, color) {
//         let fit = false;
//         for (var i = 0; i < freePlace.length; i++) {
//             for (var k = 0; k < freePlace[i].arr.length; k++) {
//                 let item = freePlace[i].arr[k];
//                 if ((config.e_max <= item.max) && (config.e_min >= item.min)) {
//                     if((h <= freePlace[i].h) || (i == freePlace.length-1)) {
//                         freePlace[i].arr.push({min: config.e_max, max: item.max});
//                         item.max = config.e_min;
//                         fit = true;
//                         let offset = 0;
//                         for(var v = 0; v<i; v++) offset+=freePlace[v].h;
//                         if(freePlace[i].h < h) freePlace[i].h = h;
//                         config.b = offset + begin;
//                         if (color == "blue") svg += "<line id='" + id + "' class='line' x1='" + EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y1='" + (offset + begin) + "' x2='" +  EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y2='" +(offset + begin+h-3) + "' style='stroke:" + color + ";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'></line>";
//                         else {
//                             svg += "<rect id='" + id + "' x='" + EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y='" + (offset + begin) + "' width='" + (EtoPx(config.e_max, maxE, minE, maxpx, minpx) - EtoPx(config.e_min, maxE, minE, maxpx, minpx) + 1) + "' height='" + (h-3) + "' style='stroke:" + color + ";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'";
//                             if (color == "black") svg += "onclick='showterm(this);'></rect>";
//                             else svg += "></rect>";
//                         }
//                          tooltips += "<foreignObject id='" + id + "_tooltip" + "' display='none' x='" + (EtoPx(config.e_max, maxE, minE, maxpx, minpx) + 1) + "' y='" + (offset+begin)+ "' width='150' height='100'><div>" + id + "<br>E<sub>min</sub>: " + config.e_min + " cm<sup>-1</sup><br>E<sub>max</sub>: " + config.e_max + " cm<sup>-1</sup></div></foreignObject>";
//                         break;
//                     }
//                 }
//             }
//             if (fit) break;
//         }
//         if(fit) return 0;
//         else {
//             freePlace.push({h: h, arr: []});
//             freePlace[freePlace.length-1].arr.push({min: 0, max: svgMaxVal});
//             drawfit(config, id, h, freePlace, begin, color);
//         }
//     };
//
//
//     let fc = configTree[configWithoutResidues][fullConfig];
//     drawfit(fc, fullConfig, fc.h, freePlaceConfig, 60, "green");
//     freePlace = [];
//     freePlace.push({h: 30, arr: []});
//     freePlace[0].arr.push({min: 0, max: svgMaxVal});
//     for (var term in configTree[configWithoutResidues][fullConfig]) {
//         if (term != "e_min" && term != "e_max" && term != "b" && term != "h") {
//             let t = configTree[configWithoutResidues][fullConfig][term];
//             drawfit(t, fullConfig + ": " + term, t.h, freePlace, fc.b, "black");
//             freePlaceJ = [];
//             freePlaceJ.push({h: 30, arr: []});
//             freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
//             for (var termJ in configTree[configWithoutResidues][fullConfig][term]) {
//                 if (termJ != "e_min" && termJ != "e_max" && termJ != "h" && termJ != "b") {
//                     let j = configTree[configWithoutResidues][fullConfig][term][termJ];
//                     drawfit(j,fullConfig + ": " + termJ, 30, freePlaceJ, t.b, "blue");
//                 }
//             }
//         }
//     }
//
//     svg += tooltips;
//     let lines = "<line id='line1' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
//     lines += "<line id='line2' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
//     svg += lines;
//     svg += "</svg>";
//     $('#level_svg').remove();
//     $('#svg-holder').append(svg);
// }
//
// var prevfullConfig;
function showterm(elem){
    lvl = 3;
    let term = elem.getAttribute("id").split(": ")[1].replace(/°/gi, "&deg;").replace(/\<span\>.*\<\/span\>$/, "");
    let fullConfig = elem.getAttribute("id").split(": ")[0].replace(/°/gi, "&deg;");
    let configWithoutResidues = fullConfig.replace(/\(([^?]+?)\)/gi, "");
    prevfullConfig = fullConfig;
    let svg;
    let tooltips = "";
    let width = $(window).width();
    let minpx = 50,
        svgheight = 1000,
        maxpx = width - 200;
    let maxE = configTree[configWithoutResidues][fullConfig][term].e_max;
    maxE = maxE.toString().split(".")[0];
    maxE = Number(maxE)+2;
    let minE = configTree[configWithoutResidues][fullConfig][term].e_min;
    minE = minE.toString().split(".")[0];
    minE = Number(minE)-2;
    let h = (maxE - minE)/10;
    svg = "<svg width='" + width + "' height='"+ svgheight+ "' id='level_svg' style='background-color:white;'>";
    let heightpx = -40;

    svg += "<line x1='" + minpx + "' y1='"+(heightpx+70)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
    svg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+65)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
    svg += "<line x1='"+ (width-115) + "' y1='"+(heightpx+75)+"' x2='" + (width-100) + "' y2='"+(heightpx+70)+"' stroke-width='2' stroke='black'></line>";
    for(let w = minE; w <= maxE; w += h){
        svg += "<line x1='"+ EtoPx(w, maxE, minE,maxpx, minpx) + "' y1='"+(heightpx+66)+"' x2='" + EtoPx(w, maxE, minE, maxpx, minpx) + "' y2='"+(heightpx+74)+"' stroke-width='2' stroke='black'></line>";
        svg += "<text x='" + EtoPx(w, maxE, minE, maxpx, minpx) + "' y='" + (heightpx+59) + "' fill='black' style='text-anchor: Middle;'>" + w.toFixed(1) + "</text>";
    }
    svg += "<foreignObject x='"+(width-140)+"' y='"+(heightpx+40)+"' width='50' height='40'><div style='text-align: left; border-radius: 0; background-color: white; color: black; padding: 0 0'>cm<sup>-1</sup></div></foreignObject>";

    let freePlace = [];
    freePlace.push({h: 30, arr: []});
    freePlace[0].arr.push({min: 0, max: svgMaxVal});

    let freePlaceJ = [];
    freePlaceJ.push({h: 30, arr: []});
    freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});

    let drawfit = function(config, id, h, freePlace, begin, color) {
        let fit = false;
        for (var i = 0; i < freePlace.length; i++) {
            for (var k = 0; k < freePlace[i].arr.length; k++) {
                let item = freePlace[i].arr[k];
                if ((config.e_max <= item.max) && (config.e_min >= item.min)) {
                    if((h <= freePlace[i].h) || (i == freePlace.length-1)) {
                        freePlace[i].arr.push({min: config.e_max, max: item.max});
                        item.max = config.e_min;
                        fit = true;
                        let offset = 0;
                        for(var v = 0; v<i; v++) offset+=freePlace[v].h;
                        if(freePlace[i].h < h) freePlace[i].h = h;
                        config.b = offset + begin;
                        if (color == "blue") svg += "<line id='" + id + "' class='line' x1='" + EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y1='" + (offset + begin) + "' x2='" +  EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y2='" +(offset + begin+h-3) + "' style='stroke:" + color + ";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'></line>";
                        else svg += "<rect id='" + id + "' x='" + EtoPx(config.e_min, maxE, minE, maxpx, minpx) + "' y='" + (offset + begin) + "' width='" + (EtoPx(config.e_max, maxE, minE, maxpx, minpx) - EtoPx(config.e_min, maxE, minE, maxpx, minpx) + 1) + "' height='" + (h-3) + "' style='stroke:"+color+";stroke-width:1;' onmouseover='showtooltip(this);' onmouseout='hidetooltip(this);'></rect>";
                        tooltips += "<foreignObject id='" + id + "_tooltip" + "' display='none' x='" + (EtoPx(config.e_max, maxE, minE, maxpx, minpx) + 1) + "' y='" + (offset+begin)+ "' width='150' height='100'><div>" + id + "<br>E<sub>min</sub>: " + config.e_min + " cm<sup>-1</sup><br>E<sub>max</sub>: " + config.e_max + " cm<sup>-1</sup></div></foreignObject>";
                        break;
                    }
                }
            }
            if (fit) break;
        }
        if(fit) return 0;
        else {
            freePlace.push({h: h, arr: []});
            freePlace[freePlace.length-1].arr.push({min: 0, max: svgMaxVal});
            drawfit(config, id, h, freePlace, begin, color);
        }
    };

    let t = configTree[configWithoutResidues][fullConfig][term];
    drawfit(t, fullConfig + ": " + term, t.h, freePlace, 60, "black");
    freePlaceJ = [];
    freePlaceJ.push({h: 30, arr: []});
    freePlaceJ[0].arr.push({min: 0, max: svgMaxVal});
    for (var termJ in configTree[configWithoutResidues][fullConfig][term]) {
        if (termJ != "e_min" && termJ != "e_max" && termJ != "h" && termJ != "b") {
            let j = configTree[configWithoutResidues][fullConfig][term][termJ];
            drawfit(j,fullConfig + ": " + termJ, 30, freePlaceJ, t.b, "blue");
        }
    }

    svg += tooltips;
    let lines = "<line id='line1' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
    lines += "<line id='line2' x1='0' y1='0' x2='0' y2='0' stroke-width='1' stroke='black' display='none' stroke-dasharray='4 2'></line>";
    svg += lines;
    svg += "</svg>";
    $('#level_svg').remove();
    $('#svg-holder').append(svg);
}