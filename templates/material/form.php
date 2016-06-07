<?php
script('cbreeder', 'MaterialHelper');
script('cbreeder', 'script');
style('cbreeder', 'style');
?>

<div id="app">
    <div id="app-navigation">
        <?php print_unescaped($this->inc('part.navigation')); ?>
        <?php print_unescaped($this->inc('part.settings')); ?>
    </div>

    <div id="app-content">
        <div id="app-content-wrapper">
            <header>
                <h1>Загрузите новый материал</h1>
            </header>
            <form action="/apps/cbreeder/material" method="POST" enctype="multipart/form-data">
                <input type="file" name="material">
                <input type="submit" value="Загрузить">
            </form>
        </div>
    </div>
</div>

