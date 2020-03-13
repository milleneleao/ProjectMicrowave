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
    } 
    else {
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
          points += `<tr id="${response.points[i].idpoints}">
                    <td id="tdPoint" hidden value=${response.points[i].idpoints}>${response.points[i].idpoints}</td> `;

          if(response.points[i].startpoint != null){
            points += ` <td id="tdPoint" hidden value="start">start</td>
                        <td id="tdPoint" value=${response.points[i].startpoint}>${response.points[i].startpoint}</td>`
          } else {
            points += ` <td id="tdPoint"  hidden value="end">end</td>
                        <td id="tdPoint" contenteditable="false" value=${response.points[i].endpoint}>${response.points[i].endpoint}</td>`
          }
          points += ` <td id="tdPoint" contenteditable="false" value=${response.points[i].groundheight}>${response.points[i].groundheight}</td>
                      <td id="tdPoint" contenteditable="false" value=${response.points[i].antennaheight}>${response.points[i].antennaheight}</td>
                      <td id="tdPoint" contenteditable="false" value=${response.points[i].antennatype}>${response.points[i].antennatype}</td>
                      <td id="tdMidpoint" contenteditable="false" value=${response.points[i].antennalength}>${response.points[i].antennalength}</td>
                      <td id="tdMidpoint"> <button type="button" class="btn btn-primary" id="btn_tdPoints_edit" value="${response.points[i].idpoints}">edit</button></td>
                      </tr>`;
          }
        }

        if(response.midpoint != undefined){
            var midpoint = "";
            for(var i=0;i < response.midpoint.length; i++){
              midpoint += `<tr id="${response.midpoint[i].idmidPoint}">
                              <td id="tdMidpoint" hidden>${response.midpoint[i].idmidPoint}</td>
                              <td id="tdMidpoint">${response.midpoint[i].distance}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].groundheight}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].terraintype}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].obstrucheight}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].obstructype}</td>
                              <td id="tdMidpoint" hidden>${response.midpoint[i].idpathway}</td>
                              <td id="tdMidpoint"> <button type="button" class="btn btn-primary" id="btn_tdMidPoints_edit"  value=${response.midpoint[i].idmidPoint}>edit</button></td>
                           </tr>`;
            }
        }

        $("#div2").html(`
        <div class="col-lg-12 pt-5" style="text-align: center;">
            <h3> <a href="../part2/editDisplay.php">Return to File List</a></h3>
        </div>
        <div class="row  pt-5">
          <div class="col-12 text-center">
            <table class="table" id="tablePathwayRoot">
               <tr>
                 <td colspan="6" align="Center" class="bg-light">Pathway</td>
               </tr>
               <tr>
                 <th scope="col" hidden>ID</th>
                 <th scope="col">Path Name</th>
                 <th scope="col">Operating Frequency</th>
                 <th scope="col">Description</th>
                 <th scope="col">Note</th>
                 <th scope="col">File Name</th>
                 <th scope="col"></th>
               </tr>
  
               <tr id="${response.pathway[0].idpathway}">
                 <td id="tdPathway" hidden>${response.pathway[0].idpathway}</td>
                 <td id="tdPathway">${response.pathway[0].pathname}</td>
                 <td id="tdPathway" contenteditable="false">${response.pathway[0].opfrq}</td>
                 <td id="tdPathway" contenteditable="false">${response.pathway[0].description}</td>
                 <td id="tdPathway" contenteditable="false">${response.pathway[0].note}</td>
                 <td id="tdPathway">${response.pathway[0].pathfile}</td>
                 <td><button type="button" class="btn btn-primary" id="btn_tdPathway_edit" value="${response.pathway[0].idpathway}">edit</button></td>
               </tr>
            </table>
          </div>
        </div>  

        <div class="row  pt-5">
          <div class="col-12 text-center">
            <table class="table" id="tablePoits">
              <td colspan="6" align="Center" class="bg-light">Points</td>
              <tr>
               <th scope="col" hidden>ID</th>
               <th scope="col" hidden>Start</th>
               <th scope="col">Distance</th>
               <th scope="col">Ground Height</th>
               <th scope="col">Antenna Height</th>
               <th scope="col">antennatype</th>
               <th scope="col">antennalength</th>
               <th scope="col"></th>
              </tr>
             ${points}
            </table>
          </div>
        </div> 


        <div class="row  pt-5">
          <div class="col-12 text-center">
            <table class="table" id="tableMidPoints">
              <td colspan="6" align="Center" class="bg-light">MidPoints</td>
              <tr>
                <th scope="col" hidden>ID</th>
                <th scope="col">distance</th>
                <th scope="col">Ground Height</th>
                <th scope="col">terraintype</th>
                <th scope="col">obstrucheight</th>
                <th scope="col">obstructype</th>
                <th scope="col" hidden>idmidPoint</th>
                <th scope="col"></th>
              </tr>
              ${midpoint}
            </table>
            </div>
          </div>` );
      }
    });
  });//end of update table
  
  //PATHWAY FUNCTIONS ---------------------------------------------------------------------------------------------------------------------
  $(document).on('click', '#btn_tdPathway_edit', function(){
    var id = $(this).attr("value");
    
    var array = [];
    var currentrow = $("#"+id);
    var idpathway = currentrow.find("td:eq(0)").text();
    var pathwayName = currentrow.find("td:eq(1)").text();
    var opfrq = currentrow.find("td:eq(2)").text();
    var description = currentrow.find("td:eq(3)").text();
    var note = currentrow.find("td:eq(4)").text();
    var file = currentrow.find("td:eq(5)").text();
    array.push(idpathway,pathwayName,opfrq,description,note);
    console.log(array);
    $("#div2").hide();
    $("#div3").html(` <form method="POST" id="updateForm">

    <input type="text"  class="d-none" id="idpathway" value="${idpathway}">

    <div class="form-group row">
      <label for="PathName" class="col-sm-2 col-form-label">Path Name</label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control" id="PathName" value="${pathwayName}">
      </div>
    </div>

        
    <div class="form-group row">
      <label for="opfrq" class="col-sm-2 col-form-label">Operating Frequency</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="opfrq" value="${opfrq}">
      </div>
    </div>


            
    <div class="form-group row">
      <label for="opfrq" class="col-sm-2 col-form-label">Description</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="description" value="${description}">
      </div>
    </div>


    <div class="form-group row">
      <label for="opfrq" class="col-sm-2 col-form-label">Note</label>
      <div class="col-sm-10">
        <input type="text"  class="form-control" id="note" value="${note}">
      </div>
    </div>


    <div class="form-group row">
    <label for="opfrq" class="col-sm-2 col-form-label">File Name</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control" id="file" value="${file}">
    </div>
  </div>
  <button type="button" class="btn btn-success" id="savePathway_btn">Save changes</button>
  <button type="button" class="btn btn-danger"  id="cancelPathway_btn">Cancel</button>
  </form>`);
   });

  $(document).on('click','#savePathway_btn', function(){
    var array = [];
    var idpathway = $("#idpathway").val();
    var pathwayName =$("#PathName").val();
    var opfrq = $("#opfrq").val();
    var description = $("#description").val();
    var note = $("#note").val();
    array.push(idpathway,pathwayName,opfrq,description,note);

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
          $("#div2").show();
          var currentrow = $("#"+idpathway);
          currentrow.find("td:eq(2)").text(opfrq);
          currentrow.find("td:eq(3)").text(description);
          currentrow.find("td:eq(4)").text(note);
          $("#div3").html("");
          $("#div2").show();
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
    $("#div3").html("");
    $("#div2").show();
  });

  //POINTS FUNCTIONS--------------------------------------------------------------------------------------------------------------------
  //EDIT BUTTON
  $(document).on('click', '#btn_tdPoints_edit', function(){
    var id = $(this).attr("value");
    console.log(id);
    var rowArray = [];
    var currentrow = $("#"+id);
    console.log(currentrow);
    var idpoints      = currentrow.find("td:eq(0)").text();
    var spoint        = currentrow.find("td:eq(1)").text();
    var distance      = currentrow.find("td:eq(2)").text();
    var groundheight  = currentrow.find("td:eq(3)").text();
    var antennaheight = currentrow.find("td:eq(4)").text();
    var antennatype   = currentrow.find("td:eq(5)").text();
    var antennalength = currentrow.find("td:eq(6)").text();
    var rowArray = [];
    rowArray.push(idpoints,spoint,distance,groundheight,antennaheight,antennatype,antennalength);
    console.log(rowArray);

    $("#div2").hide();
    $("#div3").html(` <form method="POST" id="updateForm">

    <input type="text"  class="d-none" id="idpoints" value="${idpoints}">
    <input type="text"  class="d-none" id="spoint" value="${spoint}">

    <div class="form-group row">
      <label for="distance" class="col-sm-2 col-form-label">Distance</label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control" id="distance" value="${distance}">
      </div>
    </div>

        
    <div class="form-group row">
      <label for="groundheight" class="col-sm-2 col-form-label">Ground Height</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="groundheight" value="${groundheight}">
      </div>
    </div>


            
    <div class="form-group row">
      <label for="antennaheight" class="col-sm-2 col-form-label">Antenna Heigh</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="antennaheight" value="${antennaheight}">
      </div>
    </div>


    <div class="form-group row">
      <label for="antennatype" class="col-sm-2 col-form-label">Antenna Type</label>
      <div class="col-sm-10">
        <input type="text"  class="form-control" id="antennatype" value="${antennatype}">
      </div>
    </div>


    <div class="form-group row">
    <label for="opfrq" class="col-sm-2 col-form-label">Antenna Length</label>
    <div class="col-sm-10">
      <input type="text"  class="form-control" id="antennalength" value="${antennalength}">
    </div>
  </div>

  <button type="button" class="btn btn-success" id="savePoint_btn">Save changes</button>
  <button type="button" class="btn btn-danger"  id="cancelPoint_btn">Cancel</button>
  </form>`);
   });

  //save points
  $(document).on('click','#savePoint_btn', function(){
    var array = [];
    var idpoints = $("#idpoints").val();
    var spoint =$("#spoint").val();
    var distance = $("#distance").val();
    var groundheight = $("#groundheight").val();
    var antennaheight = $("#antennaheight").val();
    var antennatype = $("#antennatype").val();
    var antennalength = $("#antennalength").val();
    array.push(idpoints,spoint,distance,groundheight,antennaheight,antennatype,antennalength);
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
          $("#div2").show();
          var currentrow = $("#"+idpoints);
          currentrow.find("td:eq(2)").text(distance);
          currentrow.find("td:eq(3)").text(groundheight);
          currentrow.find("td:eq(4)").text(antennaheight);
          currentrow.find("td:eq(5)").text(antennatype);
          currentrow.find("td:eq(6)").text(antennalength);
          $("#div3").html("");
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
  $(document).on('click','#cancelPoint_btn', function(){
    alert("All  changes won't be saved!!");         
    $("#div3").html("");
    $("#div2").show();
  });

  // MIDPOINTS FUNCTIONS-----------------------------------------------------------------------------------------------------------------
  $(document).on('click', '#btn_tdMidPoints_edit', function(){
    var id = $(this).attr("value");
    console.log(id);
    var rowArray = [];
    var currentrow = $("#"+id);
    console.log(currentrow);
    var idmidPoint   = currentrow.find("td:eq(0)").text();
    var distance     = currentrow.find("td:eq(1)").text();
    var groundheight = currentrow.find("td:eq(2)").text();
    var terraintype  = currentrow.find("td:eq(3)").text();
    var obstrucheight  = currentrow.find("td:eq(4)").text();
    var obstructype  = currentrow.find("td:eq(5)").text();
    var idpathway    = currentrow.find("td:eq(6)").text();
    var rowArray = [];
    rowArray.push(idmidPoint,distance,groundheight,terraintype,obstrucheight,obstructype,idpathway);
    console.log(rowArray);
    
    $("#div2").hide();
    $("#div3").html(` <form method="POST" id="updateForm">

    <input type="text"  class="d-none" id="idmidPoint" value="${idmidPoint}">
    <input type="text"  class="d-none" id="idpathway" value="${idpathway}">
       
    <div class="form-group row">
      <label for="distance" class="col-sm-2 col-form-label">Distance</label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control" id="distance" value="${distance}">
      </div>
    </div>


            
    <div class="form-group row">
      <label for="groundheight" class="col-sm-2 col-form-label">Ground Height</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="groundheight" value="${groundheight}">
      </div>
    </div>


    <div class="form-group row">
      <label for="terraintype" class="col-sm-2 col-form-label">Terrain Type</label>
      <div class="col-sm-10">
        <input type="text"  class="form-control" id="terraintype" value="${terraintype}">
      </div>
    </div>


    <div class="form-group row">
      <label for="obstrucheight" class="col-sm-2 col-form-label">File Obstruc Height</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="obstrucheight" value="${obstrucheight}">
      </div>
    </div>

    <div class="form-group row">
      <label for="obstructype" class="col-sm-2 col-form-label">Obstruc Type</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="obstructype" value="${obstructype}">
      </div>
    </div>

    
    <button type="button" class="btn btn-success" id="saveMidpoints_btn">Save changes</button>
    <button type="button" class="btn btn-danger"  id="cancelMidpoint_btn">Cancel</button>
  </form>`);
  });
  


  $(document).on('click','#saveMidpoints_btn', function(){
    var array = [];
    var idmidPoint    = $("#idmidPoint").val();
    var distance      =$("#distance").val();
    var groundheight  = $("#groundheight").val();
    var terraintype   = $("#terraintype").val();
    var obstrucheight = $("#obstrucheight").val();
    var obstructype   = $("#obstructype").val();
    var idpathway     = $("#idpathway").val();
    array.push(idmidPoint,distance,groundheight,terraintype,obstrucheight,obstructype,idpathway);
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
          $("#div2").show();
          var currentrow = $("#"+idmidPoint);
          currentrow.find("td:eq(1)").text(distance);
          currentrow.find("td:eq(2)").text(groundheight);
          currentrow.find("td:eq(3)").text(terraintype);
          currentrow.find("td:eq(4)").text(obstrucheight);
          currentrow.find("td:eq(5)").text(obstructype);
          $("#div3").html(""); 
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
    $("#div3").html("");
    $("#div2").show();
  });

});
