$(document).ready(function(){

	 var root_dir = 'http://demo.haiinteractive.com/media/';
	
	//var root_dir = 'http://demo.localhost.com/media/';
		
	$("#cancel_form").click(function(){
		var answer = confirm("Are you sure you want to Cancel this item?");
        if (answer){
            return true;
        } else {
            return false;
        }
    });

	
	$('.datepick').on('click', function() {
	    $(this).datepicker('destroy').datepicker({changeMonth: true,changeYear: true,dateFormat: "yy-mm-dd",yearRange: "1900:+10",showOn:'focus'}).focus();
	});
	var product = $("#result_set").val();
	
	switch(product)
	{
	case 'EG':
	  $(".form_type").val(product);
	  
	  $('#city').show();
	  $('#eg_session').show();
	  $('#gobtn').show();
	  $('#exec_session').hide();
      $('#digital_session').hide();
	 
	  break;
	case 'EXEC':
		
		$('#city').hide();
		$('#eg_session').hide();
		$(".form_type").val(product);
		$('#digital_session').hide();

	 $('#exec_session').show();
	 $('#gobtn').show();
	 break;
	case 'DIGITAL':
	 $('#digital_session').show();
	 $('#eg_session').hide();
	  $('#exec_session').hide();
	  break;
	default:
		 $('#digital_session').hide();
	  $('#exec_session').hide();
		
	}
	
	
	
	$("#upload_form").validate({
		
		rules: {
			datas: {
				required: true
			}
		},
		messages: {
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    }

		
	}); // End of Login Validation
	

	
	
	
	
	$("#login-form").validate({
		
		rules: {
			user_password: {
				required: true,
				minlength: 5
			},
			user_name: {
				required: true,
				email: true
			}
		},
		messages: {
			user_password: {
				required: "",
				minlength: ""
			},
			user_email: ""
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var user_name = $("#user_name").val();
			var user_password = $("#user_password").val();
			
			var params = "user_name="+user_name+"&user_password="+user_password;

	    	   	   $(".message").show();
	    	   	   $(".message").addClass('info');
	    		   $(".message").html("Please Wait...");
			$.ajax({
			       type: "POST",
			       url: root_dir+"users/user_login",
			       data: params,
			       async: false,
			       success: function(sresponse){
			    	
			    	   if(sresponse === 'ER')
			    	   {
			    	   	   $(".message").show();
			    	   	   $(".message").addClass('error');
			    		   $(".message").html("Email Or Password Doesn't Match");
			    		   return false;
			    		   		
			    		}else if(sresponse === 'inactive'){
			    	   	   $(".message").show();
			    	   	   $(".message").addClass('error');
			    		   $(".message").html("Account is Inactive");
			    		   return false;
			    			   
			    		}else if(sresponse === 'ip'){
			    			
			    	   	   $(".message").show();
			    	   	   $(".message").addClass('error');
			    		   $(".message").html("Ip Doesn't Match");
			    		   return false;
			    			   
			    		}else{
			    	    	window.location.reload();
			    		}
				   }
			});
			
		}
		
	}); // End of Login Validation
	
	
	
	
	
	$("#add_new_user_form").validate({
		
		rules: {
			FirstName: {
				required: true,
				minlength: 1
			},
			LastName: {
				required: true,
				minlength: 1
			},
			user_password: {
				required: true,
				minlength: 5
			},
			user_name: {
				required: true,
				email: true
			},
			user_ips: {
				required: true,
			},
			Cpassword : {
				required : true,
				minlength : 6,
				equalTo : "#user_password",
			}
		},
		messages: {
			user_password: {
				required: "",
				minlength: ""
			},
			user_email: ""
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var user_type = $("#user_type").val();
			var user_name = $("#user_name").val();
			var user_password = $("#user_password").val();
			var user_ips = $("#user_ips").val();
			var FirstName = $("#FirstName").val();
			var LastName = $("#LastName").val();
			
			
			var params = "FirstName="+FirstName+"&LastName="+LastName+"&user_type="+user_type+"&user_name="+user_name+"&user_password="+user_password+"&user_ips="+user_ips+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/add_new_user/",
		       data: params,
		       async: false,
		       success: function(sresponse){
		    	
					if(sresponse > 0){
		    			   
			    		   $(".error").hide();
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");

			    		   document.add_new_user_form.reset();	   
		    			   
		    		}else{
		    			
			    		   $(".success").hide();
			    		   $(".error").show();
			    		   $(".error").html("E-mail Address Already Available. Please check it");

		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation
	

	
	$("#edit_adtype_form").validate({
		
		rules: {
			code_type: {
				required: true,
				minlength: 1
			},
			codes: {
				required: true,
				minlength: 2
			},
			rack_rate: {
				required: true,
				minlength: 2
			}
		},
		messages: {
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var form_type = $("#form_type").val();
			var code_type = $("#code_type").val();
			var codes = $("#codes").val();
			var rack_rate = $("#rack_rate").val();
			var adtype_status = $("#adtype_status").val();
			var code_id = $("#code_id").val();
			
			var params = "form_type="+form_type+"&code_type="+code_type+"&codes="+codes+"&rack_rate="+rack_rate+"&adtype_status="+adtype_status+"&code_id="+code_id+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/EditAdType/",
		       data: params,
		       async: false,
		       success: function(sresponse){
		    	
					if(sresponse > 0){
		    			   
			    		   $(".error").hide();
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");

			    		   document.add_new_user_form.reset();	   
		    			   
		    		}else{
		    			
			    		   $(".success").hide();
			    		   $(".error").show();
			    		   $(".error").html("Failed");

		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation

	
	
	$("#add_adtype_form").validate({
		
		rules: {
			code_type: {
				required: true,
				minlength: 1
			},
			codes: {
				required: true,
				minlength: 2
			},
			rack_rate: {
				required: true,
				minlength: 2
			}
		},
		messages: {
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var form_type = $("#form_type").val();
			var code_type = $("#code_type").val();
			var codes = $("#codes").val();
			var rack_rate = $("#rack_rate").val();
			
			
			var params = "form_type="+form_type+"&code_type="+code_type+"&codes="+codes+"&rack_rate="+rack_rate+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"home/AddAdType/",
		       data: params,
		       async: false,
		       success: function(sresponse){
		    	
					if(sresponse > 0){
		    			   
			    		   $(".error").hide();
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");

			    		   document.add_new_user_form.reset();	   
		    			   
		    		}else{
		    			
			    		   $(".success").hide();
			    		   $(".error").show();
			    		   $(".error").html("E-mail Address Already Available. Please check it");

		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation
	
	
	
	
	$("#add_product_form").validate({
		
		rules: {
			product_name: {
				required: true
			}
		},
		messages: {
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var product_name = $("#product_name").val();
			
			var params = "product_name="+product_name+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/add_new_product/",
		       data: params,
		       async: false,
		       success: function(sresponse){
		    	
					if(sresponse > 0){
		    			   
			    		   $(".error").hide();
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");
			    		   document.add_new_category_form.reset();	   
		    			   
		    		}else{
		    			
			    		   $(".success").hide();
			    		   $(".error").show();
			    		   $(".error").html("Failed. Try Again");
			    		   document.add_new_category_form.reset();	   
			    			   
		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation

	
	$("#add_new_category_form").validate({
		
		rules: {
			category_name: {
				required: true
			}
		},
		messages: {
			user_password: {
				required: "",
				minlength: ""
			},
			user_email: ""
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var category_name = $("#category_name").val();
			
			var params = "category_name="+category_name+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/add_new_category/",
		       data: params,
		       async: false,
		       success: function(sresponse){
		    	
					if(sresponse > 0){
		    			   
			    		   $(".error").hide();
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");
			    		   document.add_new_category_form.reset();	   
		    			   
		    		}else{
		    			
			    		   $(".success").hide();
			    		   $(".error").show();
			    		   $(".error").html("Failed. Try Again");
			    		   document.add_new_category_form.reset();	   
			    			   
		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation
	
	
	 $.validator.addMethod("phonevalidation",
     		 function(value, element) {
		 
				 var phoneRegExp = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
			     var numbers = value.split("").length;
			     if (10 <= numbers && numbers <= 20 && phoneRegExp.test(value)) {
		             return /^[A-Za-z\d=#$%@_ -]+$/.test(value);
			     }
	         },
	   "Please enter a valid phone number."
	   );

	
	$("#add_new_company_form").validate({
		
		rules: {
			company_name: {
				required: true,
				minlength: 5
			},
			contact_person: {
				required: true,
				minlength: 1
			},
			contact_no: {
				required: true,
				minlength:5
			},
			address: {
				required: true
			},
			email_id: {
				required: true,
				email: true
			}
		},
		messages: {
			user_password: {
				required: "",
				minlength: ""
			},
			user_email: ""
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var company_name = $("#company_name").val();
			var contact_person = $("#contact_person").val();
			var contact_no = $("#contact_no").val();
			var alternative_contact_no = $("#alternative_contact_no").val();
			var address = $("#address").val();
			var pin_code = $("#pin_code").val();
			var email_id = $("#email_id").val();
			var alternative_email_id = $("#alternative_email_id").val();
			
			var params = "email_id="+email_id+"&company_name="+company_name+"&contact_person="+contact_person+"&contact_no="+contact_no+"&address="+address+"&pin_code="+pin_code+"&response=add&alternative_contact_no="+alternative_contact_no+"&alternative_email_id="+alternative_email_id;

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/add_new_company/",
		       data: params,
		       async: false,
		       success: function(sresponse){
		    	
					if(sresponse > 0){
		    			   
			    		$(".success").show();
			    		$(".success").html("Inserted Successfully");
			    		   document.add_new_company_form.reset();	   
		    			   
		    		}else{
		    			
			    		$(".error").show();
			    		$(".error").html("Insert Failed");
			    		   document.add_new_company_form.reset();	   
			    			   
		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation
	
	
	$("#change_password_form").validate({
		
		rules: {
			new_password: {
				required: true,
				minlength: 5
			},
			confirm_password : {
				required : true,
				minlength : 6,
				equalTo : "#new_password",

			}
		},
		messages: {
			user_password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			user_email: "Please enter a valid email address"
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var new_password = $("#new_password").val();
			
			var params = "new_password="+new_password+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/Change_Password/",
		       data: params,
		       async: false,
		       success: function(sresponse){
		    	
					if(sresponse > 0){
						
				       $(".success").show();
				       $(".success").html("Password Changed Successfully");
		    		   document.change_password_form.reset();	   
		    		}else{
		    			
				       $(".error").show();
				       $(".error").html("Insert Failed. Try Again");
		    		   document.change_password_form.reset();	   
			    			   
		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation



	$("#edit_user_form").validate({
		
		rules: {
		FirstName: {
				required: true,
				minlength: 5
			},
			user_name: {
				required : true,
				minlength : 6,
				email: true
			},
			user_ips: {
				required : true,
				minlength : 3
			}
		},
		messages: {
			user_password: {
				required: "",
				minlength: ""
			},
			user_email: ""
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var FirstName = $("#FirstName").val();
			var LastName = $("#LastName").val();
			var user_name = $("#user_name").val();			
			var user_type = $("#user_type").val();
			var user_ips = $("#user_ips").val();
			var user_id = $("#user_id").val();
			var user_is_active = $("#user_is_active").val();
			
			var params = "FirstName="+FirstName+"&LastName="+LastName+"&user_name="+user_name+"&user_type="+user_type+"&user_ips="+user_ips+"&user_id="+user_id+"&user_is_active="+user_is_active+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/EditUser/",
		       data: params,
		       async: false,
		       success: function(sresponse){
				
					if(sresponse > 0){
						
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");

		    		}else{
		    			
			    		   $(".error").show();
			    		   $(".error").html("Failed, Try Again");

		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation
	
	
	$("#edit_category_form").validate({
		
		rules: {
			category_name: {
				required: true,
				minlength: 5
			},
		},
		messages: {
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var category_name = $("#category_name").val();
			var category_status = $("#category_status").val();
			var category_id = $("#category_id").val();
			
			var params = "category_name="+category_name+"&category_status="+category_status+"&category_id="+category_id+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/EditCategory/",
		       data: params,
		       async: false,
		       success: function(sresponse){
				
					if(sresponse > 0){
		    			   
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");
		    			   
		    		}else{
		    			
			    		   $(".error").show();
			    		   $(".error").html("Failed, Try Again");
			    			   
		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation

	
	
	
	
	$("#edit_company_form").validate({
		
		rules: {
		company_name: {
				required: true,
				minlength: 5
			},
			contact_person: {
				required : true
			},
			contact_no: {
				required : true,
				minlength : 6
			},
			email_id:{
				required : true,
				minlength : 6,
				email:true
			}
		},
		messages: {
			user_password: {
				required: "",
				minlength: "Your password must be at least 5 characters long"
			},
			user_email: "Please enter a valid email address"
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    },

	    submitHandler: function(form) {
			
			var company_name = $("#company_name").val();
			var contact_person = $("#contact_person").val();
			var address = $("#address").val();			
			var pin_code = $("#pin_code").val();
			var contact_no = $("#contact_no").val();
			var email_id = $("#email_id").val();
			var client_id = $("#client_id").val();
			var client_status = $("#client_status").val();
			
			var params = "company_name="+company_name+"&contact_person="+contact_person+"&address="+address+"&pin_code="+pin_code+"&contact_no="+contact_no+"&email_id="+email_id+"&client_id="+client_id+"&client_status="+client_status+"&response=add";

			$.ajax({
		       type: "POST",
		       url: root_dir+"users/EditClient/",
		       data: params,
		       async: false,
		       success: function(sresponse){
				
					if(sresponse > 0){
		    			   
			    		   $(".success").show();
			    		   $(".success").html("Inserted Successfully");
		    			   
		    		}else{
		    			
			    		   $(".error").show();
			    		   $(".error").html("Failed, Try Again");
			    			   
		    		}
			   }
			});
			
		}
		
	}); // End of Login Validation
	
	
	
	
	
	$("#roform").validate({
		
		rules: {
			RO_Number: {
				required: true
			},
			company_name: {
				required: true
			},
			user_city: {
				required: true
			},
			Sales_Person: {
				required: true
			},
			Approving_Authonity: {
				required: true
			},
			Category_Business: {
				required: true
			},
			publish_AddType_row0:{
				required: true
			},
			OfferRate_row0:{
				required: true
			},
			Net_Pay:{
				required: true
			}
		},
	    onfocusout: function(element) {
	        $(element).valid();
	    },
	    highlight: function(element) {
	        var cssObj = {'border' : '1px solid red', 'background-color:':'red', 'color' : 'red'}
	    	$(element).css(cssObj);
	    },
	    unhighlight: function(element) {
	    	$(element).removeClass('error');
	        var cssObj = {'border' : '1px solid #0EA6BF', 'color' : '#222222'}
	    	$(element).css(cssObj);
	    }
		
	}); // End of Login Validation
	
	
	
	$("#Product").on('change', function(){
		
		var product = $(this).val();
		
		switch(product)
		{
		case 'EG':
		  $(".form_type").val(product);
		  
		  $('#city').show();
		  $('#eg_session').show();
		  $('#gobtn').show();
		  $('#exec_session').hide();
	      $('#digital_session').hide();
		 
		  break;
		case 'EXEC':
			
			$('#city').hide();
			$('#eg_session').hide();
			$(".form_type").val(product);
			$('#digital_session').hide();

		 $('#exec_session').show();
		 $('#gobtn').show();
		 break;
		case 'DIGITAL':
		 $('#digital_session').show();
		 $('#eg_session').hide();
		  $('#exec_session').hide();
		  break;
		
		}
		
		$(".date_range_msg").hide();
		
	});
	








                  var cb = function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
                  }

                  var optionSet1 = {
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment(),
                    minDate: '01/01/2012',
                    maxDate: '12/31/2014',
                    dateLimit: { days: 60 },
                    showDropdowns: true,
                    showWeekNumbers: true,
                    timePicker: false,
                    timePickerIncrement: 1,
                    timePicker12Hour: true,
                    ranges: {
                       'Today': [moment(), moment()],
                       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    opens: 'left',
                    buttonClasses: ['btn btn-default'],
                    applyClass: 'btn-small btn-primary',
                    cancelClass: 'btn-small',
                    format: 'MM/DD/YYYY',
                    separator: ' to ',
                    locale: {
                        applyLabel: 'Submit',
                        cancelLabel: 'Clear',
                        fromLabel: 'From',
                        toLabel: 'To',
                        customRangeLabel: 'Custom',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        firstDay: 1
                    }
                  };

                  var optionSet2 = {
                    startDate: moment().subtract(7, 'days'),
                    endDate: moment(),
                    opens: 'left',
                    ranges: {
                       'Today': [moment(), moment()],
                       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                       'This Month': [moment().startOf('month'), moment().endOf('month')],
                       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                  };

                  $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

                  $('#reportrange').daterangepicker(optionSet1, cb);

                  $('#reportrange').on('show.daterangepicker', function() { console.log("show event fired"); });
                  $('#reportrange').on('hide.daterangepicker', function() { console.log("hide event fired"); });
                  $('#reportrange').on('apply.daterangepicker', function(ev, picker) { 
                    console.log("apply event fired, start/end dates are " 
                      + picker.startDate.format('MMMM D, YYYY') 
                      + " to " 
                      + picker.endDate.format('MMMM D, YYYY')
                    ); 
                  });
                  $('#reportrange').on('cancel.daterangepicker', function(ev, picker) { console.log("cancel event fired"); });

                  $('#options1').click(function() {
                    $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
                  });

                  $('#options2').click(function() {
                    $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
                  });

                  $('#destroy').click(function() {
                    $('#reportrange').data('daterangepicker').remove();
                  });


	
});
