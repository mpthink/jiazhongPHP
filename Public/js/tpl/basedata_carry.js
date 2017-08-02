function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteCarry/pdcarry_id/" + g
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
function toAddCarry() {
    $("#dialog").dialog({height: 400, width: 650, title: '搬运组添加', modal: true, buttons: {"保存": function () {
        var g = $("#pdcarry_name").val();
        action_url = "./index.php?s=/BaseData/doAddCarry";
        if (g != "")action_url += "/pdcarry_name/" + g;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
function toEditCarry(g) {
    $("#dialog").dialog({height: 400, width: 650, title: '搬运组编辑', modal: true, open: function () {
        $.getJSON("./index.php?s=/BaseData/getProdCarryById/pdcarry_id/" + g, function (h) {
            $('#pdcarry_name').val(h.pdcarry_name)
        })
    }, buttons: {"保存": function () {
        var h = $('#pdcarry_name').val();
        action_url = "./index.php?s=/BaseData/doEditCarry/pdcarry_id/" + g;
        if (h != "")action_url += "/pdcarry_name/" + h;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
$(".btn").button();