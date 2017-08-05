$("#fastSearch").click(function () {
    window.location.href = "./index.php?s=/ShipmentQuery/index/searchBy/" + $("#searchBy").val() + "/keyword/" + $("#keyword").val()
});
$("#btnAdd").click(function () {
    window.location.href = "./index.php?s=/ShipmentBook/index"
});

function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/ShipmentQuery/delete/ship_id/" + g
    }
};

function toSearch() {
    $("#dialog").dialog({height: 400, width: 650, modal: true, buttons: {"确认": function () {
        var g = $("#dialog").contents();
        var i = g.find("input[name='ship_customer']").val();
        var j = g.find("input[name='ship_input_start']").val();
        var k = g.find("input[name='ship_input_end']").val();
        var l = g.find("input[name='ship_deliver_start']").val();
        var m = g.find("input[name='ship_deliver_end']").val();
        var n = g.find("input[name='ship_back_start']").val();
        var o = g.find("input[name='ship_back_end']").val();
		
        action_url = "./index.php?s=/InstoreQuery/index";
        if (i != '请输入关键字或空格')action_url += "/ship_customer/" + i;
        if (j != "")action_url += "/ship_input_start/" + j;
        if (k != "")action_url += "/ship_input_end/" + k;
        if (l != "")action_url += "/ship_deliver_start/" + l;
        if (m != "")action_url += "/ship_deliver_end/" + m;
        if (n != "")action_url += "/ship_back_start/" + n;
        if (o != "")action_url += "/ship_back_end/" + o;

        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};


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

function bindAutoComplete22() {
    $("#ship_customer").catcomplete22({source: './index.php?s=/ShipmentBook/autoSelect22', minLength: 1, delay: 0, select: function (g, h) {
        $('#ship_customer').val(h.item.gust_name);
    }})
};
$.widget("custom.catcomplete22", $.ui.autocomplete, {_renderMenu: function (g, h) {
    var i = this, j = "";
    $.each(h, function (k, l) {
        i._renderItem(g, l)
    })
}});
bindAutoComplete22();

$("#ship_input_start").datepicker();
$("#ship_input_end").datepicker();

$("#ship_deliver_start").datepicker();
$("#ship_deliver_end").datepicker();

$("#ship_back_start").datepicker();
$("#ship_back_end").datepicker();

$(".btn").button();