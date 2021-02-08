// JavaScript Document

function adminvalidation(){
	if(document.getElementById('userlogin').value==""){
		alert("Enter Username for login!");
		return false;
	}
	
	var str=document.getElementById('useremail').value;
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if (filter.test(str)){
		//return true;
	}else{
		alert("Please enter a valid email address!");
		return false;
	}

	if(document.getElementById('password').value==""){
		alert("Enter Password for login!");
		return false;
	}
	
	if(document.getElementById('password').value.length < 5 ){
		alert("Password must be minimium 5 character");
		return false;
	}
	
	if(document.getElementById('confirmpass').value==""){
		alert("Confirm Your Password!");
		return false;
	}
	if(document.getElementById('confirmpass').value!=document.getElementById('password').value){
		alert("Confirm Password not match!");
		return false;
	
	}
}

//function for validate change password
function changepassword(){
	if(document.getElementById('oldpass').value==""){
		alert("Enter Old Password!");
		return false;
	}
	if(document.getElementById('newpass').value==""){
		alert("Enter New Password!");
		return false;
	}
	
	if(document.getElementById('newpass').value!=""){
		if(document.getElementById('newpass').value.length < 5 ){
			alert("Password must be minimium 5 character");
			return false;
		}
	}
	
	if(document.getElementById('confirmpass').value==""){
		alert("Confirm new Password!");
		return false;
	}
	if(document.getElementById('confirmpass').value!=document.getElementById('newpass').value){
		alert("Confirm Password not match!");
		return false;
	
	}
}


/**************confirm delete faq *******************/



/* -------------- style edit --------- */
function getstyle(x){
	var tag=x.options[x.selectedIndex].value;
	window.location="csstyle.php?tag="+tag;
	//alert(tag);
}

/*--------------------window pop up-------------*/
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=1000,height=700,left=150,top =50');");
}
