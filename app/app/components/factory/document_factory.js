'use strict';

angular.module('myApp.dokumen_factory',[])

.factory('Dokumen',function(){
	return {

			tabel : function(){

			}, tanggal :function(){

		        $('#birthday').daterangepicker({
		          singleDatePicker: true,
		          calender_style: "picker_4",
		      
		            format: 'DD-MM-YYYY'
		        
		        }, function(start, end, label) {
		          console.log(start.toISOString(), end.toISOString(), label);
		        });

			},select2 : function(){
			        $(".select2_single").select2({
			          placeholder: "Select a state",
			          allowClear: true
			        });
			        $(".select2_group").select2({});
			        $(".select2_multiple").select2({
			          maximumSelectionLength: 9,
			          placeholder: "With Max Selection limit 4",
			          allowClear: true
			        });
			}

		
	}
})

