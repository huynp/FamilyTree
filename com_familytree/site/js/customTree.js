(function($) {
    function EventHandler() {
        var _handlers = {};
        return {
            registerEvent: function(name, funct) {
                var handler = _handlers[name] || [];
                handler.push(funct);
                _handlers[name] = handler;
            },
            triggerEvent: function(name, args) {
                var handler = _handlers[name] || [];
                for (var i in handler) {
                    handler[i](args);
                }
            }
        }
    }

    function FamilyTree($el, options) {
        var _options = {
            TreeName: 'familyTree',
            Data: {}
        };
        _options = $.extend(_options, options);
        var seletedNode = $root = $('<li class="tree-node selected" />');
        var contextMenu = buildContextMenu($el, _options.treeType);
        var popup = buildFamilyTreePopup($el, _options.treeType);

        function buildFamilyTreePopup(_options.treeType)
        {
            var popup = new PopupManager();
            popup.onSaveClick(function(data){

            });
            return popup;
        }

        function buildContextMenu($el, treeType) {
            var contextMenu = new MenuContext($el);
            switch (treeType) {
                case 'Ancestor':
                    contextMenu.addMenuItem('Add Father', function(sender, menuItem) {
                        popup.show(selectedNode, 'AddFather');
                    });

                    contextMenu.addMenuItem('Add Mother', function(sender, menuItem) {
                        popup.show(selectedNode, 'AddMother');
                    });
                    break;
                case 'Descendant':
                    contextMenu.addMenuItem('Add child', function(sender, menuItem) {
                        popup.show(selected, 'AddChild');
                    });
                    break;
            }

            contextMenu.addMenuItem('Edit', function(sender, menuItem) {
                popup.show(selectedNode);
            });
            contextMenu.addMenuItem('Remove', function(sender, menuItem) {
                popup.show(selectedNode, 'AddFather');
            });

        }

        function render() {

        }

        function MenuContext($el) {
            var me = this,
            _eventHandler = new EventHandler(),
            _menuItemEvents = {
                onCloseMenu: 'onCloseMenu',
                onOpenMenu: 'onOpenMenu',
                onMenuItemClick: 'onMenuItemClick'
            },
            $menu = $('<ul class="context-menu"/>'),
            _isDisplay = false,
            _instance = {
                onMenuItemClick: function(handler) {
                    _eventHandler.registerEvent(_menuItemEvents.onMenuItemClick, handler);
                },
                onClose: function(handler) {
                    _eventHandler.registerEvent(_menuItemEvents.onMenuClose, handler);
                },
                onOpen: function(handler) {
                    _eventHandler.registerEvent(_menuItemEvents.onMenuOpen, handler);
                },
                addMenuItem: addMenuItem,
                display: display
            };

            bindContextMenuEvent($el);
            function bindContextMenuEvent($el) {
                $('body').on('click', function(event) {
                    _isDisplay && event.target != $menu && _instance.display(false)
                })

                $el.on("contextmenu", function(e) {
                    if (e.target.nodeName != "INPUT" && e.target.nodeName != "TEXTAREA") {
                        _instance.display(true);
                        return false;
                    }
                });

	            _instance.onMenuItemClick(function(){
	            	_instance.display(false);
	            })

            }

            function addMenuItem(text, onClickHanlder) {
                $menuItemAddChild = $('<li/>').text(text).on('click', function() {
                    onClickHanlder(_instance, this);
                    _eventHandler.triggerEvent(_menuItemEvents.menuItemClick, [_instance, this])
                }).appendTo($menu);
            }

            function display(isDisplay) {
                if (isDisplay) {
                    _eventHandler.triggerEvent(_menuItemEvents.onOpenMenu);
                    $menu.show();
                } else {
                    _eventHandler.triggerEvent(_menuItemEvents.onCloseMenu);
                    $menu.hide();
                }
                _isShow = isDisplay;
            }

            return _instance;
        }

        function PopupManager($el,treeType) {
            var _isDisplay=false,
            _eventHandler = new EventHandler(),
            $ancestorContentTmp ='<div class="ancestor-content-popup">Ancestor Popup</div>',
            $descendantContentTmp = '<div class="descendant-content-popup">Descendant Popup</div>',
            $popupBackdrop = $('<div class="back-drop"></div>').appendTo('body'),
            $popupContainer = $('<div class="popup-container"></div>').appendTo('body'),
            $popupHeader =$('<div  class="popup-header"></div>').appendTo($popupContainer),
            $popupContent = $('<div class="popup-content></div>"').appendTo($popupContainer),
            $popupFooter =$('<div class="popup-footer"></div>').appendTo($popupContainer),
            $buttonSave = $('<button class="btn-save">Save</buton>').appendTo($popupFooter),
            $buttonCancel = $('<button class="btn-cancel">Cancel</buton>').appendTo($popupFooter),
            treeType == 'Ancestor'? $popupContent.append($ancestorContentTmp): $popupContent.append($descendantContentTmp);
            bindPopupEvent();
            var _instance ={
                display:display,
                onSaveClick:function(handler){
                    _eventHandler.registerEvent('onSaveClick');
                },
                onCancelClick:function(handler){
                    _eventHandler.registerEvent('onCancelClick');
                }
            };

            function bindDataToTemplate(selectedItem){

            }
            function display(isDisplay,selectedItem) {
               if(isDisplay){
                    selectedItem && bindDataToTemplate(selectedItem);
                    $popupContainer.show();

               }
               else{
                    $popupContainer.hide();
               }
            }

            function bindPopupEvent(){
                //Window resize s
            }

            return _instance;
        }

        return {

        };

    }

    $.fn.familyTree = function(options) {
        return new FamilyTree(this, option);
    }
}(jQuery));
