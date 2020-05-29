function deleteService(categoryName){
  const request = new XMLHttpRequest();
  request.open('POST','html/back_office/delete_service.php');
  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  request.onreadystatechange = function(){
    if(request.readyState === 4){
      const parent = document.getElementById('parent');
      const div = document.getElementById(categoryName);
      parent.removeChild(div);
    }
  }
  request.send(`categoryName=${categoryName}`);
}
