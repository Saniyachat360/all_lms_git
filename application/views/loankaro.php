<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<div class="container">
    <div class="row" id="leaddiv">
        <div id="replacediv">
            <h1 style="text-align:center;">Loankaro</h1>
            <div class="row">
                <table id="loan_details" class="display table">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Data Source</th>
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>Caller Name</th>
                            <th>Disposition</th>
                            <th>Product</th>
                            <th>Bank/NBFC</th>
                            <th>Status</th>
                            <th>Loan Amount</th>
                            <th>Call Date</th>
                            <th>Customer Remark</th>
                            <th>Followup 1 Date</th>
                            <th>Followup 1 Remark</th>
                            <th>Followup 2 Date</th>
                            <th>Followup 2 Remark</th>
                            <th>Manufacture</th>
                            <th>Model</th>
                            <th>Old Car Chassis No</th>
                            <th>New Car Model</th>
                            <th>New Car Variant</th>
                            <th>Registration No</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#loan_details').DataTable({
        "processing": true,
        "serverSide": false, 
        "ajax": {
            "url": "<?php echo site_url('Loankaro/fetch_loan_details'); ?>",
            "type": "POST",
            "dataType": "json",
            "dataSrc": function (json) {
                for (var i = 0, len = json.data.length; i < len; i++) {
                    json.data[i]['sr_no'] = i + 1; 
                    for (var key in json.data[i]) {
                        if (json.data[i].hasOwnProperty(key)) {
                            if (json.data[i][key] === null || json.data[i][key] === '') {
                                json.data[i][key] = 'NA';
                            }
                        }
                    }
                }
                return json.data; 
            }
        },
        "columns": [
            { "data": "sr_no" },
            { "data": "lead_source" },
            { "data": "customer_name" },
            { "data": "phone_number" },
            { "data": "caller_name" },
            { "data": "disposition" },
            { "data": "product" },
            { "data": "bank_nbfc" },
            { "data": "status" },
            { "data": "loanamount" },
            { "data": "call_date" },
            { "data": "customer_remark" },
            { "data": "followup_1_date" },
            { "data": "followup_1_remark" },
            { "data": "followup_2_date" },
            { "data": "followup_2_remark" },
            { "data": "manufacture" },
            { "data": "model" },
            { "data": "chasis_no" },
            { "data": "new_car_model" },
            { "data": "new_car_variant" },
            { "data": "reg_no" },
            { "data": "remark" }
        ],
        "scrollY": "400px",
        "scrollX": true,
        "scrollCollapse": true, 
        "paging": true 
    });
});
</script>
