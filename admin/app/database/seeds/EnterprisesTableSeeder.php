<?php
use Illuminate\Database\Seeder;

class EnterprisesTableSeeder extends Seeder
{

    /**
     * 企业信息填充
     *
     * @author jois
     */
    public function run()
    {
        // 先清空表数据
        Enterprise::truncate();

        $list = [
            'zb' => '指帮',
            'zbp' => 'czj指帮'
        ];

        $i = 0;
        foreach ($list as $id => $name) {
            $i ++;
            $enterprise = new Enterprise();
            $enterprise->domain = $id;
            $enterprise->name = $name;
            $enterprise->legal = $name;
            $enterprise->contacts = $name;
            $enterprise->phone = '1700000009' . $i;
            $enterprise->description = "{$name}简介";
            $enterprise->province_id = '13';
            $enterprise->city_id = '105';
            $enterprise->district_id = '981';
            $enterprise->address = '观音山7号楼';
            $enterprise->longitude = '118.199586';
            $enterprise->latitude = '24.503335';
            $enterprise->save();
        }
    }
}
