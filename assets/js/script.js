function SignInControl(event){
    if (document.getElementById("loginUsername").value=="" || document.getElementById("loginPassword").value==""){
        alert("All fields are mandatory.");
        event.preventDefault();
    }
}
function RegisterControl(event){
    if (document.getElementById("registerName").value=="" || document.getElementById("registerUsername").value=="" || 
    document.getElementById("registerEmail").value=="" || document.getElementById("registerPassword").value=="" ||
    document.getElementById("registerRepeatPassword").value==""|| document.getElementById("add").value==""
    || document.getElementById("registerlastName").value=="" ){
        alert("All fields are mandatory.");
        event.preventDefault();   
    }else if (!isValidEmail(document.getElementById("registerEmail").value)) {
        alert("Please enter a valid email address.");
        event.preventDefault();
      } else if (document.getElementById("registerPassword").value !== document.getElementById("registerRepeatPassword").value) {
        alert("Passwords do not match.");
        event.preventDefault();
      }
}
function ModifyTeacherControl(event){
    if (document.getElementById("name").value=="" || document.getElementById("email").value=="" ||
    document.getElementById("lastname").value=="" || document.getElementById("add").value=="" ){
        alert("All fields are mandatory.");
        event.preventDefault();   
    }else if (!isValidEmail(document.getElementById("email").value)) {
        alert("Please enter a valid email address.");
        event.preventDefault();
      }
}
function CreateSubject(event){
    if (document.getElementById("title").value=="" || document.getElementById("desc").value==""){
        alert("All fields are mandatory.");
        event.preventDefault();   
    }
}
function NewPassword(event){
    if (document.getElementById("pass").value==""   ){
        alert("All fields are mandatory.");
        event.preventDefault();   
    }
}
function AddStudent(event){
    if (document.getElementById("email").value==""){
        alert("All fields are mandatory.");
        event.preventDefault();   
    }else if (!isValidEmail(document.getElementById("email").value)) {
        alert("Please enter a valid email address.");
        event.preventDefault();
      }
}
function EditNote(event){
    if (document.getElementById("ex").value=="" || document.getElementById("ds").value==""){
        alert("All fields are mandatory.");
        event.preventDefault();   
    }
    else if(document.getElementById("ex").value!=='NULL' && document.getElementById("ex").value<0 && document.getElementById("ex").value>20
    || document.getElementById("ds").value!=='NULL'&& document.getElementById("ds").value<0 && document.getElementById("ds").value>20)  {
        alert("Please enter a valid grade.");
        event.preventDefault();
    }
}
function isValidEmail(email) {
    const emailRegex = /\S+@\S+\.\S+/;
    return emailRegex.test(email);
}
function AdminSignInControl(event){
    if(document.getElementById("adminpass").value==""){
        alert("Please Write the Password if available!");
        event.preventDefault();
    }
}
$('#loginmodal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
$('#registermodal').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
