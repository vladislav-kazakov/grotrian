var tga = 0.3;
var txt_angle=17;
var visible_transitions = new Array();
var right_transitions = new Array();
var left_transitions = new Array();
var count_visible=0;
var min_dy = 50; // min dy for not interfering
var max_dx = 15; // max dx for not long level
var min_l = 40; // min length for visible line
var min_dx = 5;
var min_d = 15;
var max_eq_dy = 7;
var min_levels_count = 5;
var part_after_begin = 0.25;
var compression_rate = table_width / window.innerWidth;
if (compression_rate > 1.)
{
    compress_table();
}

fix_viewBox();
checkTexts();
drawTransitions();

//Sort function for j like "9/2"
function slava_sort_function_j(j1, j2)
{
    if (j1 == "") j1 = 0;
    if (j2 == "") j2 = 0;

    if (eval(j1) > eval(j2)) return 1;
    if (eval(j1) < eval(j2)) return -1;
    if (eval(j1) == eval(j2)) return 0;
}

function compress_table()
{
    var g_cores = document.getElementsByTagName('g');
    var i, j, g_terms, rect_terms, text_terms, g_levels, k, l, curL, curSeq, curPrefix, curJ, toCompress, gL, gSeq, gPrefix, gParity, compJ, dx;
    for (i=0; i < g_cores.length; i++)
    {
        if ('core' == g_cores.item(i).getAttribute('class'))
        {
            g_terms = g_cores.item(i).getElementsByTagName('g');
            for (j=0; j< g_terms.length; j++)
            {
                if ('term' == g_terms.item(j).getAttribute('class'))
                {
                    compJ = false;
                    rect_terms = g_terms.item(j).getElementsByTagName('rect');
                    gPrefix = g_terms.item(j).getAttribute('prefix');
                    gParity = g_terms.item(j).getAttribute('parity');
                    if (rect_terms.length > 1)
                    {
                        if ((rect_terms.length > 2) && (compression_rate >= 1.5))
                        {
                            gL = rect_terms.item(0).getAttribute('L');
                            gSeq = rect_terms.item(0).getAttribute('seq');
                            if (!is_equal_attribute(rect_terms, 'L', gL))
                            {
                                gL = '(...)';
                            }
                            else
                            {
                                if ('' == gSeq)
                                {
                                    compJ = true;
                                }
                                else
                                {
                                    if (!is_equal_attribute(rect_terms, 'seq', gSeq))
                                    {
                                        gSeq = '';
                                    }
                                    else
                                    {
                                        compJ = true;
                                    }
                                }
                            }
                        }

                        g_levels = g_terms.item(j).getElementsByTagName('g');
                        text_terms = g_terms.item(j).getElementsByTagName('text');

                        if (compJ || ((compression_rate < 2.) || (rect_terms.length < 3)))
                        {
                            // try to compress
                            for (k=0; k < rect_terms.length; k++)
                            {
                                if (compJ || ((min_levels_count > parseInt(rect_terms.item(k).getAttribute('n_levels'))) || 'no' ==rect_terms.item(k).getAttribute('info')))
                                { // too little count of levels for term => compress
                                    curL = rect_terms.item(k).getAttribute('L');
                                    curSeq = rect_terms.item(k).getAttribute('seq');
                                    curPrefix = rect_terms.item(k).getAttribute('prefix');
                                    curJ = rect_terms.item(k).getAttribute('j');
                                    toCompress = new Array();
                                    find_similar(-1, rect_terms, k, curL, curSeq, curPrefix, toCompress);
                                    if (toCompress.length > 0)
                                    {
                                        toCompress.push(k);
                                        toCompress.sort(sort_numbers);
                                        //alert('i = '+i+'; j= '+ j+'; k='+k+'; l='+toCompress.length+'; new = ' + toCompress[toCompress.length - 1] + '; rect= ' + rect_terms.length);
                                        k = toCompress[toCompress.length - 1] + 1;
                                        // compression
                                        // hide levels
                                        var ii;
                                        for (ii=1; ii<toCompress.length; ii++)
                                        {
                                            dx = - term_row_w * ii;
                                            shift_glevels(g_levels.item(toCompress[ii]), dx, true)
                                            rect_terms.item(toCompress[ii]).setAttribute('display', 'none');
                                            rect_terms.item(toCompress[ii]).nextSibling.setAttribute('display', 'none');
                                        }
                                        //dx = - term_row_w * (toCompress.length - 1);
                                        // append J
                                        var tJ = rect_terms.item(toCompress[0]).nextSibling;

                                        //Slava
                                        jArr = new Array();
                                        for (ii = 0; ii < toCompress.length; ii++)
                                        {
                                            jArr.push(rect_terms.item(toCompress[ii]).getAttribute('j'));
                                            jArr.sort(slava_sort_function_j);
                                        }
                                        var newJ;
                                        if (jArr[0] != jArr[jArr.length - 1])
                                            newJ = document.createTextNode((jArr[0] == ""?0:jArr[0])  + '-' + (jArr[jArr.length - 1] == ""?0:jArr[jArr.length - 1]));
                                        else newJ = document.createTextNode(jArr[0] == ""?0:jArr[0]);

                                        var tSpans = tJ.getElementsByTagName('tspan');
                                        tSpans.item(tSpans.length-1).setAttribute('display', 'none');
                                        //End of Slava

                                        //Slava var newJ = document.createTextNode('-' + rect_terms.item(toCompress[toCompress.length - 1]).getAttribute('j'));
                                        var newSpan = document.createElement('tspan');

                                        newSpan.setAttribute('class', 'index');
                                        newSpan.setAttribute('type', 'compressed');
                                        newSpan.appendChild(newJ);
                                        tJ.appendChild(newSpan);
                                        // shift levels of current term
                                        for (ii = toCompress[toCompress.length - 1] + 1; ii < rect_terms.length; ii++)
                                        {
                                            shift_glevels(g_levels.item(ii), dx);
                                            rect_terms.item(ii).setAttribute('x', parseFloat(rect_terms.item(ii).getAttribute('x')) + dx);
                                            rect_terms.item(ii).nextSibling.setAttribute('x', parseFloat(rect_terms.item(ii).nextSibling.getAttribute('x')) + dx);
                                        }
                                        // shift next terms
                                        var curTerm = g_terms.item(j);
                                        compress_shift_data(curTerm, dx);
                                    }

                                }
                            }
                        }
                        else
                        {
                            if ((rect_terms.length > 2) && (compression_rate >= 2.))
                            {// compress term
                                // create new text
                                var newText = text_terms.item(0).cloneNode(true);
                                if (newText.hasAttribute('transform'))
                                {
                                    newText.removeAttribute('transform');
                                }
                                var nTextSpans = newText.getElementsByTagName('tspan');
                                newText.removeChild(nTextSpans.item(nTextSpans.length - 1));

                                if ('' == gSeq && ('#text' == newText.firstChild.nodeName))
                                {
                                    newText.removeChild(newText.firstChild);
                                }
                                var nL = document.createTextNode(gL);
                                if (nTextSpans.item(1).hasChildNodes())
                                {
                                    nTextSpans.item(1).removeChild(nTextSpans.item(1).firstChild);
                                }
                                nTextSpans.item(1).appendChild(nL);
                                // create new rectangle
                                var newRect = rect_terms.item(0).cloneNode(false);
                                newRect.setAttribute('type', 'compression');
                                // hide all texts and rectangles and shift levels
                                for (k = 0; k< rect_terms.length; k++)
                                {
                                    rect_terms.item(k).setAttribute('display', 'none');
                                    rect_terms.item(k).nextSibling.setAttribute('display', 'none');
                                    dx = - term_row_w * k;
                                    shift_glevels(g_levels.item(k), dx, true);
                                }
                                // add new rect and text
                                g_terms.item(j).insertBefore(newText, g_terms.item(j).firstChild);
                                g_terms.item(j).insertBefore(newRect, g_terms.item(j).firstChild);
                                compress_shift_data(g_terms.item(j), dx);
                            }
                        }

                    }
                }
            }
        }
    }
}
function is_equal_attribute(nList, attrName, attrVal)
{
    var i, aV;
    for (i=1; i<nList.length; i++)
    {
        aV = nList.item(i).getAttribute(attrName);
        if (attrVal != aV)
        {
            return false;
        }

    }
    return true;
}
function sort_numbers(arg1, arg2)
{
    if (parseInt(arg1) > parseInt(arg2))
    {
        return 1;
    }
    else
    {
        return -1;
    }
}

