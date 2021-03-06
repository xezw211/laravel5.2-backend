angular.module('MetronicApp').controller('UserUpdateController', function($rootScope, $scope, $http, $timeout) {
    $scope.$on('$viewContentLoaded', function() {   
        // initialize core components
        App.initAjax();

        /*初始化 icheck*/
        $(".parentcheckbox").each(function(index){
            $this = $(this);
            var length = $this.parents('.icheck-list').find('.soncheckbox:checked').length;
            if(length == 0){
                $this.prop('checked', false).iCheck('update');
            }else{
                $this.prop('checked', true).iCheck('update');
            }
        });

        /*bs select*/
        $(".bs-select").selectpicker({
          iconBase:"fa",tickIcon:"fa-check"
        });

        /*select2-multiple*/
        $(".select2, .select2-multiple").select2({
          placeholder: '选择角色',
        });

        /*icheck选择*/
        $(".parentcheckbox").on('ifChecked ifUnchecked', function(event){
          var $this = $(this);
          if(event.type == 'ifChecked'){
            $this.parents('.icheck-list').find('.soncheckbox').iCheck('check');
          }else if(event.type = 'ifUnchecked'){
            $this.parents('.icheck-list').find('.soncheckbox').iCheck('uncheck');
          }
        });

        $(".soncheckbox").on('ifChecked ifUnchecked', function(event){
            var $this = $(this);
            var $parentCheck = $this.parents('.icheck-list').find('.parentcheckbox');
            if(event.type == 'ifChecked'){
                $parentCheck.prop('checked', true).iCheck('update');
            }else if(event.type == 'ifUnchecked'){
                var length = $this.parents('.icheck-list').find('.soncheckbox:checked').length;
                if(length == 0){
                    $parentCheck.prop('checked', false).iCheck('update');
                }
            }
        });

        /*全选 , 反选*/
        $scope.selectAll = function(){
            $(".parentcheckbox").prop('checked', false).iCheck('check');
        };

        $scope.selectInverse = function(){
            $('.soncheckbox').iCheck('toggle');
        };

    });

    // set sidebar closed and body solid layout mode
    $rootScope.settings.layout.pageContentWhite = true;
    $rootScope.settings.layout.pageBodySolid = false;
    $rootScope.settings.layout.pageSidebarClosed = false;
});