//ie array.includes() workaround polyfill
// https://tc39.github.io/ecma262/#sec-array.prototype.includes
if (!Array.prototype.includes) {
    Object.defineProperty(Array.prototype, 'includes', {
        value: function(searchElement, fromIndex) {

            if (this == null) {
                throw new TypeError('"this" is null or not defined');
            }

            // 1. Let O be ? ToObject(this value).
            var o = Object(this);

            // 2. Let len be ? ToLength(? Get(O, "length")).
            var len = o.length >>> 0;

            // 3. If len is 0, return false.
            if (len === 0) {
                return false;
            }

            // 4. Let n be ? ToInteger(fromIndex).
            //    (If fromIndex is undefined, this step produces the value 0.)
            var n = fromIndex | 0;

            // 5. If n ? 0, then
            //  a. Let k be n.
            // 6. Else n < 0,
            //  a. Let k be len + n.
            //  b. If k < 0, let k be 0.
            var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

            function sameValueZero(x, y) {
                return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
            }

            // 7. Repeat, while k < len
            while (k < len) {
                // a. Let elementK be the result of ? Get(O, ! ToString(k)).
                // b. If SameValueZero(searchElement, elementK) is true, return true.
                if (sameValueZero(o[k], searchElement)) {
                    return true;
                }
                // c. Increase k by 1.
                k++;
            }

            // 8. Return false
            return false;
        }
    });
}





var tga = 0.3;
var txt_angle=17;
var count_visible=0;
var max_dx = 15; // max dx for not long level
var min_l = 40; // min length for visible line
var min_d = 15;
var max_eq_dy = 7;
var min_levels_count = 5;
var part_after_begin = 0.25;
//var compression_rate = table_width / window.innerWidth;
var compression_rate = table_width / diagram_w;
if (compression_rate > 1 || grouping == 'term' || grouping == 'J' ) compress_table();

var visible_transitions = new Array();
var right_transitions = new Array();
var left_transitions = new Array();
fix_viewBox();
checkTexts();
drawTransitions();


//Sort function for j like "9/2"
function slava_sort_function_j(j1, j2) {
    return eval(j1 != ""? j1 : 0) - eval(j2 != ""? j2 : 0);
}

