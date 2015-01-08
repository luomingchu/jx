<?php

class BaseController extends Controller
{

    protected $enterprise_id;

    public function __construct()
    {
        $this->enterprise_id = str_replace('zbond_', '', Config::get('database.connections.own.database'));
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }

        // 手机号验证
        Validator::extend('mobile', function ($attribute, $value, $parameters)
        {
            if (preg_match('/^1[3|4|5|7|8][0-9]{9}$/', $value)) {
                return true;
            }
            return false;
        });
    }
}
