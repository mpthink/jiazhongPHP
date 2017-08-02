function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteQuality/pdqu_id/" + g
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
function toAddQuality() {
    $("#dialog").dialog({height: 400, width: 650, title: '质量类别添加', modal: true, buttons: {"保存": function () {
        var g = $("#pdqu_name").val();
        action_url = "./index.php?s=/BaseData/doAddQuality";
        if (g != "")action_url += "/pdqu_name/" + g;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
function toEditQuality(g) {
    $("#dialog").dialog({height: 400, width: 650, title: '质量类别编辑', modal: true, open: function () {
        $.getJSON("./index.php?s=/BaseData/getProdQualityById/pdqu_id/" + g, function (h) {
            $('#pdqu_name').val(h.pdqu_name)
        })
    }, buttons: {"保存": function () {
        var h = $('#pdqu_name').val();
        action_url = "./index.php?s=/BaseData/doEditQuality/pdqu_id/" + g;
        if (h != "")action_url += "/pdqu_name/" + h;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
$(".btn").button();