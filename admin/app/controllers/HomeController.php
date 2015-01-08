<?php

class HomeController extends BaseController
{

    /**
     * 仪表盘
     */
    public function showDashboard()
    {
        return Redirect::route('MemberList');
    }
}
