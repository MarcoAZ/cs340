DROP TABLE IF EXISTS itemInstance;
DROP TABLE IF EXISTS pCharSkill;
DROP TABLE IF EXISTS playerCharacter;
DROP TABLE IF EXISTS itemClass;
DROP TABLE IF EXISTS characterClass;
DROP TABLE IF EXISTS player;
DROP TABLE IF EXISTS skill;

-- create tables

CREATE TABLE `itemClass` (
	`id` int NOT NULL AUTO_INCREMENT,
	`itemName` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`itemName`)
) ENGINE=InnoDB;

CREATE TABLE `characterClass` (
	`id` int NOT NULL AUTO_INCREMENT,
	`className` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`className`)
) ENGINE=InnoDB;

CREATE TABLE `player` (
	`id` int NOT NULL AUTO_INCREMENT,
	`userName` varChar(255) NOT NULL,
	`email` varChar(255),
	PRIMARY KEY (`id`),
	UNIQUE KEY (`userName`),
	UNIQUE KEY (`email`)
) ENGINE=InnoDB;

CREATE TABLE `skill` (
	`id` int NOT NULL AUTO_INCREMENT,
	`skillName` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`skillName`)
) ENGINE=InnoDB;

CREATE TABLE `playerCharacter` (
	`id` int NOT NULL AUTO_INCREMENT,
	`characterName` varchar(255) NOT NULL,
	`level` tinyint UNSIGNED NOT NULL,
	`health` smallint UNSIGNED NOT NULL,
	`strength` smallint UNSIGNED NOT NULL,
	`playerId` int NOT NULL,
	`classId` int NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`characterName`),
	FOREIGN KEY (`classId`) 
		REFERENCES `characterClass`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (`playerId`) 
		REFERENCES `player`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `itemInstance` (
	`id` int NOT NULL AUTO_INCREMENT,
	`classId` int NOT NULL,
	`owner` int NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`classId`) 
		REFERENCES `itemClass`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (`owner`) 
		REFERENCES `playerCharacter`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `pCharSkill` (
	`pCharId` int NOT NULL,
	`skillId` int NOT NULL,
	PRIMARY KEY (`pCharId`, `skillId`),
	FOREIGN KEY (`pCharId`) 
		REFERENCES `playerCharacter`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (`skillId`) 
		REFERENCES `skill`(`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE	
) ENGINE=InnoDB;

-- populate tables
-- characterClass insert queries

INSERT INTO characterClass (className)
values ("warrior");

INSERT INTO characterClass (className)
values ("sorcerer");

INSERT INTO characterClass (className)
values ("archer");

-- itemClass insert queries

INSERT INTO itemClass (itemName)
values ("SteelShortSword");

INSERT INTO itemClass (itemName)
values ("SteelLongSword");

INSERT INTO itemClass (itemName)
values ("WornBow");

INSERT INTO itemClass (itemName)
values ("SuperbBow");

INSERT INTO itemClass (itemName)
values ("LeatherShield");

INSERT INTO itemClass (itemName)
values ("IronShield");

-- skill insert queries

INSERT INTO skill (skillName)
values ("HealingMagic");

INSERT INTO skill (skillName)
values ("FireMagic");

INSERT INTO skill (skillName)
values ("Stealth");

INSERT INTO skill (skillName)
values ("ArmorRepair");

-- player insert queries

INSERT INTO player (userName, email) 
values ("smartypants", "jsmith@blahblah.com");

INSERT INTO player (userName, email) 
values ("dragonSlayer", "rick321@something.com");

INSERT INTO player (userName, email) 
values ("rogolfoTheBrave", "randomperson@blahblah.com");

-- playerCharacter insert queries

INSERT INTO playerCharacter (characterName, level, health, strength, playerId, classId)
values ("Rognar", 1, 500, 100, 
	(SELECT id FROM player WHERE userName = "rogolfoTheBrave"),
	(SELECT id FROM characterClass WHERE className = "warrior"));

INSERT INTO playerCharacter (characterName, level, health, strength, playerId, classId)
values ("Drognestia", 1, 500, 100,
	(SELECT id FROM player WHERE userName = "smartypants"),
	(SELECT id FROM characterClass WHERE className = "sorcerer"));

INSERT INTO playerCharacter (characterName, level, health, strength, playerId, classId)
values ("Glimbloy", 1, 500, 100,
	(SELECT id FROM player WHERE userName = "dragonSlayer"),
	(SELECT id FROM characterClass WHERE className = "archer"));




