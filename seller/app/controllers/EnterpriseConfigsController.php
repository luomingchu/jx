<?php
use Illuminate\Support\Facades\Input;

/**
 * 企业设定配置信息控制器
 *
 * @author robote
 */
class EnterpriseConfigsController extends BaseController
{

    /**
     * 获取企业Logo url
     */
    public function getEnterpriseLogo()
    {
        // 返回参数模型
        $config =  EnterpriseConfig::where('enterprise_id',$this->enterprise_id)->first();

        if(empty($config->admin_logo_hash)){
        	return Response::make('未设置logo图片', 402);
        }

        return action('StorageController@getFile', [
            'hash' => $config->admin_logo_hash2,
        ]);
    }
}