import json,base64,re,hashlib,pathlib
p=json.loads(pathlib.Path('installatie/update453.json').read_text())
p['files']=[f for f in p['files'] if not f['path'].endswith('.ico')]
p['version']='3.0.14-legends-12'
p['from']=list(dict.fromkeys(p['from']+['3.0.14-legends-11']))
p['notes'].insert(0,'Herstelt de pakketcontrole: gebruikt SVG en PNG voor het favicon, bestandstypen die de bestaande updater al accepteert. Geen uitbreiding van de toegestane paden.')
for f in p['files']:
 if not f['path'].endswith(('.php','.js','.css')):continue
 s=base64.b64decode(f['data']).decode()
 if f['path'].endswith(('static452.php','tcg444-download.php')):
  s=s.replace("'brand-icon-ico'=>['vcollector453-icon.ico','image/x-icon'],",'').replace("'brand-icon-ico'=>['vcollector453-icon.ico','image/x-icon','453'],",'')
  if f['path'].endswith('static452.php'):s=s.replace("'453'","'454'")
 if f['path'].endswith('branding453.php'):
  s=re.sub(r'<link rel="shortcut icon"[^>]*>','',s).replace('&v=453','&v=454')
 assert 'brand-icon-ico' not in s,f['path']
 b=s.encode();f['data']=base64.b64encode(b).decode();f['sha256']=hashlib.sha256(b).hexdigest()
b=json.dumps(p,ensure_ascii=False,separators=(',',':')).encode()
pathlib.Path('installatie/update454.json').write_bytes(b)
digest=hashlib.sha256(b).hexdigest()
pathlib.Path('installatie/update454.sha256').write_text(digest+'  update454.json\n')
print('SHA-256 '+digest)
