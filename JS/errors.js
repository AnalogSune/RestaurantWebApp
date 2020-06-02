var cl;
function addMessage(msg, isError = true){
    var fmsg = "<p><label class='text-" + (isError ? "danger" : "success") + "'>"+msg+"</label></p>";
    document.getElementById("errors").innerHTML += fmsg;
    clearMessagesTimeout();
}

function clearMessages(msg){
    document.getElementById("errors").innerHTML = "";
}

function clearMessagesTimeout(time = 2000){
    if (cl)
        clearTimeout(cl);
    cl = setTimeout(function(){
        clearMessages()}
        , time);
}

function fail_callback(xhr){
    addMessage(xhr.responseText);
}

function success_callback(msg){
    addMessage(msg, false);
}