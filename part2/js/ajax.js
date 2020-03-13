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
        'select': 1,
        'id': id,
      },
      success: function(response){
        console.log(response);   
        var points = "";
        if(response.points != undefined){
        for(var i=0;i < response.points.length; i++){
          points += `<tr id="trPoint">`;  
          points += ` <td id="tdPoint" hidden>${response.points[i].idpoints}</td>`
          if(response.points[i].startpoint != null){
            points += ` <td id="tdPoint" hidden>start</td>`
            points += ` <td id="tdPoint">${response.points[i].startpoint}</td>`
          } else {
            points += ` <td id="tdPoint" hidden>end</td>`
            points += ` <td id="tdPoint" contenteditable="false">${response.points[i].endpoint}</td>`
          }
          points += ` <td id="tdPoint" contenteditable="false">${response.points[i].groundheight}</td>
                         <td id="tdPoint" contenteditable="false">${response.points[i].antennaheight}</td>
                         <td id="tdPoint" contenteditable="false">${response.points[i].antennatype}</td>
                         <td id="tdPoint" contenteditable="false">${response.points[i].antennalength}</td></tr>`;
          }
        }

        if(response.midpoint != undefined){
            var midpoint = "";
            for(var i=0;i < response.midpoint.length; i++){
              midpoint += `<tr id="trMidpoint">
                              <td id="tdMidpoint" hidden>${response.midpoint[i].idmidPoint}</td>
                              <td id="tdMidpoint">${response.midpoint[i].distance}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].groundheight}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].terraintype}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].obstrucheight}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].obstructype}</td>
                              <td id="tdMidpoint" hidden>${response.midpoint[i].idpathway}</td>
                           </tr>`;
            }
        }

        $("#div2").html(`
        <div class="row  pt-5">
          <div class="col-12 text-center">
            <table class="table" id="tablePathwayRoot">
               <tr>
                 <td colspan="5" align="Center" class="bg-light">Pathway</td>
               </tr>
               <tr>
                 <th scope="col" hidden>ID</th>
                 <th scope="col">Path Name</th>
                 <th scope="col">Operating Frequency</th>
                 <th scope="col">Description</th>
                 <th scope="col">Note</th>
                 <th scope="col">File Name</th>
                 <th scope="col">ddd Name</th>
               </tr>
  
               <tr id="trPathway">
                 <td id="tdPathway" hidden>${response.pathway[0].idpathway}</td>
                 <td id="tdPathway">${response.pathway[0].pathname}</td>
                 <td id="tdPathway" contenteditable="false">${response.pathway[0].opfrq}</td>
                 <td id="tdPathway" contenteditable="false">${response.pathway[0].description}</td>
                 <td id="tdPathway" contenteditable="false">${response.pathway[0].note}</td>
                 <td>${response.pathway[0].pathfile}</td>
                 <td> </td>
               </tr>
            </table>
            </br>
            <button type="button" class="btn btn-primary" id="updatePathway_btn">Allow edit</button>
            <button type="button" class="btn btn-success" id="savePathway_btn">Save changes</button>
            <button type="button" class="btn btn-danger"  id="cancelPathway_btn">Cancel</button>
            </br></br>
          </div>
        </div>  

        <div class="row  pt-5">
          <div class="col-12 text-center">
            <table class="table" id="tablePoits">
              <td colspan="5" align="Center" class="bg-light">Points</td>
              <tr>
               <th scope="col" hidden>ID</th>
               <th scope="col" hidden>Start</th>
               <th scope="col">Point</th>
               <th scope="col">Ground Height</th>
               <th scope="col">Antenna Height</th>
               <th scope="col">antennatype</th>
               <th scope="col">antennalength</th>
              </tr>
             ${points}
            </table>
            </br>
            <button type="button" class="btn btn-primary" id="updatePoints_btn">Allow edit</button>
            <button type="button" class="btn btn-success" id="savePoints_btn">Save changes</button>
            <button type="button" class="btn btn-danger"  id="cancelPoints_btn">Cancel</button>
            </br></br>
          </div>
        </div> 


        <div class="row  pt-5">
          <div class="col-12 text-center">
            <table class="table" id="tableMidPoints">
              <td colspan="5" align="Center" class="bg-light">MidPoints</td>
              <tr>
                <th scope="col" hidden>ID</th>
                <th scope="col">distance</th>
                <th scope="col">Ground Height</th>
                <th scope="col">terraintype</th>
                <th scope="col">obstrucheight</th>
                <th scope="col">obstructype</th>
                <th scope="col" hidden>idmidPoint</th>
                
              </tr>
              ${midpoint}
            </table>
            </br>
            <button type="button" class="btn btn-primary" id="updateMidpoints_btn">Allow edit</button>
            <button type="button" class="btn btn-success" id="saveMidpoints_btn">Save changes</button>
            <button type="button" class="btn btn-danger"  id="cancelMidpoint_btn">Cancel</button>
            </br></br>
            </div>
          </div>` );
      }
    });
  });//end of update table
  
  //PATHWAY FUNCTIONS ---------------------------------------------------------------------------------------------------------------------
  $(document).on('click', '#updatePathway_btn', function(){
    $("[id]").each(function(){
      if("tdPathway"==  $(this).attr("id")){
        var value = $(this).attr("contenteditable");
        if (value == "false") {
          $(this).attr('contenteditable',"true");
        }
      }
     });
  });

  $(document).on('click','#savePathway_btn', function(){
    var array = [];
    $('#tablePathwayRoot tr').each(function() {
      console.log(this.id);
      if(this.id == 'trPathway'){
        var currentrow = $(this);
        var idpathway = currentrow.find("td:eq(0)").text();
        var pathwayName = currentrow.find("td:eq(1)").text();
        var opfrq = currentrow.find("td:eq(2)").text();
        var description = currentrow.find("td:eq(3)").text();
        var note = currentrow.find("td:eq(4)").text();
        array.push(idpathway,pathwayName,opfrq,description,note);
        console.log(array);
      }
    });

    $.ajax({
      url: 'Ajax.php',
      type: 'POST',
      data: {
        'update': 1,
        'data': array,
      },
      success: function(response){
        console.log(response);   
        if (response.status == 'Ok'){
          alert(response.error_msg);
          location.reload(); 
        }else {
          var msg = "";
          for(var i=0;i<response.error_msg.length;i++){
            msg += `${response.error_msg[i]} \n`
          }
          alert(msg);
        }
       }
    });
  });

  $(document).on('click','#cancelPathway_btn', function(){
    alert("All  changes won't be saved!!");         
    location.reload();
  });

  //POINTS FUNCTIONS--------------------------------------------------------------------------------------------------------------------
  //EDIT BUTTON
  $(document).on('click', '#updatePoints_btn', function(){

    $("[id]").each(function(){
      if("tdPoint"==  $(this).attr("id")){
        var value = $(this).attr("contenteditable");
        if (value == "false") {
          $(this).attr('contenteditable',"true");
        }
      }
     });
  });

  //save points
  $(document).on('click','#savePoints_btn', function(){
    var array = [];
    $('#tablePoits tr').each(function() {
      if(this.id == 'trPoint'){
        var currentrow  = $(this);
        var idpoints   = currentrow.find("td:eq(0)").text();
        var spoint     = currentrow.find("td:eq(1)").text();
        var point = currentrow.find("td:eq(2)").text();
        var groundheight  = currentrow.find("td:eq(3)").text();
        var antennaheight  = currentrow.find("td:eq(4)").text();
        var antennatype  = currentrow.find("td:eq(5)").text();
        var antennalength    = currentrow.find("td:eq(6)").text();
        var rowArray = [];
        rowArray.push(idpoints,spoint,point,groundheight,antennaheight,antennatype,antennalength);
        array.push(rowArray);
      }
    });
    console.log(array);
    $.ajax({
      url: 'Ajax.php',
      type: 'POST',
      data: {
        'update': 2,
        'data': array,
      },
      success: function(response){
        console.log(response);   
        if (response.status == 'Ok'){
          alert(response.error_msg);
          location.reload(); 
        }else {
          var msg = "";
          for(var i=0;i<response.error_msg.length;i++){
            msg += `${response.error_msg[i]} \n`
          }
          alert(msg);
        }
       }
    });
  });
  //cancel button
  $(document).on('click','#cancelPoints_btn', function(){
    alert("All  changes won't be saved!!");         
    location.reload();
  });

  // MIDPOINTS FUNCTIONS-----------------------------------------------------------------------------------------------------------------
  $(document).on('click', '#updateMidpoints_btn', function(){

    $("[id]").each(function(){
      if("tdMidpoint"==  $(this).attr("id")){
        var value = $(this).attr("contenteditable");
        if (value == "false") {
          $(this).attr('contenteditable',"true");
        }
      }
     });
  });


  $(document).on('click','#saveMidpoints_btn', function(){
    var array = [];
    $('#tableMidPoints tr').each(function() {
      if(this.id == 'trMidpoint'){
        var currentrow  = $(this);
        var idmidPoint   = currentrow.find("td:eq(0)").text();
        var distance     = currentrow.find("td:eq(1)").text();
        var groundheight = currentrow.find("td:eq(2)").text();
        var terraintype  = currentrow.find("td:eq(3)").text();
        var obstrucheight  = currentrow.find("td:eq(4)").text();
        var obstructype  = currentrow.find("td:eq(5)").text();
        var idpathway    = currentrow.find("td:eq(6)").text();
        var rowArray = [];
        rowArray.push(idmidPoint,distance,groundheight,terraintype,obstrucheight,obstructype,idpathway);
        array.push(rowArray);
      }
    });
    console.log(array);
    $.ajax({
      url: 'Ajax.php',
      type: 'POST',
      data: {
        'update': 3,
        'data': array,
      },
      success: function(response){
        console.log(response);   
        if (response.status == 'Ok'){
          alert(response.error_msg);
          location.reload(); 
        }else {
          var msg = "";
          for(var i=0;i<response.error_msg.length;i++){
            msg += `${response.error_msg[i]} \n`
          }
          alert(msg);
        }
       }
    });
  });


  $(document).on('click','#cancelMidpoint_btn', function(){
    alert("All  changes won't be saved!!");         
    location.reload();
  });

});
