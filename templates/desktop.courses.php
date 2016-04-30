<?php
script('kranslations', 'script');
style('kranslations', 'style');
?>

<div id="app">
    <div id="app-navigation">
        <?php print_unescaped($this->inc('part.navigation')); ?>
        <?php print_unescaped($this->inc('part.settings')); ?>
    </div>

    <div id="app-content">
        <div id="app-content-wrapper">
            <p>Раздел курсов, в которых участвует пользователь</p>
        </div>
    </div>
</div>
