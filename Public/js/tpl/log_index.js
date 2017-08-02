function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/Log/delete/user_id/" + g
    }
};
function goSearch() {
    window.location.href = "./index.php?s=/Log/index/searchBy/" + $("#searchBy").val() + "/keyword/" + $("#keyword").val()
};
$("#btnClearLog").click(function () {
    if (confirm("确认清空吗？清空不可恢复")) {
        window.location.href = "./index.php?s=/Log/clearLog"
    }
});
function toAdd() {
    $.FrameDialog.create({url: "./index.php?s=/Log/toAdd", title: '添加用户', height: '400', width: '600'}).bind('dialogclose', function (g, h) {
        if ($.FrameDialog._results == "OK") {
            var i = $("iframe").contents();
            var j = i.find("input[name='user_name']").val();
            var k = i.find("input[name='user_password']").val();
            var l = i.find("input[name='user_password2']").val();
            var m = i.find("select[name='user_type']").val();
            if (k != l) {
                alert("密码不一致,请重新填写");
                toAdd();
                return
            }
            ;
            action_url = "./index.php?s=/Log/doAdd";
            if (j != "")action_url += "/user_name/" + j;
            if (k != "")action_url += "/user_password/" + k;
            if (m != "")action_url += "/user_type/" + m;
            alert(action_url);
            window.location.href = action_url
        }
    })
};
function toEdit(g) {
    $.FrameDialog.create({url: "./index.php?s=/Log/toEdit/user_id/" + g, title: '编辑用户', height: '400', width: '600'}).bind('dialogclose', function (h, i) {
        if ($.FrameDialog._results == "OK") {
            var j = $("iframe").contents();
            var k = j.find("input[name='user_name']").val();
            var l = j.find("input[name='user_password']").val();
            var m = j.find("input[name='user_password2']").val();
            var n = j.find("select[name='user_type']").val();
            if (l != m) {
                alert("密码不一致,请重新填写");
                toAdd();
                return
            }
            ;
            action_url = "./index.php?s=/Log/doEdit/user_id/" + g;
            if (k != "")action_url += "/user_name/" + k;
            if (l != "")action_url += "/user_password/" + l;
            if (n != "")action_url += "/user_type/" + n;
            window.location.href = action_url
        }
    })
};
$(".btn").button();