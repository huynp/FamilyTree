(function($) {
    
    $.fn.jOrgChart = function(options, data) {
        var opts = $.extend({}, $.fn.jOrgChart.defaults, options);
        var $selectedNode;
        var $appendTo = $(opts.chartElement);

        // build the tree
        var $container = $("<div class='node-container " + opts.chartClass + "'/>").addClass(opts.TreeType == 'Ancestor' ? 'ancestor-tree' : 'descendant-tree'),
            $rootNode = buildNode(data, $container, opts);
        $rootNode.addClass('main');
        $appendTo.append($container);
        opts.displayHorizontal && displayHorizontal();

        function displayHorizontal() {
            $container.addClass('jOrgChart-horizontal');
            $container.find('>table').addClass('horizontal');
            var tableWidth = $container.find('>table').width();
            $container.find('>table').css({
                top: (tableWidth + 50) + "px",
                left: "20px"
            });
            $container.height(tableWidth + 120);
        }

        function renderNode($node) {
            var isRoot = $node.hasClass('main');
            var $nodeContainer = $node[0] != $rootNode[0] ? $node.parents(".node-container:first") : $container;
            $nodeContainer.empty();
            $selectedNode = buildNode($node[0].data, $nodeContainer, opts);
            if(isRoot)
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

            //Add dummy data
            if (!nodeData.isDummy) {
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

                        !hasFather && _childNodes.push({
                            isDummy: true,
                            name: 'Add Father',
                            type: 'Father'
                        });

                        !hasMother && _childNodes.push({
                            isDummy: true,
                            name: 'Add Mother',
                            type: 'Mother'
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
                            isDummy: true,
                            name: 'Add Child',
                            type: 'Child'
                        });
                        nodeData.childNodes = _childNodes;
                        break;
                }
            } else {
                $nodeDiv.addClass('dummy-node');
            }


            if (_childNodes && _childNodes.length > 1) {
                $nodeCell.attr("colspan", _childNodes.length * 2);
            }
            // Draw the node
            var $nodeContent = $(opts.nodeTemplate);
            $nodeContent.find('.name').text(nodeData.name);
            if (nodeData.spouse && nodeData.spouse !== '') {
                var andText = 'and';
                if (opts.andStyle == 'sign')
                    andText = '&';

                var $andStyle = $('<label class="end-style"></label>').text(andText);
                opts.andStyle == 'italized' && $andStyle.addClass('italized');
                var $spouseName = $('<label class="spouse-name"></label>').text(nodeData.spouse)
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
            removeNode: function() {},
            updateNode: function(data) {
                $.extend($selectedNode[0].data, data);
                var isRoot = $selectedNode.hasClass('main');
                var $parentNode = !isRoot? $selectedNode.parents('.node-container').eq(1).find('.node:first') :$selectedNode;
                renderNode($parentNode);
            },
            getRootNode:function(){
              return $rootNode;
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
