$(document).ready(function(){
    // Display data
    $(document).on('click', '#display_btn', function(){
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
            'display': 1,
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
                points += ` <td>${response.points[i].endpoint}</td>`
              }
              points += ` <td>${response.points[i].groundheight}</td>
                             <td>${response.points[i].antennatype}</td>
                             <td>${response.points[i].antennatype}</td>
                             <td>${response.points[i].antennalength}</td></tr>`;
            }
        }

        if(response.points != undefined){
            var midpoint = "";
            for(var i=0;i < response.midpoint.length; i++){
              midpoint += `<tr>`;  
              midpoint += ` <td>${response.midpoint[i].distance}</td>`
              midpoint += ` <td>${response.midpoint[i].groundheight}</td>
                             <td>${response.midpoint[i].terraintype}</td>
                             <td>${response.midpoint[i].obstructype}</td>
                             <td>${response.midpoint[i].obstructype}</td></tr>`;
            }
        }

            $("#div1").html(`<table class="table">
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
              <td>${response.pathway[0].opfrq}</td>
              <td>${response.pathway[0].description}</td>
              <td>${response.pathway[0].note}</td>
              <td>${response.pathway[0].pathfile}</td>
            </tr>


            <td colspan="5" align="Center" class="bg-light">Points</td>
            <tr>
            <th scope="col">Point</th>
            <th scope="col">Ground Height</th>
            <th scope="col">Antenna Height</th>
            <th scope="col">antennatype</th>
            <th scope="col">antennalength</th>
          </tr>

            ${points}
            <td colspan="5" align="Center" class="bg-light">MidPoints</td>
            <tr>
            <th scope="col">distance</th>
            <th scope="col">Ground Height</th>
            <th scope="col">terraintype</th>
            <th scope="col">obstrucheight</th>
            <th scope="col">obstructype</th>
          </tr>
            ${midpoint}
          </table>` );
          }
        });
      });

    //Reset data
    $(document).on('click', '#reset_btn', function(){
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
              'resetID': 1,
              'id': id,
            },
            success: function(response){
             console.log(response);  
             location.reload(); 
            }
        });
    });
    
});