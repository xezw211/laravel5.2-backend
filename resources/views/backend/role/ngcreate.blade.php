<div ng-controller="RoleAddController">
  <div ng-init="jsVars = {{$jsVars}}"></div>
  <div class="row">
    <div class="col-md-12">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet light portlet-fit portlet-form bordered">
        <div class="portlet-title">
          <div class="caption">
            <i class=" icon-layers font-green"></i>
            <span class="caption-subject font-green sbold uppercase">{{trans('label.role.add')}}</span>
          </div>
          <div class="actions">
            
          </div>
        </div>

        <div class="portlet-body">
          <form action="{{route('admin.role.store')}}" class="form-horizontal" method="post">
            {{csrf_field()}}
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group form-md-line-input has-success">
                    <label class="col-md-2 control-label" for="form_control_1">{{trans('database.role.name')}}</label>
                    <div class="col-md-8">
                      <div class="input-group has-success">
                          <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                          </span>
                          <input type="text" class="form-control" placeholder="{{trans('database.role.name')}}" name="name" ng-model="userData.name">
                          <div class="form-control-focus"> </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group form-md-line-input has-success">
                    <label class="col-md-2 control-label" for="form_control_1">{{trans('database.role.slug')}}</label>
                    <div class="col-md-8">
                      <div class="input-group has-success">
                          <span class="input-group-addon">
                            <i class="fa fa-star-o"></i>
                          </span>
                          <input type="text" class="form-control" placeholder="{{trans('database.role.slug')}}" name="slug" ng-model="userData.slug">
                          <div class="form-control-focus"> </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group form-md-line-input has-success">
                    <label class="col-md-2 control-label" for="form_control_1">{{trans('database.role.description')}}</label>
                    <div class="col-md-8">
                      <div class="input-group has-success">
                          <span class="input-group-addon">
                            <i class="fa fa-soccer-ball-o"></i>
                          </span>
                          <textarea class="form-control" rows="3" placeholder="{{trans('database.role.description')}}" name="description" ng-model="userData.description"></textarea>
                          <div class="form-control-focus"> </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group form-md-line-input has-success">
                    <label class="col-md-2 control-label" for="form_control_1">{{trans('database.role.status')}}</label>
                    <div class="col-md-8">
                      <select id="statusselect" class="bs-select form-control form-filter" data-show-subtext="true" name="status">
                        <option value="{{config('backend.project.status.open')}}" data-content="{{trans('label.status.open')}} <span class='label lable-sm label-success'>OPEN </span>">{{trans('label.status.open')}}</option>
                        <option value="{{config('backend.project.status.close')}}" data-content="{{trans('label.status.close')}} <span class='label lable-sm label-danger'>CLOSE </span>">{{trans('label.status.close')}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group form-md-line-input has-success">
                    <label class="col-md-2 control-label" for="form_control_1">{{trans('database.role.level')}}</label>
                    <div class="col-md-8">
                      <div class="input-group has-success">
                          <span class="input-group-addon">
                            <i class="fa fa-wrench"></i>
                          </span>
                          <input type="text" class="form-control" placeholder="{{trans('database.role.level')}}" name="level" ng-model="userData.level">
                          <div class="form-control-focus"> </div>
                          <span class="help-block">{{trans('database.role.help.level')}}</span>
                      </div>
                    </div>
                  </div>


                  <div class="form-group form-md-line-input has-success">
                    <div class="col-md-4 col-md-offset-2">
                      <a class="btn btn-success" ng-click="create()">提交</a>
                    </div>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="row margin-bottom-20">
                    <a class="btn btn-success" ng-click="selectAll()">全选</a>
                    <a class="btn btn-success" ng-click="selectInverse()">反选</a>
                  </div>
                  @if($permissions)
                    @foreach($permissions as $key => $permission)
                    <div class="col-md-4">
                      <div class="input-group">
                        <div class="icheck-list">
                          <label ng-click="parentCheckboxClick()">
                            <input type="checkbox" class="icheck parentcheckbox" data-checkbox="icheckbox_square-grey">{{trans('permission.' . $key)}}
                          </label>
                          @if(is_array($permission))
                            @foreach($permission as $sonPermission)
                              <label style="margin-left:30px;">
                                <input type="checkbox" class="icheck soncheckbox" data-checkbox="icheckbox_square-grey" value="{{$sonPermission['value']}}" name="permissions[]">{{$sonPermission['name']}}
                              </label>
                            @endforeach
                          @endif   
                        </div>
                      </div>
                    </div>
                    @endforeach
                  @endif
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>