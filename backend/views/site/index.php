<?php
use yii\helpers\Url;
?>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main">
            <a href="#" class="logo">简 默 后台管理系统</a>

            <a href="javascript:;" class="hideMenu icon-menu1 iconfont"></a>

            <!-- 搜索 -->
            <div class="layui-form component">
                <select name="modules" lay-verify="required" lay-search="">
                    <option value="">直接选择或搜索选择</option>
                </select>
                <i class="layui-icon">&#xe615;</i>
            </div>

            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <li class="layui-nav-item showNotice" id="showNotice" pc>
                    <a href="javascript:;"><i class="iconfont icon-gonggao"></i><cite>系统公告</cite></a>
                </li>
                <li class="layui-nav-item" pc>
                    <a href="javascript:;">
                        <img src="<?=Url::to($user_info['head']) ?>" class="layui-circle" width="35" height="35">
                        <cite><?=$user_info['username'] ?></cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-url="page/user/userInfo.html"><i class="iconfont icon-zhanghu" data-icon="icon-zhanghu"></i><cite>个人资料</cite></a></dd>
                        <dd><a href="javascript:;" data-url="page/user/changePwd.html"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>修改密码</cite></a></dd>
                        <dd><a href="<?=Url::to(['site/logout']) ?>"><i class="iconfont icon-loginout"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black">
        <div class="user-photo">
            <a class="img" title="我的头像" ><img src="<?=Url::to($user_info['head']) ?>"></a>
            <p>你好！<span class="userName"><?=$user_info['real_name'] ?></span>, 欢迎</p>
        </div>
        <br>
        <div class="navBar layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item">
                    <a href="<?=Url::to(['site/index']) ?>"><i class="iconfont icon-computer" data-icon="icon-computer"></i><cite>后台首页</cite></a>
                </li>
                <?php
                    if (!empty($menu_info)) {
                        foreach ($menu_info as $_menu) {
                            if (empty($_menu['child_menu'])) {
                                //输出一级菜单
                ?>
                                <li class="layui-nav-item">
                                    <a href="<?=Url::to($_menu['url']) ?>"><i class="iconfont icon-computer" data-icon="icon-computer"></i><cite><?=$_menu['name'] ?></cite></a>
                                </li>

                <?php
                            } else {
                                //输出二级菜单
                ?>
                                <li class="layui-nav-item layui-nav-itemed">
                                    <a href="<?=Url::to($_menu['url']) ?>">
                                        <i class="iconfont icon-text" data-icon="icon-text"></i>
                                        <cite><?=$_menu['name'] ?></cite>
                                        <span class="layui-nav-more"></span>
                                    </a>
                                    <dl class="layui-nav-child">
                <?php
                                            foreach ($_menu['child_menu'] as $child_menu) {
                                                echo "<dd>
                                                <a href=\"".$child_menu['url']."\"><i class=\"iconfont\" data-icon=\"\">
                                                </i><cite>".$child_menu['name']."</cite></a>
                                                </dd>";
                                            }
                ?>
                                    </dl>
                                </li>
                <?php
                            }
                        }
                    }

                ?>
            </ul>
        </div>
    </div>
    <!-- 右侧内容 -->
    <div class="layui-body layui-form">
        <div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>后台首页</cite></li>
            </ul>
            <ul class="layui-nav closeBox">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="iconfont icon-caozuo"></i> 页面操作</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#x1002;</i> 刷新当前</a></dd>
                        <dd><a href="javascript:;" class="closePageOther"><i class="iconfont icon-prohibit"></i> 关闭其他</a></dd>
                        <dd><a href="javascript:;" class="closePageAll"><i class="iconfont icon-guanbi"></i> 关闭全部</a></dd>
                    </dl>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    <iframe src="<?=Url::to(['site/main']) ?>"></iframe>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 移动导航 -->
<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>