function find_similar(di, data, n, L, Seq, Prefix, result)
{
    if ((n + di) >= 0 && (n+di) < data.length)
    {
        var curEl = data.item(n+di);
        var nL = curEl.getAttribute('L');
        if (nL == L)
        {
            var nSeq = curEl.getAttribute('seq');
            if (nSeq == Seq)
            {
                var nPrefix = curEl.getAttribute('prefix');
                if (nPrefix == Prefix)
                {
                    result.push(n+di);
                    find_similar(di + Math.abs(di)/di, data, n, L, Seq, Prefix, result);
                }
                else
                {
                    if (di > 0)	return 1;
                    else find_similar(1, data, n, L, Seq, Prefix, result);
                }
            }
            else
            {
                if (di > 0)	return 1;
                else find_similar(1, data, n, L, Seq, Prefix, result);
            }

        }
        else
        {
            if (di > 0)	return 1;
            else find_similar(1, data, n, L, Seq, Prefix, result);
        }
    }
    else
    {
        if (n+di < 0) find_similar(1, data, n, L, Seq, Prefix, result);
        else return 1;
    }
}

function fix_viewBox()
{
    var nTW = table_width + 100;
    if (window.svgDocument){
        window.svgDocument.rootElement.setAttribute('viewBox', '0 0 '+ nTW + ' ' + table_height);
    } else {
        window.document.getElementById("svg_with_diagram").setAttribute('viewBox', '0 0 '+ nTW + ' ' + table_height);
    }
}

