/**
 * ownCloud - cbreeder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Dmitry Basavin <basavind@gmail.com>
 * @copyright Dmitry Basavin 2016
 */

(function (exports) {
    var MaterialHelper = {
        stageLinkClass: '.stage-material',

        bindStageClick: function (elem) {
            elem = elem || $(MaterialHelper.stageLinkClass);
            elem.click(function () {
                var $this = $(this)
                var $tr = $this.parents('tr');

                var direction = $this.attr('data-stage-direction');
                var materialId = $tr.attr('id').substr(3);

                MaterialHelper.stage(materialId, direction);
            })
        },
        stage: function (id, direction) {
            var url = OC.generateUrl('/apps/cbreeder/material/' + id + '/stage/' + direction);

            var $tr = $('#mid' + id)
            $tr.html('');
            MaterialHelper.toggleRowLoading($tr);
            $.post(url).success(function (response) {
                if (response['ok']) {
                    if (response['material'] === 'Not allowed') {
                        MaterialHelper.toggleRowLoading($tr);
                        return;
                    }

                    MaterialHelper.updateRow($tr, response['material']);
                    MaterialHelper.bindStageClick($tr.find(MaterialHelper.stageLinkClass));
                }
            })
        },

        toggleRowLoading: function ($tr) {
            $tr.toggleClass('loading');
        },

        updateRow: function ($tr, material) {
            var stageUpButton = material['stage'] !== 'На выпуске'
                ? '<button class="stage-material" data-stage-direction="up">Завершить</button>'
                : '<button class="stage-material" data-stage-direction="publish">Опубликовать</button>';
            var stageDownButton = material['stage'] === 'На редакции' ? '' : '<button class="stage-material" data-stage-direction="down">Вернуть</button>';
            var buttons = '<td>' + stageUpButton + stageDownButton + '</td>';
            var template = '<td>' + material['type'] + '</td>'
                + '<td>' + material['name'] + '</td>'
                + '<td>' + material['stage'] + '</td>'
                + '<td>' + material['state'] + '</td>'
                + buttons;

            $tr.html(template);
            MaterialHelper.toggleRowLoading($tr);
        }
    };

    exports.MaterialHelper = MaterialHelper;
})(window);
