var $,tab;
layui.config({
    base : "js/"
}).use(['form','element','layer','jquery'],function(){
    var form = layui.form(),
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        element = layui.element();
    var laypage = layui.laypage;
    var $ = layui.jquery;

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

    //公告层
    function showNotice(content){
        layer.open({
            type: 1,
            title: "系统公告",
            closeBtn: false,
            area: '310px',
            shade: 0.8,
            id: 'layui',
            btn: ['我知道了'],
            moveType: 1,
            content: '<div style="padding:15px 20px; text-align:justify; line-height: 22px; ' +
            'text-indent:2em;border-bottom:1px solid #e2e2e2;"><p>'+content+'</p></div>',
            success: function(layero){
                var btn = layero.find('.layui-layer-btn');
                btn.css('text-align', 'center');
                btn.on("click",function(){
                    window.sessionStorage.setItem("showNotice","true");
                })
            }
        });
    }
})