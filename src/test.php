<?php
namespace PaperAlliance;

require_once "./autoload.php";

$config = new Config();
$config->setAppId('515045632');
$config->setSecretKey('94590b7d267190f27071171b758c2a42');
//todo:测试环境下设置成true,上线请隐藏或者设置成false
$config->setIsFakeCheck(true);
$paperAllianceManager = new PaperAllianceManager($config);

/*$paper = new PaperParams();
$paper->setTitle("测试");
$paper->setAuthor("测试");*/
//$paper->setContent(file_get_contents('./Data/test.txt'));
//$paper->setPaperPath('./Data/test.txt');
/*$paper->setPaperPath('./Data/test.docx');*/
$paper2 = new PaperParams();
$paper2->setTitle("人类普遍认为语言中发音与含义之间的对应关系是任意的");
$paper2->setAuthor("人类");
$paper2->setPaperPath('./Data/0001.doc');
//$paper2->setContent(file_get_contents('./Data/test.txt'));
//$paper2->setPaperPath('./Data/test.txt');
//$paper2->setPaperPath('./Data/test.docx');

$jane_name = "checkpass";
/**************验证论文文件****************/
$res = $paperAllianceManager->validatePaper($paper2,$jane_name);
/**************预支付订单****************/
$res = $paperAllianceManager->preCreateOne($paper2,$jane_name,'2.0|0','background');
$paper_id = $res->getData()['data']['paper_id'];
//$res = $paperAllianceManager->preCreateMulti([$paper,$paper2],$jane_name,'2.0|0','background');

/**************支付订单****************/
$res = $paperAllianceManager->payOrder($res->getData()['data']['pay_id'],'money');//T2012758374089218537

/**************订单状态查询******************/
$res0 = $paperAllianceManager->payInfoStatus($res->getData()['data']['oid']);

/**************订单记录******************/
$res1 = $paperAllianceManager->findCheckRecord($paper_id);//D004218887155246711297

$res2 = $paperAllianceManager->findCheckRecords($paper_id);

$res3 = $paperAllianceManager->reUploadPaper($paper2,$paper_id);

/******************查询用户余额*******************/
//$res = $paperAllianceManager->inquireRestMoney();
var_dump($paper_id,$res,$res0,$res1,$res2,$res3);exit();