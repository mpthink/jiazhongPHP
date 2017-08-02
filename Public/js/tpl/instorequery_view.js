$(".btn").button();



function review(g) {
        window.location.href = "./index.php?s=/InstoreQuery/doReview/ism_id/" + g
};

function sumbitIN(g) {
    window.location.href = "./index.php?s=/InstoreQuery/doSubmitIN/ism_id/" + g
};

function rollbackIN(g) {
    window.location.href = "./index.php?s=/InstoreQuery/doRollbackIN/ism_id/" + g
};

function rollbackfencang(g) {
    window.location.href = "./index.php?s=/InstoreQuery/doRollbackFengCang/ism_id/" + g
};

function editIN(g) {
    window.location.href = "./index.php?s=/InstoreQuery/toEdit/ism_id/" + g
};



//为分仓而添加的js，参考入仓登记

var d = 0;
function getRow(temp_iss_id,iss_id_newRow) {
    var i = "<tr id='row_"+ iss_id_newRow +"'>" +
        "<td align='center'><div id='iss_prodname_" + iss_id_newRow + "'/></td>" +
		
		"<td align='center'><div id='iss_code_" + iss_id_newRow + "'/></td>" +
		
        "<td align='center'><div id='iss_cate_name_" + iss_id_newRow + "'/></td>" +

        "<td align='center'><div id='iss_quality_" + iss_id_newRow + "'/></td>" +

        "<td align='center'><div id='iss_unit_" + iss_id_newRow + "'/></td>" +
		"<td align='center'><div id='iss_life_" + iss_id_newRow + "'/></td>" +
		"<td align='center'><div id='iss_make_date_" + iss_id_newRow + "'/></td>" +

        "<td align='center'><input name='iss_plancount_"+temp_iss_id+"[]' type='text' id='iss_plancount_" + iss_id_newRow + "' size='8' /></td>" +
		
        "<td align='center'><input name='iss_count_"+temp_iss_id+"[]' type='text' id='iss_count_" + iss_id_newRow + "' size='8' '/></td>" +
		
		"<td align='center'></td>" +
		
        "<td align='center'>" + 
		"<select name='iss_store_big_"+temp_iss_id+"[]' id='iss_store_big_" + iss_id_newRow + "'>" + "</select>" + 
		"<select name='iss_store_small_"+temp_iss_id+"[]' id='iss_store_small_" + iss_id_newRow + "'>" + "</select>" +
		
		"</td>" +

        "<td align='center'><a href='#' id='linkDelete_" + iss_id_newRow + "' name='linkDelete' onclick=deleteRow('"+iss_id_newRow+"')>删除</a></td>" +
		"</tr>";
    return i;
};


function getInsertRowId(current_tr_index){
	var viewtable=document.getElementById ("viewtable");
	var flag = 0;
	var next_row;
	while(flag == 0){
		next_row=viewtable.rows[current_tr_index+1];
		next_row_id = $(next_row).attr("id");
		if(next_row_id.indexOf("row_")>=0){
			flag = 0;
			current_tr_index++;
		}else{
			flag = 1;
		}
	}
	var insertRow=viewtable.rows[current_tr_index];
	return insertRow;
	
}

function fenCang(btnId) {
   tr_id=$(btnId).parent().parent().attr("id");
   tr_node=btnId.parentNode.parentNode;
   tr_index=tr_node.rowIndex;
   tr_cells=tr_node.cells;
   
   iss_prodname=tr_cells[0].innerHTML;
   iss_code=tr_cells[1].innerHTML;
   iss_cate_name=tr_cells[2].innerHTML;
   iss_quality=tr_cells[3].innerHTML;
   iss_unit=tr_cells[4].innerHTML;
   iss_life=tr_cells[5].innerHTML;
   iss_make_date=tr_cells[6].innerHTML;
   
   var insertRow=getInsertRowId(tr_index);
   
   temp_iss_id=tr_id.substring(8);
   iss_id_newRow = temp_iss_id+"_"+d;
   var newRaw = getRow(temp_iss_id,iss_id_newRow);
   $(insertRow).after(newRaw); 
	
	bindFenCangData(iss_id_newRow,iss_prodname,iss_code,iss_cate_name,iss_quality,iss_unit,iss_life,iss_make_date);
   
   d++;
};

function bindFenCangData(iss_id_newRow,iss_prodname,iss_code,iss_cate_name,iss_quality,iss_unit,iss_life,iss_make_date) {
	document.getElementById("iss_prodname_" + iss_id_newRow).innerHTML="分库："+iss_prodname;
	document.getElementById("iss_code_" + iss_id_newRow).innerHTML=iss_code;
	document.getElementById("iss_cate_name_" + iss_id_newRow).innerHTML=iss_cate_name;
	document.getElementById("iss_quality_" + iss_id_newRow).innerHTML=iss_quality;
	
	document.getElementById("iss_unit_" + iss_id_newRow).innerHTML=iss_unit;
	document.getElementById("iss_life_" + iss_id_newRow).innerHTML=iss_life;
	document.getElementById("iss_make_date_" + iss_id_newRow).innerHTML=iss_make_date;
	
	$("#iss_plancount_" + iss_id_newRow).focus();
	
	$.get("./index.php?s=/InstoreQuery/geStoreBigClass", function(data) {   
	  $("#iss_store_big_" + iss_id_newRow).html(data);   
	});

	$.get("./index.php?s=/InstoreQuery/geStoreSmallClass/bigclass/", function(data) {   
	  $("#iss_store_small_" + iss_id_newRow).html(data);   
	});
  
	$("#iss_store_big_" + iss_id_newRow).change(function() {   
	  var bigclass = $(this).val();   
	  $.get('./index.php?s=/InstoreQuery/geStoreSmallClass/bigclass/'+bigclass, function(data) {   
		$("#iss_store_small_" + iss_id_newRow).html(data);   
	  });   
	});

};

function deleteRow(g) {
    $("#row_" + g).remove();
    d--;
};


$(document).ready(function() {   
  //get bigClass   
	$.get("./index.php?s=/InstoreQuery/geStoreBigClass", function(data) {   
	  $('#bigclass').html(data);   
	});

	$.get("./index.php?s=/InstoreQuery/geStoreSmallClass/bigclass/", function(data) {   
	  $('#smallclass').html(data);   
	});
  
	$('#bigclass').change(function() {   
	  var bigclass = $(this).val();   
	  $.get('./index.php?s=/InstoreQuery/geStoreSmallClass/bigclass/'+bigclass, function(data) {   
		$('#smallclass').html(data);   
	  });   
	}); 
});
























