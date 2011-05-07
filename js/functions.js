function showProcessing(){
    document.getElementById("processing").innerHTML = "PROCESSING...";
    document.getElementById("loadingimage").style.visibility = "visible";
    document.getElementById("bondsdiv").innerHTML = "";
    document.getElementById("graphdiv").innerHTML = "";
    document.getElementById("listofbondsdiv").innerHTML = "";
    document.getElementById("bondsdiv").style.visibility = "hidden";
    document.getElementById("graphdiv").style.visibility = "hidden";
    document.getElementById("listofbondsdiv").style.visibility = "hidden";
    document.getElementById("submitlink").style.visibility = "hidden";
}

function changeSkin(id,method){
    var path = document.getElementById(id).src;
    var index = path.indexOf("_on");
    if(index == -1){
        document.getElementById(id).src = "images/"+method+"_on.png";
        setMethod('input'+method, method);
        document.getElementById(method+"details").style.display = "block";
    }
    else{
        document.getElementById(id).src = "images/"+method+".png";
        setMethod('input'+method, '');
        document.getElementById(method+"details").style.display = "none";
    }
    
}

function setMethod(method,value){
    document.getElementById(method).value = value;
}