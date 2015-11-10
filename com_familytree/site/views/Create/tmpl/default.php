<?php
// no direct access
defined('_JEXEC') or die;
?>
 	<script type="text/javascript" src="jquery-1.11.3.js"></script>
    <script type="text/javascript" src="customTree.js"></script>
    <script type="text/javascript" src="jquery.jOrgChart.js"></script>
    <script type="text/javascript" src="jquery.popup.js"></script>
    <link rel="stylesheet" href="jquery.jOrgChart.css"/>
    <link rel="stylesheet" href="custom.css"/>
    
	<style type="text/css">
		
		.popup-container {
		    position: fixed;
		    z-index: 999;
		    background:white;
		    border: 1px solid #dadada;
		    border-radius: 5px;
		    font-family:sans-serif;
		    padding:  10px 20px;
		    -webkit-box-shadow: 3px 4px 20px 2px rgba(121,122,115,0.58);
			-moz-box-shadow: 3px 4px 20px 2px rgba(121,122,115,0.58);
			box-shadow: 3px 4px 20px 2px rgba(121,122,115,0.58);
		}

		.back-drop{
		    width: 100%;
		    position: absolute;
		    top: 0;
		    left: 0;
		    opacity: 0.2;
		    background: gray;
		    z-index: 900;
		}
		
		.popup-footer{
			margin: 10px 0; 
		}

		.popup-footer button{
			margin:  0 5px;
			float: left;
		}

		.inner-popup-content{
			color: black;
			font-size:15px;
		}
		.inner-popup-content table{
			margin: 5px;
		}
		.inner-popup-content table.has-spouse{
			display: none;
		}
		.tree-type-container{
			font-size: 22px;
			font-weight: bold;
			margin: 5px;
			color: gray;
		}
	</style>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$('.tree-type').change(function(){
					var _treeType=$('.tree-type:checked').val(),
					options= {
						TreeType:_treeType,
						nodeSelected:function(node){
							if(_treeType ==='Ancestor')
							{
								$('.ancestor-toolbox button').removeAttr('disabled');
								var childNode =node.data.childNodes;
								for(var i=0;childNode && i< childNode.length;i++)
								{
									childNode[i].type==='Father'? $('#add-father').attr('disabled','disabled') :  $('#add-mother').attr('disabled','disabled');
								}
							}

						}
					},
					tree = $('#custom-tree').familyTree(options);
					if(options.TreeType ==='Ancestor' )
					{
						$('.ancestor-toolbox').show();
						$('.descendant-toolbox').hide();
					}
					else
					{
						$('.descendant-toolbox').show();
						$('.ancestor-toolbox').hide();
					}

					$('#add-child').unbind('click').click(function(){
						tree.addChild();
					});

					$('#add-father').unbind('click').click(function(){
						tree.addChild('Father');
					});

					$('#add-mother').unbind('click').click(function(){
						tree.addChild('Mother');
					});

					$('.edit-node').unbind('click').click(function(){
						tree.editNode();
					});
				});
				$('.tree-type').change();
			});
		}(jQuery))
	</script>
	<div class='container'>
		<div class='tree-type-container'>
			<label style='cursor:pointer' for="rd-ancestor"><input type='radio' class='tree-type' name='tree-type' value='Ancestor' id='rd-ancestor' checked>Ancestor Tree</label>
			<label style='cursor:pointer' for="rd-descendant"><input type='radio' class='tree-type' name='tree-type' value='Descendant' id='rd-descendant'>Descendant Tree</label>
		</div>
		<div class="tool-box">
			<div class='ancestor-toolbox'>
				<button id="add-father">Add Father</button>
				<button id="add-mother">Add Mother</button>
				<button class="edit-node">Edit Node</button>
			</div>
			<div class='descendant-toolbox'>
				<button id="add-child">Add Child</button>
				<button class="edit-node">Edit Node</button>
			</div>
		</div>
		<div id="custom-tree" class="orgChart">
	   		
		</div>
	</div>