<?php

/**
 * 订单收货地址模型
 *
 * @SWG\Model(id="OrderAddress", description="订单收货地址模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="order_id", type="integer",description="订单id")
 * @SWG\Property(name="consignee", type="string",description="收件人姓名")
 * @SWG\Property(name="mobile", type="string",description="收件人手机号")
 * @SWG\Property(name="zipcode", type="string",description="收件人邮编")
 * @SWG\Property(name="province",type="Province",description="省份")
 * @SWG\Property(name="city",type="City",description="市级")
 * @SWG\Property(name="district",type="District",description="地区")
 * @SWG\Property(name="region_name",type="string", description="省市区地址")
 * @SWG\Property(name="address",type="string", description="详细地址")
 * @SWG\Property(name="express_name",type="string", description="发货物流")
 * @SWG\Property(name="express_number",type="string", description="物流单号")
 * @SWG\Property(name="express_datetime",type="date-format", description="发货时间")
 */
class OrderAddress extends Eloquent
{



    protected $table = 'order_address';

    protected $visible = [
        'id',
        'order_id',
        'consignee',
        'mobile',
        'zipcode',
        'province',
        'city',
        'district',
        'region_name',
        'address',
        'express_name',
        'express_number',
        'express_datetime'
    ];

    protected $with = [
        'province',
        'city',
        'district'
    ];

    /**
     * 通过用户的收货地址，创建一个订单内收货地址。
     */
    public static function createFromAddress($address)
    {
        if (! ($address instanceof Address)) {
            $address = Address::find($address);
        }
        $order_address = new static();
        $order_address->consignee = $address->consignee;
        $order_address->mobile = $address->mobile;
        $order_address->zipcode = $address->zipcode;
        $order_address->province_id = $address->province_id;
        $order_address->city_id = $address->city_id;
        $order_address->district_id = $address->district_id;
        $order_address->region_name = $address->region_name;
        $order_address->address = $address->address;
        return $order_address;
    }

    /**
     * 所属订单
     */
    public function order()
    {
        return $this->belongsTo('Order');
    }

    /**
     * 所属省份
     */
    public function province()
    {
        return $this->belongsTo('Province');
    }

    /**
     * 所属市级
     */
    public function city()
    {
        return $this->belongsTo('City');
    }

    /**
     * 所属地区
     */
    public function district()
    {
        return $this->belongsTo('District');
    }
}