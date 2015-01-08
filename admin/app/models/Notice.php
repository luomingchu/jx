<?php
/**
 * 公告模型
 *
 * @SWG\Model(id="Notice", description="公告模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="title", type="string",description="公告标题")
 * @SWG\Property(name="kind", type="string",enum="['Text','Picture']",description="公告列表，Text：文本公告，Picture：图片")
 * @SWG\Property(name="picture",type="UserFile", description="公告图片")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Notice extends Eloquent
{


    /**
     * 公告类型：问题
     */
    const KIND_TEXT = 'Text';

    /**
     * 公告类型：图片
     */
    const KIND_PIC = 'Picture';

    /**
     * 公告状态：开启
     */
    const STATUS_OPEN = 'Open';

    /**
     * 公告状态：关闭
     */
    const STATUS_CLOSE = 'Close';

    protected $table = 'notices';

    protected $visible = [
        'id',
        'title',
        'picture'
    ];

    protected $with = [
        'picture'
    ];

    /**
     * 所属图片
     */
    public function picture()
    {
        return $this->belongsTo('UserFile', 'picture_id');
    }



}