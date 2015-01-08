<?php
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{

    /**
     * 总管理后台管理员
     *
     * @author Latrell Chan
     */
    public function run()
    {
        // 清空表数据
        Admin::truncate();

        // 增加一个超级管理员。
        $admin = new Admin();
        $admin->username = 'root';
        $admin->password = '123456';
        $admin->save();
    }
}
