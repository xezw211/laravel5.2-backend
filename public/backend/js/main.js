/***
Metronic AngularJS App Main Script
***/

/* Metronic App */
var MetronicApp = angular.module("MetronicApp", [
    "ui.router", 
    "ui.bootstrap", 
    "oc.lazyLoad",  
    "ngSanitize",
]); 

/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
MetronicApp.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
    $ocLazyLoadProvider.config({
        // global configs go here
    });
}]);

/********************************************
 BEGIN: BREAKING CHANGE in AngularJS v1.3.x:
*********************************************/
/**
`$controller` will no longer look for controllers on `window`.
The old behavior of looking on `window` for controllers was originally intended
for use in examples, demos, and toy apps. We found that allowing global controller
functions encouraged poor practices, so we resolved to disable this behavior by
default.

To migrate, register your controllers with modules rather than exposing them
as globals:

Before:

```javascript
function MyController() {
  // ...
}
```

After:

```javascript
angular.module('myApp', []).controller('MyController', [function() {
  // ...
}]);

Although it's not recommended, you can re-enable the old behavior like this:

```javascript
angular.module('myModule').config(['$controllerProvider', function($controllerProvider) {
  // this option might be handy for migrating old apps, but please don't use it
  // in new ones!
  $controllerProvider.allowGlobals();
}]);
**/

//AngularJS v1.3.x workaround for old style controller declarition in HTML
MetronicApp.config(['$controllerProvider', function($controllerProvider) {
  // this option might be handy for migrating old apps, but please don't use it
  // in new ones!
  $controllerProvider.allowGlobals();
}]);

/********************************************
 END: BREAKING CHANGE in AngularJS v1.3.x:
*********************************************/

/* Setup global settings */
MetronicApp.factory('settings', ['$rootScope', function($rootScope) {
    // supported languages
    var settings = {
        layout: {
            pageSidebarClosed: false, // sidebar menu state
            pageContentWhite: true, // set page content layout
            pageBodySolid: false, // solid body color state
            pageAutoScrollOnLoad: 1000 // auto scroll to top on page load
        },
        assetsPath: '../assets',
        globalPath: '../assets/global',
        layoutPath: '../backend/layouts/img',
    };

    $rootScope.settings = settings;

    return settings;
}]);

/* Setup App Main Controller */
MetronicApp.controller('AppController', ['$scope', '$rootScope', function($scope, $rootScope) {
    $scope.$on('$viewContentLoaded', function() {
        // App.initComponents(); // init core components
        //Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials included in server side instead of loading with ng-include directive 
    });
}]);

/***
Layout Partials.
By default the partials are loaded through AngularJS ng-include directive. In case they loaded in server side(e.g: PHP include function) then below partial 
initialization can be disabled and Layout.init() should be called on page load complete as explained above.
***/

/* Setup Layout Part - Header */
MetronicApp.controller('HeaderController', ['$scope', function($scope) {
    Layout.initHeader(); // init header
}]);

/* Setup Layout Part - Sidebar */
MetronicApp.controller('SidebarController', ['$scope', function($scope) {
    Layout.initSidebar(); // init sidebar
}]);

/* Setup Layout Part - Quick Sidebar */
MetronicApp.controller('QuickSidebarController', ['$scope', function($scope) {    
    $scope.$on('$includeContentLoaded', function() {
       setTimeout(function(){
            QuickSidebar.init(); // init quick sidebar        
        }, 2000)
    });
}]);

/* Setup Layout Part - Theme Panel */
MetronicApp.controller('ThemePanelController', ['$scope', function($scope) {    
    $scope.$on('$includeContentLoaded', function() {
        Demo.init(); // init theme panel
    });
}]);

/* Setup Layout Part - Footer */
MetronicApp.controller('FooterController', ['$scope', function($scope) {
    Layout.initFooter(); // init footer
}]);

