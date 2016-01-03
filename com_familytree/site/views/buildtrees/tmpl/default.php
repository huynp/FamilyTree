<div class="tree-builder-container">
     <script type="text/javascript" src="/components/com_familytree/js/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/customTree.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/jquery.popup.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/jquery.jOrgChart.js"></script>
    <script type="text/javascript" src="/components/com_familytree/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="/components/com_familytree/js/jquery.jOrgChart.css" />
    <link rel="stylesheet" href="/components/com_familytree/js/custom.css" />
    <link rel="stylesheet" href="/components/com_familytree/js/datepicker.css" />
    <link rel="stylesheet" href="/components/com_familytree/js/bootstrap.css" />
   <!-- <script type="text/javascript" src="/components/com_familytree/js/script.min.js"></script>
    <link rel="stylesheet" href="/components/com_familytree/js/styles.css" />-->
    <a id='temp-data' style='display:none' data-tree="<?php echo htmlentities($this->modelData); ?>">Tree Data</a>
    <script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            var temp = $('#temp-data').attr('data-tree').replace(/\\"/g, '"');
                temp = temp.replace(/%%H%%U%%Y%%/g, "\\\\");
                temp = temp.replace(/@@H@@U@@Y@@/g, "\\\"");
                temp = temp.replace(/!!H!!U!!Y!!/g, "\'");
            $.dataObjects =JSON.parse(temp) ;

            var initTreeFunct = function(dataObject) {
                $("#family-tree-container").empty();
                var option ={
                    orderNumber:'<?php print_r($this->orderNumber);?>',
                    orderPass:'<?php echo $this->orderPass; ?>',
                    andStyle:'and',
                    ancestorLevel:4,
                    descendantLevel:3,
                    allowAddBirthDay:false,
                    isDoubleTrunk:false,
                    isReadOnly:false
                };

                $.extend(option,dataObject);
                $('#family-tree-container').familyTree(option);
                $('#nav-line').remove();
                $('#tab-modules').remove();
                $(".tree-builder-container").parents('.row-fluid').find('.span3').remove();
                 $(".tree-builder-container").parents('.row-fluid').find('.span9').addClass('span12').removeClass('span9');
                 $('.tree-builder-container').css({
                    "width": "100%",
                    "height": "auto",
                    "padding": "5px",
                    "border-radius": "4px",
                    "overflow":"auto",
                    "border": "1px solid #CCC",
                    "margin-top":"20px"});
                 $('#main-handler').width('98%');
                 $('#bottom-bg').remove();
                 $('#slideshow-header').remove();
                 $('#menu-handler li').removeClass('active');
            }

            if($.dataObjects.length>0)
            {
                //Build dropdown list
                var $dropdown=$('<select class="product-item">');
                for(var i =0;i< $.dataObjects.length; i++)
                {
                    var $option = $("<option/>").val(i).text($.dataObjects[i].productName);
                    $dropdown.append($option);
                }
                $dropdown.change(function(event) {
                    var index = $(this).val();
                    dataObject =$.dataObjects[index];
                    initTreeFunct(dataObject);
                });
                $(".product-items-container").append($dropdown).show();
                $dropdown.change();
                if($.dataObjects.length==1)
                    $dropdown.attr("disabled","disabled");
            }
        });
    }(jQuery))
    </script>
    <div class="hide product-items-container" style="margin: 10px 10px 0 20px;">
        <span style="display:inline-block">Product Item</span>
    </div>
    <div id="family-tree-container">
    </div>
</div>
