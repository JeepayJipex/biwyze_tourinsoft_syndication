<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<h4 class="mb-2">Options</h4>

<?php
include(__DIR__ . '/partials/options/options_list_form.php');
?>
<hr>
<?php
include(__DIR__ . '/partials/options/options_import_form.php');
?>
