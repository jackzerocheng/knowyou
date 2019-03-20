var $,tab;
layui.config({
    base : "js/"
}).use(['bodyTab','form','element','layer','jquery'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        element = layui.element();
    laypage = layui.laypage;
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


    //
    //添加菜单
    //
    //
    $(window).one("resize",function(){
        $(".frontendMenu_add").click(function(){
            var front = layui.layer.open({
                title : "添加前台菜单",
                type : 2,
                content : "index.php?r=menu%2Fadd&type=1",
                area : ['80%', '60%'],
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回菜单列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                },
                end : function () {
                    location.reload();
                }
            })
            //layui.layer.full(front);
        })

        $(".backendMenu_add").click(function(){
            var backend = layui.layer.open({
                title : "添加后台菜单",
                type : 2,
                content : "index.php?r=menu%2Fadd&type=2",
                area : ['80%', '60%'],
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回菜单列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                },
                end : function () {
                    location.reload();
                }
            })
            //layui.layer.full(backend);
        })

        $(".rule_add").click(function(){
            var backend = layui.layer.open({
                title : "添加微信规则",
                type : 2,
                content : "index.php?r=wx%2Frule-add",
                area : ['80%', '60%'],
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回规则列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                },
                end : function () {
                    location.reload();
                }
            })
            //layui.layer.full(backend);
        })

        $(".banner_add").click(function(){
            var backend = layui.layer.open({
                title : "添加运营位",
                type : 2,
                content : "index.php?r=banner%2Fadd",
                area : ['80%', '60%'],
                success : function(layero, index){
                    setTimeout(function(){
                        layui.layer.tips('点击此处返回运营位列表', '.layui-layer-setwin .layui-layer-close', {
                            tips: 3
                        });
                    },500)
                },
                end : function () {
                    location.reload();
                }
            })
            //layui.layer.full(backend);
        })
    }).resize();

    //弹层提交完后自动close
    $(".close-layer").click(function () {
        layer.closeAll();
    })


    //
    // ------------   编辑   -------------
    //
    //菜单编辑
    $("body").on("click",".menu_edit",function(){  //编辑
        var _this = $(this);
        var menu_id = _this.attr("data-id");
        var rs = layui.layer.open({
            title : "编辑菜单",
            type : 2,
            content : "index.php?r=menu%2Fedit&id=" + menu_id,
            area : ['80%', '60%'],
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回菜单列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            },
            end : function () {
                location.reload();
            }
        })
    })

    //微信规则编辑
    $("body").on("click",".rule_edit",function(){  //编辑
        var _this = $(this);
        var rule_id = _this.attr("data-id");
        var rs = layui.layer.open({
            title : "编辑规则",
            type : 2,
            content : "index.php?r=wx%2Frule-edit&id=" + rule_id,
            area : ['80%', '60%'],
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回菜单列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            },
            end : function () {
                location.reload();
            }
        })
    })

    //运营位编辑
    $("body").on("click",".banner_edit",function(){  //编辑
        var _this = $(this);
        var id = _this.attr("data-id");
        var rs = layui.layer.open({
            title : "编辑运营位",
            type : 2,
            content : "index.php?r=banner%2Fedit&id=" + id,
            area : ['80%', '60%'],
            success : function(layero, index){
                setTimeout(function(){
                    layui.layer.tips('点击此处返回运营位列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            },
            end : function () {
                location.reload();
            }
        })
    })
})