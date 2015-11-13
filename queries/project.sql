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
	FOREIGN KEY (`classId`) REFERENCES `characterClass`(`id`),
	FOREIGN KEY (`playerId`) REFERENCES `player`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `itemInstance` (
	`id` int NOT NULL AUTO_INCREMENT,
	`classId` int NOT NULL,
	`owner` int NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`classId`) REFERENCES `itemClass`(`id`),
	FOREIGN KEY (`owner`) REFERENCES `playerCharacter`(`id`)
) ENGINE=InnoDB;

CREATE TABLE `pCharSkill` (
	`pCharId` int NOT NULL,
	`skillId` int NOT NULL,
	PRIMARY KEY (`pCharId`, `skillId`),
	FOREIGN KEY (`pCharId`) REFERENCES `playerCharacter`(`id`),
	FOREIGN KEY (`skillId`) REFERENCES `skill`(`id`)
) ENGINE=InnoDB;


	