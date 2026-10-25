# VCollector Legends assets

Compact WebP card illustrations and a versioned import manifest for VCollector Legends. Public collection assets only: no accounts, credentials or player data.

The collection has 1,000 numbered card definitions. **402 finished illustrations** are published, consecutively numbered 0001–0402.

- 0001–0212: existing clean collection, including the clean replacements for the first 22 cards.
- 0213–0262: 50 silver anime cards.
- 0263–0312: 50 gold cartoon cards.
- 0313–0342: 30 gold hero editions of existing creatures, with recognizable heroic items and exactly +10 HP compared with each base card. Base card IDs are retained in their production metadata.

The preceding 100 cards (0213–0312) have 100 unique creature names and 200 distinct ability names. Existing HP, damage, energy costs and rarity were retained. Their metadata is in `vcollector-legends/production/`; the complete catalogue is in `vcollector-legends/catalog.json` (gzip-base64 envelope with SHA-256 of the decompressed JSON).

Only finished illustrations appear in the manifest. Publishing does not generate missing artwork. Website catalogue changes must be installed alongside the artwork so displayed ability names match the images. The dedicated owner-only PHP update supplied separately includes the 100 illustrations and catalogue changes, with backups and rollback on installation errors.

The 30 hero editions keep their base abilities, attack damage, energy costs and rarity. Cards 0001–0312 remain unchanged. For matching website names and HP, install `vcollector-heldenkaarten574.json` through the admin website updater, then use the existing importer as usual. The public repository contains no installer access key.


## Royal editions 0343–0402

30 King editions (0343–0372) and 30 corresponding Queen editions (0373–0402). Original creature identities are retained, with visibly distinct male/female heads, proportions and poses. The approved style uses clear outlines, restrained gold borders and simple royal accessories. Each pair keeps the same base name, attacks, damage, energy costs and rarity, and gains exactly 10 HP over its base card. Existing artwork 0001–0342 and all other catalogue records remain unchanged.

All 60 royal WebP illustrations are 512 × 768 pixels and at most 100 kB each. Import artwork through the existing VCollector admin card downloader. Apply the separately supplied `vcollector-king-queen576.json` through the admin website updater for matching names and HP. No hosting login or standalone PHP upload is needed.
