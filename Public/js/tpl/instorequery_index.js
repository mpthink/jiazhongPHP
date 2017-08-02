$("#fastSearch").click(function () {
    window.location.href = "./index.php?s=/InstoreQuery/index/searchBy/" + $("#searchBy").val() + "/keyword/" + $("#keyword").val()
});
$("#btnAdd").click(function () {
    window.location.href = "./index.php?s=/InstoreBook/index"
});
function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/InstoreQuery/delete/id/" + g
    }
};

function approve(g) {
    if (confirm("确认勾单吗？")) {
        window.location.href = "./index.php?s=/InstoreQuery/approve/id/" + g
    }
};

function toSearch() {
    $("#dialog").dialog({height: 400, width: 650, modal: true, buttons: {"确认": function () {
        var g = $("#dialog").contents();
        var h = g.find("input[name='ism_danju_no']").val();
        var i = g.find("input[name='ism_sellerunit']").val();
        var j = g.find("input[name='ism_operator']").val();
        var k = g.find("input[name='iss_store']").val();
        var l = g.find("input[name='iss_total_start']").val();
        var m = g.find("input[name='iss_total_end']").val();
        var n = g.find("input[name='ism_writer']").val();
        var o = g.find("input[name='ism_date_start']").val();
        var p = g.find("input[name='ism_date_end']").val();
        var q = g.find("input[name='iss_prodname']").val();
        var r = g.find("select[name='ism_status']").val();
		var s = g.find("input[name='ism_danju_start']").val();
		var t = g.find("input[name='ism_danju_end']").val();
        action_url = "./index.php?s=/InstoreQuery/index";
        if (h != "")action_url += "/ism_danju_no/" + h;
        if (i != '请输入关键字或空格')action_url += "/ism_sellerunit/" + i;
        if (j != "")action_url += "/ism_operator/" + j;
        if (k != "")action_url += "/iss_store/" + k;
        if (l != "")action_url += "/iss_total_start/" + l;
        if (m != "")action_url += "/iss_total_end/" + m;
        if (n != "")action_url += "/ism_writer/" + n;
        if (o != "")action_url += "/ism_date_start/" + o;
        if (p != "")action_url += "/ism_date_end/" + p;
		if (s != "")action_url += "/ism_danju_start/" + s;
		if (t != "")action_url += "/ism_danju_end/" + t;
		
        if (q != '请输入关键字或空格')action_url += "/iss_prodname/" + encodeURIComponent(q);
        if (r != "")action_url += "/ism_status/" + r;
        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
$("#ism_date_start").datepicker();
$("#ism_date_end").datepicker();

$("#ism_danju_start").datepicker();
$("#ism_danju_end").datepicker();

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
    var seller = $("#ism_sellerunit").val();
    $("#iss_prodname").catcomplete({source: './index.php?s=/InstoreBook/getProduct/seller/'+seller, minLength: 1, delay: 0, select: function (g, h) {
        $('#iss_prodname').val(h.item.prod_name)
    }})
};

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

bindAutoComplete();
$(".btn").button();