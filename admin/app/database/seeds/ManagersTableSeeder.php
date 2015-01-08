<?php
use Illuminate\Database\Seeder;

class ManagersTableSeeder extends Seeder
{

    /**
     * 企业后台管理员
     *
     * @author jois
     */
    public function run()
    {
        // 清空表数据
        Manager::truncate();

        // 增加一个企业管理员。
        $manager = new Manager();
        $manager->username = 'e';
        $manager->password = '123456';
        $manager->is_super = Manager::SUPER_VALID;
        $manager->save();
    }
}