function compress_table() {
    var g_cores = document.getElementsByTagName('g');
    var dx;
    for (var i = 0; i < g_cores.length; i++) {
        if (g_cores.item(i).getAttribute('class') == 'core') {
            var g_terms = g_cores.item(i).getElementsByTagName('g');
            for (var j = 0; j < g_terms.length; j++) {
                if (g_terms.item(j).getAttribute('class') == 'term') {
                    var compJ = false;

                    var rect_terms = g_terms.item(j).getElementsByTagName('rect');
                    var g_levels = g_terms.item(j).getElementsByTagName('g');
                    var text_terms = g_terms.item(j).getElementsByTagName('text');

                    if (rect_terms.length > 1) {
                        if (compression_rate >= 1.5 || grouping != 'auto'/* &&(rect_terms.length > 2)*/) {
                            var gL = rect_terms.item(0).getAttribute('l');
                            var gSeq = rect_terms.item(0).getAttribute('seq');
                            if (!is_equal_attribute(rect_terms, 'l', gL)) gL = '(...)';
                            else {
                                if (gSeq == '') compJ = true;
                                else {
                                    if (!is_equal_attribute(rect_terms, 'seq', gSeq)) gSeq = '';
                                    else compJ = true;
                                }
                            }
                        }

                        if (grouping != 'full' && (grouping == 'J' || compJ || ((compression_rate < 1.7) /*|| (rect_terms.length < 3)*/))) {
                            // try to compress
                            for (var k = 0; k < rect_terms.length; k++) {
                                if (rect_terms[k].getAttribute('display') != 'none'
                                    /*compJ || parseInt(rect_terms.item(k).getAttribute('n_levels')) < min_levels_count
                                    || rect_terms.item(k).getAttribute('info') == 'no'*/)
                                { // too little count of levels for term => compress
                                    var curL = rect_terms.item(k).getAttribute('l');
                                    var curSeq = rect_terms.item(k).getAttribute('seq');
                                    var curPrefix = rect_terms.item(k).getAttribute('prefix');
                                    var toCompress = new Array();
                                    find_similar(rect_terms, curL, curSeq, curPrefix, toCompress);
                                    if (toCompress.length > 1) {
                                        toCompress.sort(sort_numbers);
                                        //k = toCompress[toCompress.length - 1] + 1;
                                        // compression
                                        var auto = false; //has autoionization state and we should half a term rect
                                        for (var ii = 1; ii < toCompress.length; ii++) {
                                            if (rect_terms.item(toCompress[ii]).getAttribute('type') == 'auto')
                                                auto = true;
                                        }
                                        if (auto) rect_terms.item(toCompress[0]).setAttribute('height', term_row_h / 2);
                                        if (auto) text_terms.item(toCompress[0]).setAttribute('y', 0.25 * term_row_h + core_row_h + conf_row_h);
                                        // hide levels
                                        for (var ii = 1; ii < toCompress.length; ii++) {
                                            dx = rect_terms.item(toCompress[0]).getAttribute('x') - rect_terms.item(toCompress[ii]).getAttribute('x')
                                            shift_glevels(g_levels.item(toCompress[ii]), dx, true);
                                            if (auto) g_levels.item(toCompress[ii]).getElementsByTagName('line')
                                                .item(0).setAttribute('y1', term_row_h /2  + core_row_h + conf_row_h);
                                            rect_terms.item(toCompress[ii]).setAttribute('display', 'none');
                                            rect_terms.item(toCompress[ii]).nextElementSibling.setAttribute('display', 'none');
                                        }
                                        dx = -(toCompress.length - 1)*term_row_w;
                                        // append J
                                        var tJ = rect_terms.item(toCompress[0]).nextElementSibling;

                                        var jArr = new Array();
                                        for (var ii = 0; ii < toCompress.length; ii++) {
                                            jArr.push(rect_terms.item(toCompress[ii]).getAttribute('j'));
                                            jArr.sort(slava_sort_function_j);
                                        }
                                        var newJ;
                                        var jArrFirst = "";
                                        for (var ii = 0; ii < jArr.length; ii++){
                                            if (jArr[ii]!=""){
                                                jArrFirst = jArr[ii];
                                                break;
                                            }
                                        }

                                        if (jArrFirst != jArr[jArr.length - 1])
                                            newJ = (jArrFirst == ""?0:jArrFirst)  + '-' + (jArr[jArr.length - 1] == ""?0:jArr[jArr.length - 1]);
                                        else newJ = jArrFirst == ""?0:jArrFirst;
                                        var tSpans = tJ.getElementsByTagName('tspan');
                                        tSpans.item(tSpans.length-1).textContent = newJ;

                                        // shift levels of current term
                                        //for (var ii = toCompress[toCompress.length - 1] + 1; ii < rect_terms.length; ii++) {
                                        for (var ii = 0; ii < rect_terms.length; ii++){
                                            //count blanks before this term
                                            dx2 = 0;
                                            for (var iii = 1; iii < toCompress.length; iii++)
                                                if (toCompress[iii]< ii) dx2 -= term_row_w;
                                            if (dx2 != 0 && !toCompress.includes(ii)) {//array.includes() doesn't supported in fucking IE
                                                shift_glevels(g_levels.item(ii), dx2);
                                                rect_terms.item(ii).setAttribute('x', parseFloat(rect_terms.item(ii).getAttribute('x')) + dx2);
                                                rect_terms.item(ii).nextElementSibling.setAttribute('x', parseFloat(rect_terms.item(ii).nextElementSibling.getAttribute('x')) + dx2);
                                            }
                                        }
                                        //shift intermediate terms

                                        // shift next terms
                                        var curTerm = g_terms.item(j);
                                        compress_shift_data(curTerm, dx);
                                    }
                                }
                            }
                        }
                        else {
                            if (/*(rect_terms.length > 2) && */grouping != 'full' && grouping != 'J' && (grouping == 'term' || compression_rate >= 1.7)) {// compress term
                                // create new text
                                var newText = text_terms.item(0).cloneNode(true);
                                if (newText.hasAttribute('transform')) newText.removeAttribute('transform');
                                var nTextSpans = newText.getElementsByTagName('tspan');
                                newText.removeChild(nTextSpans.item(nTextSpans.length - 1));

                                if (gSeq == '' &&  newText.firstChild.nodeName == '#text')
                                    newText.removeChild(newText.firstChild);
                                var nL = document.createTextNode(gL);
                                if (nTextSpans.item(1).hasChildNodes())
                                    nTextSpans.item(1).removeChild(nTextSpans.item(1).firstChild);
                                nTextSpans.item(1).appendChild(nL);
                                // create new rectangle
                                var newRect = rect_terms.item(0).cloneNode(false);
                                newRect.setAttribute('type', 'compression');

                                var auto = false; //has autoionization state and we should half a term rect
                                // hide all texts and rectangles and shift levels
                                for (var k = 0; k < rect_terms.length; k++) {
                                    if (rect_terms.item(k).getAttribute('type') == 'auto') auto = true;
                                }
                                for (var k = 0; k < rect_terms.length; k++) {
                                    rect_terms.item(k).setAttribute('display', 'none');
                                    rect_terms.item(k).nextElementSibling.setAttribute('display', 'none');
                                    dx = - term_row_w * k;
                                    shift_glevels(g_levels.item(k), dx, true);
                                    if (auto) g_levels.item(k).getElementsByTagName('line')
                                        .item(0).setAttribute('y1', term_row_h /2  + core_row_h + conf_row_h);

                                }
                                if (auto) newRect.setAttribute('height', term_row_h / 2);
                                if (auto) newText.setAttribute('y', 0.25*term_row_h + core_row_h + conf_row_h);
                                // add new rect and text
                                g_terms.item(j).insertBefore(newText, g_terms.item(j).firstChild);
                                g_terms.item(j).insertBefore(newRect, g_terms.item(j).firstChild);
                                compress_shift_data(g_terms.item(j), dx, auto);
                            }
                        }
                    }
                }
            }
        }
    }
}
function is_equal_attribute(nList, attrName, attrVal) {
    for (var i = 1; i < nList.length; i++)
        if (attrVal != nList.item(i).getAttribute(attrName)) return false;
    return true;
}

