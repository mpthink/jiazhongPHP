function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteDomain/domain_id/" + g
    }
};

$("#jump").change(function () {
    var g = "";
    switch ($(this).val()) {
        case"3":
            g = "./index.php?s=/BaseData/guest";
            break;
        case"5":
            g = "./index.php?s=/BaseData/domain";
            break;
		case"6":
            g = "./index.php?s=/BaseData/driver";
            break;
    }
    ;
    window.location.href = g
});

function toAddDomain() {
    $("#dialog").dialog({height: 400, width: 650, title: '收货区域添加', modal: true, buttons: {"保存": function () {
        var g = $("#domain_name").val();
		var h = $("#domain_price").val();
        action_url = "./index.php?s=/BaseData/doAddDomain";
        if (g != "")action_url += "/domain_name/" + g;
		if (h != "")action_url += "/domain_price/" + h;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
function toEditDomain(id) {
    $("#dialog").dialog({height: 400, width: 650, title: '收货区域编辑', modal: true, open: function () {
        $.getJSON("./index.php?s=/BaseData/getProdDomainById/domain_id/" + id, function (data) {
            $('#domain_name').val(data.domain_name);
			$('#domain_price').val(data.domain_price);
        })
    }, buttons: {"保存": function () {
		var g = $("#domain_name").val();
		var h = $("#domain_price").val();
        action_url = "./index.php?s=/BaseData/doEditDomain/domain_id/" + id;
        if (g != "")action_url += "/domain_name/" + g;
		if (h != "")action_url += "/domain_price/" + h;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
$(".btn").button();