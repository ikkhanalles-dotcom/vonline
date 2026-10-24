# VCollector Legends assets

Compact WebP card illustrations and a versioned import manifest for VCollector Legends. Public collection assets only: no accounts, credentials or player data.

The collection has 1,000 numbered card definitions. **312 finished illustrations** are published, consecutively numbered 0001–0312.

- 0001–0212: existing clean collection, including the clean replacements for the first 22 cards.
- 0213–0262: 50 silver anime cards.
- 0263–0312: 50 gold cartoon cards.

The latest 100 cards have 100 unique creature names and 200 distinct ability names. Existing HP, damage, energy costs and rarity were retained. Their metadata is in `vcollector-legends/production/`; the complete catalogue is in `vcollector-legends/catalog.json` (gzip-base64 envelope with SHA-256 of the decompressed JSON).

Only finished illustrations appear in the manifest. Publishing does not generate missing artwork. Website catalogue changes must be installed alongside the artwork so displayed ability names match the images. The dedicated owner-only PHP update supplied separately includes the 100 illustrations and catalogue changes, with backups and rollback on installation errors.
