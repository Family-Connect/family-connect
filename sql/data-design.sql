ALTER DATABASE foo CHARACTER SET uft8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS user;

CREATE TABLE user (
	userId BINARY(16) NOT NULL,
	userFamilyId BINARY(16) NOT NULL,
	userActivationToken VARCHAR (128) NOT NULL,
	userAvatar VARCHAR (128) NOT NULL,
	userDisplayName VARCHAR (128) NOT NULL,
	userEmail VARCHAR (128) NOT NULL,
	userHash CHAR (96) NOT NULL,
	userPhoneNumber CHAR (7) NOT NULL,
	userPrivilege VARCHAR (250) NOT NULL,
	userTimeZone CHAR (4) NOT NULL,
	userName VARCHAR (96) NOT NULL
)