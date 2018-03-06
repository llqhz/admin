<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit"> <!-- 指定默认渲染内核模式 -->
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <title>后台管理 | </title>
    <!-- Bootstrap -->
    <link href="/Public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/Public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/Public/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/Public/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/Public/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/Public/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/Public/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="/Public/build/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
      table {
          word-break:break-all;
      }
      table td {
          /* white-space:nowrap; */ /* 表格水平滚动条 */
          /* max-width: 13rem *//* 300px */;
          min-width: 3.25rem/* 300px */;
          vertical-align: middle!important;
      }
      table td.td-mw {
          max-width: 12.5rem!important/* 200px */;
          min-width: 10.0rem!important/* 100px */;
          white-space: normal!important;
      }

      td input[type=number] {
          width: 4.5rem/* 50px */;
      }
      td img {
          height: 70px;
          display: inline-block;
      }

      #ll-alert {
        margin-top: 60px;
        margin-bottom: -15px;
        display: none;
      }

      /* 分页样式 */
      .lipage {
          width: 100%;
      }
      .lipage ul {
         list-style-type: none;
         text-align: center;
         color: #96b59e;
         width: 100%;
         margin: 0;
         padding: 4px 0px;
      }
      .lipage ul li {
         display: inline-block;
         border: 1px solid rgba(93, 204, 24, 0.43);
         width: 35px;
         margin: auto 4px;
         line-height: 22px;
      }

      .lipage ul .active {
         background-color: #c8f76f;
      }


      .lipage ul .disabled {
         border: 1px solid rgba(93, 204, 24, 0.23);
         color: transparent;
      }
      .lipage ul .disabled a {
         cursor: text;
         color: lightgray;
      }
      .lipage ul .disabled a:hover {
         color: lightgray;
         background-color: transparent;
      }

      .lipage ul li a {
         text-decoration: none;
         border: 1px solid transparent;
         display: block;
         color: #7ba52a;
      }
      .lipage ul li a:hover {
         background: rgba(200, 247, 111, 0.5);
         color: #ff7777;
      }
    </style>
    
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo U('index/index');?>" class="site_title"><i class="fa fa-paw"></i> <span>后台管理!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- 管理员信息 -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="http://placeimg.com/128/128/nature" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>欢迎使用,</span>
                <h2>管理员</h2>
              </div>
            </div>
            <!-- /管理员信息 -->
            <br />

            <!-- 左边菜单 -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>普通管理员</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> 系统主页 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('index/index');?>">数据概览</a></li>
                      <!-- <li><a href="<?php echo U('index/status');?>">系统状态</a></li> -->
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> 新闻管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('news/nlists');?>">新闻列表</a></li>
                      <li><a href="<?php echo U('news/nadd');?>">添加新闻</a></li>
                      <?php if(($act) == "nedit"): ?><li><a href="<?php echo U('news/editNews',['id'=>$id]);?>">编辑新闻</a></li><?php endif; ?>
                      <!-- <li><a href="<?php echo U('news/nitems');?>">全部新闻</a></li> -->
                    </ul>
                  </li>

                  <li><a><i class="fa fa-edit"></i> 案例分类 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('kind/kcategory');?>">分类列表</a></li>
                      <li><a href="<?php echo U('kind/kcateadd');?>">添加分类</a></li>
                      <?php if(($act) == "kedit"): ?><li><a href="<?php echo U('kind/editKind',['id'=>$id]);?>">编辑分类</a></li><?php endif; ?>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-edit"></i> 案例管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('cases/clists');?>">案例列表</a></li>
                      <li><a href="<?php echo U('cases/cadd');?>">添加案例</a></li>
                      <?php if(($act) == "cedit"): ?><li class="current-page"><a href="<?php echo U('cases/editCase',['id'=>$id]);?>">编辑案例</a></li><?php endif; ?>
                      <li><a href="<?php echo U('cases/citems');?>">全部案例</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> 用户管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('user/ulists');?>">用户列表</a></li>
                      <li><a href="<?php echo U('user/uadd');?>">添加用户</a></li>
                      <?php if(($act) == "uedit"): ?><li class="current-page"><a href="<?php echo U('user/uedit');?>">编辑案例</a></li><?php endif; ?>
                    </ul>
                  </li>
                </ul>
              </div>
              <div class="menu_section">
                <h3>系统设置</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-windows"></i> 网站管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">栏目更新</a></li>
                      <li><a href="page_403.html">网站状态</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bug"></i> 系统管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">系统状态</a></li>
                      <li><a href="e_commerce.html">数据备份</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /左边菜单 -->

            <!-- 菜单底部按钮 -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="设置">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="全屏">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="锁定">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="退出" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- / 菜单底部按钮 -->
          </div>
        </div>

        <!-- 顶部导航 -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="http://placeimg.com/128/128/nature" alt="">姓名
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> 个人信息</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>设置</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">帮助</a></li>
                    <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> 退出</a></li>
                  </ul>
                </li>
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span> <!-- 通知数量 -->
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /顶部导航 -->

        <!-- 页面主体 -->
        <div class="right_col" role="main">
            <!-- 提示框 -->
            <div id="ll-alert"><div class="alert alert-success"></div></div>

        
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>案例分类 <small>添加分类</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br />
        <form id="cate_edit" data-parsley-validate class="form-horizontal form-label-left">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">分类名称 <span class="required">*</span>
            </label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <input type="hidden" name="id" value="<?php echo ($t['id']); ?>">
              <input type="text" name="name" value="<?php echo ($t['name']); ?>" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">父级分类 <span class="required">*</span></label>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <select class="select2_single form-control" name="parentId" tabindex="-1">
                <?php if(is_array($ops)): foreach($ops as $key=>$op): ?><option value="<?php echo ($op["id"]); ?>" <?php echo ($op['id']==$parentId)?'selected':'';?> ><?php echo ($op["name"]); ?></option><?php endforeach; endif; ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">分类描述 <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="detail" value="<?php echo ($t["detail"]); ?>" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">排序号 <span class="required">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="number" name="corder" value='<?php echo ($t["corder"]); ?>' required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success"> 提 交 </button>
              <button class="btn btn-primary" type="reset"> 重 置 </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

        </div>
        <!-- /页面主体 -->

        <!-- 底部版权 -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /底部版权 -->
      </div>
    </div>

    <!-- 弹窗提示 -->
    <div class="modal fade" id="ll-modal-tips-sm">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-info text-center" id="ll-modal-sm-title"></h4>
          </div>
          <div class="modal-body">
              <div class="text-center" style="font-size:16px;" id="ll-modal-sm-text"></div>
          </div>
          <div class="modal-footer">
            <div class="col-xs-6 col-xs-offset-3">
              <button type="button" class="btn btn-info btn-block" id="ll-modal-sm-submit" data-dismiss="modal">确定</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="ll-modal-tips">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-info text-center" id="ll-modal-title"></h4>
          </div>
          <div class="modal-body">
              <div class="text-center" style="font-size:16px;" id="ll-modal-text"></div>
          </div>
          <div class="modal-footer">
            <div class="col-xs-6 col-xs-offset-3" id="ll-modal-bt-1">
              <button type="button" class="btn btn-info btn-block" id="ll-modal-submit" data-dismiss="modal">确定</button>
            </div>
            <div class="col-xs-8 col-xs-offset-1" id="ll-modal-bt-2">
              <button type="button" class="btn btn-info" id="ll-modal-confirm" data-dismiss="modal">确定</button>
              <button type="button" class="btn" id="ll-modal-cancel" data-dismiss="modal">取消</button>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- jQuery -->
    <script src="/Public/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/Public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="/Public/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/Public/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="/Public/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="/Public/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="/Public/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="/Public/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="/Public/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="/Public/vendors/Flot/jquery.flot.js"></script>
    <script src="/Public/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="/Public/vendors/Flot/jquery.flot.time.js"></script>
    <script src="/Public/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="/Public/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="/Public/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="/Public/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="/Public/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="/Public/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="/Public/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="/Public/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="/Public/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="/Public/vendors/moment/min/moment.min.js"></script>
    <script src="/Public/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="/Public/build/js/custom.min.js"></script>
    <script>
     $("input[type=radio]").change(function(event) {
       var $this = $(this),tmp = this;
       var radios = $this.parent('label').parent('.btn-group').find('input[type=radio]');
       $.each(radios, function(index, val) {
          /* iterate through array or object */
          var $label = $(val).parent('label');
          var tc = $label.data('toggle-class');
          var pc = $label.data('toggle-passive-class');
          if ( val == tmp ) {
            $label.removeClass(tc).addClass(pc);
          } else {
            $label.removeClass(pc).addClass(tc);
          }
       });
     });
     var ll = {
        data: {
          funlists: [],
        },
       /**
         * 封装ajax函数
         * @param  {object} opt ajax参数
         */
        ajax: function(opt){
            if ( typeof opt.url == 'undefined' ) { console.log("ajax url not found ..."); return;  };
            var req = { url: opt.url };
            req.method = opt.method || 'post';//请求类型
            req.dataType = opt.dataType || 'json';//接收数据类型
            if ( typeof opt.async != 'undefined' ) {
                req.async = opt.async;
            };
            if ( ll.isset(opt.data) ) {
               req.data = opt.data;
            };
            req.error = function(res){ console.log("ajax error : ....."); console.log(res);};
            req.success = function(res){
                  if ( (parseInt(res.code)==1) && (typeof opt.success=='function')) {
                      opt.success(res);
                  } else {
                      if ( (parseInt(res.code)==0) && (typeof opt.error=='function')) {
                        opt.error(res);
                      }
                  }
              }
            if ( ! (typeof opt.isFormData == 'undefined') ) {
                req.processData = false,
                req.contentType = false;
            };
            $.ajax(req);
        },

        // 获取表单内容
        getFormData: function(selector){
          var fd = new FormData($(selector)[0]);
          return fd;
        },

        isset: function(obj){
            if ( typeof obj == 'undefined' ) {
                return false;
            } else {
                return true;
            }
        },

        reload: function(){
          window.location.reload(true);
        },
        /* 执行函数 */    // 如果是函数,则带参数执行, 并且支持返回值
        exec: function(fun,...args){  // 剩余参数
            if ( typeof fun == 'function' ) {
                var parms = '';
                for (var i = 0; i < args.length; i++) {
                    parms += 'args['+i+'],';
                };
                parms = parms.substr(0,parms.length-1);  // 删除末尾多余的逗号
                var cmd = 'fun('+parms+');';
                return eval(cmd);   // 执行
            }
        },

        //弹窗提示
        tips:function(text,title,hid){
          var lltipsOp = false,size='sm',confirm=false;
          hid = hid || false;
          if ( typeof text == 'object' ) {
            if ( typeof text.text == 'undefined' ) {
              // 弹出 json 错误提示
              text = JSON.stringify(text); // alert json
              text = text.slice(1,-1);
              text = text.replace(/\",\"/g,'"<br>"');

            } else {
              title = text.title || '提示';
              confirm = text.confirm || false; // 确定后执行
              hid = text.hid || false;    // 隐藏后执行
              size = text.size || 'sm';
              text = text.text || '消息提示';
            }
          };

          title = title || '提示';
          size = size || 'sm';

          if ( typeof confirm != 'function' ) {
            $('#ll-modal-bt-1').show();
            $('#ll-modal-bt-2').hide();
          } else {
            $('#ll-modal-bt-2').show();
            $('#ll-modal-bt-1').hide();
          }

          $('#ll-modal-title').text(title);
          $('#ll-modal-text').html(text);
          switch (size) {
              case 'sm':
                  size = 'sm'; break;
              case 'md':
                  size = 'md'; break;
              case 'lg':
                  size = 'lg'; break;
              default:
                  size = 'sm'; break;
          }
          $('#ll-modal-tips .modal-dialog').attr('class', 'modal-dialog modal-'+size);
          $('#ll-modal-tips').modal('show');
          $('#ll-modal-tips').one('hidden.bs.modal', function (e) {
             ll.exec(hid);
          });
          $("#ll-modal-confirm").one('click', function(event) {
            /* Act on the event */
             ll.exec(confirm);
          });
        },

        alert: function(op){
          var text = op.text || '操作成功!',color=op.color || 'info';
          $('#ll-alert div').html(text);
          $('#ll-alert div').attr('class', 'alert alert-'+color);
          $('#ll-alert').fadeIn(300).fadeOut(2000, function() {
              if ( typeof op.reload != 'undefined' ) {
                if ( op.reload === true ) {
                  window.location.reload(true);
                } else {
                  window.location.href = op.reload;
                }
              };
              if ( op.callback == true ) {
                ll.exec(op.success);
              };
            });
          ;
        },
        log: function(data){
          if ( typeof data == 'object' ) {
             alert(JSON.stringify(data,'',4));
          } else {
            alert(data);
          }
        }
     };
    </script>
    
  <script type="text/javascript">
    $(function(){
      var app_edit = {
        data: {
          postUrl : '<?php echo U("kind/edit");?>',
          jumpUrl : '<?php echo U("kind/kcategory");?>',
        },
        init: function(){
          this.eventInit();
        },
        eventInit: function(){
          var app_edit = this;
          /*提交*/
          $('button[type=submit]').on('click', function(event) {
            event.preventDefault();
            /* Act on the event */
            ll.ajax({
              url: app_edit.data.postUrl,
              data: ll.getFormData('#cate_edit'),
              isFormData: true,
              success: function(data){
                var op = {
                  text : '更新成功',
                  color:'success',
                  reload: app_edit.data.jumpUrl,
                };
                ll.alert(op);
              },
              error: function(data){
                ll.tips(data.msg);
              },
            });

          });
        },

      };
      app_edit.init();
    });
  </script>

  </body>
</html>