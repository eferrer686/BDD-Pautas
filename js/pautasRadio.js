const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];
function displayTable(){
  var html ="<table class=tablePautas>"+
  "<tr class=tablePautasHeaders>"+
    "<td>"+
      "<a>ID</a>"+
    "</td>"+
    "<td>"+
      "<p>Plaza</p>"+
    "</td>"+
    "<td>"+
      "<p>Estacion/TV</p>"+
    "</td>"+
    "<td>"+
      "<p>Frecuencia/Canal</p>"+
    "</td>"+
    "<td>"+
      "<p>Siglas</p>"+
    "</td>"+
    "<td>"+
      "<p>Hora</p>"+
    "</td>"+
    "<td>"+
      "<p>Tarifa</p>"+
    "</td>"+
    "<td class=fechasHeader>"+
      "<p>Fechas</p>"+
    "</td>"+
    "<td>"+
      "<p>Spots</p>"+
    "</td>"+
    "<td>"+
      "<p>Inversion</p>"+
    "</td>"+
    "<td>"+
      "<p>Rating</p>"+
    "</td>"+
    "<td>"+
      "<p>GRP's</p>"+
    "</td>"+
    "<td>"+
      "<p>Impactos</p>"+
    "</td>"+
    "<td>"+
      "<p>Inversion</p>"+
    "</td>"+
    "<td>"+
      "<p>Comision</p>"+
    "</td>"+
  "</tr>";
  html += "<tr class='pautaIndividual'>"+
    "<td>"+
      "<p>ID</select>"+
    "</td>"+
    "<td>"+
      "<select id='plazaSelect'>Plaza</select>"+
    "</td>"+
    "<td>"+
      "<select id='estacionSelect'>Estacion/TV</select>"+
    "</td>"+
    "<td>"+
      "<select id='frecuenciaSelect'>Frecuencia/Canal</select>"+
    "</td>"+
    "<td>"+
      "<select id='siglasSelect'>Siglas</select>"+
    "</td>"+
    "<td>"+
      "<select id='horaSelect'>Hora</select>"+
    "</td>"+
    "<td>"+
      "<select id='tarifaSelect'>Tarifa</select>"+
    "</td>"+
    "<td class=innerTD>"+
      "<div  id=calendar class=calendar></div>"+
    "</td>"+
    "<td>"+
      "<p>Spots</p>"+
    "</td>"+
    "<td>"+
      "<p>Inversion</p>"+
    "</td>"+
    "<td>"+
      "<p>Rating</p>"+
    "</td>"+
    "<td>"+
      "<p>GRP's</p>"+
    "</td>"+
    "<td>"+
      "<p>Impactos</p>"+
    "</td>"+
    "<td>"+
      "<p>Inversion</p>"+
    "</td>"+
    "<td>"+
      "<p>Comision</p>"+
    "</td>"+
  "</tr>";




  document.getElementById("pautas").innerHTML = html;
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
    innerHTML += "<tr><td colspan='31'>"+ monthNames[month] +" " +begin.getFullYear() +"</td></tr><tr>";
  }

  while(begin<=finish){
    // console.log("Month: "+month+" begin.getMonth(): "+ begin.getMonth());
    if(begin.getMonth() == month){
      innerHTML += "<td class='day'>" + begin.getDate() + "</td><input type='text' name='date' value="+ begin.toString() +" hidden='true'>" ;
      begin.setDate(begin.getDate() + 1);
    }else{
      innerHTML +="</tr></table></td>";
      month = begin.getMonth();
      innerHTML += "<td><table class='month' id='"+ month +"'>";
      innerHTML += "<tr><td colspan='31'>"+ monthNames[month] +" " + begin.getFullYear() +"</td></tr><tr>";

    }
  }

  innerHTML += "</table>";


 // set the content of div .
 var rows = document.getElementsByClassName("calendar");
    for(i=0; i<rows.length; i++){
     rows[i].innerHTML=innerHTML
    }
}
