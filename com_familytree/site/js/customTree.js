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
                    handler[i].apply(handler[i],args);
                }
            }
        }
    }

    function FamilyTree($el, options) {
        var _options = {
            TreeName: 'familyTree',
            TreeType:'Descendant',
            DescendantData: {
                name:'Main Person',
                spouse:'spouse Name',
                childNodes:[
                    {
                        name:'Child 1',
                        spouse:'Child 1 spouse',
                        childNodes:[
                            {
                                name:'Child 1-1',
                                spouse:'Child 1-1 spouse'
                            },
                            {
                                name:'Child 1-2',
                                spouse:'Child 1-2 spouse'
                            }
                        ]
                    },
                    {
                        name:'Child 2',
                        spouse:'Child 2 spouse',
                        childNodes:[
                            {
                                name:'Child 2-1',
                                spouse:'Child 2-1 spouse'
                            }
                        ]
                    },
                    {
                        name:'Child 3',
                        spouse:'Child 3 spouse',
                        childNodes:[
                            {
                                name:'Child 3-1',
                                spouse:'Child 3-1 spouse'
                            },
                            {
                                name:'Child 3-2',
                                spouse:'Child 3-2 spouse',
                                childNodes:[
                                    {
                                        name:'Child 3-2-1',
                                        spouse:'Child 3-2-1 spouse'
                                    }
                                ]
                            },
                            {
                                name:'Child 3-3',
                                spouse:'Child 3-3 spouse'
                            }
                        ]
                    }
                ]
            },
            AncestorData:{
                name:'Main Person',
                spouse:'spouse Name',
                childNodes:[
                    {
                        name: 'Father 1',
                        type:'Father',
                        childNodes:[
                            {
                                name: 'Father 1-1',
                                type:'Father'
                            },
                            {
                                name: 'Mother 1-1',
                                type: 'Mother'
                            }
                        ]

                    },
                    {
                        name: 'Mother 2',
                        type: 'Mother',
                        childNodes:[
                            {
                                name: 'Father 2-1',
                                type:'Father'
                            }]
                    }
                ]
            }
        };
        _options = $.extend(_options, options);
        var  $selectedNode, _isAdd,
        _sampleData = _options.TreeType ==='Ancestor' ? _options.AncestorData :_options.DescendantData,
        _treeInstance = renderTree(_sampleData);

      
        var _instance = {
            addChild: function(type) {
                _isAdd = true;
                if(!$selectedNode)
                {
                    alert('Please select a node!!!');
                    return;
                }
                var data ={
                    name:'',
                    type:type,
                    spouse:''
                }
                bindDataToTemplate(data)
                $popupTemplate.jPopup(popupOptions);
            },
            editNode:function() {
                _isAdd = false;
                if(!$selectedNode)
                {
                    alert('Please select a node!!!');
                    return;
                }
                bindDataToTemplate($selectedNode[0].data)
                $popupTemplate.jPopup(popupOptions);      
            }
        };

        function bindDataToTemplate(data)
        {
            $name.val(data.name);
            $spouseName.val(data.spouse);
            $nodeType.val(data.type);
            $cbHasSpouse.attr('checked',data.spouse !='');
            $cbHasSpouse.change();
        }

        function buildPopupTemplate(){
            var _ancestorContentTmp ='<div class="inner-popup-content ancestor-content-popup">\
                <h3>Ancestor Popup</h3>\
                <table>\
                    <tr>\
                        <td>Name</td>\
                        <td><input type="text" class="txtName" /><input type="hidden" class="txtType"/></td>\
                    </tr>\
                </table>\
            </div>',
            _descendantContentTmp = '<div class="inner-popup-content descendant-content-popup">\
                <h3>Descendant Popup</h3>\
                <table>\
                    <tr>\
                        <td width="100px">Name</td>\
                        <td><input type="text" class="txtName" /></td>\
                    </tr>\
                    <tr>\
                        <td>Has Spouse</td>\
                        <td><input type="checkbox" class="cbHasSpouse" /></td>\
                    </tr>\
                    <tr class="has-spouse hide">\
                        <td>Spouse Name</td>\
                        <td><input type="text" class="txtSpouseName" /></td>\
                    </tr>\
                </table>\
            </div>',
            $popupTemplate = _options.TreeType == 'Ancestor'? $(_ancestorContentTmp) : $(_descendantContentTmp),
            $spouseName = $popupTemplate.find('.txtSpouseName'),
            $name = $popupTemplate.find('.txtName'),
            $nodeType = $popupTemplate.find('.txtType'),
            $cbHasSpouse = $popupTemplate.find('.cbHasSpouse');
            $cbHasSpouse.on('change',function(){
                var $rowHasSpouse =  $popupTemplate.find('.has-spouse');
                $(this).is(':checked')? $rowHasSpouse.show():$rowHasSpouse.hide();
            });

            var popupButtons =  [{
                            title:'cancel',
                            onClick:function(popupInstance){
                                popupInstance.display(false);
                            }
                        },
                        {
                            title:'save',
                            onClick:function(popupInstance){
                                var spouseName = $cbHasSpouse.length && $cbHasSpouse.is(':checked') ? $spouseName.val() : '';
                                var data={
                                    name:$name.val(),
                                    spouse:spouseName
                                }
                                _isAdd ? _treeInstance.addNode(data) : _treeInstance.updateNode(data);
                                popupInstance.display(false);
                            }
                        }];

            var popupOptions={
                buttons:popupButtons
            }
        }
        
        function renderTree(data)
        {
            $el.find('.jOrgChart').remove();
            return $.fn.jOrgChart({
                chartElement : $el,
                onNodeSelected:function($node){
                    $selectedNode && $selectedNode.removeClass('selected');
                    $selectedNode = $node.addClass('selected');
                    _options.nodeSelected($node[0])

                },
                displayHorizontal:true
            },data);
        }
        return _instance;
    }

    $.fn.familyTree = function(options) {
        return new FamilyTree(this, options);
    }
}(jQuery));
