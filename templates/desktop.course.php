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
                <h1><?php p($_['course']['section'] . '/' . $_['course']['name']) ?></h1>
            </header>
            <table>
                <thead>
                <tr>
                    <th>Тип</th>
                    <th>Наименование</th>
                    <th>Стадия</th>
                    <th>Состояние</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_['materials'] as $material): ?>
                    <tr id="mid<?php p($material->getId()) ?>" data-entity="material">
                        <td><?php p($material->getType()) ?></td>
                        <td><?php p($material->getName()) ?></td>
                        <td><?php p($material->getStage()) ?></td>
                        <td><?php p($material->getState()) ?></td>
                        <td>
                            <?php if ($material->getStage() !== $material->getLastStage()): ?>
                                <button class="stage-material"
                                        data-stage-direction="up">
                                    Завершить
                                </button>
                            <?php else: ?>
                                <button class="stage-material"
                                        data-stage-direction="publish">
                                    Опубликовать
                                </button>
                            <?php endif; ?>
                            <?php if ($material->getStage() !== $material->getStageAt(0)): ?>
                                <button class="stage-material"
                                        data-stage-direction="down">
                                    Вернуть
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
