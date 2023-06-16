//判断客户端设备，选择写入meta
function init_viewport() {
    if (navigator.userAgent.indexOf('Android') != -1) {
        var version = parseFloat(RegExp.$1);
        if (version > 2.3) {
            var width = window.outerWidth == 0 ? window.screen.width : window.outerWidth;
            var phoneScale = parseInt(width) / 500;
            document.write('<meta name="viewport" content="width=500, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
        } else {
            document.write('<meta name="viewport" content="width=500, target-densitydpi=device-dpi, user-scalable=0">');
        }
    } else if (navigator.userAgent.indexOf('iPhone') != -1) {
        var phoneScale = parseInt(window.screen.width) / 500;
        document.write('<meta name="viewport" content="width=500, min-height=750, initial-scale=' + phoneScale + ', maximum-scale=' + phoneScale + ', user-scalable=0" /> '); //0.75   0.82
    } else {
        document.write('<meta name="viewport" content="width=500, height=750, initial-scale=0.64" /> '); //0.75  0.82
    }
}
init_viewport();


const getQuery = (url) => {
    const str = url.substr(url.indexOf('?') + 1);
    const arr = str.split('&');
    const result = {}
    for (let i = 0; i < arr.length; i++) {
        const item = arr[i].split('=')
        result[item[0]] = item[1]
    }
    return result;
};
const _REQUEST = getQuery(decodeURI(location.href));


if (_REQUEST['name'] == '' || _REQUEST['name'] == null) { //允许标题为空
    document.title = '慢慢喜欢你';
} else {
    document.title = '我喜欢你❤' + _REQUEST['name'];
}

_REQUEST['img'] = _REQUEST['img'] == '' ? './images/1.gif' : _REQUEST['img']; 

var theme = 'pure_words';

var theme_content = {
    "pure_words_content": _REQUEST['name'] + "，遇见你是我所有美好故事的开始，所以，请别放开我的手，也别缺席我的将来，因为一辈子和你在一起才叫将来<um style='color: #F44336;'>💕</um>",
    "typed_bool": "typed_y",
    "cursor_char": "cursor_heart",
    "bg_style_pure_words": "bg_opacity",
    "bg_img": "images/3.jpg",
    "simple_page_content": "",
    "video_page_content": ""
};

var music_json = {
    "music_select": "m_online",
    "m_online_id": "7",
    "m_online_url": "images/1.mp3",
    "m_upload_name": "null",
    "m_upload_url": "null"
};

var record_json = {
    "record_bool": "r_false",
    "r_wechat_time": "null",
    "r_wechat_url": "null",
    "r_wechat_amr": "null"
};

var window_height = $(window).height();

var pure_words_content = theme_content['pure_words_content'];
var str_cursorChar;
var typed_bool;
var interval_pw_height;
var height_div_pw = $(".div_pure_words_height").height();
function init_pure_words() {
    $(".div_pure_words_height").html(pure_words_content + '22222'); //初始化复制内容，撑开文档高度            
    // 初始化设置div的bg图片 初始化设置div的bg图片
    if (typeof(theme_content['bg_style_pure_words']) != 'undefined' && theme_content['bg_style_pure_words'] == 'bg_opacity') {
        if (typeof(theme_content['bg_img']) != 'undefined' && theme_content['bg_img'] != '') {
            $(".div_pure_words_bg").css({
                "background-image": "url(" + theme_content['bg_img'] + ")"
            });
        }
    }
    //以下是打字效果的js 
    if (typeof(theme_content['cursor_char']) != 'undefined' && theme_content['cursor_char'] != '') {
        switch (theme_content['cursor_char']) { //设置打字光标的样式
        case 'cursor_heart':
            str_cursorChar = '<um style="color: #F44336;">❤</um>';
            break;
        case 'cursor_sub':
            str_cursorChar = '_';
            break;
        case 'cursor_music':
            str_cursorChar = '♫';
            break;
        case 'cursor_star':
            str_cursorChar = '★';
            break;
        case 'cursor_sun':
            str_cursorChar = '☀';
            break;
        default:
            str_cursorChar = '|';
        }
    } else { //处理全新作品，默认显示打字效果
        str_cursorChar = '❤';
    }
    //判断用户有没有选择打字效果
    if (typeof(theme_content['typed_bool']) != 'undefined' && theme_content['typed_bool'] != '') {
        typed_bool = theme_content['typed_bool'] == 'typed_y' ? true : false;
    } else {
        typed_bool = false; //默认显示打字效果
    }
    display_pure_words();
    $(".div_pure_words").fadeIn();
    interval_pw_height = setInterval(function() {
        var least_height_div_pw = $('.div_pure_words_height').height();
        if (least_height_div_pw > height_div_pw) {
            height_div_pw = least_height_div_pw;
        } else {
            clearInterval(interval_pw_height);
            $(".div_pure_words_height").height(least_height_div_pw + 100);
            if ($(".div_pure_words_height").height() < window_height) {
                $(".div_pure_words_height").height(window_height); //不能小于窗口的高度
            }
        }
    }, 100);
}

function display_pure_words() {
    if (typed_bool) {
        var typed_pure_words = new Typed('#span_pw_typed', {
            strings: [pure_words_content],
            //输入内容, 支持html标签
            typeSpeed: 120,
            //打字速度
            cursorChar: str_cursorChar,
            //替换光标的样式
            contentType: 'html',
            //值为html时，将打印的文本标签直接解析html标签
            onComplete: function(abc) {
                // console.log(abc); 
                // console.log($('#span_pw_typed').height()-$(".div_pure_words_height").height());
            },
        });
    } else {
        //如果不需要打字效果就直接显示
        $("#span_pw_typed").html(pure_words_content).fadeIn();
    }
    init_attachment();
}
var start_content = {
    chase_title: _REQUEST['name'] + "做我女朋友好不好<um style='color: #F44336;'>💕</um>",
    chase_text: "承蒙你的出现，够我喜欢好多年，我希望，以后你能用我的名字拒绝所有人<um style='color: #F44336;'>💕</um>",
    chase_benefit: ["你是我拔掉氧气罐都想吻的人", "你是我跑完8000米还想拥抱的人", "你是我自罚三杯都不肯开口的秘密", "你是我赴汤蹈火都不肯放下的执着", "你是我电量只剩1%也想回信息的人", "你是我穷极一生不想醒来的梦"],
    bg_style: "bg_custom",
    bg_img: "images/2.jpg",
    img_bool: "img_true",
    img_src: _REQUEST['img']
}; //可能为null
var start_id;
$(function() {
    //此事件为触发互动创意
    start_id = 'onlyyou'; //可能为null
    init_start(start_id);
});
function init_start(start_id) {
    switch (start_id) {
    case 'loveformat':
        $('.div_loveformat').show();
        init_loveformat();
        break;
    case 'hearttree':
        $('#div_hearttree').show();
        init_hearttree();
        break;
    case 'courage':
        $('#div_courage').show();
        init_courage();
        break;
    case 'birthdaycake':
        $('#div_dbcake').show();
        init_birthdaycake();
        break;
    case 'intersect':
        $('#div_intersect').show();
        init_intersect();
        break;
    case 'onlyyou':
        $('#div_onlyyou').show();
        init_onlyyou();
        break;
    default:
        init_theme();
    }
}

//开始动画主体部分
function init_theme() {
    $('#div_start_bg').fadeOut();
    init_pure_words();
}
var attachment = 'null'; //可能为null
var attached_content = {
    "bool_save": false
}; //可能为null

function init_attachment() { //开始attachment
    switch (attachment) {
    case 'timer':
        init_at_timer();
        break;
    default:
        return;
    }
}