function sort_numbers(arg1, arg2) {
    return parseInt(arg1) - parseInt(arg2);
}

function find_similar(data, L, Seq, Prefix, result) {
    for (var i = 0; i < data.length; i++) {
        var curEl = data.item(i);
        if (curEl.getAttribute('l') == L && curEl.getAttribute('seq') == Seq
            && curEl.getAttribute('prefix') == Prefix) {
            result.push(i);
        }
    }
 }

function fix_viewBox() {
    var nTW = table_width + 100;
    if (window.svgDocument)
        window.svgDocument.rootElement.setAttribute('viewBox', '0 0 '+ nTW + ' ' + table_height);
    else
        window.document.getElementById("svg_with_diagram").setAttribute('viewBox', '0 0 '+ nTW + ' ' + table_height);
}

function compress_shift_data(curTerm, dx) {
    var Term = curTerm.nextElementSibling;
    while (Term != null) {
        if ('term' == Term.getAttribute('class')) shift_group(Term, dx);
        Term = Term.nextElementSibling;
    }
    //compress current core
    var curCore = curTerm.parentNode;
    compress_group(curCore, dx);
    //shift cores
    var Core = curCore.nextElementSibling;
    while (Core != null) {
        if ('core' == Core.getAttribute('class')) shift_group(Core, dx);
        Core = Core.nextElementSibling;
    }

    // compress config
    var curConf = curCore.parentNode;
    compress_group(curConf, dx);

    // shift next columns
    var Conf = curConf.nextElementSibling;
    while (Conf != null) {
        if (Conf.getAttribute('class') == 'column') shift_group(Conf, dx);
        Conf = Conf.nextElementSibling;
    }

    // compress AllData
    table_width += dx;
    document.getElementById('AllData').setAttribute('width', table_width);

    // shift eV energy scale
    document.getElementById('EeV').setAttribute('transform', 'translate(' + table_width +',0)');
    // shift Name
    document.getElementById('Abbr').setAttribute('x', table_width - 5);
}

