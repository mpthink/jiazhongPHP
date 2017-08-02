$("#ism_date_start").datepicker({changeYear: true});
$("#ism_date_end").datepicker({changeYear: true});
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
function bindAutoComplete() {
    $("#iss_name").catcomplete({source: './index.php?s=/InstoreBook/getProduct', minLength: 1, delay: 0, select: function (g, h) {
        $('#iss_prodname').val(h.item.prod_name)
    }})
};
bindAutoComplete();

function bindAutoComplete22() {
    $("#ism_sellerunit").catcomplete22({source: './index.php?s=/InstoreBook/autoSelect22', minLength: 1, delay: 0, select: function (g, h) {
        $('#ism_sellerunit').val(h.item.gust_name)
    }})
};
$.widget("custom.catcomplete22", $.ui.autocomplete, {_renderMenu: function (g, h) {
    var i = this, j = "";
    $.each(h, function (k, l) {
        i._renderItem(g, l)
    })
}});
bindAutoComplete22();