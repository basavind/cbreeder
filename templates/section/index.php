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
            <table>
                <thead>
                <tr>
                    <th>Направление</th>
                    <th>Доступно</th>
                    <th>В работе</th>
                    <th>Возвращено</th>
                    <th>Завершено</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_['sections'] as $section): ?>
                    <tr>
                        <td>
                            <a href="section/<?php p($section['slug']) ?>/course">
                                <?php p($section['name']) ?>
                            </a>
                        </td>
                        <td><?php p($section['available']) ?></td>
                        <td><?php p($section['in_work']) ?></td>
                        <td><?php p($section['reverted']) ?></td>
                        <td><?php p($section['completed']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
