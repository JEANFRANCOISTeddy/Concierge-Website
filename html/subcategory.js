function sub_delete(subCategory,categoryName){
  const request = new XMLHttpRequest();
  request.open('POST','back_office/delete_subcategory.php');
  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  request.onreadystatechange = function(){
    if(request.readyState === 4){
      const accept = document.getElementById('accept');
      accept.innerHTML += request.responseText;
      const parent = document.getElementById('parent');
      const div = document.getElementById(subCategory);
      parent.removeChild(div);
    }
  }
  request.send(`subCategory=${subCategory}&categoryName=${categoryName}`);
}