function compress_shift_data(curTerm, dx)
{
    var Term = curTerm.nextSibling;
    while (Term != null)
    {
        if ('term' == Term.getAttribute('class'))
        {
            shift_group(Term, dx);
        }
        Term = Term.nextSibling;
    }
    //compress current core
    var curCore = curTerm.parentNode;
    compress_group(curCore, dx);
    //shift cores
    var Core = curCore.nextSibling;
    while (Core != null)
    {
        if ('core' == Core.getAttribute('class'))
        {
            shift_group(Core, dx);
        }
        Core = Core.nextSibling;
    }

    // compress config
    var curConf = curCore.parentNode;
    compress_group(curConf, dx);

    // shift next columns
    var Conf = curConf.nextSibling;
    while (Conf != null)
    {
        if ('column' == Conf.getAttribute('class'))
        {
            shift_group(Conf, dx);
        }
        Conf = Conf.nextSibling;
    }

    // compress AllData
    var rAll = document.getElementById('AllData');
    table_width += dx;
    rAll.setAttribute('width', table_width);

    // shift eV energy scale
    var e = document.getElementById('EeV');
    e.setAttribute('transform', 'translate(' + table_width +',0)');
    // shift Name
    var n = document.getElementById('Abbr');
    n.setAttribute('x', table_width - 5);
}

function compress_group(gr, dx)
{
    var chG = gr.childNodes;
    for (i=0; i < chG.length; i++)
    {
        if ('text' == chG.item(i).nodeName)
        {
            chG.item(i).setAttribute('x', parseFloat(chG.item(i).getAttribute('x')) + dx/2.);
        }
        if ('rect' == chG.item(i).nodeName)
        {
            chG.item(i).setAttribute('width', parseFloat(chG.item(i).getAttribute('width')) + dx);
        }
    }
}

