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
    term = ({lt: "", ut: "", x: "", y: ""}),
    dataSpectr = [],
    intensArray = [],
    markers = [],
    termLabel = [],
    maxVal = 0,
    IP = 0,
    cm=true,
    ev=false,
    filter = false,
    max,
    icon = [];

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

var customTooltips;

var canvas = document.createElement("canvas");
canvas.id = "myCanvas";
canvas.height = 97;
canvas.width = 105;
canvas.ctx = canvas.getContext("2d");


var canvas5 = document.createElement("canvas");
canvas5.id = "myCanvas5";
canvas5.height = 70;
canvas5.width = 70;
canvas5.ctx = canvas5.getContext("2d");

var canvas6 = document.createElement("canvas");
canvas6.id = "myCanvas6";
canvas6.height = 70;
canvas6.width = 70;
canvas6.ctx = canvas6.getContext("2d");

var canvas7 = document.createElement("canvas");
canvas7.id = "myCanvas7";
canvas7.height = 70;
canvas7.width = 70;
canvas7.ctx = canvas7.getContext("2d");

var canvas8 = document.createElement("canvas");
canvas8.id = "myCanvas7";
canvas8.height = 70;
canvas8.width = 70;
canvas8.ctx = canvas8.getContext("2d");


//линза
canvas.ctx.arc(0, 50, 68, -Math.PI/4, Math.PI/4, false);
canvas.ctx.arc(100, 50, 68, Math.PI*3/4, -Math.PI*3/4, false);


//5угольник
canvas5.ctx.beginPath();
canvas5.ctx.moveTo(35,4);
canvas5.ctx.lineTo(65,33);
canvas5.ctx.lineTo(54,65);
canvas5.ctx.lineTo(15,65);
canvas5.ctx.lineTo(4, 33);
canvas5.ctx.lineTo(35, 4);

//6
canvas6.ctx.beginPath();
canvas6.ctx.moveTo(35,5);
canvas6.ctx.lineTo(63,19);
canvas6.ctx.lineTo(63,52);
canvas6.ctx.lineTo(35,66);
canvas6.ctx.lineTo(6, 52);
canvas6.ctx.lineTo(6, 19);
canvas6.ctx.lineTo(35, 5);

//7
canvas7.ctx.beginPath();
canvas7.ctx.moveTo(35,4);
canvas7.ctx.lineTo(65,22);
canvas7.ctx.lineTo(65,49);
canvas7.ctx.lineTo(49,65);
canvas7.ctx.lineTo(21,65);
canvas7.ctx.lineTo(5, 49);
canvas7.ctx.lineTo(5, 22);
canvas7.ctx.lineTo(35, 4);

//8
canvas8.ctx.beginPath();
canvas8.ctx.moveTo(24,5);
canvas8.ctx.lineTo(48,5);
canvas8.ctx.lineTo(65,22);
canvas8.ctx.lineTo(65,48);
canvas8.ctx.lineTo(48,65);
canvas8.ctx.lineTo(24,65);
canvas8.ctx.lineTo(5, 48);
canvas8.ctx.lineTo(5, 22);
canvas8.ctx.lineTo(24, 0);


