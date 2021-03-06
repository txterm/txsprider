<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace cmf\controller;

use think\Db;

class AdminBaseController extends BaseController
{

    public function _initialize()
    {
        parent::_initialize();
        $session_admin_id = session('ADMIN_ID');
        if (!empty($session_admin_id)) {
            $user = Db::name('user')->where(array('id' => $session_admin_id))->find();

            if (!$this->checkAccess($session_admin_id)) {
                $this->error("您没有访问权限！");
            }
            $this->assign("admin", $user);
        } else {
            if ($this->request->isPost()) {
                $this->error("您还没有登录！", url("admin/public/login"));
            } else {
                header("Location:" . url("admin/public/login"));
                exit();
            }
        }
    }

    public function _initializeView()
    {
        $cmfAdminThemePath = config('cmf_admin_theme_path');
        $cmfAdminDefaultTheme = config('cmf_admin_default_theme');

        $themePath = "{$cmfAdminThemePath}{$cmfAdminDefaultTheme}";

        $root = $this->request->root();

        $viewReplaceStr = [
            '__ROOT__' => $root,
            '__TMPL__' => "{$root}/{$themePath}",
            '__STATIC__' => "{$root}/static",
            '__WEB_ROOT__' => $root
        ];

        //config('template.view_path', "$themePath/");
        $viewReplaceStr = array_merge(config('view_replace_str'), $viewReplaceStr);
        config('template.view_base', "$themePath/");
        config('view_replace_str', $viewReplaceStr);
    }

    /**
     * 初始化后台菜单
     */
    public function initMenu()
    {
    }

    /**
     *  检查后台用户访问权限
     * @param int $uid 后台用户id
     * @return boolean 检查通过返回true
     */
    private function checkAccess($uid)
    {
//        如果用户角色是1，则无需判断
        if ($uid == 1) {
            return true;
        }
//
        $module = $this->request->module();
        $controller = $this->request->controller();
        $action = $this->request->action();
        $rule = $module . $controller . $action;

        $notRequire = array("adminIndexindex", "adminMainindex");
        if (!in_array($rule, $notRequire)) {
            return cmf_auth_check($uid);
        } else {
            return true;
        }
    }

    /**
     *  排序 排序字段为listorders数组 POST 排序字段为：listorder
     */
    protected function listOrders($model)
    {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称

        $ids = $this->request->post("list_orders/a");
        foreach ($ids as $key => $r) {
            $data['list_order'] = $r;
            $model->isUpdate(true)->save($data, [$pk => $key]);
        }
        return true;
    }
}