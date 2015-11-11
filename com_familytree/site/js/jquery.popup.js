(function($) {
    $.fn.jPopup = function(options) {
        var $el = $(this),
            opts = $.extend({}, $.fn.jOrgChart.defaults, options);
        $backdrop = $('<div class="back-drop"></div>').appendTo('body'),
            $container = $('<div class="popup-container"></div>').appendTo('body'),
            $header = $('<div  class="popup-header"></div>').appendTo($container),
            $content = $('<div class="popup-content"></div>').appendTo($container),
            $footer = $('<div class="popup-footer"></div>').appendTo($container);
        $content.append($el);
        var _instance = {
            display: display,

        }

        opts.buttons && $.each(opts.buttons, function(index, button) {
            var $button = $('<button>').text(button.title);
            $button.on('click', function() {
                button.onClick(_instance);
            })
            $footer.append($button);
        });

        function display(isDisplay) {
            if (isDisplay) {
                var width = $(document).width();
                var height = $(document).height();
                var x = ($(window).width() - $container.width()) / 2;
                var y = $(window).height() / 4;
                $backdrop.css({
                    'width': width,
                    'height': height
                }).show();
                $container.css({
                    'top': y,
                    'left': x
                }).show();
            } else {
                $container.hide();
                $backdrop.hide();
            }
        }
        display(true);
        return _instance;
    }
    $.fn.jPopup.default = {
        buttons: [],

    }
}(jQuery))
