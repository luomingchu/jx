<?php
use Carbon\Carbon;

class MembersTableSeeder extends Seeder
{

    public function run()
    {
        // 清空表数据
        Member::truncate();

        $username = '孙倩雯,周丽丽,章小美,曹兰,魏琳,陈玲,华倩,吴珊,陈好,吴珊玲,王芳,张烨华,王晓晓,陈曦,陈琳琳,廖小请,贺妮可,谢雨轩,施梦琪,范银芳,方梅,赵秋萍,施昱倩,王美美,林依萍,柳思贝,张佳,贺小妮,杨小萍,林宛儿,李冰兰,陈依珊,张秋荷,马冬灵,谢语蝶,吴小夏,周俏妍,吴琳佳,王裢蓉,郭俊芬,刘琳静,胡珍霞,任洁文,罗子艳,杨莉玫,吴霞,马雨娜,李乐怡,周梅芬,吴立霞';
        $username = explode(',', $username);
        for ($i = 0; $i < 50; $i ++) {
            $member = new Member();
            $un = $username[$i];
            $member->nickname = $un;
            $member->mobile = sprintf('136%08d', $i);
            $member->password = '123456';
            $member->gender = Member::GENDER_FEMALE;
            $member->real_name = $un;
            $member->save();
        }
    }
}