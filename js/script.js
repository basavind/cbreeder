/**
 * ownCloud - cbreeder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Dmitry Basavin <basavind@gmail.com>
 * @copyright Dmitry Basavin 2016
 */

(function ($, OC) {
    $(document).ready(function () {
        if (window.MaterialHelper !== undefined) {
            MaterialHelper.bindStageClick();
        }
    });

})(jQuery, OC);
