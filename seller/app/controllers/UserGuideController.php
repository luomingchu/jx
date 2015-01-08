<?php
/**
 * 用户操作手册控制器
 */
class UserGuideController extends BaseController
{

    /**
     * 操作指导首页
     */
    public function index()
    {
        return View::make('userguide.index');
    }

    /**
     * 好友邀请
     */
    public function invite()
    {
        return View::make('userguide.invite');
    }

    /**
     * 赚取指币
     */
    public function earnedCoin()
    {
        return View::make('userguide.earned_coin');
    }

    /**
     * 赚取内购额
     */
    public function earnedInsource()
    {
        return View::make('userguide.earned_insource');
    }

    /**
     * 开启指店
     */
    public function openVstore()
    {
        return View::make('userguide.open_vstore');
    }
}