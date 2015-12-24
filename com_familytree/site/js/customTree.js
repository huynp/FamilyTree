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
                    hasSpouse:true,
                    hasExSpouse:false,
                    type: 'Initial Data',
                    isInitialize: true,
                    isRoot: true
                };
                var callback = function(returnData) {
                    me.options.mainAncestorData = {
                        name: returnData.name,
                        spouse: returnData.spouse,
                        exSpouses: returnData.exSpouses,
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
                        exSpouses: returnData.exSpouses,
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
                    me.saveTreeData(false);
                };
                me.showPopup(data, callback)
            },
            initTree: function(mainAncestorData, mainDescendantData, spouseAncestorData) {
                var me = this;
                me.$toolbar = buildToolBar(me.options.hasRoot, me.options.treeType);
                var $mainTab = $('<div id="main-tab-container"></div>').appendTo($el);
                var $rootTab = $('<div id="root-tab-container"></div>').appendTo($el);
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

                setTimeout(function(){
                    $mainTab.addClass('tab-item tab-content active');
                    $rootTab.addClass('tab-item tab-content');
                },200);

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
                        me.saveTreeData(false);
                    });
                    var $addBirthDayContainer = $('<div class="add-birthday-container">Add Birthday and Anniversary</div>').appendTo($toolbarContainer);
                    var $lbForAddBirthDay = $('<label class="lbAddBirthday" for="cb-add-birthday"> </label>').prependTo($addBirthDayContainer);
                    var $cbAddBirthday = $('<input type="checkbox" id="cb-add-birthday"/>').prependTo($addBirthDayContainer);
                    $cbAddBirthday.prop('checked', me.options.allowAddBirthDay);
                    $cbAddBirthday.change(function() {
                        me.options.allowAddBirthDay = $(this).is(":checked");
                        me.options.allowAddBirthDay && alert('Adding date branches to your tree is additional $10. You may be invoiced for this amount if not previously collected.');
                        me.saveTreeData(false);
                    });

                    if(treeType ==='Descendant')
                    {
                        //Add single trunk or double trunk radio
                        var $trunkOptionContainer = $('<div class="trunk-option-container">\
                                        <input type="checkbox" id="cb-double"/>\
                                        <label for="cb-double" class="lbAddBirthday"></label> Double Trunk\
                            </div>').appendTo($toolbarContainer);
                        $trunkOptionContainer.find("#cb-double").prop("checked", me.options.isDoubleTrunk)
                        $trunkOptionContainer.find("#cb-double").change(function(){
                            me.options.isDoubleTrunk = $(this).is(":checked");
                            me.saveTreeData(false);
                        });

                    }

                    var $finishButton = $('<button class="finish-button">I have completed my family tree!!!!</button>').appendTo($toolbarContainer);
                    $finishButton.click(function(){
                        if(confirm('Are you completed your family tree?'))
                        {
                            me.saveTreeData(true);
                        }
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
                    me.options.currentTree = treeType;
                    $el.append($toolbarContainer);
                    return $toolbarContainer;
                }

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
                        maxLevel: treeType === 'Descendant' ? me.options.descendantLevel : me.options.ancestorLevel,
                        mode: me.options.isReadOnly ? 'readOnly':'edit'
                    }, data);
                    return tree;
                }
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
                                <td><input type="text" class="txtSpouseName" placeholder="Spouse name" />\
                                <input type="text"  class="spouse-birthday date-picker" placeholder="Spouse Birthday" data-date-format="mm-dd-yyyy" data-date-viewmode="years" readonly/></td>\
                            </tr>\
                            <tr class="add-more-ex-spouse-row hide">\
                                <td></td>\
                                <td><button class="btn-add-more-ex-spouse">Add More Ex-Spouse</button></td>\
                            </tr>\
                            <tr class="has-ex-spouse hide">\
                                <td>Ex Spouse</td>\
                                <td><input type="text" class="txtExSpouseName" placeholder="Ex Spouse name" />\
                                <input type="text"  class="ex-spouse-birthday date-picker" placeholder="ex Spouse Birthday " data-date-format="mm-dd-yyyy" data-date-viewmode="years" readonly/></td>\
                            </tr>\
                        </table>\
                    </div>'),
                    trExSpouseTemplate ='<tr class="has-ex-spouse allow-add-birthday">\
                                        <td><button class="remove-ex-spouse">Remove Ex-Spouse</button></td>\
                                        <td><input type="text" class="txtExSpouseName" placeholder="Ex Spouse name" />\
                                        <input type="text"  class="ex-spouse-birthday date-picker" placeholder="ex Spouse Birthday " data-date-format="mm-dd-yyyy" data-date-viewmode="years" readonly/></td>\
                                    </tr>',
                    $birthday = $popup.find('.birthday'),
                    $spouseBirthday = $popup.find('.spouse-birthday'),
                    $anniversary = $popup.find('.anniversary-date');
                    $rowAllowAddSpouse = $popup.find('.allow-add-spouse'),
                    $rowsAllowAddBirthday = $popup.find('.allow-add-birthday');
                    $popupTitle = $popup.find('.title'),
                    $spouseName = $popup.find('.txtSpouseName'),
                    $name = $popup.find('.txtName'),
                    $nodeType = $popup.find('.txtType'),
                    $cbHasSpouse = $popup.find('.cbHasSpouse'),
                    $cbHasExSpouse = $popup.find('.cbHasExSpouse');
                    $btnAddMoreExSpouse = $popup.find('.btn-add-more-ex-spouse');

                $cbHasSpouse.on('change', function() {
                    $(this).is(':checked') ? $popup.find('.has-spouse').show().find('input:first').focus() : $popup.find('.has-spouse').hide();
                });

                $cbHasExSpouse.on('change', function() {
                    $(this).is(':checked') ? $popup.find('.has-ex-spouse').show().find('input:first').focus() : $popup.find('.has-ex-spouse').hide();
                    $(this).is(':checked') ? $popup.find('.add-more-ex-spouse-row').show():$popup.find('.add-more-ex-spouse-row').hide();
                });

                var addMoreExSpouseFunct= function  (data) {
                    var $trExSpouse = $(trExSpouseTemplate);
                    var $removeExSpouseBtn = $trExSpouse.find('button');
                    !me.options.allowAddBirthDay && $trExSpouse.removeClass('allow-add-birthday');
                    $removeExSpouseBtn.click(function(event) {
                        $trExSpouse.remove();
                    });

                    if(data)
                    {
                        $trExSpouse.find('.txtExSpouseName').val(data.name);
                        $trExSpouse.find('.ex-spouse-birthday').val(data.birthday);
                    }

                    $popup.find('table').append($trExSpouse);

                    var $datePicker = $trExSpouse.find('.date-picker').datepicker().on('changeDate', function(ev) {
                        if (ev.viewMode === "days") {
                            $datePicker.hide();
                            $(this).show();
                        }
                    }).data('datepicker');

                }
                $btnAddMoreExSpouse.click(function(event) {
                    if(!$cbHasExSpouse.is(':checked'))
                        return;
                    addMoreExSpouseFunct();
                });

                me.$popup = $popup;
                me.$popup.find('.date-picker').each(function() {
                            var $datePicker = $(this).datepicker().on('changeDate', function(ev) {
                                if (ev.viewMode === "days") {
                                    $datePicker.hide();
                                    $(this).show();
                                }
                            }).data('datepicker');
                        });
                me.$popup.getData = function() {
                    var isValid = me.$popup.valid();
                    if (!isValid) {
                        me.$popup.find('.error:first').focus();
                        alert('Please complete all information before save!!!');
                        return;
                    }
                    var spouseName ="";
                    if($cbHasSpouse.is(':checked'))
                        spouseName = $.trim($spouseName.val());

                    var exSpouses=[];
                     if($cbHasExSpouse.is(':checked'))
                     {
                        $popup.find('tr.has-ex-spouse').each(function(index, el) {
                            var name = $.trim($(el).find('.txtExSpouseName').val());
                            var birthday = $(el).find('.ex-spouse-birthday').val()
                            exSpouses.push({name:name,birthday:birthday})

                        });
                     }
                    var name = $.trim($name.val());

                    var data = {
                        name: name,
                        hasSpouse:$cbHasSpouse.is(':checked'),
                        spouse: spouseName,
                        spouseBirthday: $spouseBirthday.val(),
                        hasExSpouse:$cbHasExSpouse.is(':checked'),
                        exSpouses: exSpouses,
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
                    var name = $.trim($name.val());

                    if (name === '') {
                        $name.addClass('error');
                        isValid = false;
                    }

                    if (spouseName === '' && $spouseName.is(':visible')) {
                        $spouseName.addClass('error');
                        isValid = false;
                    }


                     if($cbHasExSpouse.is(':checked'))
                     {
                        $popup.find('tr.has-ex-spouse').each(function(index, el) {
                            var $exSpouseName = $(el).find('.txtExSpouseName');
                            if ($.trim($exSpouseName.val()) === '') {
                                $exSpouseName.addClass('error');
                                isValid = false;
                            }

                        });
                     }
                    return isValid;
                };

                me.$popup.cleanUp = function() {
                    me.$popup.find('.error').removeClass('error');
                    me.$popup.find('input').val('');
                    $popup.find('.remove-ex-spouse').click();
                    $cbHasSpouse.prop('checked', false);
                    $cbHasSpouse.removeAttr('disabled');
                    $cbHasExSpouse.prop('checked', false);
                };

                me.$popup.bindDataToPopup = function(data) {
                    me.options.currentTree != 'Descendant' ? $rowAllowAddSpouse.hide() : $rowAllowAddSpouse.show();

                    if(data.hasSpouse)
                    {
                        $cbHasSpouse.prop('checked', true);
                        $spouseName.val(data.spouse);
                        data.spouseBirthday && $spouseBirthday.val(data.spouseBirthday);
                    }
                    else{
                         $cbHasSpouse.prop('checked', false);
                    } 
                    $cbHasSpouse.change();

                    data.birthday && $birthday.val(data.birthday);
                    data.anniversary && $anniversary.val(data.anniversary);
                    data.isDummy ? $name.attr('placeholder', data.name) : $name.val(data.name);
                    $nodeType.val(data.type);
                    if(me.options.allowAddBirthDay)
                    {
                        $rowsAllowAddBirthday.show();
                        $popup.find('.has-spouse').addClass('allow-add-birthday');
                        $popup.find('.has-ex-spouse').addClass('allow-add-birthday');
                    }  
                    else{
                        $rowsAllowAddBirthday.hide();
                        $popup.find('.has-spouse').removeClass('allow-add-birthday');
                        $popup.find('.has-ex-spouse').removeClass('allow-add-birthday');                   
                     }

                    if(data.hasExSpouse)
                    {
                        $cbHasExSpouse.prop('checked', true);
                        $.each(data.exSpouses, function(index, val) {
                            if(index==0)
                            {
                                var $trExSpouse =  $popup.find('table tr.has-ex-spouse:first');
                                $trExSpouse.find(".txtExSpouseName").val(val.name);
                                $trExSpouse.find(".ex-spouse-birthday").val(val.birthday);
                            }
                            else
                            {
                                addMoreExSpouseFunct(val)
                            }

                        });
                    }
                    else{
                        $cbHasExSpouse.prop('checked', false);
                    }
                    $cbHasExSpouse.change();
                };
                me.myPopup = $.fn.jPopup();
            },
            addUpdateTreeNode: function($node, treeInstance) {
                var me = this;
                var _nodeData = $node[0].data,
                    callback = function(data) {
                        data ? treeInstance.updateNode(data) : treeInstance.removeNode();
                        me.saveTreeData(false);
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
                    },
                    onHide: function() {
                        //Reset and clear on popup data
                        me.$popup.cleanUp();
                    }
                }
                me.myPopup.display(true, me.$popup, popupOptions);
            },
            saveTreeData: function(isFinish) {

                function enCodeDataString(str) {
                    str = str.replace(/\\/g, "%%H%%U%%Y%%");
                    str = str.replace(/\"/g, "@@H@@U@@Y@@");
                    str = str.replace(/\'/g, "!!H!!U!!Y!!");
                    return str;
                }

                function enCodeData(data) {
                    data.name && (data.name = enCodeDataString(data.name));
                    data.spouse && (data.spouse = enCodeDataString(data.spouse));
                    if(data.exSpouses)
                    {
                        $.each(data.exSpouses, function(index, val) {
                            data.exSpouses[index].name = enCodeDataString(data.exSpouses[index].name);
                        });
                    }
                    if (data.childNodes && data.childNodes.length > 0) {
                        for (var i = 0; i < data.childNodes.length; i++)
                            enCodeData(data.childNodes[i]);
                    }
                }

                var me = this;
                var url = isFinish? '/index.php/?option=com_familytree&task=finish&format=raw': '/index.php/?option=com_familytree&task=save&format=raw';

                var treeDataToSave = {
                    mainAncestorData: null,
                    mainDescendantData: null,
                    spouseAncestorData: null,
                    treeType: options.treeType,
                    hasRoot: options.hasRoot,
                    andStyle: me.$toolbar.find('select option:selected').val(),
                    allowAddBirthDay:me.options.allowAddBirthDay,
                    ancestorLevel: me.options.ancestorLevel,
                    descendantLevel: me.options.descendantLevel,
                    isDoubleTrunk:me.options.isDoubleTrunk
                };
                $.each(me.trees, function() {
                    var treeData ={};
                     $.extend(true,treeData,this.getTreeData().data);
                    enCodeData(treeData);
                    treeDataToSave[this.getTreeData().name] = treeData;
                });
                $.ajax({
                    type: 'POST',
                    data: {
                        orderNumber: me.options.orderNumber,
                        orderPass: me.options.orderPass,
                        treeData: JSON.stringify(treeDataToSave)
                    },
                    url:url,
                    success: function(result) {
                        isFinish && alert("Your tree have been sent to Custom Family Tree team. Thank You!!!");
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
