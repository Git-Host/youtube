<?php
header("Content-type: text/html; charset=UTF-8");
ini_set('error_reporting', E_ALL & ~E_NOTICE);
@session_start();	//开始Sesson会话
@date_default_timezone_set('PRC');	//默认时区（中国）
if (!isset($_SESSION["local"]))
	if (isset($_COOKIE["local"]))
		$_SESSION["local"]=$_COOKIE["local"];
	else
		$_SESSION["local"]="";

if (!isset($_SESSION["lang"]))
	if (isset($_COOKIE["lang"]))
		$_SESSION["lang"]=$_COOKIE["lang"];
	else
		$_SESSION["lang"]="";

if (!isset($_SESSION["orderby"]))
	if (isset($_COOKIE["orderby"]))
		$_SESSION["orderby"]=$_COOKIE["orderby"];
	else
		$_SESSION["orderby"]="relevance";
//上面为预设值

@include_once("codedef/cons.php");
@include_once("codedef/theme.php");
define("THEME_PATH","theme/".(is_dir("theme/".CON_theme_path)?CON_theme_path:"default"));
include_once("env_var.php");
define("WEBSITE_TITLE",(defined("CON_site_title") & CON_site_title!==">site_title")?CON_site_title:"你管索引");
//从2.1.1版本开始，请使用后台来修改网站名！
define("WELCOME_YOU","欢迎访问".WEBSITE_TITLE);
define("Search","搜索");
define("Result","结果");
define("SearchPlaylist","搜索播放列表");
define("SearchKeyMode","精准标签搜索");
define("Infomation","信息");
define("Author","作者");
define("PublishTime","发布于");
define("UpdateTime","上次更新");
define("ReadAll","查看全部内容");
define("Description","描述");
define("Download","下载");
define("Statistics","统计数字");
define("ViewCount","观看次数");
define("ShareTo","分享到...");
define("Comments","评论");
define("PostComments","发表评论");
define("RelatedVideos","相关视频");
define("YouTubeExtraInfo","<b>此视频包含被授权的影音内容</b>");
define("ZoomVideoField","放大/缩小视频域");
define("Rating","评分");
define("Raters","评分人数");
define("FavoriteCount","被收藏次数");
$Special_Titles=array( 
	"recently_featured"=>"最新精选", 
	"most_recent"=>"最新上传", 
	"top_rated"=>"高分视频", 
	"most_viewed"=>"点击量之王", 
	"top_favorites"=>"收藏量之王", 
	"most_responded"=>"回复量之王"
);
$ShareTo=array( 
	"Twitter官网"=>"https://twitter.com/?status=推荐视频《%VNAME%》 %WATCHURL%",
	"Facebook官网"=>"https://www.facebook.com/sharer.php?u=%WATCHURL%&t=推荐视频《%VNAME%》",
	"Google Reader"=>"javascript:var%20b=document.body;var%20GR________bookmarklet_domain='http://www.google.com';if(b&&!document.xmlVersion){void(z=document.createElement('script'));void(z.src='http://www.google.com/reader/ui/link-bookmarklet.js');void(b.appendChild(z));}else{}",
	"Google Buzz官网"=>"https://www.google.com/buzz/post?url=%WATCHURL%",
	"开心网"=>"http://www.kaixin001.com/~repaste/repaste.php?&rurl=%WATCHURL%&rtitle=%VNAME%&rcontent=一个视频：《%VNAME%》",
	"人人网"=>"http://share.renren.com/share/buttonshare.do?link=%WATCHURL%&title=%VNAME%",
	"新浪微博"=>"http://v.t.sina.com.cn/share/share.php?title=%VNAME%&url=%WATCHURL%",
	"豆瓣"=>"http://www.douban.com/recommend/?url=%WATCHURL%&title=%VNAME%",
	"鲜果"=>"http://www.xianguo.com/service/submitfav/?link=%WATCHURL%&title=%VNAME%",
);

//结果页面
$PersonResult=array( 
	"uploads"=>"个人上传", 
	"favorites"=>"个人收藏",
);
define("ItemsOfThePlaylist","特定播放列表的视频");
define("TheNumberOfResultsIsXXX","总共有XXX个结果");
define("ThisIsPageXXXOfYYY","第XXX页，共YYY页");
define("PrevPage","上一页");
define("NextPage","下一页");

