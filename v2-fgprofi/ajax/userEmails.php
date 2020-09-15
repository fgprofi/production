<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (isset($_REQUEST)) {
    $arData = $_REQUEST;
    if (CModule::IncludeModule("iblock") && $arData["select_users"] != "") {
        $dataId = explode(",", $arData["select_users"]);
        $dataUsers = getUsers($dataId);
        //echo "<pre>"; print_r($dataUsers); echo "</pre>";
        $strEmails = "";
        foreach ($dataUsers as $key => $value) {
            if($value["IBLOCK_ID"] == "8"){
                $strEmails .= $value["EMAIL"].";";
            }else{
               $strEmails .= $value["PROPERTY_EMAIL_VALUE"].";"; 
            }
        }
        $strEmails = substr($strEmails,0,-1);
        echo "mailto:".$strEmails;
    }?>
<?
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>