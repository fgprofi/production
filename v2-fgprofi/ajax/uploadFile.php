<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
function reSaveFile($fileId){
	$fileInfo = CFile::GetFileArray( $fileId );
	//echo "<pre>"; print_r($fileInfo); echo "</pre>";
	if($fileInfo != ""){
		$file = $_SERVER["DOCUMENT_ROOT"].$fileInfo["SRC"];
		$newfile = $_SERVER["DOCUMENT_ROOT"].'/sandbox/mass_reg/'.$fileInfo["ORIGINAL_NAME"];
		if(file_exists($newfile)){
			unlink($newfile);
		}
		if (!copy($file, $newfile)) {
		    echo "не удалось скопировать $file...\n";
		}
	}
	CFile::Delete($fileId);
}

if(isset($_POST["REESTR"])){
	if(is_array($_POST["REESTR"])){
		foreach ($_POST["REESTR"] as  $fileData) {
			reSaveFile($fileData);
		}
	}else{
		reSaveFile($_POST["REESTR"]);
	}
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>