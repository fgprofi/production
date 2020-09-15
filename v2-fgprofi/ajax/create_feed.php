<?
ob_start();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
//$APPLICATION->SetTitle("");

CModule::IncludeModule("iblock");

$data = $_REQUEST;
// echo"<pre>";
// print_r($data);
// echo "</pre>";
$arIblocks = array('TYPE_F' => 7, 'TYPE_U' => 8);
$iblock = $arIblocks[$data['user_type']];

$users = CIBlockElement::getList(array('NAME'=>'ASC'), array('IBLOCK_ID' => $iblock));
$ar_users        = explode(',',$_REQUEST['users']);
$ar_result  = array();

while($res = $users->GetNextElement())
{
	if(in_array($res->GetFields()['ID'], $ar_users)){
		$ar_result[$res->GetFields()['ID']]['fields'] = $res->GetFields();
		$ar_result[$res->GetFields()['ID']]['props'] = $res->GetProperties();
	}
}
$a=0;
$arHeads = array();
$exceptions = array('MARGE_ID','CUSTOMER_CARD_ACTIVITY','HIDDEN_VIEW','CONFIRMED','USER_ID','PHOTO');
foreach($ar_result as $k=>$v){
	if($a == 0){
		foreach($v['props'] as $val){
			if(!in_array($val['CODE'],$exceptions))
			$arHeads[$val['CODE']] = $val['NAME'];
		}
	}
	$a++;
}

//$heads = array(
//	7 => array(
//		'SURNAME' => 'Фамилия',
//		'FIRST_NAME' => 'Имя',
//		'MIDDLENAME' => 'Отчество',
//		'DATE_OF_BIRTH' => 'Отчество',
//		'EDUCATION' => 'Отчество',
//		'LANGUAGE_SKILLS' => 'Отчество',
//		'REGION_OF_RESIDENCE' => 'Отчество',
//		'LOCALITY' => 'Отчество',
//		'PHONE' => 'Отчество',
//		'EMAIL' => 'Отчество',
//		'SOC' => 'Отчество',
//		'PLACE_OF_WORK' => 'Отчество',
//		'POSITION' => 'Отчество',
//		'KIND_OF_ACTIVITY' => 'Отчество',
//		'FINANCIAL_LITERACY_COMPETENCIES' => 'Отчество'
//	),
//	8 => array(
//		'FIRST_NAME' => 'Название',
//	),
//);

$str  = implode(";",$arHeads)."\n";
foreach($ar_result as $key=>$val)
{
	foreach($arHeads as $kH => $kV){
		if(isset($val['props'][$kH]['LINK_IBLOCK_ID']) && !empty($val['props'][$kH]['LINK_IBLOCK_ID']) && !empty($val['props'][$kH]['VALUE'])){
			$vArName = array();
			$arIbRes = array();
			$obRes = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>$val['props'][$kH]['LINK_IBLOCK_ID']),false,false,array('ID','NAME'));
			while($r = $obRes->getNext()){
				$arIbRes[$r['ID']] = $r['NAME'];
			}
			// echo"<pre>";
			// print_r($arIbRes);
			// echo "</pre>";
			if(is_array($val['props'][$kH]['VALUE'])){
				foreach($val['props'][$kH]['VALUE'] as $kHid)
				{
					
					$arIbRes[$kHid] = str_replace(array("\r\n", "\r", "\n"), '', $arIbRes[$kHid]);
					$arIbRes[$kHid] = htmlspecialchars_decode($arIbRes[$kHid]);
					$arIbRes[$kHid] = str_replace("&amp;amp;quot;","\"",$arIbRes[$kHid]);
					$arIbRes[$kHid] = str_replace("&amp;quot;","\"",$arIbRes[$kHid]);
					$arIbRes[$kHid] = str_replace("&quot;","\"",$arIbRes[$kHid]);
					$vArName[] = str_replace(";",",",$arIbRes[$kHid]);
				}
				$myArray[$kH] = implode(', ',$vArName);
			}else{
				
				$arIbRes[$val['props'][$kH]['VALUE']] = str_replace(array("\r\n", "\r", "\n"), '', $arIbRes[$val['props'][$kH]['VALUE']]);
				$arIbRes[$val['props'][$kH]['VALUE']] = htmlspecialchars_decode($arIbRes[$val['props'][$kH]['VALUE']]);
				$arIbRes[$val['props'][$kH]['VALUE']] = str_replace("&amp;amp;quot;","\"",$arIbRes[$val['props'][$kH]['VALUE']]);
				$arIbRes[$val['props'][$kH]['VALUE']] = str_replace("&amp;quot;","\"",$arIbRes[$val['props'][$kH]['VALUE']]);
				$arIbRes[$val['props'][$kH]['VALUE']] = str_replace("&quot;","\"",$arIbRes[$val['props'][$kH]['VALUE']]);
				$myArray[$kH] = str_replace(";",",",$arIbRes[$val['props'][$kH]['VALUE']]);
			}
			
		}else{
			if(is_array($val['props'][$kH]['VALUE'])){
				$arNn = array();
				foreach($val['props'][$kH]['VALUE'] as $nN){
					$nN = str_replace(array("\r\n", "\r", "\n"), '', $nN);
					$nN = htmlspecialchars_decode($nN);
					$nN = str_replace("&amp;amp;quot;","\"",$nN);
					$nN = str_replace("&amp;quot;","\"",$nN);
					$nN = str_replace("&quot;","\"",$nN);
					$arNn[] = str_replace(";",",",$nN);
				}
				$myArray[$kH] = implode(', ',$arNn);
			}else{
				
				$val['props'][$kH]['VALUE'] = str_replace(array("\r\n", "\r", "\n"), '', $val['props'][$kH]['VALUE']);
				$val['props'][$kH]['VALUE'] = htmlspecialchars_decode($val['props'][$kH]['VALUE']);
				$val['props'][$kH]['VALUE'] = str_replace("&amp;amp;quot;","\"",$val['props'][$kH]['VALUE']);
				$val['props'][$kH]['VALUE'] = str_replace("&amp;quot;","\"",$val['props'][$kH]['VALUE']);
				$val['props'][$kH]['VALUE'] = str_replace("&quot;","\"",$val['props'][$kH]['VALUE']);
				$myArray[$kH] = str_replace(";",",",str_replace(array('\"',),'',$val['props'][$kH]['VALUE']));
			}
		}

	}

	$str.= implode(';', $myArray)."\n";
}

// echo"<pre>";
// print_r($str);
// echo "</pre>";
// die();
header("Content-type: csv/plain");
header("Content-Disposition: attachment; filename=users_by_filter_".date("d_m_Y").".csv");
ob_end_clean();
echo $str;
exit;

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>