<script src="<?=Url::to('@web/js/layui.js') ?>"></script>
<script>
    var $,tab;
    layui.config({
        base : "js/"
    }).use(['bodyTab','form','element','layer','jquery'],function(){
        var form = layui.form(),
            layer = layui.layer,
            element = layui.element();
        $ = layui.jquery;
        tab = layui.bodyTab();

        //隐藏左侧导航
        $(".hideMenu").click(function(){
            $(".layui-layout-admin").toggleClass("showMenu");
            //渲染顶部窗口
            tab.tabMove();
        })

        //渲染左侧菜单
        tab.render();

        //手机设备的简单适配
        var treeMobile = $('.site-tree-mobile'),
            shadeMobile = $('.site-mobile-shade')

        treeMobile.on('click', function(){
            $('body').addClass('site-mobile');
        });

        shadeMobile.on('click', function(){
            $('body').removeClass('site-mobile');
        });

        // 添加新窗口
        $("body").on("click",".layui-nav .layui-nav-item a",function(){
            //如果不存在子级
            if($(this).siblings().length == 0){
                addTab($(this));
                $('body').removeClass('site-mobile');  //移动端点击菜单关闭菜单层
            }
            $(this).parent("li").siblings().removeClass("layui-nav-itemed");
        })

        //公告层
        function showNotice(){
            layer.open({
                type: 1,
                title: "系统公告",
                closeBtn: false,
                area: '310px',
                shade: 0.8,
                id: 'LAY_layuipro',
                btn: ['我知道了'],
                moveType: 1,
                content: '<div style="padding:15px 20px; text-align:justify; line-height: 22px; ' +
                'text-indent:2em;border-bottom:1px solid #e2e2e2;"><p><?=$notice ?></p></div>',
                success: function(layero){
                    var btn = layero.find('.layui-layer-btn');
                    btn.css('text-align', 'center');
                    btn.on("click",function(){
                        window.sessionStorage.setItem("showNotice","true");
                    })
                }
            });
        }

        $(".showNotice").on("click",function(){
            showNotice();
        })

        //刷新后还原打开的窗口
        if(window.sessionStorage.getItem("menu") != null){
            menu = JSON.parse(window.sessionStorage.getItem("menu"));
            curmenu = window.sessionStorage.getItem("curmenu");
            var openTitle = '';
            for(var i=0;i<menu.length;i++){
                openTitle = '';
                if(menu[i].icon){
                    if(menu[i].icon.split("-")[0] == 'icon'){
                        openTitle += '<i class="iconfont '+menu[i].icon+'"></i>';
                    }else{
                        openTitle += '<i class="layui-icon">'+menu[i].icon+'</i>';
                    }
                }
                openTitle += '<cite>'+menu[i].title+'</cite>';
                openTitle += '<i class="layui-icon layui-unselect layui-tab-close" data-id="'+menu[i].layId+'">&#x1006;</i>';
                element.tabAdd("bodyTab",{
                    title : openTitle,
                    content :"<iframe src='"+menu[i].href+"' data-id='"+menu[i].layId+"'></frame>",
                    id : menu[i].layId
                })
                //定位到刷新前的窗口
                if(curmenu != "undefined"){
                    if(curmenu == '' || curmenu == "null"){  //定位到后台首页
                        element.tabChange("bodyTab",'');
                    }else if(JSON.parse(curmenu).title == menu[i].title){  //定位到刷新前的页面
                        element.tabChange("bodyTab",menu[i].layId);
                    }
                }else{
                    element.tabChange("bodyTab",menu[menu.length-1].layId);
                }
            }
            //渲染顶部窗口
            tab.tabMove();
        }

        //刷新当前
        $(".refresh").on("click",function(){  //点击间隔2秒
            if($(this).hasClass("refreshThis")){
                $(this).removeClass("refreshThis");
                $(".clildFrame .layui-tab-item.layui-show").find("iframe")[0].contentWindow.location.reload(true);
                setTimeout(function(){
                    $(".refresh").addClass("refreshThis");
                },2000)
            }else{
                layer.msg("您点击的速度超过了服务器的响应速度，还是等两秒再刷新吧！");
            }
        })

        //关闭其他
        $(".closePageOther").on("click",function(){
            if($("#top_tabs li").length>2 && $("#top_tabs li.layui-this cite").text()!="后台首页"){
                var menu = JSON.parse(window.sessionStorage.getItem("menu"));
                $("#top_tabs li").each(function(){
                    if($(this).attr("lay-id") != '' && !$(this).hasClass("layui-this")){
                        element.tabDelete("bodyTab",$(this).attr("lay-id")).init();
                        //此处将当前窗口重新获取放入session，避免一个个删除来回循环造成的不必要工作量
                        for(var i=0;i<menu.length;i++){
                            if($("#top_tabs li.layui-this cite").text() == menu[i].title){
                                menu.splice(0,menu.length,menu[i]);
                                window.sessionStorage.setItem("menu",JSON.stringify(menu));
                            }
                        }
                    }
                })
            }else if($("#top_tabs li.layui-this cite").text()=="后台首页" && $("#top_tabs li").length>1){
                $("#top_tabs li").each(function(){
                    if($(this).attr("lay-id") != '' && !$(this).hasClass("layui-this")){
                        element.tabDelete("bodyTab",$(this).attr("lay-id")).init();
                        window.sessionStorage.removeItem("menu");
                        menu = [];
                        window.sessionStorage.removeItem("curmenu");
                    }
                })
            }else{
                layer.msg("没有可以关闭的窗口了@_@");
            }
            //渲染顶部窗口
            tab.tabMove();
        })
        //关闭全部
        $(".closePageAll").on("click",function(){
            if($("#top_tabs li").length > 1){
                $("#top_tabs li").each(function(){
                    if($(this).attr("lay-id") != ''){
                        element.tabDelete("bodyTab",$(this).attr("lay-id")).init();
                        window.sessionStorage.removeItem("menu");
                        menu = [];
                        window.sessionStorage.removeItem("curmenu");
                    }
                })
            }else{
                layer.msg("没有可以关闭的窗口了@_@");
            }
            //渲染顶部窗口
            tab.tabMove();
        })
    })

    //打开新窗口
    function addTab(_this){
        tab.tabAdd(_this);
    }
</script>