//高级搜索选项
define("AdvancedSearch","高级搜索");
define("SearchVideos","搜索视频");
define("SpecialFunctions","特殊功能");
define("PersonalVideos","个人视频");
define("ItemsOfOnePlaylist","某个播放列表的内容");
define("IDOfThePlaylist","播放列表ID");
define("OptionsForNormalSearch","用于 普通搜索 的其他选项");
define("AllCategory","全部分类");
define("MustWithSubtitle","必须带有字幕");
$Search_Mode=array(
	"search"=>"普通搜索",
	"searchlist"=>"搜索播放列表",
	"searchkey"=>"关键字符搜索",
	"searchchannel"=>"搜索频道"
);
$Search_Mode_des=array(
	"search"=>"此方法搜索出来的结果比较泛，但是你可以找到许多有趣的相关内容。",
	"searchlist"=>"播放列表为他人所整理的同类视频，你可以试试搜索一个歌手名字或一部动画连续剧。",
	"searchkey"=>"此方法与“普通搜索”不同之处在于：搜出来的东西都很符合你的意愿，但是最好输入英文词汇，因为此功能对中文的处理能力不强。",
	"searchchannel"=>"每一位用户（或作者）都拥有一个属于自己的频道。试试搜索soccer以寻找专注于足球的频道，或者Michael Jackson以寻找MJ的频道。"
);

//Item_Block的
define("_MSG1_",'长度:%l分钟 | 评分:%r | 观看次数:%c<br>作者<a href="person.php?id=%a">%a</a>将本视频归于<a href="category.php?type=%1">%k类</a>');
define("WatchIt","观看它");
define("WatchOnYouTube","来源页面");
define("WatchPlaylist","播放列表连播");
define("TheAuthor","作者专页");
define("TheCategoryXXX","更多[XXX]类的视频");
define("ReportIt","举报");
define("ShowItems","显示内容");
define("_MSG2_",'观看次数:%c | 作者<a href="person.php?id=%a">%a</a>');
define("_MSG3_",'更新于%d | <a href="person.php?id=%a">访问专页</a>');

//分类
define("Category","分类");
define("ChildCategoryOfXXX","[XXX]的子分类");
$Category=array( 
	"Film"=>"电影和动画",
		"Film/Anime"=>"动漫",
		"Film/Cartoon"=>"动画片",
		"Film/Comedy"=>"喜剧片",
		"Film/Documentary"=>"纪录片",
		"Film/Action"=>"动作片",
		"Film/Classics"=>"经典电影",
		"Film/Horror"=>"恐怖片",
		"Film/Thriller"=>"惊悚片", 
		"Film/Drama"=>"电影 - 戏剧",
	"Autos"=>"汽车和交通工具",
	"Music"=>"音乐",
		"Music/Blues"=>"蓝调音乐",
		"Music/Classical"=>"经典音乐",
		"Music/Electronic"=>"电子乐",
		"Music/Jazz"=>"爵士乐",
		"Music/Pop"=>"流行乐",
		"Music/Rock"=>"摇滚音乐",
	"Animals"=>"宠物和动物",
		"Animals/Birds"=>"鸟",
		"Animals/Cats"=>"猫",
		"Animals/Dogs"=>"狗",
		"Animals/Fish"=>"鱼",
		"Animals/Wildlife"=>"野兽",
		"Animals/Alpaca"=>"羊驼",
	"Sports"=>"体育",
		"Sports/Football"=>"足球(football)",
		"Sports/Basketball"=>"篮球",
		"Sports/Golf"=>"高尔夫",
		"Sports/Tennis"=>"网球",
	"Nonprofit"=>"非营利",
	"Travel"=>"旅游和事件",
	//"Shortmov"=>"短片",
	//"Videoblog"=>"视频博客",
	"Games"=>"游戏",
	"Comedy"=>"喜剧",
	"People"=>"人物和博客",
	"News"=>"新闻",
	"Entertainment"=>"娱乐",
		"Entertainment/Sing"=>"现场歌唱",
		"Entertainment/Dance"=>"舞蹈",
	"Education"=>"教育",
	"Howto"=>"DIY 和生活百科",
		"Howto/Cooking"=>"美食烹饪",
		"Howto/Fashion"=>"时装",
		"Howto/Beauty"=>"女性风采",
	"Tech"=>"科学和技术",
	"Shows"=>"节目",
	"Movies"=>"电影",
	"Trailers"=>"预告片"
);
define("ThisIsTheCategory","这么多的分类，你想要看哪个呢？");
define("MoreChildCategorys","更多相关子分类(beta)");



$QualityList=array( 
	"5"=>"320×240 早期基础[flv]",
	"34"=>"320×240 基础[flv]",
	"35"=>"854×480 高质量[flv]",
	"18"=>"480×360 中等质量[mp4]",
	"22"=>"1280×720 720p[mp4]",
	"37"=>"1920×1080 1080p[mp4]",
	"38"=>"超高清 3072p[???]",
	"17"=>"176x144 手机AAC立体声[3gp]",
	"0"=>"320×240 早期基础[flv]",
	"13"=>"176x144 手机AMR单声道[3gp]",
	"6"=>"480×360 早期高质量[flv]",
	"43"=>"360p WebM",
	"44"=>"480p WebM",
	"45"=>"720p WebM"
);

//以下为通用长字符
define("YourChangeHasBeenApplied","您的更改已应用");
define("ThisFunctionIsUnavailableNow","该功能当前不可用");

