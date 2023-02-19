
# GameHub

GameHub is an online gaming website created by [Erald Kola](mailto:ekola20@epoka.edu.al), [Kledi Haxhimali](mailto:khaxhimali20@epoka.edu.al) and [Terens Tare](mailto:ttare20@epoka.edu.al) for the course "Web Technologies" at [Epoka University](https://www.epoka.edu.al/).

The website uses the following technologies:
- [PHP](https://www.php.net/) for the backend
- [MySQL](https://www.mysql.com/) for the database
- [Bootstrap](https://getbootstrap.com/) for the frontend

To run the website, you need to have a web server with PHP and MySQL installed. You can use [XAMPP](https://www.apachefriends.org/index.html) for this purpose. First, start a MySQL server. Then, start a web server and open `localhost:port` on your web browser of choice.

## Database

The database is created using the `gamehub.sql` file. It is automatically imported when you create the website. A default user with the following credentials is created:
- Username: `admin`
- Password: `Adminn1234`
- Role: `admin`

## Folder Structure

The folder structure is as follows:
- `controllers`: contains the PHP files that handle the requests.
- `games`: contains the games that are uploaded by the users. Inside this folder there is a `games.json` file that contains data about the available games. The format of this file is:
```json
[
    {
        "name": "<Game-Name>",
        "folder": "<Game-Folder>",
        "tags": [
            "<Tag-1>",
            "<Tag-2>",
            "<Tag-3>"
            ...
        ],
    }
]
```
To add a new game, you need to add a new entry in the `games.json` file and create a folder with the same name as the game in the `games` folder. Inside this folder, there should be an `index.js` file that contains the game code. You can render to the `canvas` element with id `game`. Along with the game code, you need to add an `icon.png` file that will be used as the game icon. For an example, you can check the `snake` game inside the `games` folder. The website will any new data from this file to the database on startup.

- `models/db`: contains the PHP files that describe the database tables. These files contain classes that derive from a common `Table` class, which contains some methods representing a common set of database operations.
- `routes`: contains the PHP files that handle the requests. These files are called by the `index.php` file. Each of these files contains a class with an `enter` function that just imports the corresponding view file from the `views` folder.
- `utils`: contains the PHP files that contain utility functions/definitions, such as the `Db` class that is used to connect to the database, or the regex constants that are used to validate the user input.
- `views`: contains the PHP files that render the HTML pages. These files are called by the `routes` files. Some of these files contain just a widget instead of a full page, such as navbar.
- `index.php`: the main file that handles the requests. It calls the corresponding `routes` file based on the request URL. This is achieved by using the `Router` utility class that is defined in the `utils` folder. We define a route for each page in the website, using the files from the `routes` folder. The `.htaccess` file is used to redirect all requests to the `index.php` file, which then redirects the request to the corresponding `routes` file.