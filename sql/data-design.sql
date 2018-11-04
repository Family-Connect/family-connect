ALTER DATABASE foo CHARACTER SET uft8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS task;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS family;

-- create family table

CREATE TABLE family (
	-- primary key
	familyId BINARY(16) NOT NULL,
	-- attributes
	familyName VARCHAR(64) NOT NULL,
	-- prevent duplicate data
	UNIQUE(familyName),
	-- primary key
	PRIMARY KEY(familyId)
);

CREATE TABLE user (
	userId BINARY(16) NOT NULL,
	userFamilyId BINARY(16) NOT NULL,
	userActivationToken VARCHAR (128),
	userAvatar VARCHAR (128),
	userDisplayName VARCHAR (128) NOT NULL,
	userEmail VARCHAR (128) NOT NULL,
	userHash CHAR (97) NOT NULL,
	userPhoneNumber VARCHAR (10),
	userPrivilege VARCHAR (250) NOT NULL,
	userName VARCHAR (96) NOT NULL,

	UNIQUE(userDisplayName),
	UNIQUE(userEmail),

	INDEX(userFamilyId),

	FOREIGN KEY(userFamilyId) REFERENCES family(familyId),

	PRIMARY KEY(userId)
);

CREATE TABLE event(
	eventId BINARY(16) NOT NULL,
	eventFamilyId BINARY(16) NOT NULL,
	eventUserId BINARY(16) NOT NULL,
	eventContent VARCHAR(255),
	eventStartDate DATETIME(6) NOT NULL,
	eventEndDate DATETIME(6),
	eventName CHAR(30) NOT NULL,

	INDEX(eventFamilyId),
	INDEX(eventUserId),

	FOREIGN KEY(eventFamilyId) REFERENCES family(familyId),

	FOREIGN KEY(eventUserId) REFERENCES user(userId),

	PRIMARY KEY(eventId)
);

CREATE TABLE task(
	taskId BINARY(16) NOT NULL,
	taskEventId BINARY(16),
	taskUserId BINARY(16),
	taskDueDate DATETIME(6) NOT NULL,
	taskDescription VARCHAR(35),
	taskName VARCHAR(30) NOT NULL,

	INDEX(taskEventId),
	INDEX(taskUserId),

	FOREIGN KEY(taskEventId) REFERENCES event(eventId),

	FOREIGN KEY(taskUserId) REFERENCES user(userId),

	PRIMARY KEY(taskId)
);

CREATE TABLE comments (
	commentId BINARY (16) NOT NULL,
	commentEventId BINARY (16),
	commentTaskId BINARY (16),
	commentUserId BINARY (16) NOT NULL,
	commentDate DATETIME (6) NOT NULL,
	commentContent VARCHAR (855),

	PRIMARY KEY(commentId),

	index(commentEventId),
	FOREIGN KEY(commentEventId) REFERENCES event(eventId),

	index(commentTaskId),
	FOREIGN KEY(commentTaskId) REFERENCES task(taskId),

	index(commentUserId),
	FOREIGN KEY(commentUserId) REFERENCES comment(commentId),
);

