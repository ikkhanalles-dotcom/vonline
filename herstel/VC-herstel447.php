<?php
declare(strict_types=1);

// First screen deliberately runs without game routing or access to private data.
if(($_SERVER['REQUEST_METHOD']??'GET')==='GET'){
 header('Content-Type:text/html; charset=utf-8');header('Cache-Control:no-store');header('X-Robots-Tag:noindex, nofollow');
 echo '<!doctype html><html lang="nl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>VCollector herstel</title><style>body{background:#101725;color:#e5edf6;font:16px system-ui;margin:0}main{max-width:700px;margin:8vh auto;padding:24px}section{padding:24px;background:#182438;border-radius:12px}h1{font-size:24px}button{background:#e4bd70;border:0;border-radius:8px;padding:12px 18px;font:inherit;cursor:pointer}.ok{color:#88ddb1}a{color:#e4bd70}</style></head><body><main><section><h1>VCollector herstel 447</h1><p class="ok" role="status">Herstelbestand geladen. Het PHP-bestand wordt uitgevoerd.</p><p>Er is nog niets gewijzigd. Controleer nu je beheerderssessie om daarna een privéback-up te maken en de kaartdownload te herstellen.</p><form method="post"><input type="hidden" name="herstel446" value="open"><button>Beheerderssessie controleren</button></form><p>Log vooraf in bij VCollector. Alleen hoofdbeheer kan bestanden wijzigen.</p><a href="/account.php">Naar inloggen</a></section></main></body></html>';
 exit;
}

// Owner-authenticated repair after the standalone first screen.
$vr446Base=ob_get_level();$vr446Candidate=[];
$vr446Bridge=__DIR__.'/update-center.php';
if(is_file($vr446Bridge)&&!is_link($vr446Bridge)){
 foreach(token_get_all(file_get_contents($vr446Bridge))as$vr446Token){if(is_array($vr446Token)&&$vr446Token[0]===T_CONSTANT_ENCAPSED_STRING){$vr446Path=substr($vr446Token[1],1,-1);if(str_starts_with($vr446Path,'/')&&str_ends_with($vr446Path,'/public_html/update-center.php'))$vr446Candidate[]=dirname(dirname($vr446Path)).'/gangster-private/bootstrap.php';}}
}
$vr446Candidate[]=dirname(__DIR__).'/gangster-private/bootstrap.php';$vr446Bootstrap=null;
foreach(array_unique($vr446Candidate)as$vr446Path)if(is_file($vr446Path)&&!is_link($vr446Path)){$vr446Bootstrap=realpath($vr446Path);break;}
if(!$vr446Bootstrap){http_response_code(503);header('Content-Type:text/plain; charset=utf-8');exit('Herstelbestand geladen. VCollector-applicatie niet gevonden. Plaats dit PHP-bestand naast update-center.php in de openbare map van vcollector.nl. Er is niets gewijzigd.');}
// Match the supported updater entry point only while loading the normal session/auth code.
$vr447Server=[];foreach(['SCRIPT_FILENAME','SCRIPT_NAME','PHP_SELF','REQUEST_URI']as$vr447Name)$vr447Server[$vr447Name]=$_SERVER[$vr447Name]??null;
$vr447Entry=dirname(dirname($vr446Bootstrap)).'/public_html/update-center.php';
$_SERVER['SCRIPT_FILENAME']=$vr447Entry;$_SERVER['SCRIPT_NAME']='/update-center.php';$_SERVER['PHP_SELF']='/update-center.php';$_SERVER['REQUEST_URI']='/update-center.php';
if(!defined('VC_STANDALONE400'))define('VC_STANDALONE400',true);
$GLOBALS['vr447AuthReady']=false;
register_shutdown_function(static function()use($vr446Base):void{
 if(!empty($GLOBALS['vr447AuthReady']))return;
 while(ob_get_level()>$vr446Base)ob_end_clean();
 if(!headers_sent()){header_remove('Location');http_response_code(503);header('Content-Type:text/plain; charset=utf-8');}
 echo 'Herstelbestand geladen. De VCollector-opstartcode heeft de sessiecontrole voortijdig gestopt. Er zijn geen bestanden gewijzigd. Geef deze exacte melding door.';
});
try{require_once $vr446Bootstrap;$vr446User=role(true);if(empty($GLOBALS['cfg']['vc405_central']))throw new RuntimeException('Dit herstelbestand is alleen voor VCollector.');$vr446Root=dirname((new ReflectionFunction('db'))->getFileName());}
catch(Throwable $vr446Error){$GLOBALS['vr447AuthReady']=true;while(ob_get_level()>$vr446Base)ob_end_clean();http_response_code(403);header('Content-Type:text/plain; charset=utf-8');exit('Herstelbestand geladen. Log eerst in als VCollector-hoofdbeheerder en open dit bestand opnieuw. Er is niets gewijzigd.');}
$GLOBALS['vr447AuthReady']=true;foreach($vr447Server as$vr447Name=>$vr447Value){if($vr447Value===null)unset($_SERVER[$vr447Name]);else $_SERVER[$vr447Name]=$vr447Value;}
while(ob_get_level()>$vr446Base)ob_end_clean();
if(!headers_sent())header_remove('Location');
header('Content-Type: text/html; charset=utf-8');header('Cache-Control: no-store');header('X-Robots-Tag: noindex, nofollow');header('X-Content-Type-Options: nosniff');

