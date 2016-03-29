Simple Blog
===========

Getting Started
-------
 1. Clone this Repo to your webhost
 2. Setup your MySQL Database and tables (See Below)
 2. Edit the database.php file found at `/admin/database.php`
 5. Edit the Admin `.htaccess` file found at `/admin/.htaccess`
	 6. REQUIRED: Set the full path to your .htpasswd file
	 7. Directions can be found at [http://www.htaccesstools.com/htaccess-authentication/](http://www.htaccesstools.com/htaccess-authentication/)
 8. Edit the Admin `.htpasswd` file found at `/admin/.htpasswd`
	 9. REQUIRED:  Password must be hashed! Create file here [http://www.htaccesstools.com/htpasswd-generator/](http://www.htaccesstools.com/htpasswd-generator/)
 10. At this point the everything can be managed via the web portal

Example
-------
This is deprecated

A working example can be found here: [https://www.bell-towne.com/blog_example](https://www.bell-towne.com/blog_example)

You can access the Admin page, but nothing will be saved.

Live Blog
-------
This is deprecated

My active blog using this system can be found here: [https://blog.bell-towne.com/](https://blog.bell-towne.com/)

Feel Free to Submit issues and Suggestions
------------------------------------------

You may need to change the file permission after cloning
=======


----------


Database Schema
=======

table name: `config`

| K  | Column Name   | Type         | Desription                            |
|----|---------------|--------------|---------------------------------------|
| PK | id            | int          |                                       |
|    | title         | varchar(50)  | Blog Main Title                       |
|    | tagline       | varchar(150) | Blog Main Tagline                     |
|    | blogUrl       | varchar(150) | Base URL for blog ROOT                |
|    | twitter       | varchar(150) | Twitter URL                           |
|    | facebook      | varchar(150) | Facebook URL                          |
|    | github        | varchar(150) | Github URL                            |
|    | copyrightName | varchar(50)  | Name for copyright at bottom of pages |
|    | copyrightUrl  | varchar(150) | URL for copyright                     |


table name: `authors`

| K  | Column Name | Type        | Desription     |
|----|-------------|-------------|----------------|
| PK | authorID    | int         | author Number  |
|    | authorName  | varchar(50) | Name of Author |
|    | authorURL   | varchar(50) | Author Website |


table name: `blogs`

| K  | Column Name | Type           | Desription                      |
|----|-------------|----------------|---------------------------------|
|    | published   | tinyint        | boolean for publishing          |
|    | title       | varchar(50)    | Blog Title                      |
| FK | authorID    | int            | Link to Author Table            |
|    | preview     | varchar(21844) | Preview Text, size is up to you |
|    | timestamp   | timestamp      | Created Time                    |
|    | updated     | timestamp      | Update Time                     |
| PK | url         | varchar(50)    | title converted to url (unique) |
|    | text        | longtext       | blog text                       |