$(document).ready(function() {

  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {dateRange: 1},
   async: true,
   beforeSend: function(){
        showLoading();
    },
   success: function(response) {
     begDate = JSON.parse(response)[1];
     finDate = JSON.parse(response)[0];
     $(".begin").val(begDate);
     $(".finish").val(finDate);
     displayTable();
   }
  });

  $(".begin").change(function() {
    displayTable();
    setDaysModals();

  });
  $(".finish").change(function() {
    displayTable();
    setDaysModals();

  });

  // Si cambia radio estado o ciudad se actualizan tarifas en DB
  var previous;
  var prevEstado;
  var prevCiudad;
  var prevEstacion;

  $(".ciudadSelect").on('focus', function () {
      // Store the current value on focus and on change
      prevCiudad = this.value;
      prevEstacion = this.parentNode.parentNode.childNodes[3].childNodes[0].value;
      prevEstado = this.parentNode.parentNode.childNodes[1].childNodes[0].value;

  }).change(function() {
      // Do something with the previous value after the change
      if(confirm("Estás seguro de cambiar la ciudad? Esto causaria que todos los spots almacenados se actualicen")){
        changeECR(this);
      }else {
        sortSelects(this);
        setSelectValues(this,prevEstado,prevCiudad,prevEstacion);
      }
  });
  $(".estacionSelect").on('focus', function () {
      // Store the current value on focus and on change
      prevEstado = this.parentNode.parentNode.childNodes[1].childNodes[0].value;
      prevCiudad = this.parentNode.parentNode.childNodes[2].childNodes[0].value;
      prevEstacion = this.value;

  }).change(function() {
      // Do something with the previous value after the change
      if(confirm("Estás seguro de cambiar la estación? Esto causaria que todos los spots almacenados se actualicen")){
        changeECR(this);
      }else {
        sortSelects(this);
        setSelectValues(this,prevEstado,prevCiudad,prevEstacion);
      }
  });

  $(".estadoSelect").on('focus', function () {
      // Store the current value on focus and on change
      prevEstado = this.value;
      prevCiudad = this.parentNode.parentNode.childNodes[2].childNodes[0].value ;
      prevEstacion = this.parentNode.parentNode.childNodes[3].childNodes[0].value;


  }).change(function() {
      // Do something with the previous value after the change
      if(confirm("Estás seguro de cambiar el estado? Esto causaria que todos los spots almacenados se actualicen")){
        changeECR(this);
      }else {
        sortSelects(this);
        setSelectValues(this,prevEstado,prevCiudad,prevEstacion);
      }
  });

  //Eliminar renglones

  $(".deleteRenglon").click(function(){
    if(confirm("Estás seguro de eliminar todo este renglon, los cambios NO serán reversibles")){
      deleteRenglon(this);
    }
  });

  setDaysModals();

  $(".aceptarSpot").click(function(){
    var table = document.getElementById("spotsRadioDia");

    var sqlTable=[];

    for (var i = 1, row; row = table.rows[i]; i++) {
      var sqlRow=[];

      var idSpot = row.cells[0].innerHTML.replace('<br>', '');

      var sel = row.cells[1].childNodes[0];
      var hora = sel.value;

      var sel = row.cells[2].childNodes[0];
      var cantidad = sel.value;

      var sel = row.cells[3].childNodes[0];
      var opt = sel.options[sel.selectedIndex];
      var tarifa =  opt.value;

      var idPautaRenglon = this.parentNode.childNodes[7].value;
      var date = this.parentNode.childNodes[5].value;


      sqlRow[0]= idSpot;
      sqlRow[1]= hora;
      sqlRow[2]= cantidad;
      sqlRow[3]= tarifa;
      sqlRow[4]= date;
      sqlRow[5]= idPautaRenglon;


      sqlTable[i-1]=sqlRow;

    }
    // console.log(sqlTable);

    //AJAX request to update, no submit

    $.ajax({
     type: "POST",
     url: '../html/pautasRadio.php',
     data: {tablaModalSpots: JSON.stringify(sqlTable)},
     async: true,
     success: function(response) {
       displayCalendar();
       var modal = document.getElementById('myModal');
       modal.style.display = "none";
     }
    });

  });
  var timer=0;
  var firstPass=true;
  var tDate = new Date();
  $(".ratingPautaRadio").keypress(function(e){
    var keycode = e.which;
    if(keycode == 0){
      return true;
    }
          /* 48-57: 0 -9
             8:backspace */
    if((keycode >= 48 && keycode <= 57) || keycode == 8 || keycode == 46){
      showLoading();
      var ratingElem = this;
      setTimeout(function () {
        changeRating(ratingElem);
      }, 5000);

      return true;
    } else {
      return false;
    }

  });

  getGRPS();
  getImpactos();
  getComision();
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
    var id = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id;

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
    document.getElementById("modalId").value = id;
    month = date.getMonth();
    day = date.getDate();
    year = date.getFullYear();
    var textDate = '<p style="text-align:center">'+day+' - '+monthNames[month]+' - '+year+'</p>';
    document.getElementById("textDate").innerHTML = textDate;

    var id = this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id;

    $.ajax({
     type: "POST",
     url: '../html/pautasRadio.php',
     data: {getSpotsDia: 1,diaSpot: day, mesSpot: month,añoSpot: year, idPautaRenglon: id},
     async: true,
     success: function(response) {
       var modalTable = document.getElementById('modal-table');

       var tableHTML = response;
       modalTable.innerHTML = tableHTML;

     }
    });
  });
}
const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];
function displayTable(){

  displayCalendar();

}
function displayCalendar(){


  // set the content of div .

    var b = document.getElementById("begin").value.split(/\D/);
    var begin = new Date(b[0], --b[1], b[2]);
    var b = document.getElementById("finish").value.split(/\D/);
    var finish = new Date(b[0], --b[1], b[2]);

    showLoading();

    $.when(getNumSpots(begin,finish)).done(function(result) {
      var rows = document.getElementsByClassName("calendar");
        for(i=0; i<rows.length; i++){

            var id = rows[i].parentNode.parentNode.id;

            // console.log(JSON.parse(result));

            var b = document.getElementById("begin").value.split(/\D/);
            var begin = new Date(b[0], --b[1], b[2]);
            var b = document.getElementById("finish").value.split(/\D/);
            var finish = new Date(b[0], --b[1], b[2]);

            var rArray = JSON.parse(result);

            var innerHTML="";

            innerHTML += "<table class='innerCalendar'>";

            var month = begin.getMonth();
            innerHTML += "<td><table class='month' id='"+ month +"'>";

            if(!isNaN(month)){
              innerHTML += "<tr><td class='monthTd' colspan='31'>"+ monthNames[month] +" " +begin.getFullYear() +"</td></tr><tr>";
            }

            var idSpot = 0;
            while(begin<=finish){
              if(begin.getMonth() == month){

                var numSpots = 0;
                idSpot++;

                for (var j = 0; j < rArray.length; j++) {
                  if(rows[i].parentNode.parentNode.id == rArray[j]["idPautaRadio"] &&
                    inputToDate(rArray[j]["fecha"]).getTime() === begin.getTime()){
                    numSpots = rArray[j]["cantidad"];
                  }
                }


                innerHTML += "<td class='completeDay'><table class='completeDayTable'><tr><td class='day'>" + begin.getDate() + "<input type='date' id='date' name='date' value='"+ dateToInput(begin) +"' hidden='true'></td></tr>" ;
                innerHTML += "<tr><td class='numSpots'}'>"+numSpots+"</td></tr></table></td>" ;
                begin.setDate(begin.getDate() + 1);
              }
               else{
                innerHTML +="</tr></table></td>";
                month = begin.getMonth();
                innerHTML += "<td><table class='month' id='"+ month +"'>";
                innerHTML += "<tr><td class='monthTd' colspan='31'>"+ monthNames[month] +" " + begin.getFullYear() +"</td></tr><tr>";
              }
            }

            innerHTML += "</table>";

            rows[i].innerHTML=innerHTML;
            setDaysModals();
            hideLoading();
          }
        });




}
function getSpots(begin,finish,id){
  return ($.when(getNumSpots(begin,finish,id)).done(function(response){
      //Get AJAX operation
      spots = JSON.parse(response);

      // console.log(spots);

      if(spots[0]!=0){
        for (var i = 0; i < spots.length; i++) {
          spots[i]["fecha"] = inputToDate(spots[i]["fecha"]);
        }
      }
      return spots;
    })
  );
}

