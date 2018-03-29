--DDL for CRSFF Database
--Note that SQLite will allow NULL pks without the NOT NULL constraint
PRAGMA foreign_keys = ON;
CREATE TABLE Source (
	source_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL,
	place_of_publication TEXT,
	year INTEGER,
	original_year INTEGER,
	edition TEXT,
	language TEXT NOT NULL,
	searchable BOOLEAN
);

CREATE TABLE Section (
	section_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	source_id INTEGER NOT NULL,
	title TEXT NOT NULL,
	page_start TEXT,
	page_end TEXT,
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Author (
	author_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	first_name TEXT,
	last_name TEXT
);
CREATE TABLE Editor (
	editor_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	first_name TEXT,
	last_name TEXT
);
CREATE TABLE Translator (
	translator_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	first_name TEXT,
	last_name TEXT
);
CREATE TABLE Publisher (
	publisher_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL
);
CREATE TABLE Source_keywords (
	source_id INTEGER NOT NULL,
	keyword TEXT NOT NULL,
	PRIMARY KEY (source_id, keyword),
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);
CREATE TABLE Section_keywords (
	section_id INTEGER NOT NULL,
	keyword TEXT NOT NULL,
	PRIMARY KEY (section_id, keyword),
	FOREIGN KEY (section_id) REFERENCES Section(section_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Authors_source (
	source_id INTEGER NOT NULL,
	author_id INTEGER NOT NULL,
	PRIMARY KEY (source_id, author_id),
	FOREIGN KEY (source_id) REFERENCES Source (source_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
	FOREIGN KEY (author_id) REFERENCES Author (author_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);
CREATE TABLE Edits_source (
	source_id INTEGER NOT NULL,
	editor_id INTEGER NOT NULL,
	PRIMARY KEY (source_id, editor_id)
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	FOREIGN KEY (editor_id) REFERENCES Editor(editor_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Translates_source (
	source_id INTEGER NOT NULL,
	translator_id INTEGER NOT NULL,
	PRIMARY KEY (source_id, translator_id),
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	FOREIGN KEY (translator_id) REFERENCES Translator(translator_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Publishes_source (
	source_id INTEGER NOT NULL,
	publisher_id INTEGER NOT NULL,
	PRIMARY KEY (source_id, publisher_id),
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	FOREIGN KEY (publisher_id) REFERENCES Publisher(publisher_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Authors_section (
	section_id INTEGER NOT NULL,
	author_id INTEGER NOT NULL,
	PRIMARY KEY (author_id, section_id),
	FOREIGN KEY (author_id) REFERENCES Author (author_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	FOREIGN KEY (section_id) REFERENCES Section (section_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Edits_section (
	section_id INTEGER NOT NULL,
	editor_id INTEGER NOT NULL,
	PRIMARY KEY (section_id, editor_id),
	FOREIGN KEY (section_id) REFERENCES Section (section_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	FOREIGN KEY (editor_id) REFERENCES Editor (editor_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Translates_section (
	section_id INTEGER NOT NULL,
	translator_id INTEGER NOT NULL,
	PRIMARY KEY (section_id, translator_id),
	FOREIGN KEY (section_id) REFERENCES Section (section_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
	FOREIGN KEY (translator_id) REFERENCES Translator (translator_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
