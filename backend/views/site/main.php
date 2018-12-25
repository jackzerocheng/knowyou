<?php
use yii\helpers\Url;
?>
<body class="childrenBody">
<div class="panel_box row">
    <div class="panel col">
        <a href="javascript:;" data-url="page/message/message.html">
            <div class="panel_icon">
                <i class="layui-icon" data-icon="&#xe63a;">&#xe63a;</i>
            </div>
            <div class="panel_word newMessage">
                <span><?=$count_number['today_message_number'] ?></span>
                <cite>今日留言</cite>
            </div>
        </a>
    </div>
    <div class="panel col">
        <a href="javascript:;" data-url="page/user/allUsers.html">
            <div class="panel_icon" style="background-color:#FF5722;">
                <i class="iconfont icon-dongtaifensishu" data-icon="icon-dongtaifensishu"></i>
            </div>
            <div class="panel_word userAll">
                <span><?=$count_number['today_new_user_number'] ?></span>
                <cite>今日注册用户</cite>
            </div>
        </a>
    </div>
    <div class="panel col">
        <a href="javascript:;" data-url="page/user/allUsers.html">
            <div class="panel_icon" style="background-color:#009688;">
                <i class="layui-icon" data-icon="&#xe613;">&#xe613;</i>
            </div>
            <div class="panel_word userAll">
                <span><?=$count_number['all_user_number'] ?></span>
                <cite>用户总数</cite>
            </div>
        </a>
    </div>
    <!--
    <div class="panel col">
        <a href="javascript:;" data-url="page/img/images.html">
            <div class="panel_icon" style="background-color:#5FB878;">
                <i class="layui-icon" data-icon="&#xe64a;">&#xe64a;</i>
            </div>
            <div class="panel_word imgAll">
                <span>222</span>
                <cite>图片总数</cite>
            </div>
        </a>
    </div>
    -->
    <div class="panel col">
        <a href="javascript:;" data-url="page/news/newsList.html">
            <div class="panel_icon" style="background-color:#F7B824;">
                <i class="iconfont icon-wenben" data-icon="icon-wenben"></i>
            </div>
            <div class="panel_word waitNews">
                <span><?=$count_number['today_article_number'] ?></span>
                <cite>今日文章</cite>
            </div>
        </a>
    </div>
    <div class="panel col max_panel">
        <a href="javascript:;" data-url="page/news/newsList.html">
            <div class="panel_icon" style="background-color:#2F4056;">
                <i class="iconfont icon-text" data-icon="icon-text"></i>
            </div>
            <div class="panel_word allNews">
                <span><?=$count_number['all_article_number'] ?></span>
                <em>文章总数</em>
                <cite>文章列表</cite>
            </div>
        </a>
    </div>
</div>
<blockquote class="layui-elem-quote explain">
    <p>本模板基于Layui 1.0.9实现，支持除LayIM外所有的Layui组件。<a href="http://layim.layui.com/" target="_blank" class="layui-btn layui-btn-mini">前往获取LayIM授权</a><a href="https://git.oschina.net/layuicms/layuicms" target="_blank" class="layui-btn layui-btn-mini layui-btn-danger">码云下载</a><a href="https://github.com/BrotherMa/layuiCMS" target="_blank" class="layui-btn layui-btn-mini layui-btn-danger">GitHub下载</a>　<span style="color:#1E9FFF;">郑重提示：网站所有数据均为静态数据，无数据库，除打开的窗口和部分小改动外所有操作刷新后无效，关闭窗口或清除缓存后，所有操作无效，请知悉</span></p>
    <p>开发文档地址：<a class="layui-btn layui-btn-mini" target="_blank" href="http://www.layui.com/doc">点此跳转</a> <a class="layui-btn layui-btn-mini layui-btn-danger" target="_blank" href="http://fly.layui.com/case/u/3198216">我要点赞</a>　<span style="color:#f00;">注：本框架未引入任何第三方组件（天气信息除外），单纯的layui+js实现的各种功能【本框架仅作为学习交流使用，如需用作商业用途，请联系作者授权，谢谢】</span></p>
    <p>技术交流QQ群：<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=8b7dd3ea73528c1e46c5d4e522426d60deed355caefdf481c1eacdd1b7b73bfd"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="layui后台管理模版cms" title="layuicms后台管理模版"></a>（添加时请注明来自本框架）【layuicms 2.0正在加速开发中】</p>
