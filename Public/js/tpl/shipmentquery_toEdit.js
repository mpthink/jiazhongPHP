﻿function clearTip(g) {
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

$(".btn").button();

function bindAutoComplete22() {
    $("#ship_customer").catcomplete22({source: './index.php?s=/ShipmentBook/autoSelect22', minLength: 1, delay: 0, select: function (g, h) {
        $('#ship_customer').val(h.item.gust_name);
		$('#ship_customer_address').val(h.item.gust_address);
		$('#ship_customer_info').val(h.item.gust_phone);
    }})
};
$.widget("custom.catcomplete22", $.ui.autocomplete, {_renderMenu: function (g, h) {
    var i = this, j = "";
    $.each(h, function (k, l) {
        i._renderItem(g, l)
    })
}});
bindAutoComplete22();

$("#ship_input_date").datepicker();
$("#ship_deliver_date").datepicker();
$("#ship_deliver_back_date").datepicker();
$("#ship_load_date").datepicker();
$("#ship_arrive_date").datepicker();
