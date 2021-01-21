


function like( like,id ) {

console.log(like+"   "+id);
    var xhttp = new XMLHttpRequest();

        xhttp.open("POST", "nonuser/getvideo.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("like="+like+"&id="+id );

}