function getNumSpots(begin,finish,id){
    return $.ajax({
       type: "POST",
       url: '../html/pautasRadio.php',
       async: true,
       data: {
         getSpotsCalendar: 1,
         iDiaSpot: begin.getDate(),
         iMesSpot: begin.getMonth(),
         iAñoSpot: begin.getFullYear(),
         fDiaSpot: finish.getDate(),
         fMesSpot: finish.getMonth(),
         fAñoSpot: finish.getFullYear(),
         idPautaRenglon: id
       }
       // ,
       // success: function(response) {
       //   res = (response);
       //   return numSpots[idSpot] = res;
       // }
    });
}
//Cambios en la tabla
function estadosChange(value){
  var select = '';
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
       + response[i]['ciudad']
       +"</option>";
      }
      /* Remove all options from the select list */
      var select = $(value.parentNode).find('.ciudad').children().first();
      select.empty().append(t);

      var ciudad = select[0];
      ciudadesChange(ciudad);
    }
  });
}
  //Cambios en la tabla ciudades
  function ciudadesChange(value){
    // console.log(value.childNodes[0].value.toString());

    var idPauta = value.parentNode.parentNode.id;

    $.ajax({
     type: "POST",
     url: '../html/pautasRadio.php',
     data: {ciudadID: value.childNodes[0].value.toString()},
     async: true,
     success: function(response) {
      response = JSON.parse(response);

      var htmlEstacion ='';
      var htmlFrecuencia ='';
      var htmlSiglas ='';

      for(var i = 0; i<response.length;i++){
       htmlEstacion+="<option value='"+ response[i]['idRadio'] +"'>"
       + response[i]['estacion']+ " | "
       + response[i]['frecuencia'] + " | "
       + response[i]['siglas']
       +"</option>";
      }

      /* Remove all options from the select list */
      var doc = (document).getElementById(idPauta);
      var select = $(doc).find('.estacion').children().first();
      select.empty().append(htmlEstacion);
     }
    });
}
function changeECR(tile){
    // showLoading();
    //
    // setTimeout(function () {
    //
    //   idRadio = tile.parentNode.parentNode.childNodes[3].childNodes[0].value;
    //   idPautaRenglon = tile.parentNode.parentNode.childNodes[0].childNodes[0].innerHTML;
    //   $.ajax({
    //    type: "POST",
    //    url: '../html/pautasRadio.php',
    //    data: {updateToIdRadio: idRadio,updatePautaRenglon: idPautaRenglon},
    //    async: true,
    //    beforeSend: function(){
    //      showLoading();
    //    },
    //    success: function(response) {
    //      console.log(response);
    //      setDaysModals();
    //      hideLoading();
    //    }
    //   });
    //
    // }, 1000);

}
function deleteRenglon(renglon){
  idRenglon =  renglon.parentNode.parentNode.childNodes[0].childNodes[0].innerHTML;

  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {idRenglon: idRenglon},
   async: true,
   beforeSend: function(){
     showLoading();
    },
   success: function(response) {
     location.reload();
   }
  });
}
function sortSelects(selElem){
  sortSel(selElem.parentNode.parentNode.childNodes[3].childNodes[0]);
  sortSel(selElem.parentNode.parentNode.childNodes[2].childNodes[0]);
  sortSel(selElem.parentNode.parentNode.childNodes[1].childNodes[0]);

}
function sortSel(selElem){

  var tmpAry = new Array();
    for (var i=0;i<selElem.options.length;i++) {
        tmpAry[i] = new Array();
        tmpAry[i][0] = selElem.options[i].text;
        tmpAry[i][1] = selElem.options[i].value;
    }
    tmpAry.sort();
    while (selElem.options.length > 0) {
        selElem.options[0] = null;
    }
    for (var i=0;i<tmpAry.length;i++) {
        var op = new Option(tmpAry[i][0], tmpAry[i][1]);
        selElem.options[i] = op;
    }
    return;

}

