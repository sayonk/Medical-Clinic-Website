<?php
if($_POST["phone"]) {
    mail("sayon.mk@gmail.com", "Form to email message", $_POST["phone"], "From: dundurn@email.address");
}
?>
