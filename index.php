<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Yadda Yadda Yadda &#153</title>
    </head>
    <body>
        <p>Yadda Yadda Yadda &#153</p>
        <?php
            session_start();
            require_once './model/Model.inc.php'; // domainmodel
            require_once './model/Image.inc.php'; // domainmodel
            require_once './model/Listener.inc.php'; // domainmodel
            require_once './controller/Controller.inc.php'; // domainmodel
         /*   require_once './view/TagView.inc.php';
            require_once './view/UsersView.inc.php';
            require_once './view/YaddaView.inc.php';*/

            $controller = new Controller($_GET, $_POST);
            $controller->action();
        ?>
    </body>
</html>
