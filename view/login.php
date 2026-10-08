<!DOCTYPE html>
<html>
    <head>
        <title>NEWSPORTAL</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity=
              "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fq784/j6cY/iJTUQOhoCwR7x9JvORxT2MZw1"
              crossorigin="anonymous">
              <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
        <meta charset="utf-8">
    </head>
    <body>
        <nav class="one">
            <ul class="topmenu">
                <li><a href="#">Kategooriad <i class="fa fa-angle-down"></i></a>
                    <ul class="submenu">
                        <?php
                            Controller::AllCategory();
                        ?>
                    </ul>
                </li>
                <li><a href="info">Info</a></li>
                <li><a href="./">Stardileht</a></li>
                <li><a href="registerForm">Register</a></li>
                <li class="pull-right">
                    <form action="search" method="GET">
                        <input type="text" name="otsi">
                        <input type="submit" value="Otsi">
                    </form>
                </li>
            </ul>
        </nav>

        <section>
            <div class = 'divBox'>
                <?php
                if(isset($content)){
                    echo $content;
                }
                else {
                    echo '<h1>Content is gone!</h1>';
                }
                ?>
            </div>
        </section>
    
        <hr>
        <p style="display:block; text-align:center;">JPTV24 2026 a. &copy</p>
    </body>
</html>