//отображение иинтенсивности прозрачностью
function click_intens(){
    if(document.getElementById('intens').checked){
        fill_icon(markers, icon, colorArr);
        scatterChartData.datasets[0].pointStyle = icon;
        scatterChartData.datasets[0].pointBorderColor = colorArr;
        window.myScatter.update();
    }
    else {
        let col = [];
        colorArr.forEach(function(item){
            let a = item.split('a');
            let b = a[1].split(',');
            col.push(a[0]+b[0]+','+b[1]+','+b[2]+')');
        });
        fill_icon(markers, icon, col);
        scatterChartData.datasets[0].pointStyle = icon;
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
            IP = atom_json.IONIZATION_POTENCIAL;
            IP = IP * 1.23977 * Math.pow(10, -4);
        }
        else IP = atom_json.IONIZATION_POTENCIAL;


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

        scatterChartData.datasets[2].data[0].x = maxVal;
        scatterChartData.datasets[2].data[1].x = 0;
        scatterChartData.datasets[2].data[1].y = IP;
        scatterChartData.datasets[2].data[0].y = IP;

        scatterChartData.datasets[3].data[0].x = 0;
        scatterChartData.datasets[3].data[1].x = 0;
        scatterChartData.datasets[3].data[1].y = 0;
        scatterChartData.datasets[3].data[0].y = 0;

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
            IP = atom_json.IONIZATION_POTENCIAL;
            IP = IP * 1.23977 * Math.pow(10, -4);
        }
        else {
            scatterChartData.datasets[1].data[1].x = maxVal;
            scatterChartData.datasets[1].data[1].y = maxVal;
            IP = atom_json.IONIZATION_POTENCIAL;
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
            IP = atom_json.IONIZATION_POTENCIAL;
            IP = IP * 1.23977 * Math.pow(10, -4);
        }
        else IP = atom_json.IONIZATION_POTENCIAL;

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
});

function resize(new_atom) {
    if((new_atom == 1) || (filter == true)){
        if(document.getElementById('fullScreen').value == 'Full screen') {
            let win_w, win_h, size;
            win_w = $(window).width();
            win_h = $(window).height();
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            size = Math.floor(size*3/4);
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) {
                window.myScatter.clear();
            }
            graph(size, size);
        }
        else {
            let win_w, win_h, size;
            win_w = $(window).width();
            win_h = $(window).height();
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) {
                window.myScatter.clear();
            }
            graph(size, size);
        }
    }
    else {
        if(document.getElementById('fullScreen').value == 'Full screen') {
            let win_w, win_h, size;
            win_w = $(window).width();
            win_h = $(window).height();
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) {
                window.myScatter.clear();
            }
            graph(size, size);
            document.getElementById('fullScreen').value = 'Exit full screen';
        }
        else {
            let win_w, win_h, size;
            win_w = $(window).width();
            win_h = $(window).height();
            if(win_w <= win_h) size = win_w;
            else size = win_h;
            size = Math.floor(size*3/4);
            $('#canvas').remove();
            $('#chartCont').append('<canvas id="canvas"><canvas>');
            if (window.myScatter) {
                window.myScatter.clear();
            }
            graph(size, size);
            document.getElementById('fullScreen').value = 'Full screen';
        }
    }
    window.myScatter.options.title.text = '';
    window.myScatter.update();
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
                let arr = scatterChartData.labels[i].split("(");
                scatterChartData.labels[i] = arr[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                scatterChartData.datasets[0].data[i].x =item.x;
                scatterChartData.datasets[0].data[i].y =item.y;
            });

            if(eUp_eDcheck == true){
                IP = atom_json.IONIZATION_POTENCIAL;
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

                IP = atom_json.IONIZATION_POTENCIAL;

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
                IP = atom_json.IONIZATION_POTENCIAL;
                scatterChartData.datasets[2].data[0].x = maxVal;
                scatterChartData.datasets[2].data[1].x = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[0].y = IP;
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
            window.myScatter.update();
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
                let arr = scatterChartData.labels[i].split("(");
                scatterChartData.labels[i] = arr[0] + "(" + term.x.toFixed(3) + ", " + term.y.toFixed(3) + ")";
                scatterChartData.datasets[0].data[i].x =item.x;
                scatterChartData.datasets[0].data[i].y =item.y;
            });


            if(eUp_eDcheck == true){
                IP = atom_json.IONIZATION_POTENCIAL;
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

                IP = atom_json.IONIZATION_POTENCIAL;
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
                IP = atom_json.IONIZATION_POTENCIAL;
                IP = IP*1.23977*Math.pow(10,-4);
                scatterChartData.datasets[2].data[0].x = maxVal;
                scatterChartData.datasets[2].data[1].x = 0;
                scatterChartData.datasets[2].data[1].y = IP;
                scatterChartData.datasets[2].data[0].y = IP;
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
            window.myScatter.update();
        }
        myScatter.options.scales.yAxes[0].scaleLabel.labelString = part1Y + part2;
        myScatter.options.scales.xAxes[0].scaleLabel.labelString = part1X + part2;
    });
}

