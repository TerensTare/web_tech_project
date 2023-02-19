<?php

require_once __DIR__ . '/../utils/db.php';

class Navbar
{
    public static function build()
    {
        $html = <<<HTML
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">GameHub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="/navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="/" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Games
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/?filter=arcade">Arcade</a></li>
                            <li><a class="dropdown-item" href="/?filter=puzzle">Puzzle</a></li>
                            <li><a class="dropdown-item" href="/?filter=board">Board</a></li>
                            <li><a class="dropdown-item" href="/?filter=multiplayer">Multiplayer</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <form class="d-flex me-5" method="get" action="/">
                <input class="form-control me-2" type="search" name="filter" placeholder="Search by genre" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <div>
HTML;

        if (!isset($_SESSION['id'])) {
            $html .= <<<HTML
                <a href="/auth" class="btn btn-outline-secondary me-2">Login</a>
                <a href="/auth" class="btn btn-outline-secondary me-2">Signup</a>
HTML;
        } else {
            $html .= <<<HTML
                <form action="/logout" method="POST">
                <input type="hidden" name="logout" value="logout">
HTML;

            if (isset($_SESSION['admin'])) {
                $html .= <<<HTML
    <a href="/admin" class="btn btn-outline-secondary me-2">Admin</a>
HTML;
            } else {
                $user = Db::self()->users()->find([UsersTable::ID => $_SESSION['id']]);

                $html .= <<<HTML
                <a href="/profile" class="btn btn-outline-secondary me-2 disabled">{$user[UsersTable::USERNAME]}</a>
HTML;
            }

            $html .= <<<HTML
                    <button type="submit" class="btn btn-outline-danger me-2">Logout</button>
                </form>
HTML;
        }

        $html .= <<<HTML
            </div>
        </div>
    </nav>
HTML;

        return $html;
    }
}

?>