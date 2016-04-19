<!-- Process received data, and display charts - Makhtar Diouf -->

<script type="text/javascript">
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages': ['corechart']});
    google.setOnLoadCallback(drawChart);

<?php
$charts = ['hum', 'sound', 'light', 'temp'];
?>
    function drawChart() {
        var jsonData = $.ajax({
            url: "read.php",
            dataType: "json",
            async: true
        }).responseText;

        // Create our data table out of JSON data loaded from server.
        var data;
        var options;
        var chart;
<?php
$i = 0;
for (; $i < sizeof($charts); $i++) {
    ?>

            data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Time');
    <?php
    echo "\t\t\t data.addColumn('number', '" . $charts[$i] . "');" .
    "\n\t\t\t data.addRows([ ";

    require_once 'read.php';
    $obj = new ArduiData();
    json_encode($obj->getData($charts[$i]));
    ?>
            ]);
            options = {
                title: '<?php echo $charts[$i]; ?> vs time',
                curveType: 'function',
                legend: {position: 'top'},
                width: 500,
                height: 300
            };

            // Instantiate and draw our chart
            chart = new google.visualization.LineChart(document.getElementById('<?php echo $charts[$i]; ?>'));
            chart.draw(data, options);
<?php } ?>
    }
</script>