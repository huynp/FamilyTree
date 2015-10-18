<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_addtocart.php 6433 2012-09-12 15:08:50Z openglobal $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
if (isset($this->product->step_order_level))
	$step=$this->product->step_order_level;
else
	$step=1;
if($step==0)
	$step=1;
$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
?>

<script type='text/javascript'>  
  
  window.onload = initForm;
  window.onunload = function() {};
  var originalBackground = document.getElementById('PDP_Image').src;
  var select_TreeType = "";
  var id_TreeType = "";
  var id_BranchStyle = "";
  var id_IncludeRoots = "";
  var id_ShowLeaves = "";
  var id_Background = "";
  var id_FontColor = "";
  var id_BottomLeft = "";
  var id_BottomLeftText = "";
  var id_BottomRight = "";
  var id_BottomRightText = "";
  var id_Bottom = "";
  var id_BottomText = "";
  var id_InternetSearchText = "";
  var id_FriendFamilyText = "";
  var id_OtherWebSiteNameText = "";
  var id_Frame = "";
  var id_Plexiglass = "";
  var selectedForm = ""; 
  
  function showPopup(contentElem){
	var $ = jQuery;
	var padding=60;
	var popupWidth = $(window).width()-padding;
	var popupHeight = $(window).height()-padding;
	//Update popup width/height
	popupWidth = popupWidth>750? 750:popupWidth;
	popupHeight = popupHeight>550? 550:popupHeight;
	SqueezeBox.options.size={x:popupWidth,y:popupHeight}
	SqueezeBox.setContent('adopt',contentElem);
	//Reset overlay width/height
	$("#sbox-overlay").css({"width":$(document).width(),"height":$(document).height()})
  }

  String.format = function() {
      var s = arguments[0];
      for (var i = 0; i < arguments.length - 1; i++) {       
          var reg = new RegExp("\\{" + i + "\\}", "gm");             
          s = s.replace(reg, arguments[i + 1]);
      }
      return s;
  }

  function initForm() {
    // Last characters of first index in selection box define mandatory status.
    var mandatory = "...";
	var bkgrnd = 1;
	var textCounter = 1;
	var titles = document.getElementsByClassName('product-fields-title');
    var elements = document.getElementsByClassName('product-field-display');
	
	// Find asterisks and make them red and hide text input
	if (titles.length > 0) {
	  var j = 0;
      var ids = new Array();
	  var others = new Array();
	  for (var i = 0; i < titles.length; i++) {
		  var text = titles[i].innerHTML;
		  //add "asterisk" class to turn them red
		  titles[i].innerHTML = titles[i].innerHTML.replace(/\*/g, '<span id="asterisk_'+i+'" class="asterisk">* </span>');

			  //find fields with words "text" and add class "user_input_text"
		  
		  //if(titles[i].innerHTML.indexOf("Text") > -1) {
		  //	titles[i].innerHTML = '<span class="user_input_text">'+titles[i].innerHTML+'</span>';
		  //}
	 }
	}

    // Find mandatory fields
    if (elements.length > 0) {
      var j = 0;
	  var k = 0;
      var ids = new Array();
      for (var i = 0; i < elements.length; i++) {
        var text = elements[i].innerHTML;
        //var x = text.search("customPrice");
        //var y = text.search("name=");
        //var id = text.substr(x,y - x - 2);
		var id = text.match(/(customPrice)\w+/g);
		var pluginName = text.match(/customPlugin\[(.*?)\]\[textinput\]\[comment\]/g);
		if(pluginName != null) {
			elem = document.getElementsByName(pluginName)[0];
			if(elem != null) {
				pluginID = text.match(/customPlugin\[(.*?)\]/g);
				elem.setAttribute("id", pluginID);
				if(textCounter == 1) {
					id_BottomLeftText = pluginID;
				}
				else if(textCounter == 2) {
					id_BottomRightText = pluginID;
				}
				else if(textCounter == 3) {
					id_BottomText = pluginID;
				}
				else if(textCounter == 4) {
					id_InternetSearchText = pluginID;
				}
				else if(textCounter == 5) {
					id_FriendFamilyText = pluginID;
				}
				else if(textCounter == 6) {
					id_OtherWebSiteNameText = pluginID;
				}
				textCounter = textCounter + 1;
			}
		}
		if (id != '' && id != null) {
			var index = document.getElementById(id).options[0].text;
			if (index.substr(index.length - mandatory.length,mandatory.length) == mandatory) {
			  ids[j] = id;
			  j++;
			}
			else {
			  others[k] = id;
			  k++;		
			}
		}
      }
      
      // Set the color of MANDATORY fields and add functions to each select form field
      var j = 0;
      for (var i = 0; i < ids.length; i++) {
        var option2 = document.getElementById(ids[i]).options[1].text;
		
		//Generations
		if (option2.indexOf(" - ") > -1) {
		  document.getElementById(ids[i]).setAttribute("onchange", "initForm(); choose_Tree_Type(this.options[this.selectedIndex].text,this.id);");
		  //document.getElementById(ids[i]).setAttribute("onchange", "initForm();");
		  id_TreeType = ids[i];
		}
		//Branch Style
		else if (option2 == "Style 1") {
		  document.getElementById(ids[i]).setAttribute("onchange", "initForm();");  
		  document.getElementById(ids[i]).setAttribute("onmousedown", "return show_styles(this.id);");
		  id_BranchStyle = ids[i];
		}
		//Include Roots
		else if (option2 == "No Roots") {
		  document.getElementById(ids[i]).setAttribute("onchange", "initForm();");  
		  document.getElementById(ids[i]).setAttribute("onmousedown", "return show_roots(this.id);");
		  id_IncludeRoots = ids[i];
		}
		//Show Leaves
		else if (option2 == "No Leaves") {
		  document.getElementById(ids[i]).setAttribute("onchange", "initForm();");  
		  document.getElementById(ids[i]).setAttribute("onmousedown", "return show_leaves(this.id);");
		  id_ShowLeaves = ids[i];
		}
		//Background
		else if (option2 == 1) {
		  document.getElementById(ids[i]).setAttribute("onchange", "initForm();");  
		  document.getElementById(ids[i]).setAttribute("onmousedown", "return show_backgrounds(this.id);");
		  id_Background = ids[i];
		}
		//Font Color
		else if (option2 == "Black") {
		  document.getElementById(ids[i]).setAttribute("onchange", "initForm(); changeFontColor(this.options[this.selectedIndex].text);");
		  id_FontColor = ids[i];
		}
		//Print Size
		else if (option2 == "8x10") {
	      document.getElementById(ids[i]).setAttribute("onchange", "changePrintSize();");  
	      id_PrintSize = ids[i];
		}
		//Frame
		else if (option2.indexOf("Black 11x14") > -1) {
		  document.getElementById(ids[i]).setAttribute("onchange", "initForm();");
		  document.getElementById(ids[i]).setAttribute("onmousedown", "return show_frames(this.id);");
		  id_Frame = ids[i];
		}
		//Referred By
		else if (option2 == "Internet Search") {
			document.getElementById(ids[i]).setAttribute("onchange", "checkReferredBy(this.value);");
			id_ReferredBy = ids[i];	
		}
		//Just Initiazlize Form
		else {
          document.getElementById(ids[i]).setAttribute("onchange", "initForm()");
		}
		
        //set border color to red if "..." is contained in the first option of the select form field
        if (document.getElementById(ids[i]).selectedIndex == 0) {
          document.getElementById(ids[i]).style.borderColor="#FF0000";
          j++;
        } else {
          document.getElementById(ids[i]).style.borderColor="#AAAAAA";
        }
      }
      
      // Disable or enable send button
      if (j != 0) {
        document.getElementsByName("addtocart")[0].disabled = true;
		document.getElementsByName("addtocart")[0].setAttribute("style", "background-color:#CCC !important;");
      } else { 
    	var catTitle = document.getElementById('CategoryProductTitle').innerHTML;
		/*
		if(catTitle.indexOf('Ancestor Trees') > -1 || catTitle.indexOf('Descendant Trees') > -1) {
			show_attachForm();
		}
		*/
  	    document.getElementsByName("addtocart")[0].setAttribute("style", "background-color:#709A00;");
        document.getElementsByName("addtocart")[0].disabled = false;
      }
	  
	  //For NON-MANDATORY fields add functions to each select form field
      for (var i = 0; i < others.length; i++) {
        if(typeof document.getElementById(others[i]).options[1] !== "undefined" && document.getElementById(others[i]).options[1] !== null) {
			var option2 = document.getElementById(others[i]).options[1].text;
		}
		else {
			var option2 = "Nothing";
		}
		var fieldClass = document.getElementById(others[i]).getAttribute('class');
		//Bottom Left
		if (option2 == "Bottom Left Option 1") {
		  document.getElementById(others[i]).setAttribute("onchange", "initForm();");  
		  document.getElementById(others[i]).setAttribute("onmousedown", "return show_bottomleft(this.id);");
		  id_BottomLeft = others[i];
		}
		//Bottom Right
		else if (option2 == "Bottom Right Option 1") {
		  document.getElementById(others[i]).setAttribute("onchange", "initForm();");  
		  document.getElementById(others[i]).setAttribute("onmousedown", "return show_bottomright(this.id);");
		  id_BottomRight = others[i];
		}
		//Bottom
		else if (option2 == "Bottom Option 1") {
		  document.getElementById(others[i]).setAttribute("onchange", "initForm();");  
		  document.getElementById(others[i]).setAttribute("onmousedown", "return show_bottom(this.id);");
		  id_Bottom = others[i];
		}
		//Acrylic Plexiglass
		else if (option2.indexOf("Yes - 8x10") > -1) {
		  document.getElementById(others[i]).setAttribute("onchange", "initForm();");
		  document.getElementById(others[i]).setAttribute("onmousedown", "return show_plexiglass(this.id);");
		  id_Plexiglass = others[i];
		}
		else { }
	  }
    }
  }
  
  function closeWindow() {
	SqueezeBox.close();
  }
      
  function checkSelected(num) {
	//check generations
	if(num >= 1) {
		if(select_TreeType == "") {
			alert("Please select your \"Generations\" first.");
			document.getElementById(id_TreeType).style.backgroundColor = "#f9a8a8";			
			return false;
		}
		else {
			if(num == 1) {
				return true;
			}
			else {
			}
		}
	}
	//check branch style
	if(num >= 2) {
		sel = document.getElementById(id_BranchStyle).selectedIndex;
		if(sel == "0") {
			alert("Please select your \"Branch Style\" first.");
			document.getElementById(id_BranchStyle).style.backgroundColor = "#f9a8a8";
			return false;
		}
		else {
			if(num == 2) {
				return true;
			}
			else {
			}
		}
	}
	//check roots
	if(num >= 3) {
		sel = document.getElementById(id_IncludeRoots).selectedIndex;
		if(sel == "0") {
			alert("Please choose if you want to \"Include Roots\" first.");
			document.getElementById(id_IncludeRoots).style.backgroundColor = "#f9a8a8";
			return false;
		}
		else {
			if(num == 3) {
				return true;
			}
			else {
			}
		}
	}
	//check font color
	if(num >= 4) {
		sel = document.getElementById(id_FontColor).selectedIndex;
		if(sel == "0") {
			alert("Please select your \"Font Color\" first.");
			document.getElementById(id_FontColor).style.backgroundColor = "#f9a8a8";
			return false;
		}
		else {
			if(num == 4) {
				return true;
			}
			else {
			}
		}
	}
  }

  function show_attachForm() {  
	  var addToCartBtn = document.getElementsByName("addtocart");
	  var deleteFileBtn = document.getElementById('deletefilebtn');
	  
	  if(deleteFileBtn == null) {

		  SqueezeBox.initialize({
			  size: {x: 700, y: 550}
			});
		  //SqueezeBox.resize({x: 700, y: 550})
			
		  var newElem = new Element( 'div' );
		  /*newElem.setStyle('border', 'solid 1px #CCC');*/ 
		  //newElem.setStyle('width', '675px');
		  //newElem.setStyle('height', '525px');
		  newElem.setStyle('padding', '10px');   
		  newElem.setStyle('text-align', 'center');
			
		  var spn = document.createElement("span");
		  
		  spn.innerHTML = "<center><table class=\"background_table\" style='height:445px;'><tbody>" +
						  "<tr style='font-size:16px'><td>If you've finished customizing your tree it's now time to attach your completed form: " +
						  "<b><a href='/forms/"+selectedForm+".xlsx'><u>" + selectedForm + "</u></a></b>" +
						  "<br />Please attach it now by doing the following:</td>" +
						  "</tr><tr>" +
						  "<td style='text-align:left; padding:0px 20px; font-weight:bold;'><br /><br />1. Close this instruction window.<br /><br />" +
						  	  "2. Click on the green 'Click Here to Upload Completed Form' button near the bottom of the page.<br /><br />" +
						      "3. Browse to where you've saved your completed form and select it.<br /><br />" +
							  "4. Click the 'Start' button to upload and attach the file.<br /><br />" +
							  "5. Click 'Add to Cart'.</td>" +
						  "</tr><tr>" +
						  "<td style='text-align:left; padding:0px 20px;'>" +
						  "<br />Or, if your form isn't complete yet, you can still place your order. " +
						  "Just do the following instead of attaching your completed form to this order:<br /><br />" +
						  	  "-Check out and pay for your customized tree.<br />" +
						  	  "-After you've paid, send an email with your completed form to order@customfamilytreeart.com.<br />" +
							  "-Make sure to reference the order number you'll receive in your order confirmation email.<br /><br />" +
							  "<a href=# onClick='SqueezeBox.close();'><u>Continue...</u></a></td>" +
						  "</tr></tbody></table></center>";
		  
		  newElem.appendChild(spn);
			
		  showPopup(newElem);
	  }
  }
 
  
  function choose_Tree_Type(txt,id) {   
      selectedForm = txt;
	  select_TreeType = id;
	  document.getElementById(id_TreeType).style.borderWidth = "1px";
      selIndex = document.getElementById(id).selectedIndex;
	  if (txt.indexOf("Select One ...") > -1) {
	  	select_TreeType = "";
		document.getElementById('PDP_Image').src = originalBackground;
		document.getElementById('main-image').style.backgroundImage = "";
		thisForm = document.getElementById(id).form;
		thisForm.reset();
		setLeaves("Select One");
		setBottomLeft(0,id_BottomLeft);
		setBottomRight(0,id_BottomRight);
		setBottom(0,id_Bottom);
		initForm();
      }
	  /*else if (txt.indexOf("Descendant - 5 Generation") > -1) {
	  	var options = {size: {x: 300, y: 195}};
		SqueezeBox.initialize(options);
		//SqueezeBox.resize({x: 300, y: 195})
		var newElem = document.createElement("span");
		
		newElem.innerHTML = "<center><table><tbody>" +
		                    "<tr>" +
			                "<td>For 5+ generation trees you'll need to submit a request through the contact us page.<br /><br >" +
							    "Include 'Descendant 5 Generation Request' in the subject line.<br /><br />" +
							    "<a href='/index.php/contact-us'><u>Click here to go to that form.</u></a></td>" +
		                    "</tr></tbody></table></center>"; 
		
	    showPopup(newElem);
		
		thisForm = document.getElementById(id).form;
		thisForm.reset();
		initForm();
	  }*/
	  else { 
		/*
		SqueezeBox.initialize({
          size: {x: 700, y: 585}
        });
		
	    var newElem = new Element( 'div' );
	    //newElem.setStyle('width', '675px');
	    //newElem.setStyle('height', '560px');
	    newElem.setStyle('padding', '10px');
		newElem.setStyle('text-align', 'center');
        
		var anchr = document.createElement("a");
		
		var n = txt.indexOf('+');
		var location = txt.substring(0, n != -1 ? n : txt.length);
		location = location.trim();

		anchr.setAttribute("href", "/forms/" + location);
		anchr.setStyle('text-decoration', 'underline');
		anchr.setStyle('font-size', '16px');
		anchr.innerHTML = "Download:  " + txt + " Form";   
		
		var newElem = document.createElement("span");
		
		newElem.innerHTML = "<center><table style='width: 667px; height: 740px;'><tbody>" +
		                    "<tr style=\"width: 667px; height: 190px;\">" +
			                "<td valign='middle' style='width: 270px; background: url(\"/images/Step_1.png\") no-repeat left center;'>&nbsp;</td>" +
			                "<td valign='middle' style='padding: 22px 30px 38px 30px;' valign='top'><span style='font-weight: bold; color: #ff4b26; font-size: 30px;'>Step 1</span>" +
							                                             "<br /><a href='/forms/"+location+".xlsx'><u><b>CLICK HERE</b></u></a> to download the form for the Generations you've selected.<br /><i>("+txt+")</i></td>" +
		                    "</tr><tr style=\"width: 667px; height: 190px;\">" +
			                "<td valign='middle' style='width: 270px; background: url(\"/images/Step_2.png\") no-repeat left center;'>&nbsp;</td>" +
			                "<td valign='middle' style='padding: 22px 30px 38px 30px;' valign='top'><span style='font-weight: bold; color: #a2c404; font-size: 30px;'>Step 2</span>" +
							                                              "<br />Fill out the form you downloaded.<br />Enter your family member's names.</td>" +
							"</tr><tr style=\"width: 667px; height: 190px;\">" +
			                "<td valign='middle' style='width: 270px; background: url(\"/images/Step_3.png\") no-repeat left center;'>&nbsp;</td>" +
			                "<td valign='middle' style='padding: 22px 30px 38px 30px;' valign='top'><span style='font-weight: bold; color: #378bc3; font-size: 30px;'>Step 3</span>" +
							                                              "<br />Customize your tree and then upload your completed form to this order." +
																		  "<br /><a href=# onClick='SqueezeBox.close();'><u>Continue...</u></a></td>" +
		                    "</tr></tbody></table></center>";
		
	    showPopup(newElem);
		*/
				
		document.getElementById('PDP_Image').src = originalBackground;
		
		thisForm = document.getElementById(id).form;
		thisForm.reset();
		setLeaves("Select One");
		setBottomLeft(0,id_BottomLeft);
		setBottomRight(0,id_BottomRight);
		setBottom(0,id_Bottom); 
		document.getElementById(id_BottomLeftText).value = "None";
		document.getElementById(id_BottomRightText).value = "None";
		document.getElementById(id_BottomText).value = "None";
		document.getElementById(id).selectedIndex = selIndex;
		document.getElementById(id_TreeType).style.backgroundColor = "#ffffff";
		initForm();
		updatePrice();      
	  }
  }
  
  function show_styles(id) {
	  if(checkSelected(1)) {
		  var selected = selectedTreeType(1)
		  var selected = "/images/products/" + selected;
		  SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
		  //SqueezeBox.resize({x: 600, y: 450})
			
		  var newElem = new Element( 'div' );
		  /*newElem.setStyle('border', 'solid 1px #CCC');*/ 
		  //newElem.setStyle('width', 'auto'); 
		  //newElem.setStyle('height', '425px');
		  newElem.setStyle('padding', '10px');   
		  newElem.setStyle('text-align', 'center');
			
		  var spn = document.createElement("span");
		  
		  if(selected.indexOf('Couple') > -1) {
			  spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
							  "<td><b>Branch Style 1:</b><br />Parents form the 2 main branches</td>" +
							  "<td><b>Branch Style 2:</b><br />Parents form the 4 main branches</td>" +   
							  "</tr><tr>" +
							  "<td align='center'><img id='Style_1' class='imageHover' onclick='setBranch(this.id);' src='"+selected+"_Style 1.png' width='250' alt='Style 1' /></td>" +
							  "<td align='center'><img id='Style_2' class='imageHover' onclick='setBranch(this.id);' src='"+selected+"_Style 2.png' width='250' alt='Style 2' /></td>" +
							  "</tr></tbody></table></center>";
		  }
		  else if(selected.indexOf('Descendant') > -1) {
		  	  spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
							  "<td><b>Branch Style 1:</b><br />Branches curve downward</td>" +
							  "<td><b>Branch Style 2:</b><br />Branches curve upward</td>" +   
							  "</tr><tr>" +
							  "<td align='center'><img id='Style_1' class='imageHover' onclick='setBranch(this.id);' src='"+selected+"_Style 1.png' width='250' alt='Style 1' /></td>" +
							  "<td align='center'><img id='Style_2' class='imageHover' onclick='setBranch(this.id);' src='"+selected+"_Style 2.png' width='250' alt='Style 2' /></td>" +
							  "</tr></tbody></table></center>";
		  }
		  else {
			  spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
							  "<td><b>Style 1:</b><br />Parents form the 2 main branches<br /><i>(Only style available for individual generations)</i></td>" +
							  "</tr><tr>" +
							  "<td align='center'><img id='Style_1' class='imageHover' onclick='setBranch(this.id);' src='"+selected+"_Style 1.png' width='250' alt='Style 1' /></td>" +
							  "</tr></tbody></table></center>";
		  }
		  
		  newElem.appendChild(spn);
			
		  showPopup(newElem);
		  return false;
		  }
  }
  
  function setBranch(imgID) {	
	if(imgID == "Style_1") {
		document.getElementById(id_BranchStyle).selectedIndex = 1;
	}
	else if(imgID == "Style_2") {
		document.getElementById(id_BranchStyle).selectedIndex = 2;
	}
	
	document.getElementById('PDP_Image').src = createTreeImage(selectedTreeType());
	document.getElementById(id_BranchStyle).style.backgroundColor = "#ffffff";
	jQuery("#img_boder").show();
	initForm();
	closeWindow(); 
	//SqueezeBox.close();  
  }
  
  function show_roots(id) {
	  if(checkSelected(2)) {
		  var selected = selectedTreeType(2)
		  var selected = "/images/products/" + selected;  
		  SqueezeBox.initialize({
			  size: {x: 600, y: 450}
			});
		  //SqueezeBox.resize({x: 600, y: 450})
			
		  var newElem = new Element( 'div' );
		  /*newElem.setStyle('border', 'solid 1px #CCC');*/ 
		  //newElem.setStyle('width', '575px');
		  //newElem.setStyle('height', '425px');
		  newElem.setStyle('padding', '10px');   
		  newElem.setStyle('text-align', 'center');
			
		  var spn = document.createElement("span");
		  
		  if(selected.indexOf('Descendant') > -1) {
		  	  spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
							  "<td><b>No Roots:</b><br />Descendants are the branches.</td>" +
							  "<td><b>Yes Roots (+ $10.00):</b><br />Descendants are the branches.<br />Ancestors are the roots.</td>" +
							  "</tr><tr>" +
							  "<td align='center'><img id='No_Roots' class='imageHover' onclick='setRoots(this.id);' src='"+selected+"_NoRoots.png' width='250' alt='No Roots' /></td>" +
							  "<td align='center'><img id='Yes_Roots' class='imageHover' onclick='setRoots(this.id);' src='"+selected+"_Roots.png' width='250' alt='Yes Roots' /></td>" +
							  "</tr></tbody></table></center>";
		  }
		  else {
			  spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
							  "<td><b>No Roots:</b><br />Ancestors are the branches.</td>" + 
							  "<td><b>Yes Roots (+ $10.00):</b><br />Ancestors are the branches.<br />Descendants are the roots</td>" +
							  "</tr><tr>" +
							  "<td align='center'><img id='No_Roots' class='imageHover' onclick='setRoots(this.id);' src='"+selected+"_NoRoots.png' width='250' alt='No Roots' /></td>" +
							  "<td align='center'><img id='Yes_Roots' class='imageHover' onclick='setRoots(this.id);' src='"+selected+"_Roots.png' width='250' alt='Yes Roots' /></td>" +
							  "</tr></tbody></table></center>";
		  }
		  
		  newElem.appendChild(spn);
			
		  showPopup(newElem);
		  return false;
	}
  }

  function setRoots(imgID) {
	var roots = "";
	if(imgID == "No_Roots") {
		document.getElementById(id_IncludeRoots).selectedIndex = 1;
	}
	else if(imgID == "Yes_Roots") {
		document.getElementById(id_IncludeRoots).selectedIndex = 2;
	}
	
	document.getElementById('PDP_Image').src = createTreeImage(selectedTreeType());

	//update leaves if they've already been set
	var leaves = document.getElementById(id_ShowLeaves);
	if(leaves.selectedIndex > 0) {
		setLeaves(document.getElementById(id_ShowLeaves).selectedIndex.text);
	}
	
	document.getElementById(id_IncludeRoots).style.backgroundColor = "#ffffff";
	initForm();
	SqueezeBox.close();  
	updatePrice();
  }
  
  function show_leaves(id) {
	  if(checkSelected(1)) {
		  var selected = selectedTreeType(3)
		  var selected = "/images/products/" + selected;
		  
		  SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
		  //SqueezeBox.resize({x: 600, y: 415})
			
		  var newElem = new Element( 'div' );
		  /*newElem.setStyle('border', 'solid 1px #CCC');*/ 
		  //newElem.setStyle('width', '575px');
		  //newElem.setStyle('height', '390px');
		  newElem.setStyle('padding', '10px');   
		  newElem.setStyle('text-align', 'center');
		
		  var spn = document.createElement("span");
		  
		  spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
						  "<td><b>No Leaves:</b><br /></td>" +
						  "<td><b>Yes Leaves (+ $10.00):</b><br /></td>" +
						  "</tr><tr>" +
						  "<td align='center'><img id='No Leaves' class='imageHover' onclick='setLeaves(this.id);' src='"+selected+".png' width='250' alt='No Leaves' /></td>" +
						  "<td align='center'><img id='Yes Leaves' class='imageHover' onclick='setLeaves(this.id);' src='"+selected+"_Leaves_Small.png' width='250' alt='Yes Leaves' /></td>" + 
						  "</tr></tbody></table></center>"; 
		  
		  newElem.appendChild(spn);
			
		  showPopup(newElem);
		  }
	  return false;
	  
  }

  function setLeaves(imgID) {
	var index = 1;
	var selected = "";
	if(imgID == "No Leaves") {
    	index = 1;
		leaves = "/images/products/Leaves_None.png";
		selected = leaves;
	}
	else if(imgID == "Yes Leaves") {
		index = 2;
		leaves = "_Leaves";
		selected = createTreeImage(selectedTreeType(3) + leaves);
	}
	else {
		index = 0;
		leaves = "/images/products/Leaves_None.png";
		selected = leaves;
	}
	
	document.getElementById(id_ShowLeaves).selectedIndex = index;
	document.getElementById('img_Leaves').innerHTML = "<img class='img_Leaves' alt='' id='leaves' src='"+selected+"'>";
	  
	initForm();
	SqueezeBox.close();
	updatePrice();  
  }
  
  function setBackground(id,field) {
	document.getElementById('img_Background').innerHTML = "<img id='backgrounds' alt='' src='/images/products/backgrounds/"+id+".png'>";     
	
	index = id.replace(/\D/g,'');
	document.getElementById(field).selectedIndex = index;
	initForm();
	SqueezeBox.close();  
  }
  
  function show_bottomleft(id) {
	  if(checkSelected(4)) {
		  var selected = selectedTreeType(3);
		  SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
			//SqueezeBox.resize({x: 1150, y: 740})
			
			var newElem = new Element( 'div' );
			/*newElem.setStyle('border', 'solid 1px #CCC');*/ 
			//newElem.setStyle('width', '1508px');
			//newElem.setStyle('height', '700px');
			newElem.setStyle('padding', '10px');   
			newElem.setStyle('text-align', 'center');
			
			var spn = document.createElement("span");
			spn.innerHTML =  String.format("<div class='box-option'>\
					<div>\
						<b>Bottom Left Option 1:</b><br />Family Name & Established Date<br />Font Style 1\
					</div>\
					<div>\
						<img id='BottomLeft_Option1' class='image_border' width='350' src='/images/products/{0}_Bottom Left Option 1.png' alt='BottomLeftOption1' />\
					</div>\
					<div>\
						Enter your family name and<br />year established here.<br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomLeftOption1'><br />\
						<input type='button' value='Select Option 1' onclick='setBottomLeft(1,\"BottomLeftOption1\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Left Option 2:</b><br />Family Name & Established Date<br />Font Style 2\
					</div>\
					<div>\
						<img id='BottomLeft_Option2' class='image_border' width='350' src='/images/products/{0}_Bottom Left Option 2.png' alt='BottomLeftOption2' />\
					</div>\
					<div>\
						Enter your family name and<br />year established here.<br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomLeftOption2'><br />\
						<input type='button' value='Select Option 2' onclick='setBottomLeft(2,\"BottomLeftOption2\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Left Option 3:</b><br />Family Name & Established Date<br />Font Style 3\
					</div>\
					<div>\
						<img id='BottomLeft_Option3' class='image_border' width='350' src='/images/products/{0}_Bottom Left Option 3.png' alt='BottomLeftOption3' />\
					</div>\
					<div>\
						Enter your family name and<br />year established here.<br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomLeftOption3'><br />\
						<input type='button' value='Select Option 3' onclick='setBottomLeft(3,\"BottomLeftOption3\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Left Option Empty:</b><br />Family Name & Established Date<br />None\
					</div>\
					<div>\
						<img id='BottomLeft_OptionNone' class='image_border' width='350' src='/images/products/{0}.png' alt='BottomLeftOption3' />\
					</div>\
					<div>\
						<br />\
						<input type='button' value='Select Empty' id='BottomLeftNone' onclick='setBottomLeft(0,\"BottomLeftNone\");'>\
					</div>\
				</div>",selected);
			newElem.appendChild(spn);
			
			showPopup(newElem);
	  }
	  return false;
  }
  
  function setBottomLeft(num,id) {
	  field = document.getElementById(id);
	  if(field.value == "" || field.value == " ") {
		  alert("Please enter your family name and established date in the field above the option you selected");
	  }
	  else {
		  if(num > 0) {
		  	img = createTreeImage(selectedTreeType(4) + "_Bottom Left Option " + num);
			document.getElementById('img_BottomLeft').innerHTML = "<img class='img_BottomLeft' alt='' id='bottomleft' src='"+img+"'>";
		  }
		  else {
		  	document.getElementById('img_BottomLeft').innerHTML = "";
		  }
		  
		  document.getElementById(id_BottomLeft).selectedIndex = num;
		  document.getElementById(id_BottomLeftText).value = field.value;
		  parnt = document.getElementById(id_BottomLeftText).parentNode; 
		  grand = parnt.parentNode;
		  great = grand.parentNode;
		  if(num > 0) {
		  	great.setAttribute("style", "display:inline !important");
		  }
		  else { 
			great.setAttribute("style", "display:none !important");  
		  }
		  initForm();
		  SqueezeBox.close();  
	  }
  }
  
  function show_bottomright(id) {
	  if(checkSelected(4)) {
		  var selected = selectedTreeType(3);
		  SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
			//SqueezeBox.resize({x: 1150, y: 700})
			
			var newElem = new Element( 'div' );
			newElem.setStyle('padding', '10px');   
			newElem.setStyle('text-align', 'center');
			
			var spn = document.createElement("span");
			spn.innerHTML = String.format("<div class='box-option'>\
					<div>\
						<b>Bottom Right Option 1:</b><br />Quote or Occasion<br />Font Style 1\
					</div>\
					<div>\
						<img id='BottomRight_Option1' class='image_border' width='350' src='/images/products/{0}_Bottom Right Option 1.png' alt='BottomRightOption1' />\
					</div>\
					<div>\
						Enter your quote<br />or occassion here.<br />\
						<a href=\"/index.php/our-products/quote-ideas\" target=\"_blank\"><u>Click here for quote ideas.</u></a><br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomRightOption1'><br />\
						<input type='button' value='Select Option 1' onclick='setBottomRight(1,\"BottomRightOption1\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Right Option 2:</b><br />Quote or Occasion<br />Font Style 2\
					</div>\
					<div>\
						<img id='BottomRight_Option2' class='image_border' width='350' src='/images/products/{0}_Bottom Right Option 2.png' alt='BottomRightOption2' />\
					</div>\
					<div>\
						Enter your quote<br />or occassion here.<br />\
						<a href=\"/index.php/our-products/quote-ideas\" target=\"_blank\"><u>Click here for quote ideas.</u></a><br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomRightOption2'><br />\
						<input type='button' value='Select Option 2' onclick='setBottomRight(2,\"BottomRightOption2\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Right Option Empty:</b><br />Quote or Occasion<br />None\
					</div>\
					<div>\
						<img id='BottomRight_OptionNone' class='image_border' width='350' src='/images/products/{0}.png' alt='BottomRightOption3' />\
					</div>\
					<div>\
						<br />\
						<input type='button' value='Select Empty' id='BottomRightNone' onclick='setBottomRight(0,\"BottomRightNone\");'>\
					</div>\
				</div>",selected);
			newElem.appendChild(spn);
			showPopup(newElem);
	  }
	  return false;
  }
  
    function setBottomRight(num,id) {
    	debugger;
	  field = document.getElementById(id);
	  if(field.value == "" || field.value == " ") {
		  alert("Please enter your quote or occassion in the field above the option you selected");
	  }
	  else {
		  if(num > 0) {
			img = createTreeImage(selectedTreeType(4) + "_Bottom Right Option " + num);
		  	document.getElementById('img_BottomRight').innerHTML = "<img class='img_BottomRight' alt='' id='BottomRight' src='"+img+"'>";
		  }
		  else {
			document.getElementById('img_BottomRight').innerHTML = "";
		  }
		  
		  document.getElementById(id_BottomRight).selectedIndex = num;
		  document.getElementById(id_BottomRightText).value = field.value;
		  parnt = document.getElementById(id_BottomRightText).parentNode; 
		  grand = parnt.parentNode;
		  great = grand.parentNode;
		  if(num > 0) {
		  	great.setAttribute("style", "display:inline !important");
		  }
		  else {
			great.setAttribute("style", "display:none !important");  
		  }
		  initForm();
		  SqueezeBox.close();  
	  }
  }
  
  function show_bottom(id) {
  		debugger;
	  if(checkSelected(4)) {
		  var selected = selectedTreeType(3);
		  SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
			//SqueezeBox.resize({x: 850, y: 725})
			
			var newElem = new Element( 'div' );
			/*newElem.setStyle('border', 'solid 1px #CCC');*/ 
			//newElem.setStyle('width', '825px');
			//newElem.setStyle('height', '700px');
			newElem.setStyle('padding', '10px');   
			newElem.setStyle('text-align', 'center');
			
			var roots = document.getElementById(id_IncludeRoots);
	  		roots = roots.options[roots.selectedIndex].text; 
			var spn = document.createElement("span");
			if(roots.indexOf("Yes") > -1) {
				spn.innerHTML = String.format("<div class='box-option'>\
					<div>\
						<b>Bottom Option 1:</b><br />Quote, Occasion, Family Name, Scripture, or Title Name and Established Date<br />Font Style 1\
					</div>\
					<div>\
						<img id='BottomRight_Option1' class='image_border' width='350' src='/images/products/{0}_Bottom Option 1.png' alt='BottomOption1' />\
					</div>\
					<div>\
						Enter your desired<br />\"ground\" text here.<br />\
						<a href=\"/index.php/our-products/quote-ideas\" target=\"_blank\"><u>Click here for quote ideas.</u></a><br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomOption1'><br />\
						<input type='button' value='Select Option 1' onclick='setBottom(1,\"BottomOption1\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Option 2:</b><br />Quote, Occasion, Family Name, Scripture, or Title Name and Established Date<br />None\
					</div>\
					<div>\
						<img id='BottomRight_Option1' class='image_border' width='350' src='/images/products/{0}.png' alt='BottomOption1' />\
					</div>\
					<div>\
						<br />\
						<input type='button' value='Select Empty'  id='BottomNone'  onclick='setBottom(0,\"BottomNone\");'>\
					</div>\
				</div>",selected);
			}
			else {

				spn.innerHTML = String.format("<div class='box-option'>\
					<div>\
						<b>Bottom Option 1:</b><br />Quote, Occasion, Family Name, Scripture, or Title Name and Established Date<br />Font Style 1\
					</div>\
					<div>\
						<img id='BottomRight_Option1' class='image_border' width='350' src='/images/products/{0}_Bottom Option 1.png' alt='BottomOption1' />\
					</div>\
					<div>\
						Enter your desired<br />\"ground\" text here.<br />\
						<a href=\"/index.php/our-products/quote-ideas\" target=\"_blank\"><u>Click here for quote ideas.</u></a><br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomOption1'><br />\
						<input type='button' value='Select Option 1' onclick='setBottom(1,\"BottomOption1\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Option 2:</b><br />Quote, Occasion, Family Name, Scripture, or Title Name and Established Date<br />Font Style 2\
					</div>\
					<div>\
						<img id='BottomRight_Option2' class='image_border' width='350' src='/images/products/{0}_Bottom Option 2.png' alt='BottomOption2' />\
					</div>\
					<div>\
						Enter your desired<br />\"ground\" text here.<br />\
						<a href=\"/index.php/our-products/quote-ideas\" target=\"_blank\"><u>Click here for quote ideas.</u></a><br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomOption2'><br />\
						<input type='button' value='Select Option 2' onclick='setBottom(2,\"BottomOption2\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Option 3:</b><br />Quote, Occasion, Family Name, Scripture, or Title Name and Established Date<br />Font Style 3\
					</div>\
					<div>\
						<img id='BottomRight_Option3' class='image_border' width='350' src='/images/products/{0}_Bottom Option 3.png' alt='BottomOption3' />\
					</div>\
					<div>\
						Enter your desired<br />\"ground\" text here.<br />\
						<a href=\"/index.php/our-products/quote-ideas\" target=\"_blank\"><u>Click here for quote ideas.</u></a><br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomOption3'><br />\
						<input type='button' value='Select Option 3' onclick='setBottom(3,\"BottomOption3\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Option 4:</b><br />Quote, Occasion, Family Name, Scripture, or Title Name and Established Date<br />Font Style 4\
					</div>\
					<div>\
						<img id='BottomRight_Option4' class='image_border' width='450' src='/images/products/{0}_Bottom Option 4.png' alt='BottomOption4' />\
					</div>\
					<div>\
						Enter your desired<br />\"ground\" text here.<br />\
						<a href=\"/index.php/our-products/quote-ideas\" target=\"_blank\"><u>Click here for quote ideas.</u></a><br />\
					    <input class='input_three' style='text-align:center;' type='text' id='BottomOption4'><br />\
						<input type='button' value='Select Option 4' onclick='setBottom(4,\"BottomOption4\");'>\
					</div>\
				</div>\
				<div class='box-option'>\
					<div>\
						<b>Bottom Option 5:</b><br />Quote, Occasion, Family Name, Scripture, or Title Name and Established Date<br />None\
					</div>\
					<div>\
						<img id='BottomRight_Option1' class='image_border' width='350' src='/images/products/{0}.png' alt='BottomOption1' />\
					</div>\
					<div>\
						<br />\
						<input type='button'  id='BottomNone' value='Select Empty' onclick='setBottom(0,\"BottomNone\");'>\
					</div>\
				</div>",selected);
			}
			newElem.appendChild(spn);
			
			showPopup(newElem);
	  }
	  return false; 
  }
  
  function setBottom(num,id) {
	  field = document.getElementById(id);
	  if(field.value == "" || field.value == " ") {
		  alert("Please enter your desired \"ground\" text in the field above the option you selected");
	  }
	  else {
		  if(num > 0) {
			img = createTreeImage(selectedTreeType(4) + "_Bottom Option " + num);
		  	document.getElementById('img_Bottom').innerHTML = "<img class='img_Bottom' alt='' id='Bottom' src='"+img+"'>";
		  }
		  else {
		    document.getElementById('img_Bottom').innerHTML = "";
		  }
		  
		  document.getElementById(id_Bottom).selectedIndex = num;
		  document.getElementById(id_BottomText).value = field.value;
		  parnt = document.getElementById(id_BottomText).parentNode; 
		  grand = parnt.parentNode;
		  great = grand.parentNode;
		  if(num > 0) {
		  	great.setAttribute("style", "display:inline !important");
		  }
		  else {
			great.setAttribute("style", "display:none !important");  
		  }
		  initForm();
		  SqueezeBox.close();  
	  }
  }
  
  function checkReferredBy(val) {
	  var referredSelect = document.getElementById(id_ReferredBy);
      var referredText = referredSelect.options[referredSelect.selectedIndex].text;
	  parnt1 = document.getElementById(id_InternetSearchText).parentNode; 
	  grand1 = parnt1.parentNode;
	  great1 = grand1.parentNode;
	  parnt2 = document.getElementById(id_FriendFamilyText).parentNode; 
	  grand2 = parnt2.parentNode;
	  great2 = grand2.parentNode;
	  parnt3 = document.getElementById(id_OtherWebSiteNameText).parentNode; 
	  grand3 = parnt3.parentNode;
	  great3 = grand3.parentNode;
	  if(referredText == "Internet Search") {
		  great1.setAttribute("style", "display:inline !important");
		  great2.setAttribute("style", "display:none !important");
		  great3.setAttribute("style", "display:none !important");
	  }
	  else if(referredText == "Friend or Family") {
		  great2.setAttribute("style", "display:inline !important");
		  great1.setAttribute("style", "display:none !important");
		  great3.setAttribute("style", "display:none !important");
	  }
	  else if(referredText == "Other Web Site") {
		  great3.setAttribute("style", "display:inline !important");
		  great2.setAttribute("style", "display:none !important");
		  great1.setAttribute("style", "display:none !important");
	  }
	  else {
		  great1.setAttribute("style", "display:none !important");
		  great2.setAttribute("style", "display:none !important");
		  great3.setAttribute("style", "display:none !important");
	  }
	  initForm();
  }
  
  function show_backgrounds(id) {
	 if(checkSelected(3)) {
	    var roots = document.getElementById(id_IncludeRoots);
	  	roots = roots.options[roots.selectedIndex].text;
			
		if(roots.indexOf("Yes") > -1) {
			SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
			//SqueezeBox.resize({x: 600, y: 555})
			
			var newElem = new Element( 'div' );
			/*newElem.setStyle('border', 'solid 1px #CCC');*/ 
			//newElem.setStyle('width', '575px'); 
			//newElem.setStyle('height', '530px');
			newElem.setStyle('padding', '10px');    
			newElem.setStyle('text-align', 'center');
			
			var spn = document.createElement("span");
			spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
							"<td align='center'><img id='Background_1' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_1.png' alt='Background 1' />&nbsp;</td>" +
							"<td align='center'><img id='Background_2' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_2.png' alt='Background 2' />&nbsp;</td>" +
							"<td align='center'><img id='Background_3' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_3.png' alt='Background 3' />&nbsp;</td>" +
							"<td align='center'><img id='Background_4' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_4.png' alt='Background 4' />&nbsp;</td>" +
							"</tr><tr>" +
							"<td align='center'><img id='Background_5' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_5.png' alt='Background 5' />&nbsp;</td>" +
							"<td align='center'><img id='Background_6' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_6.png' alt='Background 6' />&nbsp;</td>" +
							"<td align='center'><img id='Background_7' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_7.png' alt='Background 7' />&nbsp;</td>" +
							"<td align='center'><img id='Background_8' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_8.png' alt='Background 8' />&nbsp;</td>" +
							"</tr><tr>" +
							"<td align='center'><img id='Background_9' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_9.png' alt='Background 9' />&nbsp;</td>" +
							"<td align='center'><img id='Background_10' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_10.png' alt='Background 10' />&nbsp;</td>" +
							"<td align='center'><img id='Background_11' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_11.png' alt='Background 11' />&nbsp;</td>" +
							"<td align='center'><img id='Background_12' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_12.png' alt='Background 12' />&nbsp;</td>" +
							"</tr><tr>" +
							"<td align='center'><img id='Background_13' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_13.png' alt='Background 13' />&nbsp;</td>" +
							"<td align='center'><img id='Background_14' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_14.png' alt='Background 14' />&nbsp;</td>" +
							"<td align='center'><img id='Background_15' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_15.png' alt='Background 15' />&nbsp;</td>" +
							"<td align='center'><img id='Background_16' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_16.png' alt='Background 16' />&nbsp;</td>" +
							"</tr><tr>" +
							"<td align='center'><img id='Background_17' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_17.png' alt='Background 17' />&nbsp;</td>" +
							"<td align='center'>&nbsp;</td>" +
							"<td align='center'>&nbsp;</td>" +
							"<td align='center'>&nbsp;</td>" +
							"</tr></tbody></table></center>";
		}
		else {
			SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
			//SqueezeBox.resize({x: 600, y: 450})
			
			var newElem = new Element( 'div' );
			/*newElem.setStyle('border', 'solid 1px #CCC');*/ 
			//newElem.setStyle('width', '575px');
			//newElem.setStyle('height', '425px');
			newElem.setStyle('padding', '10px');   
			newElem.setStyle('text-align', 'center');
			
			var spn = document.createElement("span");
			spn.innerHTML = "<center><table class=\"background_table\"><tbody><tr>" +
							"<td align='center'><img id='Background_1' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_1.png' alt='Background 1' />&nbsp;</td>" +
							"<td align='center'><img id='Background_2' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_2.png' alt='Background 2' />&nbsp;</td>" +
							"<td align='center'><img id='Background_3' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_3.png' alt='Background 3' />&nbsp;</td>" +
							"<td align='center'><img id='Background_4' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_4.png' alt='Background 4' />&nbsp;</td>" +
							"</tr><tr>" +
							"<td align='center'><img id='Background_5' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_5.png' alt='Background 5' />&nbsp;</td>" +
							"<td align='center'><img id='Background_6' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_6.png' alt='Background 6' />&nbsp;</td>" +
							"<td align='center'><img id='Background_7' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_7.png' alt='Background 7' />&nbsp;</td>" +
							"<td align='center'><img id='Background_8' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_8.png' alt='Background 8' />&nbsp;</td>" +
							"</tr><tr>" +
							"<td align='center'><img id='Background_9' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_9.png' alt='Background 9' />&nbsp;</td>" +
							"<td align='center'><img id='Background_10' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_10.png' alt='Background 10' />&nbsp;</td>" +
							"<td align='center'><img id='Background_11' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_11.png' alt='Background 11' />&nbsp;</td>" +
							"<td align='center'><img id='Background_12' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_12.png' alt='Background 12' />&nbsp;</td>" +
							"</tr><tr>" +
							"<td align='center'><img id='Background_13' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_13.png' alt='Background 13' />&nbsp;</td>" +
							"<td align='center'><img id='Background_14' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_14.png' alt='Background 14' />&nbsp;</td>" +
							"<td align='center'><img id='Background_15' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_15.png' alt='Background 15' />&nbsp;</td>" +
							"<td align='center'><img id='Background_16' class='imageHover' onclick='setBackground(this.id,\""+id+"\");' src='/images/products/Background_16.png' alt='Background 16' />&nbsp;</td>" +
							"</tr></tbody></table></center>";
		}
		
	    newElem.appendChild(spn);
		
	    showPopup(newElem);
	 }
	 return false;
  }

  function changePrintSize() {
	  printsize = document.getElementById(id_PrintSize);
	  printsize = printsize.options[printsize.selectedIndex].text;
	  //Update frame
	  if(document.getElementById(id_Frame) !== null) {
		  frame = document.getElementById(id_Frame);
		  txt = frame.options[frame.selectedIndex].text; 
		  indx = frame.selectedIndex;
			  if(indx > 0) {
				if(txt.indexOf("Black Scoop") > -1) {
					setFrame("Black Scoop");
				}
				else if(txt.indexOf("Bronze Scoop") > -1) {
					setFrame("Bronze Scoop");
				}
				else if(txt.indexOf("Gold Classical") > -1) {
					setFrame("Gold Classical");
				}
				else if(txt.indexOf("Gold Scoop") > -1) {
					setFrame("Gold Scoop");
				}
				else if(txt.indexOf("Pewter Scoop") > -1) {
					setFrame("Pewter Scoop");
				}
				else if(txt.indexOf("Silver Classical") > -1) {
					setFrame("Silver Classical");
				}
				else if(txt.indexOf("Whitewashed Barnwood") > -1) {
					setFrame("Whitewashed Barnwood");
				}
			  }
	  }
	  //Update plexiglass
	  if(document.getElementById(id_Plexiglass) !== null) {
		  plexiglass = document.getElementById(id_Plexiglass);
		  txt = plexiglass.options[plexiglass.selectedIndex].text;
		  var printsize = document.getElementById(id_PrintSize);
		  var s = printsize.options[printsize.selectedIndex].text; 
		  var n = s.indexOf('+');
		  var size = s.substring(0, n != -1 ? n : s.length);
		  yesAndSize = "Yes - " + size;
		  if(txt.indexOf("Yes") > -1) {
				setPlexiglass(yesAndSize);
		  }
	  }
	  
	  initForm();
  }
  
  function show_frames(id) {
	  if(checkSelected(4)) {
		  var selected = selectedTreeType(3);
		  SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
			//SqueezeBox.resize({x: 800, y: 575})
			
			var newElem = new Element( 'div' );
			/*newElem.setStyle('border', 'solid 1px #CCC');*/ 
			//newElem.setStyle('width', '775px');
			//newElem.setStyle('height', '550px');
			newElem.setStyle('padding', '10px');
			newElem.setStyle('text-align', 'center');
			
			var spn = document.createElement("span");
			
			//Was using to determine to calculate shipping surcharge amount. Not doing that anymore
			<?php
				if(strpos($this->product->product_name,"Ready to Frame") !== false) {
					$frameShipCost = "$10.00";	
				}
				else {
					$frameShipCost = "$16.00";
				}
			?>
			//End comment
			
			//Get size of currently selected frame in order to determine frame price and show it in the pop up
			var printsize = document.getElementById(id_PrintSize);
			var s = printsize.options[printsize.selectedIndex].text; 
			var n = s.indexOf('+');
			size = s.substring(0, n != -1 ? n : s.length);
			if(size.indexOf("8x10") > -1) {
				frameCost = "$65.00";	
			}
			else if(size.indexOf("11x14") > -1) {
				frameCost = "$70.00";	
			}
			else if(size.indexOf("16x20") > -1) {
				frameCost = "$90.00";	
			}
			else if(size.indexOf("20x24") > -1) {
				frameCost = "$110.00";	
			}
			else if(size.indexOf("24x30") > -1) {
				frameCost = "$145.00";	
			}
			else {
				frameCost = "$0.00";	
			}
			

			spn.innerHTML =String.format("<div class='frame-table'>\
							    <div class='frame-item'>\
							        <b>Frame Option 1:</b>\
							        <br />Black Scoop\
							        <br /><b><span style='font-size:12px'>{0}</span></b>\
							        <br /><img id='Frame_Option1' class='imageHover' onclick='setFrame(\"Black Scoop\");' width='149' src='/images/products/Frame_Black_Scoop.png' alt='FrameOption1' />\
							    </div>\
							    <div class='frame-item'>\
							        <b>Frame Option 2:</b>\
							        <br />Bronze Scoop\
							        <br /><b><span style='font-size:12px'>{0}</span></b>\
							        <br /><img id='Frame_Option2' class='imageHover' onclick='setFrame(\"Bronze Scoop\");' width='149' src='/images/products/Frame_Bronze_Scoop.png' alt='FrameOption2' />\
							    </div>\
							    <div class='frame-item'>\
							        <b>Frame Option 3:</b>\
							        <br />Gold Classical\
							        <br /><b><span style='font-size:12px'>{0}</span></b>\
							        <br /><img id='Frame_Option3' class='imageHover' onclick='setFrame(\"Gold Classical\");' width='149' src='/images/products/Frame_Gold_Classical.png' alt='FrameOption3' />\
							    </div>\
							    <div class='frame-item'>\
							        <b>Frame Option 4:</b>\
							        <br />Gold Scoop\
							        <br /><b><span style='font-size:12px'>{0}</span></b>\
							        <br /><img id='Frame_Option4' class='imageHover' onclick='setFrame(\"Gold Scoop\");' width='149' src='/images/products/Frame_Gold_Scoop.png' alt='FrameOption4' />\
							    </div>\
							    <div class='frame-item'>\
							        <b>Frame Option 5:</b>\
							        <br />Pewter Scoop\
							        <br /><b><span style='font-size:12px'>{0}</span></b>\
							        <br /><img id='Frame_Option5' class='imageHover' onclick='setFrame(\"Pewter Scoop\");' width='149' src='/images/products/Frame_Pewter_Scoop.png' alt='FrameOption5' />\
							    </div>\
							    <div class='frame-item'>\
							        <b>Frame Option 6:</b>\
							        <br />Silver Classical\
							        <br /><b><span style='font-size:12px'>{0}</span></b>\
							        <br /><img id='Frame_Option6' class='imageHover' onclick='setFrame(\"Silver Classical\");' width='149' src='/images/products/Frame_Silver_Classical.png' alt='FrameOption6' />\
							    </div>\
							    <div class='frame-item'>\
							        <b>Frame Option 7:</b>\
							        <br />Whitewashed Barnwood\
							        <br /><b><span style='font-size:12px'>{0}</span></b>\
							        <br /><img id='Frame_Option7' class='imageHover' onclick='setFrame(\"Whitewashed Barnwood\");' width='149' src='/images/products/Frame_Whitewashed_Barnwood.png' alt='FrameOption7' />\
							    </div>\
							    <div class='frame-item'>\
							        <b>Frame Option 8:</b>\
							        <br />No Frame\
							        <br /><b><span style='font-size:12px'>+ $0.00</span></b>\
							        <br /><img id='Frame_Option8' class='imageHover' onclick='setFrame(\"None\");' width='149' src='/images/products/Frame_None.png' alt='FrameOption8' />\
							    </div>\
							</div>",frameCost);
			newElem.appendChild(spn);
			showPopup(newElem);
	  }
	  return false; 
  }
  
  function setFrame(color) {
	var printsize = document.getElementById(id_PrintSize);
	var s = printsize.options[printsize.selectedIndex].text; 
	var n = s.indexOf('+');
	size = s.substring(0, n != -1 ? n : s.length);
	if(color == "None") {
		colorsize = color;
	}
	else {
		colorsize = color + " " + size;	
	}
	var obj = document.getElementById(id_Frame);
	for(var i=0; i<obj.length; i++) {
	  txt = obj.options[i].text;
	  if(txt.indexOf(colorsize) > -1) {
	  	obj.selectedIndex = i;
	  }
	}
	
	img = "/images/products/Frame_Full_" + color + ".png";
	document.getElementById('img_Frame').innerHTML = "<img class='imageFrame' alt='' id='imageFrame' src='"+img+"'>";
	
	initForm();
	SqueezeBox.close(); 
	updatePrice();
  }
  
  function changeFontColor(color) {
  	img = selectedTreeType();
	img = createTreeImage(img);
	document.getElementById('PDP_Image').src = img;
	var bottomleft = document.getElementById(id_BottomLeft).selectedIndex;
	var bottomright = document.getElementById(id_BottomRight).selectedIndex;
	var bottom = document.getElementById(id_Bottom).selectedIndex;
	if(bottomleft > 0) {
		if(bottomleft == 1) {
			setBottomLeft(1,id_BottomLeftText);	
		}
		if(bottomleft == 2) {
			setBottomLeft(2,id_BottomLeftText);	
		}
		if(bottomleft == 3) { 
			setBottomLeft(3,id_BottomLeftText);	
		}
	}
	if(bottomright > 0) {
		if(bottomright == 1) {
			setBottomRight(1,id_BottomRightText);	
		}
		if(bottomright == 2) {
			setBottomRight(2,id_BottomRightText);	
		}
		if(bottomright == 3) { 
			setBottomRight(3,id_BottomRightText);	
		}
	}
	if(bottom > 0) {
		if(bottom == 1) {
			setBottom(1,id_BottomText);	
		}
		if(bottom == 2) {
			setBottom(2,id_BottomText);	
		}
		if(bottom == 3) { 
			setBottom(3,id_BottomText);	
		}
		if(bottom == 4) { 
			setBottom(4,id_BottomText);	
		}
	}
	document.getElementById(id_FontColor).style.backgroundColor = "#ffffff";
  }   
    
  function selectedTreeType(num) {
	var treetype = document.getElementById(id_TreeType);
	var selected = treetype.options[treetype.selectedIndex].text;
	var tree = selected.substr(0, selected.indexOf(' +'));
	if(tree !== '' && tree !== ' ') {
		selected = tree;
	}
	
	if(num == 1) {
		return selected;	
	}
	
	//Branch Style
	var branchstyle = document.getElementById(id_BranchStyle);
	branchstyle = branchstyle.options[branchstyle.selectedIndex].text;
	if(branchstyle != "Select One ...") {
		selected = selected + "_" + branchstyle;	
	}
	if(num == 2) {
		return selected;	
	}
	
	//Include Roots
	var roots = document.getElementById(id_IncludeRoots);
	roots = roots.options[roots.selectedIndex].text;
	if(roots.indexOf("Yes Roots") > -1) {
		selected = selected + "_Roots";
	}
	if(num == 3) {
		return selected;	
	}
	
	//Font Color
	var font = document.getElementById(id_FontColor);
	font = font.options[font.selectedIndex].text;
	if(font != "Select One ...") {
		selected = selected + "_" + font;	
	}
	if(num == 4) {
		return selected;	
	}
	else {
		return selected;	
	}
  }
  
  function createTreeImage(selected) {
	selected = "/images/products/" + selected + ".png";
	
	return selected;
  }
  
  function stripLastFour(thing) {
	thing = thing.substring(0, thing.length - 4);
	  
	return thing;
  }
  
  function updatePrice() {
	jQuery(document).ready(function($) {

			Virtuemart.product($("form.product"));

			$("form.js-recalculate").each(function(){
				if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
					var id= $(this).find('input[name="virtuemart_product_id[]"]').val();
					Virtuemart.setproducttype($(this),id);

				}
			});
	});
  }
  
  function show_GenerationQuestion() {  
		  SqueezeBox.initialize({
			  size: {x: 700, y: 550}
			});
			
		  var newElem = new Element( 'div' );
		  newElem.setStyle('padding', '10px');   
		  newElem.setStyle('text-align', 'center');
			
		  var spn = document.createElement("span");
		  
		  spn.innerHTML = "<center><table class=\"background_table\" style='height:445px;'><tbody>" +
						  "<tr style='font-size:20px'><td>Questions about how many generations you should select for your tree? " +
						  "</tr><tr>" +
						  "<td style='text-align:center; padding:0px 20px; font-size:16px;'><br /><u><b>DESCENDANT TREE</b></u><br />" +
						  	  "1 Generation = The TRUNK is Generation 1<br />" +
						      "2 Generation = Branches show Trunk's Children<br />" +
							  "3 Generation = Branches show Trunk's Children <b>AND</b> Grandchildren<br />" +
							  "4 Generation = Branches show Trunk's Children <b>AND</b> Grandchildren <b>AND</b> Great Grandchildren<br />" +
							  "and so on.</td>" +
						  "</tr><tr>" +
						  "<td style='text-align:center; padding:0px 20px; font-size:16px;'><br /><u><b>ANCESTRY TREE</b></u><br />" +
						  	  "1 Generation = The TRUNK is Generation 1<br />" +
						      "2 Generation = Branches show Trunk's Parents<br />" +
							  "3 Generation = Branches show Trunk's Parents <b>AND</b> Grandparents<br />" +
							  "4 Generation = Branches show Trunk's Parents <b>AND</b> Grandparents <b>AND</b> Great Grandparents<br />" +
							  "and so on.</td>" +
						  "</tr><tr>" +
						  "<td style='text-align:center; padding:0px 20px; font-weight:bold; font-size:16px; color:red;'>" +
						      "*Do not count roots as they are counted and priced seperately</td>" +	  
						  "</tr></tbody></table></center>";
		  
		  newElem.appendChild(spn);
			
		  showPopup(newElem);
  }
  
  function show_plexiglass(id) {
	  if(checkSelected(4)) {
		  var selected = selectedTreeType(3);
		  SqueezeBox.initialize({
			  size: {x: 350, y: 350}
			});
			//SqueezeBox.resize({x: 800, y: 575})
			
			var newElem = new Element( 'div' );
			/*newElem.setStyle('border', 'solid 1px #CCC');*/ 
			//newElem.setStyle('width', '775px');
			//newElem.setStyle('height', '550px');
			newElem.setStyle('padding', '10px');
			newElem.setStyle('text-align', 'center');
			
			var spn = document.createElement("span");
			
			//Was using to determine to calculate shipping surcharge amount. Not doing that anymore
			<?php
				if(strpos($this->product->product_name,"Ready to Frame") !== false) {
					$frameShipCost = "$10.00";	
				}
				else {
					$frameShipCost = "$16.00";
				}
			?>
			//End comment
			
			//Get size of currently selected frame in order to determine frame price and show it in the pop up
			var printsize = document.getElementById(id_PrintSize);
			var s = printsize.options[printsize.selectedIndex].text; 
			var n = s.indexOf('+');
			size = s.substring(0, n != -1 ? n : s.length);
			if(size.indexOf("8x10") > -1) {
				plexiCost = "$3.00";	
			}
			else if(size.indexOf("11x14") > -1) {
				plexiCost = "$5.00";	
			}
			else if(size.indexOf("16x20") > -1) {
				plexiCost = "$7.75";	
			}
			else if(size.indexOf("20x24") > -1) {
				plexiCost = "$14.00";	
			}
			else if(size.indexOf("24x30") > -1) {
				plexiCost = "$18.00";	
			}
			else {
				plexiCost = "$0.00";	
			}
			
				spn.innerHTML = "<center><table class=\"background_table\"><tbody>" +
								"<td><b>Yes Acrylic Plexiglass w/Frame</b><br /><b><span style='font-size:12px'>+ " + plexiCost + "</span></b><br /><img id='Yes_Plexiglass' class='imageHover' onclick='setPlexiglass(\"Yes - "+size+"\");' height='186' src='/images/products/greenCheckMark.png' alt='greenCheckMark' /></td>" +
								"<td><b>No Acrylic Plexiglass w/Frame</b><br /><b><span style='font-size:12px'>+ $0.00</span></b><br /><img id='No_Plexiglass' class='imageHover' onclick='setPlexiglass(\"No\");' width='300' src='/images/products/Frame_None.png' alt='FrameOption8' /></td>" +
								"</tr></tbody></table></center>";
			newElem.appendChild(spn);
			
			showPopup(newElem);
	  }
	  return false; 
  }
  
  function setPlexiglass(sel) {	
	
	var obj = document.getElementById(id_Plexiglass);
	sel = sel.trim();
	if(sel.indexOf("Yes") > -1) {
		for(var i=0; i<obj.length; i++) {
		  txt = obj.options[i].text;
		  if(txt.indexOf(sel) > -1) {
			obj.selectedIndex = i;
		  }
		}
	}
	else {
		obj.selectedIndex = 0;
	}
	
	initForm();
	SqueezeBox.close(); 
	updatePrice();
  }
  
  
  
