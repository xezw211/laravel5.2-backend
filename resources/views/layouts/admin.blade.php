<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js" data-ng-app="MetronicApp"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js" data-ng-app="MetronicApp"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="MetronicApp">
  <!--<![endif]-->
  <!-- BEGIN HEAD -->
  <head>
    <base href="/" />
    <title data-ng-bind="'Metronic AngularJS | ' + $state.current.data.pageTitle"></title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    @yield('meta')
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" /> -->
    <link href="{{asset('backend/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN DYMANICLY LOADED CSS FILES(all plugin and page related styles must be loaded between GLOBAL and THEME css files ) -->
    <link id="ng_load_plugins_before" />
    <!-- END DYMANICLY LOADED CSS FILES -->
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="{{asset('backend/global/css/components-md.min.css')}}" id="style_components" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/global/css/plugins-md.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/layouts/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/layouts/css/themes/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{asset('backend/layouts/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> 
  </head>
  <!-- END HEAD -->
  
  <!-- BEGIN BODY -->
    <!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
    <!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
    <!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
    <!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
    <!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
    <!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
    <!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
    <!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
  <body ng-controller="AppController" class="page-header-fixed page-sidebar-closed-hide-logo page-on-load" ng-class="{'page-content-white': settings.layout.pageContentWhite,'page-container-bg-solid': settings.layout.pageBodySolid, 'page-sidebar-closed': settings.layout.pageSidebarClosed}">
    <!-- BEGIN PAGE SPINNER -->
    <div ng-spinner-bar class="page-spinner-bar">
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
    <!-- END PAGE SPINNER -->
    <!-- BEGIN HEADER -->
    <div ng-controller="HeaderController" class="page-header navbar navbar-fixed-top">
      @include('backend.frame.header')
    </div>
    <!-- END HEADER -->
    <div class="clearfix"> </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
      <!-- BEGIN SIDEBAR -->
      <div ng-controller="SidebarController" class="page-sidebar-wrapper">
        @include('backend.frame.sidebar')
      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN CONTENT -->
      <div class="page-content-wrapper">
        <div class="page-content">
          <!-- BEGIN STYLE CUSTOMIZER(optional) -->
          <!-- END STYLE CUSTOMIZER -->
          <!-- BEGIN ACTUAL CONTENT -->
          @include('backend.frame.flash')
          <div ui-view class="fade-in-up"> </div>
          <!-- END ACTUAL CONTENT -->
        </div>
      </div>
      <!-- END CONTENT -->
      <!-- BEGIN QUICK SIDEBAR -->
      <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
      </a>
      <!-- <div data-ng-include="'tpl/quick-sidebar.html'" data-ng-controller="QuickSidebarController" class="page-quick-sidebar-wrapper"></div> -->
      <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div ng-controller="FooterController" class="page-footer">
      @include('backend.frame.footer')
    </div>
    @include('backend.frame.javascript')
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE JQUERY PLUGINS -->
    <!--[if lt IE 9]>
    <script src="../assets/global/plugins/respond.min.js"></script>
    <script src="../assets/global/plugins/excanvas.min.js"></script> 
    <![endif]-->
    <script src="{{asset('backend/plugins/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <!-- END CORE JQUERY PLUGINS -->
    <!-- BEGIN CORE ANGULARJS PLUGINS -->
    <script src="{{asset('backend/plugins/angularjs/angular.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/angularjs/angular-sanitize.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/angularjs/angular-touch.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/angularjs/plugins/angular-ui-router.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/angularjs/plugins/ocLazyLoad.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/plugins/angularjs/plugins/ui-bootstrap-tpls.min.js')}}" type="text/javascript"></script>
    <!-- END CORE ANGULARJS PLUGINS -->
    <!-- BEGIN APP LEVEL ANGULARJS SCRIPTS -->
    <script src="{{asset('backend/js/main.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/js/directives.js')}}" type="text/javascript"></script>
    <!-- END APP LEVEL ANGULARJS SCRIPTS -->
    <!-- BEGIN APP LEVEL JQUERY SCRIPTS -->
    <script src="{{asset('backend/js/app.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/layouts/scripts/layout.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/layouts/scripts/demo.min.js')}}" type="text/javascript"></script>
    <!-- END APP LEVEL JQUERY SCRIPTS -->
    <!-- END JAVASCRIPTS -->
  </body>
  <!-- END BODY -->
</html>