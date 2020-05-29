function deleteSubscription(subscriptionName){
  const request = new XMLHttpRequest();
  request.open('POST','subscription/delete_subscription.php');
  request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  request.onreadystatechange = function(){
    if(request.readyState === 4){
      const parent = document.getElementById('parent');
      const div = document.getElementById(subscriptionName);
      parent.removeChild(div);
    }
  }
  request.send(`subscriptionName=${subscriptionName}`);
}
