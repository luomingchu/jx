<?php
Route::pattern('id', '[0-9]+');
Route::pattern('width', '[0-9]+');
Route::pattern('height', '[0-9]+');

Route::get('/', 'HomeController@showWelcome');


// 全局模块
require __DIR__ . '/routes/global.php';

// 用户模块
require __DIR__ . '/routes/user.php';

// 指店模块
require __DIR__ . '/routes/vstore.php';

// 收藏模块
//require __DIR__ . '/routes/favorite.php';

// 赞模块
//require __DIR__ . '/routes/like.php';

// 商品模块
//require __DIR__ . '/routes/goods.php';

// 评论模块
// require __DIR__ . '/routes/comment.php';

// 购物车模块
//require __DIR__ . '/routes/cart.php';

// 收货地址模块
//require __DIR__ . '/routes/address.php';



// 订单模块
//require __DIR__ . '/routes/order.php';

// 关注模块
//require __DIR__ . '/routes/attention.php';

// 门店模块
//require __DIR__ . '/routes/store.php';

// 公告模块
//require __DIR__ . '/routes/notice.php';

// 支付包模块
//require __DIR__ . '/routes/alipay.php';

// 广告模块
//require __DIR__ . '/routes/advertise.php';

// 用户聊天模块
//require __DIR__ . '/routes/chat.php';

// 问答模块
//require __DIR__ . '/routes/issue.php';

// 消息模块
//require __DIR__ . '/routes/message.php';

// 内购额模块
//require __DIR__ . '/routes/insource.php';

// M版模块
//require __DIR__ . '/routes/m.php';

// M版web页面模块
//require __DIR__ . '/routes/m_web.php';

// 佣金模块
//require __DIR__ . '/routes/brokerage.php';

// 分享模块
//require __DIR__ . '/routes/share.php';

// 任务模块
//require __DIR__ . '/routes/task.php';

// 活动模块
//require __DIR__ . '/routes/activity.php';

// 银行卡模块
//require __DIR__ . '/routes/bankcard.php';

// 问卷调查模块
//require __DIR__ . '/routes/questionnaire.php';

// 退款退货
//require __DIR__ . '/routes/refund.php';

// 用户手册模块
//require __DIR__ . '/routes/user_guide.php';

// 企业模块
//require __DIR__ . '/routes/enterprise.php';

// 商品分类模块
//require __DIR__ . '/routes/category.php';

// 银联手机支付
//require __DIR__ . '/routes/unionpay.php';