//以下为地区专用
$CountryCode=array( 
	""=>"全球", 
	"HK"=>"香港", 
	"TW"=>"台湾", 
	"BR"=>"巴西", 
	"ES"=>"西班牙", 
	"FR"=>"法国", 
	"IE"=>"爱尔兰", 
	"IT"=>"意大利", 
	"JP"=>"日本", 
	"NL"=>"荷兰", 
	"PL"=>"波兰", 
	"UK"=>"英国", 
	"MX"=>"墨西哥", 
	"AU"=>"澳大利亚", 
	"NZ"=>"新西兰", 
	"CA"=>"加拿大", 
	"DE"=>"德国", 
	"RU"=>"俄罗斯", 
	"KR"=>"韩国", 
	"IN"=>"印度", 
	"IL"=>"以色列", 
	"SE"=>"瑞典" 
);
define("LocalChooser","地区选择器");
define("PleaseChooseLocal","欢迎来“".LocalChooser."”。请选择一个地区来本地化".WEBSITE_TITLE."。");
define("ThisIsThePlaceList","这就是支持的地区的列表：");
define("YourLocalIs","地区：");

//以下为地区专用
$OrderbyCode=array( 
	"relevance"=>"按相关性排序", 
	"published"=>"按发布时间排序", 
	"viewCount"=>"按观看次数排序", 
	"rating"=>"按得分排序"
);
define("OrderbyChooser","排序方法选择器");
define("PleaseChooseOrderby","欢迎来“".LocalChooser."”。请选择一个方法来优化".WEBSITE_TITLE."的索引结果。");
define("ThisIsTheOrderbyList","这些就是支持的结果排序方法：");
define("YourOrderbyIs","结果排序：");

//以下为语言专用
//lr 参数将搜索限制为带有特定语言的标题、说明或关键字的视频。lr 参数的有效值为 ISO 639-1 双字母语言代码。您还可以将值 zh-Hans 用于简体中文，将值 zh-Hant 用于繁体中文。该参数可在请求除标准供稿之外的任何视频供稿时使用。
//via http://www.loc.gov/standards/iso639-2/php/code_list.php
//via http://blog.sina.com.cn/s/blog_3d24e30d01000alj.html (中文资料)
//via http://code.google.com/intl/zh-CN/apis/youtube/developers_guide_protocol.html#Assigning_Developer_Tags
$LangCode=array( 
	"" => "（未指定）" ,
	"zh" => "中文" ,
	//"zh-CN" => "中文 (简体)" ,
	//"zh-TW" => "中文 (繁體)" ,
	"en" => "English （英语）" ,
	//"en-GB" => "English (UK)（英国英语）" ,
	"ja" => "日本語" ,
	"ko" => "&#54620;&#44397;&#50612;（韩国语）" ,
	"da" => "Dansk（丹麦语）" ,
	"de" => "Deutsch（德语）" ,
	"es" => "Español （西班牙语）" ,
	//"es-MX" => "Español (Latinoamérica) （拉丁美洲的西班牙语）" ,
	"fr" => "Français（法语）" ,
	"it" => "Italiano（意大利语）" ,
	"hu" => "Magyar（匈牙利语）" ,
	"nl" => "Nederlands（荷兰语）" ,
	"no" => "Norsk（挪威语）" ,
	"pl" => "Polski（波兰语）" ,
	//"pt-PT" => "Português（葡萄牙语）" ,
	"pt" => "Português （葡萄牙语）" ,
	"ru" => "Pyccĸий（俄语）" ,
	"fi" => "Suomi（芬兰语）" ,
	"sv" => "Svenska（瑞典语）" ,
	"cs" => "Čeština（捷克语）" ,
	"el" => "Ελληνικά（希腊语）" ,
	"hi" => "&#2361;&#2367;&#2344;&#2381;&#2342;&#2368;（印地文）"
);
define("LangChooser","语言选择器");
define("PleaseChooseLang","欢迎来“".LangChooser."”。请选择一个语言来本地化".WEBSITE_TITLE."。");
define("ThisIsTheLangList","这个就是已知的语言的列表（实际不限于本表）：");
define("YourLangIs","语言：");

//作者专页 person.php
define("ChannelOfXXX","XXX的频道");
define("UserName","用户名");
define("Age","年龄");
define("Gender","性别");
define("Hometown","家乡");
define("Location","所在地区");
define("Occupation","职业");
define("Company","公司");
define("School","学校");
define("Hobbies","兴趣爱好");
define("FavoriteBook","喜欢的书籍");
define("FavoriteMovies","喜欢的电影");
define("FavoriteMusic","喜欢的音乐");
define("KnowMoreAboutHim","深入了解他...");
$GenderData = array(
	"m" => "男性",
	"f" => "女性",
	""  => "未知"
);

//有关函数
function put_alert($msg){
	echo '<div align="center"><div class="alertbox">'.$msg.'</div></div>';
}
?>