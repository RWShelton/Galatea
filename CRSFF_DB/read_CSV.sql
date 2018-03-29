CREATE TABLE CSV_import (
	author_first TEXT,
	author_last TEXT,
	title TEXT,
	source TEXT,
	editor_first TEXT,
	editor_last TEXT,
	year INTEGER,
	language TEXT,
	place_of_publication TEXT,
	publisher TEXT,
	page_start TEXT,
	page_end TEXT,
	translator_first TEXT,
	translator_last TEXT,
	edition TEXT,
	keyword TEXT,
	original_year INTEGER,
	searchable BOOLEAN
);

.separator ","
.import db_data.csv CSV_import

--Create temp tables with unique constraints (don't need all tables to have temps)
CREATE TABLE Source_Temp (
	source_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	name TEXT NOT NULL CHECK (name != ""),
	place_of_publication TEXT,
	year INTEGER,
	original_year INTEGER,
	edition TEXT,
	language TEXT NOT NULL,
	searchable BOOLEAN,
	UNIQUE (name, year, edition, language, searchable)
);

CREATE TABLE Section_Temp (
	section_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	source_id INTEGER NOT NULL,
	title TEXT NOT NULL CHECK (title != ""),
	page_start TEXT,
	page_end TEXT,
	UNIQUE (title, page_start, page_end),
	FOREIGN KEY (source_id) REFERENCES Source(source_id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);
CREATE TABLE Author_Temp (
	author_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	author_first_name TEXT,
	author_last_name TEXT,
	UNIQUE (author_first_name, author_last_name)
);
CREATE TABLE Editor_Temp (
	editor_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	editor_first_name TEXT,
	editor_last_name TEXT,
	UNIQUE (editor_first_name, editor_last_name)
);
CREATE TABLE Translator_Temp (
	translator_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	translator_first_name TEXT,
	translator_last_name TEXT,
	UNIQUE (translator_first_name, translator_last_name)
);
CREATE TABLE Publisher_Temp (
	publisher_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	publisher_name TEXT NOT NULL CHECK (publisher_name != ""),
	UNIQUE (publisher_name)
);

INSERT OR IGNORE INTO Source_Temp (name, place_of_publication, year, original_year, edition, language, searchable)
	SELECT source, place_of_publication, year, original_year, edition, language, searchable
		FROM CSV_import;
INSERT or IGNORE into Source SELECT * FROM Source_Temp;
--need script for: Section
--insert values into Section that are from the join of Source and CSV_import on all their common attributes.
--every section will be associated with a source
--does this need a WHERE clause?
INSERT OR IGNORE INTO Section_Temp (source_id, title, page_start, page_end)
	SELECT source_id, title, page_start, page_end
	FROM Source JOIN CSV_import
		ON Source.name = CSV_import.source
			AND Source.year = CSV_import.year
			AND Source.original_year = CSV_import.original_year
			AND Source.language = CSV_import.language
			AND Source.place_of_publication = CSV_import.place_of_publication
			AND Source.edition = CSV_import.edition
			AND Source.searchable = CSV_import.searchable;

INSERT OR IGNORE INTO Author_Temp (author_first_name, author_last_name)
	SELECT author_first, author_last FROM CSV_import;

INSERT OR IGNORE INTO Editor_Temp (editor_first_name, editor_last_name)
	SELECT editor_first, editor_last FROM CSV_import;

INSERT OR IGNORE INTO Translator_Temp (translator_first_name, translator_last_name)
	SELECT translator_first, translator_last FROM CSV_import;

INSERT OR IGNORE INTO Publisher_Temp (publisher_name)
	SELECT publisher FROM CSV_import;

INSERT or IGNORE into Section SELECT * FROM Section_Temp;
INSERT or IGNORE into Author SELECT * FROM Author_Temp;
INSERT or IGNORE into Editor SELECT * FROM Editor_Temp;
INSERT or IGNORE into Translator SELECT * FROM Translator_Temp;
INSERT or IGNORE into Publisher SELECT * FROM Publisher_Temp;

INSERT or IGNORE INTO Authors_source (source_id, author_id)
	SELECT source_id, author_id
	FROM Author JOIN CSV_import ON
		Author.author_first_name = CSV_import.author_first
		AND Author.author_last_name	 = CSV_import.author_last
		JOIN Source ON Source.name = CSV_import.source
	WHERE CSV_import.title IS NULL OR CSV_import.title = "";

INSERT or IGNORE INTO Edits_source (source_id, editor_id)
	SELECT source_id, editor_id
	FROM Editor JOIN CSV_import ON
		Editor.editor_first_name = CSV_import.editor_first
		AND Editor.editor_last_name	 = CSV_import.editor_last
		JOIN Source ON Source.name = CSV_import.source;

INSERT or IGNORE INTO Translates_source (source_id, translator_id)
	SELECT source_id, translator_id
	FROM Translator JOIN CSV_import ON
		Translator.translator_first_name = CSV_import.translator_first
		AND Translator.translator_last_name	 = CSV_import.translator_last
		JOIN Source ON Source.name = CSV_import.source;

INSERT or IGNORE INTO Publishes_source (source_id, publisher_id)
	SELECT source_id, publisher_id
	FROM Publisher JOIN CSV_import ON
		Publisher.publisher_name = CSV_import.publisher
		JOIN Source ON Source.name = CSV_import.source;

INSERT or IGNORE INTO Authors_section (section_id, author_id)
	SELECT section_id, author_id
	FROM Author JOIN CSV_import ON
		Author.author_first_name = CSV_import.author_first
		AND Author.author_last_name	 = CSV_import.author_last
		JOIN Section ON Section.title = CSV_import.title
		JOIN SOURCE ON Section.source_id = Source.source_id
		WHERE CSV_import.source = Source.name;

INSERT or IGNORE INTO Edits_section (section_id, editor_id)
	SELECT section_id, editor_id
	FROM Editor JOIN CSV_import ON
		Editor.editor_first_name = CSV_import.editor_first
		AND Editor.editor_last_name	 = CSV_import.editor_last
		JOIN Section ON Section.title = CSV_import.title
		JOIN SOURCE ON Section.source_id = Source.source_id
		WHERE CSV_import.source = Source.name;;

INSERT or IGNORE INTO Translates_section (section_id, translator_id)
	SELECT section_id, translator_id
	FROM Translator JOIN CSV_import ON
		Translator.translator_first_name = CSV_import.translator_first
		AND Translator.translator_last_name	 = CSV_import.translator_last
		JOIN Section ON Section.title = CSV_import.title
		JOIN SOURCE ON Section.source_id = Source.source_id
		WHERE CSV_import.source = Source.name;

Drop table Source_Temp;
Drop table Section_Temp;
Drop table Author_Temp;
Drop table Editor_Temp;
Drop table Publisher_Temp;
Drop table Translator_Temp;
Drop table CSV_import;
--Then copy all temp tables into real tables (attributes are in same order, so Select all)
