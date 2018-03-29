--DDL for CRSFF Database
--Note that SQLite will allow NULL pks without the NOT NULL constraint

.mode columns
.headers on

PRAGMA foreign_keys = ON;
CREATE TABLE Source (
	source_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL CHECK (name != ""),
	place_of_publication TEXT,
	year INTEGER,
	original_year INTEGER,
	edition TEXT,
	language TEXT NOT NULL CHECK (language != ""),
	searchable BOOLEAN,
	UNIQUE (name, year, language)
);

CREATE TABLE Section (
	section_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	source_id INTEGER NOT NULL,
	title TEXT NOT NULL CHECK (title != ""),
	page_start TEXT,
	page_end TEXT,
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	UNIQUE (source_id, title)
);
CREATE TABLE Author (
	author_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	author_first_name TEXT,
	author_last_name TEXT
);
CREATE TABLE Editor (
	editor_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	editor_first_name TEXT,
	editor_last_name TEXT
);
CREATE TABLE Translator (
	translator_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	translator_first_name TEXT,
	translator_last_name TEXT
);
CREATE TABLE Publisher (
	publisher_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	publisher_name TEXT NOT NULL CHECK (publisher_name != ""),
	UNIQUE (publisher_name)
);
CREATE TABLE Source_keywords (
	source_id INTEGER NOT NULL,
	keyword TEXT NOT NULL CHECK (keyword != ""),
	PRIMARY KEY (source_id, keyword),
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);
CREATE TABLE Section_keywords (
	section_id INTEGER NOT NULL,
	keyword TEXT NOT NULL CHECK (keyword != ""),
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