function updateChart(new_atom, min, max){
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
    if (new_atom == 1)document.getElementById('intens').checked = true;
    document.getElementsByName('myRadios')[0].checked = true;
    document.getElementsByName('myRadios')[1].checked = false;
    document.getElementById('eUp_eD').checked = false;
    document.getElementById('parity').checked = false;
    document.getElementById('eUp').checked = true;
    eUpcheck = true;
    parity = false;
    eUp_eDcheck = false;
    filter = false;

    customTooltips = function (tooltip) {
        var tooltipEl = document.getElementById('chartjs-tooltip');

        if (tooltip.opacity === 0) {
            tooltipEl.style.opacity = 0;
            return;
        }

        tooltipEl.classList.remove('above', 'below', 'no-transform');
        if (tooltip.yAlign) {
            tooltipEl.classList.add(tooltip.yAlign);
        } else {
            tooltipEl.classList.add('no-transform');
        }

        function getBody(bodyItem) {
            return bodyItem.lines;
        }

        if (tooltip.body) {
            var titleLines = tooltip.title || [];
            var bodyLines = tooltip.body.map(getBody);

            var innerHtml = '<thead>';

            titleLines.forEach(function (title) {
                innerHtml += '<tr><th>' + title + '</th></tr>';
            });
            innerHtml += '</thead><tbody>';

            bodyLines.forEach(function (body, i) {
                var colors = tooltip.labelColors[i];
                var style = 'background:' + colors.backgroundColor;
                style += '; border-color:' + colors.borderColor;
                style += '; border-width: 2px';
                var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                innerHtml += '<tr><td>' + span + body + '</td></tr>';
            });
            innerHtml += '</tbody>';

            var tableRoot = tooltipEl.querySelector('table');
            tableRoot.innerHTML = innerHtml;
        }
        var positionY = this._chart.canvas.offsetTop;
        var positionX = this._chart.canvas.offsetLeft;

        tooltipEl.style.opacity = 1;
        tooltipEl.style.left = positionX + tooltip.caretX + 'px';
        tooltipEl.style.top = positionY + tooltip.caretY + 'px';
        tooltipEl.style.fontFamily = tooltip._bodyFontFamily;
        tooltipEl.style.fontSize = tooltip.bodyFontSize;
        tooltipEl.style.fontStyle = tooltip._bodyFontStyle;
        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
    };

    if (((min == 0) && (max == 0))){
        transitions_json.forEach(function (transition) {
            if (transition.ID_LOWER_LEVEL && transition.ID_UPPER_LEVEL) {
                let pref,
                    multCol = ({m: '', c: '', l: ''}),
                    len = transition.WAVELENGTH,
                    multUp,
                    multLow;

                if ((transition.INTENSITY == null) || (transition.INTENSITY == 0))
                    transition.INTENSITY = 0;

                let x = transition.lower_level_energy,
                    y = transition.upper_level_energy;

                multLow = transition.lower_level_termprefix;
                multUp = transition.upper_level_termprefix;

                if (transition.lower_level_termprefix)
                    pref = transition.lower_level_termprefix;
                else
                    pref = "";

                if (transition.lower_level_termmultiply == 0) {
                    term.lt = "<span>" + transition.lower_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sup>" + transition.lower_level_termmultiply + "</sup>" + "<sub>" + transition.lower_level_j + "</sub>";
                } else term.lt = "<span>" + transition.lower_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sub>" + transition.lower_level_j + "</sub>";


                let test = transition.upper_level_termmultiply;
                if (transition.upper_level_termprefix) pref = transition.upper_level_termprefix;
                else pref = "";
                if (test === 0) {
                    term.ut = "<span>" + transition.upper_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sup>" + transition.upper_level_termmultiply + "</sup>" + "<sub>" + transition.upper_level_j + "</sub>";
                } else term.ut = "<span>" + transition.upper_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sub>" + transition.upper_level_j  + "</sub>";


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
                termLabel.push(term.lt + "<span> - </span>" + term.ut + "<br>" + "wavelength [A]: " + len + "<br>" + "intensity: " + transition.INTENSITY + "<br>" + "(" + term.x + ", " + term.y + ")");
                dataSpectr.push(point);
                if (transition.INTENSITY == 0) intensArray.push(0);
                else intensArray.push(Math.log10(transition.INTENSITY));
            }
        });
    }
    else{
        transitions_json.forEach(function (transition) {
            if (transition.ID_LOWER_LEVEL && transition.ID_UPPER_LEVEL && (transition.WAVELENGTH > min) && (transition.WAVELENGTH < max)) {
                let pref,
                    multCol = ({m: '', c: '', l: ''}),
                    len = transition.WAVELENGTH,
                    multUp,
                    multLow;

                if ((transition.INTENSITY == null) || (transition.INTENSITY == 0))
                    transition.INTENSITY = 0;

                let x = transition.lower_level_energy,
                    y = transition.upper_level_energy;

                multLow = transition.lower_level_termprefix;
                multUp = transition.lower_level_termprefix;

                if (transition.lower_level_termprefix)
                    pref = transition.lower_level_termprefix;
                else
                    pref = "";

                if (transition.lower_level_termmultiply == 0) {
                    term.lt = "<span>" + transition.lower_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sup>" + transition.lower_level_termmultiply + "</sup>" + "<sub>" + transition.lower_level_j + "</sub>";
                } else term.lt = "<span>" + transition.lower_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.lower_level_termfirstpart + "</span>" + "<sub>" + transition.lower_level_j + "</sub>";


                let test = transition.upper_level_termmultiply;
                if (transition.upper_level_termprefix) pref = transition.upper_level_termprefix;
                else pref = "";
                if (test === 0) {
                    term.ut = "<span>" + transition.upper_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sup>" + transition.upper_level_termmultiply + "</sup>" + "<sub>" + transition.upper_level_j + "</sub>";
                } else term.ut = "<span>" + transition.upper_level_config.replace(/@\{0\}/gi, "&deg;").replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/#/gi, "&deg;") + ": " + "</span>" + "<sup>" + pref + "</sup>" + "<span>" + transition.upper_level_termfirstpart + "</span>" + "<sub>" + transition.upper_level_j  + "</sub>";


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
                termLabel.push(term.lt + "<span> - </span>" + term.ut + "<br>" + "wavelength [A]: " + len + "<br>" + "intensity: " + transition.INTENSITY + "<br>" + "(" + term.x + ", " + term.y + ")");
                dataSpectr.push(point);
                if (transition.INTENSITY == 0) intensArray.push(0);
                else intensArray.push(Math.log10(transition.INTENSITY));
            }
        });
    }

    var maxItem = Math.max.apply(null, intensArray);
    intensArray.forEach(function (item, i) {
        intensArray[i] = item / maxItem;
    });

    intensArray.forEach(function (item, i) {
        markers[i].c = markers[i].c + String(item) + ")";
        colorArr.push(markers[i].c);
    });

    fill_icon(markers, icon, colorArr);

    maxVal = 0;
    max = 0;
    dataSpectr.forEach(function (item) {
        if (maxVal <  item.x) maxVal = item.x;
        if (max < item.y) max = item.y;
    });
    if (max < maxVal) max = maxVal;
    IP = atom_json.IONIZATION_POTENCIAL;

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
            data: [{x: maxVal, y: IP}, {x: 0, y: IP}],
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
            data: [{x: 0, y: 0}, {x: 0, y: 0}],
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

    resize(new_atom);

    window.myScatter.options.title.text = '';
    myScatter.options.scales.xAxes[0].ticks.suggestedMax = max;
    myScatter.options.scales.yAxes[0].ticks.suggestedMax = max;

    window.myScatter.update();
}