function shift_group(gr, dx)
{
    var chG = gr.childNodes;
    var i, cl, t;
    for (i=0; i< chG.length; i++)
    {
        t = chG.item(i).nodeName;
        if (('rect' == t) || ('text' == t))
        {
            chG.item(i).setAttribute('x', parseFloat(chG.item(i).getAttribute('x')) + dx);
        }
        if ('g' == t)
        {
            cl = gr.getAttribute('class');
            if (('column' == cl) || ('core' == cl))
            {
                shift_group(chG.item(i), dx);
            }
            if ('term' == cl)
            {
                shift_glevels(chG.item(i), dx, false);
            }
        }
    }
}

function shift_glevels(gLevels, dx, hide)
{
    if ('g' == gLevels.nodeName && 'levels' == gLevels.getAttribute('class'))
    {
        var j;
        lines = gLevels.getElementsByTagName('line');
        for (j = 0; j < lines.length; j++)
        {
            line = lines.item(j);
            line.setAttribute('x1', parseFloat(line.getAttribute('x1')) + dx);
            line.setAttribute('x2', parseFloat(line.getAttribute('x2')) + dx);
        }
        txt_l = gLevels.getElementsByTagName('text');
        for (j = 0; j < txt_l.length; j++)
        {
            line = txt_l.item(j);
            line.setAttribute('x', parseFloat(line.getAttribute('x')) + dx);
            if (hide)
            { line.setAttribute('display', 'none'); }
        }
        return 1;
    }
    return -1;
}

function scale_to_height()
{
    var w_h = window.innerHeight;
    var d_h = document.rootElement.getAttribute('height');
    if (w_h < d_h)
    {
        var sc = 'scale(1 ' + Math.floor(w_h/d_h*100)/100. + ')';
        document.rootElement.setAttribute('transform', sc);
    }
}

//parent.redrawTransitionsWaveRange = redrawTransitionsWaveRange;

function drawTransitions()
{
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
    //if(!minWave){minWave=null;}
    drawTransitionsWaveEnergyRange(minWave, maxWave, minEnergy, maxEnergy);
}

