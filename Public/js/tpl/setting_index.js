$('#btnSubmit').click(function () {
    if ($('#user_name').val() == '' || $('#user_realname').val() == '') {
        tip('请填写完整');
        return
    }
    ;
    if ($('#user_password').val() != $('#user_password2').val()) {
        tip('两次密码不一致');
        return
    }
    ;
    $.post('./index.php?s=/Setting/doEdit', {user_id: $('#user_id').val(), user_name: $('#user_name').val(), user_realname: $('#user_realname').val(), user_password: $('#user_password').val()}, function (g) {
        $('#user_name').val(g.user_name);
        $('#user_realname').val(g.user_realname);
        window.parent.header.location.reload();
        tip('设置已保存')
    }, 'json')
});
function tip(g) {
    $('#tip').html(g);
    $('#tip').fadeIn(500).delay(1000).fadeOut(500)
};
$(".btn").button();