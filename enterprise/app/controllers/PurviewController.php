<?php

/**
 * 企业后台-权限管理控制器
 *
 * @author jois
 */
class PurviewController extends BaseController
{

    /**
     * 权限列表
     */
    public function getList()
    {
        // 返回视图
        return View::make('purview.list');
    }
}
