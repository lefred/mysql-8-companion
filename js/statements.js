jQuery(document).ready(function ($) {
    
    $('.cell-data').on('click', function() {
            var $this = $(this);
            var digest = $this.data('id');
            var elements = document.querySelectorAll(".query-line");
            elements.forEach(element => { 
                element.style.display = "none";
                
            });
            var element = document.getElementById(digest);
            element.style.display = "revert";
            console.log("DIGEST: ",digest);
            var data = {
                'action': 'm8c_get_statement_details',
                'nonce': m8cstatements.nonce,
                'type': "POST",
                'digest': digest
            }
            $.post(m8cstatements.ajaxUrl, data, function(response) {                
                 var element = document.getElementById(digest);
                 var result = "<table class='m8c-query-tab'>";
                 result += "<tr><th>Normalized Query</th></tr>";
                 result += "<tr><td colspan='2'><pre class='m8c-query'>"+ response.data['query'] + "</pre></td></tr>";
                 result += "<tr><th>Query Sample</th></tr>";
                 result += "<tr><td colspan='2'><pre class='m8c-query'>"+ response.data['query_sample_text'] + "</pre></td></tr>";
                 result += "<tr><td><table class='m8c-stats-tab'>";
                 result += "<th>Rows Sent:</th><td>"+  response.data['rows_sent'] +"</td>";
                 result += "<th>Rows Sent Avg:</th><td>"+  response.data['rows_sent_avg'] +"</td>";
                 result += "<th>Rows Examined:</th><td>"+  response.data['rows_examined'] +"</td>";
                 result += "<th>Rows Examined Avg:</th><td>"+  response.data['rows_examined_avg'] +"</td>";
                 result += "</tr><tr>";
                 result += "<th>Temp Tables to Disk</th><td>"+  response.data['sum_created_tmp_disk_tables'] +"</td>";
                 result += "<th>Temp Tables to Disk Avg</th><td>"+  response.data['sum_created_tmp_disk_tables']/response.data['exec_count'] +"</td>";
                 result += "<th>Select Full Join</th><td>"+  response.data['sum_select_full_join'] +"</td>";
                 result += "<th>Select Full Join Avg</th><td>"+  response.data['sum_select_full_join']/response.data['exec_count'] +"</td>";
                 result += "</tr><tr>";
                 result += "<th>Select Full Range Join</th><td>"+  response.data['sum_select_full_range_join'] +"</td>";
                 result += "<th>Select Full Range Join Avg</th><td>"+  response.data['sum_select_full_range_join']/response.data['exec_count'] +"</td>";
                 result += "<th>Select Range</th><td>"+  response.data['sum_select_range'] +"</td>";
                 result += "<th>Select Range Avg</th><td>"+  response.data['sum_select_range']/response.data['exec_count'] +"</td>";
                 result += "</tr><tr>";
                 result += "<th>Full Table Scan</th><td>"+  response.data['sum_select_scan'] +"</td>";
                 result += "<th>Full Table Scan Avg</th><td>"+  response.data['sum_select_scan']/response.data['exec_count'] +"</td>";
                 result += "<th>No Index Used</th><td>"+  response.data['sum_no_index_used'] +"</td>";
                 result += "<th>No Index Used Avg</th><td>"+  response.data['sum_no_index_used']/response.data['exec_count'] +"</td>";
                 result += "</tr><tr>";
                 result += "<th>Sort Rows</th><td>"+  response.data['sum_sort_rows'] +"</td>";
                 result += "<th>Sort Rows Avg</th><td>"+  parseFloat((response.data['sum_sort_rows']/response.data['exec_count']).toFixed(2)) +"</td>";
                 result += "<th>Sort Scan</th><td>"+  response.data['sum_sort_scan'] +"</td>";
                 result += "<th>Sort Scan Avg</th><td>"+  response.data['sum_sort_scan']/response.data['exec_count'] +"</td>";
                 result += "</tr><tr>";
                 result += "<th>Max Latency:</th><td>"+  response.data['max_latency'] +"</td>";
                 result += "<th>Max Total Memory:</th><td>"+  response.data['max_total_memory'] +"</td>";
                 result += "</tr></table></td></tr>";
                 result +="</table>";
                 element.firstChild.innerHTML=result;
            });
    });

});
