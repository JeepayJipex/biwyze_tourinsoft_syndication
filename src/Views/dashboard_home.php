<?php
?>
<div class="container" x-data="tabs">
    <h3>Options des syndications</h3>

    <div class="mt-5">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" x-bind:class="tab === 'options' ? 'active' : ''" x-on:click="setTab('options')" aria-current="page" href="#">Options</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" x-bind:class="tab === 'syndications' ? 'active' : ''" x-on:click="setTab('syndications')" href="#">Syndications</a>
            </li>
        </ul>
    </div>
    <div class="mt-3">
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