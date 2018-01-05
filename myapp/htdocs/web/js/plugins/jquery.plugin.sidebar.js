(function($) {
    "use strict";

    $.fn.tree = function() {

        return this.each(function() {
			var btn = $(this);
			var menu = $(this).parent().find(".treeview-menu").first();
			var isActive = $(this).parent().hasClass('active');

            //initialize already active menus
            if (isActive) {
                menu.show();
				btn.children('.opened').show();
				btn.children('.closed').hide();
            }
            //Slide open or close the menu on link click
            btn.click(function(e) {
                e.preventDefault();
                if (isActive) {
                    //Slide up to close menu
                    menu.slideUp();
                    isActive = false;
					btn.children('.opened').hide();
					btn.children('.closed').show();
                    btn.parent("li").removeClass("active");
                } else {
                    //Slide down to open menu
                    menu.slideDown();
                    isActive = true;
                    btn.find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
					btn.children('.opened').show();
					btn.children('.closed').hide();
                    btn.parent("li").addClass("active");
                }
            });
        });
    };
}(jQuery));
