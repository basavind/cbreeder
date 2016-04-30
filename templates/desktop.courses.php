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
            <table>
                <thead>
                <tr>
                    <th>Направление</th>
                    <th>Курс</th>
                    <th>Доступно</th>
                    <th>Возвращено</th>
                    <th>Завершено</th>
                    <th>Всего</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_['courses'] as $course): ?>
                    <tr>
                        <td><?php p($course['section']) ?></td>
                        <td>
                            <a href="courses/<?php p($course['anchor']) ?>">
                                <?php p($course['name']) ?>
                            </a>
                        </td>
                        <td><?php p($course['materials']['available']) ?></td>
                        <td><?php p($course['materials']['reverted']) ?></td>
                        <td><?php p($course['materials']['completed']) ?></td>
                        <td><?php p($course['materials']['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
