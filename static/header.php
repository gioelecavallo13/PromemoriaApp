<!--/static/header.php-->
<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Ottiene il nome del file PHP corrente
?>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c2a2a;">
    <div class="container-fluid">
        <a class="navbar-brand" href="promemoria.php">Promemoria App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'promemoria.php') ? 'active' : ''; ?>" href="promemoria.php">Promemoria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'timer.php') ? 'active' : ''; ?>" href="timer.php">Timer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'profilo.php') ? 'active' : ''; ?>" href="profilo.php">Profilo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'logout.php') ? 'active' : ''; ?>" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

