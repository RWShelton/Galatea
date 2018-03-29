.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

create table users(
	id INTEGER PRIMARY KEY,
	email TEXT NOT NULL UNIQUE,
	password TEXT NOT NULL
);