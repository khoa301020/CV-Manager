<!-- create function to set layout -->
<?php
function set_layout($title, $body)
{
    $title = $title;
    include './resources/views/layouts/header.tpl.php';
    include './helpers/session.php';
    include './resources/views/' . $body;
    include './resources/views/layouts/footer.tpl.php';
}
