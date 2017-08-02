$("#osm_date_start").datepicker({changeYear: true});
$("#osm_date_end").datepicker({changeYear: true});
$("#osm_danju_start").datepicker({changeYear: true});
$("#osm_danju_end").datepicker({changeYear: true});
$("#fastSearch").click(function () {
    window.location.href = "./index.php?s=/OutstoreQuery/index/searchBy/" + $("#searchBy").val() + "/keyword/" + $("#keyword").val()
});
$("#btnAdd").click(function () {
    window.location.href = "./index.php?s=/OutstoreBook/index"
});
function del(g) {
    if (confirm("确认删除吗？删除后数据将返回库存")) {
        window.location.href = "./index.php?s=/OutstoreQuery/delete/osm_id/" + g
    }
};

function approve(g) {
    if (confirm("确认勾单吗？")) {
        window.location.href = "./index.php?s=/OutstoreQuery/approve/id/" + g
    }
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
function toSearch() {
    $("#dialog").dialog({height: 400, width: 650, modal: true, buttons: {"确认": function () {
        var g = $("#dialog").contents();
        var h = g.find("input[name='osm_danju_no']").val();
        var i = g.find("input[name='osm_buyerunit']").val();
        var j = g.find("input[name='osm_operator']").val();
        var k = g.find("input[name='oss_total_start']").val();
        var l = g.find("input[name='oss_total_end']").val();
        var m = g.find("input[name='oss_store']").val();
        var n = g.find("input[name='osm_writer']").val();
        var o = g.find("input[name='osm_date_start']").val();
        var p = g.find("input[name='osm_date_end']").val();
        var q = g.find("input[name='oss_prodname']").val();
        var r = g.find("select[name='osm_status']").val();
		var s = g.find("input[name='osm_danju_start']").val();
		var t = g.find("input[name='osm_danju_end']").val();
        action_url = "./index.php?s=/OutstoreQuery/index";
        if (h != "")action_url += "/osm_danju_no/" + h;
        if (i != '请输入关键字或空格')action_url += "/osm_buyerunit/" + i;
        if (j != "")action_url += "/osm_operator/" + j;
        if (k != "")action_url += "/oss_total_start/" + k;
        if (l != "")action_url += "/oss_total_end/" + l;
        if (m != "")action_url += "/oss_store/" + m;
        if (n != "")action_url += "/osm_writer/" + n;
        if (o != "")action_url += "/osm_date_start/" + o;
        if (p != "")action_url += "/osm_date_end/" + p;
        if (r != "")action_url += "/osm_status/" + r;
		
		if (s != "")action_url += "/osm_danju_start/" + s;
		if (t != "")action_url += "/osm_danju_end/" + t;
		
        if (q != "请输入关键字或空格")action_url += "/oss_prodname/" + encodeURIComponent(q);
        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
function view(g) {
    $.FrameDialog.create({url: "./index.php?s=/OutstoreQuery/view/osm_id/" + g, title: '查看', height: '400', width: '600'}).bind('dialogclose', function (h, i) {
        if ($.FrameDialog._results == "OK") {
        } else {
        }
    })
};
function toEdit(g) {
    $.FrameDialog.create({url: "./index.php?s=/OutstoreQuery/toEdit/osm_id/" + g, title: '编辑', height: '400', width: '600'}).bind('dialogclose', function (h, i) {
        if ($.FrameDialog._results == "OK") {
        } else {
        }
    })
};
function bindAutoComplete() {
    var buyer = $("#osm_buyerunit").val();
    $("#oss_prodname").catcomplete({source: './index.php?s=/InstoreBook/getProduct/buyer/'+buyer, minLength: 1, delay: 0, select: function (g, h) {
        $('#oss_prodname').val(h.item.prod_name)
    }})
};
bindAutoComplete();
$(".btn").button();

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