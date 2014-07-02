// This function aligns images in a grid based on the arguments below
function alignGrid(/*string*/ id, /*int*/ cols, /*int*/ cellWidth, 
    /*int*/ cellHeight, /*int*/ padding) {

    var x = 0;
    var y = 0;
    var count = 1;

    jQuery("#" + id).each(function() {1
        jQuery(this).css("position", "relative");2
        
        jQuery(this).children("div").each(function() {3
            jQuery(this).css("width", cellWidth + "em");
            jQuery(this).css("height", cellHeight + "em");
            jQuery(this).css("position", "absolute");
            
            jQuery(this).css("left", x + "em");
            jQuery(this).css("top", y + "em");
            
            if ((count % cols) == 0) {4
                x = 0;
                y += cellHeight + padding;
            } else {
                x += cellWidth + padding;
            }
            
            count++;
        });
    });
}