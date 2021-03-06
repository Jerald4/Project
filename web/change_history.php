<?php
include_once 'includes/psl-config.php';
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="css/pure-web.css">
    <link rel="stylesheet" href="css/pure.css" />
    <link rel="stylesheet" href="css/pure-form.css" />
    <link rel="stylesheet" href="css/side-menu.css">
</head>

<?php if (login_check($mysqli) == true) : ?>
<?php if (0 < $_REQUEST['wid']) { $wid = $_REQUEST['wid']; } ?>
<input type='hidden' name='wid' value='$wid'>
<?php if ($_REQUEST['wid'] > 0) : ?>

<div id="layout">
    <a href="" id="menuLink" class="menu-link">
        <span></span>
    </a>

    <div id='menu'>
            <div class='pure-menu pure-menu-open'>
                <a class='pure-menu-heading' align='center' href='main.php'><img src='img/logo.png'></a>
                    <ul>
                    <li><a href='my_projects.php'>Mine projekter</a></li>
                    <li><a href='all_projects.php'>Alle projekter</a></li>
                    <li><a href='history.php'>Min historik</a></li>
                    <li><a href='contact.php'>Kontakt</a></li>
                    <?php if (check_admin($mysqli) == true) : ?>
                    <li> <a href='new_project.php'>Nyt projekt</a></li>
                    <li> <a href ='sql_table_to_pdf/generate-pdf.php'> Print </a></li>
                    <?php endif; ?>
                    <?php if (check_overadmin($mysqli) == true) : ?>
                    <li> <a href='administrator.php'>Administrator</a></li>
                    <?php endif; ?>
                    <li><a class='logout' href='includes/logout.php'>Log ud</a></li>
                </  ul>
            </div>
        </div>

    <div id="main">
        <div class="header">
            <h1>Tilføj dine ændringer</h1>
        </div>

        <div class="content">
            <h2 class="content-subhead"></h2>
            
            <form class="pure-form pure-form-stacked" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"   name="registration_form">
                <?php
                    echo '<input type="hidden" name="wid" value="' .$wid .'">';
                ?>
                <ul><li> Indtast dine ændringer og tryk godkend.<br> Denne funktion vil ikke være tilgængelig hvis et projekt er lukket. </li></ul>
                <div>
                    <label for="timer"><b>Timer</b></label>
                    <input id ="timer" type="text" name="timer" required />
                </div>
                    <br><br>
                <div>
                    <label for="date"><b>Dato</b></label>
                    <input id="date" type="text" name="date" required/>
                </div>
                <br><br>
                <div>
                    <label for="info"><b>Beskrivelse</b></label>
                    <textarea id="info" type="text" name="info" rows="4" cols="50"></textarea>
                </div>
                <br><br>
                <div>
                    <br><br>
                    <input class="btn right" type="submit" value="Godkend ændringer"/> 
                </div>
                <?php
                    if(isset($_REQUEST['timer'], $_REQUEST['date'])) {
                        $timer = $_REQUEST['timer'];
                        $dato = $_REQUEST['date'];
                        $info = $_REQUEST['info'];
                        $wid = $_REQUEST['wid'];
                        mysqli_query($mysqli,"UPDATE work_on SET date = '$dato', hours = '$timer', info = '$info'
                                              WHERE work_on_id = $wid");     

                        mysqli_close($mysqli);            
                        header('Location: ./history.php');
                    }
                ?>
            </form>
        </div>
    </div>
</div>

<script src="js/ui.js"></script>

</body>
    <?php else : ?>
        <?php header('Location: ./history.php');
        die();?>
    <?php endif; ?> 
    <?php else : ?>
        <p>
            <span class="error">Du har ikke rettigheder til at komme ind på siden.</span> Gå venligst tilbage til <a href="index.php">login siden</a>.
        </p>
    <?php endif; ?>

</body>

</html>