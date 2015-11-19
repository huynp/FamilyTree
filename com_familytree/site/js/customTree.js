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
        var _instance = {
            options: options,
            init: function() {
                var me = this;
                _instance.initPopup();
                (me.options.mainAncestorData || me.options.mainDescendantData) ? _instance.initTree(me.options.mainAncestorData, me.options.mainDescendantData, me.options.spouseAncestorData): _instance.showInitScreen();
            },
            showInitScreen: function() {
                var me = this;
                var data = {
                    isDummy: true,
                    name: 'Main Person Name',
                    spouse: 'Spouse Name',
                    type: 'Initial Data',
                    isInitialize: true,
                    isRoot: true
                };
                var callback = function(returnData) {
                    me.options.mainAncestorData = {
                        name: returnData.name,
                        spouse: returnData.spouse,
                        exSpouse: returnData.exSpouse,
                        level: 0,
                        type: 'Root',
                        isDummy: false,
                        id: $.fn.generateUID(),
                        isRoot: true,
                        anniversary: returnData.anniversary,
                        birthday: returnData.birthday
                    };

                    me.options.mainDescendantData = {
                        name: returnData.name,
                        spouse: returnData.spouse,
                        exSpouse: returnData.exSpouse,
                        level: 0,
                        type: 'Root',
                        isDummy: false,
                        id: $.fn.generateUID(),
                        isRoot: true,
                        anniversary: returnData.anniversary,
                        birthday: returnData.birthday
                    };

                    me.options.spouseAncestorData = {
                        name: returnData.spouse,
                        spouse: returnData.name,
                        level: 0,
                        type: 'Root',
                        isDummy: false,
                        id: $.fn.generateUID(),
                        isRoot: true
                    };
                    me.initTree(me.options.mainAncestorData, me.options.mainDescendantData, me.options.spouseAncestorData);
                    me.saveTreeData();
                };
                me.showPopup(data, callback)
            },
            initTree: function(mainAncestorData, mainDescendantData, spouseAncestorData) {
                var me = this;

                function buildToolBar(hasRoot, treeType) {
                    var $toolbarContainer = $('<div class="toolbar-container"></div>');
                    //Select and type
                    var $select = $("<select id='ddl-and-style'> </select>");
                    $select.append($('<option value="and">  I want the standard "and"</option>'));
                    $select.append($('<option value="italized">  I want the "and" italized</option>'));
                    $select.append($('<option value="sign">  I want "&"</option>'));
                    $select.val(me.options.andStyle);
                    var $andStyleDDL = $("<label class='lbAnStyle' for='ddl-and-style'/>").text("And style").append($select);
                    $andStyleDDL.appendTo($toolbarContainer);
                    $andStyleDDL.change(function() {
                        //Remove tab-item to make all tree visible in order to calculate correct 
                        $('.tab-content').removeClass('tab-item');
                        $.each(me.trees, function(index, item) {
                            item.updateAndStyle($andStyleDDL.find('option:selected').val())
                        });
                        $('.tab-content').addClass('tab-item');
                        me.saveTreeData();
                    });
                    var $addBirthDayContainer = $('<div class="add-birthday-container">Add Birthday and Anniversary</div>').appendTo($toolbarContainer);
                    var $lbForAddBirthDay = $('<label class="lbAddBirthday" for="cb-add-birthday"> </label>').prependTo($addBirthDayContainer);
                    var $cbAddBirthday = $('<input type="checkbox" id="cb-add-birthday"/>').prependTo($addBirthDayContainer);
                    $cbAddBirthday.prop('checked', me.options.allowAddBirthDay);
                    $cbAddBirthday.change(function() {
                        me.options.allowAddBirthDay = $(this).is(":checked");
                        me.options.allowAddBirthDay && alert('Adding date branches to your tree is additional $10. You may be invoiced for this amount if not previously collected.');
                        me.saveTreeData();
                    });
                    //build tabs
                    if (hasRoot) {
                        var mainTabTitle, rootTabTitle,mainTabTreeType,rootTabTreeType;
                        switch (treeType) {
                            case 'Descendant':
                                mainTabTitle = 'Main Descendant Tree';
                                rootTabTitle = 'Root Ancestor Tree';
                                mainTabTreeType =treeType;
                                rootTabTreeType ='AncestorCouple';

                                break;

                            case 'AncestorSingle':
                            case 'AncestorCouple':
                                mainTabTitle = 'Main Ancestor Tree';
                                rootTabTitle = 'Root Descendant Tree';
                                mainTabTreeType =treeType;
                                rootTabTreeType ='Descendant';
                                break;
                        }
                        var $navTabs = $('<ul class="nav nav-tabs tree-tabs"></ul>');
                        $navTabs.append($('<li class="active"><a class="tree-tab active" tab-content="#main-tab-container">' + mainTabTitle + '</a></li>'));
                        $navTabs.append($('<li> <a class="tree-tab" tab-content="#root-tab-container">' + rootTabTitle + '</a></li>'));
                        $navTabs.appendTo($toolbarContainer);
                        $navTabs.find('a.tree-tab').click(function() {
                            $('.tree-tabs .active, .tab-item').removeClass('active');
                            var contentId = $(this).attr('tab-content');
                            $(this).addClass('active').parent().addClass('active');
                            $(contentId).addClass('active');
                            if(contentId=='#main-tab-container')
                            {
                                me.options.currentTree = mainTabTreeType;
                            }
                            else{

                                me.options.currentTree = rootTabTreeType;
                            }

                        });
                    }
                    $el.append($toolbarContainer);
                    return $toolbarContainer;
                }
                me.$toolbar = buildToolBar(me.options.hasRoot, me.options.treeType);

                function createFamilyTree(treeType, data, $treeContainer, treeName) {
                    var tree = $.fn.jOrgChart({
                        treeName: treeName,
                        chartElement: $treeContainer,
                        onNodeSelected: function($node) {
                            me.addUpdateTreeNode($node, tree);
                        },
                        displayHorizontal: true,
                        treeType: treeType,
                        andStyle: me.options.andStyle,
                        maxLevel: treeType === 'Descendant' ? me.options.descendantLevel : me.options.ancestorLevel
                    }, data);
                    return tree;
                }
                var $mainTab = $('<div id="main-tab-container" class="tab-content active"></div>').appendTo($el);
                var $rootTab = $('<div id="root-tab-container"  class="tab-content"></div>').appendTo($el);
                me.trees = [];
                switch (me.options.treeType) {
                    case 'Descendant':
                        var $mainDescendantTree = $('<div id="main-descendant-tree" class="orgChart"></div>').appendTo($mainTab);
                        me.trees.push(createFamilyTree('Descendant', mainDescendantData, $mainDescendantTree, 'mainDescendantData'))
                        if (me.options.hasRoot) {
                            var $mainAncestorTree = $('<div id="main-ancestor-tree" class="orgChart"></div>').appendTo($rootTab);
                            me.trees.push(createFamilyTree('Ancestor', mainAncestorData, $mainAncestorTree, 'mainAncestorData'));

                            var $spouseAncestorTree = $('<div id="spouse-ancestor-tree" class="orgChart" ></div>').appendTo($rootTab);
                            me.trees.push(createFamilyTree('Ancestor', spouseAncestorData, $spouseAncestorTree, 'spouseAncestorData'));
                        }
                        break;

                    case 'AncestorSingle':
                        var $mainAncestorTree = $('<div id="main-ancestor-tree-tree" class="orgChart" ></div>').appendTo($mainTab);
                        me.trees.push(createFamilyTree('Ancestor', mainAncestorData, $mainAncestorTree, 'mainAncestorData'));
                        if (me.options.hasRoot) {
                            var $mainDescendantTree = $('<div id="main-descendant-tree-tree" class="orgChart" ></div>').appendTo($rootTab);
                            me.trees.push(createFamilyTree('Descendant', mainDescendantData, $mainDescendantTree, 'mainDescendantData'));
                        }

                        break;

                    case 'AncestorCouple':
                        var $mainAncestorTree = $('<div id="main-ancestor-tree" class="orgChart" ></div>').appendTo($mainTab);
                        me.trees.push(createFamilyTree('Ancestor', mainAncestorData, $mainAncestorTree, 'mainAncestorData'));

                        var $spouseAncestorTree = $('<div id="spouse-ancestor-tree" class="orgChart" ></div>').appendTo($mainTab);
                        me.trees.push(createFamilyTree('Ancestor', spouseAncestorData, $spouseAncestorTree, 'spouseAncestorData'));

                        if (me.options.hasRoot) {
                            var $mainDescendantTree = $('<div id="main-descendant-tree" class="orgChart"></div>').appendTo($rootTab);
                            me.trees.push(createFamilyTree('Descendant', mainDescendantData, $mainDescendantTree, 'mainDescendantData'));
                        }
                        break;
                }
                $mainTab.addClass('tab-item');
                $rootTab.addClass('tab-item');
            },
            initPopup: function() {
                var me = this;
                var $popup = $('<div class="inner-popup-content">\
                        <table>\
                            <tr>\
                                <td>Name</td>\
                                <td><input type="text" class="txtName" /></td>\
                            </tr>\
                            <tr class="allow-add-birthday">\
                                <td>Birthday</td>\
                                <td><input type="text"  class="birthday date-picker" placeholder="Select A Date" data-date-format="mm-dd-yyyy" data-date-viewmode="years" readonly/></td>\
                            </tr>\
                            <tr class="allow-add-birthday">\
                                <td>Anniversary</td>\
                                <td><input type="text"  class="anniversary-date date-picker" placeholder="Select A Date" data-date-format="mm-dd-yyyy" data-date-viewmode="years" readonly/></td>\
                            </tr>\
                            <tr  class="allow-add-spouse">\
                                <td>Spouses</td>\
                                <td>\
                                    <label class="lbHasSpouse" for="cbHasSpouse"><input type="checkbox" class="cbHasSpouse" id="cbHasSpouse" /> Has spouse</label>\
                                    <label class="lbHasExSpouse" for="cbHasExSpouse"> <input type="checkbox" class="cbHasExSpouse" id="cbHasExSpouse" /> Has ex-spouse</label>\
                                </td>\
                            </tr>\
                            <tr class="has-spouse hide">\
                                <td>Spouse</td>\
                                <td><input type="text" class="txtSpouseName" placeholder="spouse name" /></td>\
                            </tr>\
                            <tr class="has-ex-spouse hide">\
                                <td>Ex Spouse</td>\
                                <td><input type="text" class="txtExSpouseName" placeholder="ex Spouse name" /></td>\
                            </tr>\
                        </table>\
                    </div>'),
                    $birthday = $popup.find('.birthday'),
                    $anniversary = $popup.find('.anniversary-date');
                    $rowAllowAddSpouse = $popup.find('.allow-add-spouse'),
                    $rowsAllowAddBirthday = $popup.find('.allow-add-birthday');
                    $rowHasSpouse = $popup.find('.has-spouse'),
                    $rowHasExSpouse = $popup.find('.has-ex-spouse'),
                    $popupTitle = $popup.find('.title'),
                    $spouseName = $popup.find('.txtSpouseName'),
                    $exSpouseName = $popup.find('.txtExSpouseName'),
                    $name = $popup.find('.txtName'),
                    $nodeType = $popup.find('.txtType'),
                    $cbHasSpouse = $popup.find('.cbHasSpouse'),
                    $cbHasExSpouse = $popup.find('.cbHasExSpouse');

                $cbHasSpouse.on('change', function() {
                    $(this).is(':checked') ? $rowHasSpouse.show().find('input').focus() : $rowHasSpouse.hide();
                });
                $cbHasExSpouse.on('change', function() {
                    $(this).is(':checked') ? $rowHasExSpouse.show().find('input').focus() : $rowHasExSpouse.hide();
                });


                me.$popup = $popup;

                me.$popup.getData = function() {
                    var isValid = me.$popup.valid();
                    if (!isValid) {
                        me.$popup.find('.error:first').focus();
                        alert('Please complete all information before save!!!');
                        return;
                    }
                    var spouseName = $spouseName.is(':visible') ? $.trim($spouseName.val()) : '';
                    var exSpouseName = $exSpouseName.is(':visible') ? $.trim($exSpouseName.val()) : '';
                    var name = $.trim($name.val());

                    var data = {
                        name: name,
                        spouse: spouseName,
                        exSpouse: exSpouseName,
                        type: $nodeType.val(),
                        isDummy: false,
                        birthday: $birthday.val(),
                        anniversary: $anniversary.val()
                    };
                    return data;
                };

                me.$popup.valid = function() {
                    var isValid = true;
                    me.$popup.find('.error').removeClass('error');
                    var spouseName = $spouseName.is(':visible') ? $.trim($spouseName.val()) : '';
                    var exSpouseName = $exSpouseName.is(':visible') ? $.trim($exSpouseName.val()) : '';
                    var name = $.trim($name.val());

                    if (name === '') {
                        $name.addClass('error');
                        isValid = false;
                    }

                    if (spouseName === '' && $spouseName.is(':visible')) {
                        $spouseName.addClass('error');
                        isValid = false;
                    }

                    if (exSpouseName === '' && $exSpouseName.is(':visible')) {
                        $exSpouseName.addClass('error');
                        isValid = false;
                    }
                    return isValid;
                };

                me.$popup.cleanUp = function() {
                    me.$popup.find('.error').removeClass('error');
                    me.$popup.find('input').val('');
                    $cbHasSpouse.prop('checked', false);
                    $cbHasSpouse.removeAttr('disabled');
                    $cbHasExSpouse.prop('checked', false);
                };

                me.$popup.bindDataToPopup = function(data) {
                    !data.isDummy && data.spouse && data.spouse != '' && $cbHasSpouse.prop('checked', true);
                    !data.isDummy && data.exSpouse && data.exSpouse != '' && $cbHasExSpouse.prop('checked', true);
                    data.isDummy ? $spouseName.attr('placeholder', data.spouse) : $spouseName.val(data.spouse);
                    data.isDummy ? $exSpouseName.attr('placeholder', data.exSpouse) : $exSpouseName.val(data.exSpouse);
                    !data.isInitialize && me.options.currentTree != 'Descendant' ? $rowAllowAddSpouse.hide() : $rowAllowAddSpouse.show();
                    data.isInitialize && $cbHasSpouse.attr('disabled', 'disabled').prop('checked', true);
                    $cbHasExSpouse.change();
                    $cbHasSpouse.change();
                    data.birthday && $birthday.val(data.birthday);
                    data.anniversary && $anniversary.val(data.anniversary);
                    data.isDummy ? $name.attr('placeholder', data.name) : $name.val(data.name);
                    $nodeType.val(data.type);
                    me.options.allowAddBirthDay ? $rowsAllowAddBirthday.show() : $rowsAllowAddBirthday.hide();
                };
                me.myPopup = $.fn.jPopup();
            },
            addUpdateTreeNode: function($node, treeInstance) {
                var me = this;
                var _nodeData = $node[0].data,
                    callback = function(data) {
                        data ? treeInstance.updateNode(data) : treeInstance.removeNode();
                        var treeData = treeInstance.getTreeData();
                        me.saveTreeData(treeData);
                    };
                this.showPopup(_nodeData, callback);
            },
            showPopup: function(data, callback) {
                var me = this,
                    popupButtons = [{
                        title: 'cancel',
                        onClick: function(popupInstance) {
                            popupInstance.display(false);
                        }
                    }, {
                        title: 'save',
                        onClick: function(popupInstance) {
                            var data = me.$popup.getData();
                            if (data) {
                                callback(data);
                                popupInstance.display(false);
                            }
                        }
                    }, {
                        title: 'Remove',
                        onClick: function(popupInstance) {
                            callback();
                            popupInstance.display(false);
                        }
                    }];

                me.$popup.bindDataToPopup(data);
                (data.isDummy || data.isRoot) && popupButtons.splice(2, 1);
                data.isInitialize && popupButtons.splice(0, 1);
                var popupOptions = {
                    buttons: popupButtons,
                    title: data.isDummy ? ('Add ' + data.type) : ('Edit ' + data.name),
                    allowManualClose: !data.isInitialize,
                    onShow: function(popupInstance) {
                        popupInstance.$container.find('.date-picker').each(function() {
                            var $datePicker = $(this).datepicker().on('changeDate', function(ev) {
                                if (ev.viewMode === "days") {
                                    $datePicker.hide();
                                    $(this).show();
                                }
                            }).data('datepicker');

                        });
                    },
                    onHide: function() {
                        //Reset and clear on popup data
                        me.$popup.cleanUp();
                    }
                }
                me.myPopup.display(true, me.$popup, popupOptions);
            },
            saveTreeData: function() {

                function enCodeDataString(str) {
                    str = str.replace(/\\/g, "%%H%%U%%Y%%");
                    str = str.replace(/\"/g, "@@H@@U@@Y@@");
                    str = str.replace(/\'/g, "!!H!!U!!Y!!");
                    return str;
                }

                function enCodeData(data) {
                    data.name && (data.name = enCodeDataString(data.name));
                    data.spouse && (data.spouse = enCodeDataString(data.spouse));
                    data.exSpouse && (data.exSpouse = enCodeDataString(data.exSpouse));
                    if (data.childNodes && data.childNodes.length > 0) {
                        for (var i = 0; i < data.childNodes.length; i++)
                            enCodeData(data.childNodes[i]);
                    }
                }

                var me = this;
                var treeDataToSave = {
                    mainAncestorData: null,
                    mainDescendantData: null,
                    spouseAncestorData: null,
                    treeType: options.treeType,
                    hasRoot: options.hasRoot,
                    andStyle: me.$toolbar.find('select option:selected').val(),
                    allowAddBirthDay:me.options.allowAddBirthDay
                };
                $.each(me.trees, function() {
                    var treeData = this.getTreeData();
                    enCodeData(treeData.data);
                    treeDataToSave[treeData.name] = treeData.data;
                });
                $.ajax({
                    type: 'POST',
                    data: {
                        orderNumber: me.options.orderNumber,
                        orderPass: me.options.orderPass,
                        treeData: JSON.stringify(treeDataToSave),
                        dataName: 'dataToSave.name'
                    },
                    url: '/index.php/?option=com_familytree&task=save&format=raw',
                    success: function(result) {

                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            }
        }
        _instance.init();


    }

    $.fn.familyTree = function(options) {
        return new FamilyTree(this, options);
    }
}(jQuery));
