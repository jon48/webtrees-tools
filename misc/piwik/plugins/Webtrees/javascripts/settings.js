/*!
 * Piwik - Web Analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

function sendWebtreesSettingsAJAX() {
    var webtreesrooturl = $('#webtreesrooturl').val();
    var webtreestoken = $('#webtreestoken').val();
    var webtreestaskname = $('#webtreestaskname').val();

    var postParams = {};
    postParams.webtreesrooturl = webtreesrooturl;
    postParams.webtreestoken = webtreestoken;
    postParams.webtreestaskname = webtreestaskname;

    var ajaxHandler = new ajaxHelper();
    ajaxHandler.addParams({
        module: 'Webtrees',
        format: 'json',
        action: 'setGeneralSettings'
    }, 'GET');
    ajaxHandler.addParams(postParams, 'POST');
    ajaxHandler.redirectOnSuccess();
    ajaxHandler.setLoadingElement('#ajaxLoadingWebtreesSettings');
    ajaxHandler.setErrorElement('#ajaxErrorWebtreesSettings');
    ajaxHandler.send(true);
}

$(document).ready(function () {	
	$('#webtreesSettingsSubmit').click(function () {
		sendWebtreesSettingsAJAX();
    });

    $('input').keypress(function (e) {
            var key = e.keyCode || e.which;
            if (key == 13) {
                $('#webtreesSettingsSubmit').click();
            }
        }
    );
});
