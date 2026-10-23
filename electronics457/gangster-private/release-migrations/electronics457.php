<?php
declare(strict_types=1);
(static function(array &$state,string $id):void{
 $root=dirname(__DIR__);require_once $root.'/patch415.php';
 foreach(['vm415Kind','vm415Title','vm415Damage','vm415Page','vm415Details','vc415Art','vc415Dispatch','vc415Menu','co429Catalog','hwChange326','ccMeta262','ppBind333'] as $f)if(!function_exists($f))throw new RuntimeException('Elektronica vereist de bestaande VCollector-verzamelmodule: '.$f);
 $catalog=json_decode(file_get_contents($root.'/electronics457-catalog.json'),true,64,JSON_THROW_ON_ERROR);if(($catalog['format']??'')!=='vcollector-electronics-457'||count($catalog['items']??[])<15)throw new RuntimeException('Elektronicacatalogus is onvolledig.');
 foreach($catalog['items'] as $m){$asset=(string)($m['art']['image']??'');if(!preg_match('~^/assets/electronics457/[a-z0-9-]+\.webp$~D',$asset)||!is_file(dirname($root).'/public_html'.$asset)||!hash_equals($m['art']['sha256'],hash_file('sha256',dirname($root).'/public_html'.$asset)))throw new RuntimeException('Elektronicafoto ontbreekt of wijkt af.');}
 $require="require_once __DIR__.'/electronics457.php'; ";
 $hooks=[
 'vm415Kind'=>"if(func_get_arg(0)==='electro')return 'electro';",
 'vm415Title'=>"if(func_get_arg(0)==='electro')return 'Elektronica';",
 'vm415Damage'=>"if(func_get_arg(0)==='electro')return el457Damage();",
 'vc415Art'=>"if((func_get_arg(0)['model']['kind']??'')==='electro')return el457Art(func_get_arg(0));",
 'vm415Details'=>"if((func_get_arg(0)['kind']??'')==='electro')return el457Details(func_get_arg(0));",
 'vm415Page'=>"if(el457IsRequest(func_get_arg(0),func_get_arg(1)))return el457Page(func_get_arg(0),func_get_arg(1));",
 'co429Catalog'=>"if((\$_GET['kind']??'')==='electro')return el457Page(func_get_arg(0),'catalog');",
 'vc415Dispatch'=>"if(el457Dispatch())return;",
 'vc415Menu'=>"\$html=el457Menu(\$html);"
 ];$plans=[];
 foreach($hooks as $fn=>$extra){$path=(new ReflectionFunction($fn))->getFileName();if(!is_string($path)||realpath(dirname($path))!==realpath($root)||is_link($path)||!is_writable($path))throw new RuntimeException('Onveilig of niet schrijfbaar runtimepad: '.$fn);$name=basename($path);$code=$plans[$name]??file_get_contents($path);$mark='/* electronics457:'.$fn.' */';if(!str_contains($code,$mark))$code=vc415AtStart($code,$fn,$mark.' '.$require.$extra);$plans[$name]=$code;}
 token_get_all(file_get_contents($root.'/electronics457.php'),TOKEN_PARSE);
 vc415Journal($root,array_keys($plans),$state,$id);
 vc415Atomic(function()use($catalog){$j=['phase'=>'local','cursor'=>'','target'=>count($catalog['items']),'paused'=>true,'exhausted'=>false,'price'=>1000,'daily'=>20,'enabled'=>true,'skipped'=>0,'last'=>'Lokale elektronicacatalogus met bronvermelding geïnstalleerd.'];q('INSERT IGNORE INTO go_media415_jobs(kind,state) VALUES(?,?)',['electro',enc($j)]);$max=(int)(one("SELECT COALESCE(MAX(seq),0) n FROM go_media415_titles WHERE kind='electro'")['n']??0);foreach($catalog['items'] as $m){if(one("SELECT model FROM go_media415_titles WHERE kind='electro' AND model=?",[$m['id']]))continue;q('INSERT INTO go_media415_titles(kind,model,seq,title,data,created,mbid) VALUES(?,?,?,?,?,?,?)',['electro',$m['id'],++$max,$m['title'],enc($m),now(),null]);}});
 vc415WritePlans($root,$plans);
})( $state,$id );
