<?php
	namespace App\Repositories\Backend;

	use App\User;

	/*仓库*/
	use RoleRepo;
	use PermissionRepo;
	/*第三方应用*/
	use Hashids, DB;
	
	use App\Traits\RepositoryTrait;

	class UserRepository{
		use RepositoryTrait;
		
		/**
		 * ajax 获取用户列表
		 * 
		 * @param		$searchData     数组
		 * 
		 * @author		xezw211@gmail.com
		 * 
		 * @date		2016-04-06 17:33:38
		 * 
		 * @return		
		 */
		public function searchUserList($searchData = []){
			$draw = $this->getFieldValue($searchData, 'draw');
			$name = $this->getFieldValue($searchData, 'name');
			$email = $this->getFieldValue($searchData, 'email');
			$status = $this->getFieldValue($searchData, 'status');
			$created_at_from = $this->getFieldValue($searchData, 'created_at_from');
			$created_at_to = $this->getFieldValue($searchData, 'created_at_to');
			$updated_at_from = $this->getFieldValue($searchData, 'updated_at_from');
			$updated_at_to = $this->getFieldValue($searchData, 'updated_at_to');
			$start = $this->getFieldValue($searchData, 'start');
			$length = $this->getFieldValue($searchData, 'length');

			$returnData = [
				'draw' => $draw,
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				'data' => [],
			];

			$user = new User;

			if(!empty($name)){
				$user = $user->where('name', $name);	
			}

			if(!empty($email)){
				$user = $user->where('email', $email);
			}

			if(!empty($status)){
				$user = $user->where('status', $status);
			}

			if(!empty($created_at_from)){
				$created_at_from = datetimeDeal($created_at_from, true);
				$user = $user->where('created_at', '>=', $created_at_from);
			}

			if(!empty($created_at_to)){
				$created_at_to = datetimeDeal($created_at_to, true);
				$user = $user->where('created_at', '<=', $created_at_to);
			}

			if(!empty($updated_at_from)){
				$updated_at_from = datetimeDeal($updated_at_from, true);
				$user = $user->where('updated_at', '>=', $updated_at_from);
			}

			if(!empty($updated_at_to)){
				$updated_at_to = datetimeDeal($updated_at_to, true);
				$user = $user->where('updated_at', '<=', $updated_at_to);
			}

			$count = $user->count();

			if($count){
				/*用户数据处理*/
				$data = [];
				$users = $user->offset($start)->limit($length)->get();
				if(!$users->isEmpty()){
					foreach($users as $key => $user){
						$data[$key] = $this->setEncryptId($user)->toArray();
						$data[$key]['status'] = $user->setStatusText();
						$data[$key]['roles'] = '';
						$data[$key]['permissions'] = '';
						$data[$key]['button'] = $user->updateButton()->deleteButton(['class' => 'btn btn-danger infodelete'])->getButtonString();
						$data[$key]['roles'] = $this->setUserRoles($user);
						$data[$key]['permissions'] = $this->setUserPermissions($user);
					}
				}

				$returnData['recordsTotal'] = $count;
				$returnData['recordsFiltered'] = $count;
				$returnData['data'] = $data;
			}

			return $returnData;
		}

		/**
		 * 创建用户
		 * 
		 * @param		$userData     需要创建的用户信息
		 * 
		 * @author		xezw211@gmail.com
		 * 
		 * @date		2016-04-09 09:36:53
		 * 
		 * @return		
		 */
		public function createUser($userData){
			$user = new User;

			$user->fill($userData)->save();

			if(!$user){
				\Log::info("用户添加失败\n");
			}

			return $user;
		}

		/**
		 * 通过用户id 获取用户信息		
		 * 
		 * @param		id  获取用户的id
		 * @param 		encodeBool  获取的用户对象是否增加加密id
		 * @param 		decodeBool  对用户的id是否需要解密
		 * 
		 * @author		xezw211@gmail.com
		 * 
		 * @date		2016-04-12 10:12:29
		 * 
		 * @return		
		 */
		public function userInfoById($id, $encodeBool = true, $decodeBool = true){
			$userInfo = false;

			$id = $this->decodeEncryptId($id, $decodeBool);

			if(!empty($id)){
				$userInfo = User::where('id', $id)->first();
				$this->setEncryptId($userInfo, $encodeBool);
			}

			return $userInfo;
		}

		/**
		 * 修改用户信息		
		 * 
		 * @param		$id   用户id
		 * @param       $userData    用户数据
		 * 
		 * @author		xezw211@gmail.com
		 * 
		 * @date		2016-04-12 11:31:05
		 * 
		 * @return		
		 */
		public function updateUser($id, $userData){
			$userInfo = $this->userInfoById($id, false);

			if($userInfo){
				$userInfo->fill($userData)->push();
			}else{
				\Log::info('更新用户失败');
			}

			return $userInfo;
		}

		/**
		 * 删除用户
		 * 
		 * @param		$id   用户id
		 * 
		 * @author		xezw211@gmail.com
		 * 
		 * @date		2016-04-12 15:03:02
		 * 
		 * @return		
		 */
		public function deleteUser($id){
			$returnData = [
				'result' => true,
				'title' => trans('prompt.user.delete.after.title'),
				'message' => trans('prompt.user.delete.after.success'),
			];
			if(config('backend.project.delete.logic')){
				/*逻辑删除*/
				if(!$this->updateUser($id, ['status' => config('backend.project.status.close')])){
					$returnData['result'] = false;
					$returnData['title'] = trans('prompt.user.delete.after.title');
					$returnData['message'] = trans('prompt.user.delete.after.fail');
				}
			}else{
				/*物理删除*/
				$userInfo = $this->userInfoById($id);
				if($userInfo){	
					if(!$userInfo->delete()){
						$returnData['result'] = false;
						$returnData['title'] = trans('prompt.user.delete.after.title');
						$returnData['message'] = trans('prompt.user.delete.after.fail');
					}
				}else{
					$returnData['result'] = false;
					$returnData['title'] = trans('prompt.user.delete.after.title');
					$returnData['message'] = trans('prompt.user.delete.after.fail');
				}
			}

			return $returnData;
		}

		/**
		 * 删除多个用户
		 * 
		 * @param		$ids    数组ids
		 * 
		 * @author		xezw211@gmail.com
		 * 
		 * @date		2016-04-13 15:36:04
		 * 
		 * @return		
		 */
		public function deleteUsers($ids){
			$deleteInfo = [
				'result' => true,
				'title' => trans('prompt.user.delete.after.title'),
				'message' => trans('prompt.user.delete.after.success'),
			];

			if(!empty($ids) && is_array($ids)){
				DB::beginTransaction();
				foreach($ids as $id){
					$deleteInfo = $this->deleteUser($id);
					if(!$deleteInfo['result']){
						DB::rollBack();
						break;
					}
				}
				DB::commit();
			}

			return $deleteInfo;
		}

		/**
		 * 设置 用户显示的角色
		 * @param		App\User $user
		 * @author		xezw211@gmail.com
		 * @date		2016-04-19 17:12:33
		 * @return		string
		 */
		private function setUserRoles($user){
			$returnString = '';
			$roles = RoleRepo::userRoles($user);
			if($roles && !$roles->isEmpty()){
				foreach($roles as $role){
					$rolePermissionNames = PermissionRepo::rolePermissionName($role);
					$rolePermissionsBody = implode("<br />", $rolePermissionNames);
					$rolePermissionsTitle = $role->name;

					$returnString .= "<button class='btn grey-mint popovers margin-bottom-5' data-container='body' data-trigger='hover' data-placement='right' data-content='{$rolePermissionsBody}' data-original-title='{$rolePermissionsTitle}'>{$rolePermissionsTitle}</button>";
				}
			}

			return $returnString;
		}

		/**
		 * 设置用户显示的权限
		 * @param		
		 * @author		xezw211@gmail.com
		 * @date		2016-04-19 17:12:52
		 * @return		
		 */
		private function setUserPermissions($user){
			$returnString = '';
			$permissions = PermissionRepo::userAllPermissionKeys($user, 'name');
			if($permissions){
				$permission_body = implode("<br />", $permissions);
				$permission_title  = trans('database.user.permission');
				$returnString = "<button class='btn grey-mint popovers margin-bottom-5' data-container='body' data-trigger='hover' data-placement='right' data-content='{$permission_body}' data-original-title='{$permission_title}'>{$permission_title}</button>";
			}
			return $returnString;
		}
	}