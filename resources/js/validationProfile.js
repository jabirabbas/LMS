$(document).ready(function(){
	$("#profileForm").submit(function(){	
	requiredProduct = ["oldpassword", "newpassword", "cpassword"];
	
		for (i=0;i<requiredProduct.length;i++) {
			var input = $('#'+requiredProduct[i]);
			if (input.val() == "") {
				input.addClass("needsfilled");
				
			} else {
				input.removeClass("needsfilled");
			}
		}
		
		if ($('#newpassword').val() != $('#cpassword').val()) {
			$('#cpassword').addClass("needsfilled");
			alert("Incorrect password typed for Confirm Password");
		}
		//if any inputs on the page have the class 'needsfilled' the form will not submit
		if ($(":input").hasClass("needsfilled")) {
			return false;
		} else {
			errornotice.hide();
			return true;
		}
	});
	
	// Clears any fields in the form when the user clicks on them
	$(":input").focus(function(){		
	   if ($(this).hasClass("needsfilled") ) {
			$(this).val("");
			$(this).removeClass("needsfilled");
	   }
	});
});	