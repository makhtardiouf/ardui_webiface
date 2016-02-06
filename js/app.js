'use strict';

/* 
 * 
 * Makhtar Diouf<makhtar.diouf@gmail.com>
 * $Id$
 **/

var reloadTime = 5000;

function reloadGraphs() {
    setTimeout(function () {
        //  $("#graphs").load("../visualize.php");
        location.reload();
        //  reloadGraphs();
    }, reloadTime * 8);

}

function loadOutput() {
    // setTimeout(function () {
    $("#output").load("../rxdata.log");
    $("#output").scroll();
    //     loadOutput();
    //  }, reloadTime / 2);
}

function setTitle(title) {
    $('#title').text(title);
}

function sendInput(arg) {
    //  $("#arduinput").load("../txdata.php");
    $("#output").append("Sending to the arduino board: " + arg + "...");
    var url = "http://192.168.0.139:9000?msg=";
    url = "http://localhost:9000?msg="; // test
    $.get(url + arg, function (resp) {

        var msg = "Response from arduino board: " + resp;
        console.log(msg);
        $("#output").append(msg);
        $('[data-toggle="popover"]').popover();
        $("data-content").load(resp);

    });
}

function setLastData(data) {
     $("#lastData").html(data);
}

$(document).ready(function () {
    loadOutput();
    reloadGraphs();
    //  $("#pbar").hide();
});
