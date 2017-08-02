function fleshVerify(g) {
    var h = new Date().getTime();
    if (g) {
        $('#verifyImg').attr("src", './index.php?s=/Index/verify/adv/1/' + h)
    } else {
        $('#verifyImg').attr("src", './index.php?s=/Index/verify/' + h)
    }
};
function tip(g) {
    $('#tip').fadeIn(500);
    $('#tip').html("<font style='color:red;margin-bottom:20px;font-size: 20'>" + g + "</font>")
};
function doSubmit() {
    $.get('./index.php?s=/Index/doLogin/user_name/' + $('#user_name').val() + '/user_password/' + $('#user_password').val() + '/code/' + $('#code').val(), function (g) {
        switch (g) {
            case'1':
                tip('不存在此用户');
                break;
            case'2':
                tip('密码不正确');
                break;
            case'3':
                tip('验证码不正确');
                break;
            case'4':
                window.location.href = './index.php?s=/Index/index';
                break
        }
    })
};
$("#btnSubmit").click(function () {
    doSubmit()
});
$(document).keydown(function (g) {
    var h = window.event ? g.keyCode : g.which;
    if (h == 13) {
        doSubmit()
    }
});
$(".btn").button();