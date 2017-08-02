var d = 0;
var e = 1;
function getRow(g, h) {
    var i = "<tr id='row_" + g + "'>" +
        "<td align='center'>" + h + "</td>" +
        "<td align='center'>" +
        "<input name='iss_prodname[]' type='text' id='iss_prodname_" + g + "' size='30' value='请输入关键字或空格' style='color:#CCC' onfocus='clearTip(this)'  onblur='fillTip(this)'/></td>" +
		
		"<td align='center'><input name='iss_code[]' type='text' id='iss_code_" + g + "' size='25' disabled='disabled'/></td>" +
		
        "<td align='center'><input type='text' id='iss_cate_name_" + g + "' size='8' disabled='disabled'/></td>" +

        "<td align='center'><select name='iss_quality[]' id='iss_quality_" + g + "'>"+
        "</select>" +"</td>" +

        "<td align='center'><input name='iss_unit[]' type='text' id='iss_unit_" + g + "' size='8' /></td>" +
		
		"<td align='center'><input name='iss_life[]' type='text' id='iss_life_" + g + "' size='8' disabled='disabled'/></td>" +
		
		"<td align='center'><input name='iss_make_date[]' type='text' id='iss_make_date_" + g + "' size='12'/></td>" +
		
        "<td align='center'><input name='iss_plancount[]' type='text' id='iss_plancount_" + g + "' size='8' /></td>" +
        "<td align='center'><input name='iss_count[]' type='text' id='iss_count_" + g + "' size='8' onblur='compute(" + g + ")'/></td>" +

        
        "<td align='center'>" + "<select name='iss_store[]' id='iss_store_" + g + "'>" + "<option value=''>--请选择--</option>" + "</select>" + "</td>" +

        "<td align='center'><a href='#' id='linkDelete_" + g + "' name='linkDelete' onclick='deleteRow(" + g + ")'>删除</a></td>" +
        "<input name='row_count[]' type='hidden' value='" + g + "'>" +
        "<input id='iss_cate_id_" + g + "' name='iss_cate[]' type='hidden'>" +
        "<input id='iss_prod_" + g + "' name='iss_prod[]' type='hidden'>" + "</tr>";
    return i
};
$("#btnAdd").click(function () {
    var g = getRow(d, e);
    $("#table").append(g);
    bindAutoComplete(d);
    bindStore(d);
    bindQuality(d);

    d++;
    e++
});
function bindStore(g) {
    $.getJSON('./index.php?s=/InstoreBook/getStore', function (h) {
        $.each(h, function (i, j) {
            $('#iss_store_' + g).append("<option value='" + j.sto_id + "'>" + j.sto_name + "</option>")
        })
    })
};

function bindQuality(g) {
    $.getJSON('./index.php?s=/InstoreBook/getQuality', function (h) {
        $.each(h, function (i, j) {
            $('#iss_quality_' + g).append("<option value='" + j.pdqu_name + "'>" + j.pdqu_name + "</option>")
        })
    })
};

function deleteRow(g) {
    $("#row_" + g).remove();
    e--
};
function checkName(g) {
    $.get("./index.php?s=/InstoreBook/checkName/name/" + g, function (h) {
        if (h == "no_exist") {
            alert("不存在此产品，请修改！")
        }
    })
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
function compute(g) {
    $("#iss_total_" + g).val($("#iss_price_" + g).val() * $("#iss_count_" + g).val())
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
function bindAutoComplete(g) {
    var seller = $("#ism_sellerunit").val();
    $("#iss_prodname_" + g).catcomplete({source: './index.php?s=/InstoreBook/getProduct/seller/'+seller, minLength: 1, delay: 0, select: function (h, i) {
        $("#iss_prod_" + g).val(i.item.prod_id);
        $("#iss_prodname_" + g).val(i.item.prod_name);
        $("#iss_unit_" + g).val(i.item.prod_unit);
		$("#iss_life_" + g).val(i.item.prod_life);
		$("#iss_code_" + g).val(i.item.prod_code);
		$("#iss_make_date_" + g).datepicker();
        $("#iss_cate_id_" + g).val(i.item.prod_cate);
        $("#iss_cate_name_" + g).val(i.item.pdca_name);
        $("#iss_plancount_" + g).focus()
    }})
};
$(".btn").button();

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
$("#ism_danju_date").datepicker();
