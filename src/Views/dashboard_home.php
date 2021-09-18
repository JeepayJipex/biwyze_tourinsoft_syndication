<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div class="container" x-data="tabs">
    <h2>Syndications Tourinsoft</h2>


    <div class="mt-5">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" x-bind:class="tab === 'syndications' ? 'active' : ''" x-on:click="setTab('syndications')" href="#">Syndications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" x-bind:class="tab === 'options' ? 'active' : ''" x-on:click="setTab('options')" aria-current="page" href="#">Options</a>
            </li>
        </ul>
    </div>

    <div class="spinner-border ma-5" role="status" x-show="$store.main.loading">
        <span class="visually-hidden">Loading...</span>
    </div>

    <div class="mt-5 mb-5 ml-5 mr-5">
        <div x-show="tab === 'options'">
            <?php
                require_once ('dashboard_options.php')
            ?>
        </div>
        <div x-show="tab === 'syndications'">
            <?php
            require_once ('dashboard_syndications.php')
            ?>
        </div>
    </div>
</div>

<?php
?>