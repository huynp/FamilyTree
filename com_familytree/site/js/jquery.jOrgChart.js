/**
 * jQuery org-chart/tree plugin.
 *
 * Author: Wes Nolte
 * http://twitter.com/wesnolte
 *
 * Based on the work of Mark Lee
 * http://www.capricasoftware.co.uk 
 *
 * Copyright (c) 2011 Wesley Nolte
 * Dual licensed under the MIT and GPL licenses.
 *
 */
(function($) {

  $.fn.jOrgChart = function(options,data) {
    var opts = $.extend({}, $.fn.jOrgChart.defaults, options);
    var $selectedNode;
    var $appendTo = $(opts.chartElement);

    // build the tree
    var $container = $("<div class='" + opts.chartClass + "'/>"),
    $rootNode = buildNode(data, $container, opts);
    $appendTo.append($container); 

    function renderNode($node)
    {
      var $nodeContainer =$node[0]!= $rootNode[0]? $node.parents(".node-container:first") : $container;
      $nodeContainer.empty();
      $selectedNode = buildNode($node[0].data, $nodeContainer,opts);
      $selectedNode.addClass('selected');
    }

    // Method that recursively builds the tree
    function buildNode(nodeData,$container,opts) {
      var $table = $("<table cellpadding='0' cellspacing='0' border='0'/>");
      var $tbody = $("<tbody/>");

      // Construct the node container(s)
      var $nodeRow = $("<tr/>").addClass("node-cells");
      var $nodeCell = $("<td/>").addClass("node-cell").attr("colspan", 2);
      var _childNodes = nodeData.childNodes;
      var $nodeDiv;
      
      if(_childNodes && _childNodes.length > 1) {
        $nodeCell.attr("colspan", _childNodes.length * 2);
      }
      // Draw the node
      var $nodeContent = $(opts.nodeTemplate);
      $nodeContent.find('.name').text(nodeData.name);
      $nodeContent.find('.spouse-name').text(nodeData.spouse);

      //Increaments the node count which is used to link the source list and the org chart
      $nodeDiv = $("<div>").addClass("node").append($nodeContent);
      $nodeDiv[0].data= nodeData;
      $nodeDiv.on('click',function(){
        $selectedNode && $selectedNode.removeClass('selected');
        $selectedNode = $nodeDiv.addClass('selected');
        opts.onNodeSelected($nodeDiv);
      });

      $nodeCell.append($nodeDiv);
      $nodeRow.append($nodeCell);
      $tbody.append($nodeRow);

      if(_childNodes && _childNodes.length > 0) {
          var $downLineRow = $("<tr/>");
          var $downLineCell = $("<td/>").attr("colspan", _childNodes.length*2);
          $downLineRow.append($downLineCell);
          
          // draw the connecting line from the parent node to the horizontal line 
          $downLine = $("<div></div>").addClass("line down");
          $downLineCell.append($downLine);
          $tbody.append($downLineRow);

          // Draw the horizontal lines
          var $linesRow = $("<tr/>");
          $.each(_childNodes,function() {
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
          _childNodes.length==1 && $linesRow.find("td.line ").addClass('padding-top');
          $tbody.append($linesRow);
          var _childNodesRow = $("<tr/>");
          $.each(_childNodes,function(index,_childNode) {
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
      $nodeDiv.children('a').click(function(e){
          console.log(e);
          e.stopPropagation();
      });
      return $nodeDiv;
    };

    return {
      addNode:function(data)
      {
          $selectedNode[0].data.childNodes|| ($selectedNode[0].data.childNodes=[])
          $selectedNode[0].data.childNodes.push(data);
          renderNode($selectedNode);
      },
      removeNode:function(){},
      updateNode:function(data){
          $.extend($selectedNode[0].data, data);
          renderNode($selectedNode);
      },
      $selectedNode:$selectedNode
      
    }
  };

  // Option defaults
  $.fn.jOrgChart.defaults = {
    chartElement : 'body',
    depth      : -1,
    chartClass : "jOrgChart",
    dragAndDrop: false,
    onNodeSelected:function(){},
    nodeTemplate:'<div class="node-content"><span class="name"></span><span class="spouse-name"></span></div>'
  };
	

})(jQuery);
