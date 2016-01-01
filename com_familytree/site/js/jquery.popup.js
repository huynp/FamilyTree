(function($) {
    $.fn.jPopup = function() {
        var $backdrop =   $('<div class="back-drop"></div>').appendTo('body'),
            $container = $('<div class="popup-container"></div>').appendTo('body'),
            $closeButton =$('<button class="b-close">X</span>').click(function(){
                _instance.display(false);
            }),
            $title =$('<div class="header-title"/>'),
            $header = $('<div  class="popup-header"></div>').append( $title).append($closeButton).appendTo($container),
            $content = $('<div class="popup-content"></div>').appendTo($container),
            $footer = $('<div class="popup-footer"></div>').appendTo($container),
            opts={};
        
        var _instance = {
            display: display,
            $container:$container
        }
       
        $( window ).resize(function() {
            $backdrop.width()>0 && $backdrop.height()>0 && $backdrop.is(':visible') && calculatePosition();
        });
        function prepairPopup($el,options){
            var me = this;
            opts = $.extend({}, $.fn.jOrgChart.defaults, options);
            $title.text(opts.title);
            $footer.empty();
            $closeButton.show();
            $content.append($el);
            !opts.allowManualClose && $closeButton.hide();
            opts.buttons && $.each(opts.buttons, function(index, button) {
                var $button = $('<button>').text(button.title).attr("id",button.id||"");
                $button.on('click', function() {
                    button.onClick(_instance);
                })
                $footer.append($button);
            });
            calculatePosition();
        }

        function calculatePosition(){
                var width = $(document).width();
                var height = $(document).height();
                var x = ($(window).width() - $container.width()) / 2;
                var y = $(window).height() / 8;
                $backdrop.css({
                    'width': width,
                    'height': height
                });
                $container.css({
                    'top': y,
                    'left': x
                });
        }

        function display(isDisplay,$el,options) {
            var me = this;
            if (isDisplay) {
                prepairPopup($el,options);
                $('html').css('overflow','hidden');
                opts.onShow && opts.onShow(_instance);
                $backdrop.show();
                $container.show();
                $container.find('input:first').focus();
            } else {

                $('html').css('overflow','auto');
                opts.onHide && opts.onHide(_instance);
                $container.hide();
                $backdrop.hide();
            }
        }
        return _instance;
    }
    $.fn.jPopup.default = {
        buttons: [],
        onShow:false,
        onHide:false

    }
}(jQuery))
