(function($) {
    $.fn.generateUID = function() {
        return ("0000" + (Math.random() * Math.pow(36, 4) << 0).toString(36)).slice(-4);
    };
    $.fn.jOrgChart = function(options, data) {
        data.level = 0;
        var opts = $.extend({}, $.fn.jOrgChart.defaults, options),
            $selectedNode, $appendTo = $(opts.chartElement),
            _treeLevel = 0,
            $container = $("<div class='node-container " + opts.chartClass + "'/>").addClass(opts.treeType),
            $rootNode = buildNode(data, $container, opts);
        $rootNode.addClass('main');
        $appendTo.append($container);
        opts.displayHorizontal && displayHorizontal();

        function displayHorizontal() {
            $container.addClass('jOrgChart-horizontal');
            $container.find('>table').addClass('horizontal');
            var tableWidth = $container.find('>table').width();
            var tableHeight = $container.find('>table').height();
            $container.find('>table').css({
                top: (tableWidth + 50) + "px",
                left: "20px"
            });
            $container.height(tableWidth + 120);
            $container.parents('#family-tree-container').width(tableHeight + 120);
        }

        function renderNode($node) {
            var isRoot = $node.hasClass('main');
            var $nodeContainer = $node[0] != $rootNode[0] ? $node.parents(".node-container:first") : $container;
            $nodeContainer.empty();
            $selectedNode = buildNode($node[0].data, $nodeContainer, opts);
            if (isRoot)
                $rootNode = $selectedNode.addClass('main');
            opts.displayHorizontal && displayHorizontal();
        }

        // Method that recursively builds the tree
        function buildNode(nodeData, $container, opts) {
            var $table = $("<table cellpadding='0' cellspacing='0' border='0'/>");
            var $tbody = $("<tbody/>");

            // Construct the node container(s)
            var $nodeRow = $("<tr/>").addClass("node-cells");
            var $nodeCell = $("<td/>").addClass("node-cell").attr("colspan", 2);
            var _childNodes = nodeData.childNodes || [];
            var $nodeDiv = $("<div>").addClass("node");

            if (nodeData.isDummy) {
                $nodeDiv.addClass('dummy-node');
            } else if (!nodeData.isDummy && nodeData.level < opts.maxLevel - 1) {
                //Add dummy data
                switch (opts.treeType) {
                    case 'Ancestor':
                        var hasFather = hasMother = false;
                        for (var i = 0; i < _childNodes.length; i++) {
                            switch (_childNodes[i].type) {
                                case 'Father':
                                    hasFather = true;
                                    break;
                                case 'Mother':
                                    hasMother = true;
                                    break;
                            }
                        }

                        !hasFather && _childNodes.unshift({
                            name: 'Father Name',
                            level: nodeData.level + 1,
                            type: 'Father',
                            isDummy: true,
                            id: $.fn.generateUID()
                        });

                        !hasMother && _childNodes.push({
                            name: 'Mother Name',
                            level: nodeData.level + 1,
                            type: 'Mother',
                            isDummy: true,
                            id: $.fn.generateUID()
                        });
                        nodeData.childNodes = _childNodes;
                        break;
                    case 'Descendant':
                        var _hasDummyNode = false;
                        for (var i = 0; i < _childNodes.length; i++) {
                            if (_childNodes[i].isDummy) {
                                _hasDummyNode = true
                                break;
                            }
                        }

                        !_hasDummyNode && _childNodes.unshift({
                            name: 'Child Name',
                            spouse: 'Child\'s spouse',
                            level: nodeData.level + 1,
                            type: 'Child',
                            isDummy: true,
                            id: $.fn.generateUID(),
                        });
                        nodeData.childNodes = _childNodes;
                        break;
                }
            }


            if (_childNodes && _childNodes.length > 1) {
                $nodeCell.attr("colspan", _childNodes.length * 2);
            }
            // Draw the node
            var $nodeContent = $(opts.nodeTemplate);
            var nodeDisplayText = nodeData.isDummy ? 'Add ' + nodeData.type : nodeData.name;
            $nodeContent.find('.name').text(nodeDisplayText);
            if (!nodeData.isDummy && nodeData.spouse && nodeData.spouse !== '') {
                var andText = 'and';
                if (opts.andStyle == 'sign')
                    andText = '&';

                var $andStyle = $('<label class="end-style"></label>').text(andText);
                opts.andStyle == 'italized' && $andStyle.addClass('italized');
                var spouseName =nodeData.spouse;
                var $spouseName = $('<label class="spouse-name"></label>').text(spouseName)
                $nodeContent.find('.spouse-name-container').append($andStyle).append($spouseName);
            } else {
                $nodeContent.find('.spouse-name-container').remove();
            }

            var iconClass = nodeData.type || '';
            $nodeContent.find('.icon').addClass(iconClass);
            //Increaments the node count which is used to link the source list and the org chart
            $nodeDiv.append($nodeContent);
            $nodeDiv[0].data = nodeData;
            $nodeDiv.unbind('click').on('click', function() {
                $selectedNode = $nodeDiv;
                opts.onNodeSelected($nodeDiv);
            });
            var $nodeWrapper = $('<div class="node-wrapper"></div>');
            $nodeCell.append($nodeDiv);
            $nodeRow.append($nodeCell);
            $tbody.append($nodeRow);

            if (_childNodes && _childNodes.length > 0) {
                var $downLineRow = $("<tr/>");
                var $downLineCell = $("<td/>").attr("colspan", _childNodes.length * 2);
                $downLineRow.append($downLineCell);

                // draw the connecting line from the parent node to the horizontal line 
                $downLine = $("<div></div>").addClass("line down");
                $downLineCell.append($downLine);
                $tbody.append($downLineRow);

                // Draw the horizontal lines
                var $linesRow = $("<tr/>");
                $.each(_childNodes, function() {
                    var $left = $("<td>&nbsp;</td>").addClass("line left top");
                    var $right = $("<td>&nbsp;</td>").addClass("line right top");
                    $linesRow.append($left).append($right);
                });

                // horizontal line shouldn't extend beyond the first and last child branches
                $linesRow.find("td:first")
                    .removeClass("top")
                    .end()
                    .find("td:last")
                    .removeClass("top");
                // if this is single child node add padding
                _childNodes.length == 1 && $linesRow.find("td.line ").addClass('padding-top');
                $tbody.append($linesRow);
                var _childNodesRow = $("<tr/>");
                $.each(_childNodes, function(index, _childNode) {
                    var $td = $("<td class='node-container'/>");
                    $td.attr("colspan", 2);
                    // recurse through children lists and items
                    buildNode(_childNode, $td, opts);
                    _childNodesRow.append($td);
                });
                $tbody.append(_childNodesRow);
            }

            $table.append($tbody);
            $container.append($table);

            /* Prevent trees collapsing if a link inside a node is clicked */
            $nodeDiv.children('a').click(function(e) {
                console.log(e);
                e.stopPropagation();
            });
            return $nodeDiv;
        };

        var _instance = {
            addNode: function(data) {
                $selectedNode && $selectedNode[0].data.childNodes || ($selectedNode[0].data.childNodes = [])
                $selectedNode && $selectedNode[0].data.childNodes.push(data);
                renderNode($selectedNode);
            },
            removeNode: function() {
                var $parentNode = $selectedNode.parents('.node-container').eq(1).find('.node:first');
                var childNodes = $parentNode[0].data.childNodes;
                for (var i = 0; i < childNodes.length; i++) {
                    if (childNodes[i].id == $selectedNode[0].data.id) {
                        $parentNode[0].data.childNodes.splice(i, 1);
                        renderNode($parentNode);
                        break;
                    }
                }
            },
            updateNode: function(data) {
                $.extend($selectedNode[0].data, data);
                var isRoot = $selectedNode.hasClass('main');
                var $parentNode = !isRoot ? $selectedNode.parents('.node-container').eq(1).find('.node:first') : $selectedNode;
                renderNode($parentNode);
            },
            updateAndStyle: function(andStyle) {
                opts.andStyle = andStyle;
                renderNode($rootNode);
            },
            getTreeData: function() {
                return { 
                        name:opts.treeName,
                        data:$rootNode[0].data
                    };
            }
        };
        return _instance;
    };

    // Option defaults
    $.fn.jOrgChart.defaults = {
        chartElement: 'body',
        depth: -1,
        chartClass: "jOrgChart",
        dragAndDrop: false,
        onNodeSelected: function() {},
        nodeTemplate: '<div class="node-content"><i class="icon"></i><span class="name"></span><div class="spouse-name-container"></div></div>'
    };


})(jQuery);
