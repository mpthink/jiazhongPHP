$("#osm_date_start").datepicker({changeYear: true});
$("#osm_date_end").datepicker({changeYear: true});
function clearTip(g) {
    if ($(g).val() == '请输入关键字或空格') {
        $(g).attr('style', 'color:#000');
        $(g).val('')
    }
};
function fillTip(g) {
    if ($(g).val() == '') {
        $(g).attr('style', 'color:#CCC');
        $(g).val('请输入关键字或空格')
    }
};
$.widget("custom.catcomplete", $.ui.autocomplete, {_renderMenu: function (g, h) {
    var i = this, j = "";
    $.each(h, function (k, l) {
        if (l.category != j) {
            g.append("<li class='ui-autocomplete-category'>" + l.category + "</li>");
            j = l.category
        }
        ;
        i._renderItem(g, l)
    })
}});
function bindAutoComplete() {
    $("#oss_name").catcomplete({source: './index.php?s=/InstoreBook/getProduct', minLength: 1, delay: 0, select: function (g, h) {
        $('#oss_prodname').val(h.item.prod_name)
    }})
};
bindAutoComplete();

function bindAutoComplete22() {
    $("#osm_buyerunit").catcomplete22({source: './index.php?s=/InstoreBook/autoSelect22', minLength: 1, delay: 0, select: function (g, h) {
        $('#osm_buyerunit').val(h.item.gust_name)
    }})
};
$.widget("custom.catcomplete22", $.ui.autocomplete, {_renderMenu: function (g, h) {
    var i = this, j = "";
    $.each(h, function (k, l) {
        i._renderItem(g, l)
    })
}});
bindAutoComplete22();