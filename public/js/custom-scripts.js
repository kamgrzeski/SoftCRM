/*------------------------------------------------------
    Author : www.webthemez.com
    License: Commons Attribution 3.0
    http://creativecommons.org/licenses/by/3.0/
---------------------------------------------------------  */
(function ($) {
    "use strict";
    var mainApp = {

        initFunction: function () {
            /*MENU
            ------------------------------------*/
            $('#main-menu').metisMenu();

            $(window).bind("load resize", function () {
                if ($(this).width() < 768) {
                    $('div.sidebar-collapse').addClass('collapse')
                } else {
                    $('div.sidebar-collapse').removeClass('collapse')
                }
            });
        },

        initialization: function () {
            mainApp.initFunction();

        }

    }
    $(document).ready(function () {
        mainApp.initFunction();
    });

}(jQuery));

$(document).ready(function () {
    $('#dataTables').DataTable({
        "paging": false,
        "ordering": true,
        "info": false
    });
});

$(window).load(function () {
    $(".se-pre-con").delay(500).fadeOut("slow");
});
$(document).ready(function () {
    $('#localclock').jsclock();
});
