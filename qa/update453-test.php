<?php
declare(strict_types=1);
function check453(bool $ok,string $message):void{if(!$ok)throw new RuntimeException($message);$GLOBALS['checks']++;}
$GLOBALS['checks']=0;$p=json_decode(file_get_contents(__DIR__.'/../installatie/update453.json'),true,64,JSON_THROW_ON_ERROR);
check453($p['version']==='3.0.14-legends-11','Version');
$root=sys_get_temp_dir().'/vc453-'.bin2hex(random_bytes(6));mkdir($root);
foreach($p['files']as$f){$b=base64_decode($f['data'],true);check453(is_string($b)&&hash('sha256',$b)===$f['sha256'],'Payload checksum '.$f['path']);if(str_ends_with($f['path'],'.php'))token_get_all($b,TOKEN_PARSE);$path=$root.'/'.$f['path'];if(!is_dir(dirname($path)))mkdir(dirname($path),0700,true);file_put_contents($path,$b);}
require $root.'/gangster-private/branding453.php';
function user(){return $GLOBALS['viewer'];}
$_SERVER['SCRIPT_FILENAME']='/public/index.php';$_GET=[];$GLOBALS['viewer']=null;
$bar='<nav class="extra"><a href="/index.php?vc413=referrals">Verdien VC met referrals</a><a href="/index.php?vc413=market">Euro-markt</a><a href="/index.php?vc413=profile">Mijn PayPal-profiel</a><a href="/index.php?vc413=wiki">VCollector-wiki</a></nav>';
$header='<header><a class="brand" href="/index.php">VCOLLECTOR <strong>MARKET</strong></a><a href="/account.php">Inloggen</a><a href="/account.php?mode=register">Aanmelden</a></header>';
$html='<!doctype html><html><head><link rel="icon" href="old.ico"><link rel="stylesheet" href="theme.css"></head><body>'.$bar.$header.'<main>Sportkaarten<p>Euro-markt informatie</p></main><footer><a href="/index.php?vc413=wiki">Wiki</a></footer></body></html>';
$new=vc453Filter($html);
check453(!str_contains($new,'class="extra"'),'Guest feature bar removed');
check453(str_contains($new,'Inloggen')&&str_contains($new,'Aanmelden'),'Public account links preserved');
check453(str_contains($new,'Sportkaarten')&&str_contains($new,'Euro-markt informatie'),'Page contents preserved');
check453(str_contains($new,'<footer><a href="/index.php?vc413=wiki">Wiki</a></footer>'),'Public wiki footer preserved');
check453(str_contains($new,'class="vc453-logo"'),'Shared logo');
check453(str_contains($new,'theme.css')&&!str_contains($new,'old.ico'),'Theme kept, old favicon replaced');
check453(str_contains($new,'brand-icon-png')&&str_contains($new,'brand-icon-ico')&&str_contains($new,'brand-icon&'),'Favicon formats');
check453(vc453Filter($new)===$new,'Idempotent');
$GLOBALS['viewer']=['id'=>'player'];$signed=vc453Filter($html);check453(str_contains($signed,'class="extra"'),'Signed-in features preserved');check453(str_contains($signed,'vc453-logo'),'Signed-in public logo');
$_SERVER['SCRIPT_FILENAME']='/public/admin.php';$admin=vc453Filter($html);check453(str_contains($admin,$header),'Admin logo untouched');check453(str_contains($admin,'brand-icon-png'),'Admin favicon');
$_SERVER['SCRIPT_FILENAME']='/public/account.php';$GLOBALS['viewer']=null;check453(str_contains(vc453Filter($html),'vc453-logo'),'Login-page logo');
check453(vc453Filter('{"message":"<html>"}')==='{"message":"<html>"}','JSON unmodified');
check453(vc453Filter('<svg></svg>')==='<svg></svg>','SVG unmodified');
$other='<nav><a href="/index.php">Home</a><a href="/account.php">Inloggen</a></nav>';check453(vc453GuestMenu($other)===$other,'Other navigation retained');
$similar=str_replace('vc413=wiki','tab=sportcards',$bar);check453(vc453GuestMenu($similar)===$similar,'Only exact obsolete feature bar removed');
$png=file_get_contents($root.'/public_html/assets/vcollector453-icon.png');check453(substr($png,0,8)==="\x89PNG\r\n\x1a\n",'PNG signature');$size=getimagesizefromstring($png);check453($size&&$size[0]===64&&$size[1]===64,'PNG dimensions');
$ico=file_get_contents($root.'/public_html/assets/vcollector453-icon.ico');check453(substr($ico,0,6)==="\0\0\1\0\1\0",'ICO header');
echo "PASS ".$GLOBALS['checks']." checks: payloads, PHP syntax, shared logo, guest-only menu removal, unchanged admin branding, favicon formats and non-HTML preservation.\n";
