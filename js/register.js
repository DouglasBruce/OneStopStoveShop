// Registration form javascript

// Fill the year select option box from 1901 till the current year
function initYear() {
	var yearobj=document.getElementById("yearob");
	var d = new Date();
	var currentyear=d.getFullYear();
	for(i=1901;i<=currentyear;i++) {
		theoption=document.createElement("option");
		theoption.text=i;
		theoption.value=i;
		yearobj.add(theoption);
	}
	var defaultyear=yearobj.length-17;
	yearobj.selectedIndex=defaultyear;
}
// initialise the first 31 days of the month for default month January
function initDay() {
	var dayobj=document.getElementById("dayob");
	for(i=1;i<=31;i++) {
		theoption=document.createElement("option");
		theoption.text=i;
		theoption.value=i;
		dayobj.add(theoption);
	}
}
// add or remove days to match the days for the selected month and year
// this is called when either the month or year select options are changed
function fillDay() {
	var dayobj=document.getElementById("dayob");
	var monthobj=document.getElementById("monthob");
	var yearobj=document.getElementById("yearob");
	var currentyear=parseInt(yearobj.options[yearobj.selectedIndex].value);
	var currentmonth=parseInt(monthobj.options[monthobj.selectedIndex].value);
	// 31 days default, on february check for leap year
	// case fallthrough used to capture months with 30 days
	var maxdays=31;
	switch(currentmonth) {
		case 2:
		maxdays=((currentyear%4)==0)?29:28;
		break;
		case 4:
		case 6:
		case 9:
		case 11:
		maxdays=30;
		break;
	}
	if(maxdays>dayobj.length) {
		// add some options days 29 -> 31 as needed
		startday=dayobj.length+1;
		for(i=startday;i<=maxdays;i++) {
			theoption=document.createElement("option");
			theoption.text=i;
			theoption.value=i;
			dayobj.add(theoption);
		}
	} else if (maxdays<dayobj.length) {
		// remove some options days 31 -> 29 as needed
		for(i=dayobj.length;i>=maxdays;i--) {
			dayobj.remove(i);
		}
	}
}
// check if an element is empty
function checkEmpty(element) {
	return (element==null || typeof(element)==='undefined' || element=="")?true:false;
}
// check if passwords match
function checkPass(pass1,pass2) {
	return (!checkEmpty(pass1) && !checkEmpty(pass2) && pass1!=pass2)?true:false;
}
// check terms have been agreed
function checkTerms(agreeterm) {
	return (agreeterm.checked)?false:true;	
}
// check age is at least 16 years old
function checkAge(doby,dobm,dobd) {
    var today = new Date();
    var birthdate = new Date(doby,dobm,dobd);
    var age = today.getFullYear() - birthdate.getFullYear();
    var m = (today.getMonth()+1) - birthdate.getMonth();
    if (m < 0 || (m == 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    return (age<16)?true:false;
}
//Check email format
function checkEmail(email) {
	var emailregex=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i
	return (!emailregex.test(email));
}
// check whether or not username or email has been registered already
function checkUser(username,email,callback) {
	var useravailable=true;
	// create an XMLHTTPRequest
	var XHR=createXHR();
	XHR.open("POST","../php/checkUser.php",false);
	XHR.onreadystatechange = (function() {
		if(XHR.readyState==4) {
			if(XHR.status==200) {
				// Get json array returned, 0 or 1 users
				var responsedata=JSON.parse(XHR.responseText)[0];
				// Will be 0 if there are no matching users
				if(parseInt(responsedata.userexists)!=0) { 
					// user exists feedback
					usernameFb.innerHTML="Username has already been registered";
					useravailable=false;
				} else {usernameFb.innerHTML="";}
				if (parseInt(responsedata.emailexists)!=0) {
					// email exists feedback
					emailFb.innerHTML="Email has already been registered";
					useravailable=false;
				} else {emailFb.innerHTML="";}
			} else if(XHR.status==400) {
				useravailable=false;
				usernameFb.innerHTML="Could not process request";
			}
		}
		// callback to return whether or not user is available to
		// main checkForm function
		callback(useravailable);
	});
	// Send request
	XHR.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	XHR.send("username="+encodeURIComponent(username)+"&email="+encodeURIComponent(email));
}
// Provide password strength feedback based on length and ~ apparent complexity
function testStrength(e) {
	// Baseline output colour of red for weak passwords
	var resultcolour="#F00";
	var currpass=getTargetElement(e).value;
	// Get the total length of password, baseline strength of 1 for a 6 character password
	var passtr=(currpass.length<6)?1:currpass.length/2.5;
	// Use Regex to find what types of characters, symbols and numbers used
	var hassymbol=((/[-!£$%^&*()_+|~=`{}\[\]:";'<>?,.\/]/).test(currpass))?2:0;
	var hasnumeric=((/[0-9]/).test(currpass))?1.5:0;
	var hasupper=((/[A-Z]/).test(currpass))?1.3:0;
	var haslower=((/[a-z]/).test(currpass))?1.2:0;
	// Calculate the overall relative strength of the password
	var passmark=passtr*(hassymbol+hasnumeric+hasupper+haslower);
	if(passmark>19) { passmark=19; }
	// Yellow colour for medium strength passwords
	if(passmark>8) { resultcolour="#FF0"; }
	// Green colour for strong passwords
	if(passmark>16) { resultcolour="#0F0"; }
	// Set wide and background style properties for output div
	document.getElementById("passstrresult").style.backgroundColor=resultcolour;
	document.getElementById("passstrresult").style.width=passmark+"em";
}

function checkForm(e) {
	var iscomplete=true;
	var testuser=true;
	var theform=document.getElementById("registeruser");
	with(theform) {
		if(checkEmpty(firstname.value)) 
			{ firstnameFb.innerHTML="Please add your Forname/s"; iscomplete=false;}
		else
			{ firstnameFb.innerHTML=""; }
		if(checkEmpty(surname.value)) 
			{ surnameFb.innerHTML="Please add your Surname"; iscomplete=false;}
		else
			{ surnameFb.innerHTML=""; }
		if(checkEmpty(username.value)) 
			{ usernameFb.innerHTML="Please add your desired Username"; iscomplete=false; testuser=false; }
		else
			{ usernameFb.innerHTML=""; }
		if(checkEmpty(housename.value)) 
			{ housenameFb.innerHTML="Please add your House Name / Number"; iscomplete=false;}
		else
			{ housenameFb.innerHTML=""; }
		if(checkEmpty(streetname.value)) 
			{ streetnameFb.innerHTML="Please add your Street Name"; iscomplete=false;}
		else
			{ streetnameFb.innerHTML=""; }
		if(checkEmpty(city.value)) 
			{ city.innerHTML="Please add your City"; iscomplete=false;}
		else
			{ city.innerHTML=""; }
		if(checkEmpty(county.value)) 
			{ county.innerHTML="Please add your County"; iscomplete=false;}
		else
			{ county.innerHTML=""; }
		if(checkEmpty(postcode.value)) 
			{ postcode.innerHTML="Please add your Postcode"; iscomplete=false;}
		else
			{ postcode.innerHTML=""; }
		if(checkEmpty(userpass.value)) 
			{ userpassFb.innerHTML="Please enter a Password"; iscomplete=false;}
		else
			{ userpassFb.innerHTML=""; }
		if(checkEmpty(secondpass.value)) 
			{ secondpassFb.innerHTML="Please re-enter your Password"; iscomplete=false;}
		else
			{ secondpassFb.innerHTML=""; }
		if(checkPass(userpass.value,secondpass.value))
			{ secondpassFb.innerHTML="Passwords do not match"; iscomplete=false;}
		if(checkTerms(tnc))
			{ tncFb.innerHTML="You must agree to the website Terms & Conditions"; iscomplete=false;}
		else
			{ tncFb.innerHTML=""; }
		if(checkAge(yearob.value,monthob.value,dayob.value))
			{ ageFb.innerHTML="Sorry, you must be 16 to register."; iscomplete=false; }
		else
			{ ageFb.innerHTML=""; }
		if(checkEmail(emailadd.value))
			{ emailFb.innerHTML="Please add a valid Email Address"; iscomplete=false; testuser=false;  }
		else
			{ emailFb.innerHTML=""; }
		// check user function with callback from XHR to check 
		// whether or not user or email exists.
		if(testuser) {
			checkUser(username.value,emailadd.value, function(useravailable){
			if (!useravailable) { stopDefaultAction(e);}
		});
	}

	}
	if(!iscomplete) {stopDefaultAction(e);}
}



// initialise registration form
function prepareRegister() {
	initYear();
	initDay();
	if(window.addEventListener) {
		document.getElementById("monthob").addEventListener("change",fillDay,false);
		document.getElementById("yearob").addEventListener("change",fillDay,false);
		document.getElementById("userpass").addEventListener("keyup", testStrength, false);
		document.getElementById("registeruser").addEventListener("submit",checkForm,false);
	} else if(window.attachEvent) {
		document.getElementById("monthob").attachEvent("onchange",fillDay);
		document.getElementById("yearob").attachEvent("onchange",fillDay);
		document.getElementById("userpass").attachEvent("onkeyup", testStrength);
		document.getElementById("registeruser").attachEvent("onsubmit",checkForm);
	}

}
