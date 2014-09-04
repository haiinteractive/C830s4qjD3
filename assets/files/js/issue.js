// JavaScript Document
$(function() {
	
	$('#issuereport').validationEngine();
	$('#masterclientlist').validationEngine();
	
	$('.material_status').live('click',function(){
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

$('#submit_status').live('click',function(){
	
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


$('.instruction').live('click',function(){
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

$('#submit_ins').live('click',function(){
	
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
	
	
	$('#Product').change(function(){
		$('#gobtn').show();
		var value=$(this).val();
		if(value=='EG')
		{
			$('#eg_session').show();
			$('#city').show();
			$('#exec_session').hide();
			$('#digital_session').hide();
			
			
		}
		if(value=='EXEC')
		{
			$('#exec_session').show();
			$('#eg_session').hide();
			$('#digital_session').hide();
			$('#city').show();
		}
		if(value=='DIGITAL')
		{
			$('#digital_session').show();
			$('#city').show();
			$('#exec_session').hide();
			$('#eg_session').hide();
		}
		
	});
	
	
	$('#view_issue').toggle(function(){
		$(this).text('Close Detailed Issue Report');
		$('#show_issue_details').show();
		$('#tabs').hide();
	},function(){ $(this).text('Click here to View Detailed Issue Report');$('#show_issue_details').hide(); $('#tabs').show(); });
	
	
	//populate issue reports
	$('#populate').click(function(){
		var value=$('#Product').val();
		switch(value)
		{
		case 'EG':
		  var city=$('#select_city').val();
		  var month=$('#eg_month').val();
		  var year=$('#eg_year').val();
		  var session=$('#session').val();
		  var data='product='+value+'&city='+city+'&month='+month+'&year='+year+'&session='+session;
		  
		 
		  break;
		case 'EXEC':
		  var city=$('#select_city').val();
		  var month=$('#exec_month').val();
		  var year=$('#exec_year').val();
		   var data='product='+value+'&month='+month+'&year='+year+'&city='+city;
		  
		  break;
		case 'DIGITAL':
		  var city=$('#select_city').val();
		  var month=$('#digital_month').val();
		  var year=$('#digital_year').val();
		   var data='product='+value+'&city='+city+'&month='+month+'&year='+year;
		  
		  break;
		
		}
		
		
		
		
		
		
		
	});
	

});