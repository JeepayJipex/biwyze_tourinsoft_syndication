<?php
//var_dump((new \BiwyzeTourinsoft\Handlers\SyndicationReader("1b7cfeb8-2443-4194-a7d3-f07d0b96755a", "Chambres d'hôtes"))->getOffers());
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