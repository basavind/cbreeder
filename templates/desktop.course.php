<?php
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
                <h1><?php p($_['course']['section'] . '/' . $_['course']['name']) ?></h1>
            </header>
            <table>
                <thead>
                <tr>
                    <th>Тип</th>
                    <th>Наименование</th>
                    <th>Стадия</th>
                    <th>Состояние</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_['materials'] as $material): ?>
                    <tr>
                        <td><?php p($material->getType()) ?></td>
                        <td><?php p($material->getName()) ?></td>
                        <td><?php p($material->getStage()) ?></td>
                        <td><?php p($material->getState()) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
