-- characterClass insert queries

INSERT INTO characterClass (className)
values ("warrior");

INSERT INTO characterClass (className)
values ("sorcerer");

INSERT INTO characterClass (className)
values ("archer");

-- player insert queries

INSERT INTO player (userName, email) 
values ("smartypants", "jsmith@blahblah.com");

INSERT INTO player (userName, email) 
values ("dragonSlayer", "rick321@something.com");

INSERT INTO player (userName, email) 
values ("rogolfoTheBrave", "randomperson@blahblah.com");

-- playerCharacter insert queries

INSERT INTO playerCharacter (characterName, level, health, strength, playerId, classId)
values ("rognar", 1, 500, 100, 
	(SELECT id FROM player WHERE userName = "rogolfoTheBrave"),
	(SELECT id FROM characterClass WHERE className = "warrior"));
