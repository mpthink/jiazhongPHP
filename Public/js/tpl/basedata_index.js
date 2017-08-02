$("#fastSearch").click(function () {

    var g = $("#keyword").val();

    action_url = "./index.php?s=/BaseData/index/searchBy/" + $("#searchBy").val() + "/keyword/" + encodeURIComponent(g)

    window.location.href = encodeURI(action_url)
});

function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/BaseData/deleteProduct/prod_id/" + g
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
function toAddProduct() {
    $("#dialog").dialog({height: 400, width: 650, title: '产品添加', modal: true, buttons: {"保存": function () {
        var g = $("#prod_name").val();
        var h = $("#prod_price").val();
        var h1 = $("#prod_realprice").val();
        var i = $("#prod_weight").val();
        var j = $("#prod_cate").val();
        var g1 = $('#prod_code').val();
        var g2 = $('#prod_unit').val();
        var g3 = $('#prod_guest').val();
        var g4 = $('#prod_volume').val();
		var g5 = $('#prod_life').val();


        action_url = "./index.php?s=/BaseData/doAddProduct";
        if (j != "")action_url += "/prod_cate/" + j;
        if (g != "")action_url += "/prod_name/" + encodeURIComponent(g);
        if (h != "")action_url += "/prod_price/" + h;
        if (h1 != "")action_url += "/prod_realprice/" + h1;
        if (i != "")action_url += "/prod_weight/" + i;
        if (g1 != "")action_url += "/prod_code/" + g1;
        if (g2 != "")action_url += "/prod_unit/" + g2;
        if (g3 != "")action_url += "/prod_guest/" + g3;
        if (g4 != "")action_url += "/prod_volume/" + g4;
		if (g5 != "")action_url += "/prod_life/" + g5;


        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
function toEditProduct(g) {
    $("#dialog").dialog({height: 400, width: 650, title: '产品编辑', modal: true, open: function () {
        $.getJSON("./index.php?s=/BaseData/getProdById/prod_id/" + g, function (h) {
            $('#prod_cate').val(h.prod_cate);
            $('#prod_name').val(h.prod_name);
            $('#prod_price').val(h.prod_price);
            $('#prod_realprice').val(h.prod_realprice);
            $('#prod_weight').val(h.prod_weight);
            $('#prod_code').val(h.prod_code);
            $('#prod_unit').val(h.prod_unit);
            $('#prod_volume').val(h.prod_volume);
            $('#prod_guest').val(h.prod_guest);
			$('#prod_life').val(h.prod_life);

        })
    }, buttons: {"保存": function () {
        var h = $("#prod_name").val();
        var i = $("#prod_price").val();
        var i1 = $("#prod_realprice").val();
        var j = $("#prod_cate").val();
        var k = $("#prod_weight").val();
        var g1 = $('#prod_code').val();
        var g2 = $('#prod_unit').val();
        var g3 = $('#prod_guest').val();
        var g4 = $('#prod_volume').val();
		var g5 = $('#prod_life').val();

        action_url = "./index.php?s=/BaseData/doEditProduct/prod_id/" + g;
        if (h != "")action_url += "/prod_name/" + encodeURIComponent(h);
        if (j != "")action_url += "/prod_cate/" + j;
        if (i != "")action_url += "/prod_price/" + i;
        if (i1 != "")action_url += "/prod_realprice/" + i1;
        if (k != "")action_url += "/prod_weight/" + k;
        if (g1 != "")action_url += "/prod_code/" + g1;
        if (g2 != "")action_url += "/prod_unit/" + g2;
        if (g3 != "")action_url += "/prod_guest/" + g3;
        if (g4 != "")action_url += "/prod_volume/" + g4;
		if (g5 != "")action_url += "/prod_life/" + g5;

        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};

$(".btn").button();

function bindAutoComplete22() {
    $("#prod_guest").catcomplete22({source: './index.php?s=/InstoreBook/autoSelect22', minLength: 1, delay: 0, select: function (g, h) {
        $('#prod_guest').val(h.item.gust_name)
    }})
};
$.widget("custom.catcomplete22", $.ui.autocomplete, {_renderMenu: function (g, h) {
    var i = this, j = "";
    $.each(h, function (k, l) {
        i._renderItem(g, l)
    })
}});
bindAutoComplete22();