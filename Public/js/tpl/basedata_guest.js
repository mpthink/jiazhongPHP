function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteGuest/gust_id/" + g
    }
};

function delcate(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteGuestCate/gust_cate_id/" + g
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


function toAddGuest() {
    $("#dialog").dialog({height: 400, width: 650, title: '客户添加', modal: true, buttons: {"保存": function () {
        var g = $('#gust_name').val();
        //var h = $('#gust_comfullname').val();
        var i = $('#gust_address').val();
        var j = $('#gust_phone').val();
        var g1 = $('#gust_sn').val();
        var g2 = $('#gust_cate').val();
        var g3 = $('#way_pay').val();
        var g4 = $('#way_out').val();
        var g5 = $('#form_valid').val();


        action_url = "./index.php?s=/BaseData/doAddGuest";
        if (g != "")action_url += "/gust_name/" + g;
        //if (h != "")action_url += "/gust_comfullname/" + h;
        if (i != "")action_url += "/gust_address/" + i;
        if (j != "")action_url += "/gust_phone/" + j;

        if (g1 != "")action_url += "/gust_sn/" + g1;
        if (g2 != "")action_url += "/gust_cate/" + g2;
        if (g3 != "")action_url += "/way_pay/" + g3;
        if (g4 != "")action_url += "/way_out/" + g4;
        if (g5 != "")action_url += "/form_valid/" + g5;


        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};



function toEditGuest(g) {
    $("#dialog").dialog({height: 400, width: 650, title: '客户编辑', modal: true, open: function () {
        $.getJSON("./index.php?s=/BaseData/getGuestById/gust_id/" + g, function (h) {
            $('#gust_name').val(h.gust_name);
            //$('#gust_comfullname').val(h.gust_comfullname);
            $('#gust_phone').val(h.gust_phone);
            $('#gust_address').val(h.gust_address)

            $('#gust_sn').val(h.gust_sn);
            $('#gust_cate').val(h.gust_cate);
            $('#way_pay').val(h.way_pay);
            $('#way_out').val(h.way_out);
            $('#form_valid').val(h.form_valid)

        })
    }, buttons: {"保存": function () {
        var h = $('#gust_name').val();
        //var i = $('#gust_comfullname').val();
        var j = $('#gust_address').val();
        var k = $('#gust_phone').val();

        var g1 = $('#gust_sn').val();
        var g2 = $('#gust_cate').val();
        var g3 = $('#way_pay').val();
        var g4 = $('#way_out').val();
        var g5 = $('#form_valid').val();

        action_url = "./index.php?s=/BaseData/doEditGuest/gust_id/" + g;
        if (h != "")action_url += "/gust_name/" + h;
        //if (i != "")action_url += "/gust_comfullname/" + i;
        if (j != "")action_url += "/gust_address/" + j;
        if (k != "")action_url += "/gust_phone/" + k;


        if (g1 != "")action_url += "/gust_sn/" + g1;
        if (g2 != "")action_url += "/gust_cate/" + g2;
        if (g3 != "")action_url += "/way_pay/" + g3;
        if (g4 != "")action_url += "/way_out/" + g4;
        if (g5 != "")action_url += "/form_valid/" + g5;

        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};


function toAddGuestCate() {
    $("#dialog2").dialog({height: 400, width: 650, title: '客户分类添加', modal: true, buttons: {"保存": function () {
        var g5 = $('#gust_cate_name').val();


        action_url = "./index.php?s=/BaseData/doAddGuestCate";
        if (g5 != "")action_url += "/gust_cate_name/" + g5;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};

$(".btn").button();