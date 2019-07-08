/**
 *  页面的首部js控制
 *  目前主要是控制下拉表单的显示隐藏
 * @name      head.js
 * @author    unasm < 1264310280@qq.com >
 * @since     2013-11-13 21:23:56
*/
/**
 * 控制菜单栏的显示隐藏
 * @param dom       _ul     当前显示隐藏的节点
 * @param boolen    _flag   标志位，500ms内禁止任何显示隐藏
 * @param boolen   _inside  标志位，检查光标当前的位置，为关闭做准备
 */
function menuControl() {
    var _ul = "",_flag = 0,_inside = 0;
    $(".nav").delegate(".menu","mouseenter",function () {
        if(_flag)return false;//在500ms内不再显示和隐藏
        _flag = 1;
        var tmpul = $(this).find("ul");
        tmpul = tmpul[0];//进行显示隐藏的节点
        if(tmpul != _ul){
            $(_ul).fadeOut();//进入另一个ul，之前的隐藏,以免出现bug
        }
        _inside = 1;
        _ul = tmpul;
        //检查是不是在一个
        var height = $(_ul).height();
        $(_ul).css("opacity",0).css("display","").css("height",'0px').animate({
            opacity:"1",
            height:height
        },500)
        setTimeout(function() {
            _flag = 0;
        }, 520);
    }).delegate(".menu","mouseleave",function(){
        _inside = 0;//进行缓冲，一面因为微动导致隐藏，500ms之后还是离开，则隐藏
        setTimeout(function() {
            if(_inside === 0)
                $(_ul).fadeOut();
        }, 500);
    });
}
$(document).ready(function () {
    $.ajax({
        url: 'head.html',
        dataType: 'html',
        success: function (data, textStatus, jqXHR) {
            document.getElementById("header").innerHTML = data;
            menuControl();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus);
        }
    });
})
