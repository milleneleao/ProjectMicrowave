/*
<!-- 
File:    Ajax.js
Purpose: functions of the java script
Authors: Millene L B S Cesconetto
         Olha Tymoshchuk
         Omar Rafik
-->
*/

$(document).ready(function(){

$(document).on('click', '#update_btn', function(){
    var id  = $('input[name=list_select]:checked').val()
    console.log(id);
    if(id == undefined){
        $("#div1").html(`<div class="alert alert-danger" role="alert">
        Select a register!!
      </div>`);
    } else {
        $("#div1").html("");
    }
    $.ajax({
      url: 'Ajax.php',
      type: 'POST',
      data: {
        'update': 1,
        'id': id,
      },
      success: function(response){
        console.log(response);   
        var points = "";
        if(response.points != undefined){
        for(var i=0;i < response.points.length; i++){
          points += `<tr>`;  
          if(response.points[i].startpoint != null){
            points += ` <td>${response.points[i].startpoint}</td>`
          } else {
            points += ` <td contenteditable="false">${response.points[i].endpoint}</td>`
          }
          points += ` <td contenteditable="false">${response.points[i].groundheight}</td>
                         <td contenteditable="false">${response.points[i].antennatype}</td>
                         <td contenteditable="false">${response.points[i].antennatype}</td>
                         <td contenteditable="false">${response.points[i].antennalength}</td></tr>`;
        }
    }

    if(response.points != undefined){
        var midpoint = "";
        for(var i=0;i < response.midpoint.length; i++){
          midpoint += `<tr>`;  
          midpoint += ` <td>${response.midpoint[i].distance}</td>`
          midpoint += ` <td contenteditable="false">${response.midpoint[i].groundheight}</td>
                         <td contenteditable="false">${response.midpoint[i].terraintype}</td>
                         <td contenteditable="false">${response.midpoint[i].obstructype}</td>
                         <td contenteditable="false">${response.midpoint[i].obstructype}</td></tr>`;
        }
    }

        $("#div2").html(`<table class="table">
        <tr>
          <td colspan="5" align="Center" class="bg-light">Pathway</td>
        </tr>
        <tr>
          <th scope="col">Path Name</th>
          <th scope="col">Operating Frequency</th>
          <th scope="col">Description</th>
          <th scope="col">Note</th>
          <th scope="col">File Name</th>
        </tr>
        
        <tr>
          <td>${response.pathway[0].pathname}</td>
          <td id="tablePathway" contenteditable="false">${response.pathway[0].opfrq}</td>
          <td id="tablePathway" contenteditable="false">${response.pathway[0].description}</td>
          <td id="tablePathway" contenteditable="false">${response.pathway[0].note}</td>
          <td id="tablePathway" contenteditable="false">${response.pathway[0].pathfile}</td>
          
        </tr></table>
        </br>
        <button type="button" class="btn btn-success" id="updatePathway_btn">Allow edit</button>
        <button type="button" class="btn btn-success" id="savePathway_btn">Save changes</button>
        </br>
       
        <table class="table" id="table">
        <td colspan="5" align="Center" class="bg-light">Points</td>
        <tr>
        <th scope="col">Point</th>
        <th scope="col">Ground Height</th>
        <th scope="col">Antenna Height</th>
        <th scope="col">antennatype</th>
        <th scope="col">antennalength</th>
      </tr>

        ${points}</table>
        </br>
        <button type="button" class="btn btn-success" id="updatePoints_btn">Allow edit</button>
        <button type="button" class="btn btn-success" id="savePoints_btn">Save changes</button>
        </br>

        <table class="table" id="table">
        <td colspan="5" align="Center" class="bg-light">MidPoints</td>
        <tr>
        <th scope="col">distance</th>
        <th scope="col">Ground Height</th>
        <th scope="col">terraintype</th>
        <th scope="col">obstrucheight</th>
        <th scope="col">obstructype</th>
      </tr>
        ${midpoint}
      </table>
      </br>
        <button type="button" class="btn btn-success" id="updateMidpoints_btn">Allow edit</button>
        <button type="button" class="btn btn-success" id="saveMidpoints_btn">Save changes</button>
        </br>` );
      }
    });
  });//end of update table
  $(document).on('click', '#updatePathway_btn', function(){
    var value = $('#tablePathway').attr('contenteditable');
      if (value == "false") {
        $('#tablePathway').attr('contenteditable',"true");
      }
  });

});