function vr446Patch(string $old):string{
 token_get_all($old,TOKEN_PARSE);
 if(!preg_match('/function\s+tc444Tick\s*\(/',$old)||!preg_match('/function\s+tc444Install\s*\(/',$old))throw new RuntimeException('Dit downloadbestand wordt niet herkend; er is niets gewijzigd.');
 if(str_contains($old,'/* vr446:dependency */'))return $old;
 if(!preg_match('/\bdeclare\s*\(\s*strict_types\s*=\s*1\s*\)\s*;/',$old,$m,PREG_OFFSET_CAPTURE))throw new RuntimeException('De PHP-bestandskop wordt niet herkend.');
 $at=$m[0][1]+strlen($m[0][0]);$s=substr_replace($old,"\n/* vr446:dependency */ require_once __DIR__.'/tcg443.php';\n",$at,0);token_get_all($s,TOKEN_PARSE);return $s;
}
function vr446Write(string $target,string $bytes,int $mode):void{
 if(is_link($target)||!is_file($target))throw new RuntimeException('Het hersteldoel ontbreekt of is onveilig.');
 $tmp=tempnam(dirname($target),'.vr446-');if(!$tmp)throw new RuntimeException('Tijdelijk herstelbestand maken mislukt.');
 try{if(file_put_contents($tmp,$bytes,LOCK_EX)!==strlen($bytes)||!chmod($tmp,$mode)||!rename($tmp,$target))throw new RuntimeException('Opslaan mislukt. Controleer de bestandsrechten.');if(function_exists('opcache_invalidate'))opcache_invalidate($target,true);}finally{if(is_file($tmp))unlink($tmp);}
 if(!hash_equals(hash('sha256',$bytes),hash_file('sha256',$target)))throw new RuntimeException('Controle van het opgeslagen bestand mislukt.');
}
function vr446Backup(string $root,string $id):array{
 if(!preg_match('/^[a-f0-9]{32}$/D',$id))throw new RuntimeException('Ongeldig back-upnummer.');$root=realpath($root);if(!$root)throw new RuntimeException('Applicatiemap ontbreekt.');
 $target=$root.'/tcg444-download.php';$cards=$root.'/tcg443.php';foreach([$target,$cards]as$f)if(is_link($f)||!is_file($f)||!is_readable($f))throw new RuntimeException('Een kaartbestand ontbreekt. Er is niets gewijzigd.');
 $old=file_get_contents($target);if(!is_string($old)||strlen($old)>2000000)throw new RuntimeException('Downloadbestand kon niet veilig worden gelezen.');
 $cardCode=file_get_contents($cards);token_get_all($cardCode,TOKEN_PARSE);if(!preg_match('/function\s+tc443Config\s*\(/',$cardCode))throw new RuntimeException('De kaartconfiguratiefunctie ontbreekt ook in het kaartbestand. Automatisch herstel afgebroken.');
 $new=vr446Patch($old);$dir=$root.'/tcg446-herstel';if(is_link($dir)||(!is_dir($dir)&&!mkdir($dir,0700)))throw new RuntimeException('Privéback-upmap maken mislukt.');if(!chmod($dir,0700))throw new RuntimeException('Privéback-uprechten instellen mislukt.');
 $record=['format'=>'vcollector-repair446-backup-1','id'=>$id,'created'=>time(),'target'=>'tcg444-download.php','old_sha'=>hash('sha256',$old),'new_sha'=>hash('sha256',$new),'mode'=>fileperms($target)&0777,'data'=>base64_encode($old)];$raw=json_encode($record,JSON_THROW_ON_ERROR|JSON_UNESCAPED_SLASHES);
 $file=$dir.'/'.$id.'.json';$stream=fopen($file,'xb');if(!$stream)throw new RuntimeException('Privéback-upbestand maken mislukt.');try{if(!chmod($file,0600)||fwrite($stream,$raw)!==strlen($raw))throw new RuntimeException('Back-up opslaan mislukt.');}finally{fclose($stream);}
 if(!hash_equals(hash('sha256',$raw),hash_file('sha256',$file)))throw new RuntimeException('Back-upcontrole mislukt.');return ['id'=>$id,'sha256'=>hash('sha256',$raw),'changed'=>$old!==$new];
}
function vr446Restore(string $root,array $plan):array{
 $id=$plan['id']??'';if(!is_string($id)||!preg_match('/^[a-f0-9]{32}$/D',$id))throw new RuntimeException('Maak eerst een nieuwe back-up.');$dir=$root.'/tcg446-herstel';$file=$dir.'/'.$id.'.json';if(is_link($dir)||is_link($file)||!is_file($file)||!hash_equals((string)($plan['sha256']??''),hash_file('sha256',$file)))throw new RuntimeException('De back-upcontrole klopt niet; er is niets gewijzigd.');
 $r=json_decode(file_get_contents($file),true,16,JSON_THROW_ON_ERROR);$old=base64_decode($r['data']??'',true);if(($r['format']??'')!=='vcollector-repair446-backup-1'||($r['target']??'')!=='tcg444-download.php'||!is_string($old)||!hash_equals($r['old_sha'],hash('sha256',$old)))throw new RuntimeException('Ongeldige herstelback-up.');
 $new=vr446Patch($old);if(!hash_equals($r['new_sha'],hash('sha256',$new)))throw new RuntimeException('De herstelcontrole klopt niet.');$target=$root.'/tcg444-download.php';if(is_link($target)||!is_file($target)||!in_array(hash_file('sha256',$target),[$r['old_sha'],$r['new_sha']],true))throw new RuntimeException('Het bestand is sinds de back-up gewijzigd. Maak eerst een nieuwe back-up.');
 vr446Write($target,$new,(int)$r['mode']);return ['id'=>$id,'sha256'=>$r['new_sha'],'changed'=>$old!==$new];
}