function setSelectValues(selElem,prevEstado,prevCiudad,prevEstacion){
  selElem.parentNode.parentNode.childNodes[1].childNodes[0].value = prevEstado;
  selElem.parentNode.parentNode.childNodes[2].childNodes[0].value = prevCiudad;
  selElem.parentNode.parentNode.childNodes[3].childNodes[0].value = prevEstacion;
}
function showLoading(){
  var loading = document.getElementById('loading');
  loading.style.display = "block";
}
function hideLoading(){
  var loading = document.getElementById('loading');
  loading.style.display = "none";
}
function mostrarModalNuevoRenglon(){
  // -----------------------------------------------------------------------------
  // Modals Management
  // -----------------------------------------------------------------------------
  var modal = document.getElementById('modalNuevoRenglon');

  var span = document.getElementsByClassName("closeNuevoRenglon")[0];

  modal.style.display = "block";

  span.onclick = function() {
      modal.style.display = "none";
  }
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
  }
}


//Todo sobre nuevo renglones
function estadosNRChange(value){
  var select = '';
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
       + response[i]['ciudad']
       +"</option>";
      }
      /* Remove all options from the select list */
      var select = $(document).find('.ciudadesNuevoRenglon');
      select.empty().append(t);

      var ciudad = select[0];
      ciudadesNRChange(ciudad);
    }
  });
}
function ciudadesNRChange(value){
  // console.log(value.childNodes[0].value.toString());

  var idPauta = '';

  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {ciudadID: value.childNodes[0].value.toString()},
   async: true,
   success: function(response) {
    response = JSON.parse(response);

    var htmlEstacion ='';
    var htmlFrecuencia ='';
    var htmlSiglas ='';

    for(var i = 0; i<response.length;i++){
     htmlEstacion+="<option value='"+ response[i]['idRadio'] +"'>"
     + response[i]['estacion']+ " | "
     + response[i]['frecuencia'] + " | "
     + response[i]['siglas']
     +"</option>";
    }

    /* Remove all options from the select list */
    var select = $(document).find('.estacionesNuevoRenglon');
    select.empty().append(htmlEstacion);
   }
  });
}
function agregarNuevoRenglon(){
  var estado = $(document).find('.estadosNuevoRenglon')[0].value;
  var ciudad = $(document).find('.ciudadesNuevoRenglon')[0].value;
  var estacion = $(document).find('.estacionesNuevoRenglon')[0].value;

  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {idNuevaRadio: estacion},
   async: true,
   success: function(response) {
     location.reload();
   }
  });
}
function setNombre(){
  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {getNombre:1},
   async: true,
   success: function(response) {

     var title = $(document).find('.titlePautasRadio')[0];
     title.innerHTML = "Pautas de " + JSON.parse(response);
   }
  });
}


