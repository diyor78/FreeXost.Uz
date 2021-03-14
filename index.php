<?php
$title = 'UzDc.Site | Мобильный хостинг сайтов!';
include_once($_SERVER["DOCUMENT_ROOT"]."/inc/head.php");
if (isset($active) == true) {
$ontarif = $connect->prepare("select * from `tarifs_hosting` where `id` = ?");
$ontarif->execute(array($user['id_tarif']));
$ustarif = $ontarif->fetch(PDO::FETCH_LAZY);
// Akkauntni aktivlash
if ($user[test]==1){
    if (isset($_POST['ok']))
{
    $code=val($_POST['code']);
    if ($user[wmr]==$code) {
        $connect->query("update `users` set `test` = '2' where `id` = ".$user['id']."");
        $redsa='';
        header('Location: /');
    }else{
        $redsa='<div class="menu"><center><font color="red">Неверно! Код Подтверждение почта!</font></center></div>';
    }
    
    
}
$oks=$_SESSION['ok'];
if (isset($_POST['else'])) {
$qa1='1';
$qasss=$_SESSION['ok']+$qa1;
$_SESSION['ok'] = $qasss;
if ($oks<=2){
mailto($user->email, 'UzDc.Site| Подтверждение почта!','UzDc.Site | Мобильный хостинг!<br/>Ваш логин: '.$user->login.'<br/>Код Подтверждение: '.$user->wmr.'<br/><br/>С Уважением Администратор UzDc.Site! ', $set['mail']);
$redsa='<div class="menu"><center><font color="gren">На Ваш почта отправлен код Подтверждение!</font></center></div>';
}else{$redsa='<div class="menu"><center><font color="red">Вы много отправиль код Подтверждение на ваш E-Mail!!!</font></center></div>';}}
if ($redsa) echo $redsa;
    echo '<div class="title">Подтверждение почта!</div>';
    echo '<div class="menu"><font color=red>Ваш Почта</font>: <b>'.$user->email.'</b><br/>
    <font color="red">Раздел Восстановление пароля не доступен, пока не будет подтвержден MAIL адрес!</font>
<form method="post">
Код активация [0-9]:<br /><input type="text"  name="code" pattern="^[0-9]{3,7}$"/> <br />
<input class="btn btn-default" type="submit" name="ok" value="Подтвердить" /><input class="btn btn-default" type="submit" name="else" value="Отправить код подтверждение ещё" />
</form></div>';}
echo '<div class="title">Мое меню</div>';
if ($user[activ]==0) {$c1='<font color="red">не активирован!</font> ()';}
if ($user[activ]==1) {$c1='<font color="red">не активирован!</font>'; $c2='Для активации <a href="/pay">пополните</a> баланс на '.($ustarif['price_day'] - $user['money']).' рублей)';}
if ($user[activ]==2) {$c1='<font color="gren">Активен!</font>';}
if ($user[activ]==3) {$c1='<font color="red">отключен!</font>'; $c2='Ваш аккаунт приостановлен из-за недостатка средств на лицевом счете. Подробную информацию по вашему лицевому счету, можно узнать в биллинг-панели. Внимание! В случае неуплаты тарифа более 7 дней, согласно <a href="http://uzdc.site/info/rules/">Правилам Хостинг</a> - ваш аккаунт будет удален автоматически без возможности восстановления данных.</span><br/>Для активации <a href="/pay">пополните</a> баланс на '.($ustarif['price_day'] - $user['money']).' рублей)';}
if ($user[activ]==4) {$c1='<font color="red">блокирован!</font>';}
if (empty($c1)) {$c1='<font color="red">Ошибка :)</font>';}
if(($user['money']>=$ustarif['price_month'] && $user[activ] == 1) || ($user['money']>=$ustarif['price_day'] && $user[activ] == 3 && $ustarif['price_pay'] ==1) || ($user['money']>=$ustarif['price_month'] && $user[activ] == 3 && $ustarif['price_pay'] == 2)){
    $ts='0';
echo '<div class="ok">Аккаунт Обрабатывается! Пожалуйста ждите активатция!</div>';}else{$ts='1';}
echo'<div class="menu">
<b>Здравствуйте</b>, <b>'.filter($user['login']).'</b>!<br/>
<b>Время</b>: <span id="time">'.date('H:i:s',time()).' </span>UTC +5<br/>
<b>Сервер</b>: <b>№1 [РУ]</b> <br/>
<b>Ваш баланс</b>: <b>'.filter($user['money']).' Руб</b> <a href="/pay"><b>[пополнить]</b></a><br/>';
$usm=$user[money];
$tcm=$ustarif['price_day'];
if ($tcm == 0) {$k='9999';}else{
for ($k=0;$tcm <=$usm;$k++){
    $usm=$usm-$tcm;
}
}
if ($k >= 1) {
    $allc = 86400 * $k;
}else{$allc='0';}
if ($user['activ'] == 2) {
echo '<b>Осталось дней</b>: '.order_day(($user['time_work'] + $allc)).' (<b>Активен до</b>: '.vremja(($user['time_work'] + $allc)).')<br/>
'.(order_day($user['time_work'],true) < 0.01 ? '<font color="red"><b>До сброс аккаунт осталось</b>: '.order_day(($user['time_work'] + (84600 * 7))).' дней. </font><br/>' : '').' ';}
echo '<b>Тариф</b>: <b>'.$ustarif['name'].' ('.($ustarif['price_pay'] == 1 ? $ustarif['price_day'].' руб/день' : $ustarif['price_month'].' руб/мес').')</b><br/>
'.($user['activ']==2 ? '<b>Ваш домен: <a href="http://'.filter($user['login']).'.uzdc.site" target="_blank">'.filter($user['login']).'.uzdc.site</a></b><br/>' : '').'
<b>Активность вашего аккаунт:  '.$c1.'</b>
</div>';
if (($c2 && $ts && empty($user['money']>=$ustarif['price_month']) && $ustarif['price_pay'] == 1) || ($c2 && $ts && empty($user['money']>=$ustarif['price_month']) && $ustarif['price_pay'] == 2)) {
echo'<div class="menu"><h1 style="color: red;"><b>Внимание!</b></h1>';
echo '<font color="red">'.$c2.'</font>';
echo '</div>';
}
?>
<?
echo '<div class="title">Услуги</div>';
echo '<div class="menu"><img src="../con/512.png" alt="*" width="16px" height="16px"><a href="/tarifs/hosting"> Виртуальный хостинг [Тарифы] [Смена тариф]</a></div>';
echo '<div id="son" class="title">Связы</div>';
echo '<div class="menu"><img src="../con/telegram.png" alt="*" width="16px" height="16px"><a href="https://t.me/developer_bots"> администратор</a></div>';
echo '<div class="menu"><img src="../con/telegram.png" alt="*" width="16px" height="16px"><a href="https://t.me/uzdc_site"> Телеграм Группа</a></div>';
echo '<div class="menu"><img src="../con/apps.png" alt="*" width="16px" height="16px"><a href="https://uzdc.site/apps/uzdc.site.apk"> Мобильное приложение</a></div>';
echo '<div class="title">Меню Сайта </div>';
if (isset($user) && $user['activ'] == 2){
echo '<div class="menu"><img src="../con/mgr.png" alt="*" width="16px" height="16px"><a href="/authcp"> Управление Сайтом [CP | ISP]</a></div>';
}

echo '<div class="menu"><img src="/con/web.png" alt="*" width="16px" height="16px"><a href="/service"> Сервисы [2]</div>';
echo '<div class="menu"><img src="/con/chat.png" alt="*" width="16px" height="16px"><a href="/user/chat"> Мастер Чат </a>['.$ch.'<font color=red>'.$new_chat.'</font>]</div>';
echo '<div class="menu"><img src="/con/news.png" alt="*" width="16px" height="16px"><a href="/news">  Новости</a> ['.$count_news.''.$new_news.']</div>';
echo '<div class="menu"><img src="/con/admin.png" alt="*" width="16px" height="16px"><a href="/info/support"> Служба поддержки</a></div>';
echo '<div class="menu"><img src="/con/komp.png" alt="*" width="16px" height="16px"><a href="/info/server"> Конфигурация сервера</a></div>';
echo '<div class="menu"><img src="/con/qoida.png" alt="*" width="16px" height="16px"><a href="/info/rules"> Правила хостинга</a></div>';
echo '<div class="menu"><img src="/con/pay.png" alt="*" width="16px" height="16px"><a href="/info/pay"> Способы оплаты</a></div>';
}else{
if (isset($_GET['ref']) && user($_GET['ref'])){
    $_SESSION['ref'] = intval($_GET['ref']);
}
        
echo '<div class="title">Наши преимущества</div><div class="container">
  <img src="https://uzdc.site/style/bek/server_fon.jpg" alt="Notebook" style="width:100%;">
  <div class="content"><h1><font color="white">UzDc.Site Mobile Hosting</font></h1>
✓ Полноценное управление сайтом с телефона!<br/>
✓ Поддержка PHP, ioncube и MySQL, DNS<br/>
✓ Выбор версий PHP для каждого домена<br/>
✓ Доступ по Wap Manager & ISP Manager 5 к вашим сайтам<br/>
✓ Бесплатный SSL сертификат (Let’s Encrypt)<br/>
✓ Создание поддоменов и парковка доменов
  </div>
</div>';
echo '<head><script data-ad-client="ca-pub-6996872273340765" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script></head>';
?>

<?
echo '<div id="son" class="title">связы</div>';
echo '<div class="menu"><img src="../con/telegram.png" alt="*" width="16px" height="16px"><a href="https://t.me/developer_bots"> администратор</a></div>';
echo '<div id="son" class="title">Услуги </div>';
echo '<div class="menu"> <img src="../con/512.png" alt="*" width="16px" height="16px"><a href="/tarifs/hosting"> Виртуальный хостинг [Тарифы]</a></a></div>';
echo '<div class="title">Меню Сайта </div>';
echo '<div class="menu"><img src="../con/news.png" alt="*" width="16px" height="16px"><a href="/news">  Новости</a> ['.$count_news.''.$new_news.']</div>';
echo '<div class="menu"><img src="../con/admin.png" alt="*" width="16px" height="16px"><a href="/info/support"> Служба поддержки</a></div>';
echo '<div class="menu"><img src="/con/komp.png" alt="*" width="16px" height="16px"><a href="/info/server"> Конфигурация сервера</a></div>';
echo '<div class="menu"><img src="../con/qoida.png" alt="*" width="16px" height="16px"><a href="/info/rules"> Правила хостинга</a></div>';
echo '<div class="menu"><img src="../con/pay.png" alt="*" width="16px" height="16px"><a href="/info/pay"> Способы оплаты</a></div>';
}
include_once($_SERVER["DOCUMENT_ROOT"]."/inc/foot.php");
 ?>