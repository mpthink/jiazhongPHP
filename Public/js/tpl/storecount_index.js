
function toSearch() {
    $("#dialog").dialog({height: 400, width: 650, modal: true, buttons: {"确认": function () {
        var g = $("#dialog").contents();
        var i = g.find("input[name='ism_sellerunit']").val();
        var m = g.find("select[name='iss_quality']").val();
        var k = g.find("input[name='iss_store']").val();
        var o = g.find("input[name='ism_date_start']").val();
        var p = g.find("input[name='ism_date_end']").val();
        var q = g.find("input[name='iss_prodname']").val();
        var r = g.find("input[name='ism_status_time']").val();
        action_url = "./index.php?s=/StoreCount/search";
        if (i != '请输入关键字或空格')action_url += "/ism_sellerunit/" + i;
        if (m != "")action_url += "/iss_quality/" + m;
        if (k != "")action_url += "/iss_store/" + k;
        if (o != "")action_url += "/ism_date_start/" + o;
        if (p != "")action_url += "/ism_date_end/" + p;
        if (r != "")action_url += "/ism_status_time/" + r;
        if (q != '请输入关键字或空格')action_url += "/iss_prodname/" + encodeURIComponent(q);
        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};
$("#ism_date_start").datepicker();
$("#ism_date_end").datepicker();
$("#ism_status_time").datepicker();
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
function bindAutoComplete() {
    $("#iss_prodname").catcomplete({source: './index.php?s=/InstoreBook/getProduct', minLength: 1, delay: 0, select: function (g, h) {
        $('#iss_prodname').val(h.item.prod_name)
    }})
};
bindAutoComplete();
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

function bindQuality() {
    $.getJSON('./index.php?s=/InstoreBook/getQuality', function (h) {
        $.each(h, function (i, j) {
            $('#iss_quality').append("<option value='" + j.pdqu_name + "'>" + j.pdqu_name + "</option>")
        })
    })
};
bindQuality();

function toMoveStore(a1,a2,a3,a4,a5,a6,a7,a8,a9,a10,a11,a12,a13){
	var prod_id = a1;
	var prod_name = a2;
	var pdca_id = a3;
	var pdca_name = a4;
	var prod_quality = a5;
	var prod_unit = a6;
	var prod_allcount = a7;
	var source_store_id = a8;
	var store_name = a9;
	var store_kuwei_name = a10;
	var sellerunit = a11;
	var prod_code = a12;
	var iss_make_date = a13;
	
	$("#movedialog").dialog({height: 400, width: 650, title: '产品移库', modal: true, open: function () {
		$('#move_sellerunit').val(sellerunit);
		$('#move_prod_name').val(prod_name);
		$('#move_prod_id').val(prod_id);
		$('#move_pcda_name').val(pdca_name);
		$('#move_pcda_id').val(pdca_id);
		$('#move_iss_quality').val(prod_quality);
		$('#move_allcount').val(prod_allcount);
		if(store_kuwei_name == 'invalid'){
			$('#move_source_store').val(store_name);
		}else{
			$('#move_source_store').val(store_name+'/'+store_kuwei_name);
		}
		$('#move_prod_code').val(prod_code);
		if(iss_make_date == 'invalid'){
			$('#move_iss_make_date').val('');
		}else{
			$('#move_iss_make_date').val(iss_make_date);
		}

		$.get("./index.php?s=/InstoreQuery/geStoreBigClass", function(data) {   
		  $("#move_store_big").html(data);   
		});

		$.get("./index.php?s=/InstoreQuery/geStoreSmallClass/bigclass/", function(data) {   
		  $("#move_store_small").html(data);   
		});
	  
		$("#move_store_big").change(function() {   
		  var bigclass = $(this).val();   
		  $.get('./index.php?s=/InstoreQuery/geStoreSmallClass/bigclass/'+bigclass, function(data) {   
			$("#move_store_small").html(data);   
		  });   
		});
		
    }, buttons: {"移库": function () {
        var temp_store_big = $("#move_store_big").val();
        var temp_store_small = $("#move_store_small").val();
		var target_store_id;
		if(temp_store_small != 0){
			target_store_id = temp_store_small;
		}else{
			target_store_id = temp_store_big;
		}
		
		action_url = "./index.php?s=/StoreCount/moveStore";
		action_url += "/prod_id/"+prod_id;
		action_url += "/prod_name/"+prod_name;
		action_url += "/pdca_id/"+pdca_id;
		action_url += "/prod_quality/"+prod_quality;
		action_url += "/prod_unit/"+prod_unit;
		action_url += "/prod_allcount/"+prod_allcount;
		action_url += "/source_store_id/"+source_store_id;
		action_url += "/target_store_id/"+target_store_id;
		action_url += "/sellerunit/"+sellerunit;
		action_url += "/iss_make_date/"+iss_make_date;

        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
	
}

