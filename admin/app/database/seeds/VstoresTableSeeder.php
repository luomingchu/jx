<?php
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VstoresTableSeeder extends Seeder
{

    /**
     * 指店填充
     *
     * @author jois
     */
    public function run()
    {
        // 清空表数据
        Vstore::truncate();

        // 给每家企业随机创建20个不同状态的指店
        $enterprises = Enterprise::all();
        foreach ($enterprises as $enterprise) {
            // 随机选择一个用户
            $ids = array_flip(Member::lists('id'));
            if (! empty($ids)) {
                $member_ids = count($ids) > 20 ? array_rand(array_flip(Member::lists('id')), 20) : count($ids);
                foreach ($member_ids as $member_id) {
                    $member = Member::find($member_id);
                    $vstore = new Vstore();
                    $vstore->enterprise()->associate($enterprise);
                    $vstore->member()->associate($member);
                    $vstore->name = sprintf('由%s开的%d的指店', $member->real_name, $enterprise->id);
                    $vstore->status = [
                        Vstore::STATUS_OPEN,
                        Vstore::STATUS_CLOSE,
                        Vstore::STATUS_ENTERPRISE_AUDITING,
                        Vstore::STATUS_ENTERPRISE_AUDITERROR,
                        Vstore::STATUS_ENTERPRISE_AUDITED,
                        Vstore::STATUS_MEMBER_GETED
                    ];
                    $vstore->status = $vstore->status[mt_rand(0, count($vstore->status) - 1)];
                    $vstore->save();
                }
            }
        }
    }
}
