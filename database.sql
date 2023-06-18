/*
 * @Author: Biyuehu biyuehuya@gmail.com
 * @Blog: http://imlolicon.tk
 * @Date: 2023-06-18 17:22:20
 */
-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-06-18 17:15:20
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `apidatabase`
--

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_account`
--

CREATE TABLE `huliapi_account` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `opgroup` int(1) NOT NULL DEFAULT '1',
  `ip` varchar(40) DEFAULT NULL,
  `coin` int(11) NOT NULL DEFAULT '0',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `huliapi_account`
--

INSERT INTO `huliapi_account` (`id`, `name`, `email`, `password`, `opgroup`, `ip`, `coin`, `reg_date`) VALUES
(1, 'admin', 'admin@qq.com', '123456', 4, '', 10000, '2022-09-20 02:36:36');

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_api`
--

CREATE TABLE `huliapi_api` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(100) NOT NULL,
  `idstr` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `returnTemp` text,
  `returnType` text,
  `returnPar` text,
  `requestTemp` text,
  `requestType` text,
  `requestPar` text,
  `codeTemp` text,
  `codePar` text,
  `coin` int(11) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `huliapi_api`
--

INSERT INTO `huliapi_api` (`id`, `title`, `subtitle`, `idstr`, `state`, `returnTemp`, `returnType`, `returnPar`, `requestTemp`, `requestType`, `requestPar`, `codeTemp`, `codePar`, `coin`, `reg_date`) VALUES
(1, '网页跳转', '网页生成类', 'webjump', 1, '', 'text/html', '', '?url=http://baidu.com', 'GET', 'url&是&string&输网址', '2', '', 0, '2022-10-03 08:09:02'),
(2, '个人主页生成', '网页生成类', 'homepage', 1, '', 'text/html', '', '?name=糊狸&descr=这里是可爱的糊狸~&ua=狐的博客&url=http://imlolicon.tk&img=https://biyuehu.github.io/images/avatar.png', 'GET', 'name&是&string&名字|msg&是&string&介绍|ua&是&string&按钮名称|url&是&string&按钮链接|img&是&number&图片链接', '2', '', 0, '2022-10-03 08:09:02'),
(3, '表白页生成', '网页生成类', 'confession', 1, '', 'text/html', '', '?name=华江霄&img=./images/1.gif', 'GET', 'name&是&string&输对象的名字|img&否&string&图片链接', '2', '', 0, '2022-10-03 08:09:02'),
(4, 'APP下载页生成', '网页生成类', 'downloadpage', 1, '', 'text/html', '', '?name=我的世界最强外挂2.0&version=2.0.0&descr=最牛逼的外挂&size=5.65M&update=2.0.0更新&log=结束了罪恶的一生&img=https://biyuehu.github.io/addon/ulang.png&img1=https://s1.ax1x.com/2020/08/21/dNdZa4.gif&url=/res/我的世界最强外挂2.0.apk', 'GET', 'name&是&string&软件名称|version&是&string&软件版本|descr&是&string&软件介绍|size&是&string&软件大小|update&是&string&版本更新|log&是&string&更新日志|img&是&string&软件图标直链|img1&是&string&软件图片|url&是&string&下载链接', '2', '', 0, '2022-10-03 08:09:02'),
(5, '倒计时页面生成', '？？？？？？', 'lasttime', 1, '', 'text/html', '', '?time=2024-06-7 9:00:00&title=2024中考倒计时&descr=距离2024年高考还有&name=同学们&message=寄语：在奋斗的过程中，常会遭受挫折，惟有坚持到底，才会获得最后的成功！', 'GET', 'time&是&string&最终时间,格式:四位数年份-两位数月份-两位数日期 时-分-秒|title&是&string&网站标题|descr&是&string&倒计时描述|name&是&strng&时间问候称呼|message&是&string&底部消息', '2', '', 0, '2022-10-03 08:09:02'),
(6, '色情文章', 'R18的噢', 'sexart', 1, '男人第二章\n张楚赶到医院时差不多八点锺了，正是上班人流高峰期。他进了医院，就急忙奔到妇産科那一层楼。刚走到里面，他昨天才认识的一位送女儿来生産的妇女走上来对他说，你妻子産后大出血，进了急救室了。已经进去一个多小时了，还沒出来，你快点进去看看，吓死人了。\n张楚听了，当即魂就像从头顶上飞出去一般，眼也呆了，身子僵在那里。那个妇女走上来推了他一把，他竟坐了下来，两眼瞪在前方一动都不动。过了好一会儿，他才缓过神来，站起来什麽也不顾，飞奔着向急救室沖过去。到了急救室门口，他推开门就往里面沖，却被一个小护士上来给拦住了。他抓住小护士的手，一边把小护士往旁边推，一边恳求说，我要看看我爱人，我要看看我爱人。小护士用力抵住门，拦住他，不让他进来，并且告诉他这里不能进，医生正在抢救。\n但他还是往里挤，同时不停地对小护士说，我要看看我爱人，我要看看我爱人。\n这时候，护士长从外面走过来。她看到张楚后，问，你是诗芸的爱人张楚说是。护士长说，你跟我过来，但不许讲话，看一眼就出去。张楚连忙答应下来，跟在她后面走进去。进去后，张楚看到几个医生，各人手里拿着一把闪亮带血的金属工具围在手术台上忙时，他当即吓得两腿抖了起来，脸也白了。当他看到诗芸昏死在手术台上时，张楚竟大喊一声，诗芸！同时张开两臂向手术台上扑过去……\n张楚被人推到门外时，瘫在地上几乎沒有一点意识，心里全是恐慌。手术室门口不停地有人进进出出。张楚看着那情形，心里就越是紧张、害怕。他甚至在心里喊起了诗茗的名字。诗茗，你怎麽还不来他恐怖的内心这刻真希望诗茗能够抱住他，让他的心找到一个贴靠处。\n这时候，一个医生像是突然想起什麽似的，走到张楚面前问张楚，你是什麽血型张楚一听，立即跳起来，说，我和我爱人是同一个血型。医生马上领他进去，一边走一边对他说，我们血库里的血用完了，到血液中心取血来不及，你爱人出血太多了，要快。张楚进了手术室，很快就被人安排着准备输血。诗芸身边，有几个医生还在忙着做急救措施。张楚看着，心都揪到了脑门上。他在心里喊，诗芸，你不能走。\n“时间就是生命”。在这一刻，张楚明明白白知道了时间与生命的关系。只一会儿工夫，一根输血管就插在了张楚和诗芸的手背上，把他们两人连了起来。\n张楚身上的血，立即缓缓地一滴一滴地流到了诗芸的血管里。张楚坐在那里，两眼紧紧地盯在诗芸苍白的脸上，他心里一边在祈祷，一边跟着那一滴一滴的血在数数，数诗芸什麽时候醒来……\n他们这个小孩来得有些意外。\n那是六月里一个阳光明媚的日子，这一天是诗芸二十三生日。张楚上班中午一般不回来吃饭，在单位吃食堂。但南方人过生日，中午要吃面条，意爲寿面。\n所以，张楚这天中午特地赶回来爲诗芸下生日面条。他们在吃饭的当儿，张楚和诗芸谈到了晚上到哪儿吃饭的事，要不要请同学吃饭等问题。诗芸怕麻烦，又因爲不在休息天，就说让妹妹诗茗过来吃个晚饭算了，简单清静点好。诗芸说到请诗茗，让张楚心里有些纠缠。诗茗此时正暗中跟张楚生气，张楚结婚让诗茗的那层心思全砸到地上去了。自从张楚结婚后，诗茗极少来这里。张楚有时在办公室里给诗茗打个电话去问声好，诗茗一拿起电话就挂掉。张楚结婚后，曾经和他有些暧昧的女孩子都远离了他，诗茗在他心中，比以前就更突出。张楚是那种需要从身边找出更多生活原料的男人，他需要从这些原料中去品尝人生的多种滋味，这与是否爱诗芸沒有一点关系。诗茗生他的气，他心里想，她是小姨子，能气到哪儿。所以，当诗芸说让诗茗来吃晚饭时，张楚心里一阵高兴，似乎抓住了一次机会，可以借此机会跟诗茗和好。他对诗芸说，那你打电话告诉她吧。诗芸立即说，怎麽让我打我给自己过生日啊。张楚赶紧说，我打我打。\n吃完午饭后，诗芸像平时晚上在家一样，坐在客厅沙发上，搂着张楚的腰倚在张楚身上看电视，准备过一会儿再去上班。张楚就把手伸进诗芸的怀里，手按在诗芸的胸前轻轻地抚摸诗芸的奶子，逗弄诗芸。每每这个时候，诗芸在张楚的怀里就如沈入一片暗潮涌动的汪洋里，身体在徐徐地舒展开一份接纳的姿势。不一会儿，诗芸在张楚的抚弄里渐渐地就难以自持。她起身搂住张楚的脖子，吻了一下张楚，说，你回来是给我过生日的，还是回来摸奶子的张楚回吻一下诗芸，笑着说，什麽都是。然后用劲揪了一把诗芸的奶子，就在诗芸的耳边上说，等会儿我还要咬你。诗芸的身子这刻早酥得沒有腿子胳膀了，她把身子全贴进张楚的怀里，说，把我抱过去。\n张楚抱起诗芸就往房间里走。诗芸在张楚的怀里，这一刻就像在梦里一般，寐寐的在那片汪洋里荡漾着醉意。到了房间里，张楚把诗芸放倒在床上。诗芸搂住张楚说，这还是第一次，中午在家里你跟我亲热。\n诗芸的身体非常性感，粉肌嫩肤，乳光水色，柳腰细腿，宽臀耸乳，一派风光，美不胜收。张楚每次在诗芸身上折腾时，总是无法控制住自己那种近于野蛮的掠夺，而诗芸似乎本能地爱着张楚那种野蛮的风格。一个男人在女人身上某个领域里的疯狂，有时反而会激起女人更大的爱意，它让女人看到了她在男人心目中的地位。张楚每次在诗芸身上都要奋力很长时间。有次兴盡后，张楚对诗芸说，真想跟你一直做下去。诗芸却舍不得起来，说，我天天在你身边，你好象还不够\n你太贪色了，我这样的女人会把你累坏了的。你一点点都不知道疼自己。你累坏了，以后想要我要不上怎麽办我还舍不得呢！我要你慢慢爱我，记住了张楚笑着拍拍诗芸的身子，说，不记住，谁教你长着这麽个妖魔的身子。这样的身子就是吃男人的。诗芸只好也笑笑说，我不依你，你也沒办法我。\n他们今天在一起似乎比以往任何一次都要勐烈。张楚都擡高了身子向身下的诗芸沖击，诗芸把身体也迎合成一片云似的，舒卷得柔曼让张楚荡心涤魂，蹈海翻江，寻妙探境。\n当他们一起越过快乐的高潮顶峰时，诗芸就象要晕过去一般，在张楚身下似乎连气都喘不上来了。\n过后，他们搂在一起躺在床上休息了很长时间。\n当诗芸翻身起来从张楚身下抽掉安全套时，忽然发现上面破了个洞。她赶紧把张楚推起来，嘴上一个劲地说，完了，完了，这下出事了。就是你，用这麽大的力气。你看，破了。张楚坐起来，看了看诗芸手里的安全套，反问诗芸，说，你说咋办\n怎麽你说咋办我问你。诗芸似乎急了，拿手就捶张楚。他们两人本来说好了过两年再要小孩。张楚见诗芸那麽着急的样子，就说，有就生，有啥咋办的。\n张楚的这句话立即把诗芸说得笑起来了。诗芸躺下来，对张楚说，你不知道，其实我早就希望你哪天破了。还在大学里时我就曾这样想过，正好毕业出来生个小孩，玩玩就把小孩带大了，一点也不会累人。我妈跟我也说过，要我早点生个小孩。你成天像个小孩子似的，什麽事也不问，除了吃饭、睡老婆、摸奶子，你什麽都不关心。我就想有个小孩把你变成熟了。可有时也怕你辛苦，这爸爸可不是好当的。人家都说，做父亲的都是给爱人孩子当牛当马的，你要有这个思想准备。有了小孩，我就顾不上你许多了。\n张楚听了诗芸这番话，心里有些黯然。他翻了一下身，说，天啦，那我不要。\n诗芸立即起身把两只乳峰压在张楚的脸上，揪住张楚的耳朵，说，你刚才说不要什麽张楚就势张嘴咬住诗芸的奶头，拐过心里一个角落，说，我是说不要像小孩子的我。诗芸听了，笑着把张楚拉起来，说，你去上班吧，我今天下午不去了。\n张楚上班后，担心给诗茗打去电话，诗茗又会挂掉，便特地打的到诗茗的单位去，想当面跟她说。但去了沒有找到诗茗。她单位里人说，诗茗下午请假沒有来上班。\n张楚一下午都黯神。他从诗芸那里早就听说诗茗在谈朋友了。他爲此心里常懵懵的，有时坐在办公室里，突然就怔住了神。渐渐地，心里面漾出了诗茗的影子。他有些贪心，女人、爱，以及他自己。\n晚上，张楚下班回到家，却发现桌上放着一盒大蛋糕，还有一束鲜花。再看看客厅里，诗芸和诗茗正坐在沙发上一边閑谈，一边在看电视。张楚心里立即高兴起来，他走过去喊了一声诗茗，诗茗嗯了一声，却沒拿眼看他，明显还在怄他的气。但有诗芸在一边，张楚也不好说其它话，就把自己买的那束鲜花送到诗芸面前，说，祝你生日快乐。诗芸接过鲜花时，开心得一脸灿烂，还举起来叫诗茗看看。诗茗趁机拿话怄张楚，说，姐姐过生日，你买那麽多勿忘我干什麽玫瑰还要买两枝，还买康乃馨什麽乱七八糟的，好象要我姐姐唤起什麽回忆似的，你给旧情人送怀念花呀。诗茗说到这里，诗芸先笑了。张楚接过话说，你过生日那我该送什麽花诗茗说，谁要你送，姐姐会送。诗茗说到这里，忽然发现自己话说得有些重了，怕张楚吃不住反过来憋她的气，赶紧补一句，说，你送也是乱送花。\n诗芸把花送到桌上去时，诗茗趁诗芸不注意，擡脚用力向张楚的腿上踢过去。\n张楚疼得不敢吱声，拿眼看看诗茗，脸上却露出了一丝关不住的甜蜜的笑容。诗茗这一脚，让他心里的阴霾化去了许多。\n隔了几天，诗芸从书店里买回来一大堆“怀孕必知”、“孕妇必读”等一类怀孕育儿方面的书，想撑握一些怀孕育儿等方面的知识。但诗芸看完了这些书却犯起了愁。原因是她从书本上得到一条信息，说精子进入子宫时，是采用优胜劣淘法。精子往子宫里前进时，大部分要被杀死，只有最强健最有力的精子才能沖破层层围杀，进入到子宫里，与卵子结合，使卵子受精。诗芸想，那天安全套里还残留着许多精液，进入到子宫里的精子可能就不是最优秀的精子。诗芸想到这里，就有点担心小孩将来智力不好。诗芸躺在张楚怀里，整整担心了一个晚上。\n张楚只好劝说诗芸，说还沒有确信怀孕，你现在愁什麽。等到诗芸这个月例假沒有来，去医院化验，结果出来知道自己真的怀了孕，诗芸更加不安起来。她后来和张楚商量，准备去医院把这个小孩打掉。医生给诗芸检查过后劝说诗芸，头一个小孩，千万別打掉，不会有任何问题。诗芸的母亲也三番五次地打来电话叫诗芸別打掉，诗芸这才留住这个小孩。\n诗茗得知姐姐怀孕了，更加对张楚气不过来。', 'text/html', '', '?msg=1', 'GET', 'msg&否&number&输数字(1-25)', NULL, '', 0, '2022-10-03 08:09:02'),
(7, 'UUID获取', '随机获取UUID', 'uuidget', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": [\n        \"e93ff75f-06bf-ef6d-406b-64d1278a209e\",\n        \"c871845a-b41f-032e-afdd-3259890f4d76\",\n        \"5e31eb6b-b882-7d87-fd98-417ef645d829\"\n    ]\n}', 'application/json', 'data&array&获取到的数据', '?num=3', 'GET/POST', 'num&是&number&生成个数,默认1', '', '', 0, '2022-10-03 08:09:02'),
(8, '农历', '农历', 'lunar', 1, '今天是公元2023年01月14日\n农历壬寅年 腊月廿三 虎年\n节气：小寒后', 'text/plain', '', '', 'GET', '', '', '', 0, '2022-10-03 08:09:02'),
(9, '随机语录', '16种不同类型语录', 'words', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"msg\": \"如果你吃了亏，千万不要喝水，不然你会变污的。\",\n        \"type\": \"毒鸡汤\"\n    }\n}', 'application/json', 'msg&string&语录|type&string&类型', '?msg=1', 'GET/POST', 'msg&否&number&范围为1~16数字,1一言,2骚话,3情话,4人生语录,5社会语录,6,毒鸡汤,7笑话,8网抑云,9温柔语录,10舔狗语录,11爱情语录,12个性签名,13人间,14经典语录,15英汉语录,16诗词,填错或不填则随机|format&否&string&类型,可选json、text,默认json', NULL, '', 0, '2022-10-03 08:09:02'),
(10, '有道翻译', '中英互译', 'fanyi', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": \"爱已逝\"\n}', 'application/json', 'data&string&返回的数据', '?msg=love is gone', 'GET/POST', 'msg&是&string&输要翻译的英语', '', '', 0, '2022-10-03 08:09:02'),
(11, 'base64加解密', '直接返回类', 'base64', 1, '{\n	\"code\": 500,\n	\"message\": \"success\",\n	\"data\": \"\"\n}', 'application/json', 'data&string&返回的数据', '?op=0&code=echo \'hi\';', 'POST', 'id&是&number&0加密,1解密|code&是&string&输入代码', NULL, '', 0, '2022-10-03 08:09:02'),
(12, '妹子图', '妹子图', 'beautyimg', 0, 'http://tva1.sinaimg.cn/large/005BYqpggy1fwre4ivvpvj31hc0u078r.jpg', 'image', '', '', 'GET', '', NULL, '', 0, '2022-10-03 08:09:02'),
(13, '动漫图', '正经图', 'animeimg', 0, 'http://tva4.sinaimg.cn/large/9bd9b167ly1g2ret0y7aij20u01hc4qp.jpg', 'image', '', '', 'GET', '', NULL, '', 0, '2022-10-03 08:09:02'),
(14, '天气查询', '查询城市天气', 'weather', 1, '城市：长春市朝阳区\n日期：周五\n温度：-17～4℃\n天气：多云\n风度：微风-2级\n空气质量：优\n\n日期：周六\n温度：-20～-13℃\n天气：多云\n风度：东北风-1级\n空气质量：优\n\n日期：周日\n温度：-19～-11℃\n天气：多云\n风度：西风-2级\n空气质量：良', 'text/plain', '', '?msg=长春&b=1', 'GET', 'msg&是&string&输地区|b&是&number&输地区的选择', '', '', 0, '2022-10-03 08:09:02'),
(15, '站长工具', '多个功能', 'webtool', 1, '菜单(不输入任何参数):\n1.状态查询\n2.域名查询(维护)\n3.网站测速\n4.ping(维护)\n5.收录查询(维护)\n6.收录量查询(维护)\n请发送数字\n1.状态查询:\n域名/IP:baidu.com\n状态:200\n解释:成功\n3.网站测速:\n最慢：21/ms\n最快：11/ms\n平均：16/ms\n响应IP：39.156.66.10', 'text/plain', '', '?op=1&url=baidu.com', 'GET', 'op&否&string&操作|url&否&string&网页链接', '', '', 0, '2022-10-03 08:09:02'),
(16, '随机谜语', '随机返回一条谜语', 'riddle', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"topic\": \"火腿肠\",\n        \"answer\": \"HTC。\",\n        \"type\": \"其他谜\",\n        \"ps\": \"打一手机品牌\"\n    }\n}', 'application/json', 'topic&string&题目|type&string&类型|answer&string&答案|ps&string&提示', '', 'GET/POST', '', '', '', 0, '2022-10-03 08:09:02'),
(17, '获取QQ昵称和头像', '获取QQ昵称和头像', 'qqget', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"imgurl\": \"https://q.qlogo.cn/headimg_dl?dst_uin=10001&spec=100\",\n        \"name\": \"pony\"\n    }\n}', 'application/json', 'imgurl&string&QQ头像图片直链|pony&string&QQ名字', '?qq=10001', 'GET/POST', 'qq&是&integer&输QQ号', '', '500&请求成功|501&错误', 0, '2022-10-03 08:09:02'),
(18, '网易云音乐信息获取', '网易云音乐信息获取', 'nemusic', 1, '{\n	\"code\": 500,\n	\"message\": \"success\",\n	\"data\": {\n		\"id\": \"760308\",\n		\"name\": \"Saya\'s Song\",\n		\"singer\": \"Lia\",\n		\"cover\": \"http://p1.music.126.net/kuT_f6Joy9LFzAWqdik1yw==/720180116205332.jpg\",\n		\"url\": \"http://music.163.com/song/media/outer/url?id=760308\"\n	}\n}', 'application/json', 'id&string&音乐ID|cover&string&音乐封面图片直链|name&string&音乐名字|singer&string&音乐歌手名字|url&string&音乐链接', '?msg=saya\'s song&line=1', 'GET/POST', 'msg&是&string&输内容|line&否&number&输内容的选择', NULL, '500&请求成功|501&错误', 0, '2022-10-03 08:09:02'),
(19, 'MCBE服务器信息查询', '经典的motdpe', 'motdpe', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"status\": \"online\",\n        \"ip\": \"cloud.huliapi.xyz\",\n        \"real\": \"82.157.165.201\",\n        \"port\": \"20101\",\n        \"location\": \"四川省南充市 电信\",\n        \"motd\": \"CHED Server\",\n        \"agreement\": \"554\",\n        \"version\": \"1.19.31\",\n        \"online\": \"0\",\n        \"max\": \"10000\",\n        \"gamemode\": \"Survival\",\n        \"delay\": 40\n    }\n}', 'application/json', 'status&string&状态(在线,离线)|ip&string&IP或域名|real&string&IP|port&string&端口|location&string&地址|motd&string&服务器提示信息|agreement&string&服务器协议版本|version&string&服务器版本|online&string&服务器在线人数|max&string&服务器最大人数|gamemode&string&服务器游戏模式|delay&number&delay', '?ip=82.157.165.201&port=19111', 'GET/POST', 'ip&是&string&服务器IP地址|port&是&number&服务器端口', '', '500&请求成功|501&错误|502&错误|503&错误', 0, '2022-10-03 08:09:02'),
(20, '网易云音乐下载', '直接下载网易云音频文件', 'nemusicdl', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"id\": 26089099,\n        \"type\": \"mp3\",\n        \"md5\": \"6dfd717ef6d1267869cfae8d72682772\",\n        \"size\": 12563064,\n        \"url\": \"http://m10.music.126.net/20221221182535/29dcf5545877afdd34323c55b1f1b605/ymusic/bc6a/f7b2/d5ef/6dfd717ef6d1267869cfae8d72682772.mp3\"\n    }\n}', 'application/json', 'id&number&音乐ID|type&string&音频文件类型|md5&string&MD5值|size&number&音频文件大小|url&string&音频文件直链', '?id=26089099', 'GET/POST', 'id&是&number&音乐ID', '', '500&请求成功|501&错误', 0, '2022-10-03 08:09:02'),
(21, 'HuHitokoto一言', '糊狸的专属hitokoto', 'hitokoto_ialapi', 2, 'http://imlolicon.tk/index.php/archives/129/', 'text/html', '', '', 'GET', '', '0', '', 0, '2022-10-03 08:09:02'),
(22, 'HCB-HULI云黑', 'HCB-HULI云黑', 'index_hcb', 2, 'http://hcb.imlolicon.tk', 'text/html', '', '', 'GET', '', NULL, '', 0, '2022-10-03 08:09:02'),
(23, 'Pixiv图片', '有懂得都懂的那种图片噢', 'seimg_ialapi', 2, 'https://imlolicon.tk/index.php/archives/221/', 'text/html', '', '', 'GET', '', '0', '', 0, '2022-10-03 08:09:02'),
(24, 'B站用户追番信息获取', '由机制的糊狸特别制作', 'getbilianime', 1, '{\n    \"code\": 500,\n    \"data\": {\n        \"uid\": \"2\",\n        \"nums\": 153,\n        \"list\": [\n            {\n                \"type\": \"国创\",\n                \"title\": \"小魔头暴露啦！\",\n                \"subtitle\": \"为救魔族少主竟然？\",\n                \"tags\": [\n                    \"泡面\",\n                    \"搞笑\",\n                    \"漫画改\",\n                    \"古风\"\n                ],\n                \"descr\": \"为了在江湖上活下去，魔教教主之子于仁杰奉命混入只招收名门正派弟子的“正道书院”，目标是获得能够洗白魔教身份的”好人证“。此行凶险异常，一旦暴露魔教身份必将被无数正道侠客当场击杀。可在报到当天于仁杰就尴...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/d6250b1eb2893304c2c496eb8b9d79f5aac9b9ab.png\",\n                \"setnum\": \"全26话\",\n                \"isnew\": null,\n                \"showtime\": \"2022年1月15日\",\n                \"areas\": \"中国大陆\",\n                \"badge\": \"出品\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"恋爱要在世界征服后\",\n                \"subtitle\": \"不要战斗要恋爱！\",\n                \"tags\": [\n                    \"战斗\",\n                    \"恋爱\",\n                    \"漫画改\",\n                    \"特摄\"\n                ],\n                \"descr\": \"春季，樱花飞舞的某一天，一对懵懵懂懂的情侣在草地上并肩而坐。n他们是相川不动和祸原死死美。n但他们的真实身份其实是，冰冻战队冰果五战士的队长「红色冰果」和n邪恶秘密组织月光的打手「死神公主」！n原本互...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/61e324e9ce28934e77e98a2502d988f89c74a119.jpg\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2022年4月8日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"魔法纪录 魔法少女小圆外传 第二季\",\n                \"subtitle\": \"为了寻找失去的愿望\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"战斗\",\n                    \"魔法\",\n                    \"游戏改\"\n                ],\n                \"descr\": \"愿望的代价，究竟是希望还是绝望——。\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/9eef1df9ab157be52d2c4d70d3500442f00cafc3.png\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年7月30日\",\n                \"areas\": \"日本\",\n                \"badge\": \"独家\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"瑞奇宝宝 第二季 中文配音\",\n                \"subtitle\": \"和瑞奇宝宝一起学习\",\n                \"tags\": [\n                    \"少儿\"\n                ],\n                \"descr\": \"《瑞奇宝宝》中的故事主要发生在卧室、书房、操场等孩子们熟悉的场景中，情节简单真实，以孩子已经认识的食物、游戏、睡眠及其他日常行为作为基础，将关于情绪、社交、运动和艺术等知识巧妙融入到剧情中，让孩子能够...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/53133740d40f6a0d9e25bcb75b7542719e4cca6f.png\",\n                \"setnum\": \"全52话\",\n                \"isnew\": null,\n                \"showtime\": \"2018年6月1日\",\n                \"areas\": \"俄罗斯\",\n                \"badge\": \"\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"与变成了异世界美少女的好友一起冒险\",\n                \"subtitle\": \"打败魔王变回男儿身\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"搞笑\",\n                    \"萌系\",\n                    \"漫画改\"\n                ],\n                \"descr\": \"因自己不受欢迎找不到女朋友，而郁郁寡欢的32岁职场白领橘日向，借由异世界女神之力，和自幼玩伴&现完美精英的同事一起转移到了异世界！竟因女神的粗心，变为了超绝可爱金发美少女――!? n为寻回自己原本的性...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/314c9855b31b9acb35663598755243b87629a9f9.png\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2022年1月11日\",\n                \"areas\": \"日本\",\n                \"badge\": \"出品\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"里亚德录大地\",\n                \"subtitle\": \"冒险从现在开始！\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"小说改\",\n                    \"穿越\"\n                ],\n                \"descr\": \"一场不幸的事故，让名为各务桂菜的少女不得不在生命维持装置里度过一生。只有虚拟现实大型多人在线角色扮演游戏《里亚德录》是她唯一的自由。nn而就在某一天，生命维持装置忽然停止，桂菜也失去了生命。n但是当她...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/a626e4d7c4e09018b2314ce0cb98881c7aa783c8.png\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2022年1月5日\",\n                \"areas\": \"日本\",\n                \"badge\": \"独家\"\n            },\n            {\n                \"type\": \"国创\",\n                \"title\": \"喜羊羊与灰太狼之奇趣外星客\",\n                \"subtitle\": \"羊羊们在神秘外太空\",\n                \"tags\": [\n                    \"热血\",\n                    \"少儿\",\n                    \"战斗\",\n                    \"催泪\",\n                    \"原创\"\n                ],\n                \"descr\": \"智羊羊夫妇遭细菌大王冰封前，将冰冰羊送去寻求喜羊羊的庇护。不料细菌大王为解封能力追到草原，幸好众羊狼将冰冰羊救出。自此羊村波澜不断，众羊狼最终击败细菌军团，解除了大危机，而冰冰羊的身份也终将水落石出...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/f87ce2e7deee03e4d383961c8f96ca44fffa45e0.jpg\",\n                \"setnum\": \"全60话\",\n                \"isnew\": null,\n                \"showtime\": \"2020年1月10日\",\n                \"areas\": \"中国大陆\",\n                \"badge\": \"\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"命运-冠位嘉年华\",\n                \"subtitle\": \"嘉年华回来啦！！\",\n                \"tags\": [\n                    \"日常\",\n                    \"搞笑\",\n                    \"原创\"\n                ],\n                \"descr\": \"一起庆祝吧！为了这奇迹般的嘉年华！\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/c660976f4502a544d990a882ae62194b57753a71.png\",\n                \"setnum\": \"全2话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年6月2日\",\n                \"areas\": \"日本\",\n                \"badge\": \"独家\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"命运-冠位指定 冠位时间神殿所罗门\",\n                \"subtitle\": \"为了夺回人类的未来\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"战斗\",\n                    \"游戏改\"\n                ],\n                \"descr\": \"在经过七个特异点的大战后，n人理存续保障机关迦勒底，终于到达了圣杯探索的最终地点——终局特异点 冠位时间神殿所罗门。n他们要击败身为罪魁祸首的魔术王所罗门，夺回未来。n在开战的前一刻，一行人各自度过了...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/c67cf37c9d722a50c7f75ffd6e81391fc9170f9d.jpg\",\n                \"setnum\": \"全1话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年7月30日\",\n                \"areas\": \"日本\",\n                \"badge\": \"独家\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"异想食堂  / 异世界食堂 第二季\",\n                \"subtitle\": \"这家食堂通向异世界\",\n                \"tags\": [\n                    \"治愈\",\n                    \"美食\",\n                    \"小说改\"\n                ],\n                \"descr\": \"“欢迎光临！这里是猫屋西餐厅！！”n阿蕾塔与黑就职的餐厅，其特点便是门口悬挂着的印有猫咪图案的招牌。乍一看只是个在日本随处可见的餐厅，但到了每7天1次的“特殊营业日”时，异世界各地便会出现通向这家店的...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/dbd034057eea888ab0e4635c3e3726e59f24c479.png\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年10月1日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"国创\",\n                \"title\": \"重器2069\",\n                \"subtitle\": \"我们必将胜利归航！\",\n                \"tags\": [\n                    \"战斗\",\n                    \"原创\",\n                    \"励志\"\n                ],\n                \"descr\": \"2069年，地球忽然遭遇了来路不明的攻击，全球70％的国家和地区沦陷。即将退役的中国第二代航母16A舰因其使用超短波通讯反而躲过了敌方干扰，得以幸存。年轻的实习作战指挥官少女水夏及临时飞行员姜天等人临...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/7b86ac8342f774b37d6964e2fbe8765ee760b7c6.png\",\n                \"setnum\": \"即将开播\",\n                \"isnew\": null,\n                \"showtime\": \"敬请期待\",\n                \"areas\": \"中国大陆\",\n                \"badge\": \"出品\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"命运-冠位指定 -月光／失落之室-\",\n                \"subtitle\": \"不属于任何人的房间\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"游戏改\"\n                ],\n                \"descr\": \"失落之室——。n这是一个可以看到被夺去亦或是遗失之物的地方。n这是位于迦勒底被遗忘的角落，不属于任何人的地方。...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/3fa5fd2b7afae827b0bf150d7f0cbfc54eda1ff2.png\",\n                \"setnum\": \"全1话\",\n                \"isnew\": null,\n                \"showtime\": \"2017年12月31日\",\n                \"areas\": \"日本\",\n                \"badge\": \"独家\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"关于我转生变成史莱姆这档事 第二季\",\n                \"subtitle\": \"史莱姆黑化\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"战斗\",\n                    \"小说改\",\n                    \"魔法\",\n                    \"架空\"\n                ],\n                \"descr\": \"主人公利姆鲁与仰慕他而聚集的众多魔物们所建立的国家「鸠拉·特恩佩斯特国」，经由与邻国的协议及交易，让「人类与魔物共同漫步的国家」这一温柔的理想逐步成形。nn利姆鲁作为曾是人类的史莱姆当然拥有「对人类的...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/fd492888df64bbc3b821dac5d516dbc1c2fe5f08.png\",\n                \"setnum\": \"全24话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年1月5日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"关于我转生变成史莱姆这档事 转生史莱姆日记\",\n                \"subtitle\": \"\",\n                \"tags\": [\n                    \"日常\",\n                    \"搞笑\",\n                    \"漫画改\",\n                    \"穿越\"\n                ],\n                \"descr\": \"美妙的史莱姆人生！nn累计突破50万部的大人气外传四格漫画『转生史莱姆日记』，作为转生史莱姆的外传系列首次TV动画化！n「因为拿到了贵重的纸，我把至今为止发生的事情以日记形式记录了下来。开头的话就这么...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/cac1699418451387f93572066b7e5d14d799d3cd.jpg\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年4月6日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"国创\",\n                \"title\": \"灵笼\",\n                \"subtitle\": \"末世如何才能生存\",\n                \"tags\": [\n                    \"热血\",\n                    \"奇幻\",\n                    \"科幻\",\n                    \"战斗\",\n                    \"原创\"\n                ],\n                \"descr\": \"不久的未来，人类的世界早已拥挤不堪，迈向星河、寻找新家园的行动迫在眉捷。正当一切有条不紊的推进之时，月相异动，脚下的大地爆发了长达数十年、剧烈的地质变化，人类在这场浩劫中所剩无几。当天地逐渐恢复平静，...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/cfab7e0fbdb4786ff4e885d050b7cf37f8829486.png\",\n                \"setnum\": \"全16话\",\n                \"isnew\": null,\n                \"showtime\": \"2019年7月13日\",\n                \"areas\": \"中国大陆\",\n                \"badge\": \"出品\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"食戟之灵 餐之皿\",\n                \"subtitle\": \"\",\n                \"tags\": [\n                    \"热血\",\n                    \"搞笑\",\n                    \"校园\",\n                    \"美食\",\n                    \"漫画改\"\n                ],\n                \"descr\": \"在老家的餐饮店“幸平餐馆”一边帮忙下厨一边磨炼厨艺的幸平创真，前往超级精英料理学校“远月茶寮料理学园”入学。创真在学园中与各式各样的料理人相遇并不断成长着，同时也开始摸索“只属于自己的料理”。n创真在...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/ba2d5db28415558a577f71b4f845fcea45ea1bac.jpg\",\n                \"setnum\": \"全24话\",\n                \"isnew\": null,\n                \"showtime\": \"2017年10月3日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"五等分的新娘∬\",\n                \"subtitle\": \"谁才是最后的新娘？\",\n                \"tags\": [\n                    \"校园\",\n                    \"恋爱\",\n                    \"漫画改\"\n                ],\n                \"descr\": \"面对“将要留级”、“讨厌学习”的美少女五姐妹，身为兼职家庭教师的风太郎要指导她们学习，直到“顺利毕业”为止。经历了林间学校中发生的许多事情后，风太郎与五姐妹的信赖进一步加深。n想要在作为家庭教师的事业...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/2a0dc651a4ffca1cfe915dbc7eb2c8c65256813d.png\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年1月8日\",\n                \"areas\": \"日本\",\n                \"badge\": \"独家\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"Re：从零开始的异世界生活 第二季 后半\",\n                \"subtitle\": \"我一定会拯救你\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"小说改\",\n                    \"穿越\"\n                ],\n                \"descr\": \"我一定会拯救你。n在打倒了魔女教大罪司教「怠惰」担当——培提其乌斯·罗曼尼康帝之后，菜月昴和爱蜜莉雅又得以重新开始。n克服了艰难的诀别，两人终于和解，然而这只是新一轮风波的序幕。n超乎想象的绝境危机，...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/4f3edbede7fc0bdb52842075cf8faaa1c5953eaa.png\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年1月6日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"岸边露伴 一动也不动\",\n                \"subtitle\": \"JOJO外传动画\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"战斗\",\n                    \"漫画改\"\n                ],\n                \"descr\": \"本作是在「JOJO的奇妙冒险 不灭钻石」中登场的漫画家・岸边露伴，n为了收集漫画的素材而前往各地后所遭遇的奇妙见闻集！n...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/9b89d0fa9c44fdc791407847d3556f4cb8f157e4.png\",\n                \"setnum\": \"全4话\",\n                \"isnew\": null,\n                \"showtime\": \"2021年2月20日\",\n                \"areas\": \"日本\",\n                \"badge\": \"独家\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"关于我转生变成史莱姆这档事\",\n                \"subtitle\": \"参见萌王！\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"战斗\",\n                    \"小说改\",\n                    \"魔法\",\n                    \"穿越\",\n                    \"冒险\",\n                    \"架空\"\n                ],\n                \"descr\": \"史莱姆生活，开始了。n上班族的三上悟在道路上被歹徒给刺杀身亡后，回过神来发现自己转生到了异世界。n不过，自己居然是“史莱姆”！n他在得到利姆鲁这个名字后开始了自己的史莱姆人生，随着与各个种族相处交流的...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/a4c0e0ccc44fe3949a734f546cf5bb07da925bad.png\",\n                \"setnum\": \"全29话\",\n                \"isnew\": null,\n                \"showtime\": \"2018年10月2日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"Re：从零开始的异世界生活 第二季 前半\",\n                \"subtitle\": \"圣域篇，来了来了\",\n                \"tags\": [\n                    \"奇幻\",\n                    \"小说改\",\n                    \"穿越\"\n                ],\n                \"descr\": \"我一定会拯救你。n在打倒了魔女教大罪司教「怠惰」担当——培提其乌斯·罗曼尼康帝之后，菜月昴和爱蜜莉雅又得以重新开始。n克服了艰难的诀别，两人终于和解，然而这只是新一轮风波的序幕。n超乎想象的绝境危机，...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/f2425cbdb07cc93bd0d3ba1c0099bfe78f5dc58a.png\",\n                \"setnum\": \"全13话\",\n                \"isnew\": null,\n                \"showtime\": \"2020年7月8日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            },\n            {\n                \"type\": \"番剧\",\n                \"title\": \"刀剑神域 爱丽丝篇 异界战争 -终章-\",\n                \"subtitle\": \"重新站起来吧，桐人\",\n                \"tags\": [\n                    \"科幻\",\n                    \"战斗\",\n                    \"小说改\",\n                    \"穿越\",\n                    \"冒险\",\n                    \"架空\"\n                ],\n                \"descr\": \"桐人、尤吉欧、爱丽丝。n距离两名修剑士和一名整合骑士打败了最高祭司阿多米尼斯多雷特已过去了半年。n结束了战斗，爱丽丝在故乡卢利特村生活。n在她的身旁，是失去了挚友，自己也失去了手臂和心的桐人。n献身般...\",\n                \"cover\": \"http://i0.hdslb.com/bfs/bangumi/image/54d9ca94ca84225934e0108417c2a1cc16be38fb.png\",\n                \"setnum\": \"全12话\",\n                \"isnew\": null,\n                \"showtime\": \"2020年7月5日\",\n                \"areas\": \"日本\",\n                \"badge\": \"会员专享\"\n            }\n        ]\n    }\n}', 'application/json', 'uid&string&用户UID|nums&number&追番数量|list&array&追番信息列表|type&string&类型(番剧,国创...)|title&string&标题|subtitle&string&副标题|tags&array&标签|descr&string&简介|cover&string&封面图片直链|setnum&string&集数|isnew&boolean&是否为新番|url&string&番剧链接|showtime&string&播出时间|isnew&string&|areas&string&地区(日本,中国大陆...)|badge&string&会员专享,出品...', '?uid=2', 'GET/POST', 'uid&是&number&用户UID', NULL, '500&请求成功|501&参数不能为空', 15, '2022-10-03 08:09:02'),
(25, '身份证查询', '查询并验证身份证是否合规', 'idcard', 1, '{\n    \"code\": 500,\n    \"data\": {\n        \"text\": \"身份证号正确!\",\n        \"gender\": \"女\",\n        \"birthday\": \"1975-3-10\",\n        \"age\": 47,\n        \"adult\": true,\n        \"province\": \"辽宁\",\n        \"address\": \"辽宁省大连市西岗区\",\n        \"zodiac\": \"兔\",\n        \"starsign\": \"双鱼座\"\n    }\n}', 'application/json', 'text&string&文字提示|gender&string&性别|birthday&string&出生日期|age&number&年龄|adult&boolean&是否成年|province&string&省份|address&string&地址|zodiac&string&生肖|starsign&string&星座', '?msg=210203197503102721', 'GET/POST', 'msg&是&number&身份证', '', '500&请求成功|501&身份证号不正确', 0, '2022-10-05 14:58:52'),
(26, '时间差计算', '计算两个时间段间隔', 'timecal', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"day\": 13933,\n        \"hour\": 0,\n        \"minute\": 0,\n        \"second\": 0\n    }\n}', 'application/json', 'day&number&日|hour&number&时|minute&number&分|second&number&秒', '?start=1984-1-1&end=2022-2-23', 'GET/POST', 'start&是&string&开始时间段 格式:Y-M-D h:min:s|end&是&string&结束时间段', '', '', 0, '2022-10-05 15:03:17'),
(27, '查字', '查询字的信息', 'diction', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"word\": \"狐\",\n        \"yinjie\": \"hu\",\n        \"bushou\": \"犭\",\n        \"bushounum\": 3,\n        \"buwainum\": 5,\n        \"num\": 8,\n        \"method\": 35333544\n    }\n}', 'application/json', 'word&string&字|yinjie&string&音节|bushou&string&部首|bushounum&number&部首笔画|buwainum&number&部外笔画|num&number&字笔画|method&number&字书写顺序', '?msg=狐', 'GET/POST', 'msg&是&string&要查的字', '', '500&请求成功|501&错误', 0, '2022-10-05 15:05:22'),
(28, '文字转语音', '度娘版', 'reading', 1, '/res/temp/reading.mp3', 'audio', '', '?msg=魔爱着神,神爱世人,而世人却不自爱,更心生魔物,自相残杀。', 'GET', 'msg&是&string&内容', '1', '', 0, '2022-10-05 15:08:59'),
(29, '聊天AI', '这个是ISLA酱~', 'chat', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data \": \"害羞死了呢\"\n}', 'application/json', 'data&string&返回的数据', '?msg=其实...我喜欢你很久了...', 'GET/POST', 'msg&是&string&聊天内容', NULL, '500&请求成功|501&错误', 0, '2022-10-05 15:13:38'),
(30, '诱惑图', '诱惑图', 'sedimg', 1, '/res/temp/sedimg.jpg', 'image', '', '', 'GET', '', '1', '', 0, '2022-10-06 14:32:29'),
(31, '随机小姐姐视频', '随机小姐姐视频', 'sisters', 1, 'http://ali-cdn.kwai.net/upic/2015/10/12/10/BMjAxNTEwMTIxMDIzMTlfMTY3ODUwOTFfNDEzMTgzNDY5XzJfMw==.mp4', 'video', '', '', 'GET', '', '1', '', 0, '2022-10-06 14:35:17'),
(32, '墙壁文字图片生成', '墙壁文字图片', 'wall', 1, '/res/temp/wall.jpg', 'image', '', '?msg=HULIAPI制作', 'GET', 'msg&是&string&文字', '1', '', 0, '2022-10-06 14:38:14'),
(33, '60秒带你读世界图片生成', '60秒带你读世界', '60s', 1, '/res/temp/60s.jpg', 'image', '', '?name=ISLA', 'GET', 'name&否&string&名字', NULL, '', 20, '2022-10-06 14:39:59'),
(34, '历史上的今天', '历史上的今天', 'storytoday', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": [\n        \"2010年-秘鲁作家马里奥巴尔加斯略萨获诺贝尔文学奖\",\n        \"2005年-南京长江第三大桥正式通车\",\n        \"2001年-阿富汗战争，塔利班政权崩溃\",\n        \"2001年-中国男子足球冲进世界杯\",\n        \"1997年-动画艺术大师万籁鸣逝世\",\n        \"1990年-第十一届北京亚运会闭幕\",\n        \"1986年-刘伯承元帅逝世\",\n        \"1986年-美国发现最古老的恐龙化石\",\n        \"1986年-北京第一所弱智儿童养育院开学\",\n        \"1986年-美发明防止核反应堆爆炸装置\",\n        \"1985年-中国成为“南极条约”协商国\",\n        \"1982年-我国向预定海域发射运载火箭成功\",\n        \"1969年-历史学家陈寅恪逝世\",\n        \"1952年-俄罗斯总统普京诞辰\",\n        \"1949年-德意志民主共和国建立\",\n        \"1949年-我国与波兰建立外交关系\",\n        \"1936年-三大主力红军胜利会师，长征结束\",\n        \"1931年-南非著名黑人图图主教诞辰\",\n        \"1913年-亨利福特建立了第一条装配线\",\n        \"1895年-中国民主建国会创建人胡厥文诞辰\",\n        \"1885年-丹麦物理学家玻尔诞生\",\n        \"1864年-中俄签订《勘分西北界约记》\",\n        \"1860年-英法侵略军火烧圆明园\",\n        \"-643年-春秋五霸之首齐桓公逝世\"\n    ]\n}', 'application/json', 'data&array&获取到的数据', '', 'GET/POST', 'name&否&string&名字', '', '500&请求成功|501&错误', 0, '2022-10-07 02:30:00'),
(35, '姓名身份证匹配校验', '检查姓名与身份证是否一致', 'nameidcard', 1, '{\n    \"code\": 500,\n    \"message\": \"success\"\n}', 'application/json', '', '?name=韦一&id=341202200409040016', 'GET/POST', 'name,是,string,姓名&id,是,number,身份证', NULL, '500&请求成功|501&姓名身份证不匹配|502&该姓名身份证查询次数过多,请24小时后重试|503&姓名身份证不符合规则', 10, '2022-12-02 10:52:01'),
(36, 'B站视频信息获取', '基于官方API', 'biligetv', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"bvid\": \"BV1GJ411x7h7\",\n        \"aid\": 80433022,\n        \"title\": \"【官方 MV】Never Gonna Give You Up - Rick Astley\",\n        \"pic\": \"http://i1.hdslb.com/bfs/archive/5242750857121e05146d5d5b13a47a2a6dd36e98.jpg\",\n        \"ctime\": 1577835803,\n        \"descr\": \"-\",\n        \"owner\": {\n            \"uid\": 486906719,\n            \"name\": \"索尼音乐中国\",\n            \"img\": \"http://i2.hdslb.com/bfs/face/459425ffc7f0c9c12976fb678c34734462be8ab7.jpg\"\n        }\n    }\n}', 'application/json', 'bvid&string&视频BV号|title&string&视频标题|pic&string&视频封面图片直链|ctime&number&视频时长|descr&string&视频简介|uid&number&UP主UID|name&string&UP主名字|img&string&UP主头像图片直链', '?msg=BV1GJ411x7h7', 'GET/POST', 'msg&是&string&BV号', '', '500&请求成功|501&参数不能为空|502&参数错误', 0, '2022-12-07 10:00:07'),
(37, 'B站视频下载', '基于官方API', 'bilidlv', 1, '{\n    \"code\": 500,\n    \"message\": \"success\",\n    \"data\": {\n        \"type\": \"mp4720\",\n        \"typelist\": [\n            \"高清 1080P \",\n            \"高清 1080P\",\n            \"高清 720P\",\n            \"流畅 360P\"\n        ],\n        \"timelength\": 212320,\n        \"size\": 86306926,\n        \"url\": \"https://upos-sz-mirrorhw.bilivideo.com/upgcxcode/99/91/137649199/137649199_u2-1-208.mp4?e=ig8euxZM2rNcNbKV7bdVhwdl7wdjhwdVhoNvNC8BqJIzNbfq9rVEuxTEnE8L5F6VnEsSTx0vkX8fqJeYTj_lta53NCM=&uipk=5&nbs=1&deadline=1670421443&gen=playurlv2&os=hwbv&oi=2067331027&trid=c522a857913142eaa70b8b38ceebc4beT&mid=0&platform=html5&upsig=03cbf89aab9410e8d0f382f92bd49a5e&uparams=e,uipk,nbs,deadline,gen,os,oi,trid,mid,platform&bvc=vod&nettype=0&bw=407108&orderid=0,1&logo=80000000\"\n    }\n}', 'application/json', 'type&string&视频类型|typelist&array&视频画质列表|timelength&number&视频时长|size&number&视频文件大小|url&string&视频文件直链', '?msg=BV1GJ411x7h7', 'GET/POST', 'msg&是&string&BV号', '', '500&请求成功|501&参数不能为空|502&参数错误', 0, '2022-12-07 10:05:46'),
(38, '[核心CORE]统计API', 'HULICORE ByBiyuehu', 'stat', 3, '{\n	\"code\": 500,\n	\"message\": \"success\",\n	\"data\": 865\n}', 'application/json', 'data&string&返回数据', '?op=queryday&name=api_call_inside&par2=2', 'GET/POST', 'name&是&string&选择器名字|op&是&string&操作,选填query,queryday,write,add|par2&否&string&进行queryday操作时,可指定多少天前的数据,默认0', NULL, '500&请求成功|501&选择器已存在|502&选择器不存在|503&参数错误|504&未知的错误', 0, '2022-12-19 14:00:32'),
(39, '二维码生成', '二维码生成', 'qrcode', 1, '/res/temp/qrcode.png', 'image', 'data&string&返回数据', '?text=so you will be like them abandon me?&frame=2&size=200&e=L', 'GET', 'text&是&string&文字内容|frame&是&number&二维码白色边框大小|size&是&number&二维码大小(像素)|e&是&string&选填L,M,Q,H', NULL, '501&fail:', 0, '2022-12-19 14:03:36'),
(40, 'COS图', 'COS图', 'cosimg', 0, '/res/temp/cosimg.jpg', 'image', '', '', 'GET', '', NULL, '', 0, '2022-12-21 13:29:24'),
(79, 'Bili昵称和头像获取', '获取睿站用户的昵称和头像', 'biliget', 1, '{\n	\"code\": 500,\n	\"message\": \"success\",\n	\"data\": {\n		\"imgurl\": \"https://i1.hdslb.com/bfs/face/34c5b30a990c7ce4a809626d8153fa7895ec7b63.gif\",\n		\"name\": \"bishi\"\n	}\n}', 'application/json', 'imgurl&string&头像图片直链|name&string&昵称', '?uid=1', 'GET/POST', 'uid&是&number&用户UID', NULL, '500&success|501&error', 0, '2023-01-15 03:56:18'),
(82, 'IP签名档', '糊狸重制版,11个不同角色风格', 'ipcard', 1, '/res/temp/ipcard.gif', 'image', '', '', 'GET', 'img&否&number&选择角色,1~11,1古河渚 2香风智乃 3立华奏 4亚托莉 5神户小鸟 6夜羽真白 7初音未来 8博丽灵梦 9枣铃 10阿尔托莉雅 11宫水三叶,填错或不填则随机', NULL, '', 10, '2023-01-15 15:20:59'),
(83, '必应每日图', '每日一张', 'bing', 1, '/res/temp/bing.jpg', 'image', '', '', 'GET/POST', '', NULL, '', 0, '2023-01-15 15:25:50'),
(84, '圣诞祝福页生成', '网页生成类,Merry Christmas~', 'chr', 1, '', 'text/html', '', '?msg=胡斐勇|Merry Christmas|健健康康，平安喜乐|一定要站在你所热爱的世界里闪闪发光&music=1892513656', 'GET', 'msg&是&string&祝福语录,使用间隔符分行|music&否&number&网易云音乐ID(页面打开时播放)', NULL, '', 0, '2023-01-17 07:49:36'),
(85, '新年祝福生成页', '网页生成类,兔年快乐呀~', 'newyear', 1, '', 'text/html', '', '?title=2023兔年快乐&msg=赵广姚|新年快乐|新的一年里，希望你开心，快乐，健康♥&music=1753961268', 'GET', 'title&是&string&标题|msg&是&string&祝福语,使用间隔符分行|id&否&number&网易云音乐id(打开时播放)', NULL, '', 0, '2023-01-17 07:57:39'),
(86, '星座运势查询', '查星座运势的东西,真的有人信吗?', 'starluck', 1, '{\n	\"code\": 500,\n	\"message\": \"success\",\n	\"data\": {\n		\"name\": \"天蝎座\",\n		\"info\": [\"健康指数：80%\", \"商谈指数：79%\", \"幸运颜色：姜黄色\", \"幸运数字：2\", \"速配星座：天蝎座\", \"短评：被卷入信息流中\"],\n		\"index\": [\"综合运势：整体运势稍有起伏，意志力不坚定，容易受外界的干扰。接收的信息很多，却未必对自己都有用，反而容易在其中随波逐流。生活方面平平淡淡，有时间可以做一些积极向上的安排，寻找充实感。\", \"爱情运势：单身的受大环境影响，或有婚恋观的变化。恋爱中的或有生闷气的情况，要保持沟通。\", \"事业学业：接收第一手信息有利于走在时间前面，但不能反过来被牵着鼻子走，注意筛选分辨。\", \"财富运势：以正财和微薄小财的进账维持日常花销，建议养成记账的习惯，有目标地存一笔钱。\", \"健康运势：宅在一个环境中容易出现负面情绪，建议出门走走，散散心，或是转移注意力。\"]\n	}\n}', 'application/json', 'name&string&星座名字|info&array&星座信息|index&array&星座运势', '?msg=天蝎座', 'GET/POST', 'msg&是&string&星座名,如:天蝎座', NULL, '', 0, '2023-01-17 14:41:00'),
(87, '实时卫星图', '数据来源于国家气象卫星局', 'starpic', 1, '/res/temp/starpic.jpg', 'image', '', '?type=0', 'GET', 'type&否&number&填0返回实时地球卫星图,填1则返回实时中国卫星图,默认0', NULL, '', 0, '2023-01-17 14:43:10'),
(88, 'B站查成分小助手', '原本是三相+V的油猴脚本,但这次是API接口版', 'component', 0, '{\"code\":500,\"message\":\"success\",\"data\":{\"tag\":[\"棺材板\",\"骑士团\",\"公主\",\"【 隐藏 | 动态抽奖】\"],\"color\":[\"#C0C0C0\",\"#00CC99\",\"#CCFF99\",\"#254680\"]}}', 'application/json', 'tag&array&相关标签|color&array&标签对应颜色16进制值', '?uid=2&format=json', 'GET/POST', 'uid&是&number&查询的b站用户UID|format&否&string&返回方式,默认json,可选html', NULL, '', 0, '2023-01-17 14:46:34'),
(89, '照妖镜', '经典:偷窥偷拍必备', 'mirror', 1, '', 'text/html', '', '?op=query&id=1&url=http://baidu.com', 'GET/POST', 'op&否&string&GET请求下:选填,query查询图片,否则为拍照|id&是&number&查询ID|url&否&string&拍照时为必填,跳转链接|page&否&number&查询时为必填,页数|img&否&base64&POST请求下可用且必填,待上传的图片数据', '', '', 0, '2023-03-04 03:30:32'),
(90, '中国疫情查询', '中国疫情查询', 'covid', 1, '{\"code\":500,\"message\":\"success\",\"data\":{\"city\":\"北京\",\"nowDiagnosed\":28389,\"nowDeath\":20,\"nowCure\":16762,\"updateTime\":\"3月4日11时01分\"}}', 'application/json', 'city&string&查询地区|nowDiagnosed&number&目前确诊|nowDeath&number&目前死亡|nowCure&number&目前治愈|updateTime&string&更新时间', '?msg=北京&format=json', 'GET/POST', 'msg&是&string&查询地区|format&否&string&返回类型,默认json,选填json或text', NULL, '500&success|501&error', 0, '2023-03-04 04:10:34'),
(91, '社工查询接口集合', '支持邮箱,QQ号,LOL,手机号,身份证', 'sed', 1, '{\"code\":500,\"message\":\"success\",\"takeTime\":2.4121599197387695,\"count\":3,\"data\":{\"qq\":\"2857262080\",\"phone\":\"17373522664\",\"location\":\"湖南省郴州市电信\"}}', 'application/json', 'takeTime&number&花费时间,单位:s|count&number&数据量|phone&string&手机号|location&string&运营商|id&string&LOLid|area&string&LOL区域|qq&string&QQ号', '?msg=2857262080&format=json', 'GET/POST', 'msg&是&string&查询值,支持邮箱,QQ号,LOL,手机号,身份证|format&否&string&返回格式,选填json或text,默认json', NULL, '500&success|501&error', 15, '2023-04-28 10:48:31'),
(92, '卖家秀图片', '卖家秀图片', 'sellerimg', 1, '/res/temp/sellerimg.jpg', 'image', '', '', 'GET', '', NULL, '', 0, '2023-04-28 16:35:35');

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_apikey`
--

CREATE TABLE `huliapi_apikey` (
  `id` int(11) UNSIGNED NOT NULL,
  `account` int(11) DEFAULT NULL,
  `api` varchar(255) DEFAULT NULL,
  `apikey` varchar(255) DEFAULT NULL,
  `ctime` timestamp NULL DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- 表的结构 `huliapi_lib_stat`
--

CREATE TABLE `huliapi_lib_stat` (
  `id` int(11) UNSIGNED NOT NULL,
  `sign` varchar(255) DEFAULT NULL,
  `result` int(11) DEFAULT NULL,
  `type_` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `huliapi_lib_stat`
--

INSERT INTO `huliapi_lib_stat` (`id`, `sign`, `result`, `type_`) VALUES
(1, 'webjump_inside', 0, 'total'),
(2, 'webjump_inside', 0, '2023_04_30'),
(3, 'homepage_inside', 0, 'total'),
(4, 'homepage_inside', 0, '2023_04_30'),
(5, 'confession_inside', 0, 'total'),
(6, 'confession_inside', 0, '2023_04_30'),
(7, 'downloadpage_inside', 0, 'total'),
(8, 'downloadpage_inside', 0, '2023_04_30'),
(9, 'lasttime_inside', 0, 'total'),
(10, 'lasttime_inside', 0, '2023_04_30'),
(11, 'sexart_inside', 318, 'total'),
(12, 'sexart_inside', 0, '2023_04_30'),
(13, 'uuidget_inside', 146, 'total'),
(14, 'uuidget_inside', 11, '2023_04_30'),
(15, 'lunar_inside', 131, 'total'),
(16, 'lunar_inside', 15, '2023_04_30'),
(17, 'words_inside', 3161, 'total'),
(18, 'words_inside', 2, '2023_04_30'),
(19, 'fanyi_inside', 70, 'total'),
(20, 'fanyi_inside', 0, '2023_04_30'),
(21, 'base64_inside', 57, 'total'),
(22, 'base64_inside', 0, '2023_04_30'),
(23, 'beautyimg_inside', 67, 'total'),
(24, 'beautyimg_inside', 0, '2023_04_30'),
(25, 'animeimg_inside', 87, 'total'),
(26, 'animeimg_inside', 0, '2023_04_30'),
(27, 'weather_inside', 55, 'total'),
(28, 'weather_inside', 0, '2023_04_30'),
(29, 'webtool_inside', 131, 'total'),
(30, 'webtool_inside', 0, '2023_04_30'),
(31, 'riddle_inside', 86, 'total'),
(32, 'riddle_inside', 0, '2023_04_30'),
(33, 'qqget_inside', 64, 'total'),
(34, 'qqget_inside', 0, '2023_04_30'),
(35, 'nemusic_inside', 218, 'total'),
(36, 'nemusic_inside', 0, '2023_04_30'),
(37, 'motdpe_inside', 274, 'total'),
(38, 'motdpe_inside', 0, '2023_04_30'),
(39, 'nemusicdl_inside', 248, 'total'),
(40, 'nemusicdl_inside', 0, '2023_04_30'),
(41, 'hitokoto_ialapi_inside', 0, 'total'),
(42, 'hitokoto_ialapi_inside', 0, '2023_04_30'),
(43, 'index_hcb_inside', 0, 'total'),
(44, 'index_hcb_inside', 0, '2023_04_30'),
(45, 'seimg_ialapi_inside', 0, 'total'),
(46, 'seimg_ialapi_inside', 0, '2023_04_30'),
(47, 'getbilianime_inside', 84, 'total'),
(48, 'getbilianime_inside', 0, '2023_04_30'),
(49, 'idcard_inside', 313, 'total'),
(50, 'idcard_inside', 0, '2023_04_30'),
(51, 'timecal_inside', 12, 'total'),
(52, 'timecal_inside', 0, '2023_04_30'),
(53, 'diction_inside', 26, 'total'),
(54, 'diction_inside', 0, '2023_04_30'),
(55, 'reading_inside', 30, 'total'),
(56, 'reading_inside', 0, '2023_04_30'),
(57, 'chat_inside', 491, 'total'),
(58, 'chat_inside', 0, '2023_04_30'),
(59, 'sedimg_inside', 10066, 'total'),
(60, 'sedimg_inside', 0, '2023_04_30'),
(61, 'sisters_inside', 90, 'total'),
(62, 'sisters_inside', 0, '2023_04_30'),
(63, 'wall_inside', 44, 'total'),
(64, 'wall_inside', 0, '2023_04_30'),
(65, '60s_inside', 75, 'total'),
(66, '60s_inside', 0, '2023_04_30'),
(67, 'storytoday_inside', 33, 'total'),
(68, 'storytoday_inside', 0, '2023_04_30'),
(69, 'nameidcard_inside', 79, 'total'),
(70, 'nameidcard_inside', 0, '2023_04_30'),
(71, 'biligetv_inside', 66, 'total'),
(72, 'biligetv_inside', 0, '2023_04_30'),
(73, 'bilidlv_inside', 99, 'total'),
(74, 'bilidlv_inside', 0, '2023_04_30'),
(75, 'stat_inside', 261145, 'total'),
(76, 'stat_inside', 79, '2023_04_30'),
(77, 'qrcode_inside', 104, 'total'),
(78, 'qrcode_inside', 0, '2023_04_30'),
(79, 'cosimg_inside', 221, 'total'),
(80, 'cosimg_inside', 0, '2023_04_30'),
(81, 'biliget_inside', 117, 'total'),
(82, 'biliget_inside', 0, '2023_04_30'),
(83, 'ipcard_inside', 734, 'total'),
(84, 'ipcard_inside', 0, '2023_04_30'),
(85, 'bing_inside', 42, 'total'),
(86, 'bing_inside', 0, '2023_04_30'),
(87, 'chr_inside', 0, 'total'),
(88, 'chr_inside', 0, '2023_04_30'),
(89, 'newyear_inside', 0, 'total'),
(90, 'newyear_inside', 0, '2023_04_30'),
(91, 'starluck_inside', 26, 'total'),
(92, 'starluck_inside', 0, '2023_04_30'),
(93, 'starpic_inside', 29, 'total'),
(94, 'starpic_inside', 0, '2023_04_30'),
(95, 'component_inside', 337, 'total'),
(96, 'component_inside', 0, '2023_04_30'),
(97, 'mirror_inside', 0, 'total'),
(98, 'mirror_inside', 0, '2023_04_30'),
(99, 'covid_inside', 8, 'total'),
(100, 'covid_inside', 0, '2023_04_30'),
(101, 'sed_inside', 342, 'total'),
(102, 'sed_inside', 0, '2023_04_30'),
(103, 'sellerimg_inside', 42, 'total'),
(104, 'sellerimg_inside', 0, '2023_04_30'),
(105, 'api_call_inside', 261364, 'total'),
(106, 'api_call_inside', 76, '2023_04_29'),
(107, 'api_call_inside', 56, '2023_04_28'),
(108, 'api_call_inside', 22, '2023_04_27'),
(109, 'api_call_inside', 38, '2023_04_26'),
(110, 'api_call_inside', 48, '2023_04_25'),
(111, 'api_call_inside', 23, '2023_04_24'),
(112, 'api_call_inside', 77, '2023_04_23'),
(113, 'api_call_inside', 17, '2023_04_30'),
(114, 'stat_inside_inside', 8, '2023_05_01'),
(115, 'web_visitor_inside', 5678, 'total'),
(116, 'web_visitor_inside', 108, '2023_04_30'),
(117, 'web_visitor_inside', 134, '2023_04_29'),
(118, 'web_visitor_inside', 104, '2023_04_28'),
(119, 'web_visitor_inside', 432, '2023_04_27'),
(120, 'web_visit_inside', 123616, 'total'),
(121, 'web_visit_inside', 111, '2023_04_29'),
(122, 'hitokoto_ialapi', 6237, 'total'),
(123, 'hitokoto_ialapi', 140, '2023_04_30'),
(124, 'seimg_ialapi', 83142, 'total'),
(125, 'seimg_ialapi', 103, '2023_04_30'),
(126, 'index_hcb', 114, 'total'),
(127, 'index_hcb', 19, '2023_04_30'),
(128, 'lunar_inside', 11, '2023_05_01'),
(129, 'api_call_inside', 135, '2023_05_01'),
(130, 'web_visit_inside', 52, '2023_05_01'),
(131, 'web_visitor_inside', 1, '2023_05_01'),
(132, 'stat_inside', 34, '2023_05_01'),
(133, '60s_inside', 1, '2023_05_01'),
(134, 'ipcard_inside', 4, '2023_05_01'),
(135, 'wall_inside', 2, '2023_05_01'),
(136, 'user_1:starluck_inside', 0, 'total'),
(137, 'user_1:bing_inside', 2, 'total'),
(138, 'sed_inside', 3, '2023_05_01'),
(139, 'bing_inside', 17, '2023_05_01'),
(140, 'user_1:bing_inside', 2, '2023_05_01'),
(141, 'component_inside', 3, '2023_05_01'),
(142, 'user_8:starluck_inside', 6, 'total'),
(143, 'starluck_inside', 7, '2023_05_01'),
(144, 'user_8:starluck_inside', 6, '2023_05_01'),
(145, 'user_8:sellerimg_inside', 5, 'total'),
(146, 'user_8:total', 6, 'total'),
(147, 'user_8:total', 1, '2023_05_01'),
(148, 'user_1:starpic_inside', 1, 'total'),
(149, 'user_1:total', 4, 'total'),
(150, 'qrcode_inside', 68, '2023_05_01'),
(151, 'riddle_inside', 14, '2023_05_01'),
(152, 'web_visitor_inside', 2, '2023_05_02'),
(153, 'web_visit_inside', 14, '2023_05_02'),
(154, 'sellerimg_inside', 20, '2023_05_02'),
(155, 'api_call_inside', 20, '2023_05_02'),
(156, 'user_8:total', 5, '2023_05_02'),
(157, 'user_8:sellerimg_inside', 5, '2023_05_02'),
(158, 'web_visit_inside', 36, '2023_05_03'),
(159, 'web_visitor_inside', 23, '2023_05_03'),
(160, 'stat_inside', 11, '2023_05_03'),
(161, 'hitokoto_ialapi', 3, '2023_05_03'),
(162, 'api_call_inside', 4, '2023_05_03'),
(163, 'component_inside', 1, '2023_05_03'),
(164, 'web_visitor_inside', 49, '2023_05_04'),
(165, 'web_visit_inside', 17, '2023_05_04'),
(166, 'stat_inside', 17, '2023_05_04'),
(167, 'seimg_ialapi', 3, '2023_05_04'),
(168, 'api_call_inside', 10, '2023_05_04'),
(169, 'component_inside', 3, '2023_05_04'),
(170, 'hitokoto_ialapi', 4, '2023_05_04'),
(171, 'web_visitor_inside', 49, '2023_05_05'),
(172, 'stat_inside', 22, '2023_05_05'),
(173, 'seimg_ialapi', 8, '2023_05_05'),
(174, 'api_call_inside', 22, '2023_05_05'),
(175, 'web_visit_inside', 8, '2023_05_05'),
(176, 'hitokoto_ialapi', 14, '2023_05_05'),
(177, 'web_visitor_inside', 12, '2023_05_06'),
(178, 'stat_inside', 6, '2023_05_06'),
(179, 'hitokoto_ialapi', 3, '2023_05_06'),
(180, 'api_call_inside', 6, '2023_05_06'),
(181, 'web_visit_inside', 5, '2023_05_06'),
(182, 'seimg_ialapi', 3, '2023_05_06'),
(183, 'web_visitor_inside', 104, '2023_05_07'),
(184, 'stat_inside', 38, '2023_05_07'),
(185, 'hitokoto_ialapi', 23, '2023_05_07'),
(186, 'api_call_inside', 35, '2023_05_07'),
(187, 'web_visit_inside', 46, '2023_05_07'),
(188, 'seimg_ialapi', 9, '2023_05_07'),
(189, 'words_inside', 3, '2023_05_07'),
(190, 'web_visitor_inside', 105, '2023_05_08'),
(191, 'web_visit_inside', 36, '2023_05_08'),
(192, 'stat_inside', 28, '2023_05_08'),
(193, 'hitokoto_ialapi', 7, '2023_05_08'),
(194, 'api_call_inside', 43, '2023_05_08'),
(195, 'words_inside', 1, '2023_05_08'),
(196, 'sed_inside', 19, '2023_05_08'),
(197, 'idcard_inside', 9, '2023_05_08'),
(198, 'getbilianime_inside', 5, '2023_05_08'),
(199, 'seimg_ialapi', 2, '2023_05_08'),
(200, 'web_visitor_inside', 50, '2023_05_09'),
(201, 'stat_inside', 20, '2023_05_09'),
(202, 'hitokoto_ialapi', 10, '2023_05_09'),
(203, 'api_call_inside', 29, '2023_05_09'),
(204, 'seimg_ialapi', 1, '2023_05_09'),
(205, 'web_visit_inside', 14, '2023_05_09'),
(206, 'sed_inside', 9, '2023_05_09'),
(207, 'idcard_inside', 9, '2023_05_09'),
(208, 'web_visitor_inside', 64, '2023_05_10'),
(209, 'stat_inside', 19, '2023_05_10'),
(210, 'hitokoto_ialapi', 5, '2023_05_10'),
(211, 'api_call_inside', 20, '2023_05_10'),
(212, 'web_visit_inside', 15, '2023_05_10'),
(213, 'words_inside', 1, '2023_05_10'),
(214, 'seimg_ialapi', 14, '2023_05_10'),
(215, 'web_visitor_inside', 74, '2023_05_11'),
(216, 'stat_inside', 19, '2023_05_11'),
(217, 'hitokoto_ialapi', 18, '2023_05_11'),
(218, 'api_call_inside', 19, '2023_05_11'),
(219, 'web_visit_inside', 9, '2023_05_11'),
(220, 'seimg_ialapi', 1, '2023_05_11'),
(221, 'web_visitor_inside', 70, '2023_05_12'),
(222, 'stat_inside', 7, '2023_05_12'),
(223, 'hitokoto_ialapi', 7, '2023_05_12'),
(224, 'api_call_inside', 7, '2023_05_12'),
(225, 'web_visit_inside', 13, '2023_05_12'),
(226, 'web_visitor_inside', 109, '2023_05_13'),
(227, 'web_visit_inside', 30, '2023_05_13'),
(228, 'stat_inside', 36, '2023_05_13'),
(229, 'hitokoto_ialapi', 7, '2023_05_13'),
(230, 'api_call_inside', 27, '2023_05_13'),
(231, 'seimg_ialapi', 17, '2023_05_13'),
(232, 'motdpe_inside', 3, '2023_05_13'),
(233, 'web_visitor_inside', 94, '2023_05_14'),
(234, 'stat_inside', 24, '2023_05_14'),
(235, 'hitokoto_ialapi', 7, '2023_05_14'),
(236, 'api_call_inside', 19, '2023_05_14'),
(237, 'web_visit_inside', 64, '2023_05_14'),
(238, 'seimg_ialapi', 12, '2023_05_14'),
(239, 'web_visitor_inside', 143, '2023_05_15'),
(240, 'stat_inside', 68, '2023_05_15'),
(241, 'hitokoto_ialapi', 16, '2023_05_15'),
(242, 'api_call_inside', 63, '2023_05_15'),
(243, 'web_visit_inside', 88, '2023_05_15'),
(244, 'seimg_ialapi', 44, '2023_05_15'),
(245, 'motdpe_inside', 3, '2023_05_15'),
(246, 'web_visitor_inside', 168, '2023_05_16'),
(247, 'stat_inside', 73, '2023_05_16'),
(248, 'hitokoto_ialapi', 37, '2023_05_16'),
(249, 'api_call_inside', 55, '2023_05_16'),
(250, 'web_visit_inside', 74, '2023_05_16'),
(251, 'index_hcb', 1, '2023_05_16'),
(252, 'sed_inside', 1, '2023_05_16'),
(253, 'biligetv_inside', 1, '2023_05_16'),
(254, 'bilidlv_inside', 1, '2023_05_16'),
(255, 'seimg_ialapi', 14, '2023_05_16'),
(256, 'web_visitor_inside', 45, '2023_05_17'),
(257, 'stat_inside', 15, '2023_05_17'),
(258, 'hitokoto_ialapi', 15, '2023_05_17'),
(259, 'api_call_inside', 15, '2023_05_17'),
(260, 'web_visit_inside', 19, '2023_05_17'),
(261, 'web_visitor_inside', 253, '2023_05_18'),
(262, 'stat_inside', 43, '2023_05_18'),
(263, 'hitokoto_ialapi', 40, '2023_05_18'),
(264, 'api_call_inside', 122, '2023_05_18'),
(265, 'web_visit_inside', 53, '2023_05_18'),
(266, 'diction_inside', 2, '2023_05_18'),
(267, 'component_inside', 3, '2023_05_18'),
(268, 'bing_inside', 6, '2023_05_18'),
(269, 'chat_inside', 4, '2023_05_18'),
(270, 'sexart_inside', 9, '2023_05_18'),
(271, 'sellerimg_inside', 3, '2023_05_18'),
(272, 'covid_inside', 1, '2023_05_18'),
(273, 'starpic_inside', 2, '2023_05_18'),
(274, 'starluck_inside', 1, '2023_05_18'),
(275, 'qrcode_inside', 1, '2023_05_18'),
(276, 'storytoday_inside', 2, '2023_05_18'),
(277, 'user_1:60s_inside', 3, 'total'),
(278, '60s_inside', 4, '2023_05_18'),
(279, 'user_1:total', 1, '2023_05_18'),
(280, 'user_1:60s_inside', 1, '2023_05_18'),
(281, 'sedimg_inside', 1, '2023_05_18'),
(282, 'fanyi_inside', 3, '2023_05_18'),
(283, 'words_inside', 14, '2023_05_18'),
(284, 'wall_inside', 1, '2023_05_18'),
(285, 'weather_inside', 2, '2023_05_18'),
(286, 'motdpe_inside', 2, '2023_05_18'),
(287, 'sed_inside', 2, '2023_05_18'),
(288, 'idcard_inside', 3, '2023_05_18'),
(289, 'webtool_inside', 2, '2023_05_18'),
(290, 'qqget_inside', 2, '2023_05_18'),
(291, 'nameidcard_inside', 2, '2023_05_18'),
(292, 'riddle_inside', 1, '2023_05_18'),
(293, 'getbilianime_inside', 1, '2023_05_18'),
(294, 'bilidlv_inside', 1, '2023_05_18'),
(295, 'nemusicdl_inside', 2, '2023_05_18'),
(296, 'reading_inside', 2, '2023_05_18'),
(297, 'biliget_inside', 1, '2023_05_18'),
(298, 'timecal_inside', 1, '2023_05_18'),
(299, 'seimg_ialapi', 1, '2023_05_18'),
(300, 'web_visit_inside', 28, '2023_05_19'),
(301, 'web_visitor_inside', 77, '2023_05_19'),
(302, 'stat_inside', 25, '2023_05_19'),
(303, 'hitokoto_ialapi', 10, '2023_05_19'),
(304, 'api_call_inside', 26, '2023_05_19'),
(305, 'webtool_inside', 1, '2023_05_19'),
(306, 'seimg_ialapi', 15, '2023_05_19'),
(307, 'web_visitor_inside', 54, '2023_05_20'),
(308, 'stat_inside', 30, '2023_05_20'),
(309, 'hitokoto_ialapi', 11, '2023_05_20'),
(310, 'api_call_inside', 34, '2023_05_20'),
(311, 'seimg_ialapi', 19, '2023_05_20'),
(312, 'web_visit_inside', 14, '2023_05_20'),
(313, 'webtool_inside', 1, '2023_05_20'),
(314, 'motdpe_inside', 3, '2023_05_20'),
(315, 'web_visitor_inside', 390, '2023_05_21'),
(316, 'stat_inside', 94, '2023_05_21'),
(317, 'hitokoto_ialapi', 19, '2023_05_21'),
(318, 'api_call_inside', 30, '2023_05_21'),
(319, 'web_visit_inside', 53, '2023_05_21'),
(320, 'starpic_inside', 1, '2023_05_21'),
(321, 'seimg_ialapi', 7, '2023_05_21'),
(322, 'ipcard_inside', 1, '2023_05_21'),
(323, 'bilidlv_inside', 1, '2023_05_21'),
(324, 'biligetv_inside', 1, '2023_05_21'),
(325, 'web_visitor_inside', 223, '2023_05_22'),
(326, 'stat_inside', 19, '2023_05_22'),
(327, 'hitokoto_ialapi', 18, '2023_05_22'),
(328, 'api_call_inside', 37, '2023_05_22'),
(329, 'web_visit_inside', 31, '2023_05_22'),
(330, 'motdpe_inside', 14, '2023_05_22'),
(331, 'uuidget_inside', 1, '2023_05_22'),
(332, 'component_inside', 1, '2023_05_22'),
(333, 'sed_inside', 1, '2023_05_22'),
(334, 'idcard_inside', 1, '2023_05_22'),
(335, 'nemusic_inside', 1, '2023_05_22'),
(336, 'web_visitor_inside', 81, '2023_05_23'),
(337, 'stat_inside', 8, '2023_05_23'),
(338, 'hitokoto_ialapi', 7, '2023_05_23'),
(339, 'api_call_inside', 13, '2023_05_23'),
(340, 'motdpe_inside', 5, '2023_05_23'),
(341, 'web_visit_inside', 27, '2023_05_23'),
(342, 'seimg_ialapi', 1, '2023_05_23'),
(343, 'web_visitor_inside', 77, '2023_05_24'),
(344, 'motdpe_inside', 3, '2023_05_24'),
(345, 'api_call_inside', 13, '2023_05_24'),
(346, 'web_visit_inside', 34, '2023_05_24'),
(347, 'stat_inside', 9, '2023_05_24'),
(348, 'hitokoto_ialapi', 9, '2023_05_24'),
(349, 'sexart_inside', 1, '2023_05_24'),
(350, 'web_visitor_inside', 132, '2023_05_25'),
(351, 'web_visit_inside', 54, '2023_05_25'),
(352, 'sed_inside', 12, '2023_05_25'),
(353, 'api_call_inside', 57, '2023_05_25'),
(354, 'stat_inside', 49, '2023_05_25'),
(355, 'idcard_inside', 4, '2023_05_25'),
(356, 'motdpe_inside', 3, '2023_05_25'),
(357, 'hitokoto_ialapi', 20, '2023_05_25'),
(358, 'seimg_ialapi', 17, '2023_05_25'),
(359, 'biligetv_inside', 1, '2023_05_25'),
(360, 'web_visitor_inside', 57, '2023_05_26'),
(361, 'web_visit_inside', 19, '2023_05_26'),
(362, 'stat_inside', 17, '2023_05_26'),
(363, 'hitokoto_ialapi', 11, '2023_05_26'),
(364, 'api_call_inside', 20, '2023_05_26'),
(365, 'diction_inside', 1, '2023_05_26'),
(366, 'motdpe_inside', 2, '2023_05_26'),
(367, 'seimg_ialapi', 6, '2023_05_26'),
(368, 'web_visitor_inside', 77, '2023_05_27'),
(369, 'stat_inside', 27, '2023_05_27'),
(370, 'seimg_ialapi', 16, '2023_05_27'),
(371, 'api_call_inside', 25, '2023_05_27'),
(372, 'web_visit_inside', 11, '2023_05_27'),
(373, 'hitokoto_ialapi', 6, '2023_05_27'),
(374, 'bilidlv_inside', 1, '2023_05_27'),
(375, 'sed_inside', 1, '2023_05_27'),
(376, 'idcard_inside', 1, '2023_05_27'),
(377, 'web_visitor_inside', 38, '2023_05_28'),
(378, 'motdpe_inside', 1, '2023_05_28'),
(379, 'api_call_inside', 14, '2023_05_28'),
(380, 'stat_inside', 13, '2023_05_28'),
(381, 'hitokoto_ialapi', 11, '2023_05_28'),
(382, 'web_visit_inside', 10, '2023_05_28'),
(383, 'seimg_ialapi', 2, '2023_05_28'),
(384, 'web_visitor_inside', 95, '2023_05_29'),
(385, 'web_visit_inside', 10, '2023_05_29'),
(386, 'biliget_inside', 1, '2023_05_29'),
(387, 'api_call_inside', 20, '2023_05_29'),
(388, 'getbilianime_inside', 1, '2023_05_29'),
(389, 'timecal_inside', 1, '2023_05_29'),
(390, 'wall_inside', 1, '2023_05_29'),
(391, 'nemusicdl_inside', 1, '2023_05_29'),
(392, 'uuidget_inside', 1, '2023_05_29'),
(393, 'stat_inside', 13, '2023_05_29'),
(394, 'hitokoto_ialapi', 4, '2023_05_29'),
(395, 'seimg_ialapi', 9, '2023_05_29'),
(396, 'motdpe_inside', 1, '2023_05_29'),
(397, 'web_visit_inside', 29, '2023_05_30'),
(398, 'web_visitor_inside', 72, '2023_05_30'),
(399, 'stat_inside', 14, '2023_05_30'),
(400, 'hitokoto_ialapi', 14, '2023_05_30'),
(401, 'api_call_inside', 19, '2023_05_30'),
(402, 'starluck_inside', 1, '2023_05_30'),
(403, 'motdpe_inside', 4, '2023_05_30'),
(404, 'web_visitor_inside', 77, '2023_05_31'),
(405, 'web_visit_inside', 27, '2023_05_31'),
(406, 'stat_inside', 11, '2023_05_31'),
(407, 'hitokoto_ialapi', 8, '2023_05_31'),
(408, 'api_call_inside', 11, '2023_05_31'),
(409, 'seimg_ialapi', 3, '2023_05_31'),
(410, 'web_visitor_inside', 130, '2023_06_01'),
(411, 'web_visit_inside', 17, '2023_06_01'),
(412, 'stat_inside', 94, '2023_06_01'),
(413, 'seimg_ialapi', 85, '2023_06_01'),
(414, 'api_call_inside', 90, '2023_06_01'),
(415, 'hitokoto_ialapi', 5, '2023_06_01'),
(416, 'web_visitor_inside', 106, '2023_06_02'),
(417, 'stat_inside', 66, '2023_06_02'),
(418, 'hitokoto_ialapi', 8, '2023_06_02'),
(419, 'api_call_inside', 63, '2023_06_02'),
(420, 'web_visit_inside', 54, '2023_06_02'),
(421, 'seimg_ialapi', 54, '2023_06_02'),
(422, 'motdpe_inside', 1, '2023_06_02'),
(423, 'web_visitor_inside', 59, '2023_06_03'),
(424, 'stat_inside', 8, '2023_06_03'),
(425, 'hitokoto_ialapi', 7, '2023_06_03'),
(426, 'api_call_inside', 24, '2023_06_03'),
(427, 'web_visit_inside', 46, '2023_06_03'),
(428, 'words_inside', 16, '2023_06_03'),
(429, 'bing_inside', 1, '2023_06_03'),
(430, 'web_visitor_inside', 170, '2023_06_04'),
(431, 'stat_inside', 119, '2023_06_04'),
(432, 'hitokoto_ialapi', 31, '2023_06_04'),
(433, 'api_call_inside', 78, '2023_06_04'),
(434, 'web_visit_inside', 19, '2023_06_04'),
(435, 'component_inside', 19, '2023_06_04'),
(436, 'bilidlv_inside', 2, '2023_06_04'),
(437, 'biligetv_inside', 4, '2023_06_04'),
(438, 'ipcard_inside', 12, '2023_06_04'),
(439, 'seimg_ialapi', 9, '2023_06_04'),
(440, 'motdpe_inside', 1, '2023_06_04'),
(441, 'web_visitor_inside', 221, '2023_06_05'),
(442, 'stat_inside', 153, '2023_06_05'),
(443, 'seimg_ialapi', 93, '2023_06_05'),
(444, 'api_call_inside', 130, '2023_06_05'),
(445, 'web_visit_inside', 28, '2023_06_05'),
(446, 'biliget_inside', 1, '2023_06_05'),
(447, 'starpic_inside', 1, '2023_06_05'),
(448, 'hitokoto_ialapi', 16, '2023_06_05'),
(449, 'starluck_inside', 1, '2023_06_05'),
(450, 'uuidget_inside', 1, '2023_06_05'),
(451, 'motdpe_inside', 11, '2023_06_05'),
(452, 'ipcard_inside', 6, '2023_06_05'),
(453, 'web_visitor_inside', 88, '2023_06_06'),
(454, 'stat_inside', 52, '2023_06_06'),
(455, 'seimg_ialapi', 34, '2023_06_06'),
(456, 'api_call_inside', 50, '2023_06_06'),
(457, 'web_visit_inside', 15, '2023_06_06'),
(458, 'hitokoto_ialapi', 15, '2023_06_06'),
(459, 'motdpe_inside', 1, '2023_06_06'),
(460, 'web_visitor_inside', 79, '2023_06_07'),
(461, 'web_visit_inside', 24, '2023_06_07'),
(462, 'stat_inside', 22, '2023_06_07'),
(463, 'hitokoto_ialapi', 14, '2023_06_07'),
(464, 'api_call_inside', 16, '2023_06_07'),
(465, 'seimg_ialapi', 2, '2023_06_07'),
(466, 'web_visitor_inside', 69, '2023_06_08'),
(467, 'stat_inside', 20, '2023_06_08'),
(468, 'hitokoto_ialapi', 6, '2023_06_08'),
(469, 'api_call_inside', 25, '2023_06_08'),
(470, 'web_visit_inside', 20, '2023_06_08'),
(471, 'seimg_ialapi', 10, '2023_06_08'),
(472, 'getbilianime_inside', 1, '2023_06_08'),
(473, 'sed_inside', 4, '2023_06_08'),
(474, 'idcard_inside', 4, '2023_06_08'),
(475, 'web_visit_inside', 23, '2023_06_09'),
(476, 'web_visitor_inside', 63, '2023_06_09'),
(477, 'stat_inside', 11, '2023_06_09'),
(478, 'hitokoto_ialapi', 3, '2023_06_09'),
(479, 'api_call_inside', 18, '2023_06_09'),
(480, 'sed_inside', 7, '2023_06_09'),
(481, 'idcard_inside', 7, '2023_06_09'),
(482, 'seimg_ialapi', 1, '2023_06_09'),
(483, 'web_visitor_inside', 59, '2023_06_10'),
(484, 'web_visit_inside', 29, '2023_06_10'),
(485, 'motdpe_inside', 1, '2023_06_10'),
(486, 'api_call_inside', 7, '2023_06_10'),
(487, 'stat_inside', 6, '2023_06_10'),
(488, 'hitokoto_ialapi', 6, '2023_06_10'),
(489, 'web_visitor_inside', 89, '2023_06_11'),
(490, 'web_visit_inside', 43, '2023_06_11'),
(491, 'stat_inside', 14, '2023_06_11'),
(492, 'hitokoto_ialapi', 12, '2023_06_11'),
(493, 'api_call_inside', 15, '2023_06_11'),
(494, 'sed_inside', 1, '2023_06_11'),
(495, 'idcard_inside', 1, '2023_06_11'),
(496, 'seimg_ialapi', 1, '2023_06_11'),
(497, 'web_visitor_inside', 100, '2023_06_12'),
(498, 'web_visit_inside', 37, '2023_06_12'),
(499, 'starpic_inside', 1, '2023_06_12'),
(500, 'api_call_inside', 19, '2023_06_12'),
(501, 'starluck_inside', 1, '2023_06_12'),
(502, 'stat_inside', 14, '2023_06_12'),
(503, 'hitokoto_ialapi', 12, '2023_06_12'),
(504, 'lunar_inside', 1, '2023_06_12'),
(505, 'qrcode_inside', 1, '2023_06_12'),
(506, 'sed_inside', 1, '2023_06_12'),
(507, 'idcard_inside', 1, '2023_06_12'),
(508, 'seimg_ialapi', 1, '2023_06_12'),
(509, 'web_visitor_inside', 112, '2023_06_13'),
(510, 'web_visit_inside', 27, '2023_06_13'),
(511, 'stat_inside', 23, '2023_06_13'),
(512, 'hitokoto_ialapi', 6, '2023_06_13'),
(513, 'api_call_inside', 27, '2023_06_13'),
(514, 'words_inside', 4, '2023_06_13'),
(515, 'seimg_ialapi', 17, '2023_06_13'),
(516, 'web_visitor_inside', 36, '2023_06_14'),
(517, 'stat_inside', 4, '2023_06_14'),
(518, 'hitokoto_ialapi', 3, '2023_06_14'),
(519, 'api_call_inside', 4, '2023_06_14'),
(520, 'web_visit_inside', 11, '2023_06_14'),
(521, 'seimg_ialapi', 1, '2023_06_14'),
(522, 'web_visitor_inside', 60, '2023_06_15'),
(523, 'web_visit_inside', 5, '2023_06_15'),
(524, 'stat_inside', 3, '2023_06_15'),
(525, 'hitokoto_ialapi', 3, '2023_06_15'),
(526, 'api_call_inside', 9, '2023_06_15'),
(527, 'nemusic_inside', 5, '2023_06_15'),
(528, 'motdpe_inside', 1, '2023_06_15'),
(529, 'web_visitor_inside', 196, '2023_06_16'),
(530, 'stat_inside', 158, '2023_06_16'),
(531, 'hitokoto_ialapi', 156, '2023_06_16'),
(532, 'api_call_inside', 161, '2023_06_16'),
(533, 'webtool_inside', 1, '2023_06_16'),
(534, 'web_visit_inside', 34, '2023_06_16'),
(535, 'seimg_ialapi', 2, '2023_06_16'),
(536, 'sed_inside', 2, '2023_06_16'),
(537, 'web_visit_inside', 16, '2023_06_17'),
(538, '60s_inside', 3, '2023_06_17'),
(539, 'api_call_inside', 7, '2023_06_17'),
(540, 'user_1:total', 2, '2023_06_17'),
(541, 'user_1:60s_inside', 2, '2023_06_17'),
(542, 'cosimg_inside', 1, '2023_06_17'),
(543, 'chat_inside', 3, '2023_06_17'),
(544, 'web_visit_inside', 32, '2023_06_18'),
(545, 'user_9:sellerimg_inside', 1, 'total'),
(546, 'user_9:total', 1, 'total'),
(547, 'sellerimg_inside', 1, '2023_06_18'),
(548, 'api_call_inside', 153, '2023_06_18'),
(549, 'user_9:total', 1, '2023_06_18'),
(550, 'user_9:sellerimg_inside', 1, '2023_06_18'),
(551, 'sexart_inside', 2, '2023_06_18'),
(552, 'covid_inside', 1, '2023_06_18'),
(553, 'component_inside', 14, '2023_06_18'),
(554, 'starpic_inside', 3, '2023_06_18'),
(555, 'user_1:total', 1, '2023_06_18'),
(556, 'user_1:starpic_inside', 1, '2023_06_18'),
(557, 'starluck_inside', 1, '2023_06_18'),
(558, 'bing_inside', 1, '2023_06_18'),
(559, 'ipcard_inside', 1, '2023_06_18'),
(560, 'biliget_inside', 9, '2023_06_18'),
(561, 'bilidlv_inside', 2, '2023_06_18'),
(562, 'qrcode_inside', 2, '2023_06_18'),
(563, 'cosimg_inside', 29, '2023_06_18'),
(564, 'biligetv_inside', 2, '2023_06_18'),
(565, 'nameidcard_inside', 1, '2023_06_18'),
(566, 'storytoday_inside', 1, '2023_06_18'),
(567, 'sisters_inside', 29, '2023_06_18'),
(568, 'wall_inside', 1, '2023_06_18'),
(569, 'sedimg_inside', 3, '2023_06_18'),
(570, 'chat_inside', 1, '2023_06_18'),
(571, 'reading_inside', 3, '2023_06_18'),
(572, 'idcard_inside', 1, '2023_06_18'),
(573, 'timecal_inside', 1, '2023_06_18'),
(574, 'diction_inside', 1, '2023_06_18'),
(575, 'getbilianime_inside', 1, '2023_06_18'),
(576, 'nemusicdl_inside', 1, '2023_06_18'),
(577, 'motdpe_inside', 1, '2023_06_18'),
(578, 'riddle_inside', 1, '2023_06_18'),
(579, 'qqget_inside', 1, '2023_06_18'),
(580, 'nemusic_inside', 15, '2023_06_18'),
(581, 'webtool_inside', 11, '2023_06_18'),
(582, 'weather_inside', 1, '2023_06_18'),
(583, 'animeimg_inside', 2, '2023_06_18'),
(584, 'fanyi_inside', 1, '2023_06_18'),
(585, 'base64_inside', 1, '2023_06_18'),
(586, 'beautyimg_inside', 1, '2023_06_18'),
(587, 'words_inside', 3, '2023_06_18'),
(588, 'lunar_inside', 1, '2023_06_18'),
(589, 'uuidget_inside', 2, '2023_06_18');

-- --------------------------------------------------------

--
-- 表的结构 `huliapi_log`
--

CREATE TABLE `huliapi_log` (
  `id` int(11) UNSIGNED NOT NULL,
  `ua` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `request` varchar(10) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- 表的结构 `huliapi_set`
--

CREATE TABLE `huliapi_set` (
  `id` int(6) UNSIGNED NOT NULL,
  `set_key` varchar(100) NOT NULL,
  `set_val` text,
  `set_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `huliapi_set`
--

INSERT INTO `huliapi_set` (`id`, `set_key`, `set_val`, `set_type`) VALUES
(1, 'weburl', 'http://api.imlolicon.tk', 'webinfo'),
(2, 'webtitle', 'HULIAPI', 'webinfo'),
(3, 'websubtitle', 'Interface call platform', 'webinfo'),
(4, 'webdescr', 'The purpose is to provide stable and fast API interface and no bug', 'webinfo'),
(5, 'keywords', 'API,Api call,Interface call platform,call platform,api,Api platform,Api Interface,聚合数据,API数据接口,API,免费接口,免费api接口调用,免费API数据调用', 'webinfo'),
(6, 'author', 'Biyuehu', 'webinfo'),
(7, 'email', 'biyuehuya@gmail.com', 'webinfo'),
(8, 'createTime', '2021-6-19', 'webinfo'),
(9, 'theme', 'default', 'webinfo'),
(43, 'mainColor', 'deepskyblue', 'theme_default'),
(44, 'headUrl', 'Tool,/tool/, 1|Links,/friends|Blog,http://imlolicon.tk,1', 'theme_default'),
(45, 'tips', 'Full use of https!', 'theme_default'),
(46, 'openEjct', '目前糊理API接口正在进行批量售卖！<a href=\"/article/apishop\" target=\"blank\" style=\"color:red\">查看详情</a><br>本站大部分接口为站长糊理原创,站点API管理核心框架为糊理原创的<span style=\"color:aqua\">HULICoe</span>系统,框架遵循<strong>MVC架构</strong>,目前仍在施工中<br><li>接口可用于任何地方(Robot、网站等), 但请勿恶意调用/爬取数据</><br><li>同时也可以玩玩<a href=\"/tool/\" target=\"_blank\" style=\"color:blue\">本站小工具</a>, 玩累了就来<a href=\"https://imlolicon.tk\" target=\"_blank\">糊理博客</a>坐一坐~</li>', 'theme_default'),
(47, 'openRoll', 'Donot <a style=\"color:red\" target=\"_blank\" href=\"https://imlolicon.tk/sponsor\">【Sponsor】</a> lovely fox？', 'theme_default'),
(48, 'advert', '', 'theme_default'),
(49, 'bottom1', '<div style=\"color:lightgreen\">首先，少TMD的说这是由别人模板搭的网站，API站模板到处都是我很清楚，但鄙站顶多套用了一下前端页面(写不出好看页面的屑)，但也已魔改了多次。后台管理和API核心系统框架完全为自己开发，目前仍在施工中，彻底做完后会开源</div>', 'theme_default'),
(50, 'bottom2', '<div style=\"color:red\">网站开发/维护/运营均由糊狸一人，已经快精尽人亡啦~</div>', 'theme_default'),
(51, 'codeHead', '<script>\nvar _hmt = _hmt || [];\n(function() {\n  var hm = document.createElement(\"script\");\n  hm.src = \"https://hm.baidu.com/hm.js?22fedf29970478cc0e2fd92472da07be\";\n  var s = document.getElementsByTagName(\"script\")[0]; \n  s.parentNode.insertBefore(hm, s);\n})();\n</script>\n', 'theme_default'),
(52, 'codeFoot', '<!-- 播放器 -->\n<!---\n<script src=\"//cdn.bootcss.com/jquery/1.11.1/jquery.min.js\"></script>\n<script src=\"//myhkw.cn/api/player/1624181502117\" id=\"myhk\" key=\"1624181502117\" m=\"1\"></script>\n--->', 'theme_default'),
(53, 'friends', 'http://imlolicon.tk,BiyuehuBlog,糊狸的小破站,https://imlolicon.tk/favicon.ico|http://hcb.imlolicon.tk,HCB云黑,秉承着公正、公开两项原则,https://biyuehu.github.io/ico/hcb.ico', 'theme_default'),
(54, 'host', '', 'plugins_email'),
(55, 'port', '', 'plugins_email'),
(56, 'username', '', 'plugins_email'),
(57, 'password', '', 'plugins_email'),
(58, 'fromuser', '', 'plugins_email'),
(60, 'fromname', '', 'plugins_email'),
(61, 'crossdomain', 'on', 'websafe'),
(62, 'cycle', '60', 'websafe'),
(63, 'cyclenum', '17', 'websafe'),
(64, 'refusemsg', '调用过于频繁请稍后再试', 'websafe'),
(65, 'badapimsg', '你访问的接口正在维护中,糊狸被玩坏啦呜呜呜呜呜', 'websafe'),
(66, 'safeimport', 'nagisa', 'websafe'),
(67, 'accentColor', 'orangered', 'theme_default'),
(68, 'log', '111111111', 'webinfo'),
(69, 'useropen', '金额充值、接口报错修复、使用问题、各种建议等相关业务请联系站长邮箱:biyuehuya@gmail.com，并提供具体信息，请勿发送垃圾邮件<br>\n使用步骤:<br>\n充值->”接口商店“页面购买需要的接口->\"接口列表\"页面查看已拥有的接口并获取<strong>【apikey】</strong><br>\n每次购买固定为一个月期限，到期后才可续费', 'webinfo'),
(70, 'startcoin', '100', 'webinfo');

--
-- 转储表的索引
--

--
-- 表的索引 `huliapi_account`
--
ALTER TABLE `huliapi_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adminname` (`name`,`email`);

--
-- 表的索引 `huliapi_api`
--
ALTER TABLE `huliapi_api`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`,`idstr`);

--
-- 表的索引 `huliapi_apikey`
--
ALTER TABLE `huliapi_apikey`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `huliapi_lib_stat`
--
ALTER TABLE `huliapi_lib_stat`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `huliapi_log`
--
ALTER TABLE `huliapi_log`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `huliapi_set`
--
ALTER TABLE `huliapi_set`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `huliapi_account`
--
ALTER TABLE `huliapi_account`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `huliapi_api`
--
ALTER TABLE `huliapi_api`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- 使用表AUTO_INCREMENT `huliapi_apikey`
--
ALTER TABLE `huliapi_apikey`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `huliapi_lib_stat`
--
ALTER TABLE `huliapi_lib_stat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=590;

--
-- 使用表AUTO_INCREMENT `huliapi_log`
--
ALTER TABLE `huliapi_log`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40111;

--
-- 使用表AUTO_INCREMENT `huliapi_set`
--
ALTER TABLE `huliapi_set`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