function changeRating(elem){
  showLoading();

  var idPautaRenglon = elem.parentNode.parentNode.id;
  var rating = elem.innerHTML.replace('<br>','').replace(' ','');
  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {idPautaRenglonRating:idPautaRenglon, rating: rating},
   async: true,
   success: function(response) {
     hideLoading();
     getGRPS();
     getImpactos();
   }
  });
}
function changeUniverso(elem){
  showLoading();

  var universo = elem.value;

  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {universo: universo},
   async: true,
   success: function(response) {
     hideLoading();

   }
  });

}
function getGRPS(){
  var spots=0;
  var rating = 0;
  var grps = $(document).find('.grp');
  for (var i = 0; i < grps.length; i++) {

    spots = grps[i].parentNode.parentNode.childNodes[5].childNodes[0].innerHTML;
    rating = grps[i].parentNode.parentNode.childNodes[8].childNodes[0].innerHTML;
    grp = spots*rating;

    grps[i].innerHTML=grp.toString().match(/^-?\d+(?:\.\d{0,3})?/);

  }

}
function getImpactos(){
  var spots=0;
  var rating = 0;
  var impactos = $(document).find('.impacto');
  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {getUniverso: 0},
   async: true,
   success: function(response) {
     for (var i = 0; i < impactos.length; i++) {


       grps = impactos[i].parentNode.parentNode.childNodes[9].childNodes[0].innerHTML;
       impacto = grps*response/100;

       impactos[i].innerHTML=impacto.toString().match(/^-?\d+(?:\.\d{0,3})?/);
     }
   }
  });
}
function getComision(){
  var comision = $(document).find('.comision');
  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {getComision: 0},
   async: true,
   success: function(response) {
     response = JSON.parse(response);
     // console.log(response);
     for (var i = 0; i < comision.length; i++) {


       idRadio = comision[i].parentNode.parentNode.childNodes[3].childNodes[0].value;
       inversion = comision[i].parentNode.parentNode.childNodes[6].childNodes[0].innerHTML.replace('$', '');

       for (var j = 0; j < response.length; j++) {
         if(response[j]['idRadio']==idRadio){
           comisionRadio = inversion*response[j]['comision']/100;
           comision[i].innerHTML = "$"+comisionRadio.toString().match(/^-?\d+(?:\.\d{0,3})?/);
         }
       }
     }
   }
  });
}