function compress_group(gr, dx){
    var chG = gr.childNodes;
    for (var i = 0; i < chG.length; i++) {
        if (chG.item(i).nodeName == 'text')
            chG.item(i).setAttribute('x', parseFloat(chG.item(i).getAttribute('x')) + dx / 2.);
        if (chG.item(i).nodeName == 'rect')
            chG.item(i).setAttribute('width', parseFloat(chG.item(i).getAttribute('width')) + dx);
    }
}

function shift_group(gr, dx){
    var chG = gr.childNodes;
    for (var i = 0; i < chG.length; i++) {
        if (chG.item(i).nodeName == 'rect' || chG.item(i).nodeName == 'text')
            chG.item(i).setAttribute('x', parseFloat(chG.item(i).getAttribute('x')) + dx);
        if (chG.item(i).nodeName == 'g') {
            if (gr.getAttribute('class') == 'column' || gr.getAttribute('class') == 'core')  shift_group(chG.item(i), dx);
            if (gr.getAttribute('class') == 'term') shift_glevels(chG.item(i), dx, false);
        }
    }
}

function shift_glevels(gLevels, dx, hide){
    if (gLevels.nodeName == 'g' && gLevels.getAttribute('class') == 'levels'){
        var lines = gLevels.getElementsByTagName('line');
        for (var j = 0; j < lines.length; j++){
            lines.item(j).setAttribute('x1', parseFloat(lines.item(j).getAttribute('x1')) + dx);
            lines.item(j).setAttribute('x2', parseFloat(lines.item(j).getAttribute('x2')) + dx);
        }
        var txt_l = gLevels.getElementsByTagName('text');
        for (var j = 0; j < txt_l.length; j++){
            txt_l.item(j).setAttribute('x', parseFloat(txt_l.item(j).getAttribute('x')) + dx);
            if (hide) txt_l.item(j).setAttribute('display', 'none');
        }
        var circle_l = gLevels.getElementsByTagName('circle');
        for (var j = 0; j < circle_l.length; j++){
            circle_l.item(j).setAttribute('cx', parseFloat(circle_l.item(j).getAttribute('cx')) + dx);
        }
        return 1;
    }
    return -1;
}

function drawTransitions(){
    if (window.parent!=null){ //Declaration for ASV3 and webkit
        minWave = window.parent.waveMinVal ? parseFloat(window.parent.waveMinVal) : null
        maxWave = window.parent.waveMaxVal ? parseFloat(window.parent.waveMaxVal) : null
        minEnergy = window.parent.energyMinVal ? parseFloat(window.parent.energyMinVal) : null
        maxEnergy = window.parent.energyMaxVal ? parseFloat(window.parent.energyMaxVal) : null
    } else { //Declaration for ASV6
        minWave = parseFloat(waveMinVal);
        maxWave = parseFloat(waveMaxVal);
        minEnergy = parseFloat(energyMinVal);
        maxEnergy = parseFloat(energyMaxVal);
    }
    drawTransitionsWaveEnergyRange(minWave, maxWave, minEnergy, maxEnergy);
}