</script>

<?php
	if(strpos($this->product->category_name, "Ancestor") !== false) {
		echo '<center><a href="#" onclick="show_GenerationQuestion();">How Many Generations Do I Need?</a></center>';
	}
	if(strpos($this->product->category_name, "Descendant") !== false) {
		echo '<center><a href="#" onclick="show_GenerationQuestion();">How Many Generations Do I Need?</a></center>';
	}
?>

<div class="addtocart-area">

	<form name="product-form" id="product-form" method="post" class="product js-recalculate"
		action="<?php echo JRoute::_ ('index.php'); ?>">
		<input name="quantity" type="hidden" value="<?php echo $step ?>" />
		<?php // Product custom_fields
if (!empty($this->product->customfieldsCart)) {
			?>
		<?php 
			$counter = 1;
			$catName = $this->product->category_name;
			$productTitle = $this->product->product_name;
			if(strpos($productTitle,"Updates") !== false) {
				$startPos = 3;
				$endPos = 7;	
			}
			else if(strpos($productTitle,"Additional") !== false) {
				$startPos = 2;
				$endPos = 6;	
			}
			else {
				$startPos = 1;
				$endPos = 5;	
			}
		?>	
		<div class="product-fields">
			<?php foreach ($this->product->customfieldsCart as $field) { 
				if(strpos($catName,'Additional') !== false) {
    				$span5style = "width: 60%;";  
 					$span7style = "width: auto;";
					$title = $field->custom_title;
					if($counter < $startPos) {
						$thisStyle = "padding:5px 0px 0px 20px;";
					}
					else if($counter == $startPos || $counter == $startPos + 5 || $counter == $startPos + 10 || $counter == $startPos + 15 || $counter == $startPos + 20) {
						$thisStyle = "border-top:1px solid #CCC; border-right:1px solid #CCC; border-left:1px solid #CCC; border-radius:3px; padding:5px 0px 0px 20px;";
					}
					else if($counter == $endPos || $counter == $endPos + 5 || $counter == $endPos + 10 || $counter == $endPos + 15 || $counter == $endPos + 20) {
						$thisStyle = "border-bottom:1px solid #CCC; border-right:1px solid #CCC; border-left:1px solid #CCC; margin-bottom:3px; border-radius:3px; padding: 0px 0px 5px 20px;";					
					}
					else {
						$thisStyle = "border-right:1px solid #CCC; border-left:1px solid #CCC; padding:0px 0px 0px 20px;";
					}
				}
				else {
					$thisStyle = "";
					$span5style = "";
					$span7style = "";
				}
			?>
			<?php
			if(strpos($field->custom_title,'Delivery Date') !== false) {
				echo '<div class="product-field product-field-type-V row-fluid" style="">';	
			}
			else {
				echo '<div class="product-field product-field-type-'.$field->field_type.' row-fluid" style="'.$thisStyle.'">';
			}
			?>
				<div class="span5" style="<?php echo $span5style; ?>">
					<?php if ($field->show_title) { ?>
					<span class="product-fields-title-wrapper"><span
						class="product-fields-title"><strong><?php echo JText::_ ($field->custom_title) ?>
						</strong> </span> <?php }
						if ($field->custom_tip) {
						echo JHTML::tooltip ($field->custom_tip, JText::_ ($field->custom_title), 'tooltip.png');
					} ?> </span>
				</div>
				<div class="span7" style="<?php echo $span7style; ?>">
					<span class="product-field-display"><?php echo $field->display ?> </span>
				</div>
				<span class="product-field-desc"><?php echo $field->custom_field_desc ?>
				</span>
			</div>
			<?php
				$counter = $counter + 1;
			}
			?>
		</div>
		<?php
		}
		/* Product custom Childs
		 * to display a simple link use $field->virtuemart_product_id as link to child product_id
		* custom_value is relation value to child
		*/

		if (!empty($this->product->customsChilds)) {
			?>
		<div class="product-fields">
			<?php foreach ($this->product->customsChilds as $field) { ?>
			<div
				class="product-field product-field-type-<?php echo $field->field->field_type ?> row-fluid">
				<div class="span5">
					<span class="product-fields-title"><strong><?php echo JText::_ ($field->field->custom_title) ?>
					</strong> </span>
				</div>
				<div class="span7">
					<span class="product-field-desc"><?php echo JText::_ ($field->field->custom_value) ?>
					</span>
				</div>
				<span class="product-field-display"><?php echo $field->display ?> </span>

			</div>
			<?php } ?>
		</div>
		<?php } ?>

		<div class="addtocart-bar">

			<script type="text/javascript">
		function check(obj) {
 		// use the modulus operator '%' to see if there is a remainder
		remainder=obj.value % <?php echo $step?>;
		quantity=obj.value;
 		if (remainder  != 0) {
 			alert('<?php echo $alert?>!');
 			obj.value = quantity-remainder;
 			return false;
 			}
 		return true;
 		}
