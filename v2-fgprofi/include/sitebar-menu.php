<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");?>
<div class="sidebar sitebar_scroll">
    <?
    $directory = $APPLICATION->GetCurDir();
    $sSectionName = "";
    $sPath = $_SERVER["DOCUMENT_ROOT"].$directory.".section.php";
    include($sPath);
    if(!isset($USER_PROP["ID_USER_INFO"])){
        $USER_PROP = needAuth('/freg/', false, true);
    }
    if($_GET["test"] == "1"){
        echo "<pre>"; print_r($USER_PROP); echo "</pre>";
        // global   $USER ;
     // $USER ->Authorize( 230 );
    }
    //pre($USER_PROP);
    //echo "<pre>"; print_r($USER_PROP); echo "</pre>";
    ?>
    <?if($USER_PROP["ID_USER_INFO"] != ""):?>
        <ul class="sidebar__list">
            <li class="sidebar__item">
                <?if($USER_PROP["IBLOCK_ID"] == 8):?>
                    <a class="sidebar__link" href="/personal/legal_faces/<?=$USER_PROP["ID_USER_INFO"]?>/">Мой профиль</a>
                <?else:?>
                    <a class="sidebar__link" href="/personal/fiz_faces/<?=$USER_PROP["ID_USER_INFO"]?>/">Мой профиль</a>
                <?endif;?>
            </li>
        </ul>
    <?endif;?>
    <?/*<div class="sidebar__name"><?echo $sSectionName;?></div>*/?>
    <?if(isset($txt) && count($txt)>0):?>
        <ul class="sidebar__list required_fields_check">
            <? foreach ($txt as $group):
                echo $group;
            endforeach; ?>
        </ul>
    <?endif;?>
    <ul class="sidebar__list">
        <?if(isAdministrator()):?>
            <li class="sidebar__item">
                <a class="sidebar__link" href="/admin/">Пользователи</a>
            </li>
            <li class="sidebar__item f_need_moderation">
                <a class="sidebar__link" href="/admin/queries_f/">Запросы физ.лица</a>
            </li>
            <li class="sidebar__item u_need_moderation">
                <a class="sidebar__link" href="/admin/queries_u/">Запросы юр.лица</a>
            </li>
            <li class="sidebar__item">
                <a class="sidebar__link" href="/admin/report/">Отчет</a>
            </li>
            <li class="sidebar__item">
                <a class="sidebar__link" href="/admin/report/mailing/">Отчеты по опросам</a>
            </li>
            <li class="sidebar__item">
                <a class="sidebar__link" href="/admin/report/questions/">Отчеты по вопросам</a>
            </li>
        <?endif;?>
        <?/*if(!isAdministrator()):?>
            <li class="sidebar__item">
                <a class="sidebar__link drop-login__menu-item_feedback" href="#">Обратная связь</a>
            </li>
        <?endif;*/?>
        <li class="sidebar__item">
            <a class="sidebar__link" href="/about/faq/">Частые вопросы</a>
        </li>
        <?if(isset($USER_PROP["PROOF_MINFIN"]) && $USER_PROP["PROOF_MINFIN"] == 23):?>
            <li class="sidebar__item">
                <a class="sidebar__link" href="/personal/communication/">Сообщество</a>
            </li>
        <?endif;?>
        <li class="sidebar__item li_count_message">
            <a class="sidebar__link" href="/support/message/">Уведомления</a>
        </li>
        <li class="sidebar__item">
            <a class="sidebar__link" href="/support/">Сообщения</a>
        </li>
        <?if(isAdministrator()):?>
            <li class="sidebar__item">
                <div class="sidebar__link sidebar__link-info">Рассылка</div>
                <div class="sidebar__tab-content">
                    <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/">Мои рассылки</a>
                    <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/audience/">Аудитории</a>
                    <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/planner/">Планировщик</a>
                    <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/template/">Мои шаблоны</a>
                    <a class="sidebar__link sidebar__link-tab" href="/admin/subscribe/mailer/history/">Архив рассылок</a>
                </div>
            </li>
        <?endif;?>
        <li class="sidebar__item">
            <a class="sidebar__link logout_href" href="#">Выход</a>
        </li>
    </ul>
</div>
<script>
    $(document).ready(function(){
        var directory = "<?=$directory?>";
        $(".sidebar__list li a").each(function(){
            var href = $(this).attr("href");
            if(href == directory){
                $(this).parents("li").addClass("active");
                if($(this).hasClass("sidebar__link-tab")){
                    $(this).addClass("active");
                    $(this).parents(".sidebar__tab-content").css("display", "block");
                }
            }
        });
    });
</script>
<?//require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");?>