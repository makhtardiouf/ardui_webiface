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
        <title> Arduino control and monitoring interface</title>        
    </head>
    <body> <!--  Top Header --> 
        <div class="container header">
            <div class="jumbotron"> 
                <h4> Arduino control and monitoring interface</h4> 
                <progress id="pbar"> </progress>  
                <br>Displaying data for: <?php echo date("Y-m-d"); 
                $_SESSION["error_msg"] = "";
                require_once 'read.php'; ?> ...
            </div>                
        </div>

        <!-- Main content -->
        <div class="view-container container content">
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
                        <button type="button" class="btn btn-danger">Send Command</button>
                    </a>
                </div>
            </div>

            <!-- Generate the javascript code for plotting graphes with Google API
            https://developers.google.com/chart/interactive/docs/gallery/linechart -->
            <div id="graphs"> <?php require_once 'visualize.php'; ?> </div>

            <div class="row" id="graph1">
                <div class="col-md-1"></div>
                <div class="col-md-5" id="hum">Test</div>          
                <div class="col-md-5" id="sound"></div>                  
            </div>
            <div class="row" id="graph2">  
                <div class="col-md-1"></div>
                <div class="col-md-5" id="light"></div>           
                <div class="col-md-5" id="temp"></div>   
            </div>
            
            <div class="row">
                <div class="col-md-1"> </div>
                <div class="col-md-10">
                    <!-- Display logs of received requests -->
                    <h5>Output: </h5>
                    <textarea rows="10" cols="150" id="output"></textarea>
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
            
            <br/><div class="alert-warning"><?php echo $_SESSION["error_msg"]; ?></div>
            
            <div class="row footer"> 
                <div class="col-md-12"> 
                    <p><i>&copy; 2015-<?php echo date("Y"); ?> <a href="mailto:makhtar.diouf@gmail.com">Makhtar Diouf</a></i></p>        
                    <p><a href="https://developers.google.com/chart/interactive/docs/gallery/linechart" target="_blank">
                             Graphs generated with Google JS API</a><p>
                </div>               
            </div>
        </div>    
    </body>
</html>
