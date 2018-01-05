/**
 * Side navigation menu bar scripting for Twitter Bootstrap 3.0
 * Built for Yii Framework 2.0
 * Author: Kartik Visweswaran
 * Copyright: 2013, Kartik Visweswaran, Krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */

$(document).ready(function(){
	$('.kv-toggle').click(function(event){
        event.preventDefault(); // cancel the event
        $(this).children('.opened').toggle();
        $(this).children('.closed').toggle();
		// untuk buat menu seperti accordion
		if($(this).parent().parent().children('li').hasClass('active')) {
			$('.kv-sidenav li.active ul.treeview-menu').attr('style','display: none');
			$('.kv-sidenav li.active').removeAttr('class');
		}
		// end untuk menu seperti accordion
        $(this).parent().children('ul').toggle()
        $(this).parent().toggleClass('active')
        //return false;
	});
});
