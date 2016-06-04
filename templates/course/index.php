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
                    <th>Курс</th>
                    <th>Доступно</th>
                    <th>В работе</th>
                    <th>Возвращено</th>
                    <th>Завершено</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_['courses'] as $course): ?>
                    <tr>
                        <td>
                            <a href="courses/<?php p($course['id']) ?>">
                                <?php p($course['name']) ?>
                            </a>
                        </td>
                        <td><?php p($course['available']) ?></td>
                        <td><?php p($course['in_work']) ?></td>
                        <td><?php p($course['reverted']) ?></td>
                        <td><?php p($course['completed']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
