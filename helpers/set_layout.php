<!-- create function to set layout -->
<?php
function set_layout($title, $body)
{
  $title = $title;
  include_once('./resources/views/layouts/header.tpl.php');
  include_once('./resources/views/' . $body);
  include_once('./resources/views/layouts/footer.tpl.php');
}
