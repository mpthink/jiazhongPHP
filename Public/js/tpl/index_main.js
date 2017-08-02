function noticeView(g) {
    $("#dialog").dialog({height: 400, width: 650, title: '通知查看', modal: true, buttons: {"关闭": function () {
        $(this).dialog("close")
    }}, open: function () {
        $.getJSON('./index.php?s=/Index/noticeView/ntc_id/' + g, function (h) {
            $("#ntc_title").html(h.ntc_title);
            $("#ntc_content").html(h.ntc_content);
            $("#ntc_author").val(h.ntc_author)
        })
    }})
};
function checkUpdate() {
    $.ajax({url: 'http://www.9isoft.net/sm_info.php?callback=?', async: false, error: function () {
        $('#newStr').html("<a href='#' onClick='checkUpdate()'>目前无法更新</a>")
    }, success: function (g, h) {
        $('#newStr').html("<a href='#' onClick='checkUpdate()'>" + "最新版本:" + g.version + "</a>")
    }})
};
function formatFloat(g, h) {
    return Math.round(g * Math.pow(10, h)) / Math.pow(10, h)
};
$(document).ready(function () {
    var g = new Highcharts.Chart({chart: {renderTo: 'container1', type: 'line', marginRight: 130, marginBottom: 25, height: 150}, title: {text: ' ', x: -20}, xAxis: {categories: line_cate}, yAxis: {title: {text: '数量(件)'}, plotLines: [
        {value: 0, width: 1, color: '#808080'}
    ]}, plotOptions: {line: {dataLabels: {enabled: true}, enableMouseTracking: false}}, tooltip: {formatter: function () {
        return'<b>' + this.series.name + '</b><br/>' + this.x + ' : ' + this.y + '个'
    }}, legend: {layout: 'vertical', align: 'right', verticalAlign: 'top', x: -10, y: 100, borderWidth: 0}, series: [
        {name: '入仓', data: line_count_in},
        {name: '出仓', data: line_count_out}
    ]});
    var h = new Highcharts.Chart({chart: {renderTo: 'container2', type: 'line', marginRight: 130, marginBottom: 25, height: 150}, title: {text: ' ', x: -20}, xAxis: {categories: line_cate}, yAxis: {title: {text: '金额(元)'}, plotLines: [
        {value: 0, width: 1, color: '#808080'}
    ]}, plotOptions: {line: {dataLabels: {enabled: true}, enableMouseTracking: false}}, tooltip: {formatter: function () {
        return'<b>' + this.series.name + '</b><br/>' + this.x + ' : ' + this.y + '个'
    }}, legend: {layout: 'vertical', align: 'right', verticalAlign: 'top', x: -10, y: 100, borderWidth: 0}, series: [
        {name: '入仓', data: line_total_in},
        {name: '出仓', data: line_total_out}
    ]});
    chart3 = new Highcharts.Chart({chart: {renderTo: 'container3', plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, height: 200}, title: {text: '出入仓总金额比率图', style: {fontSize: '12px'}}, tooltip: {formatter: function () {
        return'<b>' + this.point.name + '</b>: ' + formatFloat(this.percentage, 0) + ' %'
    }}, plotOptions: {pie: {allowPointSelect: true, cursor: 'pointer', dataLabels: {enabled: true, color: '#000000', distance: 18, softConnector: true, connectorColor: '#000000', formatter: function () {
        return'<b>' + this.point.name + '</b>: ' + formatFloat(this.percentage, 0) + ' %'
    }}, showInLegend: false}}, series: [
        {type: 'pie', name: 'Browser share', data: [
            ['入仓总金额', pie_in_total],
            ['出仓总金额', pie_out_total]
        ]}
    ]});
    chart4 = new Highcharts.Chart({chart: {renderTo: 'container4', plotBackgroundColor: null, plotBorderWidth: null, plotShadow: false, height: 200}, title: {text: '出入仓总数量比率图', style: {fontSize: '12px'}}, tooltip: {formatter: function () {
        return'<b>' + this.point.name + '</b>: ' + formatFloat(this.percentage, 0) + ' %'
    }}, plotOptions: {pie: {allowPointSelect: true, cursor: 'pointer', dataLabels: {enabled: true, color: '#000000', distance: 18, connectorColor: '#000000', formatter: function () {
        return'<b>' + this.point.name + '</b>: ' + formatFloat(this.percentage, 0) + ' %'
    }}, showInLegend: false}}, series: [
        {type: 'pie', name: 'Browser share', data: [
            ['入仓总数量', pie_in_count],
            ['出仓总数量', pie_out_count]
        ]}
    ]})
});