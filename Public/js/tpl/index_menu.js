function cleartabon() {
    if (b) {
        b.className = ''
    }
    ;
    for (var g = 0; g < a.length; g++) {
        var h = a[g];
        if (h.className == 'tabon') {
            b = h
        }
    }
};
var a = document.getElementById('leftmenu').getElementsByTagName('a');
var b = '';
for (var c = 0; c < a.length; c++) {
    var g = a[c];
    g.onclick = function () {
        setTimeout('cleartabon()', 1);
        this.className = 'tabon';
        this.blur()
    }
}
;
cleartabon();