/* Setup Rounting For All Pages */
MetronicApp.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', function($stateProvider, $urlRouterProvider, $locationProvider) {
    $locationProvider.html5Mode(true);
    $locationProvider.hashPrefix('!');

    // Redirect any unmatched url
    $urlRouterProvider.otherwise("/dashboard.html");  
    
    $stateProvider
        /*admin*/
        // .state('admin')
        /*user*/
        .state('user', {
            url : '/admin/user',
            templateUrl : "/admin/user/ngindex",
            data : {pageTitle : "用户列表"},
            controller : "UserController",
            resolve : {
                deps : ['$ocLazyLoad', function($ocLazyLoad){
                    return $ocLazyLoad.load(
                        {
                            cache : false,
                            name : 'MetronicApp',
                            insertBefore : '#ng_load_plugins_before',
                            files : [
                                'backend/plugins/datatables/datatables.min.css',
                                'backend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
                                'backend/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                                'backend/plugins/bootstrap-select/css/bootstrap-select.min.css',
                                'backend/plugins/sweetalert/dist/sweetalert.css',
                                'backend/plugins/icheck/skins/all.css',

                                'backend/global/plugins/datatables/datatables.all.min.js',
                                'backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                                'backend/plugins/bootstrap-select/js/bootstrap-select.min.js',
                                'backend/plugins/sweetalert/dist/sweetalert.min.js',
                                'backend/plugins/icheck/icheck.min.js',

                                'backend/js/scripts/user/TableAjax.js',
                                'backend/js/controllers/user/UserController.js',
                            ]
                        }
                    );
                }]
            }
        })
        .state('user_add', {
            url : '/admin/user/create',
            templateUrl : 'admin/user/ngcreate',
            data : {pageTitle : "添加用户"},
            controller : 'UserAddController',
            resolve : {
                deps : ['$ocLazyLoad', function($ocLazyLoad){
                    return $ocLazyLoad.load({
                        cache : false,
                        name : 'MetronicApp',
                        insertBefore : '#ng_load_plugins_before',
                        files : [
                            'backend/plugins/bootstrap-select/css/bootstrap-select.min.css',
                            'backend/plugins/select2/css/select2.min.css',
                            'backend/plugins/select2/css/select2-bootstrap.min.css',
                            'backend/plugins/icheck/skins/all.css',
                            'backend/plugins/sweetalert/dist/sweetalert.css',

                            'backend/plugins/bootstrap-select/js/bootstrap-select.min.js',
                            'backend/plugins/select2/js/select2.full.min.js',
                            'backend/plugins/icheck/icheck.min.js',
                            'backend/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js',
                            'backend/plugins/sweetalert/dist/sweetalert.min.js',
                            'backend/plugins/ngSweetAlert/SweetAlert.min.js',

                            'backend/js/controllers/user/UserAddController.js',
                        ]
                    });
                }]
            }
        })
        .state('user_update', {
            url : '/admin/user/:id/edit',
            templateUrl : function($stateParams){
              return 'admin/user/ngedit/' + $stateParams.id;
            },
            data : {pageTitle : "修改用户"},
            controller : 'UserUpdateController',
            resolve : {
                deps : ['$ocLazyLoad', function($ocLazyLoad){
                    return $ocLazyLoad.load({
                        cache : false,
                        name : 'MetronicApp',
                        insertBefore : '#ng_load_plugins_before',
                        files : [
                            'backend/plugins/bootstrap-select/css/bootstrap-select.min.css',
                            'backend/plugins/select2/css/select2.min.css',
                            'backend/plugins/select2/css/select2-bootstrap.min.css',
                            'backend/plugins/icheck/skins/all.css',

                            'backend/plugins/bootstrap-select/js/bootstrap-select.min.js',
                            'backend/plugins/select2/js/select2.full.min.js',
                            'backend/plugins/icheck/icheck.min.js',

                            'backend/js/controllers/user/UserUpdateController.js',
                        ]
                    });
                }]
            }
        })
        /*role*/
        .state('role', {
            url : '/admin/role',
            templateUrl : "/admin/role/ngindex",
            data : {pageTitle : "用户列表"},
            controller : "RoleController",
            resolve : {
                deps : ['$ocLazyLoad', function($ocLazyLoad){
                    return $ocLazyLoad.load(
                        {
                            cache : false,
                            name : 'MetronicApp',
                            insertBefore : '#ng_load_plugins_before',
                            files : [
                                'backend/plugins/datatables/datatables.min.css',
                                'backend/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
                                'backend/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                                'backend/plugins/bootstrap-select/css/bootstrap-select.min.css',
                                'backend/plugins/sweetalert/dist/sweetalert.css',
                                'backend/plugins/icheck/skins/all.css',

                                'backend/global/plugins/datatables/datatables.all.min.js',
                                'backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                                'backend/plugins/bootstrap-select/js/bootstrap-select.min.js',
                                'backend/plugins/sweetalert/dist/sweetalert.min.js',
                                'backend/plugins/icheck/icheck.min.js',

                                'backend/js/scripts/role/TableAjax.js',
                                'backend/js/controllers/role/RoleController.js',
                            ]
                        }
                    );
                }]
            }
        })
        .state('role_add', {
            url : '/admin/role/create',
            templateUrl : 'admin/role/ngcreate',
            data : {pageTitle : "添加用户"},
            controller : 'RoleAddController',
            resolve : {
                deps : ['$ocLazyLoad', function($ocLazyLoad){
                    return $ocLazyLoad.load({
                        cache : false,
                        name : 'MetronicApp',
                        insertBefore : '#ng_load_plugins_before',
                        files : [
                            'backend/plugins/bootstrap-select/css/bootstrap-select.min.css',
                            'backend/plugins/select2/css/select2.min.css',
                            'backend/plugins/select2/css/select2-bootstrap.min.css',
                            'backend/plugins/icheck/skins/all.css',
                            'backend/plugins/sweetalert/dist/sweetalert.css',

                            'backend/plugins/bootstrap-select/js/bootstrap-select.min.js',
                            'backend/plugins/select2/js/select2.full.min.js',
                            'backend/plugins/icheck/icheck.min.js',
                            'backend/plugins/bootstrap-growl/jquery.bootstrap-growl.min.js',
                            'backend/plugins/sweetalert/dist/sweetalert.min.js',
                            'backend/plugins/ngSweetAlert/SweetAlert.min.js',

                            'backend/js/controllers/role/RoleAddController.js',
                        ]
                    });
                }]
            }
        })
        .state('role_update', {
            url : '/admin/role/:id/edit',
            templateUrl : function($stateParams){
              return 'admin/role/ngedit/' + $stateParams.id;
            },
            data : {pageTitle : "修改用户"},
            controller : 'RoleUpdateController',
            resolve : {
                deps : ['$ocLazyLoad', function($ocLazyLoad){
                    return $ocLazyLoad.load({
                        cache : false,
                        name : 'MetronicApp',
                        insertBefore : '#ng_load_plugins_before',
                        files : [
                            'backend/plugins/bootstrap-select/css/bootstrap-select.min.css',
                            'backend/plugins/select2/css/select2.min.css',
                            'backend/plugins/select2/css/select2-bootstrap.min.css',
                            'backend/plugins/icheck/skins/all.css',

                            'backend/plugins/bootstrap-select/js/bootstrap-select.min.js',
                            'backend/plugins/select2/js/select2.full.min.js',
                            'backend/plugins/icheck/icheck.min.js',

                            'backend/js/controllers/role/RoleUpdateController.js',
                        ]
                    });
                }]
            }
        });
}]);

/* Init global settings and run the app */
MetronicApp.run(["$rootScope", "settings", "$state", function($rootScope, settings, $state) {
    $rootScope.$state = $state; // state to be accessed from view
    $rootScope.$settings = settings; // state to be accessed from view
}]);