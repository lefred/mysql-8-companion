CREATE TABLE IF NOT EXISTS `%%VAR_PREFIX%%m8c_versions` (
  `id` int(11) NOT NULL,
  `version` char(5) DEFAULT NULL,
  `eol` date DEFAULT NULL,
  `latest_version` char(7) DEFAULT NULL,
  `latest_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) %%VAR_CHARACTER%%