function fill_icon(markers, icon, col) {
    icon.length = 0;
    markers.forEach(function (item, i) {
        let image = new Image();
        if (item.m === 0) {
            icon.push('crossRot');
        } else if (item.m === 1) {
            icon.push('circle');
        } else if (item.m === 2) {
            canvas.ctx.strokeStyle = col[i];
            canvas.ctx.lineWidth = 10;
            canvas.ctx.fillStyle = 'rgba(255, 255, 255, 0)';
            canvas.ctx.fill();
            canvas.ctx.stroke();
            image.src = canvas.toDataURL();
            image.width = 14;
            image.height = 14;
            icon.push(image);
            canvas.ctx.clearRect(0, 0, 105, 97);
        } else if (item.m === 3) {
            icon.push('triangle');
        } else if (item.m === 4) {
            icon.push('rect');
        } else if (item.m === 5) {
            canvas5.ctx.strokeStyle = col[i];
            canvas5.ctx.lineWidth = 9;
            canvas5.ctx.fillStyle = 'rgba(255, 255, 255, 0)';
            canvas5.ctx.fill();
            canvas5.ctx.stroke();
            image.src = canvas5.toDataURL();
            image.width = 10;
            image.height = 10;
            icon.push(image);
            canvas5.ctx.clearRect(0, 0, 70, 70);
        } else if (item.m === 6) {
            canvas6.ctx.strokeStyle = col[i];
            canvas6.ctx.lineWidth = 9;
            canvas6.ctx.fillStyle = 'rgba(255, 255, 255, 0)';
            canvas6.ctx.fill();
            canvas6.ctx.stroke();
            image.src = canvas6.toDataURL();
            image.width = 10;
            image.height = 10;
            icon.push(image);
            canvas6.ctx.clearRect(0, 0, 70, 70);
        } else if (item.m === 7) {
            canvas7.ctx.strokeStyle = col[i];
            canvas7.ctx.lineWidth = 9;
            canvas7.ctx.fillStyle = 'rgba(255, 255, 255, 0)';
            canvas7.ctx.fill();
            canvas7.ctx.stroke();
            image.src = canvas7.toDataURL();
            image.width = 10;
            image.height = 10;
            icon.push(image);
            canvas7.ctx.clearRect(0, 0, 70, 70);
        } else if (item.m === 8) {
            canvas8.ctx.strokeStyle = col[i];
            canvas8.ctx.lineWidth = 9;
            canvas8.ctx.fillStyle = 'rgba(255, 255, 255, 0)';
            canvas8.ctx.fill();
            canvas8.ctx.stroke();
            image.src = canvas8.toDataURL();
            image.width = 10;
            image.height = 10;
            icon.push(image);
            canvas8.ctx.clearRect(0, 0, 70, 70);
        } else icon.push('star');
    });
}

