<?php
$arUrlRewrite=array (
  13 => 
  array (
    'CONDITION' => '#^/personal/legal_faces/([0-9_]+)/edit/\\?{0,1}(.*)$#',
    'RULE' => 'ID=$1',
    'ID' => 'bitrix:news.detail',
    'PATH' => '/personal/legal_faces/edit.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/personal/fiz_faces/([0-9_]+)/edit/\\?{0,1}(.*)$#',
    'RULE' => 'ID=$1',
    'ID' => 'bitrix:news.detail',
    'PATH' => '/personal/fiz_faces/edit.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/information/links/([a-zA-Z0-9_]+)/\\?{0,1}(.*)$#',
    'RULE' => '/information/links/index.php?SECTION_CODE=\\1&\\2',
    'ID' => '',
    'PATH' => '',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/personal/legal_faces/([0-9_]+)/\\?{0,1}(.*)$#',
    'RULE' => 'ID=$1',
    'ID' => 'bitrix:news.detail',
    'PATH' => '/personal/legal_faces/detail.php',
    'SORT' => 100,
  ),
  17 => 
  array (
    'CONDITION' => '#^/personal/fiz_faces/([0-9_]+)/\\?{0,1}(.*)$#',
    'RULE' => 'ID=$1',
    'ID' => 'bitrix:news.detail',
    'PATH' => '/personal/fiz_faces/detail.php',
    'SORT' => 100,
  ),
  23 => 
  array (
    'CONDITION' => '#^/admin/subscribe/mailer/send/([0-9]+)/#',
    'RULE' => 'load_id=$1',
    'ID' => '',
    'PATH' => '/admin/subscribe/mailer/send/index.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  26 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  18 => 
  array (
    'CONDITION' => '#^/news/([a-zA-Z0-9_-]+)/\\?{0,1}(.*)$#',
    'RULE' => 'ELEMENT_CODE=$1',
    'ID' => '',
    'PATH' => '/news/detail.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/board/([a-zA-Z0-9_]+)/\\?{0,1}(.*)$#',
    'RULE' => '/board/index.php?SECTION_CODE=\\1&\\2',
    'ID' => '',
    'PATH' => '',
    'SORT' => 100,
  ),
  25 => 
  array (
    'CONDITION' => '#^/personal/auth_profile/([0-9]+)/#',
    'RULE' => 'event=auth_profile&profile_id=$1',
    'ID' => '',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  27 => 
  array (
    'CONDITION' => '#^/unsubscribe/([a-zA-Z0-9_]+)/#',
    'RULE' => 'CHECK=$1',
    'ID' => '',
    'PATH' => '/personal/unsubscribe.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/auth/([a-zA-Z0-9_]+)/#',
    'RULE' => 'face=$1',
    'PATH' => '/auth/index.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/freg/([a-zA-Z0-9_]+)/#',
    'RULE' => 'face=$1',
    'PATH' => '/freg/index.php',
    'SORT' => 100,
  ),
  20 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  21 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/nationalnews/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/nationalnews/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/job/vacancy/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/job/vacancy/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/job/resume/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/job/resume/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/themes/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/themes/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/forum/#',
    'RULE' => '',
    'ID' => 'bitrix:forum',
    'PATH' => '/forum/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/photo/#',
    'RULE' => '',
    'ID' => 'bitrix:photogallery_user',
    'PATH' => '/photo/index.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/blogs/#',
    'RULE' => '',
    'ID' => 'bitrix:blog',
    'PATH' => '/blogs/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
  22 => 
  array (
    'CONDITION' => '#^/club/#',
    'RULE' => '',
    'ID' => 'bitrix:socialnetwork',
    'PATH' => '/club/index.php',
    'SORT' => 100,
  ),
  24 => '1oad_id',
);