function drawTransitionsWaveEnergyRange(minWave, maxWave, minEnergy, maxEnergy){
    var transitions = document.getElementById('transitions');
    if (transitions == null) return 1;
    transitions = transitions.childNodes;
    var rating, val;

    for (var i=0; i<transitions.length; i++){
        if (transitions.item(i).nodeType == Node.TEXT_NODE) continue;
        if (document.getElementById(transitions.item(i).getAttribute('high_level'))
            && document.getElementById(transitions.item(i).getAttribute('low_level'))
            && transitions.item(i).nodeName == 'line'
            && (maxWave == null || transitions.item(i).getAttribute('wavelength') <= maxWave)
            && (minWave == null || transitions.item(i).getAttribute('wavelength') >= minWave)
            && (maxEnergy == null || document.getElementById(transitions.item(i).getAttribute('high_level')).getAttribute('energy') <= maxEnergy)
            && (minEnergy == null || document.getElementById(transitions.item(i).getAttribute('high_level')).getAttribute('energy') >= minEnergy)
            && (maxEnergy == null || document.getElementById(transitions.item(i).getAttribute('low_level')).getAttribute('energy') <= maxEnergy)
            && (minEnergy == null || document.getElementById(transitions.item(i).getAttribute('low_level')).getAttribute('energy') >= minEnergy)
            ){
            var curLine = transitions.item(i);
            var hlevel = document.getElementById(curLine.getAttribute('high_level'));
            var llevel = document.getElementById(curLine.getAttribute('low_level'));
            var longh = hlevel.hasAttribute('long');
            var longl = llevel.hasAttribute('long');
            var xl = get_real_line_x(llevel);
            var xh = get_real_line_x(hlevel);
            var y1 = parseFloat(hlevel.getAttribute('y1'));
            var y2 = parseFloat(llevel.getAttribute('y1'));
            curLine.setAttribute('y1', y1);
            curLine.setAttribute('y2', y2);

            if (!longh && !longl){
                //var len = Math.sqrt((y2-y1)*(y2-y1) + (xh-xl)*(xh-xl));
                //	if (len > min_l)
                //	{
                //      	curLine.setAttribute('x1', xh);
                //              curLine.setAttribute('x2', xl);
                //		visible_transitions.push(curLine);count_visible++;
                //	}
                set_invisible(curLine);
            }
            else{
                var len = Math.sqrt((1+tga*tga)*(y2-y1)*(y2-y1));
                if (len > min_l){
                    if (longh && !longl){ // low_level is not long
                        val = xl;
                        curLine.setAttribute('x2', xl);
                        if (xl < xh){// to reduce distance between levels!!!!
                            val += (y2-y1)*tga;
                            right_transitions.push(curLine);
                        }
                        else {
                            val -= (y2-y1)*tga;
                            left_transitions.push(curLine);
                        }
                        curLine.setAttribute('x1', val);
                        visible_transitions.push(curLine);
                        count_visible++;
                    }
                    else{// only high_level or both are long
                        val = xh;
                        curLine.setAttribute('x1', val);
                        if (xh > xl){
                            val -= (y2-y1)*tga;
                            right_transitions.push(curLine);
                        }
                        else {
                            val += (y2-y1)*tga;
                            left_transitions.push(curLine);
                        }
                        curLine.setAttribute('x2', val);
                        visible_transitions.push(curLine);
                        count_visible++;
                    }
                }
                else set_invisible(curLine);
            }
            if (count_visible == 30){
                rating = curLine.getAttribute('rating');
                if (rating > 3) rating = 3;
            }
            if (count_visible > 30)
                if (curLine.getAttribute('rating') < rating) break;
        }
    }

    distr_transitions();
    fix_levels();
    show_texts();
}

function get_line_CTM(line){
    var ctM = line.parentNode.parentNode.parentNode.parentNode.getCTM();
    var CTMScale = 1/ctM.a;
    if (CTMScale != 1){ //not IE
        ctM.a = ctM.a * CTMScale;
        ctM.b = ctM.b * CTMScale;
        ctM.c = ctM.c * CTMScale;
        ctM.d = ctM.d * CTMScale;
        ctM.e = (ctM.e - line.parentNode.parentNode.parentNode.parentNode.parentNode.getCTM().e) * CTMScale;
        ctM.f = ctM.f * CTMScale;
    }
    return(ctM);
}

