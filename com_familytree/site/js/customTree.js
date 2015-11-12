/*

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
*/

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
                    handler[i].apply(handler[i], args);
                }
            }
        }
    }

    function FamilyTree($el, options) {
        var _options = {
            treeName: 'familyTree',
            treeType: 'Descendant',
            data:{}

        };
        _options = $.extend(_options, options);
        var $selectedNode, _isAdd,
           // _sampleData = _options.treeType === 'Ancestor' ? _options.AncestorData : _options.DescendantData,
            _treeInstance = renderTree(_options.data);



        function bindDataToTemplate(data, title, allowAddSpouse) {

            if (allowAddSpouse) {
                $rowAllowAddSpouse.show();
                $cbHasSpouse.attr('checked', data.spouse != '');
                $cbHasSpouse.change();
                $spouseName.val(data.spouse);
            } else {
                $rowAllowAddSpouse.hide();
                $rowHasSpouse.hide();
            }
            $popupTitle.text(title);
            $name.val(data.name);
            $nodeType.val(data.type);
        }

        var $popupTemplate = $('<div class="inner-popup-content">\
                <h3 class="title"></h3>\
                <table>\
                    <tr>\
                        <td width="100px">Name</td>\
                        <td><input type="text" class="txtName" /></td>\
                    </tr>\
                    <tr  class="allow-add-spouse">\
                        <td>Has Spouse</td>\
                        <td><input type="checkbox" class="cbHasSpouse" /></td>\
                    </tr>\
                    <tr class="has-spouse hide">\
                        <td>Spouse Name</td>\
                        <td><input type="text" class="txtSpouseName" /></td>\
                    </tr>\
                </table>\
            </div>'),
            $rowAllowAddSpouse = $popupTemplate.find('.allow-add-spouse');
            $rowHasSpouse = $popupTemplate.find('.has-spouse');
            $popupTitle = $popupTemplate.find('.title');
            $spouseName = $popupTemplate.find('.txtSpouseName'),
            $name = $popupTemplate.find('.txtName'),
            $nodeType = $popupTemplate.find('.txtType'),
            $cbHasSpouse = $popupTemplate.find('.cbHasSpouse');
            $cbHasSpouse.on('change', function() {
            $(this).is(':checked') ? $rowHasSpouse.show() : $rowHasSpouse.hide();
        });

        var popupButtons = [{
                title: 'cancel',
                onClick: function(popupInstance) {
                    popupInstance.display(false);
                }
            }, 
            {
                title: 'save',
                onClick: function(popupInstance) {
                    var spouseName = $cbHasSpouse.length &&$cbHasSpouse.is(':visible') && $cbHasSpouse.is(':checked') ? $spouseName.val() : '';
                    var name = $.trim($name.val());
                    if (name === '') {
                        alert("Please enter name!!!");
                        return;
                    }

                    var data = {
                        name: $name.val(),
                        spouse: spouseName,
                        type: $nodeType.val(),
                        isDummy: false
                    };
                    _treeInstance.updateNode(data);
                    popupInstance.display(false);
                }
            }];

        var _instance = {
            addChild: function($node) {
                _isAdd = true;
                var data = {
                    name: '',
                    type: $node[0].data.type,
                    spouse: ''
                }
                var allowAddSpouse = _options.treeType == 'Descendant' || ($node[0] == _treeInstance.getRootNode()[0]);
                bindDataToTemplate(data, 'Add ' + $node[0].data.type, allowAddSpouse);
                var popupOptions = {
                    buttons: popupButtons
                }
                $popupTemplate.jPopup(popupOptions);
            },
            editNode: function($node) {
                _isAdd = false;
                var allowAddSpouse = _options.treeType == 'Descendant' || ($node[0] == _treeInstance.getRootNode()[0]) ;
                bindDataToTemplate($node[0].data, 'Edit ' + $node[0].data.type, allowAddSpouse);
                var popupOptions = {
                    buttons: popupButtons
                }
                $popupTemplate.jPopup(popupOptions);
            }
        };

        function renderTree(data) {
            $el.find('.jOrgChart').remove();
            return $.fn.jOrgChart({
                chartElement: $el,
                onNodeSelected: function($node) {
                    _options.nodeSelected($node);
                },
                displayHorizontal: true,
                treeType: _options.treeType,
                andStyle: _options.andStyle
            }, data);

        }
        return _instance;
    }

    $.fn.familyTree = function(options) {
        return new FamilyTree(this, options);
    }
}(jQuery));