function exportClientVersion(){

  var tablaCliente;

  $.ajax({
   type: "POST",
   url: '../html/pautasRadio.php',
   data: {exportClient: 0},
   async: true,
   success: function(response) {

     var tablaFinal =[];
     var prevCantidad = 0;

     response = JSON.parse(response);

     var prevIdPautaRenglon=response[0]['idPautaRadio'];
     var firstPautaRadio = true;
     var firstTarifa = true;

     var nombrePauta = response[0]['nombre'];

     for (var i = 0; i < response.length; i++) {
       if (firstPautaRadio || response[i]['idPautaRadio'] != prevIdPautaRenglon) {
            firstPautaRadio=false;
            tablaFinal[i] = {estado:response[i]['estado'],
                            ciudad:response[i]['ciudad'],
                            estacion: response[i]['estacion'],
                            frecuencia: response[i]['frecuencia'],
                            siglas: response[i]['siglas'],
                            spots: [],
                            totalSpots: 0,
                            inversion: 0,
                            rating: 0,
                            GRPS: 0,
                            impactos: 0};
            for (var j = 0; j < response.length; j++) {
              if(firstTarifa ||
                  response[j]['idTarifa'] == prevTarifa &&
                  response[j]['idPautaRadio'] == response[i]['idPautaRadio'])
              {
                firstTarifa=false;
                tablaFinal[i]['spots'].push({fecha: response[j]['fecha'],cantidad: response[j]['cantidad']});
                tablaFinal[i]['totalSpots'] += parseInt(response[j]['cantidad']);
              }
              prevTarifa = response[i]['idTarifa'];
            }
            tablaFinal[i]['inversion'] = parseFloat(tablaFinal[i]['totalSpots'])*parseFloat(response[i]['tarifaEspecifica']);
            tablaFinal[i]['rating'] = response[i]['rating'];
            tablaFinal[i]['GRPS'] = tablaFinal[i]['totalSpots']*tablaFinal[i]['rating'];
            tablaFinal[i]['impactos'] = tablaFinal[i]['GRPS']*response[i]['universo']/100;


       }
       prevIdPautaRenglon = response[i]['idPautaRadio'];
     }
     tablaFinal.clean(undefined);
     console.log(JSON.stringify(tablaFinal));


     // delete response[0];
     // ws = XLSX.utils.json_to_sheet(tablaFinal);
     //
     // var wb = XLSX.utils.book_new();
     // XLSX.utils.book_append_sheet(wb, ws, "test");
     // XLSX.writeFile(wb, "Pauta_Radio_"+nombrePauta+".xlsx");
   }
  });

  // tablePautas = $(document).find('.month')[0];
  //
  // ws = XLSX.utils.table_to_sheet(tablePautas);

}

Array.prototype.clean = function(deleteValue) {
  for (var i = 0; i < this.length; i++) {
    if (this[i] == deleteValue) {
      this.splice(i, 1);
      i--;
    }
  }
  return this;
};
