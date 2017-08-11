function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteDriver/driver_id/" + g
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

function toAddDriver() {
    $("#dialog").dialog({height: 400, width: 650, title: '司机添加', modal: true, buttons: {"保存": function () {
        var g = $("#driver_name").val();
		var h = $("#driver_car_no").val();
		var k = $("#driver_note").val();
        action_url = "./index.php?s=/BaseData/doAddDriver";
        if (g != "")action_url += "/driver_name/" + g;
		if (h != "")action_url += "/driver_car_no/" + h;
		if (k != "")action_url += "/driver_note/" + k;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
function toEditDriver(id) {
    $("#dialog").dialog({height: 400, width: 650, title: '司机编辑', modal: true, open: function () {
        $.getJSON("./index.php?s=/BaseData/getDriverById/driver_id/" + id, function (data) {
            $('#driver_name').val(data.driver_name);
			$('#driver_car_no').val(data.driver_car_no);
			$('#driver_note').val(data.driver_note);
        })
    }, buttons: {"保存": function () {
		var g = $("#driver_name").val();
		var h = $("#driver_car_no").val();
		var k = $("#driver_note").val();
        action_url = "./index.php?s=/BaseData/doEditDriver/driver_id/" + id;
        if (g != "")action_url += "/driver_name/" + g;
		if (h != "")action_url += "/driver_car_no/" + h;
		if (k != "")action_url += "/driver_note/" + k;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
$(".btn").button();