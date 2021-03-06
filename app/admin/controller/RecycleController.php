<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 小夏 < 449134904@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use cmf\controller\AdminBaseController;
use think\Db;

class RecycleController extends AdminBaseController
{
    //回收站列表
    function index()
    {
        $list = Db::name('recycleBin')->paginate(10);
        // 获取分页显示
        $page = $list->render();
        $this->assign('page', $page);
        $this->assign('list', $list);
        return $this->fetch();
    }

    //还原
    function restore()
    {

        $id = $this->request->param('id');
        $result = Db::name('recycleBin')->where(array('id' => $id))->find();
        //还原文章
        if ($result['table_name'] == 'portal_post') {
            $data = json_decode($result['data'], TRUE);
            $re = Db::name('portal_post')->insert($data);
            if ($re) {
                $res = Db::name('recycleBin')->where('id', $id)->delete();
                if ($res) {
                    $this->success("还原成功！");
                }
            }
        }
    }

    //删除
    function delete()
    {
        $id = $this->request->param('id');
        $result = Db::name('recycleBin')->where(array('id' => $id))->find();
        //删除文章
        if ($result['table_name'] == 'portal_post') {
            $re = Db::name('portal_post')->where('id', $result['object_id'])->delete();
            if ($re) {
                $res = Db::name('recycleBin')->where('id', $id)->delete();
                if ($res) {
                    $this->success("删除成功！");
                }
            }
        }
    }
}