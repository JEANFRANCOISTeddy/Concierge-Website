let columnName = document.getElementsByName("columnName").value;
let size = document.getElementsByName("size").value;
const test = document.getElementById('inputAdded');

function verify(){
  let select = document.getElementById("choice");
  let choice = select.selectedIndex;
  let value = select.options[choice].value;

  const container = document.getElementById("newInput");
  const input = document.createElement("input");
  const inputAdded = document.getElementById("inputAdded");

  if( value === "CHAR" || value === "VARCHAR"){
    if (inputAdded != null) {
      const parent = inputAdded.parentNode;
      parent.removeChild(inputAdded);
    }
    input.type="number";
    input.name="size";
    input.id="inputAdded";
    input.placeholder="Taille de la variable";
    container.appendChild(input);
  }

  else if( value === "DATE"){
    if (inputAdded != null) {
      const parent = inputAdded.parentNode;
      parent.removeChild(inputAdded);
    }
  }

  else if( value === "TIME"){
    if (inputAdded != null) {
      const parent = inputAdded.parentNode;
      parent.removeChild(inputAdded);
    };
  }

  else if( value === "TEXT"){
    if (inputAdded != null) {
      const parent = inputAdded.parentNode;
      parent.removeChild(inputAdded);
    }
  }

  else{
    if (inputAdded != null) {
      const parent = inputAdded.parentNode;
      parent.removeChild(inputAdded);
    };
  }

}

function deplacer(l1,l2) {
  /*
   * Option --> Récupérer le nom et la value du champs sélectionné
   */
 if (l1.options.selectedIndex>=0) {
   let option = new Option(l1.options[l1.options.selectedIndex].text,l1.options[l1.options.selectedIndex].value);
   l2.options[l2.options.length] = option;
   l1.options[l1.options.selectedIndex] = null;
  }else{
     alert("Aucune option sélectionnée");
  }
}

function traitement(){
  newInput();
  deleteBdd();
}

function newInput() {

   let liste = document.getElementById("liste2");
   let listeLength = document.getElementById("liste2").options.length;
   const container = document.getElementById('newInput2');

   const br = document.createElement('br');
   const label = document.createElement('label');
   const input = document.createElement('input');

     for(let i=0; i<listeLength; i++){
       label.innerHTML = liste.options[i].text + " :";
       input.name = liste.options[i].text;
       input.placeholder = liste.options[i].text;
       input.value = liste.options[i].text;

       container.appendChild(label);
       container.appendChild(input);
       container.appendChild(br);
     }

}

function deleteBdd(){
  let nameCategorie = document.getElementById("inputHidden").value;
  let liste = document.getElementById("liste3");
  let listeLength = document.getElementById("liste3").options.length;
  let array = [];
    for(let i=0; i<listeLength; i++){
      array.push(liste.options[i].value);
    }
  //AJAX
  const request = new XMLHttpRequest();
  request.open('POST','delete_column.php');
  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  request.onreadystatechange = function(){
    if(request.readyState === 4){
      const accept = document.getElementById('accept');
      accept.innerHTML += request.responseText;
      const parent = document.getElementById('liste3');
      const div = document.getElementById(nameCategorie);
      parent.removeChild(div);
    }
  }
  request.send(`array=${array}&nameCategorie=${nameCategorie}`);
}

function verifyColumn(){
  const field = document.getElementById("columnName");
  const nameSuccess = check(field.value);
  displayErrors(field,nameSuccess);
}

function check(variable){
  let countNumbers = 0;
  for(let i=0; i < variable.length; i++){
      const code = variable.charCodeAt(i);
      if(code >= 48 && code <= 57){
          countNumbers++;
      }
  }
  return countNumbers > 0;
}

function space(variable){
  for(let i=0; i < variable.length; i++){
    const name = variable.indexOf(" ");
    if(name != -1){
        return true;
    }
  }
  return false;
}

function displayErrors(input, success){
  if( success ){
      input.style="border: 1.5px solid red;";
  }else{
      input.style="border: 1px solid grey;";
  }
}

function empty(value){
  if( value != ""){
    return true;
  }else{
    return false;
  }
}
