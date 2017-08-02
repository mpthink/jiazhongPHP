(function($) {
$.fn.tableresizer = function(options) 
{        
    $.fn.tableresizer.defaults = 
    {
        col_border : "2px solid #666",
    };
    
    var opts = $.extend({}, $.fn.tableresizer.defaults, options);
    var args = arguments;
    
    /**
     * Make table columns resizable
     */  
    var resize_columns = function(root)
    {                   
        var tbl = root.children("table");
        var tr  = tbl.find("tr:first");
        var header,newwidth;
        var resize = false;
        
        root.width(tbl.width());
        tr.children("th").css("border-right",opts.col_border);
        var left_pos = root.offset().left;
    
        endresize = function()
        {
            if(resize == true && header != null)
            {
                document.onselectstart=new Function ("return true");
                resize = false;
                root.children("table").css("cursor","");
            }   
        };
        
        tbl.mousemove(function(e)
        {
            var left = (e.clientX - left_pos);
    
            if(resize)
            {
                // when jquery includes dimensions into core, use that
                // to get implicit with instead of subtracting padding
                var width = left - (header.offset().left - left_pos)
                    - parseInt(header.css("padding-left"))
                    - parseInt(header.css("padding-right"));
    
                if(width > 1)
                {
                    var current_width = header.width();
                    // If expanding, resize container first, else resize
                    // column then container. otherwise the adjacent 
                    // cells resize
                    if(width > current_width)
                    {
                        var total = root.width() + ((width - header.width()));
                        root.width(total);
                        header.width(width);
                    }
                    else
                    {
                        header.width(width);
                        // check the header resize (might have
                        // a min width
                        if(header.width() == width)
                        {
                            var total = root.width() + ((width - current_width));
                            root.width(total);
                        }
                    }
                    newwidth = width;
                }
            }
            else
            {
                if(e.target.nodeName == "TH")
                {
                
                    // nasty calculation to check the mouse is on / around
                    // the border to a header
                    var tgt = $(e.target);
                    var dosize = (left-(tgt.offset().left-left_pos) 
                        > tgt.width()-4);
                    $(this).css("cursor",dosize?"col-resize":"");
                }
            }                   
        });
        
        tbl.mouseup(function(e) 
        {
            endresize();   
        });
                
        tbl.bind("mouseleave",function(e)
        {
            endresize();
            return false; 
        });
        
        tr.mousedown(function(e) 
        {
            if(e.target.nodeName == "TH" 
                && $(this).css("cursor") ==  "col-resize")
            {
                header = $(e.target);                    
                resize = true;
                // Stop ie selecting text
                document.onselectstart=new Function ("return false");
            }    
            return false;
        });
        
        tr.bind('mouseleave',function(e)
        {
            if(!resize)
                root.children("table").css("cursor","");
        });
    };
    

    
    /**
     * Entry point
     */   
    return this.each(function() 
    {
        var root = $(this).wrap("<div class='roottbl' />").parent();
        resize_columns(root);
        resize_rows(root);    
    });
};

})(jQuery);