function drawTransitionsWaveEnergyRange(minWave, maxWave, minEnergy, maxEnergy)
{
    var transitions = document.getElementById('transitions');
    if (null == transitions) return 1;
    transitions = transitions.childNodes;
    var rating, i, llevel, hlevel, curLine, txt_el, ex;
    var y1, y2, xl1, xl2, xh1, xh2, longh, longl, val, hx, len;
    //rating = transitions.item(0).getAttribute('rating');
    ex = false;

    for (i=0; (i<transitions.length && (false == ex)); i++)
    {

        if ( document.getElementById(transitions.item(i).getAttribute('high_level')) && document.getElementById(transitions.item(i).getAttribute('low_level')) )

        {
            if ('line' == transitions.item(i).nodeName
                && (maxWave == null || transitions.item(i).getAttribute('wavelength') <= maxWave)
                && (minWave == null || transitions.item(i).getAttribute('wavelength') >= minWave)
                && (maxEnergy == null || document.getElementById(transitions.item(i).getAttribute('high_level')).getAttribute('energy') <= maxEnergy)
                && (minEnergy == null || document.getElementById(transitions.item(i).getAttribute('high_level')).getAttribute('energy') >= minEnergy)
                && (maxEnergy == null || document.getElementById(transitions.item(i).getAttribute('low_level')).getAttribute('energy') <= maxEnergy)
                && (minEnergy == null || document.getElementById(transitions.item(i).getAttribute('low_level')).getAttribute('energy') >= minEnergy)

            )
            {
                curLine = transitions.item(i);
                hlevel = document.getElementById(curLine.getAttribute('high_level'));
                llevel = document.getElementById(curLine.getAttribute('low_level'));
                longh = hlevel.hasAttribute('long');
                longl = llevel.hasAttribute('long');
                xl = get_real_line_x(llevel);
                xh = get_real_line_x(hlevel);
                y1 = parseFloat(hlevel.getAttribute('y1'));
                y2 = parseFloat(llevel.getAttribute('y1'));
                curLine.setAttribute('y1', y1);
                curLine.setAttribute('y2', y2);

                if (!longh && !longl)
                {
                    len = Math.sqrt((y2-y1)*(y2-y1) + (xh-xl)*(xh-xl));
                    //	if (len > min_l)
                    //	{
                    //      	curLine.setAttribute('x1', xh);
                    //              curLine.setAttribute('x2', xl);
                    //		visible_transitions.push(curLine);count_visible++;
                    //	}
                    set_invisible(curLine);
                }
                else
                {
                    len = Math.sqrt((1+tga*tga)*(y2-y1)*(y2-y1));
                    if (len > min_l)
                    {
                        if (longh && !longl)
                        { // low_level is not long
                            val = xl;
                            curLine.setAttribute('x2', xl);
                            if (xl < xh) // to reduce distance between levels!!!!
                            {
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
                        else
                        {// only high_level or both are long
                            val = xh;
                            curLine.setAttribute('x1', val);
                            if (xh > xl)
                            {
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
                    } else {
                        set_invisible(curLine);
                    }
                }
                if (30 == count_visible)
                {
                    rating = curLine.getAttribute('rating');
                    if (rating > 3)
                    {
                        rating = 3;
                    }
                }
                if (count_visible > 30)
                {
                    if (curLine.getAttribute('rating') < rating)
                    {
                        //alert(count_visible);
                        ex = true;
                    }
                }
            }
        }
    }

    distr_transitions();
    fix_levels();
    show_texts();
}

function get_line_CTM(line)
{
    //return line.parentNode.parentNode.parentNode.parentNode.getCTM();
    var ctM = line.parentNode.parentNode.parentNode.parentNode.getCTM();
    var CTMScale = 1/ctM.a;
    if (CTMScale!=1){ //not IE
        ctM.a=ctM.a*CTMScale;ctM.b=ctM.b*CTMScale;ctM.c=ctM.c*CTMScale;
        ctM.d=ctM.d*CTMScale;ctM.e=(ctM.e-line.parentNode.parentNode.parentNode.parentNode.parentNode.getCTM().e)*CTMScale;ctM.f=ctM.f*CTMScale;
    }
    return(ctM);
}
function fix_levels()
{
    var i, x, ll, hl, cTr;

    for (i=0; i<visible_transitions.length; i++)
    {
        cTr = visible_transitions[i];
        x = parseFloat(cTr.getAttribute('x2'));
        ll = document.getElementById(cTr.getAttribute('low_level'));
        hl = document.getElementById(cTr.getAttribute('high_level'));
        extend_level(ll, get_line_CTM(ll), x);
        x = parseFloat(cTr.getAttribute('x1'));
        extend_level(hl, get_line_CTM(hl), x);
    }
}

function show_transition_text(transition, a, rH)
{
    var curTr = transition;
    var curId = curTr.getAttribute('id');
    var x1 = parseFloat(curTr.getAttribute('x1'));
    var x2 = parseFloat(curTr.getAttribute('x2'));
    var y1 = parseFloat(curTr.getAttribute('y1'));
    var y2 = parseFloat(curTr.getAttribute('y2'));
    var gx = x2 - (x2 - x1)*part_after_begin;
    var gy = y2 - (y2 - y1)*part_after_begin;
    var txtR = document.getElementById('rect_' + curId);
    var txtE = document.getElementById('txt_' + curId);
    var cR = 'rotate(' + a + ' ' + gx + ' ' + gy +')';
    txtR.setAttribute('display', '');
    txtR.setAttribute('transform', cR);
    txtR.setAttribute('x', gx);
    txtR.setAttribute('y', gy - 1);
    var cR = 'rotate(' + a + ' ' + gx + ' ' + gy +')';
    txtE.setAttribute('transform', cR);
    txtE.setAttribute('display', '');
    txtE.setAttribute('x', gx);
    txtE.setAttribute('y', gy + rH);
    txtR.setAttribute('width', txtE.getComputedTextLength());
}

function show_texts()
{
    var rH = 4;

    var a = -(90 + txt_angle);
    for (var i=0; i<left_transitions.length; i++)
        show_transition_text(left_transitions[i], a, rH);

    var a = -(90 - txt_angle);
    for (var i=0; i<right_transitions.length; i++)
        show_transition_text(right_transitions[i], a, rH);

}

//Slava
function distr_ordered_transitions(transitions, side)
{
    for (i=0; i<transitions.length - 1 && transitions.length > 1; i++)
    {
        next = false;
        dn = 1;
        while ( (!next) && (dn < transitions.length - i))
        {
            curTr = transitions[i+dn];
            //curTr.setAttribute('display', '');
            if (!equal(transitions[i], transitions[i+dn]))
            {
                d = Math.abs(distance(transitions[i], transitions[i+dn]));
                if (d < min_d)
                {	// try to shift i+dn transition
                    hl = document.getElementById(curTr.getAttribute('high_level'));
                    ll = document.getElementById(curTr.getAttribute('low_level'));
                    curDx = parseFloat(curTr.getAttribute('dx'));
                    hl_long = hl.hasAttribute('long');
                    ll_long = ll.hasAttribute('long');
                    if ((!hl_long) || (!ll_long))
                    {// high level is not long
                        dx = min_d - d + curDx;
                        if (dx <= max_dx)
                        {
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
                        else
                        { // hide transition
                            set_invisible(curTr);
                            transitions.splice(i+dn, 1);
                        }
                    }
                    else
                    {// both levels are long
                        dx = parseFloat(curTr.getAttribute('dx'));
                        if (dx + max_dx > (table_width*0.3))
                        {
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
                        else
                        {
                            set_invisible(curTr);
                            transitions.splice(i+dn, 1);
                        }
                    }
                }
                else
                { // d > min
                    dn++;
                }
            }
            else
            { // if equal
                set_invisible(curTr);
                transitions.splice(i+dn, 1);
            }
        }
    }

}

function distr_transitions()
{
    right_transitions.sort(sort_function_decrease_x1);
    left_transitions.sort(sort_function_increase_x1);
    var i, next, dn, d, hl, ll, curTr, hl_long, ll_long, curDx, new_x2, new_x1, dx;
    // left_transitions
    distr_ordered_transitions(left_transitions, "left")
    // right_transitions
    distr_ordered_transitions(right_transitions, "right")
}

function sort_function_increase_x1(line1, line2)
{
    var x11 = parseFloat(line1.getAttribute('x1'));
    var x12 = parseFloat(line2.getAttribute('x1'));

    if (x11 > x12)	return 1;
    if (x11 < x12)	return -1;
    if (x11 == x12)
    {
        var y11 = parseFloat(line1.getAttribute('y1'));
        var y12 = parseFloat(line2.getAttribute('y1'));
        if (y11 > y12)	return -1;
        if (y11 < y12)	return 1;

        var x21 = parseFloat(line1.getAttribute('x2'));
        var x22 = parseFloat(line2.getAttribute('x2'));
        if (x21 > x22)	return -1;
        if (x21 < x22)	return 1;
        if (x21 == x22)
        {
            var wl1 = parseFloat(line1.getAttribute('wavelength'));
            var wl2 = parseFloat(line2.getAttribute('wavelength'));
            if (wl1 > wl2)	return 1;
            if (wl1 < wl2)	return -1;
            return 0;

        }
    }
}

function sort_function_decrease_x1(line1, line2)
{
    var x11 = parseFloat(line1.getAttribute('x1'));
    var x12 = parseFloat(line2.getAttribute('x1'));

    if (x11 < x12)	return 1;
    if (x11 > x12)	return -1;
    if (x11 == x12)
    {
        var y11 = parseFloat(line1.getAttribute('y1'));
        var y12 = parseFloat(line2.getAttribute('y1'));
        if (y11 > y12)	return -1;
        if (y11 < y12)	return 1;

        var x21 = parseFloat(line1.getAttribute('x2'));
        var x22 = parseFloat(line2.getAttribute('x2'));

        if (x21 > x22)	return 1;
        if (x21 < x22)	return -1;
        if (x21 == x22)	return 0;
    }
}

function distance(line1, line2)
{
    var dx = (diff(line2, line1, 'x1')) + tga*(diff(line1, line2, 'y1'));
    return dx;
}
function diff(line1, line2, param)
{
    var v1 = parseFloat(line1.getAttribute(param));
    var v2 = parseFloat(line2.getAttribute(param));
    if (isNaN(v1))
        v1 = 0;
    if (isNaN(v2))
        v2 = 0;
    var dx = v1 - v2;
    return dx;
}
function equal(line1, line2)
{
    var dx1 = diff(line1, line2, 'x1') - diff(line1, line2, 'dx');
    var dx2 = diff(line1, line2, 'x2') - diff(line1, line2, 'dx');
    if ((0 == dx1) || (0 == dx2))
    {
        var dy1 = Math.abs(diff(line1, line2, 'y1'));
        var dy2 = Math.abs(diff(line1, line2, 'y2'));
        if ((dy1 <= max_eq_dy) && (dy2 <= max_eq_dy))
        {
            return true;
        }
        var wl1 = parseInt(line1.getAttribute('wavelength'));
        var wl2 = parseInt(line2.getAttribute('wavelength'));
        if (wl1 == wl2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    return false;
}
function get_real_line_x(level)
{
    var trM = get_line_CTM(level);
    var mx = (parseFloat(level.getAttribute('x1')) + parseFloat(level.getAttribute('x2')))/ 2. ;
    return trM.a*mx+trM.e;
}

function compare_hl_x(line1, line2)
{
    var hl1 = document.getElementById(line1.getAttribute('high_level'));
    var hl2 = document.getElementById(line2.getAttribute('high_level'));
    var TrM1 = get_line_CTM(hl1);
    var TrM2 = get_line_CTM(hl2);
    var x1 = TrM1.a*(parseFloat(hl1.getAttribute('x1')) + parseFloat(hl1.getAttribute('x2'))/2.) + TrM1.e;
    var x2 = TrM2.a*(parseFloat(hl2.getAttribute('x1')) + parseFloat(hl2.getAttribute('x2'))/2.) + TrM2.e;
    if (x1 > x2)
    {
        return 1;
    }
    if (x1 < x2)
    {
        return -1;
    }
    return 0;
}

function set_invisible(line)
{
    line.setAttribute('display', 'none');
    // delete from visible_transitions
    var line_id = line.getAttribute('id');
    var i;
    for (i=0; i < visible_transitions.length; i++)
    {
        if (visible_transitions[i].getAttribute('id') == line_id)
        {
            visible_transitions.splice(i, 1);
            i = visible_transitions.length; // stop searching
        }
    }
}

function compare_y1(line1, line2)
{ // for sorting array
    var l1y1, l2y1;
    l1y1 = line1.getAttribute('y1');
    l2y1 = line2.getAttribute('y1');
    if (l1y1 < l2y1)
    {
        return 1;
    }
    if (l1y1 == l2y1)
    {
        return 0;
    }
    if (l1y1 > l2y1)
    {
        return -1;
    }
}

function find_equal_attribute(attr_name, attr_val, start)
{
    var i;
    for (i=start; i<visible_transitions.length; i++)
    {
        if (attr_val == visible_transitions[i].getAttribute(attr_name))
        {
            return i;
        }
    }
    return i;
}


function extend_level(level, trMatr, new_x)
{
    var lx1, lx2, trM, nx;
    lx1 = level.getAttribute('x1');
    lx2 = level.getAttribute('x2');
    trM = trMatr.inverse();
    nx = trM.a*new_x + trM.e;
    if (nx>Math.max(lx1, lx2))
    {
        level.setAttribute('x2', nx);
        level.setAttribute('x1', Math.min(lx1, lx2));
    }
    if (nx < Math.min(lx1, lx2))
    {
        level.setAttribute('x1', nx);
        level.setAttribute('x2', Math.max(lx1, lx2));
    }
}

function checkTexts()
{
    var texts = document.getElementsByTagName('text');
    var sId;
    var i, j, l_text, recId, svgTextNode, svgRecNode, svgRecId, curChilds;

    for (i=0; i<texts.length; i++)
    {
        svgTextNode =  texts.item(i);
        if ('none' != svgTextNode.getAttribute('display'))
        {
            if ('config' == svgTextNode.getAttribute('class'))
            {
                svgRecId = svgTextNode.getAttribute('rec_id');
                curChilds = (svgTextNode.parentNode).childNodes;
                for (j=0; j<curChilds.length; j++)
                {
                    if ((('rect' == curChilds.item(j).nodeName) && (curChilds.item(j).hasAttribute('id'))) && (svgRecId == curChilds.item(j).getAttribute('id')))
                    {
                        svgRecNode = curChilds.item(j);
                        // compare Rectangle width and text ComputedTextLength
                        if (svgTextNode.getComputedTextLength > svgRecNode.getAttribute('width'))
                        {
                            rotateText(svgTextNode);
                            j = curChilds.length; // stop searching
                        }
                    }
                }
            }
        }
    }
}

function rotateText(elem)
{
    var curTransform, resultTransform;
    if (elem.hasAttribute('transform'))
    {
        curTransform = elem.getAttribute('transform');
    }
    else
    {
        curTransform='';
    }
    var curX, curY;
    curX = elem.getAttribute('x');
    curY = elem.getAttribute('y');

    resultTransform = 'rotate(-90 ' + curX + ' ' + curY +') ';
    resultTransform += curTransform;
    elem.setAttribute('transform', resultTransform);
}

////// interactive mouse functions
function getTarget(e) {
    if ('getTarget' in e) return e.getTarget();
    else if (e.srcElement) return e.srcElement;
    else return e.relatedTarget;
}

function mouse_on_tr(evt, target)
{
    if (target.nodeName!='line'){
        target = getTarget(evt)
    };
    //var target = evt.getTarget();
    //var target = getTarget(evt);
    //if (target==null){var target = evt.getTarget();}
    var ll = document.getElementById(target.getAttribute('low_level'));
    var hl = document.getElementById(target.getAttribute('high_level'));
    show_level_info(ll);
    show_level_info(hl);
}
function mouse_move_tr(evt)
{
}
function mouse_out_tr(evt, target)
{
    if (target.nodeName!='line'){
        target = getTarget(evt)
    };
    //var target = evt.getTarget();
    //var target = getTarget(evt);
    //if (target==null){var target = evt.getTarget();}
    var ll = document.getElementById(target.getAttribute('low_level'));
    var hl = document.getElementById(target.getAttribute('high_level'));
    hide_level_info(ll);
    hide_level_info(hl);
}
function mouse_on_level(evt, target)
{
    if (target.nodeName!='line'){
        target = getTarget(evt)
    };
    //var target = evt.getTarget();
    //var target = getTarget(evt);
    //if (target==null){var target = evt.getTarget();}
    show_level_info(target);
}
function mouse_out_level(evt, target)
{
    if (target.nodeName!='line'){
        target = getTarget(evt)
    };
    //var target = evt.getTarget();
    //var target = getTarget(evt);
    //if (target == null) {var target = evt.getTarget();}
    hide_level_info(target);
}
function show_level_info(level)
{
    txt_el = document.getElementById('txt_lbl_'+level.getAttribute('id'));
    line_el = document.getElementById('lbl_'+level.getAttribute('id'));
    txt_conf_el = document.getElementById('conf_name_'+level.getAttribute('id'));
    txt_el.setAttribute('display', '');
    line_el.setAttribute('display', '');
    txt_conf_el.setAttribute('display', '');
}
function hide_level_info(level)
{
    txt_el = document.getElementById('txt_lbl_'+level.getAttribute('id'));
    line_el = document.getElementById('lbl_'+level.getAttribute('id'));
    txt_conf_el = document.getElementById('conf_name_'+level.getAttribute('id'));
    txt_el.setAttribute('display', 'none');
    line_el.setAttribute('display', 'none');
    txt_conf_el.setAttribute('display', 'none');
}
