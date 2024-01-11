function sortTableAsc() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("usuariosTable");
  switching = true;
  console.log("OWO")
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    console.log("Entro al switch")
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    console.log(rows)
    console.log(rows[1].getElementsByTagName("td")[1])
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 0; i < rows.length; i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      console.log("UWU")
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("td")[1];
      x = x.innerHTML;
      xC = x.replace("-","/");
      xC = xC.replace("-","/");
      y = rows[i + 1].getElementsByTagName("td")[1];
      y = y.innerHTML;
      yC= y.replace("-","/");
      yC= yC.replace("-","/");
      console.log(new Date(yC))
      //check if the two rows should switch place:
      if (new Date(xC) > new Date(yC)) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

function sortTableDesc() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("usuariosTable");
  switching = true;
  console.log("OWO")
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    console.log("Entro al switch")
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    console.log(rows)
    console.log(rows[1].getElementsByTagName("td")[1])
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 0; i < rows.length; i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      console.log("UWU")
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("td")[1];
      x = x.innerHTML;
      xC = x.replace("-","/");
      xC = xC.replace("-","/");
      y = rows[i + 1].getElementsByTagName("td")[1];
      y = y.innerHTML;
      yC= y.replace("-","/");
      yC= yC.replace("-","/");
      console.log(new Date(yC))
      //check if the two rows should switch place:
      if (new Date(xC) < new Date(yC)) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}