$vr446Message='Herstelbestand geladen. Je bent herkend als hoofdbeheerder.';$vr446Error='';$vr446Done=false;
if(($_SERVER['REQUEST_METHOD']??'GET')==='POST'&&($_POST['herstel446']??'')!=='open'){
 try{csrf();$vr446Lock=fopen($vr446Root.'/tcg446-herstel.lock','c');if(!$vr446Lock||!flock($vr446Lock,LOCK_EX|LOCK_NB))throw new RuntimeException('Een herstelactie is al bezig. Probeer opnieuw.');
 try{$vr446Action=$_POST['herstel446']??'';
 if($vr446Action==='backup'){$vr446Plan=vr446Backup($vr446Root,bin2hex(random_bytes(16)));$_SESSION['vr446-plan']=$vr446Plan;$vr446Message='Controle geslaagd. Privéback-up opgeslagen en gecontroleerd. Er is nog niets aan de kaartmodule gewijzigd. Klik nu op Herstel uitvoeren.';}
 elseif($vr446Action==='repair'){$vr446Result=vr446Restore($vr446Root,$_SESSION['vr446-plan']??[]);try{require_once $vr446Root.'/tcg443.php';if(!function_exists('tc443Config'))throw new RuntimeException('Functie ontbreekt na herstel.');}catch(Throwable $e){throw new RuntimeException('Bestand hersteld, maar de functiecontrole kon niet worden afgerond. De privéback-up is bewaard.');}$vr446Message='Herstel geslaagd. De downloadmodule laadt nu zelf tc443Config(). De bestandscontrole is geslaagd. Collecties, saldi, instellingen en downloadvoortgang zijn behouden.';$vr446Done=true;$_SESSION['vr446-last']=['id'=>$vr446Result['id'],'sha256'=>$vr446Result['sha256']];unset($_SESSION['vr446-plan']);}
 else throw new RuntimeException('Onbekende herstelactie.');
 }finally{flock($vr446Lock,LOCK_UN);fclose($vr446Lock);}
 }catch(Throwable $e){$vr446Error=$e instanceof PDOException?'Databaseverbinding niet beschikbaar; controleer het hostinglog.':$e->getMessage();}
}
try{$vr446Release=one("SELECT value FROM go_meta WHERE id='admin-release'");}catch(Throwable $e){$vr446Release=null;if($vr446Error==='')$vr446Error='De versienaam kon niet worden gelezen. Controleer de databaseverbinding.';}
?><!doctype html><html lang="nl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>VCollector · Kaartdownloads herstellen</title><style>body{margin:0;background:#101725;color:#e5edf6;font:16px system-ui,sans-serif}main{max-width:780px;margin:5vh auto;padding:24px}section{background:#182438;border:1px solid #34445e;border-radius:14px;padding:22px;margin:16px 0}h1{font-size:24px}h2{font-size:18px}.notice{background:#15372d;padding:16px;border:1px solid #4c9d7c;border-radius:9px}.error{background:#48252c;padding:16px;border:1px solid #d67f85;border-radius:9px}button,a.button{display:inline-block;background:#e4bd70;color:#151c28;border:0;border-radius:8px;padding:12px 16px;font:inherit;font-weight:650;text-decoration:none;cursor:pointer}a{color:#e4bd70}small{color:#a9bdd1}code{overflow-wrap:anywhere}form{margin:16px 0}</style></head><body><main><h1>VCollector · Herstel kaartdownloads 447</h1><p>1. Bestand geladen → 2. Controle en back-up → 3. Herstel → 4. Resultaat</p><p class="notice" role="status"><?=h($vr446Message)?></p><?php if($vr446Error):?><p class="error" role="alert"><?=h($vr446Error)?></p><?php endif;?><section><h2>Huidige situatie</h2><p>Geïnstalleerde versie: <b><?=h($vr446Release['value']??'onbekend')?></b></p><p>Dit herstel past uitsluitend de laadvolgorde van <code>tcg444-download.php</code> aan. De geïnstalleerde versienaam blijft gelijk.</p><p>Een privéback-up wordt bewaard buiten de openbare map. Er worden geen spelers, verzamelobjecten, saldi of database-instellingen gereset.</p><?php if(!$vr446Done):?><form method="post"><input type="hidden" name="csrf" value="<?=h($_SESSION['csrf'])?>"><input type="hidden" name="herstel446" value="backup"><button>1. Controleren en back-up maken</button></form><?php if(isset($_SESSION['vr446-plan'])):?><p>Back-upnummer: <code><?=h($_SESSION['vr446-plan']['id'])?></code></p><form method="post"><input type="hidden" name="csrf" value="<?=h($_SESSION['csrf'])?>"><input type="hidden" name="herstel446" value="repair"><button>2. Herstel uitvoeren</button></form><?php endif;?><?php endif;?></section><?php if($vr446Done):?><section><h2>Herstel voltooid</h2><p>Back-upnummer: <code><?=h($_SESSION['vr446-last']['id'])?></code></p><a class="button" href="/index.php?tc443=admin">Open Kaartenbeheer</a><p>Houd Kaartenbeheer open voor de downloads. Een eerdere fout kan nog in de wachtrijmelding staan totdat een nieuwe poging slaagt.</p><p>Verwijder dit herstelbestand uit de openbare map als het weer werkt.</p></section><?php endif;?><p><a href="/update-center.php">Naar Updatebeheer</a> · <a href="/index.php">Naar VCollector</a></p></main></body></html>
