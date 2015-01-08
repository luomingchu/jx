<?php

/**
 * 银行卡模型
 *
 * @SWG\Model(id="EnterpriseBankcard", description="银行卡模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="enterprise", type="Enterprise",description="所属企业")
 * @SWG\Property(name="bank", type="Bank",description="所属银行")
 * @SWG\Property(name="number", type="string",description="银行卡号")
 * @SWG\Property(name="name", type="string",description="账户名称")
 * @SWG\Property(name="branch_code", type="string",description="分支机构码")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class EnterpriseBankcard extends Eloquent
{

    protected $table = 'enterprise_bankcards';

    protected $visible = [
        'id',
        'enterprise',
        'bank',
        'number',
        'name',
        'branch_code',
        'created_at'
    ];

    protected $with = [
        'bank'
    ];

    /**
     * 所属企业
     */
    public function enterprise()
    {
        return $this->belongsTo('Enterprise');
    }

    /**
     * 所属银行
     */
    public function bank()
    {
        return $this->belongsTo('Bank');
    }
}