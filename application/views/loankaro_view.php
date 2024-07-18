<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Details</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination li {
            list-style: none;
            margin: 0 5px;
            display: inline-block;
        }
        .pagination li a {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .pagination li a:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .pagination .active a {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align:center;">Loankaro</h1>
        <div class="control-group" id="blah" style="margin:0% 30% 1% 50%"></div>

        <div class="table-responsive">
            <table id="example" class="table" style="width:100%">
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
                    
                    <?php foreach ($loan_details as $key => $row) : ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo !empty($row['lead_source']) ? $row['lead_source'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['customer_name']) ? $row['customer_name'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['phone_number']) ? $row['phone_number'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['caller_name']) ? $row['caller_name'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['disposition']) ? $row['disposition'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['product']) ? $row['product'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['bank_nbfc']) ? $row['bank_nbfc'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['status']) ? $row['status'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['loanamount']) ? $row['loanamount'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['call_date']) ? $row['call_date'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['customer_remark']) ? $row['customer_remark'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['followup_1_date']) ? $row['followup_1_date'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['followup_1_remark']) ? $row['followup_1_remark'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['followup_2_date']) ? $row['followup_2_date'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['followup_2_remark']) ? $row['followup_2_remark'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['manufacture']) ? $row['manufacture'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['model']) ? $row['model'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['chasis_no']) ? $row['chasis_no'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['new_car_model']) ? $row['new_car_model'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['new_car_variant']) ? $row['new_car_variant'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['reg_no']) ? $row['reg_no'] : 'NA'; ?></td>
                            <td><?php echo !empty($row['remark']) ? $row['remark'] : 'NA'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="text-align: center;">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                searching: false,
                scrollY: "400px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    leftColumns: 0,
                    rightColumns: 0
                }
            });
        });
    </script>
</body>
</html>
