from pathlib import Path
import json,hashlib,base64
r=Path('electronics457');p={'format':'gangsteronline-update-1','php':'8.3','from':['3.0.14-legends-'+str(n).zfill(2) for n in range(7,15)]+['3.0.15-electronics-01'],'version':'3.0.15-electronics-02','migration':'gangster-private/release-migrations/electronics457.php','notes':['Nieuwe verzameling Elektronica met 19 echte apparaten en lokaal meegeleverde, gecontroleerde foto’s.','Fototoestellen, VHS- en DVD-apparatuur, televisies, computers, laptops, walkmans, discman en hifi. Filteren, zoeken, bezit en vergroting met informatie.','Schatkisten gebruiken de bestaande VC-aankoopbeveiliging, unieke exemplaren, conditiepunten, verkoop en ruil. Prijs en daglimiet instelbaar via Elektronica → Beheer.','WebP-foto’s: gemiddeld 11 KB, maximaal 22 KB. Geen live API-verkeer bij spelen. Per foto bron, auteur en licentie zichtbaar.','DVD en VHS blijven ongewijzigd. Geen verwijdering van bezittingen of reset van spelers.'],'files':[]}
for folder in ['gangster-private','public_html']:
 for f in sorted((r/folder).rglob('*')):
  if f.is_file():
   b=f.read_bytes();p['files'].append({'path':str(f.relative_to(r)),'sha256':hashlib.sha256(b).hexdigest(),'data':base64.b64encode(b).decode()})
b=json.dumps(p,ensure_ascii=False,separators=(',',':')).encode();(r/'update458.json').write_bytes(b);h=hashlib.sha256(b).hexdigest();(r/'update458.sha256').write_text(h+'  update458.json\n');print(json.dumps({'bytes':len(b),'files':len(p['files']),'sha256':h}))
(r/'README.md').write_text('''# VCollector Elektronica · update 457

19 echte elektronicamodellen met lokale WebP-foto’s. Installeer update458.json via het VCollector-updatebeheer, vanaf Legends-versie 07 tot en met 14. Daarna: Verzamelen → Elektronica. Instellingen: Elektronica → Beheer. Directe link: /index.php?el457=catalog.

Prijs standaard: 1000 VC per willekeurig virtueel exemplaar; daglimiet 20. Prijs en verkoop aan/uit zijn instelbaar. Elk model heeft vaste spelpunten; willekeurige conditie verlaagt exemplaarpunten. Punten en klassen zijn redactionele spelwaarden, geen echte taxatie. Jaargegevens worden niet verzonnen.

Foto’s afkomstig van Wikimedia Commons. Per foto staan de exacte bronpagina, auteur, licentie en conversie vermeld in de catalogus. De foto’s behouden hun eigen CC BY, CC BY-SA of publiek-domeinvoorwaarden; de softwarelicentie vervangt deze niet. Alle afbeeldingen zijn verkleind, geconverteerd naar WebP en ontdaan van overbodige metadata. Er zijn geen API-keys nodig en geen live bronaanvragen tijdens spelen.

De update voegt eigen bestanden toe en past uitsluitend negen expliciete bestaande functie-ingangen aan. De migratie controleert functies en alle fotohashes vooraf en registreert runtimebestanden in het bestaande updatehersteljournaal. Bestaande eigenaren, kaarten, films en saldi worden niet gereset. De server/database op hosting zijn niet vanuit deze werkruimte getest.

Validatie: PHP 8.3 WASM, catalogus, filters, outputescaping, bezit, native checkoutquote, adminrechten, CSRF-velden, menuidempotentie en migratie met hashcontroles/runtimebackups. Aankoop gebruikt de bestaande transactie-, receipt- en walletbeveiliging. Controleer na installatie eerst één aankoop met het beheeraccount en daarna verkoop/ruil op de staging-site.
''')