</script>

			<?php // Display the quantity box

			$stockhandle = VmConfig::get ('stockhandle', 'none');
			if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($this->product->product_in_stock - $this->product->product_ordered) < 1) {
				?>
			<a
				href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $this->product->virtuemart_product_id); ?>"
				class="notify"><?php echo JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?>
			</a>

			<?php } else { ?>
			<!-- <label for="quantity<?php echo $this->product->virtuemart_product_id; ?>" class="quantity_box"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
			<span class="quantity-box"> <input type="text"
				class="quantity-input js-recalculate" name="quantity[]"
				value="<?php if (isset($this->product->min_order_level) && (int)$this->product->min_order_level > 0) {
			echo $this->product->step_order_level;
		} else if(!empty($this->product->min_order_level)){
			echo $this->product->min_order_level;
		}else {
			echo '1';
		} ?>" />
			</span> <span class="quantity-controls js-recalculate"> <input
				type="button" class="quantity-controls quantity-plus" value="+" /><input
				type="button" class="quantity-controls quantity-minus" value="-" />
			</span>
			<?php // Display the quantity box END ?>

			<?php
			// Display the add to cart button
			?>
			<span class="addtocart-button"> <?php echo shopFunctionsF::getAddToCartButton ($this->product->orderable); ?>
			<?php
				if(strpos($this->product->category_name, "Ancestor") !== false) {
					echo "<br /><i><b>*Important:</b>&nbsp;&nbsp;After completing the checkout process, we'll email you a form so you can provide the names of your family.</i>";
				}
				if(strpos($this->product->category_name, "Descendant") !== false) {
					echo "<br /><i><b>*Important:</b>&nbsp;&nbsp;After completing the checkout process, we'll email you a form so you can provide the names of your family.</i>";
				}
			?>
            </span>
			<?php } ?>
			
			<div class="clear"></div>
		</div>

		<?php // Display the add to cart button END  ?>
		<input type="hidden" class="pname"
			value="<?php echo htmlentities($this->product->product_name, ENT_QUOTES, 'utf-8') ?>" />
		<input type="hidden" name="option" value="com_virtuemart" /> <input
			type="hidden" name="view" value="cart" />
		<noscript>
			<input type="hidden" name="task" value="add" />
		</noscript>
		<input type="hidden" name="virtuemart_product_id[]"
			value="<?php echo $this->product->virtuemart_product_id ?>" />
	</form>

	<div class="clear"></div>
</div>



<script>
 	var divs = document.getElementsByClassName('product-field product-field-type-E row-fluid');
  	var innerHTM = divs[0].innerHTML
	if(innerHTM.indexOf("vmcustom-textareainput") > -1) {
		divs[0].setAttribute('style', 'display:block !important');
		txtarea = document.getElementsByClassName('vmcustom-textareainput field');
		txtarea[0].style.width = "523px";
	}
</script>
