function loginOut() {
    if (confirm("确认退出吗？")) {
        window.parent.location.href = './index.php?s=/Index/loginOut'
    }
}