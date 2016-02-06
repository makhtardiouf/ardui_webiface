<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">             
        <meta name="description" content="Arduino control and monitoring interface">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Makhtar Diouf">   
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/app.css">          

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="js/app.js"></script>       
        <title> Arduino control and monitoring interface - Makhtar </title>        
    </head>
    <body> <!--  Top Header --> 
        <div class="container-fluid header">
            <div class="jumbotron"> 
                <h4> Arduino control and monitoring interface - Makhtar </h4> 
                <progress id="pbar"> </progress>  
                <br>Displaying data for: <?php echo date("Y-m-d"); require_once 'read.php'; ?> ...
            </div>                
        </div>

        <!-- Main content -->
        <div class="view-container container-fluid content">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <button type="button" class="btn btn-success" data-toggle="modal" 
                            data-target="#popup" onclick="setLastData('Humidity: <?php ArduiData::readLastData('hum') ?>');">Humidity</button>
                    
                    <button type="button" class="btn btn-primary">Sound</button>
                    <button type="button" class="btn btn-danger">Temperature</button>
                    <button type="button" class="btn btn-warning">Light</button>                    
                </div>
                <div class="col-md-1">
                    <a href="#" id="arduinput" data-toggle="popover" title="Popover Header" data-content="" onclick="sendInput('alert');">
                        <button type="button" class="btn btn-danger">Send Alert</button>
                    </a>
                </div>
            </div>

            <!-- Generate the javascript for plotting graph with Google API
            https://developers.google.com/chart/interactive/docs/gallery/linechart -->
            <div id="graphs"> <?php require_once 'visualize.php'; ?> </div>

            <div class="row" id="graph1">               
                <div class="col-md-3" id="hum"></div>          
                <div class="col-md-3" id="sound"></div>                  
            </div>
            <div class="row" id="graph2">                
                <div class="col-md-3" id="light"></div>           
                <div class="col-md-3" id="temp"></div>   
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <!-- Display logs of received requests in a textarea -->
                    <h5>Output: </h5>
                    <textarea rows="10" cols="100" id="output"></textarea>
                </div>        
            </div>

            <div id="popup" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">     
                        <div class="modal-body">
                            <p id="lastData">Data not loaded...</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row footer"> 
                <div class="col-md-12"> 
                    <p><i>By <a href="mailto:makhtar.diouf@gmail.com">Elhadji Makhtar Diouf - 2015-2016</a></i></p>        
                    <p> Graphs generated with Google JS API: <a href="https://developers.google.com/chart/interactive/docs/gallery/linechart" target="_blank">
                            https://developers.google.com/chart/interactive/docs/gallery/linechart</a><p>
                </div>               
            </div>
        </div>    
    </body>
</html>
