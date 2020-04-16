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

$(document).on('click', '#calc_btn', function(){
  var DISTANCE = [];
  var AGOHaddCH = [];
  var FRZaddAGOH = [];
  
  var dataPointsGND = [];
  var dataPointsFRZ = [];

  //var for graph
  var path1 = 0;
  var path2 = 0;

 

    var id  = $('input[name=list_select]:checked').val();
    console.log(id);

    if(id == undefined){
        $("#div1").html(`<div class="alert alert-danger" role="alert">
        Select a register!!
      </div>`);
    } 
    else {
        $("#div1").html("");
        var curv  = $(`#earthCurvature_${id}`).val();
        console.log(curv);
    }
    $.ajax({
      url: 'Ajax.php',
      type: 'POST',
      data: {
        'select': 1,
        'id': id,
        'curv': curv
      },
      success: function(response){
        console.log(response);   
        var points = "";
        if(response.points != undefined){
          
        for(var i=0; i < response.points.length; i++){
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
                      </tr>`;
                      
                      if(response.points[i].startpoint != null){
                        path1 = parseInt(response.points[i].groundheight) + parseInt(response.points[i].antennaheight);
                      }
                      else{
                        path2 = parseInt(response.points[i].groundheight) + parseInt(response.points[i].antennaheight);
                      }    
            }             
        }
        
       
        console.log("Ground height start " + path1); 
        console.log("antenna height start " + path2);
       
        
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
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].CurvatureHeight}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].ApparentGround}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].FirstFreznel}</td>
                              <td id="tdMidpoint" contenteditable="false">${response.midpoint[i].Total}</td>
                           </tr>`;
                           DISTANCE.push(response.midpoint[i].distance);
            }
        }
        //Build the graph ----------------------------------------------------------------------------------------------------------------- 
       
        for(var i = 0; i < response.midpoint.length; i++){
          var element = parseInt(response.midpoint[i].ApparentGround) + parseInt(response.midpoint[i].FirstFreznel);
          FRZaddAGOH.push(element);
        }

        for(var i = 0; i < response.midpoint.length; i++){
          var element = parseInt(response.midpoint[i].ApparentGround) + parseInt(response.midpoint[i].CurvatureHeight);
          AGOHaddCH.push(element);
        }

        console.log("Gnd+obs " + AGOHaddCH);
        console.log("FRZ+AGOH " + FRZaddAGOH);

        for (var i = 0; i < DISTANCE.length; i++) {
          dataPointsGND.push({
            x: DISTANCE[i],
            y: AGOHaddCH[i]
          });
        }

        for(var i = 0; i < DISTANCE.length; i++){
          dataPointsFRZ.push({
            x: DISTANCE[i],
            y: FRZaddAGOH[i]
          });
        }

        var chart = new CanvasJS.Chart("chartContainer", {
          title: {
            text: "Path Attenuation = " + response.pathway.PA
          },
          axisX: {
            valueFormatString: ""
          },
          axisY2: {
            title: "",
          },
          toolTip: {
            shared: true
          },
          legend: {
            cursor: "pointer",
            verticalAlign: "top",
            horizontalAlign: "center",
            dockInsidePlotArea: true,
            itemclick: toogleDataSeries
          },
          data: [{
            type:"line",
            axisYType: "secondary",
            name: "Path",
            showInLegend: true,
            markerSize: 0,
            yValueFormatString: "$#,###k",
            dataPoints: [		
              { x: 0, y: path1 },
              { x: 1.5000, y: path2 }
            ]
          },
          {
            type: "line",
            axisYType: "secondary",
            name: "Gnd+Obs",
            showInLegend: true,
            markerSize: 0,
            yValueFormatString: "$#,###k",
            dataPoints: dataPointsGND
          },
          {
            type: "line",
            axisYType: "secondary",
            name: "1st Freznel",
            showInLegend: true,
            markerSize: 0,
            yValueFormatString: "$#,###k",
            dataPoints: dataPointsFRZ
          }]
        });
        chart.render();
        
        function toogleDataSeries(e){
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
          } else{
            e.dataSeries.visible = true;
          }
          chart.render();
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
              <td colspan="11" align="Center" class="bg-light">MidPoints</td>
              <tr>
                <th scope="col" hidden>ID</th>
                <th scope="col">distance</th>
                <th scope="col">Ground Height</th>
                <th scope="col">terraintype</th>
                <th scope="col">obstrucheight</th>
                <th scope="col">obstructype</th>
                <th scope="col" hidden>idmidPoint</th>
                <th scope="col">Curvature Height</th>
                <th scope="col">Apparent Ground and Obstruction Height</th>
                <th scope="col">1st Freznel Zone</th>
                <th scope="col">Total Clearance Height</th>
                <th scope="col"></th>
              </tr>
              ${midpoint}
            </table>
            </div>
          </div>` 
          );
        }
    });
  
  });//end of update table

  
});


