$(document).ready(function() {

  $(".begin").change(function() {
    displayTable();
    setDaysModals();

  });
  $(".finish").change(function() {
    displayTable();
    setDaysModals();

  });


  setDaysModals();

});
// date is expected to be a date object (e.g., new Date())
const dateToInput = date =>
  `${date.getFullYear()
  }-${('0' + (date.getMonth() + 1)).slice(-2)
  }-${('0' + date.getDate()).slice(-2)
  }`;

// str is expected in yyyy-mm-dd format (e.g., "2017-03-14")
const inputToDate = str => new Date(str.split('-'));

function setDaysModals(){
  $(".completeDay").click(function(){
    var date = inputToDate($(this).find("[name=date]").val());



    // -----------------------------------------------------------------------------
    // Modals Management
    // -----------------------------------------------------------------------------

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    // var btn = document.getElementsByClassName("day");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    // btn.onclick = function() {
        modal.style.display = "block";
    // }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    document.getElementById("modalDate").valueAsDate = date;
    month = date.getMonth();
    day = date.getDate();
    year = date.getFullYear();
    var textDate = '<p style="text-align:center">'+day+' - '+monthNames[month]+' - '+year+'</p>';
    document.getElementById("textDate").innerHTML = textDate;


  });
}
const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];
function displayTable(){


  displayCalendar();

}
function displayCalendar(){

  var b = document.getElementById("begin").value.split(/\D/);
  var begin = new Date(b[0], --b[1], b[2]);
  var b = document.getElementById("finish").value.split(/\D/);
  var finish = new Date(b[0], --b[1], b[2]);

  var innerHTML="";
  innerHTML += "<table class='calendar'>";

  var month = begin.getMonth();
  innerHTML += "<td><table class='month' id='"+ month +"'>";

  if(!isNaN(month)){
    innerHTML += "<tr><td class='monthTd' colspan='31'>"+ monthNames[month] +" " +begin.getFullYear() +"</td></tr><tr>";
  }

  while(begin<=finish){
    // console.log("Month: "+month+" begin.getMonth(): "+ begin.getMonth());
    if(begin.getMonth() == month){
      innerHTML += "<td class='completeDay'><table class='completeDayTable'><tr><td class='day'>" + begin.getDate() + "<input type='date' id='date' name='date' value='"+ dateToInput(begin) +"' hidden='true'></td></tr>" ;
      innerHTML += "<tr><td class='numSpots'}'>"+0+"</td></tr></table></td>" ;
      begin.setDate(begin.getDate() + 1);

    }else{
      innerHTML +="</tr></table></td>";
      month = begin.getMonth();
      innerHTML += "<td><table class='month' id='"+ month +"'>";
      innerHTML += "<tr><td class='monthTd' colspan='31'>"+ monthNames[month] +" " + begin.getFullYear() +"</td></tr><tr>";

    }
  }

  innerHTML += "</table>";
  innerHTML += "<div id=myModal class=modal>"

  +"<div class=modal-content>"
  +  "<span class=close>&times;</span>"
  +  "<table>"
  +   "<tr>"
  +    "<td colspan = 2 >"
  +     "<div id='textDate'></div>"
  +     "<input type=date name=date id=modalDate value='' hidden=true>"
  +    "</td>"
  +  "</tr>"
  +    "<tr>"
  +    "<td>"
  +      "<p>Numero de spots:</p>"
  +    "</td>"
  +    "<td>"
  +      "<input type=number name=numSpots value=''>"
  +    "</td>"
  +  "</tr>"
  +  "<tr>"
  +    "<td>"
  +      "<p>Tipo de Spot:</p>"
  +    "</td>"
  +    "<td>"
  +      "<input type=text name=tipoSpot value=''>"
  +    "</td>"
  +  "</tr>"
  +"</table>"
  +"<input type=button name=AceptarSpot value=Aceptar>"
  +"</div>";


 // set the content of div .
 var rows = document.getElementsByClassName("calendar");
    for(i=0; i<rows.length; i++){
     rows[i].innerHTML=innerHTML
    }
}
//Cambios en la tabla
function estadosChange(value){
  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {estadoID: value.childNodes[0].value.toString()},
   async: true,
   success: function(response) {
    response = JSON.parse(response);

    var t ='';

    for(var i = 0; i<response.length;i++){
     t+="<option value='"+ response[i]['idciudad'] +"'>"
     + response[i]['ciudad'] +"</option>";
    }

    /* Remove all options from the select list */
    var select = $(value.parentNode).find('.ciudad').children().first();
    select.empty().append(t);


   }
  });
}