function fix_levels(){
    for (var i=0; i<visible_transitions.length; i++){
        var cTr = visible_transitions[i];

        var x2 = parseFloat(cTr.getAttribute('x2'));
        var ll = document.getElementById(cTr.getAttribute('low_level'));
        extend_level(ll, get_line_CTM(ll), x2);

        var x1 = parseFloat(cTr.getAttribute('x1'));
        var hl = document.getElementById(cTr.getAttribute('high_level'));
        extend_level(hl, get_line_CTM(hl), x1);
    }
}

function show_transition_text(transition, a, rH){
    var x1 = parseFloat(transition.getAttribute('x1'));
    var x2 = parseFloat(transition.getAttribute('x2'));
    var y1 = parseFloat(transition.getAttribute('y1'));
    var y2 = parseFloat(transition.getAttribute('y2'));
    var gx = x2 - (x2 - x1)*part_after_begin;
    var gy = y2 - (y2 - y1)*part_after_begin;

    var txtR = document.getElementById('rect_' + transition.getAttribute('id'));
    txtR.setAttribute('display', '');
    txtR.setAttribute('transform', 'rotate(' + a + ' ' + gx + ' ' + gy +')');
    txtR.setAttribute('x', gx);
    txtR.setAttribute('y', gy - 1);

    var txtE = document.getElementById('txt_' + transition.getAttribute('id'));
    txtE.setAttribute('transform', 'rotate(' + a + ' ' + gx + ' ' + gy +')');
    txtE.setAttribute('display', '');
    txtE.setAttribute('x', gx);
    txtE.setAttribute('y', gy + rH * 0);
    txtR.setAttribute('width', txtE.getComputedTextLength());
}

function show_texts(){
    var rH = 4;//?

    for (var i=0; i<left_transitions.length; i++)
        show_transition_text(left_transitions[i], -(90 + txt_angle), rH);

    for (var i=0; i<right_transitions.length; i++)
        show_transition_text(right_transitions[i], -(90 - txt_angle), rH);
}

function distr_ordered_transitions(transitions, side){
    for (var i = 0; i < transitions.length - 1 && transitions.length > 1; i++) {
        dn = 1;
        while (dn < transitions.length - i){
            curTr = transitions[i+dn];
            if (!equal(transitions[i], transitions[i+dn])) {
                d = Math.abs(distance(transitions[i], transitions[i+dn]));
                if (d < min_d) {	// try to shift i+dn transition
                    hl = document.getElementById(curTr.getAttribute('high_level'));
                    ll = document.getElementById(curTr.getAttribute('low_level'));
                    curDx = parseFloat(curTr.getAttribute('dx'));
                    hl_long = hl.hasAttribute('long');
                    ll_long = ll.hasAttribute('long');
                    if ((!hl_long) || (!ll_long)){
                        // high level is not long
                        dx = min_d - d + curDx;
                        if (dx <= max_dx){
                            new_x1 = parseFloat(curTr.getAttribute('x1'))
                            if (side == "left") new_x1 += dx;
                            else new_x1 -= dx;
                            curTr.setAttribute('x1', new_x1);

                            new_x2 = parseFloat(curTr.getAttribute('x2'));
                            if (side == "left") new_x2 += dx;
                            else new_x2 -= dx;
                            curTr.setAttribute('x2', new_x2);

                            curTr.setAttribute('dx', dx);
                            dn++;
                        }
                        else{ // hide transition
                            set_invisible(curTr);
                            transitions.splice(i+dn, 1);
                        }
                    }
                    else{ // both levels are long
                        dx = parseFloat(curTr.getAttribute('dx'));
                        if (dx + max_dx > (table_width*0.3)){
                            new_x1 = parseFloat(curTr.getAttribute('x1'));
                            if (side == "left") new_x1 += max_dx;
                            else new_x1 -= max_dx;
                            curTr.setAttribute('x1', new_x1);

                            curTr.setAttribute('dx', dx + max_dx);
                            new_x2 = parseFloat(curTr.getAttribute('x2'));
                            if (side == "left") new_x2 += max_dx;
                            else new_x2 -= max_dx;
                            curTr.setAttribute('x2', new_x2);
                            dn++;
                        }
                        else{
                            set_invisible(curTr);
                            transitions.splice(i+dn, 1);
                        }
                    }
                }
                else dn++; // d > min
            }
            else{ // if equal
                set_invisible(curTr);
                transitions.splice(i+dn, 1);
            }
        }
    }

}

