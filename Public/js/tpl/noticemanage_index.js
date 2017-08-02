$("#fastSearch").click(function () {
    window.location.href = "./index.php?s=/NoticeManage/index/searchBy/" + $("#searchBy").val() + "/keyword/" + $("#keyword").val()
});
function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/NoticeManage/delete/ntc_id/" + g
    }
};
function add() {
    $("#dialog").dialog({height: 400, width: 650, title: "通知添加", modal: true, buttons: {"保存": function () {
        var g = $("#ntc_title").val();
        var h = $("#ntc_content").val();
        var i = $("#ntc_author").val();
        var j = "./index.php?s=/NoticeManage/doAdd";
        if (g != "")j += "/ntc_title/" + g;
        if (h != "")j += "/ntc_content/" + h;
        if (i != "")j += "/ntc_author/" + i;
        window.location.href = j
    }, "关闭": function () {
        $(this).dialog("close")
    }}, open: function () {
        $("#ntc_title").html('');
        $("#ntc_content").html('');
        $("#ntc_author").val(ntc_author)
    }})
};
function view(g) {
    $("#dialog").dialog({height: 400, width: 650, title: "通知查看", modal: true, buttons: {"关闭": function () {
        $(this).dialog("close")
    }}, open: function () {
        $.getJSON('./index.php?s=/NoticeManage/view/ntc_id/' + g, function (h) {
            $("#ntc_title").html(h.ntc_title);
            $("#ntc_content").html(h.ntc_content);
            $("#ntc_author").val(h.ntc_author)
        })
    }})
};
function toEdit(g) {
    $("#dialog").dialog({height: 400, width: 650, title: "通知编辑", modal: true, buttons: {"保存": function () {
        var h = g;
        var i = $("#ntc_title").val();
        var j = $("#ntc_content").val();
        var k = $("#ntc_author").val();
        var l = "./index.php?s=/NoticeManage/doEdit";
        if (h != "")l += "/ntc_id/" + h;
        if (i != "")l += "/ntc_title/" + i;
        if (j != "")l += "/ntc_content/" + j;
        if (k != "")l += "/ntc_author/" + k;
        window.location.href = l
    }, "关闭": function () {
        $(this).dialog("close")
    }}, open: function () {
        $.getJSON('./index.php?s=/NoticeManage/view/ntc_id/' + g, function (h) {
            $("#ntc_title").html(h.ntc_title);
            $("#ntc_content").html(h.ntc_content);
            $("#ntc_author").val(h.ntc_author)
        })
    }})
};
$(".btn").button();