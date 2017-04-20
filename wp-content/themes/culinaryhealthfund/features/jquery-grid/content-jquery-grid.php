<link href="<?php bloginfo('stylesheet_directory');?>/features/jquery-grid/assets/css/styles.css" rel="stylesheet" type="text/css" />
<div class="classes_wrapper">
<?php
if ( is_page('breastfeeding-classes') ) {
  include_once('docs/breastfeeding.php');
} elseif (is_page('diabetes-classes')  ) {
  include_once('docs/diabetes.php');
} elseif (is_page('kidney-smart') ) {
  include_once('docs/kidney_smart.php');
}
?>
</div>



<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<script src="<?php bloginfo('template_directory');?>/features/jquery-grid/assets/js/jquery-grid.js"></script>
