jQuery(document).ready(function ($) {
    
    $('.m8c-qep').on('click', function() {
            var $this = $(this);
            var digest = $this.data('id');
            $(".spinner").addClass("is-active"); 
            var elements = document.querySelectorAll(".m8c-qep-det");
            elements.forEach(element => { 
                element.style.display = "none";
                
            });
            var data = {
                'action': 'm8c_get_qep_details',
                'nonce': m8cqep.nonce,
                'type': "POST",
                'digest': digest
            }
            $.post(m8cqep.ajaxUrl, data, function(response) {                
                 var element = document.getElementById(digest);
                 // check is key exist
                 if('query_cost' in response.data) {
		            var query_block = JSON.parse(response.data['query_cost']['EXPLAIN']);
                    var result = "<h4 class='m8c-qep-det' style='border: 0px;'>Query Cost: " + query_block.query_block.cost_info.query_cost + "</h4>"; 
                 } else {
                    var result = "<h4 class='m8c-qep-det' style='border: 0px;'>Query Cost: N/A</h4>"; 
                 }
	             result += "<pre class='m8c-qep-det'>" + response.data['EXPLAIN'] + "</pre>"; 
                 element.firstChild.innerHTML+=result;
                 $(".spinner").removeClass("is-active");
            });
    });
});
