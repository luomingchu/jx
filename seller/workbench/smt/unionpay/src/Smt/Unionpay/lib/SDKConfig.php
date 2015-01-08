<?php

// cvn2加密 1：加密 0:不加密
const SDK_CVN2_ENC = 0;
// 有效期加密 1:加密 0:不加密
const SDK_DATE_ENC = 0;
// 卡号加密 1：加密 0:不加密
const SDK_PAN_ENC = 0;

// ######(以下配置为PM环境：入网测试环境用，生产环境配置见文档说明)#######
// 签名证书路径
//const SDK_SIGN_CERT_PATH = "../workbench/smt/unionpay/src/Smt/Unionpay/certs/700000000000001_acp.p12";
const SDK_SIGN_CERT_PATH = "../workbench/smt/unionpay/src/Smt/Unionpay/certs/PM_700000000000001_acp.pfx";

// 签名证书密码
const SDK_SIGN_CERT_PWD = '000000';

// 验签证书
//const SDK_VERIFY_CERT_PATH = '../workbench/smt/unionpay/src/Smt/Unionpay/certs/verify_sign_acp_own.cer';
const SDK_VERIFY_CERT_PATH = '../workbench/smt/unionpay/src/Smt/Unionpay/certs/verify_sign_acp.cer';

// 密码加密证书
const SDK_ENCRYPT_CERT_PATH = '../workbench/smt/unionpay/src/Smt/Unionpay/certs/encrypt.cer';

// 验签证书路径
const SDK_VERIFY_CERT_DIR = '../workbench/smt/unionpay/src/Smt/Unionpay/certs/';

// 前台请求地址
const SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';

// 后台请求地址
const SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do';

// 批量交易
const SDK_BATCH_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do';

// 单笔查询请求地址
const SDK_SINGLE_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do';

// 文件传输请求地址
const SDK_FILE_QUERY_URL = 'https://101.231.204.80:9080/';

// 有卡交易地址
const SDK_Card_Request_Url = 'https://101.231.204.80:5000/gateway/api/cardTransReq.do';

// App交易地址
const SDK_App_Request_Url = 'https://101.231.204.80:5000/gateway/api/appTransReq.do';

// 前台通知地址 (商户自行配置通知地址)
const SDK_FRONT_NOTIFY_URL = 'woaiwochatest.api.zbond.com.cn/a';//'woaiwochatest.api.zbond.com.cn/unionpay/return';
// 后台通知地址 (商户自行配置通知地址)
const SDK_BACK_NOTIFY_URL = 'woaiwochatest.api.zbond.com.cn/b';//'woaiwochatest.api.zbond.com.cn/unionpay/back_url';

// 文件下载目录
const SDK_FILE_DOWN_PATH = '../workbench/smt/unionpay/src/Smt/Unionpay/file/';

// 日志 目录
const SDK_LOG_FILE_PATH = '../workbench/smt/unionpay/src/Smt/Unionpay/logs/';

// 日志级别
const SDK_LOG_LEVEL = 'OFF';//INFO