function distr_transitions(){
    right_transitions.sort(sort_function_decrease_x1);
    left_transitions.sort(sort_function_increase_x1);
    distr_ordered_transitions(left_transitions, "left");     // left_transitions
    distr_ordered_transitions(right_transitions, "right");   // right_transitions
}

function sort_function_increase_x1(line1, line2){
    return sort_function(line1, line2, 1);
}

function sort_function_decrease_x1(line1, line2){
    return sort_function(line1, line2, -1);
}

function sort_function(line1, line2, dir){
    var x11 = parseFloat(line1.getAttribute('x1'));
    var x12 = parseFloat(line2.getAttribute('x1'));

    if (x11 != x12) return dir * (x11 - x12);
    else {
        var y11 = parseFloat(line1.getAttribute('y1'));
        var y12 = parseFloat(line2.getAttribute('y1'));
        if (y11 != y12) return y12 - y11;

        var x21 = parseFloat(line1.getAttribute('x2'));
        var x22 = parseFloat(line2.getAttribute('x2'));
        if (x21 != x22) return dir * (x22 - x21);
        else {
            //if (dir == -1) return 0;
            var wl1 = parseFloat(line1.getAttribute('wavelength'));
            var wl2 = parseFloat(line2.getAttribute('wavelength'));
            return wl1 - wl2;
        }
    }
}

function distance(line1, line2){
    return diff(line2, line1, 'x1') + tga * diff(line1, line2, 'y1');
}

function diff(line1, line2, param){
    var v1 = parseFloat(line1.getAttribute(param));
    var v2 = parseFloat(line2.getAttribute(param));
    if (isNaN(v1)) v1 = 0;
    if (isNaN(v2)) v2 = 0;
    return v1 - v2;
}

function equal(line1, line2){
    var dx1 = diff(line1, line2, 'x1') - diff(line1, line2, 'dx');
    var dx2 = diff(line1, line2, 'x2') - diff(line1, line2, 'dx');
    if (dx1 == 0 || dx2 == 0){
        var dy1 = Math.abs(diff(line1, line2, 'y1'));
        var dy2 = Math.abs(diff(line1, line2, 'y2'));
        if (dy1 <= max_eq_dy && dy2 <= max_eq_dy) return true;

        var wl1 = parseInt(line1.getAttribute('wavelength'));
        var wl2 = parseInt(line2.getAttribute('wavelength'));
        if (wl1 == wl2) return true;
        else return false;
    }
    return false;
}

function get_real_line_x(level){
    var trM = get_line_CTM(level);
    var mx = (parseFloat(level.getAttribute('x1')) + parseFloat(level.getAttribute('x2')))/ 2. ;
    return trM.a * mx + trM.e;
}

function set_invisible(line){
    line.setAttribute('display', 'none');
    // delete from visible_transitions
    for (var i = 0; i < visible_transitions.length; i++){
        if (visible_transitions[i].getAttribute('id') == line.getAttribute('id')){
            visible_transitions.splice(i, 1);
            break;
        }
    }
}

