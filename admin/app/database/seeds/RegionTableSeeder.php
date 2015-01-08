<?php

class RegionTableSeeder extends Seeder
{

    /**
     * 省市县数据
     *
     * @return void
     */
    public function run()
    {
        // 导入数据
        $file = fopen(app_path('database/seeds/Region.sql'), 'r');
        while (($sql = fgets($file)) !== false) {
            $sql = preg_replace('/--.*/', '', $sql);
            $sql = trim($sql);
            if ($sql == '') {
                continue;
            }
            DB::insert($sql);
        }
        fclose($file);
    }
}