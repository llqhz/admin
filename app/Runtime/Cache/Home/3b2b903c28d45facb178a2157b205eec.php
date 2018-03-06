<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/Public/production/images/favicon.ico" type="/Public/production/image/ico" />
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
          width: 3.8rem/* 50px */;
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
                <img src="/Public/production/images/img.jpg" alt="..." class="img-circle profile_img">
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
                      <li><a href="<?php echo U('index/status');?>">系统状态</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-edit"></i> 新闻管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('news/nlists');?>">新闻列表</a></li>
                      <li><a href="<?php echo U('news/nadd');?>">添加新闻</a></li>
                      <li><a href="<?php echo U('news/nitems');?>">全部新闻</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-edit"></i> 案例分类 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('Kind/kcategory');?>">分类列表</a></li>
                      <li><a href="<?php echo U('Kind/kcateadd');?>">添加分类</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-edit"></i> 案例管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('cases/clists');?>">案例列表</a></li>
                      <li><a href="<?php echo U('cases/cadd');?>">添加案例</a></li>
                      <li><a href="<?php echo U('cases/citems');?>">全部案例</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-edit"></i> 用户管理 <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo U('user/ulists');?>">用户列表</a></li>
                      <li><a href="<?php echo U('user/uadd');?>">添加用户</a></li>
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
                    <img src="/Public/production/images/img.jpg" alt="">姓名
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
                        <span class="/Public/production/image"><img src="/Public/production/images/img.jpg" alt="Profile Image" /></span>
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
                        <span class="/Public/production/image"><img src="/Public/production/images/img.jpg" alt="Profile Image" /></span>
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
        
    系统状态信息

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
    </script>
    
  </body>
</html>