function graph(h, w) {
    var ctx = document.getElementById('canvas').getContext('2d');
    ctx.canvas.height = h;
    ctx.canvas.width = w;

    window.myScatter = new Chart(ctx, {
        type: 'scatter',
        data: scatterChartData,
        options: {
            elements: {
                line: {
                    tension: 0
                }
            },
            responsive: false,
            bezierCurve: false,
            title: {
                display: true,
                text: '',
            },
            pan: {
                enabled: true,
                mode: 'xy'
            },
            zoom: {
                enabled: true,
                mode: 'xy'
            },
            tooltips: {
                filter: function (tooltipItem) {
                    return tooltipItem.datasetIndex === 0;
                },
                callbacks:{
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';
                        return label;
                    },
                },
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
                    },
                    scaleLabel: {
                        display: true,
                        labelString: part1Y + part2
                    }
                }],
                xAxes: [{
                    ticks:{
                        suggestedMax: max,
                        beginAtZero: true,
                        maxRotation: 0,
                        minRotation: 0,
                    },
                    scaleLabel: {
                        display: true,
                        labelString: part1X + part2
                    }
                }]
            }
        },
    });
    window.myScatter.update();
}


function show_selected(){
    filter = true;
    let min = document.getElementById("min").value;
    let max = document.getElementById("max").value;
    updateChart(0, min, max);
    click_intens();
}

function show_visible(){
    filter = true;
    updateChart(0, 3800, 7600);
    click_intens();
}

function show_all(){
    filter = true;
    updateChart(0, 0, 0);
    click_intens();
}

updateChart(1, 0, 0);