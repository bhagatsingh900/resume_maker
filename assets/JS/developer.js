$( document ).ready(function() {
			 var i=0;
					var table = $('#employee').dataTable({
					"bProcessing": true,
					"sAjaxSource": "getUserList",
					"bPaginate":true,
					"sPaginationType":"full_numbers",
					"iDisplayLength": 5,
					"aoColumns": [
																			
										{ data:  null, render: function ( data, type, row ) { 
														i++;
														return i;
												
										}},
										
										{ data:  null, render: function ( data, type, row ) {
															//if(data.id == 'undefined' || data.id==null){
															//        return "<label>"+data.id+"</label>";
															//         }
															//        else{
															//        return data.name;
															//     }
															
															return data.name; 
											}},																				
										{ data:  null, render: function ( data, type, row ) {               
													return data.email;
										}},
										{ data:  null, render: function ( data, type, row ) {               
													return data.mobile;
										}},
										{ data:  null, render: function ( data, type, row ) {               
													return data.created_at;
										}},
										{ data:  null, render: function ( data, type, row ) {               
													if(data.status==0){
														return "<span style='color:red;font-weight:bolder'>Inactive</span>";
													}else{
														return "<span style='color:green;font-weight:bolder'>Active</span>";
													}
													return "<a href='#' class='btn btn-danger'>Deactive</a>";
										}},
										{ data:  null, render: function ( data, type, row ) {               
													return "";
										}},
										 
					]
					});
			});
		
		
		/*	$( document ).ready(function() {
              var  cnt=0;
						 $('#employee').dataTable({
							"bProcessing": true,
							"sAjaxSource": "getUserList",
							"bPaginate":true,
							"sPaginationType":"full_numbers",
							"iDisplayLength": 10,
							"aoColumns": [
															{ mData: 'count' } ,
															{ mData: 'product_name' } ,
															//{ mData: 'gems_stone_info' },
															{ mData: 'diamond_info' },
															{ mData: 'product_sku' } ,
															{ mData: 'product_price' } ,
															{ mData: 'product_view' }, 
															{ mData: 'product_status' }, 
															{ mData: 'edit' }
									]
							});
                        });
					
	 */