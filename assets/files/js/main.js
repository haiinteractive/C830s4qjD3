
	//var root_dir = 'http://demo.haiinteractive.com/media/';
	var root_dir = 'http://demo.localhost.com/media/';
// JavaScript Document		
$(document).ready(function() {
	$(".AddType").on('change', function(){
		
		var company_name = $("#company_name").val();
			
		if(company_name.length == 0 || company_name.length == '' )
		{
			alert("Please Choose Company Name");
			document.roform.reset();
			return false;
		}
		
	});
	
	$('#add_new_client').click(function () {
        jQuery('#edit_dialog-message').dialog({
       	 modal:true,
            width:700,
            height:500
        });
      return false;
	});
	
	
	$("#getdate").click(function() {
		if(($("#Product option:selected")).val()=="EG") $('#EgDatePicker').show();
		if(($("#Product option:selected")).val()=="EXEC") $('#ExecDatePicker').show();
		if(($("#Product option:selected")).val()=="DIGITAL") $('#DigitalDatePicker').show();
		$(".date_range_msg").css("display","none");
			
	});	
	
	var prod = $("#Product").val();
	
	switch(prod)
	{
		case 'EG':
			$('#city').show();
			$('#eg_session').show();
			$('#gobtn').show();
			  $('#exec_session').hide();
		  break;
		  
		case 'EXEC':
			$('#city').hide();
			$('#eg_session').hide();
			$(".form_type").val(product);

		 $('#exec_session').show();
		 $('#gobtn').show();
		  break;
		  
		case 'digital':
		 $('#digital_session').show();
		 $('#exec_session').hide();
		 
			$('#city').hide();
			$('#eg_session').hide();
		  break;
	}
	
});
jQuery(document).ready(function() {
	
$('#select_city').change(function(){
	var location=$(this).val();
    $('.location').val(location);
});

$('#getdate').click(function(){
	$('#myModal').removeClass("hide");
});	

$('#getrevenue').click(function(){
	
	var location=$('.location').val();
	var producttype=$('#Product').val();
	switch(producttype)
		{
		case 'EG':
		 var seg_month=$('#seg_month').val();
		 var eeg_month=$('#eeg_month').val();
		 var seg_session=$('#seg_session').val();
		 var eeg_session=$('#eeg_session').val();
		 var seg_year=$('#seg_year').val();
		 var eeg_year=$('#eeg_year').val();
		 var product=$('#egproucttype').val();
		 var data='location='+location+'&product='+product+'&seg_month='+seg_month+'&eeg_month='+eeg_month+'&seg_session='+seg_session+'&eeg_session='+eeg_session+'&seg_year='+seg_year+'&eeg_year='+eeg_year;
		 window.location="RevenueReports.php?"+data;
		  break;
		  
		  case 'EXEC':
		  var sexec_month=$('#sexec_month').val();
		 var eexec_month=$('#eexec_month').val();
		 var sexec_session=$('#sexec_session').val();
		 var eexec_session=$('#eexec_session').val();
		 var sexec_year=$('#sexec_year').val();
		 var eexec_year=$('#eexec_year').val();
		 var product=$('#execproucttype').val();
		 var data='location='+location+'&product='+product+'&sexec_month='+sexec_month+'&eexec_month='+eexec_month+'&sexec_year='+sexec_year+'&eexec_year='+eexec_year;
		 window.location="RevenueReports.php?"+data;
		 break;
		 
		 case 'DIGITAL':
		 var digitalfrom=$('.digitalfrom').val();
		 var digitalto=$('.digitalto').val();
		 var product=$('#digitalproucttype').val();
		 var data='location='+location+'&product='+product+'&digitalfrom='+digitalfrom+'&digitalto='+digitalto;
		 window.location="RevenueReports.php?"+data;
		 break;
		 
		
		
		}
		
	
});
	
	
	
$( "#from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 2,
			onSelect: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 2,
			onSelect: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
});	
	
	
$('.material_status').on('click',function(){
	var id=$(this).attr('title');
	
	$('#status').click();
	
	var postData ="materialid="+id;
		 jQuery.ajax({
			type: "POST",
			dataType: "json",
			data: postData,
			beforeSend: function(x) {
				if(x && x.overrideMimeType) {
					x.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			url: 'ajax/Actions.php',
			success: function(data) {
				// 'data' is a JSON object which we can access directly.
				// Evaluate the data.success member and do something appropriate...
				if (data.success == true){
					$('#hiddenid').val(data.Roid);
					$('.dropdown_status').val(data.Material_Status);
					
				}
				else{
					  alert('error in getting values');
				}
				
			}
});	
	
	
});


$('#submit_status').on('click',function(){
	
	var status_id=$('#hiddenid').val();
	var status_val=$('.dropdown_status').val();
	var data='shiddenid='+status_id+'&status_val='+status_val;
	
	$.ajax({
            url: "ajax/Actions.php",
            type: 'GET',
            dataType: 'html',
			data:data,
            success: function(data, textStatus, xhr) {
				if(data==1)
				{
					location.reload();
				}
				
			
		      }
                           
        });	
});


$('.instruction').on('click',function(){
	var id=$(this).attr('title');
	
	$('#instruction').click();
	
	var postData ="instructionid="+id;
		-
		 jQuery.ajax({
			type: "POST",
			dataType: "json",
			data: postData,
			beforeSend: function(x) {
				if(x && x.overrideMimeType) {
					x.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			url: 'ajax/Actions.php',
			success: function(data) {
				// 'data' is a JSON object which we can access directly.
				// Evaluate the data.success member and do something appropriate...
				if (data.success == true){
					$('#hiddenid2').val(data.Roid);
					$('#status_instruction').text(data.Insrtuctions);
					
				}
				else{
					  alert('error in getting values');
				}
				
			}
});	
	
});

$('#submit_ins').on('click',function(){
	
	var status_id=$('#hiddenid2').val();
	var status_instruction=$('#status_instruction').val();
	var data='shiddenid='+status_id+'&status_instruction='+status_instruction;
	
	$.ajax({
            url: "ajax/Actions.php",
            type: 'GET',
            dataType: 'html',
			data:data,
            success: function(data, textStatus, xhr) {
				if(data==1)
				{
					location.reload();
				}
				
			
		      }
                           
        });	
});
	
	
$('#submit_location').on('click',function(){
	var location=$('#user_city').val();
	if(location=='')
	{
		alert('Please select a location ');
	}
	else
	{
	
	window.location='IssuesReport.php?location='+location;
	}
});
	
$('#submit_year_month').on('click',function(){
	var month=$('#smonth').val();
	var year=$('#syear').val();
	window.location='DigitalForm.php?month='+month+'&year='+year;
});

$('#EditCompanyBtn').on('click',function(){
	var UserName=$('#UserName').val();
	var FirstName=$('#FirstName').val();
	var LastName=$('#LastName').val();
	var EmailId=$('#EmailId').val();
	var Role=$('#Role').val();
	var AllocatedIp=$('#AllocatedIp').val();
	var hiddenid=$('#hiddenid').val();
	
	var data='hiddenid='+hiddenid+'&UserName='+UserName+'&FirstName='+FirstName+'&LastName='+LastName+'&EmailId='+EmailId+'&Role='+Role+'&AllocatedIp='+AllocatedIp;
	
	$.ajax({
            url: "ajax/Actions.php",
            type: 'GET',
            dataType: 'html',
			data:data,
            success: function(data, textStatus, xhr) {
				if(data==1)
				{
				$('.msg_Success').show();
				
				
				}
				else
				{
				$('.msg_Error').show();	
				
				}
				
			
		      }
                           
         });
});


$('#editCompanyBtn2').on('click',function(){
	var CompanyName=$('#CompanyName').val();
	var ContactPerson=$('#ContactPerson').val();
	var CompanyAddress=$('#CompanyAddress').val();
	var CompanyPincode=$('#CompanyPincode').val();
	var CompanyPhone=$('#CompanyPhone').val();
	var CompanyEmail=$('#CompanyEmail').val();
	var Companyhiddenid=$('#hiddenid').val();
	
	var data='Companyhiddenid='+Companyhiddenid+'&CompanyName='+CompanyName+'&ContactPerson='+ContactPerson+'&CompanyAddress='+CompanyAddress+'&CompanyPincode='+CompanyPincode+'&CompanyPhone='+CompanyPhone+'&CompanyEmail='+CompanyEmail;
	
	
	$.ajax({
            url: "ajax/Actions.php",
            type: 'GET',
            dataType: 'html',
			data:data,
            success: function(data, textStatus, xhr) {
				if(data==1)
				{
				$('.msg_Success').show();
				
				
				}
				else
				{
				$('.msg_Error').show();	
				
				}
				
			
		      }
                           
         });
	
});
	
$('.status').on('click',function(){
	var id=$(this).attr('id');
	var status=$(this).attr('name');
	
	//alert(id+'--'+status);
	
	$.ajax({
            url: "ajax/Actions.php",
            type: 'GET',
            dataType: 'html',
			data:'AID='+id+'&status='+status,
            success: function(data, textStatus, xhr) {
				if(data==1)
				{
				location.reload();
				 
				}
				
			
		      }
                           
         });
});


	
$('.deleteuser').on('click',function(){
	var id=$(this).attr('name');
	if(confirm("Are you sure you want to delete this user?"))
	{
	$.ajax({
            url: "ajax/Actions.php",
            type: 'GET',
            dataType: 'html',
			data:'UserID='+id,
            success: function(data, textStatus, xhr) {
				if(data==1)
				{
				$('#row'+id).hide();
				}
				
			
		      }
                           
         });
	}
});

$('.companydelete').on('click',function(){
	var id=$(this).attr('name');
	if(confirm("Are you sure you want to delete this user?"))
	{
	$.ajax({
            url: "ajax/Actions.php",
            type: 'GET',
            dataType: 'html',
			data:'CompanyID='+id,
            success: function(data, textStatus, xhr) {
				if(data==1)
				{
				$('#row'+id).hide();
				}
				
			
		      }
                           
         });
	}
});

$('.editclient').on('click',function(){
	var id=$(this).attr('name');
	var postData ="companyid="+id;
		-
		 jQuery.ajax({
			type: "POST",
			dataType: "json",
			data: postData,
			beforeSend: function(x) {
				if(x && x.overrideMimeType) {
					x.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			url: 'ajax/Actions.php',
			success: function(data) {
				// 'data' is a JSON object which we can access directly.
				// Evaluate the data.success member and do something appropriate...
				if (data.success == true){
					jQuery('#hiddenid').val(data.CompanyId);
					jQuery('#CompanyName').val(data.CompanyName);
					jQuery('#ContactPerson').val(data.ContactPerson);
					jQuery('#CompanyAddress').val(data.Address);
					jQuery('#CompanyPincode').val(data.PinCode);
					jQuery('#CompanyPhone').val(data.Phone);
					jQuery('#CompanyEmail').val(data.Email);
				}
				else{
					 jQuery('#CompanyName').val(company_name);
					 jQuery('#message').html(company_name+" Account doesn't exist, please add the company details");
					 jQuery('.whitishBtn').click();
				}
				
			}
});		
});

$('.edituser').on('click',function(){
	var id=$(this).attr('name');
	var postData ="userid="+id;
		
		 jQuery.ajax({
			type: "POST",
			dataType: "json",
			data: postData,
			beforeSend: function(x) {
				if(x && x.overrideMimeType) {
					x.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			url: 'ajax/Actions.php',
			success: function(data) {
				// 'data' is a JSON object which we can access directly.
				// Evaluate the data.success member and do something appropriate...
				if (data.success == true){
					jQuery('#hiddenid').val(data.UserId);
					jQuery('#UserName').val(data.UserName);
					jQuery('#FirstName').val(data.UserFirstName);
					jQuery('#LastName').val(data.UserLastName);
					jQuery('#EmailId').val(data.UserEmail);
					jQuery('#Role').val(data.UserRole);
					jQuery('#AllocatedIp').val(data.UserIP);
					
					
				}
				else{
					 jQuery('#CompanyName').val(company_name);
					 jQuery('#message').html(company_name+" Account doesn't exist, please add the company details");
					 jQuery('.whitishBtn').click();
				}
				
			}
});	
	
	
});
	


$('#calculate_netpay').click(function(){
		
		var rowcount=$('#rowcount').val();
		
		for(var i = 0; i < rowcount; ++i) {
		
		var inseration=$('#inseration'+i).val();
		var OfferRate=$('#OfferRate'+i).val();
		var Rackrate=$('#RackRate'+i).val();
		
		var producttype= $("#form_type").val();
		
		if(producttype != 'DIGITAL')
		{
			if(Number(OfferRate) > Number(Rackrate))
			{
				$('.msg_Error').show();
				$('.msg_Error').html('<span class="iconsweet">X</span><p>Your Offer Rate Greater Than Rack Rate in row '+i+'</p>');
			
				
			}
			else
			{
				$('.msg_Error').hide();
			}
			
			var netpay=(Number(inseration)*Number(OfferRate));
			
			$('#total'+i).val(netpay);
			
		}else{

			var netpay=(Number(inseration)*Number(Rackrate));
			
			$('#total'+i).val(netpay);

		}
		
		
		}
	
		var add = 0;
                $(".total").each(function() {
//                	/alert($(this).val());
                    add += Number($(this).val());

                });
				
				$('#Net_Pay').val(add);
		});
	
			

	$('.OfferRate_row').on('keyup',function(){
		
		
		var rowcount=$('#rowcount').val();
		for(var i = 0; i < rowcount; ++i) {
		
		var inseration=$('#inseration'+i).val();
		var OfferRate=$('#OfferRate'+i).val();
		var Rackrate=$('#RackRate'+i).val();
		
		if(Number(OfferRate) > Number(Rackrate))
		{
			$('.msg_Error').show();
			$('.msg_Error').html('<span class="iconsweet">X</span><p>Your Offer Rate Greater Than Rack Rate in row '+i+'</p>');
		
			
		}
		else
		{
			$('.msg_Error').hide();
		}
		
		
		var netpay=(Number(inseration)*Number(OfferRate));
		
		$('#total'+i).val(netpay);
		
		
		}
	});	

$('#roform :checkbox').on("change",function(){
	
	var form_type = $("#form_type").val();
	
				var rowcount=$('#rowcount').val();
				
				var value=$(this).val();
				
				var check=$('#roform  :checkbox').filter(":checked").length;

				var i;
				var row=1;

			    if(form_type == 'DIGITAL')
			    {
			    	var case_validation = 'checked';
			    	
			    	var ij = $(this).attr('class');
			    	var nos = ij.substring(8, 9);
			    	
			    	var start_date = $("#start_date"+nos).val();
			    	var end_date = $("#end_date"+nos).val();
			    	var case_count = $("#case_count"+nos).val();

			    	var checkrow = $(this).val();
			    	
			    	var test = $(this).attr('checked');
			    	
			    	if(test != 'checked')
			    		case_validation = 'unchecked';
			    	
			    	digital_count( nos, start_date, end_date, checkrow, case_validation, case_count );
			    	
			    }else{

					$('#Total_Insertions').val(check);
					
					for(i = 0; i < rowcount; ++i) {
	
					var count_limit = $('#row'+i+' :checkbox').filter(":checked").length;
					
				    $('#rowcount').val(++row);
				    
				    if($(this).attr('class')=='checkrow'+i+'')
					{
						$('#inseration'+i+'').val(count_limit);
											
					}else if($(this).attr('class')=='checkrows'+i+''){
						
						$('#inseration'+i+'').val(count_limit);
					}
					else
					{
						$('#inseration'+i+'').val(count_limit);	
					}
								
					}	
			    }
	
});
	
$('.AddType').on("change",function(){
		var addtype=$(this).val();
		var id=$(this).attr("id");
		var producttype=$(this).attr('title');
		$.ajax({
              url: root_dir+"forms/Get_Rack_Rate/",
              type: 'GET',
              dataType: 'html',
				data:'AddType='+addtype+'&PType='+producttype,
                success: function(data, textStatus, xhr) {
			
					$('#RackRate'+id).val(data);

			}
                           
         });
	 });	
	
	
	
jQuery('#AddCompanyBtn').click(function(){
	
	  $('#addcompany').validationEngine();
		
		var CompanyName=jQuery('#CompanyName').val();
		var ContactPerson=jQuery('#ContactPerson').val();
		var CompanyAddress=jQuery('#CompanyAddress').val();
		var CompanyPincode=jQuery('#CompanyPincode').val();
		var CompanyFax=jQuery('#CompanyFax').val();
		var CompanyPhone=jQuery('#CompanyPhone').val();
		var CompanyEmail=jQuery('#CompanyEmail').val();
		
		if(ContactPerson=='')
		{
			$('#ContactPersoninfo').show();
			return false;
		}
		if(CompanyAddress=='')
		{
			$('#CompanyAddressinfo').show();
			return false;
		}
		if(CompanyPincode=='')
		{
			$('#CompanyPincodeinfo').show();
			return false;
		}
		if(CompanyPhone=='')
		{
			$('#CompanyPhoneinfo').show();
			return false;
		}
		if(CompanyEmail=='')
		{
			$('#CompanyEmailinfo').show();
			return false;
		}
		
		
		jQuery.ajax({
                            url: "ajax/Add_Company.php",
                            type: 'POST',
                            dataType: 'html',
							data:'CompanyName='+CompanyName+'&ContactPerson='+ContactPerson+'&CompanyAddress='+CompanyAddress+'&CompanyPincode='+CompanyPincode+'&CompanyFax='+CompanyFax+'&CompanyFax='+CompanyFax+'&CompanyPhone='+CompanyPhone+'&CompanyEmail='+CompanyEmail,
                            success: function(data, textStatus, xhr) {
								
								
								
								jQuery('#addcompany_form').find(':input').each(function() {
														switch(this.type) {
															case 'password':
															case 'select-multiple':
															case 'select-one':
															case 'text':
															case 'textarea':
																jQuery(this).val('');
																break;
															case 'checkbox':
															case 'radio':
																this.checked = false;
														}
													});
								
								
								if(data==1)
								{
								jQuery('.close').click();
								jQuery('#display_populate_hide').show();
								jQuery('#contact_person_hide').val(ContactPerson);
								jQuery('#address_hide').val(CompanyAddress);
								jQuery('#pin_hide').val(CompanyPincode);
								jQuery('#fax_hide').val(CompanyFax);
								jQuery('#phone_hide').val(CompanyPhone);
								jQuery('#email_hide').val(CompanyEmail);
								}
								
 
							}
                           
                        });
		
	});	
	
	
/*jQuery( "#company_name" ).autocomplete({
			source: root_dir+"forms/Search/",
			minLength: 2,
			select: function( event, ui ) {
			jQuery(this).val(ui.item.label);
			return false;
			
				log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );
			}
		});
*/	


var company_name = $("#company_name").val();

if(company_name != '')
{
	var params = "company_id="+$("#company_name").val();
	
	$.ajax({
	       type: "POST",
	       url: root_dir+"forms/Get_Company_Info/",
	       data: params,
	       dataType: "json",
	       async: false,
	       success: function(sresponse){
		
	    	   $("#contact_person_hide").val(sresponse.company_name);
	    	   $("#address_hide").val(sresponse.address);
	    	   $("#pin_hide").val(sresponse.pincode);
	    	   $("#phone_hide").val(sresponse.contact_no);
	    	   $("#email_hide").val(sresponse.email_id);
	       }
		});
}


jQuery("#company_name").on("change", function(){
	
	var company_id = $(this).val();
	
	var params = "company_id="+company_id;

	$.ajax({
       type: "POST",
       url: root_dir+"forms/Get_Company_Info/",
       data: params,
       dataType: "json",
       async: false,
       success: function(sresponse){
    	   
    	   $("#contact_person_hide").val(sresponse.company_name);
    	   $("#address_hide").val(sresponse.address);
    	   $("#pin_hide").val(sresponse.pincode);
    	   $("#phone_hide").val(sresponse.contact_no);
    	   $("#email_hide").val(sresponse.email_id);
       }
	});
    	
	
});
	
jQuery(".go_populate").click(function(){
var company_name=jQuery('#company_name').val();
var postData ="company="+company_name;

 jQuery.ajax({
    type: "POST",
    dataType: "json",
    data: postData,
    beforeSend: function(x) {
        if(x && x.overrideMimeType) {
            x.overrideMimeType("application/json;charset=UTF-8");
        }
    },
    url: 'ajax/Roform_AutoPopulate.php',
    success: function(data) {
        // 'data' is a JSON object which we can access directly.
        // Evaluate the data.success member and do something appropriate...
        if (data.success == true){
            jQuery('#contact_person_hide').val(data.ContactPerson);
			jQuery('#address_hide').val(data.Address);
			jQuery('#pin_hide').val(data.PinCode);
			jQuery('#phone_hide').val(data.Phone);
			jQuery('#email_hide').val(data.Email);
        }
        else{
			 jQuery('#CompanyName').val(company_name);
			 jQuery('#message').html(company_name+" Account doesn't exist, please add the company details");
             jQuery('.whitishBtn').click();
        }
    }
});	
								
								
								
 });






	/*Project Sort*/
	  // get the action filter option item on page load
  var jQueryfilterType = $('.filter_project li.selected a').attr('class');
	
  // get and assign the ourHolder element to the
	// $holder varible for use later
  var $holder = $('ul.project_list');

  // clone all items within the pre-assigned $holder element
  var $data = $holder.clone();

  // attempt to call Quicksand when a filter option
	// item is clicked
	$('.filter_project li a').click(function(e) {
		// reset the active class on all the buttons
		$('.filter_project li').removeClass('selected');		
		// assign the class of the clicked filter option
		// element to our $filterType variable
		var $filterType = $(this).attr('class');
		$(this).parent().addClass('selected');
		
		if ($filterType == 'all') {
			// assign all li items to the $filteredData var when
			// the 'All' filter option is clicked
			var $filteredData = $data.find('li');
		} 
		else {
			// find all li elements that have our required $filterType
			// values for the data-type element
			var $filteredData = $data.find('li[data-type=' + $filterType + ']');
		}
		
		// call quicksand and assign transition parameters
		$holder.quicksand($filteredData, {duration: 800, easing: 'easeInOutQuad'}, function(){
			initTip();
			initPop();
		});
		
		return false;
	});
	
		initTip();
		initPop();
	

	
	
	/*MESSAGES*/
		//Alert
	$("div.msgbar").click(function(){
		$(this).slideUp();
	});
	
	/*AUTOGROW TEXTAREA*/
//    $("#txtInput").autoGrow();

	
	/* FORM ELEMENTS*/
//	$("select, input:checkbox, input:radio").uniform(); 

	/*WYSWIG*/
		//editor = $("#wyswig").cleditor({width:"100%", height:"100%"});
		//$(window).resize();


	/*FILE UPLOAD*/
	// <![CDATA[
/*	  $('#file_upload').uploadify({
		'uploader'  : './uploadify/uploadify.swf',
		'script'    : './uploadify/uploadify.php',
		'cancelImg' : './uploadify/cancel.png',
		'folder'    : './uploads',
		'fileExt'   : '*.jpg;*.gif;*.png',
		'multi'     : true,
		'sizeLimit' : 400000
	  });
*/	// ]]>
	
	/*JQUERY UI*/
	$( "#slider" ).slider();
	$( "#slider_range_m" ).slider({
			value:100,
			min: 0,
			max: 500,
			step: 50,
			slide: function( event, ui ) {
				$( "#amount" ).val( "$" + ui.value );
			}
		});
		$( "#amount" ).val( "$" + $( "#slider_range_m" ).slider( "value" ) );	
		
		
		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 500,
			values: [ 75, 300 ],
			slide: function( event, ui ) {
				$( "#amount_range" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			}
		});
		$( "#amount_range" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
			" - $" + $( "#slider-range" ).slider( "values", 1 ) );	
			
		$( "#slider-range-max" ).slider({
			range: "max",
			min: 1,
			max: 10,
			value: 2,
			slide: function( event, ui ) {
				$( "#amount_max" ).val( ui.value );
			}
		});
		$( "#amount_max" ).val( $( "#slider-range-max" ).slider( "value" ) );				

		$( "#slider-range-min" ).slider({
			range: "min",
			value: 37,
			min: 1,
			max: 700,
			slide: function( event, ui ) {
				$( "#amount_min" ).val( "$" + ui.value );
			}
		});
		$( "#amount_min" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
		
		/*Progress Bar*/
		$( "#progressbar" ).progressbar({
			value: 37
		});
		
		/*Date Picker*/
		$( "#datepicker" ).datepicker();
		
		$( "#datepicker_inline" ).datepicker();
		
		/*Tabs*/
		
		$( "#tabs" ).tabs();
		
		/*Full Calendar*/
		$('#full_calendar').fullCalendar({
		
			// US Holidays
			events: 'http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic',
			
			eventClick: function(event) {
				// opens events in a popup window
				window.open(event.url, 'gcalevent', 'width=700,height=600');
				return false;
			},
			
			loading: function(bool) {
				if (bool) {
					$('#loading').show();
				}else{
					$('#loading').hide();
				}
			}
			
		});
		
		/*Modal Window*/
/*		function modal(){
		$('#myModal').modal();
		}
*/

/*Code Highlighter*/
		//$('pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
		
});


	function initTip()
	{
		jQuery('.tip_north').tipsy({gravity: 's'});
		jQuery('.tip_south').tipsy({gravity: 'n'});
		jQuery('.tip_east').tipsy({gravity: 'e'});
		jQuery('.tip_west').tipsy({gravity: 'w'});
	}
	
	function initPop()
	{
	}
	
	
	
	
	function digital_count( i, start_date, end_date, checkrow, case_validation, case_count)
	{
		
		$.ajax({
              url: root_dir+"calc/Get_Count_Insertions/",
              type: 'GET',
			  data:'start_date='+start_date+'&end_date='+end_date+"&checkrow="+checkrow+"&case_validation="+case_validation+"&case_count="+case_count,
                success: function(data, textStatus, xhr) {

				if(data > 0){
 					$('#inseration'+i+'').val(data);
					$("#case_count"+i+'').val( data );

			    	
				}else{

					$("#case_count"+i+'').val(0);
					$('#inseration'+i+'').val( 0 );
					$("#total_count").val( 0 );
					
				}	

		    	var total_count = 0;
				
		    	for(k= 0; k <= i; k++ )
		    	{
	
		    		var insertions = $("#inseration"+k).val();
	
					$("#total_count").val( insertions );
	
		    		total_count += Number(insertions);
	
		    		$("#Total_Insertions").val(total_count);
	
		    	}

			}
			
                           
         });
	}