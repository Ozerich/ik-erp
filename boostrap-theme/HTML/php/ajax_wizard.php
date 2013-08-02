<?php

    if(isset($_POST['login']) && isset($_POST['email']))
        if($_POST['login'] == 'John' && $_POST['email'] == 'john@example.com') echo 'success';
    
    if(isset($_POST['hash']) && $_POST['hash'] == 'd8d3a01ba7e5d44394b6f0a8533f4647') echo 'success';
        

?>