</blockquote>
<div class="row">
    <div class="sysNotice col">
        <blockquote class="layui-elem-quote title">更新日志</blockquote>
        <div class="layui-elem-quote layui-quote-nm">
            <h3># v1.0.1（优化） - 2017-06-25</h3>
            <p>* 修改刚进入页面无任何操作时按回车键提示“请输入解锁密码！”</p>
            <p>* 优化关闭弹窗按钮的提示信息位置问题【可能是因为加载速度的原因，造成这个问题，所以将提示信息做了一个延时】</p>
            <p>* “个人资料”提供修改功能</p>
            <p>* 顶部天气信息自动判断位置【忘记之前是怎么想的做成北京的了，可能是我在大首都吧，哈哈。。。】</p>
            <p>* 优化“用户列表”无法查询到新添加的用户【竟然是因为我把key值写错了，该死。。。】</p>
            <p>* 将左侧菜单做成json方式调用，而不是js调用，方便开发使用。同时添加了参数配置和非窗口模式打开的判断，【如登录页面】</p>
            <p>* 优化部分页面样式问题</p>
            <p>* 优化添加窗时如果导航不存在图标无法添加成功</p>
            <br />
            <p># v1.0.1（新增） - 2017-07-05</p>
            <p>* 增加“用户列表”批量删除功能【可能当时忘记添加了吧。。。】</p>
            <p style="color:#f00;">* 顶部窗口导航添加“关闭其他”、“关闭全部”功能，同时修改菜单窗口过多的展示效果【在此感谢larryCMS给予的启发】</p>
            <p>* 添加可隐藏左侧菜单功能【之前考虑没必要添加，但是很多朋友要求加上，那就加上吧，嘿嘿。。。】</p>
            <p>* 增加换肤功能【之前就想添加的，但是一直没有找到好的方式（好吧，其实是我忘记了），此方法相对简单，不是普遍适用，只简单的做个功能，如果实际用到建议单独写一套样式，将边框颜色、按钮颜色等统一调整，此处为保证代码的简洁性，只做简单的功能，不做赘述，另外“自定义”颜色中未做校验，所以要写入正确的色值。如“#f00”】</p>
            <p style="color:#f00;">* 增加登录页面【背景视频仅作样式参考，实际使用中请自行更换为其他视频或图片，否则造成的任何问题使用者本人承担。】</p>
            <p>* 新增打开窗口的动画效果</p>
        </div>
    </div>
    <div class="sysNotice col">
        <blockquote class="layui-elem-quote title">系统基本参数</blockquote>
        <table class="layui-table">
            <colgroup>
                <col width="150">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td>当前版本</td>
                <td class="version">0.1.0</td>
            </tr>
            <tr>
                <td>开发作者</td>
                <td class="author">jzc</td>
            </tr>
            <tr>
                <td>网站首页</td>
                <td class="homePage">test</td>
            </tr>
            <tr>
                <td>服务器环境</td>
                <td class="server">linux</td>
            </tr>
            <tr>
                <td>数据库版本</td>
                <td class="dataBase">mysql</td>
            </tr>
            <tr>
                <td>最大上传限制</td>
                <td class="maxUpload">100</td>
            </tr>
            <tr>
                <td>当前用户权限</td>
                <td class="userRights">admin</td>
            </tr>
            </tbody>
        </table>
        <blockquote class="layui-elem-quote title">最新文章<i class="iconfont icon-new1"></i></blockquote>
        <table class="layui-table" lay-skin="line">
            <colgroup>
                <col>
                <col width="110">
            </colgroup>
            <tbody class="hot_news">
                <tr>
                    <td align="left">帅逼的修炼之路</td>
                    <td>2018-12-12</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- 底部 -->
<div class="layui-footer footer">
    <p>Copyright © <script>document.write(new Date().getFullYear());</script>.JZC All rights reserved.</p>
</div>
<script src="<?=Url::to('@web/js/layui.js') ?>"></script>
<script>
    layui.config({
        base : "<?=Url::to('@web/js/') ?>"
    }).use(['form','element','layer','jquery'],function(){
        var form = layui.form(),
            layer = parent.layer === undefined ? layui.layer : parent.layer,
            element = layui.element(),
            $ = layui.jquery;

        $(".panel a").on("click",function(){
            window.parent.addTab($(this));
        })

        //动态获取文章总数和待审核文章数量,最新文章
        /*
        $.get("../json/newsList.json",
            function(data){
                var waitNews = [];
                $(".allNews span").text(data.length);  //文章总数
                for(var i=0;i<data.length;i++){
                    var newsStr = data[i];
                    if(newsStr["newsStatus"] == "待审核"){
                        waitNews.push(newsStr);
                    }
                }
                $(".waitNews span").text(waitNews.length);  //待审核文章
                //加载最新文章
                var hotNewsHtml = '';
                for(var i=0;i<5;i++){
                    hotNewsHtml += '<tr>'
                        +'<td align="left">'+data[i].newsName+'</td>'
                        +'<td>'+data[i].newsTime+'</td>'
                        +'</tr>';
                }
                $(".hot_news").html(hotNewsHtml);
            }
        )
        */

        //图片总数
        /*
        $.get("../json/images.json",
            function(data){
                $(".imgAll span").text(data.length);
            }
        )
        */

        //用户数
        /*
        $.get("../json/usersList.json",
            function(data){
                $(".userAll span").text(data.length);
            }
        )
        */

        //新消息
        /*
        $.get("../json/message.json",
            function(data){
                $(".newMessage span").text(data.length);
            }
        )
        */


        //数字格式化
        /*
        $(".panel span").each(function(){
            $(this).html($(this).text()>9999 ? ($(this).text()/10000).toFixed(2) + "<em>万</em>" : $(this).text());
        })
        */

        //系统基本参数
        /*
        if(window.sessionStorage.getItem("systemParameter")){
            var systemParameter = JSON.parse(window.sessionStorage.getItem("systemParameter"));
            fillParameter(systemParameter);
        }else{
            $.ajax({
                url : "../json/systemParameter.json",
                type : "get",
                dataType : "json",
                success : function(data){
                    fillParameter(data);
                }
            })
        }
        */

        //填充数据方法
        /*
        function fillParameter(data){
            //判断字段数据是否存在
            function nullData(data){
                if(data == '' || data == "undefined"){
                    return "未定义";
                }else{
                    return data;
                }
            }
            $(".version").text(nullData(data.version));      //当前版本
            $(".author").text(nullData(data.author));        //开发作者
            $(".homePage").text(nullData(data.homePage));    //网站首页
            $(".server").text(nullData(data.server));        //服务器环境
            $(".dataBase").text(nullData(data.dataBase));    //数据库版本
            $(".maxUpload").text(nullData(data.maxUpload));    //最大上传限制
            $(".userRights").text(nullData(data.userRights));//当前用户权限
        }
*/
    })
</script>
