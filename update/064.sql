ALTER TABLE  `ports` CHANGE  `ifVlan`  `ifVlan` VARCHAR( 16 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE  `ports` CHANGE  `ifTrunk`  `ifTrunk` VARCHAR( 8 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE  `ports` CHANGE  `ifVrf`  `ifVrf` INT( 16 ) NULL DEFAULT NULL;