(function( $ ) {

    $(function() {

        $('.color-field').wpColorPicker();

    });

	$(function(){
	  $("#ctc_sticky_enable").change(function() {
		$("#ctc_admin_content").toggleClass("ctc-show-hide", this.unchecked)
	  }).change();
	})
	
})( jQuery );

