<div class="tree-builder-container">
     <script type="text/javascript" src="/components/com_familytree/js/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/customTree.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/jquery.popup.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/jquery.jOrgChart.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/jquery.qtip.min.js" ></script>
    <link rel="stylesheet" href="/components/com_familytree/js/jquery.jOrgChart.css" />
    <link rel="stylesheet" href="/components/com_familytree/js/custom.css" />
    <link rel="stylesheet" href="/components/com_familytree/js/datepicker.css" />
    <link rel="stylesheet" href="/components/com_familytree/js/bootstrap.css" />
    <link rel="stylesheet" href="/components/com_familytree/js/jquery.qtip.min.css" />
   <!-- <script type="text/javascript" src="/components/com_familytree/js/script.min.js"></script>
    <link rel="stylesheet" href="/components/com_familytree/js/styles.css" />-->
    <script type="text/javascript">

        function buildCustomTreeForm(){
            var orderNumber =jQuery.fn.getParameterByName('orderNumber'); 
            var orderPass = jQuery.fn.getParameterByName('orderPass'); 
            jQuery.ajax({
              url: "/?option=com_familytree&task=getTreeData&format=raw",
              data: {
                orderNumber:orderNumber,
                orderPass:orderPass,
              },
              success: function(data){
                    var temp = data.replace(/\\"/g, '"');
                    temp = temp.replace(/%%H%%U%%Y%%/g, "\\\\");
                    temp = temp.replace(/@@H@@U@@Y@@/g, "\\\"");
                    temp = temp.replace(/!!H!!U!!Y!!/g, "\'");
                    var returnDataObject =JSON.parse(temp);
                    jQuery.dataObjects =returnDataObject.treeDatas ;
                    var initTreeFunct = function(dataObject) {
                        jQuery("#family-tree-container").empty();
                        var option ={
                            orderNumber:orderNumber,
                            orderPass:orderPass,
                            andStyle:'and',
                            ancestorLevel:4,
                            descendantLevel:3,
                            allowAddBirthDay:false,
                            isDoubleTrunk:false,
                            isReadOnly:false,
                            additionLevel:0,
                            customerName:returnDataObject.customerName
                        };

                        jQuery.extend(option,dataObject);
                        jQuery('#family-tree-container').familyTree(option);
                        jQuery('#nav-line').remove();
                        jQuery('#tab-modules').remove();
                        jQuery(".tree-builder-container").parents('.row-fluid').find('.span3').remove();
                        jQuery(".tree-builder-container").parents('.row-fluid').find('.span9').addClass('span12').removeClass('span9');
                        jQuery('.tree-builder-container').css({
                            "width": "100%",
                            "height": "auto",
                            "padding": "5px",
                            "border-radius": "4px",
                            "overflow":"auto",
                            "border": "1px solid #CCC",
                            "margin-top":"20px"});
                         jQuery('#main-handler').width('98%');
                         jQuery('#bottom-bg').remove();
                         jQuery('#slideshow-header').remove();
                         jQuery('#menu-handler li').removeClass('active');
                    }

                    if(jQuery.dataObjects.length>0)
                    {
                        //Build dropdown list
                        jQuery(".product-item").remove();
                        var jQuerydropdown=jQuery('<select class="product-item">');
                        for(var i =0;i< jQuery.dataObjects.length; i++)
                        {
                            var jQueryoption = jQuery("<option/>").val(i).text(jQuery.dataObjects[i].productName);
                            jQuerydropdown.append(jQueryoption);
                        }
                        jQuerydropdown.change(function(event) {
                            var index = jQuery(this).val();
                            dataObject =jQuery.dataObjects[index];
                            initTreeFunct(dataObject);
                        });
                        jQuery(".product-items-container").append(jQuerydropdown).show();
                        jQuerydropdown.change();
                        if(jQuery.dataObjects.length==1)
                            jQuerydropdown.attr("disabled","disabled");
                    }
                }
            });
        }

        jQuery(document).ready(function() {
            buildCustomTreeForm();
        });
    </script>
    <div class="hide product-items-container" style="margin: 10px 10px 0 20px;">
        <span style="display:inline-block">Product Item</span>
    </div>
    <div id="family-tree-container">
    </div>
</div>
