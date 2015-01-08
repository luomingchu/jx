<?php

/**
 * 企业后台-反馈意见管理控制器
 *
 * @author jois
 */
class OpinionController extends BaseController
{

    /**
     * 反馈列表
     */
    public function getList()
    {
        // 返回视图
        return View::make('opinion.list');
    }

    /**
     * 删除反馈
     */
    public function delete()
    {
        return View::make('opinion.list');
    }
}
