/*
*  Custom js
*/
jQuery(document).ready(function(){


  //Get bc plan by menber
  jQuery(document).on('change', '#member_id', function(e) {
    e.preventDefault();
    var target = jQuery(this);

    var member_id = target.find(':selected').val();

    console.log('member_id: ', member_id);

	jQuery.ajax({
		url: "{{ url('payments/get_bc_plan_by_member') }}",
		type: "POST",
		data:  {
		    member_id: member_id, // search query
		    _token: "{{ csrf_token() }}",
		 },
		dataType: 'json',
		//contentType: false,
		//processData:false,
		beforeSend: function(){
		},
		complete: function(){
		},
		success: function(data){

		 	console.log('data: ', data);
		  
		}       
	});
    
  });


});