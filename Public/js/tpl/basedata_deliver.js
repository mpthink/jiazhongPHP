function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteDeliver/pddeliver_id/" + g
    }
};
$("#jump").change(function () {
    var g = "";
    switch ($(this).val()) {
        case"0":
            g = "./index.php?s=/BaseData/cate";
            break;
        case"1":
            g = "./index.php?s=/BaseData/index";
            break;
        case"2":
            g = "./index.php?s=/BaseData/store";
            break;
        case"3":
            g = "./index.php?s=/BaseData/guest";
            break;
        case"4":
            g = "./index.php?s=/BaseData/quality";
            break;
        case"5":
            g = "./index.php?s=/BaseData/carry";
            break;
		case"6":
            g = "./index.php?s=/BaseData/deliver";
            break
    }
    ;
    window.location.href = g
});
function toAddDeliver() {
    $("#dialog").dialog({height: 400, width: 650, title: '收货人添加', modal: true, buttons: {"保存": function () {
        var g = $("#pddeliver_name").val();
		var h = $("#pddeliver_phone").val();
		var i = $("#pddeliver_address").val();
		var k = $("#pddeliver_note").val();
        action_url = "./index.php?s=/BaseData/doAddDeliver";
        if (g != "")action_url += "/pddeliver_name/" + g;
		if (h != "")action_url += "/pddeliver_phone/" + h;
		if (i != "")action_url += "/pddeliver_address/" + i;
		if (k != "")action_url += "/pddeliver_note/" + k;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
function toEditDeliver(id) {
    $("#dialog").dialog({height: 400, width: 650, title: '收货人编辑', modal: true, open: function () {
        $.getJSON("./index.php?s=/BaseData/getProdDeliverById/pddeliver_id/" + id, function (data) {
            $('#pddeliver_name').val(data.pddeliver_name);
			$('#pddeliver_phone').val(data.pddeliver_phone);
			$('#pddeliver_address').val(data.pddeliver_address);
			$('#pddeliver_note').val(data.pddeliver_note);
        })
    }, buttons: {"保存": function () {
		var g = $("#pddeliver_name").val();
		var h = $("#pddeliver_phone").val();
		var i = $("#pddeliver_address").val();
		var k = $("#pddeliver_note").val();
        action_url = "./index.php?s=/BaseData/doEditDeliver/pddeliver_id/" + id;
        if (g != "")action_url += "/pddeliver_name/" + g;
		if (h != "")action_url += "/pddeliver_phone/" + h;
		if (i != "")action_url += "/pddeliver_address/" + i;
		if (k != "")action_url += "/pddeliver_note/" + k;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
$(".btn").button();