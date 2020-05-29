function search() {
    let research = document.getElementById('searchService').value;
    const request = new XMLHttpRequest();
    request.open('POST', 'search.php');
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.onreadystatechange = function () {
        if(request.readyState === 4) {
            const body = document.getElementById('searchSection');
            body.innerHTML = request.responseText;
        }
    };
    request.send(`research=${research}`);
}
