function resume(g) {
    if (confirm("确认恢复吗？确认后数据库也将恢复到该备份之前")) {
        window.location.href = "./index.php?s=/Backup/resume/back_id/" + g
    }
};
function del(g) {
    if (confirm("确认删除吗？删除后不可恢复")) {
        window.location.href = "./index.php?s=/Backup/delete/back_id/" + g
    }
};


function toRepairDataBase(){
	window.location.href = "./index.php?s=/Backup/repair";
}



function toClearStore() {
    $("#dialog").dialog({height: 400, width: 650, title: '清理出入库数据', modal: true, buttons: {"清理": function () {
        var g = $("#prod_name").val();
        var h = $("#prod_price").val();

        action_url = "./index.php?s=/BaseData/doAddProduct";
        if (j != "")action_url += "/prod_cate/" + j;
        if (g != "")action_url += "/prod_name/" + encodeURIComponent(g);


        window.location.href = encodeURI(action_url)
    }, '取消': function () {
        $(this).dialog("close")
    }}})
};


$("#date_start").datepicker();
$("#date_end").datepicker();


$(".btn").button();