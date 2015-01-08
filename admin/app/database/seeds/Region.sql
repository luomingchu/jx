
-- 省级表

INSERT `province`(`name`,`sort`,`remark`) VALUES('北京市','1','直辖市');
INSERT `province`(`name`,`sort`,`remark`) VALUES('天津市','2','直辖市');
INSERT `province`(`name`,`sort`,`remark`) VALUES('河北省','5','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('山西省','6','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('内蒙古自治区','32','自治区');
INSERT `province`(`name`,`sort`,`remark`) VALUES('辽宁省','8','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('吉林省','9','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('黑龙江省','10','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('上海市','3','直辖市');
INSERT `province`(`name`,`sort`,`remark`) VALUES('江苏省','11','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('浙江省','12','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('安徽省','13','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('福建省','14','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('江西省','15','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('山东省','16','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('河南省','17','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('湖北省','18','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('湖南省','19','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('广东省','20','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('海南省','24','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('广西壮族自治区','28','自治区');
INSERT `province`(`name`,`sort`,`remark`) VALUES('甘肃省','21','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('陕西省','27','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('新 疆维吾尔自治区','31','自治区');
INSERT `province`(`name`,`sort`,`remark`) VALUES('青海省','26','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('宁夏回族自治区','30','自治区');
INSERT `province`(`name`,`sort`,`remark`) VALUES('重庆市','4','直辖市');
INSERT `province`(`name`,`sort`,`remark`) VALUES('四川省','22','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('贵州省','23','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('云南省','25','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('西藏自治区','29','自治区');
INSERT `province`(`name`,`sort`,`remark`) VALUES('台湾省','7','省份');
INSERT `province`(`name`,`sort`,`remark`) VALUES('澳门特别行政区','33','特别行政区');
INSERT `province`(`name`,`sort`,`remark`) VALUES('香港特别行政区','34','特别行政区');

-- 市级表

INSERT `city`(`name`,`province_id`,`sort`) VALUES('北京市','1','1');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('天津市','2','2');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('上海市','9','3');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('重庆市','27','4');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('邯郸市','3','5');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('石家庄市','3','6');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('保定市','3','7');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('张家口市','3','8');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('承德市','3','9');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('唐山市','3','10');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('廊坊市','3','11');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('沧州市','3','12');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('衡水市','3','13');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('邢台市','3','14');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('秦皇岛市','3','15');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('朔州市','4','16');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('忻州市','4','17');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('太原市','4','18');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('大同市','4','19');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阳泉市','4','20');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('晋中市','4','21');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('长治市','4','22');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('晋城市','4','23');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('临汾市','4','24');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('吕梁市','4','25');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('运城市','4','26');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('沈阳市','6','27');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('铁岭市','6','28');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('大连市','6','29');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('鞍山市','6','30');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('抚顺市','6','31');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('本溪市','6','32');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('丹东市','6','33');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('锦州市','6','34');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('营口市','6','35');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阜新市','6','36');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('辽阳市','6','37');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('朝阳市','6','38');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('盘锦市','6','39');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('葫芦岛市','6','40');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('长春市','7','41');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('吉林市','7','42');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('延边朝鲜族自治州','7','43');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('四平市','7','44');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('通化市','7','45');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('白城市','7','46');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('辽源市','7','47');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('松原市','7','48');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('白山市','7','49');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('哈尔滨市','8','50');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('齐齐哈尔市','8','51');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('鸡西市','8','52');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('牡丹江市','8','53');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('七台河市','8','54');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('佳木斯市','8','55');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('鹤岗市','8','56');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('双鸭山市','8','57');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('绥化市','8','58');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黑河市','8','59');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('大兴安岭地区','8','60');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('伊春市','8','61');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('大庆市','8','62');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('南京市','10','63');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('无锡市','10','64');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('镇江市','10','65');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('苏州市','10','66');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('南通市','10','67');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('扬州市','10','68');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('盐城市','10','69');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('徐州市','10','70');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('淮安市','10','71');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('连云港市','10','72');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('常州市','10','73');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('泰州市','10','74');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宿迁市','10','75');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('舟山市','11','76');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('衢州市','11','77');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('杭州市','11','78');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('湖州市','11','79');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('嘉兴市','11','80');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宁波市','11','81');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('绍兴市','11','82');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('温州市','11','83');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('丽水市','11','84');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('金华市','11','85');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('台州市','11','86');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('合肥市','12','87');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('芜湖市','12','88');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('蚌埠市','12','89');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('淮南市','12','90');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('马鞍山市','12','91');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('淮北市','12','92');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('铜陵市','12','93');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('安庆市','12','94');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黄山市','12','95');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('滁州市','12','96');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阜阳市','12','97');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宿州市','12','98');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('巢湖市','12','99');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('六安市','12','100');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('亳州市','12','101');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('池州市','12','102');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宣城市','12','103');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('福州市','13','104');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('厦门市','13','105');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宁德市','13','106');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('莆田市','13','107');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('泉州市','13','108');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('漳州市','13','109');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('龙岩市','13','110');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('三明市','13','111');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('南平市','13','112');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('鹰潭市','14','113');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('新余市','14','114');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('南昌市','14','115');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('九江市','14','116');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('上饶市','14','117');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('抚州市','14','118');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宜春市','14','119');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('吉安市','14','120');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('赣州市','14','121');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('景德镇市','14','122');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('萍乡市','14','123');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('菏泽市','15','124');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('济南市','15','125');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('青岛市','15','126');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('淄博市','15','127');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('德州市','15','128');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('烟台市','15','129');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('潍坊市','15','130');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('济宁市','15','131');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('泰安市','15','132');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('临沂市','15','133');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('滨州市','15','134');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('东营市','15','135');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('威海市','15','136');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('枣庄市','15','137');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('日照市','15','138');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('莱芜市','15','139');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('聊城市','15','140');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('商丘市','16','141');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('郑州市','16','142');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('安阳市','16','143');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('新乡市','16','144');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('许昌市','16','145');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('平顶山市','16','146');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('信阳市','16','147');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('南阳市','16','148');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('开封市','16','149');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('洛阳市','16','150');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('济源市','16','151');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('焦作市','16','152');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('鹤壁市','16','153');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('濮阳市','16','154');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('周口市','16','155');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('漯河市','16','156');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('驻马店市','16','157');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('三门峡市','16','158');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('武汉市','17','159');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('襄樊市','17','160');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('鄂州市','17','161');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('孝感市','17','162');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黄冈市','17','163');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黄石市','17','164');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('咸宁市','17','165');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('荆州市','17','166');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宜昌市','17','167');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('恩施土家族苗族自治州','17','168');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('神农架林区','17','169');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('十堰市','17','170');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('随州市','17','171');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('荆门市','17','172');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('仙桃市','17','173');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('天门市','17','174');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('潜江市','17','175');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('岳阳市','18','176');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('长沙市','18','177');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('湘潭市','18','178');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('株洲市','18','179');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('衡阳市','18','180');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('郴州市','18','181');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('常德市','18','182');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('益阳市','18','183');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('娄底市','18','184');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('邵阳市','18','185');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('湘西土家族苗族自治州','18','186');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('张家界市','18','187');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('怀化市','18','188');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('永州市','18','189');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('广州市','19','190');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('汕尾市','19','191');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阳江市','19','192');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('揭阳市','19','193');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('茂名市','19','194');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('惠州市','19','195');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('江门市','19','196');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('韶关市','19','197');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('梅州市','19','198');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('汕头市','19','199');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('深圳市','19','200');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('珠海市','19','201');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('佛山市','19','202');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('肇庆市','19','203');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('湛江市','19','204');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('中山市','19','205');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('河源市','19','206');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('清远市','19','207');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('云浮市','19','208');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('潮州市','19','209');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('东莞市','19','210');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('兰州市','22','211');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('金昌市','22','212');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('白银市','22','213');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('天水市','22','214');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('嘉峪关市','22','215');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('武威市','22','216');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('张掖市','22','217');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('平凉市','22','218');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('酒泉市','22','219');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('庆阳市','22','220');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('定西市','22','221');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('陇南市','22','222');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('临夏回族自治州','22','223');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('甘南藏族自治州','22','224');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('成都市','28','225');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('攀枝花市','28','226');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('自贡市','28','227');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('绵阳市','28','228');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('南充市','28','229');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('达州市','28','230');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('遂宁市','28','231');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('广安市','28','232');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('巴中市','28','233');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('泸州市','28','234');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宜宾市','28','235');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('资阳市','28','236');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('内江市','28','237');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('乐山市','28','238');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('眉山市','28','239');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('凉山彝族自治州','28','240');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('雅安市','28','241');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('甘孜藏族自治州','28','242');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阿坝藏族羌族自治州','28','243');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('德阳市','28','244');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('广元市','28','245');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('贵阳市','29','246');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('遵义市','29','247');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('安顺市','29','248');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黔南布依族苗族自治州','29','249');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黔东南苗族侗族自治州','29','250');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('铜仁地区','29','251');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('毕节地区','29','252');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('六盘水市','29','253');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黔西南布依族苗族自治州','29','254');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('海口市','20','255');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('三亚市','20','256');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('五指山市','20','257');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('琼海市','20','258');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('儋州市','20','259');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('文昌市','20','260');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('万宁市','20','261');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('东方市','20','262');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('澄迈县','20','263');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('定安县','20','264');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('屯昌县','20','265');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('临高县','20','266');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('白沙黎族自治县','20','267');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('昌江黎族自治县','20','268');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('乐东黎族自治县','20','269');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('陵水黎族自治县','20','270');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('保亭黎族苗族自治县','20','271');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('琼中黎族苗族自治县','20','272');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('西双版纳傣族自治州','30','273');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('德宏傣族景颇族自治州','30','274');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('昭通市','30','275');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('昆明市','30','276');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('大理白族自治州','30','277');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('红河哈尼族彝族自治州','30','278');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('曲靖市','30','279');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('保山市','30','280');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('文山壮族苗族自治州','30','281');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('玉溪市','30','282');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('楚雄彝族自治州','30','283');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('普洱市','30','284');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('临沧市','30','285');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('怒江傈傈族自治州','30','286');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('迪庆藏族自治州','30','287');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('丽江市','30','288');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('海北藏族自治州','25','289');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('西宁市','25','290');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('海东地区','25','291');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('黄南藏族自治州','25','292');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('海南藏族自治州','25','293');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('果洛藏族自治州','25','294');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('玉树藏族自治州','25','295');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('海西蒙古族藏族自治州','25','296');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('西安市','23','297');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('咸阳市','23','298');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('延安市','23','299');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('榆林市','23','300');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('渭南市','23','301');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('商洛市','23','302');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('安康市','23','303');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('汉中市','23','304');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('宝鸡市','23','305');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('铜川市','23','306');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('防城港市','21','307');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('南宁市','21','308');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('崇左市','21','309');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('来宾市','21','310');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('柳州市','21','311');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('桂林市','21','312');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('梧州市','21','313');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('贺州市','21','314');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('贵港市','21','315');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('玉林市','21','316');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('百色市','21','317');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('钦州市','21','318');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('河池市','21','319');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('北海市','21','320');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('拉萨市','31','321');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('日喀则地区','31','322');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('山南地区','31','323');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('林芝地区','31','324');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('昌都地区','31','325');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('那曲地区','31','326');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阿里地区','31','327');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('银川市','26','328');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('石嘴山市','26','329');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('吴忠市','26','330');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('固原市','26','331');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('中卫市','26','332');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('塔城地区','24','333');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('哈密地区','24','334');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('和田地区','24','335');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阿勒泰地区','24','336');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('克孜勒苏柯尔克孜自治州','24','337');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('博尔塔拉蒙古自治州','24','338');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('克拉玛依市','24','339');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('乌鲁木齐市','24','340');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('石河子市','24','341');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('昌吉回族自治州','24','342');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('五家渠市','24','343');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('吐鲁番地区','24','344');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('巴音郭楞蒙古自治州','24','345');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阿克苏地区','24','346');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阿拉尔市','24','347');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('喀什地区','24','348');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('图木舒克市','24','349');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('伊犁哈萨克自治州','24','350');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('呼伦贝尔市','5','351');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('呼和浩特市','5','352');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('包头市','5','353');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('乌海市','5','354');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('乌兰察布市','5','355');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('通辽市','5','356');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('赤峰市','5','357');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('鄂尔多斯市','5','358');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('巴彦淖尔市','5','359');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('锡林郭勒盟','5','360');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('兴安盟','5','361');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('阿拉善盟','5','362');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('台北市','32','363');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('高雄市','32','364');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('基隆市','32','365');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('台中市','32','366');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('台南市','32','367');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('新竹市','32','368');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('嘉义市','32','369');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('澳门特别行政区','33','370');
INSERT `city`(`name`,`province_id`,`sort`) VALUES('香港特别行政区','34','371');

-- 县区表

--1 北京
INSERT `district`(`name`,`city_id`) VALUES('东城区','1');
INSERT `district`(`name`,`city_id`) VALUES('西城区','1');
INSERT `district`(`name`,`city_id`) VALUES('崇文区','1');
INSERT `district`(`name`,`city_id`) VALUES('宣武区','1');
INSERT `district`(`name`,`city_id`) VALUES('朝阳区','1');
INSERT `district`(`name`,`city_id`) VALUES('丰台区','1');
INSERT `district`(`name`,`city_id`) VALUES('石景山区','1');
INSERT `district`(`name`,`city_id`) VALUES('海淀区','1');
INSERT `district`(`name`,`city_id`) VALUES('门头沟区','1');
INSERT `district`(`name`,`city_id`) VALUES('房山区','1');
INSERT `district`(`name`,`city_id`) VALUES('通州区','1');
INSERT `district`(`name`,`city_id`) VALUES('顺义区','1');
INSERT `district`(`name`,`city_id`) VALUES('昌平区','1');
INSERT `district`(`name`,`city_id`) VALUES('大兴区','1');
INSERT `district`(`name`,`city_id`) VALUES('怀柔区','1');
INSERT `district`(`name`,`city_id`) VALUES('平谷区','1');
INSERT `district`(`name`,`city_id`) VALUES('密云县','1');
INSERT `district`(`name`,`city_id`) VALUES('延庆县','1');

--2 天津
INSERT `district`(`name`,`city_id`) VALUES('和平区','2');
INSERT `district`(`name`,`city_id`) VALUES('河东区','2');
INSERT `district`(`name`,`city_id`) VALUES('河西区','2');
INSERT `district`(`name`,`city_id`) VALUES('南开区','2');
INSERT `district`(`name`,`city_id`) VALUES('河北区','2');
INSERT `district`(`name`,`city_id`) VALUES('红桥区','2');
INSERT `district`(`name`,`city_id`) VALUES('塘沽区','2');
INSERT `district`(`name`,`city_id`) VALUES('汉沽区','2');
INSERT `district`(`name`,`city_id`) VALUES('大港区','2');
INSERT `district`(`name`,`city_id`) VALUES('东丽区','2');
INSERT `district`(`name`,`city_id`) VALUES('西青区','2');
INSERT `district`(`name`,`city_id`) VALUES('津南区','2');
INSERT `district`(`name`,`city_id`) VALUES('北辰区','2');
INSERT `district`(`name`,`city_id`) VALUES('武清区','2');
INSERT `district`(`name`,`city_id`) VALUES('宝坻区','2');
INSERT `district`(`name`,`city_id`) VALUES('宁河县','2');
INSERT `district`(`name`,`city_id`) VALUES('静海县','2');
INSERT `district`(`name`,`city_id`) VALUES('蓟县','2');

--3	上海市
INSERT `district`(`name`,`city_id`) VALUES('黄浦区','3');
INSERT `district`(`name`,`city_id`) VALUES('卢湾区','3');
INSERT `district`(`name`,`city_id`) VALUES('徐汇区','3');
INSERT `district`(`name`,`city_id`) VALUES('长宁区','3');
INSERT `district`(`name`,`city_id`) VALUES('静安区','3');
INSERT `district`(`name`,`city_id`) VALUES('普陀区','3');
INSERT `district`(`name`,`city_id`) VALUES('闸北区','3');
INSERT `district`(`name`,`city_id`) VALUES('虹口区','3');
INSERT `district`(`name`,`city_id`) VALUES('杨浦区','3');
INSERT `district`(`name`,`city_id`) VALUES('闵行区','3');
INSERT `district`(`name`,`city_id`) VALUES('宝山区','3');
INSERT `district`(`name`,`city_id`) VALUES('嘉定区','3');
INSERT `district`(`name`,`city_id`) VALUES('浦东新区','3');
INSERT `district`(`name`,`city_id`) VALUES('金山区','3');
INSERT `district`(`name`,`city_id`) VALUES('松江区','3');
INSERT `district`(`name`,`city_id`) VALUES('青浦区','3');
INSERT `district`(`name`,`city_id`) VALUES('南汇区','3');
INSERT `district`(`name`,`city_id`) VALUES('奉贤区','3');
INSERT `district`(`name`,`city_id`) VALUES('崇明县','3');

--4	重庆市
INSERT `district`(`name`,`city_id`) VALUES('万州区','4');
INSERT `district`(`name`,`city_id`) VALUES('涪陵区','4');
INSERT `district`(`name`,`city_id`) VALUES('渝中区','4');
INSERT `district`(`name`,`city_id`) VALUES('大渡口区','4');
INSERT `district`(`name`,`city_id`) VALUES('江北区','4');
INSERT `district`(`name`,`city_id`) VALUES('沙坪坝区','4');
INSERT `district`(`name`,`city_id`) VALUES('九龙坡区','4');
INSERT `district`(`name`,`city_id`) VALUES('南岸区','4');
INSERT `district`(`name`,`city_id`) VALUES('北碚区','4');
INSERT `district`(`name`,`city_id`) VALUES('万盛区','4');
INSERT `district`(`name`,`city_id`) VALUES('双桥区','4');
INSERT `district`(`name`,`city_id`) VALUES('渝北区','4');
INSERT `district`(`name`,`city_id`) VALUES('巴南区','4');
INSERT `district`(`name`,`city_id`) VALUES('黔江区','4');
INSERT `district`(`name`,`city_id`) VALUES('长寿区','4');
INSERT `district`(`name`,`city_id`) VALUES('江津区','4');
INSERT `district`(`name`,`city_id`) VALUES('合川区','4');
INSERT `district`(`name`,`city_id`) VALUES('永川区','4');
INSERT `district`(`name`,`city_id`) VALUES('南川区','4');
INSERT `district`(`name`,`city_id`) VALUES('綦江县','4');
INSERT `district`(`name`,`city_id`) VALUES('潼南县','4');
INSERT `district`(`name`,`city_id`) VALUES('铜梁县','4');
INSERT `district`(`name`,`city_id`) VALUES('大足县','4');
INSERT `district`(`name`,`city_id`) VALUES('荣昌县','4');
INSERT `district`(`name`,`city_id`) VALUES('璧山县','4');
INSERT `district`(`name`,`city_id`) VALUES('梁平县','4');
INSERT `district`(`name`,`city_id`) VALUES('城口县','4');
INSERT `district`(`name`,`city_id`) VALUES('丰都县','4');
INSERT `district`(`name`,`city_id`) VALUES('垫江县','4');
INSERT `district`(`name`,`city_id`) VALUES('武隆县','4');
INSERT `district`(`name`,`city_id`) VALUES('忠县','4');
INSERT `district`(`name`,`city_id`) VALUES('开县','4');
INSERT `district`(`name`,`city_id`) VALUES('云阳县','4');
INSERT `district`(`name`,`city_id`) VALUES('奉节县','4');
INSERT `district`(`name`,`city_id`) VALUES('巫山县','4');
INSERT `district`(`name`,`city_id`) VALUES('巫溪县','4');
INSERT `district`(`name`,`city_id`) VALUES('石柱土家族自治县','4');
INSERT `district`(`name`,`city_id`) VALUES('秀山土家族苗族自治县','4');
INSERT `district`(`name`,`city_id`) VALUES('酉阳土家族苗族自治县','4');
INSERT `district`(`name`,`city_id`) VALUES('彭水苗族土家族自治县','4');

--****************************************************************河北省*****************************************************************
--5	邯郸市
INSERT `district`(`name`,`city_id`) VALUES('邯山区','5');
INSERT `district`(`name`,`city_id`) VALUES('丛台区','5');
INSERT `district`(`name`,`city_id`) VALUES('复兴区','5');
INSERT `district`(`name`,`city_id`) VALUES('峰峰矿区','5');
INSERT `district`(`name`,`city_id`) VALUES('邯郸县','5');
INSERT `district`(`name`,`city_id`) VALUES('临漳县','5');
INSERT `district`(`name`,`city_id`) VALUES('成安县','5');
INSERT `district`(`name`,`city_id`) VALUES('大名县','5');
INSERT `district`(`name`,`city_id`) VALUES('涉县','5');
INSERT `district`(`name`,`city_id`) VALUES('磁县','5');
INSERT `district`(`name`,`city_id`) VALUES('肥乡县','5');
INSERT `district`(`name`,`city_id`) VALUES('永年县','5');
INSERT `district`(`name`,`city_id`) VALUES('邱县','5');
INSERT `district`(`name`,`city_id`) VALUES('鸡泽县','5');
INSERT `district`(`name`,`city_id`) VALUES('广平县','5');
INSERT `district`(`name`,`city_id`) VALUES('馆陶县','5');
INSERT `district`(`name`,`city_id`) VALUES('魏县','5');
INSERT `district`(`name`,`city_id`) VALUES('曲周县','5');
INSERT `district`(`name`,`city_id`) VALUES('武安市','5');

--6	石家庄市
INSERT `district`(`name`,`city_id`) VALUES('长安区','6');
INSERT `district`(`name`,`city_id`) VALUES('桥东区','6');
INSERT `district`(`name`,`city_id`) VALUES('桥西区','6');
INSERT `district`(`name`,`city_id`) VALUES('新华区','6');
INSERT `district`(`name`,`city_id`) VALUES('井陉矿区','6');
INSERT `district`(`name`,`city_id`) VALUES('裕华区','6');
INSERT `district`(`name`,`city_id`) VALUES('井陉县','6');
INSERT `district`(`name`,`city_id`) VALUES('正定县','6');
INSERT `district`(`name`,`city_id`) VALUES('栾城县','6');
INSERT `district`(`name`,`city_id`) VALUES('行唐县','6');
INSERT `district`(`name`,`city_id`) VALUES('灵寿县','6');
INSERT `district`(`name`,`city_id`) VALUES('高邑县','6');
INSERT `district`(`name`,`city_id`) VALUES('深泽县','6');
INSERT `district`(`name`,`city_id`) VALUES('赞皇县','6');
INSERT `district`(`name`,`city_id`) VALUES('无极县','6');
INSERT `district`(`name`,`city_id`) VALUES('平山县','6');
INSERT `district`(`name`,`city_id`) VALUES('元氏县','6');
INSERT `district`(`name`,`city_id`) VALUES('赵县','6');
INSERT `district`(`name`,`city_id`) VALUES('辛集市','6');
INSERT `district`(`name`,`city_id`) VALUES('藁城市','6');
INSERT `district`(`name`,`city_id`) VALUES('晋州市','6');
INSERT `district`(`name`,`city_id`) VALUES('新乐市','6');
INSERT `district`(`name`,`city_id`) VALUES('鹿泉市','6');

--7	保定市
INSERT `district`(`name`,`city_id`) VALUES('新市区','7');
INSERT `district`(`name`,`city_id`) VALUES('北市区','7');
INSERT `district`(`name`,`city_id`) VALUES('南市区','7');
INSERT `district`(`name`,`city_id`) VALUES('满城县','7');
INSERT `district`(`name`,`city_id`) VALUES('清苑县','7');
INSERT `district`(`name`,`city_id`) VALUES('涞水县','7');
INSERT `district`(`name`,`city_id`) VALUES('阜平县','7');
INSERT `district`(`name`,`city_id`) VALUES('徐水县','7');
INSERT `district`(`name`,`city_id`) VALUES('定兴县','7');
INSERT `district`(`name`,`city_id`) VALUES('唐县','7');
INSERT `district`(`name`,`city_id`) VALUES('高阳县','7');
INSERT `district`(`name`,`city_id`) VALUES('容城县','7');
INSERT `district`(`name`,`city_id`) VALUES('涞源县','7');
INSERT `district`(`name`,`city_id`) VALUES('望都县','7');
INSERT `district`(`name`,`city_id`) VALUES('安新县','7');
INSERT `district`(`name`,`city_id`) VALUES('易县','7');
INSERT `district`(`name`,`city_id`) VALUES('曲阳县','7');
INSERT `district`(`name`,`city_id`) VALUES('蠡县','7');
INSERT `district`(`name`,`city_id`) VALUES('顺平县','7');
INSERT `district`(`name`,`city_id`) VALUES('博野县','7');
INSERT `district`(`name`,`city_id`) VALUES('雄县','7');
INSERT `district`(`name`,`city_id`) VALUES('涿州市','7');
INSERT `district`(`name`,`city_id`) VALUES('定州市','7');
INSERT `district`(`name`,`city_id`) VALUES('安国市','7');
INSERT `district`(`name`,`city_id`) VALUES('高碑店市','7');

--8	张家口市
INSERT `district`(`name`,`city_id`) VALUES('桥东区','8');
INSERT `district`(`name`,`city_id`) VALUES('桥西区','8');
INSERT `district`(`name`,`city_id`) VALUES('宣化区','8');
INSERT `district`(`name`,`city_id`) VALUES('下花园区','8');
INSERT `district`(`name`,`city_id`) VALUES('宣化县','8');
INSERT `district`(`name`,`city_id`) VALUES('张北县','8');
INSERT `district`(`name`,`city_id`) VALUES('康保县','8');
INSERT `district`(`name`,`city_id`) VALUES('沽源县','8');
INSERT `district`(`name`,`city_id`) VALUES('尚义县','8');
INSERT `district`(`name`,`city_id`) VALUES('蔚县','8');
INSERT `district`(`name`,`city_id`) VALUES('阳原县','8');
INSERT `district`(`name`,`city_id`) VALUES('怀安县','8');
INSERT `district`(`name`,`city_id`) VALUES('万全县','8');
INSERT `district`(`name`,`city_id`) VALUES('怀来县','8');
INSERT `district`(`name`,`city_id`) VALUES('涿鹿县','8');
INSERT `district`(`name`,`city_id`) VALUES('赤城县','8');
INSERT `district`(`name`,`city_id`) VALUES('崇礼县','8');

--9	承德市
INSERT `district`(`name`,`city_id`) VALUES('双桥区','9');
INSERT `district`(`name`,`city_id`) VALUES('双滦区','9');
INSERT `district`(`name`,`city_id`) VALUES('鹰手营子矿区','9');
INSERT `district`(`name`,`city_id`) VALUES('承德县','9');
INSERT `district`(`name`,`city_id`) VALUES('兴隆县','9');
INSERT `district`(`name`,`city_id`) VALUES('平泉县','9');
INSERT `district`(`name`,`city_id`) VALUES('滦平县','9');
INSERT `district`(`name`,`city_id`) VALUES('隆化县','9');
INSERT `district`(`name`,`city_id`) VALUES('丰宁满族自治县','9');
INSERT `district`(`name`,`city_id`) VALUES('宽城满族自治县','9');
INSERT `district`(`name`,`city_id`) VALUES('围场满族蒙古族自治县','9');

--10	唐山市
INSERT `district`(`name`,`city_id`) VALUES('路南区','10');
INSERT `district`(`name`,`city_id`) VALUES('路北区','10');
INSERT `district`(`name`,`city_id`) VALUES('古冶区','10');
INSERT `district`(`name`,`city_id`) VALUES('开平区','10');
INSERT `district`(`name`,`city_id`) VALUES('丰南区','10');
INSERT `district`(`name`,`city_id`) VALUES('丰润区','10');
INSERT `district`(`name`,`city_id`) VALUES('滦县','10');
INSERT `district`(`name`,`city_id`) VALUES('滦南县','10');
INSERT `district`(`name`,`city_id`) VALUES('乐亭县','10');
INSERT `district`(`name`,`city_id`) VALUES('迁西县','10');
INSERT `district`(`name`,`city_id`) VALUES('玉田县','10');
INSERT `district`(`name`,`city_id`) VALUES('唐海县','10');
INSERT `district`(`name`,`city_id`) VALUES('遵化市','10');
INSERT `district`(`name`,`city_id`) VALUES('迁安市','10');
 
--11	廊坊市
INSERT `district`(`name`,`city_id`) VALUES('安次区','11');
INSERT `district`(`name`,`city_id`) VALUES('广阳区','11');
INSERT `district`(`name`,`city_id`) VALUES('固安县','11');
INSERT `district`(`name`,`city_id`) VALUES('永清县','11');
INSERT `district`(`name`,`city_id`) VALUES('香河县','11');
INSERT `district`(`name`,`city_id`) VALUES('大城县','11');
INSERT `district`(`name`,`city_id`) VALUES('文安县','11');
INSERT `district`(`name`,`city_id`) VALUES('大厂回族自治县','11');
INSERT `district`(`name`,`city_id`) VALUES('霸州市','11');
INSERT `district`(`name`,`city_id`) VALUES('三河市','11');

--12	沧州市
INSERT `district`(`name`,`city_id`) VALUES('新华区','12');
INSERT `district`(`name`,`city_id`) VALUES('运河区','12');
INSERT `district`(`name`,`city_id`) VALUES('沧县','12');
INSERT `district`(`name`,`city_id`) VALUES('青县','12');
INSERT `district`(`name`,`city_id`) VALUES('东光县','12');
INSERT `district`(`name`,`city_id`) VALUES('海兴县','12');
INSERT `district`(`name`,`city_id`) VALUES('盐山县','12');
INSERT `district`(`name`,`city_id`) VALUES('肃宁县','12');
INSERT `district`(`name`,`city_id`) VALUES('南皮县','12');
INSERT `district`(`name`,`city_id`) VALUES('吴桥县','12');
INSERT `district`(`name`,`city_id`) VALUES('献县','12');
INSERT `district`(`name`,`city_id`) VALUES('孟村回族自治县','12');
INSERT `district`(`name`,`city_id`) VALUES('泊头市','12');
INSERT `district`(`name`,`city_id`) VALUES('任丘市','12');
INSERT `district`(`name`,`city_id`) VALUES('黄骅市','12');
INSERT `district`(`name`,`city_id`) VALUES('河间市','12');

--13	衡水市
INSERT `district`(`name`,`city_id`) VALUES('桃城区','13');
INSERT `district`(`name`,`city_id`) VALUES('枣强县','13');
INSERT `district`(`name`,`city_id`) VALUES('武邑县','13');
INSERT `district`(`name`,`city_id`) VALUES('武强县','13');
INSERT `district`(`name`,`city_id`) VALUES('饶阳县','13');
INSERT `district`(`name`,`city_id`) VALUES('安平县','13');
INSERT `district`(`name`,`city_id`) VALUES('故城县','13');
INSERT `district`(`name`,`city_id`) VALUES('景县','13');
INSERT `district`(`name`,`city_id`) VALUES('阜城县','13');
INSERT `district`(`name`,`city_id`) VALUES('冀州市','13');
INSERT `district`(`name`,`city_id`) VALUES('深州市','13');


--14	邢台市
INSERT `district`(`name`,`city_id`) VALUES('桥东区','14');
INSERT `district`(`name`,`city_id`) VALUES('桥西区','14');
INSERT `district`(`name`,`city_id`) VALUES('邢台县','14');
INSERT `district`(`name`,`city_id`) VALUES('临城县','14');
INSERT `district`(`name`,`city_id`) VALUES('内丘县','14');
INSERT `district`(`name`,`city_id`) VALUES('柏乡县','14');
INSERT `district`(`name`,`city_id`) VALUES('隆尧县','14');
INSERT `district`(`name`,`city_id`) VALUES('任县','14');
INSERT `district`(`name`,`city_id`) VALUES('南和县','14');
INSERT `district`(`name`,`city_id`) VALUES('宁晋县','14');
INSERT `district`(`name`,`city_id`) VALUES('巨鹿县','14');
INSERT `district`(`name`,`city_id`) VALUES('新河县','14');
INSERT `district`(`name`,`city_id`) VALUES('广宗县','14');
INSERT `district`(`name`,`city_id`) VALUES('平乡县','14');
INSERT `district`(`name`,`city_id`) VALUES('威县','14');
INSERT `district`(`name`,`city_id`) VALUES('清河县','14');
INSERT `district`(`name`,`city_id`) VALUES('临西县','14');
INSERT `district`(`name`,`city_id`) VALUES('南宫市','14');
INSERT `district`(`name`,`city_id`) VALUES('沙河市','14');

--15	秦皇岛市
INSERT `district`(`name`,`city_id`) VALUES('海港区','15');
INSERT `district`(`name`,`city_id`) VALUES('山海关区','15');
INSERT `district`(`name`,`city_id`) VALUES('北戴河区','15');
INSERT `district`(`name`,`city_id`) VALUES('青龙满族自治县','15');
INSERT `district`(`name`,`city_id`) VALUES('昌黎县','15');
INSERT `district`(`name`,`city_id`) VALUES('抚宁县','15');
INSERT `district`(`name`,`city_id`) VALUES('卢龙县','15');


--*********************************************************山西************************************************************************
--16	朔州市
INSERT `district`(`name`,`city_id`) VALUES('朔城区','16');
INSERT `district`(`name`,`city_id`) VALUES('平鲁区','16');
INSERT `district`(`name`,`city_id`) VALUES('山阴县','16');
INSERT `district`(`name`,`city_id`) VALUES('应县','16');
INSERT `district`(`name`,`city_id`) VALUES('右玉县','16');
INSERT `district`(`name`,`city_id`) VALUES('怀仁县','16');

--17	忻州市
INSERT `district`(`name`,`city_id`) VALUES('忻府区','17');
INSERT `district`(`name`,`city_id`) VALUES('定襄县','17');
INSERT `district`(`name`,`city_id`) VALUES('五台县','17');
INSERT `district`(`name`,`city_id`) VALUES('代县','17');
INSERT `district`(`name`,`city_id`) VALUES('繁峙县','17');
INSERT `district`(`name`,`city_id`) VALUES('宁武县','17');
INSERT `district`(`name`,`city_id`) VALUES('静乐县','17');
INSERT `district`(`name`,`city_id`) VALUES('神池县','17');
INSERT `district`(`name`,`city_id`) VALUES('五寨县','17');
INSERT `district`(`name`,`city_id`) VALUES('岢岚县','17');
INSERT `district`(`name`,`city_id`) VALUES('河曲县','17');
INSERT `district`(`name`,`city_id`) VALUES('保德县','17');
INSERT `district`(`name`,`city_id`) VALUES('偏关县','17');
INSERT `district`(`name`,`city_id`) VALUES('原平市','17');

--18	太原市
INSERT `district`(`name`,`city_id`) VALUES('小店区','18');
INSERT `district`(`name`,`city_id`) VALUES('迎泽区','18');
INSERT `district`(`name`,`city_id`) VALUES('杏花岭区','18');
INSERT `district`(`name`,`city_id`) VALUES('尖草坪区','18');
INSERT `district`(`name`,`city_id`) VALUES('万柏林区','18');
INSERT `district`(`name`,`city_id`) VALUES('晋源区','18');
INSERT `district`(`name`,`city_id`) VALUES('清徐县','18');
INSERT `district`(`name`,`city_id`) VALUES('阳曲县','18');
INSERT `district`(`name`,`city_id`) VALUES('娄烦县','18');
INSERT `district`(`name`,`city_id`) VALUES('古交市','18');

--19	大同市
INSERT `district`(`name`,`city_id`) VALUES('矿区','19');
INSERT `district`(`name`,`city_id`) VALUES('南郊区','19');
INSERT `district`(`name`,`city_id`) VALUES('新荣区','19');
INSERT `district`(`name`,`city_id`) VALUES('阳高县','19');
INSERT `district`(`name`,`city_id`) VALUES('天镇县','19');
INSERT `district`(`name`,`city_id`) VALUES('广灵县','19');
INSERT `district`(`name`,`city_id`) VALUES('灵丘县','19');
INSERT `district`(`name`,`city_id`) VALUES('浑源县','19');
INSERT `district`(`name`,`city_id`) VALUES('左云县','19');
INSERT `district`(`name`,`city_id`) VALUES('大同县','19');

--20	阳泉市
INSERT `district`(`name`,`city_id`) VALUES('矿区','20');
INSERT `district`(`name`,`city_id`) VALUES('平定县','20');
INSERT `district`(`name`,`city_id`) VALUES('盂县','20');

--21	晋中市
INSERT `district`(`name`,`city_id`) VALUES('榆次区','21');
INSERT `district`(`name`,`city_id`) VALUES('榆社县','21');
INSERT `district`(`name`,`city_id`) VALUES('左权县','21');
INSERT `district`(`name`,`city_id`) VALUES('和顺县','21');
INSERT `district`(`name`,`city_id`) VALUES('昔阳县','21');
INSERT `district`(`name`,`city_id`) VALUES('寿阳县','21');
INSERT `district`(`name`,`city_id`) VALUES('太谷县','21');
INSERT `district`(`name`,`city_id`) VALUES('祁县','21');
INSERT `district`(`name`,`city_id`) VALUES('平遥县','21');
INSERT `district`(`name`,`city_id`) VALUES('灵石县','21');
INSERT `district`(`name`,`city_id`) VALUES('介休市','21');

--22	长治市
INSERT `district`(`name`,`city_id`) VALUES('长治县','22');
INSERT `district`(`name`,`city_id`) VALUES('襄垣县','22');
INSERT `district`(`name`,`city_id`) VALUES('屯留县','22');
INSERT `district`(`name`,`city_id`) VALUES('平顺县','22');
INSERT `district`(`name`,`city_id`) VALUES('黎城县','22');
INSERT `district`(`name`,`city_id`) VALUES('壶关县','22');
INSERT `district`(`name`,`city_id`) VALUES('长子县','22');
INSERT `district`(`name`,`city_id`) VALUES('武乡县','22');
INSERT `district`(`name`,`city_id`) VALUES('沁县','22');
INSERT `district`(`name`,`city_id`) VALUES('沁源县','22');
INSERT `district`(`name`,`city_id`) VALUES('潞城市','22');

--23	晋城市
INSERT `district`(`name`,`city_id`) VALUES('沁水县','23');
INSERT `district`(`name`,`city_id`) VALUES('阳城县','23');
INSERT `district`(`name`,`city_id`) VALUES('陵川县','23');
INSERT `district`(`name`,`city_id`) VALUES('泽州县','23');
INSERT `district`(`name`,`city_id`) VALUES('高平市','23');

--24	临汾市
INSERT `district`(`name`,`city_id`) VALUES('尧都区','24');
INSERT `district`(`name`,`city_id`) VALUES('曲沃县','24');
INSERT `district`(`name`,`city_id`) VALUES('翼城县','24');
INSERT `district`(`name`,`city_id`) VALUES('襄汾县','24');
INSERT `district`(`name`,`city_id`) VALUES('洪洞县','24');
INSERT `district`(`name`,`city_id`) VALUES('古县','24');
INSERT `district`(`name`,`city_id`) VALUES('安泽县','24');
INSERT `district`(`name`,`city_id`) VALUES('浮山县','24');
INSERT `district`(`name`,`city_id`) VALUES('吉县','24');
INSERT `district`(`name`,`city_id`) VALUES('乡宁县','24');
INSERT `district`(`name`,`city_id`) VALUES('大宁县','24');
INSERT `district`(`name`,`city_id`) VALUES('隰县','24');
INSERT `district`(`name`,`city_id`) VALUES('永和县','24');
INSERT `district`(`name`,`city_id`) VALUES('蒲县','24');
INSERT `district`(`name`,`city_id`) VALUES('汾西县','24');
INSERT `district`(`name`,`city_id`) VALUES('侯马市','24');
INSERT `district`(`name`,`city_id`) VALUES('霍州市','24');

--25	吕梁市
INSERT `district`(`name`,`city_id`) VALUES('离石区','25');
INSERT `district`(`name`,`city_id`) VALUES('文水县','25');
INSERT `district`(`name`,`city_id`) VALUES('交城县','25');
INSERT `district`(`name`,`city_id`) VALUES('兴县','25');
INSERT `district`(`name`,`city_id`) VALUES('临县','25');
INSERT `district`(`name`,`city_id`) VALUES('柳林县','25');
INSERT `district`(`name`,`city_id`) VALUES('石楼县','25');
INSERT `district`(`name`,`city_id`) VALUES('岚县','25');
INSERT `district`(`name`,`city_id`) VALUES('方山县','25');
INSERT `district`(`name`,`city_id`) VALUES('中阳县','25');
INSERT `district`(`name`,`city_id`) VALUES('交口县','25');
INSERT `district`(`name`,`city_id`) VALUES('孝义市','25');
INSERT `district`(`name`,`city_id`) VALUES('汾阳市','25');

--26	运城市
INSERT `district`(`name`,`city_id`) VALUES('盐湖区','26');
INSERT `district`(`name`,`city_id`) VALUES('临猗县','26');
INSERT `district`(`name`,`city_id`) VALUES('万荣县','26');
INSERT `district`(`name`,`city_id`) VALUES('闻喜县','26');
INSERT `district`(`name`,`city_id`) VALUES('稷山县','26');
INSERT `district`(`name`,`city_id`) VALUES('新绛县','26');
INSERT `district`(`name`,`city_id`) VALUES('绛县','26');
INSERT `district`(`name`,`city_id`) VALUES('垣曲县','26');
INSERT `district`(`name`,`city_id`) VALUES('夏县','26');
INSERT `district`(`name`,`city_id`) VALUES('平陆县','26');
INSERT `district`(`name`,`city_id`) VALUES('芮城县','26');
INSERT `district`(`name`,`city_id`) VALUES('永济市','26');
INSERT `district`(`name`,`city_id`) VALUES('河津市','26');

 
--*********************************************************辽宁************************************************************************
--27	沈阳市
INSERT `district`(`name`,`city_id`) VALUES('和平区','27');
INSERT `district`(`name`,`city_id`) VALUES('沈河区','27');
INSERT `district`(`name`,`city_id`) VALUES('大东区','27');
INSERT `district`(`name`,`city_id`) VALUES('皇姑区','27');
INSERT `district`(`name`,`city_id`) VALUES('铁西区','27');
INSERT `district`(`name`,`city_id`) VALUES('苏家屯区','27');
INSERT `district`(`name`,`city_id`) VALUES('东陵区','27');
INSERT `district`(`name`,`city_id`) VALUES('沈北新区','27');
INSERT `district`(`name`,`city_id`) VALUES('于洪区','27');
INSERT `district`(`name`,`city_id`) VALUES('辽中县','27');
INSERT `district`(`name`,`city_id`) VALUES('康平县','27');
INSERT `district`(`name`,`city_id`) VALUES('法库县','27');
INSERT `district`(`name`,`city_id`) VALUES('新民市','27');

--28	铁岭市
INSERT `district`(`name`,`city_id`) VALUES('银州区','28');
INSERT `district`(`name`,`city_id`) VALUES('清河区','28');
INSERT `district`(`name`,`city_id`) VALUES('铁岭县','28');
INSERT `district`(`name`,`city_id`) VALUES('西丰县','28');
INSERT `district`(`name`,`city_id`) VALUES('昌图县','28');
INSERT `district`(`name`,`city_id`) VALUES('调兵山市','28');
INSERT `district`(`name`,`city_id`) VALUES('开原市','28');


--29	大连市
INSERT `district`(`name`,`city_id`) VALUES('长海县','29');
INSERT `district`(`name`,`city_id`) VALUES('旅顺口区','29');
INSERT `district`(`name`,`city_id`) VALUES('中山区','29');
INSERT `district`(`name`,`city_id`) VALUES('西岗区','29');
INSERT `district`(`name`,`city_id`) VALUES('沙河口区','29');
INSERT `district`(`name`,`city_id`) VALUES('甘井子区','29');
INSERT `district`(`name`,`city_id`) VALUES('金州区','29');
INSERT `district`(`name`,`city_id`) VALUES('普兰店市','29');
INSERT `district`(`name`,`city_id`) VALUES('瓦房店市','29');
INSERT `district`(`name`,`city_id`) VALUES('庄河市','29');

--30	鞍山市
INSERT `district`(`name`,`city_id`) VALUES('铁东区','30');
INSERT `district`(`name`,`city_id`) VALUES('铁西区','30');
INSERT `district`(`name`,`city_id`) VALUES('立山区','30');
INSERT `district`(`name`,`city_id`) VALUES('千山区','30');
INSERT `district`(`name`,`city_id`) VALUES('台安县','30');
INSERT `district`(`name`,`city_id`) VALUES('岫岩满族自治县','30');
INSERT `district`(`name`,`city_id`) VALUES('海城市','30');

--31	抚顺市
INSERT `district`(`name`,`city_id`) VALUES('新抚区','31');
INSERT `district`(`name`,`city_id`) VALUES('东洲区','31');
INSERT `district`(`name`,`city_id`) VALUES('望花区','31');
INSERT `district`(`name`,`city_id`) VALUES('顺城区','31');
INSERT `district`(`name`,`city_id`) VALUES('抚顺县','31');
INSERT `district`(`name`,`city_id`) VALUES('新宾满族自治县','31');
INSERT `district`(`name`,`city_id`) VALUES('清原满族自治县','31');


--32	本溪市
INSERT `district`(`name`,`city_id`) VALUES('平山区','32');
INSERT `district`(`name`,`city_id`) VALUES('溪湖区','32');
INSERT `district`(`name`,`city_id`) VALUES('明山区','32');
INSERT `district`(`name`,`city_id`) VALUES('南芬区','32');
INSERT `district`(`name`,`city_id`) VALUES('本溪满族自治县','32');
INSERT `district`(`name`,`city_id`) VALUES('桓仁满族自治县','32');

--33	丹东市
INSERT `district`(`name`,`city_id`) VALUES('元宝区','33');
INSERT `district`(`name`,`city_id`) VALUES('振兴区','33');
INSERT `district`(`name`,`city_id`) VALUES('振安区','33');
INSERT `district`(`name`,`city_id`) VALUES('宽甸满族自治县','33');
INSERT `district`(`name`,`city_id`) VALUES('东港市','33');
INSERT `district`(`name`,`city_id`) VALUES('凤城市','33');


--34	锦州市
INSERT `district`(`name`,`city_id`) VALUES('古塔区','34');
INSERT `district`(`name`,`city_id`) VALUES('凌河区','34');
INSERT `district`(`name`,`city_id`) VALUES('太和区','34');
INSERT `district`(`name`,`city_id`) VALUES('黑山县','34');
INSERT `district`(`name`,`city_id`) VALUES('义县','34');
INSERT `district`(`name`,`city_id`) VALUES('凌海市','34');
INSERT `district`(`name`,`city_id`) VALUES('北镇市','34');


--35	营口市
INSERT `district`(`name`,`city_id`) VALUES('站前区','35');
INSERT `district`(`name`,`city_id`) VALUES('西市区','35');
INSERT `district`(`name`,`city_id`) VALUES('鮁鱼圈区','35');
INSERT `district`(`name`,`city_id`) VALUES('老边区','35');
INSERT `district`(`name`,`city_id`) VALUES('盖州市','35');
INSERT `district`(`name`,`city_id`) VALUES('大石桥市','35');


--36	阜新市
INSERT `district`(`name`,`city_id`) VALUES('海州区','36');
INSERT `district`(`name`,`city_id`) VALUES('新邱区','36');
INSERT `district`(`name`,`city_id`) VALUES('太平区','36');
INSERT `district`(`name`,`city_id`) VALUES('清河门区','36');
INSERT `district`(`name`,`city_id`) VALUES('细河区','36');
INSERT `district`(`name`,`city_id`) VALUES('阜新蒙古族自治县','36');
INSERT `district`(`name`,`city_id`) VALUES('彰武县','36');


--37	辽阳市
INSERT `district`(`name`,`city_id`) VALUES('白塔区','37');
INSERT `district`(`name`,`city_id`) VALUES('文圣区','37');
INSERT `district`(`name`,`city_id`) VALUES('宏伟区','37');
INSERT `district`(`name`,`city_id`) VALUES('弓长岭区','37');
INSERT `district`(`name`,`city_id`) VALUES('太子河区','37');
INSERT `district`(`name`,`city_id`) VALUES('辽阳县','37');
INSERT `district`(`name`,`city_id`) VALUES('灯塔市','37');


--38	朝阳市
INSERT `district`(`name`,`city_id`) VALUES('双塔区','38');
INSERT `district`(`name`,`city_id`) VALUES('龙城区','38');
INSERT `district`(`name`,`city_id`) VALUES('朝阳县','38');
INSERT `district`(`name`,`city_id`) VALUES('建平县','38');
INSERT `district`(`name`,`city_id`) VALUES('喀喇沁左翼蒙古族自治县','38');
INSERT `district`(`name`,`city_id`) VALUES('北票市','38');
INSERT `district`(`name`,`city_id`) VALUES('凌源市','38');


--39	盘锦市
INSERT `district`(`name`,`city_id`) VALUES('双台子区','39');
INSERT `district`(`name`,`city_id`) VALUES('兴隆台区','39');
INSERT `district`(`name`,`city_id`) VALUES('大洼县','39');
INSERT `district`(`name`,`city_id`) VALUES('盘山县','39');

--40	葫芦岛市
INSERT `district`(`name`,`city_id`) VALUES('连山区','40');
INSERT `district`(`name`,`city_id`) VALUES('龙港区','40');
INSERT `district`(`name`,`city_id`) VALUES('南票区','40');
INSERT `district`(`name`,`city_id`) VALUES('绥中县','40');
INSERT `district`(`name`,`city_id`) VALUES('建昌县','40');
INSERT `district`(`name`,`city_id`) VALUES('兴城市','40');


--*********************************************************吉林************************************************************************
--41	长春市
INSERT `district`(`name`,`city_id`) VALUES('南关区','41');
INSERT `district`(`name`,`city_id`) VALUES('宽城区','41');
INSERT `district`(`name`,`city_id`) VALUES('朝阳区','41');
INSERT `district`(`name`,`city_id`) VALUES('二道区','41');
INSERT `district`(`name`,`city_id`) VALUES('绿园区','41');
INSERT `district`(`name`,`city_id`) VALUES('双阳区','41');
INSERT `district`(`name`,`city_id`) VALUES('农安县','41');
INSERT `district`(`name`,`city_id`) VALUES('九台市','41');
INSERT `district`(`name`,`city_id`) VALUES('榆树市','41');
INSERT `district`(`name`,`city_id`) VALUES('德惠市','41');


--42	吉林市
INSERT `district`(`name`,`city_id`) VALUES('昌邑区','42');
INSERT `district`(`name`,`city_id`) VALUES('龙潭区','42');
INSERT `district`(`name`,`city_id`) VALUES('船营区','42');
INSERT `district`(`name`,`city_id`) VALUES('丰满区','42');
INSERT `district`(`name`,`city_id`) VALUES('永吉县','42');
INSERT `district`(`name`,`city_id`) VALUES('蛟河市','42');
INSERT `district`(`name`,`city_id`) VALUES('桦甸市','42');
INSERT `district`(`name`,`city_id`) VALUES('舒兰市','42');
INSERT `district`(`name`,`city_id`) VALUES('磐石市','42');


--43	延边朝鲜族自治州
INSERT `district`(`name`,`city_id`) VALUES('延吉市','43');
INSERT `district`(`name`,`city_id`) VALUES('图们市','43');
INSERT `district`(`name`,`city_id`) VALUES('敦化市','43');
INSERT `district`(`name`,`city_id`) VALUES('珲春市','43');
INSERT `district`(`name`,`city_id`) VALUES('龙井市','43');
INSERT `district`(`name`,`city_id`) VALUES('和龙市','43');
INSERT `district`(`name`,`city_id`) VALUES('汪清县','43');
INSERT `district`(`name`,`city_id`) VALUES('安图县','43');


--44	四平市
INSERT `district`(`name`,`city_id`) VALUES('铁西区','44');
INSERT `district`(`name`,`city_id`) VALUES('铁东区','44');
INSERT `district`(`name`,`city_id`) VALUES('梨树县','44');
INSERT `district`(`name`,`city_id`) VALUES('伊通满族自治县','44');
INSERT `district`(`name`,`city_id`) VALUES('公主岭市','44');
INSERT `district`(`name`,`city_id`) VALUES('双辽市','44');


--45	通化市
INSERT `district`(`name`,`city_id`) VALUES('东昌区','45');
INSERT `district`(`name`,`city_id`) VALUES('二道江区','45');
INSERT `district`(`name`,`city_id`) VALUES('通化县','45');
INSERT `district`(`name`,`city_id`) VALUES('辉南县','45');
INSERT `district`(`name`,`city_id`) VALUES('柳河县','45');
INSERT `district`(`name`,`city_id`) VALUES('梅河口市','45');
INSERT `district`(`name`,`city_id`) VALUES('集安市','45');


--46	白城市
INSERT `district`(`name`,`city_id`) VALUES('洮北区','46');
INSERT `district`(`name`,`city_id`) VALUES('镇赉县','46');
INSERT `district`(`name`,`city_id`) VALUES('通榆县','46');
INSERT `district`(`name`,`city_id`) VALUES('洮南市','46');
INSERT `district`(`name`,`city_id`) VALUES('大安市','46');


--47	辽源市
INSERT `district`(`name`,`city_id`) VALUES('龙山区','47');
INSERT `district`(`name`,`city_id`) VALUES('西安区','47');
INSERT `district`(`name`,`city_id`) VALUES('东丰县','47');
INSERT `district`(`name`,`city_id`) VALUES('东辽县','47');


--48	松原市
INSERT `district`(`name`,`city_id`) VALUES('宁江区','48');
INSERT `district`(`name`,`city_id`) VALUES('前郭尔罗斯蒙古族自治县','48');
INSERT `district`(`name`,`city_id`) VALUES('长岭县','48');
INSERT `district`(`name`,`city_id`) VALUES('乾安县','48');
INSERT `district`(`name`,`city_id`) VALUES('扶余县','48');


--49	白山市
INSERT `district`(`name`,`city_id`) VALUES('八道江区','49');
INSERT `district`(`name`,`city_id`) VALUES('江源区','49');
INSERT `district`(`name`,`city_id`) VALUES('抚松县','49');
INSERT `district`(`name`,`city_id`) VALUES('靖宇县','49');
INSERT `district`(`name`,`city_id`) VALUES('长白朝鲜族自治县','49');
INSERT `district`(`name`,`city_id`) VALUES('临江市','49');


--*********************************************************黑龙江************************************************************************
--50	哈尔滨市
INSERT `district`(`name`,`city_id`) VALUES('道里区','50');
INSERT `district`(`name`,`city_id`) VALUES('南岗区','50');
INSERT `district`(`name`,`city_id`) VALUES('道外区','50');
INSERT `district`(`name`,`city_id`) VALUES('平房区','50');
INSERT `district`(`name`,`city_id`) VALUES('松北区','50');
INSERT `district`(`name`,`city_id`) VALUES('香坊区','50');
INSERT `district`(`name`,`city_id`) VALUES('呼兰区','50');
INSERT `district`(`name`,`city_id`) VALUES('阿城区','50');
INSERT `district`(`name`,`city_id`) VALUES('依兰县','50');
INSERT `district`(`name`,`city_id`) VALUES('方正县','50');
INSERT `district`(`name`,`city_id`) VALUES('宾县','50');
INSERT `district`(`name`,`city_id`) VALUES('巴彦县','50');
INSERT `district`(`name`,`city_id`) VALUES('木兰县','50');
INSERT `district`(`name`,`city_id`) VALUES('通河县','50');
INSERT `district`(`name`,`city_id`) VALUES('延寿县','50');
INSERT `district`(`name`,`city_id`) VALUES('双城市','50');
INSERT `district`(`name`,`city_id`) VALUES('尚志市','50');
INSERT `district`(`name`,`city_id`) VALUES('五常市','50');

--51	齐齐哈尔市
INSERT `district`(`name`,`city_id`) VALUES('龙沙区','51');
INSERT `district`(`name`,`city_id`) VALUES('建华区','51');
INSERT `district`(`name`,`city_id`) VALUES('铁锋区','51');
INSERT `district`(`name`,`city_id`) VALUES('昂昂溪区','51');
INSERT `district`(`name`,`city_id`) VALUES('富拉尔基区','51');
INSERT `district`(`name`,`city_id`) VALUES('碾子山区','51');
INSERT `district`(`name`,`city_id`) VALUES('梅里斯达翰尔族区','51');
INSERT `district`(`name`,`city_id`) VALUES('龙江县','51');
INSERT `district`(`name`,`city_id`) VALUES('依安县','51');
INSERT `district`(`name`,`city_id`) VALUES('泰来县','51');
INSERT `district`(`name`,`city_id`) VALUES('甘南县','51');
INSERT `district`(`name`,`city_id`) VALUES('富裕县','51');
INSERT `district`(`name`,`city_id`) VALUES('克山县','51');
INSERT `district`(`name`,`city_id`) VALUES('克东县','51');
INSERT `district`(`name`,`city_id`) VALUES('拜泉县','51');
INSERT `district`(`name`,`city_id`) VALUES('讷河市','51');

--52	鸡西市
INSERT `district`(`name`,`city_id`) VALUES('鸡冠区','52');
INSERT `district`(`name`,`city_id`) VALUES('恒山区','52');
INSERT `district`(`name`,`city_id`) VALUES('滴道区','52');
INSERT `district`(`name`,`city_id`) VALUES('梨树区','52');
INSERT `district`(`name`,`city_id`) VALUES('城子河区','52');
INSERT `district`(`name`,`city_id`) VALUES('麻山区','52');
INSERT `district`(`name`,`city_id`) VALUES('鸡东县','52');
INSERT `district`(`name`,`city_id`) VALUES('虎林市','52');
INSERT `district`(`name`,`city_id`) VALUES('密山市','52');

--53	牡丹江市
INSERT `district`(`name`,`city_id`) VALUES('东安区','53');
INSERT `district`(`name`,`city_id`) VALUES('阳明区','53');
INSERT `district`(`name`,`city_id`) VALUES('爱民区','53');
INSERT `district`(`name`,`city_id`) VALUES('西安区','53');
INSERT `district`(`name`,`city_id`) VALUES('东宁县','53');
INSERT `district`(`name`,`city_id`) VALUES('林口县','53');
INSERT `district`(`name`,`city_id`) VALUES('绥芬河市','53');
INSERT `district`(`name`,`city_id`) VALUES('海林市','53');
INSERT `district`(`name`,`city_id`) VALUES('宁安市','53');
INSERT `district`(`name`,`city_id`) VALUES('穆棱市','53');

--54	七台河市
INSERT `district`(`name`,`city_id`) VALUES('新兴区','54');
INSERT `district`(`name`,`city_id`) VALUES('桃山区','54');
INSERT `district`(`name`,`city_id`) VALUES('茄子河区','54');
INSERT `district`(`name`,`city_id`) VALUES('勃利县','54');


--55	佳木斯市
INSERT `district`(`name`,`city_id`) VALUES('向阳区','55');
INSERT `district`(`name`,`city_id`) VALUES('前进区','55');
INSERT `district`(`name`,`city_id`) VALUES('东风区','55');
INSERT `district`(`name`,`city_id`) VALUES('桦南县','55');
INSERT `district`(`name`,`city_id`) VALUES('桦川县','55');
INSERT `district`(`name`,`city_id`) VALUES('汤原县','55');
INSERT `district`(`name`,`city_id`) VALUES('抚远县','55');
INSERT `district`(`name`,`city_id`) VALUES('同江市','55');
INSERT `district`(`name`,`city_id`) VALUES('富锦市','55');


--56	鹤岗市
INSERT `district`(`name`,`city_id`) VALUES('向阳区','56');
INSERT `district`(`name`,`city_id`) VALUES('工农区','56');
INSERT `district`(`name`,`city_id`) VALUES('南山区','56');
INSERT `district`(`name`,`city_id`) VALUES('兴安区','56');
INSERT `district`(`name`,`city_id`) VALUES('东山区','56');
INSERT `district`(`name`,`city_id`) VALUES('兴山区','56');
INSERT `district`(`name`,`city_id`) VALUES('萝北县','56');
INSERT `district`(`name`,`city_id`) VALUES('绥滨县','56');


--57	双鸭山市
INSERT `district`(`name`,`city_id`) VALUES('尖山区','57');
INSERT `district`(`name`,`city_id`) VALUES('岭东区','57');
INSERT `district`(`name`,`city_id`) VALUES('四方台区','57');
INSERT `district`(`name`,`city_id`) VALUES('宝山区','57');
INSERT `district`(`name`,`city_id`) VALUES('集贤县','57');
INSERT `district`(`name`,`city_id`) VALUES('友谊县','57');
INSERT `district`(`name`,`city_id`) VALUES('宝清县','57');
INSERT `district`(`name`,`city_id`) VALUES('饶河县','57');


--58	绥化市
INSERT `district`(`name`,`city_id`) VALUES('北林区','58');
INSERT `district`(`name`,`city_id`) VALUES('望奎县','58');
INSERT `district`(`name`,`city_id`) VALUES('兰西县','58');
INSERT `district`(`name`,`city_id`) VALUES('青冈县','58');
INSERT `district`(`name`,`city_id`) VALUES('庆安县','58');
INSERT `district`(`name`,`city_id`) VALUES('明水县','58');
INSERT `district`(`name`,`city_id`) VALUES('绥棱县','58');
INSERT `district`(`name`,`city_id`) VALUES('安达市','58');
INSERT `district`(`name`,`city_id`) VALUES('肇东市','58');
INSERT `district`(`name`,`city_id`) VALUES('海伦市','58');

--59	黑河市
INSERT `district`(`name`,`city_id`) VALUES('爱辉区','59');
INSERT `district`(`name`,`city_id`) VALUES('嫩江县','59');
INSERT `district`(`name`,`city_id`) VALUES('逊克县','59');
INSERT `district`(`name`,`city_id`) VALUES('孙吴县','59');
INSERT `district`(`name`,`city_id`) VALUES('北安市','59');
INSERT `district`(`name`,`city_id`) VALUES('五大连池市','59');

--60	大兴安岭地区
INSERT `district`(`name`,`city_id`) VALUES('呼玛县','60');
INSERT `district`(`name`,`city_id`) VALUES('塔河县','60');
INSERT `district`(`name`,`city_id`) VALUES('漠河县','60');

--61	伊春市
INSERT `district`(`name`,`city_id`) VALUES('伊春区','61');
INSERT `district`(`name`,`city_id`) VALUES('南岔区','61');
INSERT `district`(`name`,`city_id`) VALUES('友好区','61');
INSERT `district`(`name`,`city_id`) VALUES('西林区','61');
INSERT `district`(`name`,`city_id`) VALUES('翠峦区','61');
INSERT `district`(`name`,`city_id`) VALUES('新青区','61');
INSERT `district`(`name`,`city_id`) VALUES('美溪区','61');
INSERT `district`(`name`,`city_id`) VALUES('金山屯区','61');
INSERT `district`(`name`,`city_id`) VALUES('五营区','61');
INSERT `district`(`name`,`city_id`) VALUES('乌马河区','61');
INSERT `district`(`name`,`city_id`) VALUES('汤旺河区','61');
INSERT `district`(`name`,`city_id`) VALUES('带岭区','61');
INSERT `district`(`name`,`city_id`) VALUES('乌伊岭区','61');
INSERT `district`(`name`,`city_id`) VALUES('红星区','61');
INSERT `district`(`name`,`city_id`) VALUES('上甘岭区','61');
INSERT `district`(`name`,`city_id`) VALUES('嘉荫县','61');
INSERT `district`(`name`,`city_id`) VALUES('铁力市','61');


--62	大庆市
INSERT `district`(`name`,`city_id`) VALUES('萨尔图区','62');
INSERT `district`(`name`,`city_id`) VALUES('龙凤区','62');
INSERT `district`(`name`,`city_id`) VALUES('让胡路区','62');
INSERT `district`(`name`,`city_id`) VALUES('红岗区','62');
INSERT `district`(`name`,`city_id`) VALUES('大同区','62');
INSERT `district`(`name`,`city_id`) VALUES('肇州县','62');
INSERT `district`(`name`,`city_id`) VALUES('肇源县','62');
INSERT `district`(`name`,`city_id`) VALUES('林甸县','62');
INSERT `district`(`name`,`city_id`) VALUES('杜尔伯特蒙古族自治县','62');

--*********************************************************江苏************************************************************************
--63	南京市
INSERT `district`(`name`,`city_id`) VALUES('江宁区','63');
INSERT `district`(`name`,`city_id`) VALUES('浦口区','63');
INSERT `district`(`name`,`city_id`) VALUES('玄武区','63');
INSERT `district`(`name`,`city_id`) VALUES('白下区','63');
INSERT `district`(`name`,`city_id`) VALUES('秦淮区','63');
INSERT `district`(`name`,`city_id`) VALUES('建邺区','63');
INSERT `district`(`name`,`city_id`) VALUES('鼓楼区','63');
INSERT `district`(`name`,`city_id`) VALUES('下关区','63');
INSERT `district`(`name`,`city_id`) VALUES('栖霞区','63');
INSERT `district`(`name`,`city_id`) VALUES('雨花台区','63');
INSERT `district`(`name`,`city_id`) VALUES('六合区','63');
INSERT `district`(`name`,`city_id`) VALUES('溧水县','63');
INSERT `district`(`name`,`city_id`) VALUES('高淳县','63');

--64	无锡市
INSERT `district`(`name`,`city_id`) VALUES('崇安区','64');
INSERT `district`(`name`,`city_id`) VALUES('南长区','64');
INSERT `district`(`name`,`city_id`) VALUES('北塘区','64');
INSERT `district`(`name`,`city_id`) VALUES('锡山区','64');
INSERT `district`(`name`,`city_id`) VALUES('惠山区','64');
INSERT `district`(`name`,`city_id`) VALUES('滨湖区','64');
INSERT `district`(`name`,`city_id`) VALUES('江阴市','64');
INSERT `district`(`name`,`city_id`) VALUES('宜兴市','64');


--65	镇江市
INSERT `district`(`name`,`city_id`) VALUES('京口区','65');
INSERT `district`(`name`,`city_id`) VALUES('润州区','65');
INSERT `district`(`name`,`city_id`) VALUES('丹徒区','65');
INSERT `district`(`name`,`city_id`) VALUES('丹阳市','65');
INSERT `district`(`name`,`city_id`) VALUES('扬中市','65');
INSERT `district`(`name`,`city_id`) VALUES('句容市','65');

--66	苏州市
INSERT `district`(`name`,`city_id`) VALUES('沧浪区','66');
INSERT `district`(`name`,`city_id`) VALUES('常熟市','66');
INSERT `district`(`name`,`city_id`) VALUES('平江区','66');
INSERT `district`(`name`,`city_id`) VALUES('金阊区','66');
INSERT `district`(`name`,`city_id`) VALUES('虎丘区','66');
INSERT `district`(`name`,`city_id`) VALUES('昆山市','66');
INSERT `district`(`name`,`city_id`) VALUES('太仓市','66');
INSERT `district`(`name`,`city_id`) VALUES('吴江市','66');
INSERT `district`(`name`,`city_id`) VALUES('吴中区','66');
INSERT `district`(`name`,`city_id`) VALUES('相城区','66');
INSERT `district`(`name`,`city_id`) VALUES('张家港市','66');

--67	南通市
INSERT `district`(`name`,`city_id`) VALUES('崇川区','67');
INSERT `district`(`name`,`city_id`) VALUES('港闸区','67');
INSERT `district`(`name`,`city_id`) VALUES('海安县','67');
INSERT `district`(`name`,`city_id`) VALUES('如东县','67');
INSERT `district`(`name`,`city_id`) VALUES('启东市','67');
INSERT `district`(`name`,`city_id`) VALUES('如皋市','67');
INSERT `district`(`name`,`city_id`) VALUES('通州市','67');
INSERT `district`(`name`,`city_id`) VALUES('海门市','67');

--68	扬州市
INSERT `district`(`name`,`city_id`) VALUES('高邮市','68');
INSERT `district`(`name`,`city_id`) VALUES('广陵区','68');
INSERT `district`(`name`,`city_id`) VALUES('邗江区','68');
INSERT `district`(`name`,`city_id`) VALUES('维扬区','68');
INSERT `district`(`name`,`city_id`) VALUES('宝应县','68');
INSERT `district`(`name`,`city_id`) VALUES('江都市','68');
INSERT `district`(`name`,`city_id`) VALUES('仪征市','68');

--69	盐城市
INSERT `district`(`name`,`city_id`) VALUES('亭湖区','69');
INSERT `district`(`name`,`city_id`) VALUES('盐都区','69');
INSERT `district`(`name`,`city_id`) VALUES('响水县','69');
INSERT `district`(`name`,`city_id`) VALUES('滨海县','69');
INSERT `district`(`name`,`city_id`) VALUES('阜宁县','69');
INSERT `district`(`name`,`city_id`) VALUES('射阳县','69');
INSERT `district`(`name`,`city_id`) VALUES('建湖县','69');
INSERT `district`(`name`,`city_id`) VALUES('东台市','69');
INSERT `district`(`name`,`city_id`) VALUES('大丰市','69');

--70	徐州市
INSERT `district`(`name`,`city_id`) VALUES('鼓楼区','70');
INSERT `district`(`name`,`city_id`) VALUES('云龙区','70');
INSERT `district`(`name`,`city_id`) VALUES('九里区','70');
INSERT `district`(`name`,`city_id`) VALUES('贾汪区','70');
INSERT `district`(`name`,`city_id`) VALUES('泉山区','70');
INSERT `district`(`name`,`city_id`) VALUES('丰县','70');
INSERT `district`(`name`,`city_id`) VALUES('沛县','70');
INSERT `district`(`name`,`city_id`) VALUES('铜山县','70');
INSERT `district`(`name`,`city_id`) VALUES('睢宁县','70');
INSERT `district`(`name`,`city_id`) VALUES('新沂市','70');
INSERT `district`(`name`,`city_id`) VALUES('邳州市','70');

--71	淮安市
INSERT `district`(`name`,`city_id`) VALUES('清河区','71');
INSERT `district`(`name`,`city_id`) VALUES('楚州区','71');
INSERT `district`(`name`,`city_id`) VALUES('淮阴区','71');
INSERT `district`(`name`,`city_id`) VALUES('清浦区','71');
INSERT `district`(`name`,`city_id`) VALUES('涟水县','71');
INSERT `district`(`name`,`city_id`) VALUES('洪泽县','71');
INSERT `district`(`name`,`city_id`) VALUES('盱眙县','71');
INSERT `district`(`name`,`city_id`) VALUES('金湖县','71');


--72	连云港市
INSERT `district`(`name`,`city_id`) VALUES('连云区','72');
INSERT `district`(`name`,`city_id`) VALUES('新浦区','72');
INSERT `district`(`name`,`city_id`) VALUES('海州区','72');
INSERT `district`(`name`,`city_id`) VALUES('赣榆县','72');
INSERT `district`(`name`,`city_id`) VALUES('东海县','72');
INSERT `district`(`name`,`city_id`) VALUES('灌云县','72');
INSERT `district`(`name`,`city_id`) VALUES('灌南县','72');


--73	常州市
INSERT `district`(`name`,`city_id`) VALUES('天宁区','73');
INSERT `district`(`name`,`city_id`) VALUES('钟楼区','73');
INSERT `district`(`name`,`city_id`) VALUES('戚墅堰区','73');
INSERT `district`(`name`,`city_id`) VALUES('新北区','73');
INSERT `district`(`name`,`city_id`) VALUES('武进区','73');
INSERT `district`(`name`,`city_id`) VALUES('溧阳市','73');
INSERT `district`(`name`,`city_id`) VALUES('金坛市','73');

--74	泰州市
INSERT `district`(`name`,`city_id`) VALUES('海陵区','74');
INSERT `district`(`name`,`city_id`) VALUES('高港区','74');
INSERT `district`(`name`,`city_id`) VALUES('兴化市','74');
INSERT `district`(`name`,`city_id`) VALUES('靖江市','74');
INSERT `district`(`name`,`city_id`) VALUES('泰兴市','74');
INSERT `district`(`name`,`city_id`) VALUES('姜堰市','74');


--75	宿迁市
INSERT `district`(`name`,`city_id`) VALUES('宿城区','75');
INSERT `district`(`name`,`city_id`) VALUES('宿豫区','75');
INSERT `district`(`name`,`city_id`) VALUES('沭阳县','75');
INSERT `district`(`name`,`city_id`) VALUES('泗阳县','75');
INSERT `district`(`name`,`city_id`) VALUES('泗洪县','75');

--*********************************************************浙江************************************************************************
--76	舟山市
INSERT `district`(`name`,`city_id`) VALUES('定海区','76');
INSERT `district`(`name`,`city_id`) VALUES('普陀区','76');
INSERT `district`(`name`,`city_id`) VALUES('岱山县','76');
INSERT `district`(`name`,`city_id`) VALUES('嵊泗县','76');

--77	衢州市
INSERT `district`(`name`,`city_id`) VALUES('柯城区','77');
INSERT `district`(`name`,`city_id`) VALUES('衢江区','77');
INSERT `district`(`name`,`city_id`) VALUES('常山县','77');
INSERT `district`(`name`,`city_id`) VALUES('开化县','77');
INSERT `district`(`name`,`city_id`) VALUES('龙游县','77');
INSERT `district`(`name`,`city_id`) VALUES('江山市','77');


--78	杭州市
INSERT `district`(`name`,`city_id`) VALUES('上城区','78');
INSERT `district`(`name`,`city_id`) VALUES('下城区','78');
INSERT `district`(`name`,`city_id`) VALUES('江干区','78');
INSERT `district`(`name`,`city_id`) VALUES('拱墅区','78');
INSERT `district`(`name`,`city_id`) VALUES('西湖区','78');
INSERT `district`(`name`,`city_id`) VALUES('滨江区','78');
INSERT `district`(`name`,`city_id`) VALUES('余杭区','78');
INSERT `district`(`name`,`city_id`) VALUES('桐庐县','78');
INSERT `district`(`name`,`city_id`) VALUES('淳安县','78');
INSERT `district`(`name`,`city_id`) VALUES('建德市','78');
INSERT `district`(`name`,`city_id`) VALUES('富阳市','78');
INSERT `district`(`name`,`city_id`) VALUES('临安市','78');
INSERT `district`(`name`,`city_id`) VALUES('萧山区','78');

--79	湖州市
INSERT `district`(`name`,`city_id`) VALUES('吴兴区','79');
INSERT `district`(`name`,`city_id`) VALUES('南浔区','79');
INSERT `district`(`name`,`city_id`) VALUES('德清县','79');
INSERT `district`(`name`,`city_id`) VALUES('长兴县','79');
INSERT `district`(`name`,`city_id`) VALUES('安吉县','79');

--80	嘉兴市
INSERT `district`(`name`,`city_id`) VALUES(' 南湖区','80');
INSERT `district`(`name`,`city_id`) VALUES(' 秀洲区','80');
INSERT `district`(`name`,`city_id`) VALUES(' 嘉善县','80');
INSERT `district`(`name`,`city_id`) VALUES(' 海盐县','80');
INSERT `district`(`name`,`city_id`) VALUES(' 海宁市','80');
INSERT `district`(`name`,`city_id`) VALUES(' 平湖市','80');
INSERT `district`(`name`,`city_id`) VALUES(' 桐乡市 ','80');


--81	宁波市
INSERT `district`(`name`,`city_id`) VALUES('海曙区','81');
INSERT `district`(`name`,`city_id`) VALUES('江东区','81');
INSERT `district`(`name`,`city_id`) VALUES('江北区','81');
INSERT `district`(`name`,`city_id`) VALUES('北仑区','81');
INSERT `district`(`name`,`city_id`) VALUES('镇海区','81');
INSERT `district`(`name`,`city_id`) VALUES('鄞州区','81');
INSERT `district`(`name`,`city_id`) VALUES('象山县','81');
INSERT `district`(`name`,`city_id`) VALUES('宁海县','81');
INSERT `district`(`name`,`city_id`) VALUES('余姚市','81');
INSERT `district`(`name`,`city_id`) VALUES('慈溪市','81');
INSERT `district`(`name`,`city_id`) VALUES('奉化市','81');


--82	绍兴市
INSERT `district`(`name`,`city_id`) VALUES('越城区','82');
INSERT `district`(`name`,`city_id`) VALUES('绍兴县','82');
INSERT `district`(`name`,`city_id`) VALUES('新昌县','82');
INSERT `district`(`name`,`city_id`) VALUES('诸暨市','82');
INSERT `district`(`name`,`city_id`) VALUES('上虞市','82');
INSERT `district`(`name`,`city_id`) VALUES('嵊州市','82');


--83	温州市
INSERT `district`(`name`,`city_id`) VALUES('鹿城区','83');
INSERT `district`(`name`,`city_id`) VALUES('龙湾区','83');
INSERT `district`(`name`,`city_id`) VALUES('瓯海区','83');
INSERT `district`(`name`,`city_id`) VALUES('洞头县','83');
INSERT `district`(`name`,`city_id`) VALUES('永嘉县','83');
INSERT `district`(`name`,`city_id`) VALUES('平阳县','83');
INSERT `district`(`name`,`city_id`) VALUES('苍南县','83');
INSERT `district`(`name`,`city_id`) VALUES('文成县','83');
INSERT `district`(`name`,`city_id`) VALUES('泰顺县','83');
INSERT `district`(`name`,`city_id`) VALUES('瑞安市','83');
INSERT `district`(`name`,`city_id`) VALUES('乐清市','83');


--84	丽水市
INSERT `district`(`name`,`city_id`) VALUES('莲都区','84');
INSERT `district`(`name`,`city_id`) VALUES('青田县','84');
INSERT `district`(`name`,`city_id`) VALUES('缙云县','84');
INSERT `district`(`name`,`city_id`) VALUES('遂昌县','84');
INSERT `district`(`name`,`city_id`) VALUES('松阳县','84');
INSERT `district`(`name`,`city_id`) VALUES('云和县','84');
INSERT `district`(`name`,`city_id`) VALUES('庆元县','84');
INSERT `district`(`name`,`city_id`) VALUES('景宁畲族自治县','84');
INSERT `district`(`name`,`city_id`) VALUES('龙泉市','84');


--85	金华市
INSERT `district`(`name`,`city_id`) VALUES('婺城区','85');
INSERT `district`(`name`,`city_id`) VALUES('金东区','85');
INSERT `district`(`name`,`city_id`) VALUES('武义县','85');
INSERT `district`(`name`,`city_id`) VALUES('浦江县','85');
INSERT `district`(`name`,`city_id`) VALUES('磐安县','85');
INSERT `district`(`name`,`city_id`) VALUES('兰溪市','85');
INSERT `district`(`name`,`city_id`) VALUES('义乌市','85');
INSERT `district`(`name`,`city_id`) VALUES('东阳市','85');
INSERT `district`(`name`,`city_id`) VALUES('永康市','85');

--86	台州市
INSERT `district`(`name`,`city_id`) VALUES('椒江区','86');
INSERT `district`(`name`,`city_id`) VALUES('黄岩区','86');
INSERT `district`(`name`,`city_id`) VALUES('路桥区','86');
INSERT `district`(`name`,`city_id`) VALUES('玉环县','86');
INSERT `district`(`name`,`city_id`) VALUES('三门县','86');
INSERT `district`(`name`,`city_id`) VALUES('天台县','86');
INSERT `district`(`name`,`city_id`) VALUES('仙居县','86');
INSERT `district`(`name`,`city_id`) VALUES('温岭市','86');
INSERT `district`(`name`,`city_id`) VALUES('临海市','86');



--*********************************************************安徽************************************************************************
--87	合肥市
INSERT `district`(`name`,`city_id`) VALUES('瑶海区','87');
INSERT `district`(`name`,`city_id`) VALUES('庐阳区','87');
INSERT `district`(`name`,`city_id`) VALUES('蜀山区','87');
INSERT `district`(`name`,`city_id`) VALUES('包河区','87');
INSERT `district`(`name`,`city_id`) VALUES('长丰县','87');
INSERT `district`(`name`,`city_id`) VALUES('肥东县','87');
INSERT `district`(`name`,`city_id`) VALUES('肥西县','87');

--88	芜湖市
INSERT `district`(`name`,`city_id`) VALUES('镜湖区','88');
INSERT `district`(`name`,`city_id`) VALUES('弋江区','88');
INSERT `district`(`name`,`city_id`) VALUES('鸠江区','88');
INSERT `district`(`name`,`city_id`) VALUES('三山区','88');
INSERT `district`(`name`,`city_id`) VALUES('芜湖县','88');
INSERT `district`(`name`,`city_id`) VALUES('繁昌县','88');
INSERT `district`(`name`,`city_id`) VALUES('南陵县','88');

--89	蚌埠市
INSERT `district`(`name`,`city_id`) VALUES('龙子湖区','89');
INSERT `district`(`name`,`city_id`) VALUES('蚌山区','89');
INSERT `district`(`name`,`city_id`) VALUES('禹会区','89');
INSERT `district`(`name`,`city_id`) VALUES('淮上区','89');
INSERT `district`(`name`,`city_id`) VALUES('怀远县','89');
INSERT `district`(`name`,`city_id`) VALUES('五河县','89');
INSERT `district`(`name`,`city_id`) VALUES('固镇县','89');


--90	淮南市
INSERT `district`(`name`,`city_id`) VALUES('大通区','90');
INSERT `district`(`name`,`city_id`) VALUES('田家庵区','90');
INSERT `district`(`name`,`city_id`) VALUES('谢家集区','90');
INSERT `district`(`name`,`city_id`) VALUES('八公山区','90');
INSERT `district`(`name`,`city_id`) VALUES('潘集区','90');
INSERT `district`(`name`,`city_id`) VALUES('凤台县','90');


--91	马鞍山市
INSERT `district`(`name`,`city_id`) VALUES('金家庄区','91');
INSERT `district`(`name`,`city_id`) VALUES('花山区','91');
INSERT `district`(`name`,`city_id`) VALUES('雨山区','91');
INSERT `district`(`name`,`city_id`) VALUES('当涂县','91');


--92	淮北市
INSERT `district`(`name`,`city_id`) VALUES('杜集区','92');
INSERT `district`(`name`,`city_id`) VALUES('相山区','92');
INSERT `district`(`name`,`city_id`) VALUES('烈山区','92');
INSERT `district`(`name`,`city_id`) VALUES('濉溪县 ','92');


--93	铜陵市
INSERT `district`(`name`,`city_id`) VALUES('铜官山区','93');
INSERT `district`(`name`,`city_id`) VALUES('狮子山区','93');
INSERT `district`(`name`,`city_id`) VALUES('铜陵县','93');


--94	安庆市
INSERT `district`(`name`,`city_id`) VALUES('迎江区','94');
INSERT `district`(`name`,`city_id`) VALUES('大观区','94');
INSERT `district`(`name`,`city_id`) VALUES('宜秀区','94');
INSERT `district`(`name`,`city_id`) VALUES('怀宁县','94');
INSERT `district`(`name`,`city_id`) VALUES('枞阳县','94');
INSERT `district`(`name`,`city_id`) VALUES('潜山县','94');
INSERT `district`(`name`,`city_id`) VALUES('太湖县','94');
INSERT `district`(`name`,`city_id`) VALUES('宿松县','94');
INSERT `district`(`name`,`city_id`) VALUES('望江县','94');
INSERT `district`(`name`,`city_id`) VALUES('岳西县','94');
INSERT `district`(`name`,`city_id`) VALUES('桐城市','94');


--95	黄山市
INSERT `district`(`name`,`city_id`) VALUES('屯溪区','95');
INSERT `district`(`name`,`city_id`) VALUES('黄山区','95');
INSERT `district`(`name`,`city_id`) VALUES('徽州区','95');
INSERT `district`(`name`,`city_id`) VALUES('歙县','95');
INSERT `district`(`name`,`city_id`) VALUES('休宁县','95');
INSERT `district`(`name`,`city_id`) VALUES('黟县','95');
INSERT `district`(`name`,`city_id`) VALUES('祁门县','95');


--96	滁州市
INSERT `district`(`name`,`city_id`) VALUES('琅琊区','96');
INSERT `district`(`name`,`city_id`) VALUES('南谯区','96');
INSERT `district`(`name`,`city_id`) VALUES('来安县','96');
INSERT `district`(`name`,`city_id`) VALUES('全椒县','96');
INSERT `district`(`name`,`city_id`) VALUES('定远县','96');
INSERT `district`(`name`,`city_id`) VALUES('凤阳县','96');
INSERT `district`(`name`,`city_id`) VALUES('天长市','96');
INSERT `district`(`name`,`city_id`) VALUES('明光市','96');


--97	阜阳市
INSERT `district`(`name`,`city_id`) VALUES('颍州区','97');
INSERT `district`(`name`,`city_id`) VALUES('颍东区','97');
INSERT `district`(`name`,`city_id`) VALUES('颍泉区','97');
INSERT `district`(`name`,`city_id`) VALUES('临泉县','97');
INSERT `district`(`name`,`city_id`) VALUES('太和县','97');
INSERT `district`(`name`,`city_id`) VALUES('阜南县','97');
INSERT `district`(`name`,`city_id`) VALUES('颍上县','97');
INSERT `district`(`name`,`city_id`) VALUES('界首市','97');


--98	宿州市
INSERT `district`(`name`,`city_id`) VALUES('埇桥区','98');
INSERT `district`(`name`,`city_id`) VALUES('砀山县','98');
INSERT `district`(`name`,`city_id`) VALUES('萧县','98');
INSERT `district`(`name`,`city_id`) VALUES('灵璧县','98');
INSERT `district`(`name`,`city_id`) VALUES('泗县 ','98');


--99	巢湖市
INSERT `district`(`name`,`city_id`) VALUES('居巢区','99');
INSERT `district`(`name`,`city_id`) VALUES('庐江县','99');
INSERT `district`(`name`,`city_id`) VALUES('无为县','99');
INSERT `district`(`name`,`city_id`) VALUES('含山县','99');
INSERT `district`(`name`,`city_id`) VALUES('和县 ','99');


--100	六安市
INSERT `district`(`name`,`city_id`) VALUES('金安区','100');
INSERT `district`(`name`,`city_id`) VALUES('裕安区','100');
INSERT `district`(`name`,`city_id`) VALUES('寿县','100');
INSERT `district`(`name`,`city_id`) VALUES('霍邱县','100');
INSERT `district`(`name`,`city_id`) VALUES('舒城县','100');
INSERT `district`(`name`,`city_id`) VALUES('金寨县','100');
INSERT `district`(`name`,`city_id`) VALUES('霍山县','100');


--101	亳州市
INSERT `district`(`name`,`city_id`) VALUES('谯城区','101');
INSERT `district`(`name`,`city_id`) VALUES('涡阳县','101');
INSERT `district`(`name`,`city_id`) VALUES('蒙城县','101');
INSERT `district`(`name`,`city_id`) VALUES('利辛县','101');


--102	池州市
INSERT `district`(`name`,`city_id`) VALUES('贵池区','102');
INSERT `district`(`name`,`city_id`) VALUES('东至县','102');
INSERT `district`(`name`,`city_id`) VALUES('石台县','102');
INSERT `district`(`name`,`city_id`) VALUES('青阳县','102');


--103	宣城市
INSERT `district`(`name`,`city_id`) VALUES('宣州区','103');
INSERT `district`(`name`,`city_id`) VALUES('郎溪县','103');
INSERT `district`(`name`,`city_id`) VALUES('广德县','103');
INSERT `district`(`name`,`city_id`) VALUES('泾县','103');
INSERT `district`(`name`,`city_id`) VALUES('绩溪县','103');
INSERT `district`(`name`,`city_id`) VALUES('旌德县','103');
INSERT `district`(`name`,`city_id`) VALUES('宁国市','103');



--*********************************************************福建************************************************************************
--104	福州市
INSERT `district`(`name`,`city_id`) VALUES('鼓楼区','104');
INSERT `district`(`name`,`city_id`) VALUES('台江区','104');
INSERT `district`(`name`,`city_id`) VALUES('仓山区','104');
INSERT `district`(`name`,`city_id`) VALUES('马尾区','104');
INSERT `district`(`name`,`city_id`) VALUES('晋安区','104');
INSERT `district`(`name`,`city_id`) VALUES('闽侯县','104');
INSERT `district`(`name`,`city_id`) VALUES('连江县','104');
INSERT `district`(`name`,`city_id`) VALUES('罗源县','104');
INSERT `district`(`name`,`city_id`) VALUES('闽清县','104');
INSERT `district`(`name`,`city_id`) VALUES('永泰县','104');
INSERT `district`(`name`,`city_id`) VALUES('平潭县','104');
INSERT `district`(`name`,`city_id`) VALUES('福清市','104');
INSERT `district`(`name`,`city_id`) VALUES('长乐市','104');


--105	厦门市
INSERT `district`(`name`,`city_id`) VALUES('思明区','105');
INSERT `district`(`name`,`city_id`) VALUES('海沧区','105');
INSERT `district`(`name`,`city_id`) VALUES('湖里区','105');
INSERT `district`(`name`,`city_id`) VALUES('集美区','105');
INSERT `district`(`name`,`city_id`) VALUES('同安区','105');
INSERT `district`(`name`,`city_id`) VALUES('翔安区','105');


--106	宁德市
INSERT `district`(`name`,`city_id`) VALUES('蕉城区','106');
INSERT `district`(`name`,`city_id`) VALUES('霞浦县','106');
INSERT `district`(`name`,`city_id`) VALUES('古田县','106');
INSERT `district`(`name`,`city_id`) VALUES('屏南县','106');
INSERT `district`(`name`,`city_id`) VALUES('寿宁县','106');
INSERT `district`(`name`,`city_id`) VALUES('周宁县','106');
INSERT `district`(`name`,`city_id`) VALUES('柘荣县','106');
INSERT `district`(`name`,`city_id`) VALUES('福安市','106');
INSERT `district`(`name`,`city_id`) VALUES('福鼎市','106');


--107	莆田市
INSERT `district`(`name`,`city_id`) VALUES('城厢区','107');
INSERT `district`(`name`,`city_id`) VALUES('涵江区','107');
INSERT `district`(`name`,`city_id`) VALUES('荔城区','107');
INSERT `district`(`name`,`city_id`) VALUES('秀屿区','107');
INSERT `district`(`name`,`city_id`) VALUES('仙游县','107');


--108	泉州市
INSERT `district`(`name`,`city_id`) VALUES('鲤城区','108');
INSERT `district`(`name`,`city_id`) VALUES('丰泽区','108');
INSERT `district`(`name`,`city_id`) VALUES('洛江区','108');
INSERT `district`(`name`,`city_id`) VALUES('泉港区','108');
INSERT `district`(`name`,`city_id`) VALUES('惠安县','108');
INSERT `district`(`name`,`city_id`) VALUES('安溪县','108');
INSERT `district`(`name`,`city_id`) VALUES('永春县','108');
INSERT `district`(`name`,`city_id`) VALUES('德化县','108');
INSERT `district`(`name`,`city_id`) VALUES('石狮市','108');
INSERT `district`(`name`,`city_id`) VALUES('晋江市','108');
INSERT `district`(`name`,`city_id`) VALUES('南安市','108');


--109	漳州市
INSERT `district`(`name`,`city_id`) VALUES('芗城区','109');
INSERT `district`(`name`,`city_id`) VALUES('龙文区','109');
INSERT `district`(`name`,`city_id`) VALUES('云霄县','109');
INSERT `district`(`name`,`city_id`) VALUES('漳浦县','109');
INSERT `district`(`name`,`city_id`) VALUES('诏安县','109');
INSERT `district`(`name`,`city_id`) VALUES('长泰县','109');
INSERT `district`(`name`,`city_id`) VALUES('东山县','109');
INSERT `district`(`name`,`city_id`) VALUES('南靖县','109');
INSERT `district`(`name`,`city_id`) VALUES('平和县','109');
INSERT `district`(`name`,`city_id`) VALUES('华安县','109');
INSERT `district`(`name`,`city_id`) VALUES('龙海市','109');

--110	龙岩市
INSERT `district`(`name`,`city_id`) VALUES('新罗区','110');
INSERT `district`(`name`,`city_id`) VALUES('长汀县','110');
INSERT `district`(`name`,`city_id`) VALUES('永定县','110');
INSERT `district`(`name`,`city_id`) VALUES('上杭县','110');
INSERT `district`(`name`,`city_id`) VALUES('武平县','110');
INSERT `district`(`name`,`city_id`) VALUES('连城县','110');
INSERT `district`(`name`,`city_id`) VALUES('漳平市','110');

--111	三明市
INSERT `district`(`name`,`city_id`) VALUES('梅列区','111');
INSERT `district`(`name`,`city_id`) VALUES('三元区','111');
INSERT `district`(`name`,`city_id`) VALUES('明溪县','111');
INSERT `district`(`name`,`city_id`) VALUES('清流县','111');
INSERT `district`(`name`,`city_id`) VALUES('宁化县','111');
INSERT `district`(`name`,`city_id`) VALUES('大田县','111');
INSERT `district`(`name`,`city_id`) VALUES('尤溪县','111');
INSERT `district`(`name`,`city_id`) VALUES('沙县','111');
INSERT `district`(`name`,`city_id`) VALUES('将乐县','111');
INSERT `district`(`name`,`city_id`) VALUES('泰宁县','111');
INSERT `district`(`name`,`city_id`) VALUES('建宁县','111');
INSERT `district`(`name`,`city_id`) VALUES('永安市','111');


--112	南平市
INSERT `district`(`name`,`city_id`) VALUES('延平区','112');
INSERT `district`(`name`,`city_id`) VALUES('顺昌县','112');
INSERT `district`(`name`,`city_id`) VALUES('浦城县','112');
INSERT `district`(`name`,`city_id`) VALUES('光泽县','112');
INSERT `district`(`name`,`city_id`) VALUES('松溪县','112');
INSERT `district`(`name`,`city_id`) VALUES('政和县','112');
INSERT `district`(`name`,`city_id`) VALUES('邵武市','112');
INSERT `district`(`name`,`city_id`) VALUES('武夷山市','112');
INSERT `district`(`name`,`city_id`) VALUES('建瓯市','112');
INSERT `district`(`name`,`city_id`) VALUES('建阳市','112');

--*********************************************************江西************************************************************************
--113	鹰潭市
INSERT `district`(`name`,`city_id`) VALUES('月湖区','113');
INSERT `district`(`name`,`city_id`) VALUES('余江县','113');
INSERT `district`(`name`,`city_id`) VALUES('贵溪市','113');

--114	新余市
INSERT `district`(`name`,`city_id`) VALUES('渝水区','114');
INSERT `district`(`name`,`city_id`) VALUES('分宜县','114');


--115	南昌市
INSERT `district`(`name`,`city_id`) VALUES('东湖区','115');
INSERT `district`(`name`,`city_id`) VALUES('西湖区','115');
INSERT `district`(`name`,`city_id`) VALUES('青云谱区','115');
INSERT `district`(`name`,`city_id`) VALUES('湾里区','115');
INSERT `district`(`name`,`city_id`) VALUES('青山湖区','115');
INSERT `district`(`name`,`city_id`) VALUES('南昌县','115');
INSERT `district`(`name`,`city_id`) VALUES('新建县','115');
INSERT `district`(`name`,`city_id`) VALUES('安义县','115');
INSERT `district`(`name`,`city_id`) VALUES('进贤县','115');


--116	九江市
INSERT `district`(`name`,`city_id`) VALUES('庐山区','116');
INSERT `district`(`name`,`city_id`) VALUES('浔阳区','116');
INSERT `district`(`name`,`city_id`) VALUES('九江县','116');
INSERT `district`(`name`,`city_id`) VALUES('武宁县','116');
INSERT `district`(`name`,`city_id`) VALUES('修水县','116');
INSERT `district`(`name`,`city_id`) VALUES('永修县','116');
INSERT `district`(`name`,`city_id`) VALUES('德安县','116');
INSERT `district`(`name`,`city_id`) VALUES('星子县','116');
INSERT `district`(`name`,`city_id`) VALUES('都昌县','116');
INSERT `district`(`name`,`city_id`) VALUES('湖口县','116');
INSERT `district`(`name`,`city_id`) VALUES('彭泽县','116');
INSERT `district`(`name`,`city_id`) VALUES('瑞昌市','116');

--117	上饶市
INSERT `district`(`name`,`city_id`) VALUES('信州区','117');
INSERT `district`(`name`,`city_id`) VALUES('上饶县','117');
INSERT `district`(`name`,`city_id`) VALUES('广丰县','117');
INSERT `district`(`name`,`city_id`) VALUES('玉山县','117');
INSERT `district`(`name`,`city_id`) VALUES('铅山县','117');
INSERT `district`(`name`,`city_id`) VALUES('横峰县','117');
INSERT `district`(`name`,`city_id`) VALUES('弋阳县','117');
INSERT `district`(`name`,`city_id`) VALUES('余干县','117');
INSERT `district`(`name`,`city_id`) VALUES('鄱阳县','117');
INSERT `district`(`name`,`city_id`) VALUES('万年县','117');
INSERT `district`(`name`,`city_id`) VALUES('婺源县','117');
INSERT `district`(`name`,`city_id`) VALUES('德兴市','117');

--118	抚州市
INSERT `district`(`name`,`city_id`) VALUES('临川区','118');
INSERT `district`(`name`,`city_id`) VALUES('南城县','118');
INSERT `district`(`name`,`city_id`) VALUES('黎川县','118');
INSERT `district`(`name`,`city_id`) VALUES('南丰县','118');
INSERT `district`(`name`,`city_id`) VALUES('崇仁县','118');
INSERT `district`(`name`,`city_id`) VALUES('乐安县','118');
INSERT `district`(`name`,`city_id`) VALUES('宜黄县','118');
INSERT `district`(`name`,`city_id`) VALUES('金溪县','118');
INSERT `district`(`name`,`city_id`) VALUES('资溪县','118');
INSERT `district`(`name`,`city_id`) VALUES('东乡县','118');
INSERT `district`(`name`,`city_id`) VALUES('广昌县','118');

--119	宜春市
INSERT `district`(`name`,`city_id`) VALUES('袁州区','119');
INSERT `district`(`name`,`city_id`) VALUES('奉新县','119');
INSERT `district`(`name`,`city_id`) VALUES('万载县','119');
INSERT `district`(`name`,`city_id`) VALUES('上高县','119');
INSERT `district`(`name`,`city_id`) VALUES('宜丰县','119');
INSERT `district`(`name`,`city_id`) VALUES('靖安县','119');
INSERT `district`(`name`,`city_id`) VALUES('铜鼓县','119');
INSERT `district`(`name`,`city_id`) VALUES('丰城市','119');
INSERT `district`(`name`,`city_id`) VALUES('樟树市','119');
INSERT `district`(`name`,`city_id`) VALUES('高安市','119');


--120	吉安市
INSERT `district`(`name`,`city_id`) VALUES('吉州区','120');
INSERT `district`(`name`,`city_id`) VALUES('青原区','120');
INSERT `district`(`name`,`city_id`) VALUES('吉安县','120');
INSERT `district`(`name`,`city_id`) VALUES('吉水县','120');
INSERT `district`(`name`,`city_id`) VALUES('峡江县','120');
INSERT `district`(`name`,`city_id`) VALUES('新干县','120');
INSERT `district`(`name`,`city_id`) VALUES('永丰县','120');
INSERT `district`(`name`,`city_id`) VALUES('泰和县','120');
INSERT `district`(`name`,`city_id`) VALUES('遂川县','120');
INSERT `district`(`name`,`city_id`) VALUES('万安县','120');
INSERT `district`(`name`,`city_id`) VALUES('安福县','120');
INSERT `district`(`name`,`city_id`) VALUES('永新县','120');
INSERT `district`(`name`,`city_id`) VALUES('井冈山市','120');


--121	赣州市
INSERT `district`(`name`,`city_id`) VALUES('章贡区','121');
INSERT `district`(`name`,`city_id`) VALUES('赣县','121');
INSERT `district`(`name`,`city_id`) VALUES('信丰县','121');
INSERT `district`(`name`,`city_id`) VALUES('大余县','121');
INSERT `district`(`name`,`city_id`) VALUES('上犹县','121');
INSERT `district`(`name`,`city_id`) VALUES('崇义县','121');
INSERT `district`(`name`,`city_id`) VALUES('安远县','121');
INSERT `district`(`name`,`city_id`) VALUES('龙南县','121');
INSERT `district`(`name`,`city_id`) VALUES('定南县','121');
INSERT `district`(`name`,`city_id`) VALUES('全南县','121');
INSERT `district`(`name`,`city_id`) VALUES('宁都县','121');
INSERT `district`(`name`,`city_id`) VALUES('于都县','121');
INSERT `district`(`name`,`city_id`) VALUES('兴国县','121');
INSERT `district`(`name`,`city_id`) VALUES('会昌县','121');
INSERT `district`(`name`,`city_id`) VALUES('寻乌县','121');
INSERT `district`(`name`,`city_id`) VALUES('石城县','121');
INSERT `district`(`name`,`city_id`) VALUES('瑞金市','121');
INSERT `district`(`name`,`city_id`) VALUES('南康市','121');

--122	景德镇市
INSERT `district`(`name`,`city_id`) VALUES('昌江区','122');
INSERT `district`(`name`,`city_id`) VALUES('珠山区','122');
INSERT `district`(`name`,`city_id`) VALUES('浮梁县','122');
INSERT `district`(`name`,`city_id`) VALUES('乐平市','122');


--123	萍乡市
INSERT `district`(`name`,`city_id`) VALUES('安源区','123');
INSERT `district`(`name`,`city_id`) VALUES('湘东区','123');
INSERT `district`(`name`,`city_id`) VALUES('莲花县','123');
INSERT `district`(`name`,`city_id`) VALUES('上栗县','123');
INSERT `district`(`name`,`city_id`) VALUES('芦溪县','123');

--*********************************************************山东************************************************************************
--124	菏泽市
INSERT `district`(`name`,`city_id`) VALUES('牡丹区','124');
INSERT `district`(`name`,`city_id`) VALUES('曹县','124');
INSERT `district`(`name`,`city_id`) VALUES('单县','124');
INSERT `district`(`name`,`city_id`) VALUES('成武县','124');
INSERT `district`(`name`,`city_id`) VALUES('巨野县','124');
INSERT `district`(`name`,`city_id`) VALUES('郓城县','124');
INSERT `district`(`name`,`city_id`) VALUES('鄄城县','124');
INSERT `district`(`name`,`city_id`) VALUES('定陶县','124');
INSERT `district`(`name`,`city_id`) VALUES('东明县','124');


--125	济南市
INSERT `district`(`name`,`city_id`) VALUES('历下区','125');
INSERT `district`(`name`,`city_id`) VALUES('市中区','125');
INSERT `district`(`name`,`city_id`) VALUES('槐荫区','125');
INSERT `district`(`name`,`city_id`) VALUES('天桥区','125');
INSERT `district`(`name`,`city_id`) VALUES('历城区','125');
INSERT `district`(`name`,`city_id`) VALUES('长清区','125');
INSERT `district`(`name`,`city_id`) VALUES('平阴县','125');
INSERT `district`(`name`,`city_id`) VALUES('济阳县','125');
INSERT `district`(`name`,`city_id`) VALUES('商河县','125');
INSERT `district`(`name`,`city_id`) VALUES('章丘市','125');

--126	青岛市
INSERT `district`(`name`,`city_id`) VALUES('市南区','126');
INSERT `district`(`name`,`city_id`) VALUES('市北区','126');
INSERT `district`(`name`,`city_id`) VALUES('四方区','126');
INSERT `district`(`name`,`city_id`) VALUES('黄岛区','126');
INSERT `district`(`name`,`city_id`) VALUES('崂山区','126');
INSERT `district`(`name`,`city_id`) VALUES('李沧区','126');
INSERT `district`(`name`,`city_id`) VALUES('城阳区','126');
INSERT `district`(`name`,`city_id`) VALUES('胶州市','126');
INSERT `district`(`name`,`city_id`) VALUES('即墨市','126');
INSERT `district`(`name`,`city_id`) VALUES('平度市','126');
INSERT `district`(`name`,`city_id`) VALUES('胶南市','126');
INSERT `district`(`name`,`city_id`) VALUES('莱西市','126');


--127	淄博市
INSERT `district`(`name`,`city_id`) VALUES('淄川区','127');
INSERT `district`(`name`,`city_id`) VALUES('张店区','127');
INSERT `district`(`name`,`city_id`) VALUES('博山区','127');
INSERT `district`(`name`,`city_id`) VALUES('临淄区','127');
INSERT `district`(`name`,`city_id`) VALUES('周村区','127');
INSERT `district`(`name`,`city_id`) VALUES('桓台县','127');
INSERT `district`(`name`,`city_id`) VALUES('高青县','127');
INSERT `district`(`name`,`city_id`) VALUES('沂源县','127');

--128	德州市
INSERT `district`(`name`,`city_id`) VALUES('德城区','128');
INSERT `district`(`name`,`city_id`) VALUES('陵县','128');
INSERT `district`(`name`,`city_id`) VALUES('宁津县','128');
INSERT `district`(`name`,`city_id`) VALUES('庆云县','128');
INSERT `district`(`name`,`city_id`) VALUES('临邑县','128');
INSERT `district`(`name`,`city_id`) VALUES('齐河县','128');
INSERT `district`(`name`,`city_id`) VALUES('平原县','128');
INSERT `district`(`name`,`city_id`) VALUES('夏津县','128');
INSERT `district`(`name`,`city_id`) VALUES('武城县','128');
INSERT `district`(`name`,`city_id`) VALUES('乐陵市','128');
INSERT `district`(`name`,`city_id`) VALUES('禹城市','128');

--129	烟台市
INSERT `district`(`name`,`city_id`) VALUES('芝罘区','129');
INSERT `district`(`name`,`city_id`) VALUES('福山区','129');
INSERT `district`(`name`,`city_id`) VALUES('牟平区','129');
INSERT `district`(`name`,`city_id`) VALUES('莱山区','129');
INSERT `district`(`name`,`city_id`) VALUES('长岛县','129');
INSERT `district`(`name`,`city_id`) VALUES('龙口市','129');
INSERT `district`(`name`,`city_id`) VALUES('莱阳市','129');
INSERT `district`(`name`,`city_id`) VALUES('莱州市','129');
INSERT `district`(`name`,`city_id`) VALUES('蓬莱市','129');
INSERT `district`(`name`,`city_id`) VALUES('招远市','129');
INSERT `district`(`name`,`city_id`) VALUES('栖霞市','129');
INSERT `district`(`name`,`city_id`) VALUES('海阳市','129');

--130	潍坊市
INSERT `district`(`name`,`city_id`) VALUES('潍城区','130');
INSERT `district`(`name`,`city_id`) VALUES('寒亭区','130');
INSERT `district`(`name`,`city_id`) VALUES('坊子区','130');
INSERT `district`(`name`,`city_id`) VALUES('奎文区','130');
INSERT `district`(`name`,`city_id`) VALUES('临朐县','130');
INSERT `district`(`name`,`city_id`) VALUES('昌乐县','130');
INSERT `district`(`name`,`city_id`) VALUES('青州市','130');
INSERT `district`(`name`,`city_id`) VALUES('诸城市','130');
INSERT `district`(`name`,`city_id`) VALUES('寿光市','130');
INSERT `district`(`name`,`city_id`) VALUES('安丘市','130');
INSERT `district`(`name`,`city_id`) VALUES('高密市','130');
INSERT `district`(`name`,`city_id`) VALUES('昌邑市','130');

--131	济宁市
INSERT `district`(`name`,`city_id`) VALUES('市中区','131');
INSERT `district`(`name`,`city_id`) VALUES('任城区','131');
INSERT `district`(`name`,`city_id`) VALUES('微山县','131');
INSERT `district`(`name`,`city_id`) VALUES('鱼台县','131');
INSERT `district`(`name`,`city_id`) VALUES('金乡县','131');
INSERT `district`(`name`,`city_id`) VALUES('嘉祥县','131');
INSERT `district`(`name`,`city_id`) VALUES('汶上县','131');
INSERT `district`(`name`,`city_id`) VALUES('泗水县','131');
INSERT `district`(`name`,`city_id`) VALUES('梁山县','131');
INSERT `district`(`name`,`city_id`) VALUES('曲阜市','131');
INSERT `district`(`name`,`city_id`) VALUES('兖州市','131');
INSERT `district`(`name`,`city_id`) VALUES('邹城市','131');

--132	泰安市
INSERT `district`(`name`,`city_id`) VALUES('泰山区','132');
INSERT `district`(`name`,`city_id`) VALUES('岱岳区','132');
INSERT `district`(`name`,`city_id`) VALUES('宁阳县','132');
INSERT `district`(`name`,`city_id`) VALUES('东平县','132');
INSERT `district`(`name`,`city_id`) VALUES('新泰市','132');
INSERT `district`(`name`,`city_id`) VALUES('肥城市','132');

--133	临沂市
INSERT `district`(`name`,`city_id`) VALUES('兰山区','133');
INSERT `district`(`name`,`city_id`) VALUES('罗庄区','133');
INSERT `district`(`name`,`city_id`) VALUES('河东区','133');
INSERT `district`(`name`,`city_id`) VALUES('沂南县','133');
INSERT `district`(`name`,`city_id`) VALUES('郯城县','133');
INSERT `district`(`name`,`city_id`) VALUES('沂水县','133');
INSERT `district`(`name`,`city_id`) VALUES('苍山县','133');
INSERT `district`(`name`,`city_id`) VALUES('费县','133');
INSERT `district`(`name`,`city_id`) VALUES('平邑县','133');
INSERT `district`(`name`,`city_id`) VALUES('莒南县','133');
INSERT `district`(`name`,`city_id`) VALUES('蒙阴县','133');
INSERT `district`(`name`,`city_id`) VALUES('临沭县','133');


--134	滨州市
INSERT `district`(`name`,`city_id`) VALUES('滨城区','134');
INSERT `district`(`name`,`city_id`) VALUES('惠民县','134');
INSERT `district`(`name`,`city_id`) VALUES('阳信县','134');
INSERT `district`(`name`,`city_id`) VALUES('无棣县','134');
INSERT `district`(`name`,`city_id`) VALUES('沾化县','134');
INSERT `district`(`name`,`city_id`) VALUES('博兴县','134');
INSERT `district`(`name`,`city_id`) VALUES('邹平县','134');

--135	东营市
INSERT `district`(`name`,`city_id`) VALUES('东营区','135');
INSERT `district`(`name`,`city_id`) VALUES('河口区','135');
INSERT `district`(`name`,`city_id`) VALUES('垦利县','135');
INSERT `district`(`name`,`city_id`) VALUES('利津县','135');
INSERT `district`(`name`,`city_id`) VALUES('广饶县','135');


--136	威海市
INSERT `district`(`name`,`city_id`) VALUES('环翠区','136');
INSERT `district`(`name`,`city_id`) VALUES('文登市','136');
INSERT `district`(`name`,`city_id`) VALUES('荣成市','136');
INSERT `district`(`name`,`city_id`) VALUES('乳山市','136');

--137	枣庄市
INSERT `district`(`name`,`city_id`) VALUES('市中区','137');
INSERT `district`(`name`,`city_id`) VALUES('薛城区','137');
INSERT `district`(`name`,`city_id`) VALUES('峄城区','137');
INSERT `district`(`name`,`city_id`) VALUES('台儿庄区','137');
INSERT `district`(`name`,`city_id`) VALUES('山亭区','137');
INSERT `district`(`name`,`city_id`) VALUES('滕州市','137');

--138	日照市
INSERT `district`(`name`,`city_id`) VALUES('东港区','138');
INSERT `district`(`name`,`city_id`) VALUES('岚山区','138');
INSERT `district`(`name`,`city_id`) VALUES('五莲县','138');
INSERT `district`(`name`,`city_id`) VALUES('莒县','138');


--139	莱芜市
INSERT `district`(`name`,`city_id`) VALUES('莱城区','139');
INSERT `district`(`name`,`city_id`) VALUES('钢城区','139');


--140	聊城市
INSERT `district`(`name`,`city_id`) VALUES('东昌府区','140');
INSERT `district`(`name`,`city_id`) VALUES('阳谷县','140');
INSERT `district`(`name`,`city_id`) VALUES('莘县','140');
INSERT `district`(`name`,`city_id`) VALUES('茌平县','140');
INSERT `district`(`name`,`city_id`) VALUES('东阿县','140');
INSERT `district`(`name`,`city_id`) VALUES('冠县','140');
INSERT `district`(`name`,`city_id`) VALUES('高唐县','140');
INSERT `district`(`name`,`city_id`) VALUES('临清市','140');


--*********************************************************河南************************************************************************
--141	商丘市
INSERT `district`(`name`,`city_id`) VALUES('梁园区','141');
INSERT `district`(`name`,`city_id`) VALUES('睢阳区','141');
INSERT `district`(`name`,`city_id`) VALUES('民权县','141');
INSERT `district`(`name`,`city_id`) VALUES('睢县','141');
INSERT `district`(`name`,`city_id`) VALUES('宁陵县','141');
INSERT `district`(`name`,`city_id`) VALUES('柘城县','141');
INSERT `district`(`name`,`city_id`) VALUES('虞城县','141');
INSERT `district`(`name`,`city_id`) VALUES('夏邑县','141');
INSERT `district`(`name`,`city_id`) VALUES('永城市','141');

--142	郑州市
INSERT `district`(`name`,`city_id`) VALUES('中原区','142');
INSERT `district`(`name`,`city_id`) VALUES('二七区','142');
INSERT `district`(`name`,`city_id`) VALUES('管城回族区','142');
INSERT `district`(`name`,`city_id`) VALUES('金水区','142');
INSERT `district`(`name`,`city_id`) VALUES('上街区','142');
INSERT `district`(`name`,`city_id`) VALUES('惠济区','142');
INSERT `district`(`name`,`city_id`) VALUES('中牟县','142');
INSERT `district`(`name`,`city_id`) VALUES('巩义市','142');
INSERT `district`(`name`,`city_id`) VALUES('荥阳市','142');
INSERT `district`(`name`,`city_id`) VALUES('新密市','142');
INSERT `district`(`name`,`city_id`) VALUES('新郑市','142');
INSERT `district`(`name`,`city_id`) VALUES('登封市','142');

--143	安阳市
INSERT `district`(`name`,`city_id`) VALUES('文峰区','143');
INSERT `district`(`name`,`city_id`) VALUES('北关区','143');
INSERT `district`(`name`,`city_id`) VALUES('殷都区','143');
INSERT `district`(`name`,`city_id`) VALUES('龙安区','143');
INSERT `district`(`name`,`city_id`) VALUES('安阳县','143');
INSERT `district`(`name`,`city_id`) VALUES('汤阴县','143');
INSERT `district`(`name`,`city_id`) VALUES('滑县','143');
INSERT `district`(`name`,`city_id`) VALUES('内黄县','143');
INSERT `district`(`name`,`city_id`) VALUES('林州市','143');


--144	新乡市
INSERT `district`(`name`,`city_id`) VALUES('红旗区','144');
INSERT `district`(`name`,`city_id`) VALUES('卫滨区','144');
INSERT `district`(`name`,`city_id`) VALUES('凤泉区','144');
INSERT `district`(`name`,`city_id`) VALUES('牧野区','144');
INSERT `district`(`name`,`city_id`) VALUES('新乡县','144');
INSERT `district`(`name`,`city_id`) VALUES('获嘉县','144');
INSERT `district`(`name`,`city_id`) VALUES('原阳县','144');
INSERT `district`(`name`,`city_id`) VALUES('延津县','144');
INSERT `district`(`name`,`city_id`) VALUES('封丘县','144');
INSERT `district`(`name`,`city_id`) VALUES('长垣县','144');
INSERT `district`(`name`,`city_id`) VALUES('卫辉市','144');
INSERT `district`(`name`,`city_id`) VALUES('辉县市','144');


--145	许昌市
INSERT `district`(`name`,`city_id`) VALUES('魏都区','145');
INSERT `district`(`name`,`city_id`) VALUES('许昌县','145');
INSERT `district`(`name`,`city_id`) VALUES('鄢陵县','145');
INSERT `district`(`name`,`city_id`) VALUES('襄城县','145');
INSERT `district`(`name`,`city_id`) VALUES('禹州市','145');
INSERT `district`(`name`,`city_id`) VALUES('长葛市','145');


--146	平顶山市
INSERT `district`(`name`,`city_id`) VALUES('新华区','146');
INSERT `district`(`name`,`city_id`) VALUES('卫东区','146');
INSERT `district`(`name`,`city_id`) VALUES('石龙区','146');
INSERT `district`(`name`,`city_id`) VALUES('湛河区','146');
INSERT `district`(`name`,`city_id`) VALUES('宝丰县','146');
INSERT `district`(`name`,`city_id`) VALUES('叶县','146');
INSERT `district`(`name`,`city_id`) VALUES('鲁山县','146');
INSERT `district`(`name`,`city_id`) VALUES('郏县','146');
INSERT `district`(`name`,`city_id`) VALUES('舞钢市','146');
INSERT `district`(`name`,`city_id`) VALUES('汝州市','146');

--147	信阳市
INSERT `district`(`name`,`city_id`) VALUES('浉河区','147');
INSERT `district`(`name`,`city_id`) VALUES('平桥区','147');
INSERT `district`(`name`,`city_id`) VALUES('罗山县','147');
INSERT `district`(`name`,`city_id`) VALUES('光山县','147');
INSERT `district`(`name`,`city_id`) VALUES('新县','147');
INSERT `district`(`name`,`city_id`) VALUES('商城县','147');
INSERT `district`(`name`,`city_id`) VALUES('固始县','147');
INSERT `district`(`name`,`city_id`) VALUES('潢川县','147');
INSERT `district`(`name`,`city_id`) VALUES('淮滨县','147');
INSERT `district`(`name`,`city_id`) VALUES('息县','147');


--148	南阳市
INSERT `district`(`name`,`city_id`) VALUES('宛城区','148');
INSERT `district`(`name`,`city_id`) VALUES('卧龙区','148');
INSERT `district`(`name`,`city_id`) VALUES('南召县','148');
INSERT `district`(`name`,`city_id`) VALUES('方城县','148');
INSERT `district`(`name`,`city_id`) VALUES('西峡县','148');
INSERT `district`(`name`,`city_id`) VALUES('镇平县','148');
INSERT `district`(`name`,`city_id`) VALUES('内乡县','148');
INSERT `district`(`name`,`city_id`) VALUES('淅川县','148');
INSERT `district`(`name`,`city_id`) VALUES('社旗县','148');
INSERT `district`(`name`,`city_id`) VALUES('唐河县','148');
INSERT `district`(`name`,`city_id`) VALUES('新野县','148');
INSERT `district`(`name`,`city_id`) VALUES('桐柏县','148');
INSERT `district`(`name`,`city_id`) VALUES('邓州市','148');

--149	开封市
INSERT `district`(`name`,`city_id`) VALUES('龙亭区','149');
INSERT `district`(`name`,`city_id`) VALUES('顺河回族区','149');
INSERT `district`(`name`,`city_id`) VALUES('鼓楼区','149');
INSERT `district`(`name`,`city_id`) VALUES('禹王台区','149');
INSERT `district`(`name`,`city_id`) VALUES('金明区','149');
INSERT `district`(`name`,`city_id`) VALUES('杞县','149');
INSERT `district`(`name`,`city_id`) VALUES('通许县','149');
INSERT `district`(`name`,`city_id`) VALUES('尉氏县','149');
INSERT `district`(`name`,`city_id`) VALUES('开封县','149');
INSERT `district`(`name`,`city_id`) VALUES('兰考县','149');


--150	洛阳市
INSERT `district`(`name`,`city_id`) VALUES('老城区','150');
INSERT `district`(`name`,`city_id`) VALUES('西工区','150');
INSERT `district`(`name`,`city_id`) VALUES('瀍河回族区','150');
INSERT `district`(`name`,`city_id`) VALUES('涧西区','150');
INSERT `district`(`name`,`city_id`) VALUES('吉利区','150');
INSERT `district`(`name`,`city_id`) VALUES('洛龙区','150');
INSERT `district`(`name`,`city_id`) VALUES('孟津县','150');
INSERT `district`(`name`,`city_id`) VALUES('新安县','150');
INSERT `district`(`name`,`city_id`) VALUES('栾川县','150');
INSERT `district`(`name`,`city_id`) VALUES('嵩县','150');
INSERT `district`(`name`,`city_id`) VALUES('汝阳县','150');
INSERT `district`(`name`,`city_id`) VALUES('宜阳县','150');
INSERT `district`(`name`,`city_id`) VALUES('洛宁县','150');
INSERT `district`(`name`,`city_id`) VALUES('伊川县','150');
INSERT `district`(`name`,`city_id`) VALUES('偃师市','150');


--151	济源市(无);
--152	焦作市
INSERT `district`(`name`,`city_id`) VALUES('解放区','152');
INSERT `district`(`name`,`city_id`) VALUES('中站区','152');
INSERT `district`(`name`,`city_id`) VALUES('马村区','152');
INSERT `district`(`name`,`city_id`) VALUES('山阳区','152');
INSERT `district`(`name`,`city_id`) VALUES('修武县','152');
INSERT `district`(`name`,`city_id`) VALUES('博爱县','152');
INSERT `district`(`name`,`city_id`) VALUES('武陟县','152');
INSERT `district`(`name`,`city_id`) VALUES('温县','152');
INSERT `district`(`name`,`city_id`) VALUES('沁阳市','152');
INSERT `district`(`name`,`city_id`) VALUES('孟州市','152');


--153	鹤壁市
INSERT `district`(`name`,`city_id`) VALUES('鹤山区','153');
INSERT `district`(`name`,`city_id`) VALUES('山城区','153');
INSERT `district`(`name`,`city_id`) VALUES('淇滨区','153');
INSERT `district`(`name`,`city_id`) VALUES('浚县','153');
INSERT `district`(`name`,`city_id`) VALUES('淇县','153');

--154	濮阳市
INSERT `district`(`name`,`city_id`) VALUES('华龙区','154');
INSERT `district`(`name`,`city_id`) VALUES('清丰县','154');
INSERT `district`(`name`,`city_id`) VALUES('南乐县','154');
INSERT `district`(`name`,`city_id`) VALUES('范县','154');
INSERT `district`(`name`,`city_id`) VALUES('台前县','154');
INSERT `district`(`name`,`city_id`) VALUES('濮阳县','154');

--155	周口市
INSERT `district`(`name`,`city_id`) VALUES('川汇区','155');
INSERT `district`(`name`,`city_id`) VALUES('扶沟县','155');
INSERT `district`(`name`,`city_id`) VALUES('西华县','155');
INSERT `district`(`name`,`city_id`) VALUES('商水县','155');
INSERT `district`(`name`,`city_id`) VALUES('沈丘县','155');
INSERT `district`(`name`,`city_id`) VALUES('郸城县','155');
INSERT `district`(`name`,`city_id`) VALUES('淮阳县','155');
INSERT `district`(`name`,`city_id`) VALUES('太康县','155');
INSERT `district`(`name`,`city_id`) VALUES('鹿邑县','155');
INSERT `district`(`name`,`city_id`) VALUES('项城市','155');


--156	漯河市
INSERT `district`(`name`,`city_id`) VALUES('源汇区','156');
INSERT `district`(`name`,`city_id`) VALUES('郾城区','156');
INSERT `district`(`name`,`city_id`) VALUES('召陵区','156');
INSERT `district`(`name`,`city_id`) VALUES('舞阳县','156');
INSERT `district`(`name`,`city_id`) VALUES('临颍县','156');

--157	驻马店市
INSERT `district`(`name`,`city_id`) VALUES('驿城区','157');
INSERT `district`(`name`,`city_id`) VALUES('西平县','157');
INSERT `district`(`name`,`city_id`) VALUES('上蔡县','157');
INSERT `district`(`name`,`city_id`) VALUES('平舆县','157');
INSERT `district`(`name`,`city_id`) VALUES('正阳县','157');
INSERT `district`(`name`,`city_id`) VALUES('确山县','157');
INSERT `district`(`name`,`city_id`) VALUES('泌阳县','157');
INSERT `district`(`name`,`city_id`) VALUES('汝南县','157');
INSERT `district`(`name`,`city_id`) VALUES('遂平县','157');
INSERT `district`(`name`,`city_id`) VALUES('新蔡县','157');

--158	三门峡市
INSERT `district`(`name`,`city_id`) VALUES('湖滨区','158');
INSERT `district`(`name`,`city_id`) VALUES('渑池县','158');
INSERT `district`(`name`,`city_id`) VALUES('陕县','158');
INSERT `district`(`name`,`city_id`) VALUES('卢氏县','158');
INSERT `district`(`name`,`city_id`) VALUES('义马市','158');
INSERT `district`(`name`,`city_id`) VALUES('灵宝市','158');

--*********************************************************湖北************************************************************************
--159	武汉市
INSERT `district`(`name`,`city_id`) VALUES('江岸区','159');
INSERT `district`(`name`,`city_id`) VALUES('江汉区','159');
INSERT `district`(`name`,`city_id`) VALUES('硚口区','159');
INSERT `district`(`name`,`city_id`) VALUES('汉阳区','159');
INSERT `district`(`name`,`city_id`) VALUES('武昌区','159');
INSERT `district`(`name`,`city_id`) VALUES('青山区','159');
INSERT `district`(`name`,`city_id`) VALUES('洪山区','159');
INSERT `district`(`name`,`city_id`) VALUES('东西湖区','159');
INSERT `district`(`name`,`city_id`) VALUES('汉南区','159');
INSERT `district`(`name`,`city_id`) VALUES('蔡甸区','159');
INSERT `district`(`name`,`city_id`) VALUES('江夏区','159');
INSERT `district`(`name`,`city_id`) VALUES('黄陂区','159');
INSERT `district`(`name`,`city_id`) VALUES('新洲区','159');


--160	襄樊市
INSERT `district`(`name`,`city_id`) VALUES('襄城区','160');
INSERT `district`(`name`,`city_id`) VALUES('樊城区','160');
INSERT `district`(`name`,`city_id`) VALUES('襄阳区','160');
INSERT `district`(`name`,`city_id`) VALUES('南漳县','160');
INSERT `district`(`name`,`city_id`) VALUES('谷城县','160');
INSERT `district`(`name`,`city_id`) VALUES('保康县','160');
INSERT `district`(`name`,`city_id`) VALUES('老河口市','160');
INSERT `district`(`name`,`city_id`) VALUES('枣阳市','160');
INSERT `district`(`name`,`city_id`) VALUES('宜城市','160');


--161	鄂州市
INSERT `district`(`name`,`city_id`) VALUES('梁子湖区','161');
INSERT `district`(`name`,`city_id`) VALUES('华容区','161');
INSERT `district`(`name`,`city_id`) VALUES('鄂城区','161');


--162	孝感市
INSERT `district`(`name`,`city_id`) VALUES('孝南区','162');
INSERT `district`(`name`,`city_id`) VALUES('孝昌县','162');
INSERT `district`(`name`,`city_id`) VALUES('大悟县','162');
INSERT `district`(`name`,`city_id`) VALUES('云梦县','162');
INSERT `district`(`name`,`city_id`) VALUES('应城市','162');
INSERT `district`(`name`,`city_id`) VALUES('安陆市','162');
INSERT `district`(`name`,`city_id`) VALUES('汉川市','162');


--163	黄冈市
INSERT `district`(`name`,`city_id`) VALUES('黄州区','163');
INSERT `district`(`name`,`city_id`) VALUES('团风县','163');
INSERT `district`(`name`,`city_id`) VALUES('红安县','163');
INSERT `district`(`name`,`city_id`) VALUES('罗田县','163');
INSERT `district`(`name`,`city_id`) VALUES('英山县','163');
INSERT `district`(`name`,`city_id`) VALUES('浠水县','163');
INSERT `district`(`name`,`city_id`) VALUES('蕲春县','163');
INSERT `district`(`name`,`city_id`) VALUES('黄梅县','163');
INSERT `district`(`name`,`city_id`) VALUES('麻城市','163');
INSERT `district`(`name`,`city_id`) VALUES('武穴市','163');


--164	黄石市
INSERT `district`(`name`,`city_id`) VALUES('黄石港区','164');
INSERT `district`(`name`,`city_id`) VALUES('西塞山区','164');
INSERT `district`(`name`,`city_id`) VALUES('下陆区','164');
INSERT `district`(`name`,`city_id`) VALUES('铁山区','164');
INSERT `district`(`name`,`city_id`) VALUES('阳新县','164');
INSERT `district`(`name`,`city_id`) VALUES('大冶市','164');

--165	咸宁市
INSERT `district`(`name`,`city_id`) VALUES('咸安区','165');
INSERT `district`(`name`,`city_id`) VALUES('嘉鱼县','165');
INSERT `district`(`name`,`city_id`) VALUES('通城县','165');
INSERT `district`(`name`,`city_id`) VALUES('崇阳县','165');
INSERT `district`(`name`,`city_id`) VALUES('通山县','165');
INSERT `district`(`name`,`city_id`) VALUES('赤壁市','165');

--166	荆州市
INSERT `district`(`name`,`city_id`) VALUES('沙市区','166');
INSERT `district`(`name`,`city_id`) VALUES('荆州区','166');
INSERT `district`(`name`,`city_id`) VALUES('公安县','166');
INSERT `district`(`name`,`city_id`) VALUES('监利县','166');
INSERT `district`(`name`,`city_id`) VALUES('江陵县','166');
INSERT `district`(`name`,`city_id`) VALUES('石首市','166');
INSERT `district`(`name`,`city_id`) VALUES('洪湖市','166');
INSERT `district`(`name`,`city_id`) VALUES('松滋市','166');


--167	宜昌市
INSERT `district`(`name`,`city_id`) VALUES('西陵区','167');
INSERT `district`(`name`,`city_id`) VALUES('伍家岗区','167');
INSERT `district`(`name`,`city_id`) VALUES('点军区','167');
INSERT `district`(`name`,`city_id`) VALUES('猇亭区','167');
INSERT `district`(`name`,`city_id`) VALUES('夷陵区','167');
INSERT `district`(`name`,`city_id`) VALUES('远安县','167');
INSERT `district`(`name`,`city_id`) VALUES('兴山县','167');
INSERT `district`(`name`,`city_id`) VALUES('秭归县','167');
INSERT `district`(`name`,`city_id`) VALUES('长阳土家族自治县','167');
INSERT `district`(`name`,`city_id`) VALUES('五峰土家族自治县','167');
INSERT `district`(`name`,`city_id`) VALUES('宜都市','167');
INSERT `district`(`name`,`city_id`) VALUES('当阳市','167');
INSERT `district`(`name`,`city_id`) VALUES('枝江市','167');


--168	恩施土家族苗族自治州
INSERT `district`(`name`,`city_id`) VALUES('恩施市','168');
INSERT `district`(`name`,`city_id`) VALUES('利川市','168');
INSERT `district`(`name`,`city_id`) VALUES('建始县','168');
INSERT `district`(`name`,`city_id`) VALUES('巴东县','168');
INSERT `district`(`name`,`city_id`) VALUES('宣恩县','168');
INSERT `district`(`name`,`city_id`) VALUES('咸丰县','168');
INSERT `district`(`name`,`city_id`) VALUES('来凤县','168');
INSERT `district`(`name`,`city_id`) VALUES('鹤峰县','168');


--169	神农架林区(无);
--170	十堰市
INSERT `district`(`name`,`city_id`) VALUES('茅箭区','170');
INSERT `district`(`name`,`city_id`) VALUES('张湾区','170');
INSERT `district`(`name`,`city_id`) VALUES('郧县','170');
INSERT `district`(`name`,`city_id`) VALUES('郧西县','170');
INSERT `district`(`name`,`city_id`) VALUES('竹山县','170');
INSERT `district`(`name`,`city_id`) VALUES('竹溪县','170');
INSERT `district`(`name`,`city_id`) VALUES('房县','170');
INSERT `district`(`name`,`city_id`) VALUES('丹江口市','170');


--171	随州市
INSERT `district`(`name`,`city_id`) VALUES('曾都区','171');
INSERT `district`(`name`,`city_id`) VALUES('广水市','171');


--172	荆门市
INSERT `district`(`name`,`city_id`) VALUES('东宝区','172');
INSERT `district`(`name`,`city_id`) VALUES('掇刀区','172');
INSERT `district`(`name`,`city_id`) VALUES('京山县','172');
INSERT `district`(`name`,`city_id`) VALUES('沙洋县','172');
INSERT `district`(`name`,`city_id`) VALUES('钟祥市','172');


--173	仙桃市(无);
--174	天门市(无);
--175	潜江市(无);

--*********************************************************湖南************************************************************************
--176	岳阳市
INSERT `district`(`name`,`city_id`) VALUES('岳阳楼区','176');
INSERT `district`(`name`,`city_id`) VALUES('云溪区','176');
INSERT `district`(`name`,`city_id`) VALUES('君山区','176');
INSERT `district`(`name`,`city_id`) VALUES('岳阳县','176');
INSERT `district`(`name`,`city_id`) VALUES('华容县','176');
INSERT `district`(`name`,`city_id`) VALUES('湘阴县','176');
INSERT `district`(`name`,`city_id`) VALUES('平江县','176');
INSERT `district`(`name`,`city_id`) VALUES('汨罗市','176');
INSERT `district`(`name`,`city_id`) VALUES('临湘市','176');


--177	长沙市
INSERT `district`(`name`,`city_id`) VALUES('芙蓉区','177');
INSERT `district`(`name`,`city_id`) VALUES('天心区','177');
INSERT `district`(`name`,`city_id`) VALUES('岳麓区','177');
INSERT `district`(`name`,`city_id`) VALUES('开福区','177');
INSERT `district`(`name`,`city_id`) VALUES('雨花区','177');
INSERT `district`(`name`,`city_id`) VALUES('长沙县','177');
INSERT `district`(`name`,`city_id`) VALUES('望城县','177');
INSERT `district`(`name`,`city_id`) VALUES('宁乡县','177');
INSERT `district`(`name`,`city_id`) VALUES('浏阳市','177');

--178	湘潭市
INSERT `district`(`name`,`city_id`) VALUES('雨湖区','178');
INSERT `district`(`name`,`city_id`) VALUES('岳塘区','178');
INSERT `district`(`name`,`city_id`) VALUES('湘潭县','178');
INSERT `district`(`name`,`city_id`) VALUES('湘乡市','178');
INSERT `district`(`name`,`city_id`) VALUES('韶山市','178');


--179	株洲市
INSERT `district`(`name`,`city_id`) VALUES('荷塘区','179');
INSERT `district`(`name`,`city_id`) VALUES('芦淞区','179');
INSERT `district`(`name`,`city_id`) VALUES('石峰区','179');
INSERT `district`(`name`,`city_id`) VALUES('天元区','179');
INSERT `district`(`name`,`city_id`) VALUES('株洲县','179');
INSERT `district`(`name`,`city_id`) VALUES('攸县','179');
INSERT `district`(`name`,`city_id`) VALUES('茶陵县','179');
INSERT `district`(`name`,`city_id`) VALUES('炎陵县','179');
INSERT `district`(`name`,`city_id`) VALUES('醴陵市','179');

--180	衡阳市
INSERT `district`(`name`,`city_id`) VALUES('珠晖区','180');
INSERT `district`(`name`,`city_id`) VALUES('雁峰区','180');
INSERT `district`(`name`,`city_id`) VALUES('石鼓区','180');
INSERT `district`(`name`,`city_id`) VALUES('蒸湘区','180');
INSERT `district`(`name`,`city_id`) VALUES('南岳区','180');
INSERT `district`(`name`,`city_id`) VALUES('衡阳县','180');
INSERT `district`(`name`,`city_id`) VALUES('衡南县','180');
INSERT `district`(`name`,`city_id`) VALUES('衡山县','180');
INSERT `district`(`name`,`city_id`) VALUES('衡东县','180');
INSERT `district`(`name`,`city_id`) VALUES('祁东县','180');
INSERT `district`(`name`,`city_id`) VALUES('耒阳市','180');
INSERT `district`(`name`,`city_id`) VALUES('常宁市','180');

--181	郴州市
INSERT `district`(`name`,`city_id`) VALUES('北湖区','181');
INSERT `district`(`name`,`city_id`) VALUES('苏仙区','181');
INSERT `district`(`name`,`city_id`) VALUES('桂阳县','181');
INSERT `district`(`name`,`city_id`) VALUES('宜章县','181');
INSERT `district`(`name`,`city_id`) VALUES('永兴县','181');
INSERT `district`(`name`,`city_id`) VALUES('嘉禾县','181');
INSERT `district`(`name`,`city_id`) VALUES('临武县','181');
INSERT `district`(`name`,`city_id`) VALUES('汝城县','181');
INSERT `district`(`name`,`city_id`) VALUES('桂东县','181');
INSERT `district`(`name`,`city_id`) VALUES('安仁县','181');
INSERT `district`(`name`,`city_id`) VALUES('资兴市','181');

--182	常德市
INSERT `district`(`name`,`city_id`) VALUES('武陵区','182');
INSERT `district`(`name`,`city_id`) VALUES('鼎城区','182');
INSERT `district`(`name`,`city_id`) VALUES('安乡县','182');
INSERT `district`(`name`,`city_id`) VALUES('汉寿县','182');
INSERT `district`(`name`,`city_id`) VALUES('澧县','182');
INSERT `district`(`name`,`city_id`) VALUES('临澧县','182');
INSERT `district`(`name`,`city_id`) VALUES('桃源县','182');
INSERT `district`(`name`,`city_id`) VALUES('石门县','182');
INSERT `district`(`name`,`city_id`) VALUES('津市市','182');

--183	益阳市
INSERT `district`(`name`,`city_id`) VALUES('资阳区','183');
INSERT `district`(`name`,`city_id`) VALUES('赫山区','183');
INSERT `district`(`name`,`city_id`) VALUES('南县','183');
INSERT `district`(`name`,`city_id`) VALUES('桃江县','183');
INSERT `district`(`name`,`city_id`) VALUES('安化县','183');
INSERT `district`(`name`,`city_id`) VALUES('沅江市','183');

--184	娄底市
INSERT `district`(`name`,`city_id`) VALUES('娄星区','184');
INSERT `district`(`name`,`city_id`) VALUES('双峰县','184');
INSERT `district`(`name`,`city_id`) VALUES('新化县','184');
INSERT `district`(`name`,`city_id`) VALUES('冷水江市','184');
INSERT `district`(`name`,`city_id`) VALUES('涟源市','184');


--185	邵阳市
INSERT `district`(`name`,`city_id`) VALUES('双清区','185');
INSERT `district`(`name`,`city_id`) VALUES('大祥区','185');
INSERT `district`(`name`,`city_id`) VALUES('北塔区','185');
INSERT `district`(`name`,`city_id`) VALUES('邵东县','185');
INSERT `district`(`name`,`city_id`) VALUES('新邵县','185');
INSERT `district`(`name`,`city_id`) VALUES('邵阳县','185');
INSERT `district`(`name`,`city_id`) VALUES('隆回县','185');
INSERT `district`(`name`,`city_id`) VALUES('洞口县','185');
INSERT `district`(`name`,`city_id`) VALUES('绥宁县','185');
INSERT `district`(`name`,`city_id`) VALUES('新宁县','185');
INSERT `district`(`name`,`city_id`) VALUES('城步苗族自治县','185');
INSERT `district`(`name`,`city_id`) VALUES('武冈市','185');

--186	湘西土家族苗族自治州
INSERT `district`(`name`,`city_id`) VALUES('吉首市','186');
INSERT `district`(`name`,`city_id`) VALUES('泸溪县','186');
INSERT `district`(`name`,`city_id`) VALUES('凤凰县','186');
INSERT `district`(`name`,`city_id`) VALUES('花垣县','186');
INSERT `district`(`name`,`city_id`) VALUES('保靖县','186');
INSERT `district`(`name`,`city_id`) VALUES('古丈县','186');
INSERT `district`(`name`,`city_id`) VALUES('永顺县','186');
INSERT `district`(`name`,`city_id`) VALUES('龙山县','186');


--187	张家界市
INSERT `district`(`name`,`city_id`) VALUES('永定区','187');
INSERT `district`(`name`,`city_id`) VALUES('武陵源区','187');
INSERT `district`(`name`,`city_id`) VALUES('慈利县','187');
INSERT `district`(`name`,`city_id`) VALUES('桑植县','187');

--188	怀化市
INSERT `district`(`name`,`city_id`) VALUES('鹤城区','188');
INSERT `district`(`name`,`city_id`) VALUES('中方县','188');
INSERT `district`(`name`,`city_id`) VALUES('沅陵县','188');
INSERT `district`(`name`,`city_id`) VALUES('辰溪县','188');
INSERT `district`(`name`,`city_id`) VALUES('溆浦县','188');
INSERT `district`(`name`,`city_id`) VALUES('会同县','188');
INSERT `district`(`name`,`city_id`) VALUES('麻阳苗族自治县','188');
INSERT `district`(`name`,`city_id`) VALUES('新晃侗族自治县','188');
INSERT `district`(`name`,`city_id`) VALUES('芷江侗族自治县','188');
INSERT `district`(`name`,`city_id`) VALUES('靖州苗族侗族自治县','188');
INSERT `district`(`name`,`city_id`) VALUES('通道侗族自治县','188');
INSERT `district`(`name`,`city_id`) VALUES('洪江市','188');

--189	永州市
INSERT `district`(`name`,`city_id`) VALUES('零陵区','189');
INSERT `district`(`name`,`city_id`) VALUES('冷水滩区','189');
INSERT `district`(`name`,`city_id`) VALUES('祁阳县','189');
INSERT `district`(`name`,`city_id`) VALUES('东安县','189');
INSERT `district`(`name`,`city_id`) VALUES('双牌县','189');
INSERT `district`(`name`,`city_id`) VALUES('道县','189');
INSERT `district`(`name`,`city_id`) VALUES('江永县','189');
INSERT `district`(`name`,`city_id`) VALUES('宁远县','189');
INSERT `district`(`name`,`city_id`) VALUES('蓝山县','189');
INSERT `district`(`name`,`city_id`) VALUES('新田县','189');
INSERT `district`(`name`,`city_id`) VALUES('江华瑶族自治县','189');

--*********************************************************广东************************************************************************
--190	广州市
INSERT `district`(`name`,`city_id`) VALUES('从化市','190');
INSERT `district`(`name`,`city_id`) VALUES('荔湾区','190');
INSERT `district`(`name`,`city_id`) VALUES('越秀区','190');
INSERT `district`(`name`,`city_id`) VALUES('海珠区','190');
INSERT `district`(`name`,`city_id`) VALUES('天河区','190');
INSERT `district`(`name`,`city_id`) VALUES('白云区','190');
INSERT `district`(`name`,`city_id`) VALUES('花都区','190');
INSERT `district`(`name`,`city_id`) VALUES('黄埔区','190');
INSERT `district`(`name`,`city_id`) VALUES('萝岗区','190');
INSERT `district`(`name`,`city_id`) VALUES('南沙区','190');
INSERT `district`(`name`,`city_id`) VALUES('番禺区','190');
INSERT `district`(`name`,`city_id`) VALUES('增城市','190');

--191	汕尾市
INSERT `district`(`name`,`city_id`) VALUES('海丰县','191');
INSERT `district`(`name`,`city_id`) VALUES('陆河县','191');
INSERT `district`(`name`,`city_id`) VALUES('陆丰市','191');


--192	阳江市
INSERT `district`(`name`,`city_id`) VALUES('江城区','192');
INSERT `district`(`name`,`city_id`) VALUES('阳西县','192');
INSERT `district`(`name`,`city_id`) VALUES('阳东县','192');
INSERT `district`(`name`,`city_id`) VALUES('阳春市','192');


--193	揭阳市
INSERT `district`(`name`,`city_id`) VALUES('榕城区','193');
INSERT `district`(`name`,`city_id`) VALUES('揭东县','193');
INSERT `district`(`name`,`city_id`) VALUES('揭西县','193');
INSERT `district`(`name`,`city_id`) VALUES('惠来县','193');
INSERT `district`(`name`,`city_id`) VALUES('普宁市','193');


--194	茂名市
INSERT `district`(`name`,`city_id`) VALUES('茂南区','194');
INSERT `district`(`name`,`city_id`) VALUES('茂港区','194');
INSERT `district`(`name`,`city_id`) VALUES('电白县','194');
INSERT `district`(`name`,`city_id`) VALUES('高州市','194');
INSERT `district`(`name`,`city_id`) VALUES('化州市','194');
INSERT `district`(`name`,`city_id`) VALUES('信宜市','194');


--195	惠州市
INSERT `district`(`name`,`city_id`) VALUES('惠城区','195');
INSERT `district`(`name`,`city_id`) VALUES('惠阳区','195');
INSERT `district`(`name`,`city_id`) VALUES('博罗县','195');
INSERT `district`(`name`,`city_id`) VALUES('惠东县','195');
INSERT `district`(`name`,`city_id`) VALUES('龙门县','195');


--196	江门市
INSERT `district`(`name`,`city_id`) VALUES('蓬江区','196');
INSERT `district`(`name`,`city_id`) VALUES('江海区','196');
INSERT `district`(`name`,`city_id`) VALUES('新会区','196');
INSERT `district`(`name`,`city_id`) VALUES('台山市','196');
INSERT `district`(`name`,`city_id`) VALUES('开平市','196');
INSERT `district`(`name`,`city_id`) VALUES('鹤山市','196');
INSERT `district`(`name`,`city_id`) VALUES('恩平市','196');

--197	韶关市
INSERT `district`(`name`,`city_id`) VALUES('武江区','197');
INSERT `district`(`name`,`city_id`) VALUES('浈江区','197');
INSERT `district`(`name`,`city_id`) VALUES('曲江区','197');
INSERT `district`(`name`,`city_id`) VALUES('始兴县','197');
INSERT `district`(`name`,`city_id`) VALUES('仁化县','197');
INSERT `district`(`name`,`city_id`) VALUES('翁源县','197');
INSERT `district`(`name`,`city_id`) VALUES('乳源瑶族自治县','197');
INSERT `district`(`name`,`city_id`) VALUES('新丰县','197');
INSERT `district`(`name`,`city_id`) VALUES('乐昌市','197');
INSERT `district`(`name`,`city_id`) VALUES('南雄市','197');


--198	梅州市
INSERT `district`(`name`,`city_id`) VALUES('梅江区','198');
INSERT `district`(`name`,`city_id`) VALUES('梅县','198');
INSERT `district`(`name`,`city_id`) VALUES('大埔县','198');
INSERT `district`(`name`,`city_id`) VALUES('丰顺县','198');
INSERT `district`(`name`,`city_id`) VALUES('五华县','198');
INSERT `district`(`name`,`city_id`) VALUES('平远县','198');
INSERT `district`(`name`,`city_id`) VALUES('蕉岭县','198');
INSERT `district`(`name`,`city_id`) VALUES('兴宁市','198');

--199	汕头市
INSERT `district`(`name`,`city_id`) VALUES('龙湖区','199');
INSERT `district`(`name`,`city_id`) VALUES('金平区','199');
INSERT `district`(`name`,`city_id`) VALUES('濠江区','199');
INSERT `district`(`name`,`city_id`) VALUES('潮阳区','199');
INSERT `district`(`name`,`city_id`) VALUES('潮南区','199');
INSERT `district`(`name`,`city_id`) VALUES('澄海区','199');
INSERT `district`(`name`,`city_id`) VALUES('南澳县','199');


--200	深圳市
INSERT `district`(`name`,`city_id`) VALUES('罗湖区','200');
INSERT `district`(`name`,`city_id`) VALUES('福田区','200');
INSERT `district`(`name`,`city_id`) VALUES('南山区','200');
INSERT `district`(`name`,`city_id`) VALUES('宝安区','200');
INSERT `district`(`name`,`city_id`) VALUES('龙岗区','200');
INSERT `district`(`name`,`city_id`) VALUES('盐田区','200');


--201	珠海市
INSERT `district`(`name`,`city_id`) VALUES('香洲区','201');
INSERT `district`(`name`,`city_id`) VALUES('斗门区','201');
INSERT `district`(`name`,`city_id`) VALUES('金湾区','201');


--202	佛山市
INSERT `district`(`name`,`city_id`) VALUES('禅城区','202');
INSERT `district`(`name`,`city_id`) VALUES('南海区','202');
INSERT `district`(`name`,`city_id`) VALUES('顺德区','202');
INSERT `district`(`name`,`city_id`) VALUES('三水区','202');
INSERT `district`(`name`,`city_id`) VALUES('高明区','202');


--203	肇庆市
INSERT `district`(`name`,`city_id`) VALUES('端州区','203');
INSERT `district`(`name`,`city_id`) VALUES('鼎湖区','203');
INSERT `district`(`name`,`city_id`) VALUES('广宁县','203');
INSERT `district`(`name`,`city_id`) VALUES('怀集县','203');
INSERT `district`(`name`,`city_id`) VALUES('封开县','203');
INSERT `district`(`name`,`city_id`) VALUES('德庆县','203');
INSERT `district`(`name`,`city_id`) VALUES('高要市','203');
INSERT `district`(`name`,`city_id`) VALUES('四会市','203');


--204	湛江市
INSERT `district`(`name`,`city_id`) VALUES('赤坎区','204');
INSERT `district`(`name`,`city_id`) VALUES('霞山区','204');
INSERT `district`(`name`,`city_id`) VALUES('坡头区','204');
INSERT `district`(`name`,`city_id`) VALUES('麻章区','204');
INSERT `district`(`name`,`city_id`) VALUES('遂溪县','204');
INSERT `district`(`name`,`city_id`) VALUES('徐闻县','204');
INSERT `district`(`name`,`city_id`) VALUES('廉江市','204');
INSERT `district`(`name`,`city_id`) VALUES('雷州市','204');
INSERT `district`(`name`,`city_id`) VALUES('吴川市','204');


--205	中山市(无);
--206	河源市
INSERT `district`(`name`,`city_id`) VALUES('源城区','206');
INSERT `district`(`name`,`city_id`) VALUES('紫金县','206');
INSERT `district`(`name`,`city_id`) VALUES('龙川县','206');
INSERT `district`(`name`,`city_id`) VALUES('连平县','206');
INSERT `district`(`name`,`city_id`) VALUES('和平县','206');
INSERT `district`(`name`,`city_id`) VALUES('东源县','206');

--207	清远市
INSERT `district`(`name`,`city_id`) VALUES('清城区','207');
INSERT `district`(`name`,`city_id`) VALUES('佛冈县','207');
INSERT `district`(`name`,`city_id`) VALUES('阳山县','207');
INSERT `district`(`name`,`city_id`) VALUES('连山壮族瑶族自治县','207');
INSERT `district`(`name`,`city_id`) VALUES('连南瑶族自治县','207');
INSERT `district`(`name`,`city_id`) VALUES('清新县','207');
INSERT `district`(`name`,`city_id`) VALUES('英德市','207');
INSERT `district`(`name`,`city_id`) VALUES('连州市','207');

--208	云浮市
INSERT `district`(`name`,`city_id`) VALUES('云城区','208');
INSERT `district`(`name`,`city_id`) VALUES('新兴县','208');
INSERT `district`(`name`,`city_id`) VALUES('郁南县','208');
INSERT `district`(`name`,`city_id`) VALUES('云安县','208');
INSERT `district`(`name`,`city_id`) VALUES('罗定市','208');

--209	潮州市
INSERT `district`(`name`,`city_id`) VALUES('湘桥区','209');
INSERT `district`(`name`,`city_id`) VALUES('潮安县','209');
INSERT `district`(`name`,`city_id`) VALUES('饶平县','209');

--210	东莞市(无);

--*********************************************************甘肃************************************************************************
--211	兰州市
INSERT `district`(`name`,`city_id`) VALUES('城关区','211');
INSERT `district`(`name`,`city_id`) VALUES('七里河区','211');
INSERT `district`(`name`,`city_id`) VALUES('西固区','211');
INSERT `district`(`name`,`city_id`) VALUES('安宁区','211');
INSERT `district`(`name`,`city_id`) VALUES('红古区','211');
INSERT `district`(`name`,`city_id`) VALUES('永登县','211');
INSERT `district`(`name`,`city_id`) VALUES('皋兰县','211');
INSERT `district`(`name`,`city_id`) VALUES('榆中县','211');

--212	金昌市
INSERT `district`(`name`,`city_id`) VALUES('金川区','212');
INSERT `district`(`name`,`city_id`) VALUES('永昌县','212');

--213	白银市
INSERT `district`(`name`,`city_id`) VALUES('白银区','213');
INSERT `district`(`name`,`city_id`) VALUES('平川区','213');
INSERT `district`(`name`,`city_id`) VALUES('靖远县','213');
INSERT `district`(`name`,`city_id`) VALUES('会宁县','213');
INSERT `district`(`name`,`city_id`) VALUES('景泰县','213');

--214	天水市
INSERT `district`(`name`,`city_id`) VALUES('秦州区','214');
INSERT `district`(`name`,`city_id`) VALUES('麦积区','214');
INSERT `district`(`name`,`city_id`) VALUES('清水县','214');
INSERT `district`(`name`,`city_id`) VALUES('秦安县','214');
INSERT `district`(`name`,`city_id`) VALUES('甘谷县','214');
INSERT `district`(`name`,`city_id`) VALUES('武山县','214');
INSERT `district`(`name`,`city_id`) VALUES('张家川回族自治县','214');

--215	嘉峪关市(无);
--216	武威市
INSERT `district`(`name`,`city_id`) VALUES('凉州区','216');
INSERT `district`(`name`,`city_id`) VALUES('民勤县','216');
INSERT `district`(`name`,`city_id`) VALUES('古浪县','216');
INSERT `district`(`name`,`city_id`) VALUES('天祝藏族自治县','216');

--217	张掖市
INSERT `district`(`name`,`city_id`) VALUES('甘州区','217');
INSERT `district`(`name`,`city_id`) VALUES('肃南裕固族自治县','217');
INSERT `district`(`name`,`city_id`) VALUES('民乐县','217');
INSERT `district`(`name`,`city_id`) VALUES('临泽县','217');
INSERT `district`(`name`,`city_id`) VALUES('高台县','217');
INSERT `district`(`name`,`city_id`) VALUES('山丹县','217');

--218	平凉市
INSERT `district`(`name`,`city_id`) VALUES('崆峒区','218');
INSERT `district`(`name`,`city_id`) VALUES('泾川县','218');
INSERT `district`(`name`,`city_id`) VALUES('灵台县','218');
INSERT `district`(`name`,`city_id`) VALUES('崇信县','218');
INSERT `district`(`name`,`city_id`) VALUES('华亭县','218');
INSERT `district`(`name`,`city_id`) VALUES('庄浪县','218');
INSERT `district`(`name`,`city_id`) VALUES('静宁县','218');

--219	酒泉市
INSERT `district`(`name`,`city_id`) VALUES('肃州区','219');
INSERT `district`(`name`,`city_id`) VALUES('金塔县','219');
INSERT `district`(`name`,`city_id`) VALUES('瓜州县','219');
INSERT `district`(`name`,`city_id`) VALUES('肃北蒙古族自治县','219');
INSERT `district`(`name`,`city_id`) VALUES('阿克塞哈萨克族自治县','219');
INSERT `district`(`name`,`city_id`) VALUES('玉门市','219');
INSERT `district`(`name`,`city_id`) VALUES('敦煌市','219');

--220	庆阳市
INSERT `district`(`name`,`city_id`) VALUES('西峰区','220');
INSERT `district`(`name`,`city_id`) VALUES('庆城县','220');
INSERT `district`(`name`,`city_id`) VALUES('环县','220');
INSERT `district`(`name`,`city_id`) VALUES('华池县','220');
INSERT `district`(`name`,`city_id`) VALUES('合水县','220');
INSERT `district`(`name`,`city_id`) VALUES('正宁县','220');
INSERT `district`(`name`,`city_id`) VALUES('宁县','220');
INSERT `district`(`name`,`city_id`) VALUES('镇原县','220');

--221	定西市
INSERT `district`(`name`,`city_id`) VALUES('安定区','221');
INSERT `district`(`name`,`city_id`) VALUES('通渭县','221');
INSERT `district`(`name`,`city_id`) VALUES('陇西县','221');
INSERT `district`(`name`,`city_id`) VALUES('渭源县','221');
INSERT `district`(`name`,`city_id`) VALUES('临洮县','221');
INSERT `district`(`name`,`city_id`) VALUES('漳县','221');
INSERT `district`(`name`,`city_id`) VALUES('岷县','221');

--222	陇南市
INSERT `district`(`name`,`city_id`) VALUES('武都区','222');
INSERT `district`(`name`,`city_id`) VALUES('成县','222');
INSERT `district`(`name`,`city_id`) VALUES('文县','222');
INSERT `district`(`name`,`city_id`) VALUES('宕昌县','222');
INSERT `district`(`name`,`city_id`) VALUES('康县','222');
INSERT `district`(`name`,`city_id`) VALUES('西和县','222');
INSERT `district`(`name`,`city_id`) VALUES('礼县','222');
INSERT `district`(`name`,`city_id`) VALUES('徽县','222');
INSERT `district`(`name`,`city_id`) VALUES('两当县','222');

--223	临夏回族自治州
INSERT `district`(`name`,`city_id`) VALUES('临夏市','223');
INSERT `district`(`name`,`city_id`) VALUES('临夏县','223');
INSERT `district`(`name`,`city_id`) VALUES('康乐县','223');
INSERT `district`(`name`,`city_id`) VALUES('永靖县','223');
INSERT `district`(`name`,`city_id`) VALUES('广河县','223');
INSERT `district`(`name`,`city_id`) VALUES('和政县','223');
INSERT `district`(`name`,`city_id`) VALUES('东乡族自治县','223');
INSERT `district`(`name`,`city_id`) VALUES('积石山保安族东乡族撒拉族自治县','223');

--224	甘南藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('合作市','224');
INSERT `district`(`name`,`city_id`) VALUES('临潭县','224');
INSERT `district`(`name`,`city_id`) VALUES('卓尼县','224');
INSERT `district`(`name`,`city_id`) VALUES('舟曲县','224');
INSERT `district`(`name`,`city_id`) VALUES('迭部县','224');
INSERT `district`(`name`,`city_id`) VALUES('玛曲县','224');
INSERT `district`(`name`,`city_id`) VALUES('碌曲县','224');
INSERT `district`(`name`,`city_id`) VALUES('夏河县','224');

--*********************************************************四川************************************************************************
--225	成都市
INSERT `district`(`name`,`city_id`) VALUES('锦江区','225');
INSERT `district`(`name`,`city_id`) VALUES('青羊区','225');
INSERT `district`(`name`,`city_id`) VALUES('金牛区','225');
INSERT `district`(`name`,`city_id`) VALUES('武侯区','225');
INSERT `district`(`name`,`city_id`) VALUES('成华区','225');
INSERT `district`(`name`,`city_id`) VALUES('龙泉驿区','225');
INSERT `district`(`name`,`city_id`) VALUES('青白江区','225');
INSERT `district`(`name`,`city_id`) VALUES('新都区','225');
INSERT `district`(`name`,`city_id`) VALUES('温江区','225');
INSERT `district`(`name`,`city_id`) VALUES('金堂县','225');
INSERT `district`(`name`,`city_id`) VALUES('双流县','225');
INSERT `district`(`name`,`city_id`) VALUES('郫县','225');
INSERT `district`(`name`,`city_id`) VALUES('大邑县','225');
INSERT `district`(`name`,`city_id`) VALUES('蒲江县','225');
INSERT `district`(`name`,`city_id`) VALUES('新津县','225');
INSERT `district`(`name`,`city_id`) VALUES('都江堰市','225');
INSERT `district`(`name`,`city_id`) VALUES('彭州市','225');
INSERT `district`(`name`,`city_id`) VALUES('邛崃市','225');
INSERT `district`(`name`,`city_id`) VALUES('崇州市','225');

--226	攀枝花市
INSERT `district`(`name`,`city_id`) VALUES('东区','226');
INSERT `district`(`name`,`city_id`) VALUES('西区','226');
INSERT `district`(`name`,`city_id`) VALUES('仁和区','226');
INSERT `district`(`name`,`city_id`) VALUES('米易县','226');
INSERT `district`(`name`,`city_id`) VALUES('盐边县','226');

--227	自贡市
INSERT `district`(`name`,`city_id`) VALUES('自流井区','227');
INSERT `district`(`name`,`city_id`) VALUES('贡井区','227');
INSERT `district`(`name`,`city_id`) VALUES('大安区','227');
INSERT `district`(`name`,`city_id`) VALUES('沿滩区','227');
INSERT `district`(`name`,`city_id`) VALUES('荣县','227');
INSERT `district`(`name`,`city_id`) VALUES('富顺县','227');

--228	绵阳市
INSERT `district`(`name`,`city_id`) VALUES('涪城区','228');
INSERT `district`(`name`,`city_id`) VALUES('游仙区','228');
INSERT `district`(`name`,`city_id`) VALUES('三台县','228');
INSERT `district`(`name`,`city_id`) VALUES('盐亭县','228');
INSERT `district`(`name`,`city_id`) VALUES('安县','228');
INSERT `district`(`name`,`city_id`) VALUES('梓潼县','228');
INSERT `district`(`name`,`city_id`) VALUES('北川羌族自治县','228');
INSERT `district`(`name`,`city_id`) VALUES('平武县','228');
INSERT `district`(`name`,`city_id`) VALUES('江油市','228');

--229	南充市
INSERT `district`(`name`,`city_id`) VALUES('顺庆区','229');
INSERT `district`(`name`,`city_id`) VALUES('高坪区','229');
INSERT `district`(`name`,`city_id`) VALUES('嘉陵区','229');
INSERT `district`(`name`,`city_id`) VALUES('南部县','229');
INSERT `district`(`name`,`city_id`) VALUES('营山县','229');
INSERT `district`(`name`,`city_id`) VALUES('蓬安县','229');
INSERT `district`(`name`,`city_id`) VALUES('仪陇县','229');
INSERT `district`(`name`,`city_id`) VALUES('西充县','229');
INSERT `district`(`name`,`city_id`) VALUES('阆中市','229');

--230	达州市
INSERT `district`(`name`,`city_id`) VALUES('通川区','230');
INSERT `district`(`name`,`city_id`) VALUES('达县','230');
INSERT `district`(`name`,`city_id`) VALUES('宣汉县','230');
INSERT `district`(`name`,`city_id`) VALUES('开江县','230');
INSERT `district`(`name`,`city_id`) VALUES('大竹县','230');
INSERT `district`(`name`,`city_id`) VALUES('渠县','230');
INSERT `district`(`name`,`city_id`) VALUES('万源市','230');

--231	遂宁市
INSERT `district`(`name`,`city_id`) VALUES('船山区','231');
INSERT `district`(`name`,`city_id`) VALUES('安居区','231');
INSERT `district`(`name`,`city_id`) VALUES('蓬溪县','231');
INSERT `district`(`name`,`city_id`) VALUES('射洪县','231');
INSERT `district`(`name`,`city_id`) VALUES('大英县','231');


--232	广安市
INSERT `district`(`name`,`city_id`) VALUES('广安区','232');
INSERT `district`(`name`,`city_id`) VALUES('岳池县','232');
INSERT `district`(`name`,`city_id`) VALUES('武胜县','232');
INSERT `district`(`name`,`city_id`) VALUES('邻水县','232');
INSERT `district`(`name`,`city_id`) VALUES('华蓥市','232');

--233	巴中市
INSERT `district`(`name`,`city_id`) VALUES('巴州区','233');
INSERT `district`(`name`,`city_id`) VALUES('通江县','233');
INSERT `district`(`name`,`city_id`) VALUES('南江县','233');
INSERT `district`(`name`,`city_id`) VALUES('平昌县','233');

--234	泸州市
INSERT `district`(`name`,`city_id`) VALUES('江阳区','234');
INSERT `district`(`name`,`city_id`) VALUES('纳溪区','234');
INSERT `district`(`name`,`city_id`) VALUES('龙马潭区','234');
INSERT `district`(`name`,`city_id`) VALUES('泸县','234');
INSERT `district`(`name`,`city_id`) VALUES('合江县','234');
INSERT `district`(`name`,`city_id`) VALUES('叙永县','234');
INSERT `district`(`name`,`city_id`) VALUES('古蔺县','234');

--235	宜宾市
INSERT `district`(`name`,`city_id`) VALUES('翠屏区','235');
INSERT `district`(`name`,`city_id`) VALUES('宜宾县','235');
INSERT `district`(`name`,`city_id`) VALUES('南溪县','235');
INSERT `district`(`name`,`city_id`) VALUES('江安县','235');
INSERT `district`(`name`,`city_id`) VALUES('长宁县','235');
INSERT `district`(`name`,`city_id`) VALUES('高县','235');
INSERT `district`(`name`,`city_id`) VALUES('珙县','235');
INSERT `district`(`name`,`city_id`) VALUES('筠连县','235');
INSERT `district`(`name`,`city_id`) VALUES('兴文县','235');
INSERT `district`(`name`,`city_id`) VALUES('屏山县','235');

--236	资阳市
INSERT `district`(`name`,`city_id`) VALUES('雁江区','236');
INSERT `district`(`name`,`city_id`) VALUES('安岳县','236');
INSERT `district`(`name`,`city_id`) VALUES('乐至县','236');
INSERT `district`(`name`,`city_id`) VALUES('简阳市','236');


--237	内江市
INSERT `district`(`name`,`city_id`) VALUES('市中区','237');
INSERT `district`(`name`,`city_id`) VALUES('东兴区','237');
INSERT `district`(`name`,`city_id`) VALUES('威远县','237');
INSERT `district`(`name`,`city_id`) VALUES('资中县','237');
INSERT `district`(`name`,`city_id`) VALUES('隆昌县','237');


--238	乐山市
INSERT `district`(`name`,`city_id`) VALUES('市中区','238');
INSERT `district`(`name`,`city_id`) VALUES('沙湾区','238');
INSERT `district`(`name`,`city_id`) VALUES('五通桥区','238');
INSERT `district`(`name`,`city_id`) VALUES('金口河区','238');
INSERT `district`(`name`,`city_id`) VALUES('犍为县','238');
INSERT `district`(`name`,`city_id`) VALUES('井研县','238');
INSERT `district`(`name`,`city_id`) VALUES('夹江县','238');
INSERT `district`(`name`,`city_id`) VALUES('沐川县','238');
INSERT `district`(`name`,`city_id`) VALUES('峨边彝族自治县','238');
INSERT `district`(`name`,`city_id`) VALUES('马边彝族自治县','238');
INSERT `district`(`name`,`city_id`) VALUES('峨眉山市','238');

--239	眉山市
INSERT `district`(`name`,`city_id`) VALUES('东坡区','239');
INSERT `district`(`name`,`city_id`) VALUES('仁寿县','239');
INSERT `district`(`name`,`city_id`) VALUES('彭山县','239');
INSERT `district`(`name`,`city_id`) VALUES('洪雅县','239');
INSERT `district`(`name`,`city_id`) VALUES('丹棱县','239');
INSERT `district`(`name`,`city_id`) VALUES('青神县','239');

--240	凉山彝族自治州
INSERT `district`(`name`,`city_id`) VALUES('西昌市','240');
INSERT `district`(`name`,`city_id`) VALUES('木里藏族自治县','240');
INSERT `district`(`name`,`city_id`) VALUES('盐源县','240');
INSERT `district`(`name`,`city_id`) VALUES('德昌县','240');
INSERT `district`(`name`,`city_id`) VALUES('会理县','240');
INSERT `district`(`name`,`city_id`) VALUES('会东县','240');
INSERT `district`(`name`,`city_id`) VALUES('宁南县','240');
INSERT `district`(`name`,`city_id`) VALUES('普格县','240');
INSERT `district`(`name`,`city_id`) VALUES('布拖县','240');
INSERT `district`(`name`,`city_id`) VALUES('金阳县','240');
INSERT `district`(`name`,`city_id`) VALUES('昭觉县','240');
INSERT `district`(`name`,`city_id`) VALUES('喜德县','240');
INSERT `district`(`name`,`city_id`) VALUES('冕宁县','240');
INSERT `district`(`name`,`city_id`) VALUES('越西县','240');
INSERT `district`(`name`,`city_id`) VALUES('甘洛县','240');
INSERT `district`(`name`,`city_id`) VALUES('美姑县','240');
INSERT `district`(`name`,`city_id`) VALUES('雷波县','240');


--241	雅安市
INSERT `district`(`name`,`city_id`) VALUES('雨城区','241');
INSERT `district`(`name`,`city_id`) VALUES('名山县','241');
INSERT `district`(`name`,`city_id`) VALUES('荥经县','241');
INSERT `district`(`name`,`city_id`) VALUES('汉源县','241');
INSERT `district`(`name`,`city_id`) VALUES('石棉县','241');
INSERT `district`(`name`,`city_id`) VALUES('天全县','241');
INSERT `district`(`name`,`city_id`) VALUES('芦山县','241');
INSERT `district`(`name`,`city_id`) VALUES('宝兴县','241');

--242	甘孜藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('康定县','242');
INSERT `district`(`name`,`city_id`) VALUES('泸定县','242');
INSERT `district`(`name`,`city_id`) VALUES('丹巴县','242');
INSERT `district`(`name`,`city_id`) VALUES('九龙县','242');
INSERT `district`(`name`,`city_id`) VALUES('雅江县','242');
INSERT `district`(`name`,`city_id`) VALUES('道孚县','242');
INSERT `district`(`name`,`city_id`) VALUES('炉霍县','242');
INSERT `district`(`name`,`city_id`) VALUES('甘孜县','242');
INSERT `district`(`name`,`city_id`) VALUES('新龙县','242');
INSERT `district`(`name`,`city_id`) VALUES('德格县','242');
INSERT `district`(`name`,`city_id`) VALUES('白玉县','242');
INSERT `district`(`name`,`city_id`) VALUES('石渠县','242');
INSERT `district`(`name`,`city_id`) VALUES('色达县','242');
INSERT `district`(`name`,`city_id`) VALUES('理塘县','242');
INSERT `district`(`name`,`city_id`) VALUES('巴塘县','242');
INSERT `district`(`name`,`city_id`) VALUES('乡城县','242');
INSERT `district`(`name`,`city_id`) VALUES('稻城县','242');
INSERT `district`(`name`,`city_id`) VALUES('得荣县','242');

--243	阿坝藏族羌族自治州
INSERT `district`(`name`,`city_id`) VALUES('汶川县','243');
INSERT `district`(`name`,`city_id`) VALUES('理县','243');
INSERT `district`(`name`,`city_id`) VALUES('茂县','243');
INSERT `district`(`name`,`city_id`) VALUES('松潘县','243');
INSERT `district`(`name`,`city_id`) VALUES('九寨沟县','243');
INSERT `district`(`name`,`city_id`) VALUES('金川县','243');
INSERT `district`(`name`,`city_id`) VALUES('小金县','243');
INSERT `district`(`name`,`city_id`) VALUES('黑水县','243');
INSERT `district`(`name`,`city_id`) VALUES('马尔康县','243');
INSERT `district`(`name`,`city_id`) VALUES('壤塘县','243');
INSERT `district`(`name`,`city_id`) VALUES('阿坝县','243');
INSERT `district`(`name`,`city_id`) VALUES('若尔盖县','243');
INSERT `district`(`name`,`city_id`) VALUES('红原县','243');

--244	德阳市
INSERT `district`(`name`,`city_id`) VALUES('旌阳区','244');
INSERT `district`(`name`,`city_id`) VALUES('中江县','244');
INSERT `district`(`name`,`city_id`) VALUES('罗江县','244');
INSERT `district`(`name`,`city_id`) VALUES('广汉市','244');
INSERT `district`(`name`,`city_id`) VALUES('什邡市','244');
INSERT `district`(`name`,`city_id`) VALUES('绵竹市','244');

--245	广元市
INSERT `district`(`name`,`city_id`) VALUES('市中区','245');
INSERT `district`(`name`,`city_id`) VALUES('元坝区','245');
INSERT `district`(`name`,`city_id`) VALUES('朝天区','245');
INSERT `district`(`name`,`city_id`) VALUES('旺苍县','245');
INSERT `district`(`name`,`city_id`) VALUES('青川县','245');
INSERT `district`(`name`,`city_id`) VALUES('剑阁县','245');
INSERT `district`(`name`,`city_id`) VALUES('苍溪县','245');

--*********************************************************贵州************************************************************************
--246	贵阳市
INSERT `district`(`name`,`city_id`) VALUES('南明区','246');
INSERT `district`(`name`,`city_id`) VALUES('云岩区','246');
INSERT `district`(`name`,`city_id`) VALUES('花溪区','246');
INSERT `district`(`name`,`city_id`) VALUES('乌当区','246');
INSERT `district`(`name`,`city_id`) VALUES('白云区','246');
INSERT `district`(`name`,`city_id`) VALUES('小河区','246');
INSERT `district`(`name`,`city_id`) VALUES('开阳县','246');
INSERT `district`(`name`,`city_id`) VALUES('息烽县','246');
INSERT `district`(`name`,`city_id`) VALUES('修文县','246');
INSERT `district`(`name`,`city_id`) VALUES('清镇市','246');


--247	遵义市
INSERT `district`(`name`,`city_id`) VALUES('红花岗区','247');
INSERT `district`(`name`,`city_id`) VALUES('汇川区','247');
INSERT `district`(`name`,`city_id`) VALUES('遵义县','247');
INSERT `district`(`name`,`city_id`) VALUES('桐梓县','247');
INSERT `district`(`name`,`city_id`) VALUES('绥阳县','247');
INSERT `district`(`name`,`city_id`) VALUES('正安县','247');
INSERT `district`(`name`,`city_id`) VALUES('道真仡佬族苗族自治县','247');
INSERT `district`(`name`,`city_id`) VALUES('务川仡佬族苗族自治县','247');
INSERT `district`(`name`,`city_id`) VALUES('凤冈县','247');
INSERT `district`(`name`,`city_id`) VALUES('湄潭县','247');
INSERT `district`(`name`,`city_id`) VALUES('余庆县','247');
INSERT `district`(`name`,`city_id`) VALUES('习水县','247');
INSERT `district`(`name`,`city_id`) VALUES('赤水市','247');
INSERT `district`(`name`,`city_id`) VALUES('仁怀市','247');


--248	安顺市
INSERT `district`(`name`,`city_id`) VALUES('西秀区','248');
INSERT `district`(`name`,`city_id`) VALUES('平坝县','248');
INSERT `district`(`name`,`city_id`) VALUES('普定县','248');
INSERT `district`(`name`,`city_id`) VALUES('镇宁布依族苗族自治县','248');
INSERT `district`(`name`,`city_id`) VALUES('关岭布依族苗族自治县','248');
INSERT `district`(`name`,`city_id`) VALUES('紫云苗族布依族自治县','248');

--249	黔南布依族苗族自治州
INSERT `district`(`name`,`city_id`) VALUES('都匀市','249');
INSERT `district`(`name`,`city_id`) VALUES('福泉市','249');
INSERT `district`(`name`,`city_id`) VALUES('荔波县','249');
INSERT `district`(`name`,`city_id`) VALUES('贵定县','249');
INSERT `district`(`name`,`city_id`) VALUES('瓮安县','249');
INSERT `district`(`name`,`city_id`) VALUES('独山县','249');
INSERT `district`(`name`,`city_id`) VALUES('平塘县','249');
INSERT `district`(`name`,`city_id`) VALUES('罗甸县','249');
INSERT `district`(`name`,`city_id`) VALUES('长顺县','249');
INSERT `district`(`name`,`city_id`) VALUES('龙里县','249');
INSERT `district`(`name`,`city_id`) VALUES('惠水县','249');
INSERT `district`(`name`,`city_id`) VALUES('三都水族自治县','249');


--250	黔东南苗族侗族自治州
INSERT `district`(`name`,`city_id`) VALUES('凯里市','250');
INSERT `district`(`name`,`city_id`) VALUES('黄平县','250');
INSERT `district`(`name`,`city_id`) VALUES('施秉县','250');
INSERT `district`(`name`,`city_id`) VALUES('三穗县','250');
INSERT `district`(`name`,`city_id`) VALUES('镇远县','250');
INSERT `district`(`name`,`city_id`) VALUES('岑巩县','250');
INSERT `district`(`name`,`city_id`) VALUES('天柱县','250');
INSERT `district`(`name`,`city_id`) VALUES('锦屏县','250');
INSERT `district`(`name`,`city_id`) VALUES('剑河县','250');
INSERT `district`(`name`,`city_id`) VALUES('台江县','250');
INSERT `district`(`name`,`city_id`) VALUES('黎平县','250');
INSERT `district`(`name`,`city_id`) VALUES('榕江县','250');
INSERT `district`(`name`,`city_id`) VALUES('从江县','250');
INSERT `district`(`name`,`city_id`) VALUES('雷山县','250');
INSERT `district`(`name`,`city_id`) VALUES('麻江县','250');
INSERT `district`(`name`,`city_id`) VALUES('丹寨县','250');


--251	铜仁地区
INSERT `district`(`name`,`city_id`) VALUES('铜仁市','251');
INSERT `district`(`name`,`city_id`) VALUES('江口县','251');
INSERT `district`(`name`,`city_id`) VALUES('玉屏侗族自治县','251');
INSERT `district`(`name`,`city_id`) VALUES('石阡县','251');
INSERT `district`(`name`,`city_id`) VALUES('思南县','251');
INSERT `district`(`name`,`city_id`) VALUES('印江土家族苗族自治县','251');
INSERT `district`(`name`,`city_id`) VALUES('德江县','251');
INSERT `district`(`name`,`city_id`) VALUES('沿河土家族自治县','251');
INSERT `district`(`name`,`city_id`) VALUES('松桃苗族自治县','251');
INSERT `district`(`name`,`city_id`) VALUES('万山特区','251');


--252	毕节地区
INSERT `district`(`name`,`city_id`) VALUES('毕节市','252');
INSERT `district`(`name`,`city_id`) VALUES('大方县','252');
INSERT `district`(`name`,`city_id`) VALUES('黔西县','252');
INSERT `district`(`name`,`city_id`) VALUES('金沙县','252');
INSERT `district`(`name`,`city_id`) VALUES('织金县','252');
INSERT `district`(`name`,`city_id`) VALUES('纳雍县','252');
INSERT `district`(`name`,`city_id`) VALUES('威宁彝族回族苗族自治县','252');
INSERT `district`(`name`,`city_id`) VALUES('赫章县','252');


--253	六盘水市
INSERT `district`(`name`,`city_id`) VALUES('钟山区','253');
INSERT `district`(`name`,`city_id`) VALUES('六枝特区','253');
INSERT `district`(`name`,`city_id`) VALUES('水城县','253');
INSERT `district`(`name`,`city_id`) VALUES('盘县','253');

--254	黔西南布依族苗族自治州
INSERT `district`(`name`,`city_id`) VALUES('兴义市','254');
INSERT `district`(`name`,`city_id`) VALUES('兴仁县','254');
INSERT `district`(`name`,`city_id`) VALUES('普安县','254');
INSERT `district`(`name`,`city_id`) VALUES('晴隆县','254');
INSERT `district`(`name`,`city_id`) VALUES('贞丰县','254');
INSERT `district`(`name`,`city_id`) VALUES('望谟县','254');
INSERT `district`(`name`,`city_id`) VALUES('册亨县','254');
INSERT `district`(`name`,`city_id`) VALUES('安龙县','254');


--*********************************************************海南************************************************************************
--255	海口市
INSERT `district`(`name`,`city_id`) VALUES('秀英区','255');
INSERT `district`(`name`,`city_id`) VALUES('龙华区','255');
INSERT `district`(`name`,`city_id`) VALUES('琼山区','255');
INSERT `district`(`name`,`city_id`) VALUES('美兰区','255');

--256	三亚市(无);
--257	五指山市(无);
--258	琼海市(无);
--259	儋州市(无);
--260	文昌市(无);
--261	万宁市(无);
--262	东方市(无);
--263	澄迈县(无);
--264	定安县(无);
--265	屯昌县(无);
--266	临高县(无);
--267	白沙黎族自治县(无);
--268	昌江黎族自治县(无);
--269	乐东黎族自治县(无);
--270	陵水黎族自治县(无);
--271	保亭黎族苗族自治县(无);
--272	琼中黎族苗族自治县(无);

--*********************************************************云南************************************************************************
--273	西双版纳傣族自治州
INSERT `district`(`name`,`city_id`) VALUES('景洪市','273');
INSERT `district`(`name`,`city_id`) VALUES('勐海县','273');
INSERT `district`(`name`,`city_id`) VALUES('勐腊县','273');

--274	德宏傣族景颇族自治州
INSERT `district`(`name`,`city_id`) VALUES('瑞丽市','274');
INSERT `district`(`name`,`city_id`) VALUES('潞西市','274');
INSERT `district`(`name`,`city_id`) VALUES('梁河县','274');
INSERT `district`(`name`,`city_id`) VALUES('盈江县','274');
INSERT `district`(`name`,`city_id`) VALUES('陇川县','274');

--275	昭通市
INSERT `district`(`name`,`city_id`) VALUES('昭阳区','275');
INSERT `district`(`name`,`city_id`) VALUES('鲁甸县','275');
INSERT `district`(`name`,`city_id`) VALUES('巧家县','275');
INSERT `district`(`name`,`city_id`) VALUES('盐津县','275');
INSERT `district`(`name`,`city_id`) VALUES('大关县','275');
INSERT `district`(`name`,`city_id`) VALUES('永善县','275');
INSERT `district`(`name`,`city_id`) VALUES('绥江县','275');
INSERT `district`(`name`,`city_id`) VALUES('镇雄县','275');
INSERT `district`(`name`,`city_id`) VALUES('彝良县','275');
INSERT `district`(`name`,`city_id`) VALUES('威信县','275');
INSERT `district`(`name`,`city_id`) VALUES('水富县','275');

--276	昆明市
INSERT `district`(`name`,`city_id`) VALUES('五华区','276');
INSERT `district`(`name`,`city_id`) VALUES('盘龙区','276');
INSERT `district`(`name`,`city_id`) VALUES('官渡区','276');
INSERT `district`(`name`,`city_id`) VALUES('西山区','276');
INSERT `district`(`name`,`city_id`) VALUES('东川区','276');
INSERT `district`(`name`,`city_id`) VALUES('呈贡县','276');
INSERT `district`(`name`,`city_id`) VALUES('晋宁县','276');
INSERT `district`(`name`,`city_id`) VALUES('富民县','276');
INSERT `district`(`name`,`city_id`) VALUES('宜良县','276');
INSERT `district`(`name`,`city_id`) VALUES('石林彝族自治县','276');
INSERT `district`(`name`,`city_id`) VALUES('嵩明县','276');
INSERT `district`(`name`,`city_id`) VALUES('禄劝彝族苗族自治县','276');
INSERT `district`(`name`,`city_id`) VALUES('寻甸回族彝族自治县','276');
INSERT `district`(`name`,`city_id`) VALUES('安宁市','276');

--277	大理白族自治州
INSERT `district`(`name`,`city_id`) VALUES('大理市','277');
INSERT `district`(`name`,`city_id`) VALUES('漾濞彝族自治县','277');
INSERT `district`(`name`,`city_id`) VALUES('祥云县','277');
INSERT `district`(`name`,`city_id`) VALUES('宾川县','277');
INSERT `district`(`name`,`city_id`) VALUES('弥渡县','277');
INSERT `district`(`name`,`city_id`) VALUES('南涧彝族自治县','277');
INSERT `district`(`name`,`city_id`) VALUES('巍山彝族回族自治县','277');
INSERT `district`(`name`,`city_id`) VALUES('永平县','277');
INSERT `district`(`name`,`city_id`) VALUES('云龙县','277');
INSERT `district`(`name`,`city_id`) VALUES('洱源县','277');
INSERT `district`(`name`,`city_id`) VALUES('剑川县','277');
INSERT `district`(`name`,`city_id`) VALUES('鹤庆县','277');

--278	红河哈尼族彝族自治州
INSERT `district`(`name`,`city_id`) VALUES('个旧市','278');
INSERT `district`(`name`,`city_id`) VALUES('开远市','278');
INSERT `district`(`name`,`city_id`) VALUES('蒙自县','278');
INSERT `district`(`name`,`city_id`) VALUES('屏边苗族自治县','278');
INSERT `district`(`name`,`city_id`) VALUES('建水县','278');
INSERT `district`(`name`,`city_id`) VALUES('石屏县','278');
INSERT `district`(`name`,`city_id`) VALUES('弥勒县','278');
INSERT `district`(`name`,`city_id`) VALUES('泸西县','278');
INSERT `district`(`name`,`city_id`) VALUES('元阳县','278');
INSERT `district`(`name`,`city_id`) VALUES('红河县','278');
INSERT `district`(`name`,`city_id`) VALUES('金平苗族瑶族傣族自治县','278');
INSERT `district`(`name`,`city_id`) VALUES('绿春县','278');
INSERT `district`(`name`,`city_id`) VALUES('河口瑶族自治县','278');

--279	曲靖市
INSERT `district`(`name`,`city_id`) VALUES('麒麟区','279');
INSERT `district`(`name`,`city_id`) VALUES('马龙县','279');
INSERT `district`(`name`,`city_id`) VALUES('陆良县','279');
INSERT `district`(`name`,`city_id`) VALUES('师宗县','279');
INSERT `district`(`name`,`city_id`) VALUES('罗平县','279');
INSERT `district`(`name`,`city_id`) VALUES('富源县','279');
INSERT `district`(`name`,`city_id`) VALUES('会泽县','279');
INSERT `district`(`name`,`city_id`) VALUES('沾益县','279');
INSERT `district`(`name`,`city_id`) VALUES('宣威市','279');

--280	保山市
INSERT `district`(`name`,`city_id`) VALUES('隆阳区','280');
INSERT `district`(`name`,`city_id`) VALUES('施甸县','280');
INSERT `district`(`name`,`city_id`) VALUES('腾冲县','280');
INSERT `district`(`name`,`city_id`) VALUES('龙陵县','280');
INSERT `district`(`name`,`city_id`) VALUES('昌宁县','280');

--281	文山壮族苗族自治州
INSERT `district`(`name`,`city_id`) VALUES('文山县','281');
INSERT `district`(`name`,`city_id`) VALUES('砚山县','281');
INSERT `district`(`name`,`city_id`) VALUES('西畴县','281');
INSERT `district`(`name`,`city_id`) VALUES('麻栗坡县','281');
INSERT `district`(`name`,`city_id`) VALUES('马关县','281');
INSERT `district`(`name`,`city_id`) VALUES('丘北县','281');
INSERT `district`(`name`,`city_id`) VALUES('广南县','281');
INSERT `district`(`name`,`city_id`) VALUES('富宁县','281');

--282	玉溪市
INSERT `district`(`name`,`city_id`) VALUES('红塔区','282');
INSERT `district`(`name`,`city_id`) VALUES('江川县','282');
INSERT `district`(`name`,`city_id`) VALUES('澄江县','282');
INSERT `district`(`name`,`city_id`) VALUES('通海县','282');
INSERT `district`(`name`,`city_id`) VALUES('华宁县','282');
INSERT `district`(`name`,`city_id`) VALUES('易门县','282');
INSERT `district`(`name`,`city_id`) VALUES('峨山彝族自治县','282');
INSERT `district`(`name`,`city_id`) VALUES('新平彝族傣族自治县','282');
INSERT `district`(`name`,`city_id`) VALUES('元江哈尼族彝族傣族自治县','282');

--283	楚雄彝族自治州
INSERT `district`(`name`,`city_id`) VALUES('楚雄市','283');
INSERT `district`(`name`,`city_id`) VALUES('双柏县','283');
INSERT `district`(`name`,`city_id`) VALUES('牟定县','283');
INSERT `district`(`name`,`city_id`) VALUES('南华县','283');
INSERT `district`(`name`,`city_id`) VALUES('姚安县','283');
INSERT `district`(`name`,`city_id`) VALUES('大姚县','283');
INSERT `district`(`name`,`city_id`) VALUES('永仁县','283');
INSERT `district`(`name`,`city_id`) VALUES('元谋县','283');
INSERT `district`(`name`,`city_id`) VALUES('武定县','283');
INSERT `district`(`name`,`city_id`) VALUES('禄丰县','283');

--284	普洱市
INSERT `district`(`name`,`city_id`) VALUES('思茅区','284');
INSERT `district`(`name`,`city_id`) VALUES('宁洱哈尼族彝族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('墨江哈尼族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('景东彝族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('景谷傣族彝族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('镇沅彝族哈尼族拉祜族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('江城哈尼族彝族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('孟连傣族拉祜族佤族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('澜沧拉祜族自治县','284');
INSERT `district`(`name`,`city_id`) VALUES('西盟佤族自治县','284');
 
--285	临沧市
INSERT `district`(`name`,`city_id`) VALUES('临翔区','285');
INSERT `district`(`name`,`city_id`) VALUES('凤庆县','285');
INSERT `district`(`name`,`city_id`) VALUES('云县','285');
INSERT `district`(`name`,`city_id`) VALUES('永德县','285');
INSERT `district`(`name`,`city_id`) VALUES('镇康县','285');
INSERT `district`(`name`,`city_id`) VALUES('双江拉祜族佤族布朗族傣族自治县','285');
INSERT `district`(`name`,`city_id`) VALUES('耿马傣族佤族自治县','285');
INSERT `district`(`name`,`city_id`) VALUES('沧源佤族自治县','285');

--286	怒江傈傈族自治州
INSERT `district`(`name`,`city_id`) VALUES('泸水县','286');
INSERT `district`(`name`,`city_id`) VALUES('福贡县','286');
INSERT `district`(`name`,`city_id`) VALUES('贡山独龙族怒族自治县','286');
INSERT `district`(`name`,`city_id`) VALUES('兰坪白族普米族自治县','286');

--287	迪庆藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('香格里拉县','287');
INSERT `district`(`name`,`city_id`) VALUES('德钦县','287');
INSERT `district`(`name`,`city_id`) VALUES('维西傈僳族自治县','287');


--288	丽江市
INSERT `district`(`name`,`city_id`) VALUES('古城区','288');
INSERT `district`(`name`,`city_id`) VALUES('玉龙纳西族自治县','288');
INSERT `district`(`name`,`city_id`) VALUES('永胜县','288');
INSERT `district`(`name`,`city_id`) VALUES('华坪县','288');
INSERT `district`(`name`,`city_id`) VALUES('宁蒗彝族自治县','288');


--*********************************************************青海************************************************************************
--289	海北藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('门源回族自治县','289');
INSERT `district`(`name`,`city_id`) VALUES('祁连县','289');
INSERT `district`(`name`,`city_id`) VALUES('海晏县','289');
INSERT `district`(`name`,`city_id`) VALUES('刚察县','289');

--290	西宁市
INSERT `district`(`name`,`city_id`) VALUES('城东区','290');
INSERT `district`(`name`,`city_id`) VALUES('城中区','290');
INSERT `district`(`name`,`city_id`) VALUES('城西区','290');
INSERT `district`(`name`,`city_id`) VALUES('城北区','290');
INSERT `district`(`name`,`city_id`) VALUES('大通回族土族自治县','290');
INSERT `district`(`name`,`city_id`) VALUES('湟中县','290');
INSERT `district`(`name`,`city_id`) VALUES('湟源县','290');

--291	海东地区
INSERT `district`(`name`,`city_id`) VALUES('平安县','291');
INSERT `district`(`name`,`city_id`) VALUES('民和回族土族自治县','291');
INSERT `district`(`name`,`city_id`) VALUES('乐都县','291');
INSERT `district`(`name`,`city_id`) VALUES('互助土族自治县','291');
INSERT `district`(`name`,`city_id`) VALUES('化隆回族自治县','291');
INSERT `district`(`name`,`city_id`) VALUES('循化撒拉族自治县','291');

--292	黄南藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('同仁县','292');
INSERT `district`(`name`,`city_id`) VALUES('尖扎县','292');
INSERT `district`(`name`,`city_id`) VALUES('泽库县','292');
INSERT `district`(`name`,`city_id`) VALUES('河南蒙古族自治县','292');

--293	海南藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('共和县','293');
INSERT `district`(`name`,`city_id`) VALUES('同德县','293');
INSERT `district`(`name`,`city_id`) VALUES('贵德县','293');
INSERT `district`(`name`,`city_id`) VALUES('兴海县','293');
INSERT `district`(`name`,`city_id`) VALUES('贵南县','293');
--294	果洛藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('玛沁县','294');
INSERT `district`(`name`,`city_id`) VALUES('班玛县','294');
INSERT `district`(`name`,`city_id`) VALUES('甘德县','294');
INSERT `district`(`name`,`city_id`) VALUES('达日县','294');
INSERT `district`(`name`,`city_id`) VALUES('久治县','294');
INSERT `district`(`name`,`city_id`) VALUES('玛多县','294');

--295	玉树藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('玉树县','295');
INSERT `district`(`name`,`city_id`) VALUES('杂多县','295');
INSERT `district`(`name`,`city_id`) VALUES('称多县','295');
INSERT `district`(`name`,`city_id`) VALUES('治多县','295');
INSERT `district`(`name`,`city_id`) VALUES('囊谦县','295');
INSERT `district`(`name`,`city_id`) VALUES('曲麻莱县','295');

--296	海西蒙古族藏族自治州
INSERT `district`(`name`,`city_id`) VALUES('格尔木市','296');
INSERT `district`(`name`,`city_id`) VALUES('德令哈市','296');
INSERT `district`(`name`,`city_id`) VALUES('乌兰县','296');
INSERT `district`(`name`,`city_id`) VALUES('都兰县','296');
INSERT `district`(`name`,`city_id`) VALUES('天峻县','296');

--*********************************************************陕西************************************************************************
--297	西安市
INSERT `district`(`name`,`city_id`) VALUES('新城区','297');
INSERT `district`(`name`,`city_id`) VALUES('碑林区','297');
INSERT `district`(`name`,`city_id`) VALUES('莲湖区','297');
INSERT `district`(`name`,`city_id`) VALUES('灞桥区','297');
INSERT `district`(`name`,`city_id`) VALUES('未央区','297');
INSERT `district`(`name`,`city_id`) VALUES('雁塔区','297');
INSERT `district`(`name`,`city_id`) VALUES('阎良区','297');
INSERT `district`(`name`,`city_id`) VALUES('临潼区','297');
INSERT `district`(`name`,`city_id`) VALUES('长安区','297');
INSERT `district`(`name`,`city_id`) VALUES('蓝田县','297');
INSERT `district`(`name`,`city_id`) VALUES('周至县','297');
INSERT `district`(`name`,`city_id`) VALUES('户县','297');
INSERT `district`(`name`,`city_id`) VALUES('高陵县','297');

--298	咸阳市
INSERT `district`(`name`,`city_id`) VALUES('秦都区','298');
INSERT `district`(`name`,`city_id`) VALUES('杨陵区','298');
INSERT `district`(`name`,`city_id`) VALUES('渭城区','298');
INSERT `district`(`name`,`city_id`) VALUES('三原县','298');
INSERT `district`(`name`,`city_id`) VALUES('泾阳县','298');
INSERT `district`(`name`,`city_id`) VALUES('乾县','298');
INSERT `district`(`name`,`city_id`) VALUES('礼泉县','298');
INSERT `district`(`name`,`city_id`) VALUES('永寿县','298');
INSERT `district`(`name`,`city_id`) VALUES('彬县','298');
INSERT `district`(`name`,`city_id`) VALUES('长武县','298');
INSERT `district`(`name`,`city_id`) VALUES('旬邑县','298');
INSERT `district`(`name`,`city_id`) VALUES('淳化县','298');
INSERT `district`(`name`,`city_id`) VALUES('武功县','298');
INSERT `district`(`name`,`city_id`) VALUES('兴平市','298');

--299	延安市
INSERT `district`(`name`,`city_id`) VALUES('宝塔区','299');
INSERT `district`(`name`,`city_id`) VALUES('延长县','299');
INSERT `district`(`name`,`city_id`) VALUES('延川县','299');
INSERT `district`(`name`,`city_id`) VALUES('子长县','299');
INSERT `district`(`name`,`city_id`) VALUES('安塞县','299');
INSERT `district`(`name`,`city_id`) VALUES('志丹县','299');
INSERT `district`(`name`,`city_id`) VALUES('吴起县','299');
INSERT `district`(`name`,`city_id`) VALUES('甘泉县','299');
INSERT `district`(`name`,`city_id`) VALUES('富县','299');
INSERT `district`(`name`,`city_id`) VALUES('洛川县','299');
INSERT `district`(`name`,`city_id`) VALUES('宜川县','299');
INSERT `district`(`name`,`city_id`) VALUES('黄龙县','299');
INSERT `district`(`name`,`city_id`) VALUES('黄陵县','299');

--300	榆林市
INSERT `district`(`name`,`city_id`) VALUES('榆阳区','300');
INSERT `district`(`name`,`city_id`) VALUES('神木县','300');
INSERT `district`(`name`,`city_id`) VALUES('府谷县','300');
INSERT `district`(`name`,`city_id`) VALUES('横山县','300');
INSERT `district`(`name`,`city_id`) VALUES('靖边县','300');
INSERT `district`(`name`,`city_id`) VALUES('定边县','300');
INSERT `district`(`name`,`city_id`) VALUES('绥德县','300');
INSERT `district`(`name`,`city_id`) VALUES('米脂县','300');
INSERT `district`(`name`,`city_id`) VALUES('佳县','300');
INSERT `district`(`name`,`city_id`) VALUES('吴堡县','300');
INSERT `district`(`name`,`city_id`) VALUES('清涧县','300');
INSERT `district`(`name`,`city_id`) VALUES('子洲县','300');


--301	渭南市
INSERT `district`(`name`,`city_id`) VALUES('临渭区','301');
INSERT `district`(`name`,`city_id`) VALUES('华县','301');
INSERT `district`(`name`,`city_id`) VALUES('潼关县','301');
INSERT `district`(`name`,`city_id`) VALUES('大荔县','301');
INSERT `district`(`name`,`city_id`) VALUES('合阳县','301');
INSERT `district`(`name`,`city_id`) VALUES('澄城县','301');
INSERT `district`(`name`,`city_id`) VALUES('蒲城县','301');
INSERT `district`(`name`,`city_id`) VALUES('白水县','301');
INSERT `district`(`name`,`city_id`) VALUES('富平县','301');
INSERT `district`(`name`,`city_id`) VALUES('韩城市','301');
INSERT `district`(`name`,`city_id`) VALUES('华阴市','301');

--302	商洛市
INSERT `district`(`name`,`city_id`) VALUES('商州区','302');
INSERT `district`(`name`,`city_id`) VALUES('洛南县','302');
INSERT `district`(`name`,`city_id`) VALUES('丹凤县','302');
INSERT `district`(`name`,`city_id`) VALUES('商南县','302');
INSERT `district`(`name`,`city_id`) VALUES('山阳县','302');
INSERT `district`(`name`,`city_id`) VALUES('镇安县','302');
INSERT `district`(`name`,`city_id`) VALUES('柞水县','302');

--303	安康市
INSERT `district`(`name`,`city_id`) VALUES('汉滨区','303');
INSERT `district`(`name`,`city_id`) VALUES('汉阴县','303');
INSERT `district`(`name`,`city_id`) VALUES('石泉县','303');
INSERT `district`(`name`,`city_id`) VALUES('宁陕县','303');
INSERT `district`(`name`,`city_id`) VALUES('紫阳县','303');
INSERT `district`(`name`,`city_id`) VALUES('岚皋县','303');
INSERT `district`(`name`,`city_id`) VALUES('平利县','303');
INSERT `district`(`name`,`city_id`) VALUES('镇坪县','303');
INSERT `district`(`name`,`city_id`) VALUES('旬阳县','303');
INSERT `district`(`name`,`city_id`) VALUES('白河县','303');

--304	汉中市
INSERT `district`(`name`,`city_id`) VALUES('汉台区','304');
INSERT `district`(`name`,`city_id`) VALUES('南郑县','304');
INSERT `district`(`name`,`city_id`) VALUES('城固县','304');
INSERT `district`(`name`,`city_id`) VALUES('洋县','304');
INSERT `district`(`name`,`city_id`) VALUES('西乡县','304');
INSERT `district`(`name`,`city_id`) VALUES('勉县','304');
INSERT `district`(`name`,`city_id`) VALUES('宁强县','304');
INSERT `district`(`name`,`city_id`) VALUES('略阳县','304');
INSERT `district`(`name`,`city_id`) VALUES('镇巴县','304');
INSERT `district`(`name`,`city_id`) VALUES('留坝县','304');
INSERT `district`(`name`,`city_id`) VALUES('佛坪县','304');

--305	宝鸡市
INSERT `district`(`name`,`city_id`) VALUES('渭滨区','305');
INSERT `district`(`name`,`city_id`) VALUES('金台区','305');
INSERT `district`(`name`,`city_id`) VALUES('陈仓区','305');
INSERT `district`(`name`,`city_id`) VALUES('凤翔县','305');
INSERT `district`(`name`,`city_id`) VALUES('岐山县','305');
INSERT `district`(`name`,`city_id`) VALUES('扶风县','305');
INSERT `district`(`name`,`city_id`) VALUES('眉县','305');
INSERT `district`(`name`,`city_id`) VALUES('陇县','305');
INSERT `district`(`name`,`city_id`) VALUES('千阳县','305');
INSERT `district`(`name`,`city_id`) VALUES('麟游县','305');
INSERT `district`(`name`,`city_id`) VALUES('凤县','305');
INSERT `district`(`name`,`city_id`) VALUES('太白县','305');

--306	铜川市
INSERT `district`(`name`,`city_id`) VALUES('王益区','306');
INSERT `district`(`name`,`city_id`) VALUES('印台区','306');
INSERT `district`(`name`,`city_id`) VALUES('耀州区','306');
INSERT `district`(`name`,`city_id`) VALUES('宜君县','306');


--*********************************************************广西************************************************************************
--307	防城港市
INSERT `district`(`name`,`city_id`) VALUES('港口区','307');
INSERT `district`(`name`,`city_id`) VALUES('防城区','307');
INSERT `district`(`name`,`city_id`) VALUES('上思县','307');
INSERT `district`(`name`,`city_id`) VALUES('东兴市','307');

--308	南宁市
INSERT `district`(`name`,`city_id`) VALUES('兴宁区','308');
INSERT `district`(`name`,`city_id`) VALUES('青秀区','308');
INSERT `district`(`name`,`city_id`) VALUES('江南区','308');
INSERT `district`(`name`,`city_id`) VALUES('西乡塘区','308');
INSERT `district`(`name`,`city_id`) VALUES('良庆区','308');
INSERT `district`(`name`,`city_id`) VALUES('邕宁区','308');
INSERT `district`(`name`,`city_id`) VALUES('武鸣县','308');
INSERT `district`(`name`,`city_id`) VALUES('隆安县','308');
INSERT `district`(`name`,`city_id`) VALUES('马山县','308');
INSERT `district`(`name`,`city_id`) VALUES('上林县','308');
INSERT `district`(`name`,`city_id`) VALUES('宾阳县','308');
INSERT `district`(`name`,`city_id`) VALUES('横县','308');

--309	崇左市
INSERT `district`(`name`,`city_id`) VALUES('江洲区','309');
INSERT `district`(`name`,`city_id`) VALUES('扶绥县','309');
INSERT `district`(`name`,`city_id`) VALUES('宁明县','309');
INSERT `district`(`name`,`city_id`) VALUES('龙州县','309');
INSERT `district`(`name`,`city_id`) VALUES('大新县','309');
INSERT `district`(`name`,`city_id`) VALUES('天等县','309');
INSERT `district`(`name`,`city_id`) VALUES('凭祥市','309');


--310	来宾市
INSERT `district`(`name`,`city_id`) VALUES('兴宾区','310');
INSERT `district`(`name`,`city_id`) VALUES('忻城县','310');
INSERT `district`(`name`,`city_id`) VALUES('象州县','310');
INSERT `district`(`name`,`city_id`) VALUES('武宣县','310');
INSERT `district`(`name`,`city_id`) VALUES('金秀瑶族自治县','310');
INSERT `district`(`name`,`city_id`) VALUES('合山市','310');

--311	柳州市
INSERT `district`(`name`,`city_id`) VALUES('城中区','311');
INSERT `district`(`name`,`city_id`) VALUES('鱼峰区','311');
INSERT `district`(`name`,`city_id`) VALUES('柳南区','311');
INSERT `district`(`name`,`city_id`) VALUES('柳北区','311');
INSERT `district`(`name`,`city_id`) VALUES('柳江县','311');
INSERT `district`(`name`,`city_id`) VALUES('柳城县','311');
INSERT `district`(`name`,`city_id`) VALUES('鹿寨县','311');
INSERT `district`(`name`,`city_id`) VALUES('融安县','311');
INSERT `district`(`name`,`city_id`) VALUES('融水苗族自治县','311');
INSERT `district`(`name`,`city_id`) VALUES('三江侗族自治县','311');

--312	桂林市
INSERT `district`(`name`,`city_id`) VALUES('秀峰区','312');
INSERT `district`(`name`,`city_id`) VALUES('叠彩区','312');
INSERT `district`(`name`,`city_id`) VALUES('象山区','312');
INSERT `district`(`name`,`city_id`) VALUES('七星区','312');
INSERT `district`(`name`,`city_id`) VALUES('雁山区','312');
INSERT `district`(`name`,`city_id`) VALUES('阳朔县','312');
INSERT `district`(`name`,`city_id`) VALUES('临桂县','312');
INSERT `district`(`name`,`city_id`) VALUES('灵川县','312');
INSERT `district`(`name`,`city_id`) VALUES('全州县','312');
INSERT `district`(`name`,`city_id`) VALUES('兴安县','312');
INSERT `district`(`name`,`city_id`) VALUES('永福县','312');
INSERT `district`(`name`,`city_id`) VALUES('灌阳县','312');
INSERT `district`(`name`,`city_id`) VALUES('龙胜各族自治县','312');
INSERT `district`(`name`,`city_id`) VALUES('资源县','312');
INSERT `district`(`name`,`city_id`) VALUES('平乐县','312');
INSERT `district`(`name`,`city_id`) VALUES('荔浦县','312');
INSERT `district`(`name`,`city_id`) VALUES('恭城瑶族自治县','312');

--313	梧州市
INSERT `district`(`name`,`city_id`) VALUES('万秀区','313');
INSERT `district`(`name`,`city_id`) VALUES('碟山区','313');
INSERT `district`(`name`,`city_id`) VALUES('长洲区','313');
INSERT `district`(`name`,`city_id`) VALUES('苍梧县','313');
INSERT `district`(`name`,`city_id`) VALUES('藤县','313');
INSERT `district`(`name`,`city_id`) VALUES('蒙山县','313');
INSERT `district`(`name`,`city_id`) VALUES('岑溪市','313');

--314	贺州市
INSERT `district`(`name`,`city_id`) VALUES('八步区','314');
INSERT `district`(`name`,`city_id`) VALUES('昭平县','314');
INSERT `district`(`name`,`city_id`) VALUES('钟山县','314');
INSERT `district`(`name`,`city_id`) VALUES('富川瑶族自治县','314');

--315	贵港市
INSERT `district`(`name`,`city_id`) VALUES('港北区','315');
INSERT `district`(`name`,`city_id`) VALUES('港南区','315');
INSERT `district`(`name`,`city_id`) VALUES('覃塘区','315');
INSERT `district`(`name`,`city_id`) VALUES('平南县','315');
INSERT `district`(`name`,`city_id`) VALUES('桂平市','315');

--316	玉林市
INSERT `district`(`name`,`city_id`) VALUES('玉州区','316');
INSERT `district`(`name`,`city_id`) VALUES('容县','316');
INSERT `district`(`name`,`city_id`) VALUES('陆川县','316');
INSERT `district`(`name`,`city_id`) VALUES('博白县','316');
INSERT `district`(`name`,`city_id`) VALUES('兴业县','316');
INSERT `district`(`name`,`city_id`) VALUES('北流市','316');

--317	百色市
INSERT `district`(`name`,`city_id`) VALUES('右江区','317');
INSERT `district`(`name`,`city_id`) VALUES('田阳县','317');
INSERT `district`(`name`,`city_id`) VALUES('田东县','317');
INSERT `district`(`name`,`city_id`) VALUES('平果县','317');
INSERT `district`(`name`,`city_id`) VALUES('德保县','317');
INSERT `district`(`name`,`city_id`) VALUES('靖西县','317');
INSERT `district`(`name`,`city_id`) VALUES('那坡县','317');
INSERT `district`(`name`,`city_id`) VALUES('凌云县','317');
INSERT `district`(`name`,`city_id`) VALUES('乐业县','317');
INSERT `district`(`name`,`city_id`) VALUES('田林县','317');
INSERT `district`(`name`,`city_id`) VALUES('西林县','317');
INSERT `district`(`name`,`city_id`) VALUES('隆林各族自治县','317');

--318	钦州市
INSERT `district`(`name`,`city_id`) VALUES('钦南区','318');
INSERT `district`(`name`,`city_id`) VALUES('钦北区','318');
INSERT `district`(`name`,`city_id`) VALUES('灵山县','318');
INSERT `district`(`name`,`city_id`) VALUES('浦北县','318');

--319	河池市
INSERT `district`(`name`,`city_id`) VALUES('金城江区','319');
INSERT `district`(`name`,`city_id`) VALUES('南丹县','319');
INSERT `district`(`name`,`city_id`) VALUES('天峨县','319');
INSERT `district`(`name`,`city_id`) VALUES('凤山县','319');
INSERT `district`(`name`,`city_id`) VALUES('东兰县','319');
INSERT `district`(`name`,`city_id`) VALUES('罗城仫佬族自治县','319');
INSERT `district`(`name`,`city_id`) VALUES('环江毛南族自治县','319');
INSERT `district`(`name`,`city_id`) VALUES('巴马瑶族自治县','319');
INSERT `district`(`name`,`city_id`) VALUES('都安瑶族自治县','319');
INSERT `district`(`name`,`city_id`) VALUES('大化瑶族自治县','319');
INSERT `district`(`name`,`city_id`) VALUES('宜州市','319');


--320	北海市
INSERT `district`(`name`,`city_id`) VALUES('海城区','320');
INSERT `district`(`name`,`city_id`) VALUES('银海区','320');
INSERT `district`(`name`,`city_id`) VALUES('铁山港区','320');
INSERT `district`(`name`,`city_id`) VALUES('合浦县','320');

--*********************************************************西藏************************************************************************
--321	拉萨市
INSERT `district`(`name`,`city_id`) VALUES('城关区','321');
INSERT `district`(`name`,`city_id`) VALUES('林周县','321');
INSERT `district`(`name`,`city_id`) VALUES('当雄县','321');
INSERT `district`(`name`,`city_id`) VALUES('尼木县','321');
INSERT `district`(`name`,`city_id`) VALUES('曲水县','321');
INSERT `district`(`name`,`city_id`) VALUES('堆龙德庆县','321');
INSERT `district`(`name`,`city_id`) VALUES('达孜县','321');
INSERT `district`(`name`,`city_id`) VALUES('墨竹工卡县','321');

--322	日喀则地区
INSERT `district`(`name`,`city_id`) VALUES('日喀则市','322');
INSERT `district`(`name`,`city_id`) VALUES('南木林县','322');
INSERT `district`(`name`,`city_id`) VALUES('江孜县','322');
INSERT `district`(`name`,`city_id`) VALUES('定日县','322');
INSERT `district`(`name`,`city_id`) VALUES('萨迦县','322');
INSERT `district`(`name`,`city_id`) VALUES('拉孜县','322');
INSERT `district`(`name`,`city_id`) VALUES('昂仁县','322');
INSERT `district`(`name`,`city_id`) VALUES('谢通门县','322');
INSERT `district`(`name`,`city_id`) VALUES('白朗县','322');
INSERT `district`(`name`,`city_id`) VALUES('仁布县','322');
INSERT `district`(`name`,`city_id`) VALUES('康马县','322');
INSERT `district`(`name`,`city_id`) VALUES('定结县','322');
INSERT `district`(`name`,`city_id`) VALUES('仲巴县','322');
INSERT `district`(`name`,`city_id`) VALUES('亚东县','322');
INSERT `district`(`name`,`city_id`) VALUES('吉隆县','322');
INSERT `district`(`name`,`city_id`) VALUES('聂拉木县','322');
INSERT `district`(`name`,`city_id`) VALUES('萨嘎县','322');
INSERT `district`(`name`,`city_id`) VALUES('岗巴县','322');

--323	山南地区
INSERT `district`(`name`,`city_id`) VALUES('乃东县','323');
INSERT `district`(`name`,`city_id`) VALUES('扎囊县','323');
INSERT `district`(`name`,`city_id`) VALUES('贡嘎县','323');
INSERT `district`(`name`,`city_id`) VALUES('桑日县','323');
INSERT `district`(`name`,`city_id`) VALUES('琼结县','323');
INSERT `district`(`name`,`city_id`) VALUES('曲松县','323');
INSERT `district`(`name`,`city_id`) VALUES('措美县','323');
INSERT `district`(`name`,`city_id`) VALUES('洛扎县','323');
INSERT `district`(`name`,`city_id`) VALUES('加查县','323');
INSERT `district`(`name`,`city_id`) VALUES('隆子县','323');
INSERT `district`(`name`,`city_id`) VALUES('错那县','323');
INSERT `district`(`name`,`city_id`) VALUES('浪卡子县','323');

--324	林芝地区
INSERT `district`(`name`,`city_id`) VALUES('林芝县','324');
INSERT `district`(`name`,`city_id`) VALUES('工布江达县','324');
INSERT `district`(`name`,`city_id`) VALUES('米林县','324');
INSERT `district`(`name`,`city_id`) VALUES('墨脱县','324');
INSERT `district`(`name`,`city_id`) VALUES('波密县','324');
INSERT `district`(`name`,`city_id`) VALUES('察隅县','324');
INSERT `district`(`name`,`city_id`) VALUES('朗县','324');


--325	昌都地区
INSERT `district`(`name`,`city_id`) VALUES('昌都县','325');
INSERT `district`(`name`,`city_id`) VALUES('江达县','325');
INSERT `district`(`name`,`city_id`) VALUES('贡觉县','325');
INSERT `district`(`name`,`city_id`) VALUES('类乌齐县','325');
INSERT `district`(`name`,`city_id`) VALUES('丁青县','325');
INSERT `district`(`name`,`city_id`) VALUES('察雅县','325');
INSERT `district`(`name`,`city_id`) VALUES('八宿县','325');
INSERT `district`(`name`,`city_id`) VALUES('左贡县','325');
INSERT `district`(`name`,`city_id`) VALUES('芒康县','325');
INSERT `district`(`name`,`city_id`) VALUES('洛隆县','325');
INSERT `district`(`name`,`city_id`) VALUES('边坝县','325');


--326	那曲地区
INSERT `district`(`name`,`city_id`) VALUES('那曲县','326');
INSERT `district`(`name`,`city_id`) VALUES('嘉黎县','326');
INSERT `district`(`name`,`city_id`) VALUES('比如县','326');
INSERT `district`(`name`,`city_id`) VALUES('聂荣县','326');
INSERT `district`(`name`,`city_id`) VALUES('安多县','326');
INSERT `district`(`name`,`city_id`) VALUES('申扎县','326');
INSERT `district`(`name`,`city_id`) VALUES('索县','326');
INSERT `district`(`name`,`city_id`) VALUES('班戈县','326');
INSERT `district`(`name`,`city_id`) VALUES('巴青县','326');
INSERT `district`(`name`,`city_id`) VALUES('尼玛县','326');


--327	阿里地区
INSERT `district`(`name`,`city_id`) VALUES('普兰县','327');
INSERT `district`(`name`,`city_id`) VALUES('札达县','327');
INSERT `district`(`name`,`city_id`) VALUES('噶尔县','327');
INSERT `district`(`name`,`city_id`) VALUES('日土县','327');
INSERT `district`(`name`,`city_id`) VALUES('革吉县','327');
INSERT `district`(`name`,`city_id`) VALUES('改则县','327');
INSERT `district`(`name`,`city_id`) VALUES('措勤县','327');

--*********************************************************宁夏************************************************************************
--328	银川市
INSERT `district`(`name`,`city_id`) VALUES('兴庆区','328');
INSERT `district`(`name`,`city_id`) VALUES('西夏区','328');
INSERT `district`(`name`,`city_id`) VALUES('金凤区','328');
INSERT `district`(`name`,`city_id`) VALUES('永宁县','328');
INSERT `district`(`name`,`city_id`) VALUES('贺兰县','328');
INSERT `district`(`name`,`city_id`) VALUES('灵武市','328');

--329	石嘴山市
INSERT `district`(`name`,`city_id`) VALUES('大武口区','329');
INSERT `district`(`name`,`city_id`) VALUES('惠农区','329');
INSERT `district`(`name`,`city_id`) VALUES('平罗县','329');


--330	吴忠市
INSERT `district`(`name`,`city_id`) VALUES('利通区','330');
INSERT `district`(`name`,`city_id`) VALUES('盐池县','330');
INSERT `district`(`name`,`city_id`) VALUES('同心县','330');
INSERT `district`(`name`,`city_id`) VALUES('青铜峡市','330');


--331	固原市
INSERT `district`(`name`,`city_id`) VALUES('原州区','331');
INSERT `district`(`name`,`city_id`) VALUES('西吉县','331');
INSERT `district`(`name`,`city_id`) VALUES('隆德县','331');
INSERT `district`(`name`,`city_id`) VALUES('泾源县','331');
INSERT `district`(`name`,`city_id`) VALUES('彭阳县','331');


--332	中卫市
INSERT `district`(`name`,`city_id`) VALUES('沙坡头区','332');
INSERT `district`(`name`,`city_id`) VALUES('中宁县','332');
INSERT `district`(`name`,`city_id`) VALUES('海原县','332');

--*********************************************************新 疆************************************************************************
--333	塔城地区
INSERT `district`(`name`,`city_id`) VALUES('塔城市','333');
INSERT `district`(`name`,`city_id`) VALUES('乌苏市','333');
INSERT `district`(`name`,`city_id`) VALUES('额敏县','333');
INSERT `district`(`name`,`city_id`) VALUES('沙湾县','333');
INSERT `district`(`name`,`city_id`) VALUES('托里县','333');
INSERT `district`(`name`,`city_id`) VALUES('裕民县','333');
INSERT `district`(`name`,`city_id`) VALUES('和布克赛尔蒙古自治县','333');

--334	哈密地区
INSERT `district`(`name`,`city_id`) VALUES('哈密市','334');
INSERT `district`(`name`,`city_id`) VALUES('巴里坤哈萨克自治县','334');
INSERT `district`(`name`,`city_id`) VALUES('伊吾县','334');

--335	和田地区
INSERT `district`(`name`,`city_id`) VALUES('和田市','335');
INSERT `district`(`name`,`city_id`) VALUES('和田县','335');
INSERT `district`(`name`,`city_id`) VALUES('墨玉县','335');
INSERT `district`(`name`,`city_id`) VALUES('皮山县','335');
INSERT `district`(`name`,`city_id`) VALUES('洛浦县','335');
INSERT `district`(`name`,`city_id`) VALUES('策勒县','335');
INSERT `district`(`name`,`city_id`) VALUES('于田县','335');
INSERT `district`(`name`,`city_id`) VALUES('民丰县','335');


--336	阿勒泰地区
INSERT `district`(`name`,`city_id`) VALUES('阿勒泰市','336');
INSERT `district`(`name`,`city_id`) VALUES('布尔津县','336');
INSERT `district`(`name`,`city_id`) VALUES('富蕴县','336');
INSERT `district`(`name`,`city_id`) VALUES('福海县','336');
INSERT `district`(`name`,`city_id`) VALUES('哈巴河县','336');
INSERT `district`(`name`,`city_id`) VALUES('青河县','336');
INSERT `district`(`name`,`city_id`) VALUES('吉木乃县','336');


--337	克孜勒苏柯尔克孜自治州
INSERT `district`(`name`,`city_id`) VALUES('阿图什市','337');
INSERT `district`(`name`,`city_id`) VALUES('阿克陶县','337');
INSERT `district`(`name`,`city_id`) VALUES('阿合奇县','337');
INSERT `district`(`name`,`city_id`) VALUES('乌恰县','337');


--338	博尔塔拉蒙古自治州
INSERT `district`(`name`,`city_id`) VALUES('博乐市','338');
INSERT `district`(`name`,`city_id`) VALUES('精河县','338');
INSERT `district`(`name`,`city_id`) VALUES('温泉县','338');


--339	克拉玛依市
INSERT `district`(`name`,`city_id`) VALUES('独山子区','339');
INSERT `district`(`name`,`city_id`) VALUES('克拉玛依区','339');
INSERT `district`(`name`,`city_id`) VALUES('白碱滩区','339');
INSERT `district`(`name`,`city_id`) VALUES('乌尔禾区','339');

--340	乌鲁木齐市
INSERT `district`(`name`,`city_id`) VALUES('天山区','340');
INSERT `district`(`name`,`city_id`) VALUES('沙依巴克区','340');
INSERT `district`(`name`,`city_id`) VALUES('新市区','340');
INSERT `district`(`name`,`city_id`) VALUES('水磨沟区','340');
INSERT `district`(`name`,`city_id`) VALUES('头屯河区','340');
INSERT `district`(`name`,`city_id`) VALUES('达坂城区','340');
INSERT `district`(`name`,`city_id`) VALUES('米东区','340');
INSERT `district`(`name`,`city_id`) VALUES('乌鲁木齐县','340');

--341	石河子市(无);
--342	昌吉回族自治州
INSERT `district`(`name`,`city_id`) VALUES('昌吉市','342');
INSERT `district`(`name`,`city_id`) VALUES('阜康市','342');
INSERT `district`(`name`,`city_id`) VALUES('呼图壁县','342');
INSERT `district`(`name`,`city_id`) VALUES('玛纳斯县','342');
INSERT `district`(`name`,`city_id`) VALUES('奇台县','342');
INSERT `district`(`name`,`city_id`) VALUES('吉木萨尔县','342');
INSERT `district`(`name`,`city_id`) VALUES('木垒哈萨克自治县','342');

--343	五家渠市(无);
--344	吐鲁番地区
INSERT `district`(`name`,`city_id`) VALUES('吐鲁番市','344');
INSERT `district`(`name`,`city_id`) VALUES('鄯善县','344');
INSERT `district`(`name`,`city_id`) VALUES('托克逊县','344');

--345	巴音郭楞蒙古自治州
INSERT `district`(`name`,`city_id`) VALUES('库尔勒市','345');
INSERT `district`(`name`,`city_id`) VALUES('轮台县','345');
INSERT `district`(`name`,`city_id`) VALUES('尉犁县','345');
INSERT `district`(`name`,`city_id`) VALUES('若羌县','345');
INSERT `district`(`name`,`city_id`) VALUES('且末县','345');
INSERT `district`(`name`,`city_id`) VALUES('焉耆回族自治县','345');
INSERT `district`(`name`,`city_id`) VALUES('和静县','345');
INSERT `district`(`name`,`city_id`) VALUES('和硕县','345');
INSERT `district`(`name`,`city_id`) VALUES('博湖县','345');


--346	阿克苏地区
INSERT `district`(`name`,`city_id`) VALUES('阿克苏市','346');
INSERT `district`(`name`,`city_id`) VALUES('温宿县','346');
INSERT `district`(`name`,`city_id`) VALUES('库车县','346');
INSERT `district`(`name`,`city_id`) VALUES('沙雅县','346');
INSERT `district`(`name`,`city_id`) VALUES('新和县','346');
INSERT `district`(`name`,`city_id`) VALUES('拜城县','346');
INSERT `district`(`name`,`city_id`) VALUES('乌什县','346');
INSERT `district`(`name`,`city_id`) VALUES('阿瓦提县','346');
INSERT `district`(`name`,`city_id`) VALUES('柯坪县','346');

--347	阿拉尔市(无);
--348	喀什地区
INSERT `district`(`name`,`city_id`) VALUES('喀什市','348');
INSERT `district`(`name`,`city_id`) VALUES('疏附县','348');
INSERT `district`(`name`,`city_id`) VALUES('疏勒县','348');
INSERT `district`(`name`,`city_id`) VALUES('英吉沙县','348');
INSERT `district`(`name`,`city_id`) VALUES('泽普县','348');
INSERT `district`(`name`,`city_id`) VALUES('莎车县','348');
INSERT `district`(`name`,`city_id`) VALUES('叶城县','348');
INSERT `district`(`name`,`city_id`) VALUES('麦盖提县','348');
INSERT `district`(`name`,`city_id`) VALUES('岳普湖县','348');
INSERT `district`(`name`,`city_id`) VALUES('伽师县','348');
INSERT `district`(`name`,`city_id`) VALUES('巴楚县','348');
INSERT `district`(`name`,`city_id`) VALUES('塔什库尔干塔吉克自治县','348');

--349	图木舒克市(无);
--350	伊犁哈萨克自治州
INSERT `district`(`name`,`city_id`) VALUES('伊宁市','350');
INSERT `district`(`name`,`city_id`) VALUES('奎屯市','350');
INSERT `district`(`name`,`city_id`) VALUES('伊宁县','350');
INSERT `district`(`name`,`city_id`) VALUES('察布查尔锡伯自治县','350');
INSERT `district`(`name`,`city_id`) VALUES('霍城县','350');
INSERT `district`(`name`,`city_id`) VALUES('巩留县','350');
INSERT `district`(`name`,`city_id`) VALUES('新源县','350');
INSERT `district`(`name`,`city_id`) VALUES('昭苏县','350');
INSERT `district`(`name`,`city_id`) VALUES('特克斯县','350');
INSERT `district`(`name`,`city_id`) VALUES('尼勒克县','350');


--*********************************************************内蒙古************************************************************************
--351	呼伦贝尔市
INSERT `district`(`name`,`city_id`) VALUES('海拉尔区','351');
INSERT `district`(`name`,`city_id`) VALUES('阿荣旗','351');
INSERT `district`(`name`,`city_id`) VALUES('莫力达瓦达斡尔族自治旗','351');
INSERT `district`(`name`,`city_id`) VALUES('鄂伦春自治旗','351');
INSERT `district`(`name`,`city_id`) VALUES('鄂温克族自治旗','351');
INSERT `district`(`name`,`city_id`) VALUES('陈巴尔虎旗','351');
INSERT `district`(`name`,`city_id`) VALUES('新巴尔虎左旗','351');
INSERT `district`(`name`,`city_id`) VALUES('新巴尔虎右旗','351');
INSERT `district`(`name`,`city_id`) VALUES('满洲里市','351');
INSERT `district`(`name`,`city_id`) VALUES('牙克石市','351');
INSERT `district`(`name`,`city_id`) VALUES('扎兰屯市','351');
INSERT `district`(`name`,`city_id`) VALUES('额尔古纳市','351');
INSERT `district`(`name`,`city_id`) VALUES('根河市','351');

--352	呼和浩特市
INSERT `district`(`name`,`city_id`) VALUES('新城区','352');
INSERT `district`(`name`,`city_id`) VALUES('回民区','352');
INSERT `district`(`name`,`city_id`) VALUES('玉泉区','352');
INSERT `district`(`name`,`city_id`) VALUES('赛罕区','352');
INSERT `district`(`name`,`city_id`) VALUES('土默特左旗','352');
INSERT `district`(`name`,`city_id`) VALUES('托克托县','352');
INSERT `district`(`name`,`city_id`) VALUES('和林格尔县','352');
INSERT `district`(`name`,`city_id`) VALUES('清水河县','352');
INSERT `district`(`name`,`city_id`) VALUES('武川县','352');

--353	包头市
INSERT `district`(`name`,`city_id`) VALUES('东河区','353');
INSERT `district`(`name`,`city_id`) VALUES('昆都仑区','353');
INSERT `district`(`name`,`city_id`) VALUES('青山区','353');
INSERT `district`(`name`,`city_id`) VALUES('石拐区','353');
INSERT `district`(`name`,`city_id`) VALUES('白云鄂博矿区','353');
INSERT `district`(`name`,`city_id`) VALUES('九原区','353');
INSERT `district`(`name`,`city_id`) VALUES('土默特右旗','353');
INSERT `district`(`name`,`city_id`) VALUES('固阳县','353');
INSERT `district`(`name`,`city_id`) VALUES('达尔罕茂明安联合旗','353');

--354	乌海市
INSERT `district`(`name`,`city_id`) VALUES('海勃湾区','354');
INSERT `district`(`name`,`city_id`) VALUES('海南区','354');
INSERT `district`(`name`,`city_id`) VALUES('乌达区','354');

--355	乌兰察布市
INSERT `district`(`name`,`city_id`) VALUES('集宁区','355');
INSERT `district`(`name`,`city_id`) VALUES('卓资县','355');
INSERT `district`(`name`,`city_id`) VALUES('化德县','355');
INSERT `district`(`name`,`city_id`) VALUES('商都县','355');
INSERT `district`(`name`,`city_id`) VALUES('兴和县','355');
INSERT `district`(`name`,`city_id`) VALUES('凉城县','355');
INSERT `district`(`name`,`city_id`) VALUES('察哈尔右翼前旗','355');
INSERT `district`(`name`,`city_id`) VALUES('察哈尔右翼中旗','355');
INSERT `district`(`name`,`city_id`) VALUES('察哈尔右翼后旗','355');
INSERT `district`(`name`,`city_id`) VALUES('四子王旗','355');
INSERT `district`(`name`,`city_id`) VALUES('丰镇市','355');

--356	通辽市
INSERT `district`(`name`,`city_id`) VALUES('科尔沁区','356');
INSERT `district`(`name`,`city_id`) VALUES('科尔沁左翼中旗','356');
INSERT `district`(`name`,`city_id`) VALUES('科尔沁左翼后旗','356');
INSERT `district`(`name`,`city_id`) VALUES('开鲁县','356');
INSERT `district`(`name`,`city_id`) VALUES('库伦旗','356');
INSERT `district`(`name`,`city_id`) VALUES('奈曼旗','356');
INSERT `district`(`name`,`city_id`) VALUES('扎鲁特旗','356');
INSERT `district`(`name`,`city_id`) VALUES('霍林郭勒市','356');

--357	赤峰市
INSERT `district`(`name`,`city_id`) VALUES('红山区','357');
INSERT `district`(`name`,`city_id`) VALUES('元宝山区','357');
INSERT `district`(`name`,`city_id`) VALUES('松山区','357');
INSERT `district`(`name`,`city_id`) VALUES('阿鲁科尔沁旗','357');
INSERT `district`(`name`,`city_id`) VALUES('巴林左旗','357');
INSERT `district`(`name`,`city_id`) VALUES('巴林右旗','357');
INSERT `district`(`name`,`city_id`) VALUES('林西县','357');
INSERT `district`(`name`,`city_id`) VALUES('克什克腾旗','357');
INSERT `district`(`name`,`city_id`) VALUES('翁牛特旗','357');
INSERT `district`(`name`,`city_id`) VALUES('喀喇沁旗','357');
INSERT `district`(`name`,`city_id`) VALUES('宁城县','357');
INSERT `district`(`name`,`city_id`) VALUES('敖汉旗','357');


--358	鄂尔多斯市
INSERT `district`(`name`,`city_id`) VALUES('东胜区','358');
INSERT `district`(`name`,`city_id`) VALUES('达拉特旗','358');
INSERT `district`(`name`,`city_id`) VALUES('准格尔旗','358');
INSERT `district`(`name`,`city_id`) VALUES('鄂托克前旗','358');
INSERT `district`(`name`,`city_id`) VALUES('鄂托克旗','358');
INSERT `district`(`name`,`city_id`) VALUES('杭锦旗','358');
INSERT `district`(`name`,`city_id`) VALUES('乌审旗','358');
INSERT `district`(`name`,`city_id`) VALUES('伊金霍洛旗','358');

--359	巴彦淖尔市
INSERT `district`(`name`,`city_id`) VALUES('临河区','359');
INSERT `district`(`name`,`city_id`) VALUES('五原县','359');
INSERT `district`(`name`,`city_id`) VALUES('磴口县','359');
INSERT `district`(`name`,`city_id`) VALUES('乌拉特前旗','359');
INSERT `district`(`name`,`city_id`) VALUES('乌拉特中旗','359');
INSERT `district`(`name`,`city_id`) VALUES('乌拉特后旗','359');
INSERT `district`(`name`,`city_id`) VALUES('杭锦后旗','359');

--360	锡林郭勒盟
INSERT `district`(`name`,`city_id`) VALUES('二连浩特市','360');
INSERT `district`(`name`,`city_id`) VALUES('锡林浩特市','360');
INSERT `district`(`name`,`city_id`) VALUES('阿巴嘎旗','360');
INSERT `district`(`name`,`city_id`) VALUES('苏尼特左旗','360');
INSERT `district`(`name`,`city_id`) VALUES('苏尼特右旗','360');
INSERT `district`(`name`,`city_id`) VALUES('东乌珠穆沁旗','360');
INSERT `district`(`name`,`city_id`) VALUES('西乌珠穆沁旗','360');
INSERT `district`(`name`,`city_id`) VALUES('太仆寺旗','360');
INSERT `district`(`name`,`city_id`) VALUES('镶黄旗','360');
INSERT `district`(`name`,`city_id`) VALUES('正镶白旗','360');
INSERT `district`(`name`,`city_id`) VALUES('正蓝旗','360');
INSERT `district`(`name`,`city_id`) VALUES('多伦县','360');

--361	兴安盟
INSERT `district`(`name`,`city_id`) VALUES('乌兰浩特市','361');
INSERT `district`(`name`,`city_id`) VALUES('阿尔山市','361');
INSERT `district`(`name`,`city_id`) VALUES('科尔沁右翼前旗','361');
INSERT `district`(`name`,`city_id`) VALUES('科尔沁右翼中旗','361');
INSERT `district`(`name`,`city_id`) VALUES('扎赉特旗','361');
INSERT `district`(`name`,`city_id`) VALUES('突泉县','361');

--362	阿拉善盟
INSERT `district`(`name`,`city_id`) VALUES('阿拉善左旗','362');
INSERT `district`(`name`,`city_id`) VALUES('阿拉善右旗','362');
INSERT `district`(`name`,`city_id`) VALUES('额济纳旗','362');

--*********************************************************港澳台************************************************************************
--363	台北市(无);
--364	高雄市(无);
--365	基隆市(无);
--366	台中市(无);
--367	台南市(无);
--368	新竹市(无);
--369	嘉义市(无);
--370	澳门特别行政区(无);

