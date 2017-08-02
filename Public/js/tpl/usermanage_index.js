function del(g) {
    if (confirm("确认删除吗？")) {
        window.location.href = "./index.php?s=/UserManage/delete/user_id/" + g
    }
};
function toAdd() {
    $("#dialog").dialog({height: 400, width: 650, modal: true, title: '用户添加', buttons: {"保存": function () {
        var g = $("#user_name").val();
        var h = $("#user_realname").val();
        var i = $("#user_password").val();
        var j = $("#user_password2").val();
        var k = $("#user_type").val();
        if (i != j) {
            alert("密码不一致,请重新填写");
            toAdd();
            return
        }
        ;
        action_url = "./index.php?s=/UserManage/doAdd";
        if (g != "")action_url += "/user_name/" + g;
        if (h != "")action_url += "/user_realname/" + h;
        if (i != "")action_url += "/user_password/" + i;
        if (k != "")action_url += "/user_type/" + k;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}, open: function () {
        $('#user_name').val('');
        $('#user_realname').val('');
        $('#user_type').val('')
    }})
};
function toEdit(g) {
    $("#dialog").dialog({height: 400, width: 650, modal: true, title: '用户编辑', buttons: {"保存": function () {
        var h = $("#user_name").val();
        var i = $("#user_realname").val();
        var j = $("#user_password").val();
        var k = $("#user_password2").val();
        var l = $("#user_type").val();
        if (j != k) {
            alert("密码不一致,请重新填写");
            toEdit(g);
            return false
        }
        ;
        action_url = "./index.php?s=/UserManage/doEdit/user_id/" + g;
        if (h != "")action_url += "/user_name/" + h;
        if (i != "")action_url += "/user_realname/" + i;
        if (j != "")action_url += "/user_password/" + j;
        if (l != "")action_url += "/user_type/" + l;
        window.location.href = action_url
    }, '取消': function () {
        $(this).dialog("close")
    }}, open: function () {
        $.getJSON('./index.php?s=/UserManage/view/user_id/' + g, function (h) {
            $('#user_id').val(h.user_id);
            $('#user_name').val(h.user_name);
            $('#user_realname').val(h.user_realname);
            $('#user_type').val(h.user_type)
        })
    }})
};
$(".btn").button();