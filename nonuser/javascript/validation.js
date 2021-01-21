let Email = document.getElementById('email');
let Pass = document.getElementById('pass');
let form= document.getElementById('loginForm');
let emaillabel = document.getElementById('emailLabel');

var userName = document.createElement("input");

userName.value=null;


let submit= document.createElement('input');
let atribute= document.createAttribute('type');
atribute.value='button';
submit.setAttributeNode(atribute);

let value= document.createAttribute('value');
value.value = "login";
submit.setAttributeNode(value);
let id= document.createAttribute('id');
id.value='submit';
submit.setAttributeNode(id);


Email.onkeyup= validate;
Pass.onkeyup =validate;

let a =0;



function submitFunction(){
    var xhttp = new XMLHttpRequest();
    console.log("submit");
    xhttp.open("POST", "loginHandler.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("email=" + Email.value + "&pass=" + Pass.value+"&submit=true&name="+userName.value);
    xhttp.onreadystatechange = function () {

        if (this.readyState === 4 && this.status === 200) {
            let result = JSON.parse(xhttp.response);


            if(result.exist===true && result.register==false) {
                    console.log(result.url);
                    window.location.href = result.url;

                    }
                    else if(a===3){
                        alert("to many atempts?");
                        location.href='../index.php';
                }
                else{
                    let registercheck = document.getElementById('registerButton');
                    let name = document.getElementById('name');
                      if(!registercheck && !name) {
                let registerButton = document.createElement("div");
                let id = document.createAttribute('id');
                id.value = "registerButton";
                registerButton.setAttributeNode(id);

                registerButton.innerText = "register";
                          form.appendChild(registerButton);
                          registerButton.onclick= function(){   addregister()};

                     }
                     else if(!name) {
                          console.log(a);
                          a++;
                      }
                }

        }
    };
}



function addregister(){


    console.log("test");

    var register = document.getElementById('registerButton');
    register.remove();

    let type =document.createAttribute("type");
    type.value="text";
    userName.setAttributeNode(type);
    let value =document.createAttribute("value");
    value.value="name";
    userName.setAttributeNode(value);
    let id =document.createAttribute("id");
    id.value="name";
    userName.setAttributeNode(id);
    submit.value="register";

form.insertBefore(userName,emaillabel);
// form.appendChild(userName);


}




function validate() {

    if (Email.value != null && Pass.value != null ) {



        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
               let result = JSON.parse( this.response);
               //
                //
                if (result.validate !== true) {
                   Email.style.background='#FF0000';
                   Pass.style.background='#FF0000';
                    try {
                        form.removeChild(submit);
                    }
                    catch (e) {
                    }
                }
                else {
                    Email.style.background='white';
                    Pass.style.background='white';
                    form.appendChild(submit);
                    let Submitbutton = document.getElementById('submit');
                    Submitbutton.addEventListener('click', submitFunction);

                }
                console.log(result);

            }
        };
            xhttp.open("POST", "loginHandler.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("email=" + Email.value + "&pass=" + Pass.value+"&submit=false&name="+userName.value);
        }
}