<?php
/**
 * 企业控制器
 */
class EnterpriseController extends BaseController
{

    /**
     * 获取企业信息
     */
    public function getInfo()
    {
        // 返回参数模型
        $config =  EnterpriseConfig::where('enterprise_id',$this->enterprise_id)->first();

        // 企业logo地址
        if(empty($config->admin_logo_hash)){
            $data['logo'] = '';
        } else {
            $data['logo'] = action('StorageController@getFile', [
                'hash' => $config->admin_logo_hash2,
            ]);
        }

        // 企业指店数量
        $data['vstore'] = 300 + Vstore::where('status', Vstore::STATUS_OPEN)->count();

        // 企业支付佣金总额
        $data['brokerage'] = 287008 + Order::where('status', Order::STATUS_FINISH)->where('brokerage_settlement_id', '!=', 0)->sum('brokerage');

        return $data;
    }
}