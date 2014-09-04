
	var dash_init = function( start_date, end_date ){
		if(start_date == 0 && end_date == 0){
			date = new Date();
			start_date = date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate();
			end_date = moment().add('days', -30);
			
			end_date = moment(end_date).format('YYYY-MM-DD');
		}
		$('.loading').html('<img src="'+root_dir+'assets/files/loading.gif" height="40" width="40"> ');
		$.ajax({
		               url: root_dir+"home/LeaderBoard/",
		               type: 'GET',
		               dataType: 'json',
			data:'start_date='+start_date+'&end_date='+end_date,
                		success: function(data, textStatus, xhr) {
		    		$("#total_earning").html(data.total_earning);
		    		$("#total_clients").html(data.total_clients);
		    		$("#total_products").html(data.total_products);
		    		$("#total_users").html(data.total_users);
		    		$("#total_adtype").html(data.total_adtype);
			}
		         });
         	}

dash_init(  0, 0);