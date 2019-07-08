/**
 * @name      ./formTab.js
 * @author    unasm < 1264310280@qq.com >
 * @since     2013-11-15 19:25:22
 */
/**
 * @param contst QESTNUM question_num 总共有多少个问题
 */
var QESTNUM = 5;
$(document).ready(function () {
    var sum = Array();
    var _table = document.getElementById("table");
    $.ajax({
        url: 'score.xml',dataType: 'xml',
        success: function (data, textStatus, jqXHR) {
            var boys = data.getElementsByTagName("boy");
            var len = boys.length;
            for (var i = 0 ; i < len; i ++) {
                sum[i] = 0;
                var tBoy = boys[i];
                for (var j = 0, lj = tBoy.childNodes.length; j < lj; j ++) {
                    if(tBoy.childNodes[j].tagName == "score"){
                        sum[i] += $(tBoy.childNodes[j]).text() - 0;
                    }
                }
            }
            var tabStr = "";
            for (var i = 0; i < len ; i ++) {
                var node = getMax(sum);
                tabStr += formTr(boys[node] , sum[node]);
                sum[node] = 0;
            }
            $(_table).append(tabStr)
            showTr();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus)
        }
    });
    /**
     * 一个小效果,一个一个的显示
     * table-row;
     */
    function showTr() {
        var trs = $(_table).find("tr");
        var trsLen = trs.length,idx = 0;
        console.log(trsLen);
        var flag = setInterval(function () {
            if(idx === trsLen)clearInterval(flag);
            idx++;
            $(trs[idx]).css("opacity","0").css("display","table-row").animate({
                opacity:"1",
                "margin-top":0
            },400)
        },150)
    }
    function getMax() {
        var node = 0,max = sum[0];
        for (var i = 1, l = sum.length; i < l; i ++) {
            if(sum[i] > max){
                max = sum[i];
                node = i;
            }
        }
        return node;
    }
    /**
     * 构成table 的tr
     * @param node boy xml的一个boy节点
     */
    function formTr(boy ,total ) {
        var pointer = 0 , boyLen = boy.childNodes.length;
        var res = "<tr style = 'display:none'><td>" + $(boy).attr("name") +"</td><td>" + total + "</td>";
        var quesId = 1;
        while( (pointer < boyLen) ){
            if(boy.childNodes[pointer].tagName == "score"){
                var score = boy.childNodes[pointer];
                var nextQuestionId = parseInt( $(score).attr("name") );
                for(;quesId <= QESTNUM && quesId < parseInt($(score).attr("name") );quesId++){
                    //留下一个添加通过的情况
                    res += "<td></td>";
                }
                res += "<td class = 'passed'>" + $( score ).text() + "</td>";
                quesId++;
            }
            pointer++;
        }
        res += "</tr>";
        return res;
    }
})