function extend_level(level, trMatr, new_x){
    var lx1 = level.getAttribute('x1');
    var lx2 = level.getAttribute('x2');
    var trM = trMatr.inverse();
    var nx = trM.a*new_x + trM.e;
    if (nx > Math.max(lx1, lx2)){
        level.setAttribute('x2', nx);
        level.setAttribute('x1', Math.min(lx1, lx2));
    }
    if (nx < Math.min(lx1, lx2)){
        level.setAttribute('x1', nx);
        level.setAttribute('x2', Math.max(lx1, lx2));
    }
}

function checkTexts(){
    var texts = document.getElementsByTagName('text');
    for (var i = 0; i < texts.length; i++){
        var svgTextNode =  texts.item(i);
        if (svgTextNode.getAttribute('display') != 'none' &&
            svgTextNode.getAttribute('class') == 'config'){
            var curChilds = (svgTextNode.parentNode).childNodes;
            for (var j = 0; j < curChilds.length; j++){
                if (curChilds.item(j).nodeName == 'rect' && curChilds.item(j).hasAttribute('id')
                    && svgTextNode.getAttribute('rec_id') == curChilds.item(j).getAttribute('id')
                    /*&& svgTextNode.getComputedTextLength() > curChilds.item(j).getAttribute('width')*/){//let it rotate all labels
                    // compare Rectangle width and text ComputedTextLength
                    rotateText(svgTextNode);
                    break;
                }
            }
        }
    }
}

function rotateText(elem){
    var curTransform = elem.hasAttribute('transform')? curTransform = elem.getAttribute('transform'): '';
    var resultTransform = 'rotate(-90 ' + elem.getAttribute('x') + ' ' + elem.getAttribute('y') +') ' ;
    resultTransform += curTransform;
    elem.setAttribute('transform', resultTransform);
}

////// interactive mouse functions
function getTarget(e){
    if ('getTarget' in e) return e.getTarget();
    else if (e.srcElement) return e.srcElement;
    else return e.relatedTarget;
}

function mouse_on_tr(evt, id){
//    if (target.nodeName != 'line') target = getTarget(evt);
    target = document.getElementById(id);
    show_level_info(document.getElementById(target.getAttribute('low_level')));
    show_level_info(document.getElementById(target.getAttribute('high_level')));
}

function click_on_tr(evt, id){
//    if (target.nodeName != 'line') target = getTarget(evt);
    target = document.getElementById(id);
    if (target.getAttribute('display') == 'none') target.setAttribute('display', '');
    else target.setAttribute('display', 'none');
}
function click_on_tr_text(evt, id){
//    if (target.nodeName != 'line') target = getTarget(evt);
    txt = document.getElementById('txt_' + id);
    rect = document.getElementById('rect_' + id);
    if (txt.getAttribute('display') == 'none') {
        txt.setAttribute('display', '');
        rect.setAttribute('display', '');
    }
    else {
        txt.setAttribute('display', 'none');
        rect.setAttribute('display', 'none');
    }
}

function mouse_move_tr(evt){
}

function mouse_out_tr(evt, id){
    //if (target.nodeName!='line') target = getTarget(evt);
    target = document.getElementById(id);
    hide_level_info(document.getElementById(target.getAttribute('low_level')));
    hide_level_info(document.getElementById(target.getAttribute('high_level')));
}

function mouse_on_level(evt, target){
    if (target.nodeName!='line') target = getTarget(evt);
    show_level_info(target);
}

function mouse_out_level(evt, target){
    if (target.nodeName!='line') target = getTarget(evt);
    hide_level_info(target);
}

function show_level_info(level){
    document.getElementById('txt_lbl_'+level.getAttribute('id')).setAttribute('display', '');
    document.getElementById('lbl_'+level.getAttribute('id')).setAttribute('display', '');
    document.getElementById('conf_name_'+level.getAttribute('id')).setAttribute('display', '');
}

function hide_level_info(level) {
    document.getElementById('txt_lbl_'+level.getAttribute('id')).setAttribute('display', 'none');
    document.getElementById('lbl_'+level.getAttribute('id')).setAttribute('display', 'none');
    document.getElementById('conf_name_'+level.getAttribute('id')).setAttribute('display', 'none');
}
