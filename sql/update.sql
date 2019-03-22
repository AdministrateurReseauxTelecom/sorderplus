------------------------------------
--Extrafields Commande fournisseur--
------------------------------------

INSERT INTO `llx_extrafields` (`name`, `entity`, `elementtype`, `tms`, `label`, `type`, `size`, `fieldunique`, `fieldrequired`, `perms`, `list`, `pos`, `alwayseditable`, `param`, `ishidden`, `fieldcomputed`, `fielddefault`, `langs`) VALUES
('f_stk', 1, 'commande_fournisseur', '2018-04-23 08:21:35', 'Stock de destination', 'sellist', '', 0, 0, NULL, 0, 0, 1, 'a:1:{s:7:"options";a:1:{s:30:"entrepot:label:rowid::statut=1";N;}}', 0, NULL, NULL, NULL);


ALTER TABLE `llx_commande_fournisseur_extrafields` ADD `f_stk` text;


------------------------------------
--Table Release Commande fournisseur--
------------------------------------

CREATE TABLE `llx_commande_fournisseur_release` (
  `rowid` int(11) NOT NULL,
  `fk_commande` int(11) DEFAULT NULL,
  `fk_product` int(11) DEFAULT NULL,
  `fk_commandefourndet` int(11) NOT NULL DEFAULT '0',
  `qty` float DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `datec` datetime DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `tms` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `batch` varchar(30) DEFAULT NULL,
  `eatby` date DEFAULT NULL,
  `sellby` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
