
	window.fbAsyncInit = function() {
    FB.init({
      appId      : '1465837763458763',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
	refreshFB();
  };


  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/es_LA/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
	function disableRegisterForm(){
		var form = document.getElementById("registerForm");
		var elements = form.elements;
		for (var i = 0, len = elements.length; i < len; ++i) {
			elements[i].readOnly = true;
		}
		document.getElementById("btn_submit").disabled = true;
		document.getElementById("btn_login").disabled = true;
   }   
	function enableRegisterForm(){
		var form = document.getElementById("registerForm");
		
		var elements = form.elements;
		for (var i = 0, len = elements.length; i < len; ++i) {
			elements[i].readOnly = false;
		}
		document.getElementById("btn_submit").disabled = false;
		document.getElementById("btn_login").disabled = false;
   }
	function refreshFB(){
		console.log('-- Get Status From FaceBook ---');
		
		FB.getLoginStatus(function(response) {
		
		console.log(response);
		
		if (response.status === 'connected') {
			console.log('CONNECTED');
		// the user is logged in and has authenticated your
		// app, and response.authResponse supplies
		// the user's ID, a valid access token, a signed
		// request, and the time the access token 
		// and signed request each expire
		
		var uid = response.authResponse.userID;
		var accessToken = response.authResponse.accessToken;
		FB.api('/me', {fields: 'last_name,first_name,email,name'}, function(response) {
			console.log(response);
			var checkUser = $.ajax({
					url: 'func_checkuser.php',
					method: 'POST',
					data: {id:uid,email:response.email},
					
					success: function(data) {
						
						console.log('raw data from FB ' + data); // Inspect this in your console
						obj = JSON.parse(data);
						console.log('json data obj : ' + obj); // Inspect this in your console
						if ((obj.ismember === "true") && (obj.isFB === "true")){
							// user is currently connected with Facebook
							// user already has an account and is linked with Facebook
							// disable the whole form 
							// show alert <div> to propose options to user [start session from Facebook login or unlink account and facebook}
							console.log('*** isMember AND isFB ***');
							
							//document.getElementById('with_FB_link').hidden=false;
							//document.getElementById('with_no_FB_link').hidden=true;
							
							disableRegisterForm();
							$('#myModal1').modal('show');
		
						}
						
						else if ((obj.ismember === "true") && (obj.isFB === "false")){
							// user is currently connected with Facebook
							// user already has an account with same email as Facebook but account is not linked with Facebook
							// disable the whole form 
							// show alert <div> to propose options to user to link is account with Facebook
							console.log('*** isMember AND NOT isFB ***');
							//document.getElementById('with_FB_link').hidden=true;
							//document.getElementById('with_no_FB_link').hidden=false;
							disableRegisterForm();
							$('#myModal').modal('show');
						}
						else {
							// user is currently connected with Facebook and has no account here (no email, no facebookid matching)
							console.log('*** NOT isMember***');
							//document.getElementById('with_FB_link').hidden=true;
							//document.getElementById('with_no_FB_link').hidden=true;
							enableRegisterForm();
						}
				}
						
				});
			
				console.log('Check User = ' + checkUser);
				document.getElementById('inputUserFirstName').value = response.first_name;
				document.getElementById('inputUserLastName').value = response.last_name;
				document.getElementById('inputUserEmail').value = response.email;
				document.getElementById('inputUserEmailCheck').value = response.email;
				document.getElementById('facebookid').value = response.id;
				document.getElementById('inputUserEmail').disabled=true;
				document.getElementById('inputUserEmailCheck').disabled=true;
				
				document.getElementById('fbWelcome').hidden=false;
				document.getElementById('fbWelcome').innerHTML='<h4 class="text-center">Hola <strong> ' + response.name + '</strong></h4>';
				document.getElementById('fbPhoto').hidden=false;
				document.getElementById('fbPhoto').innerHTML='<img src="https://graph.facebook.com/' + response.id + '/picture?width=120" alt="Circle Image" class="img-circle img-responsive center-block" width="120" height="120">';				
			});
			
		} else if (response.status === 'not_authorized') {
			// the user is logged in to Facebook, 
			// but has not authenticated your app
			console.log('THE APP IS NOT AUTHORIZED');
			//document.getElementById('with_no_FB_link').hidden=true;
			//document.getElementById('with_FB_link').hidden=true;
			document.getElementById('inputUserFirstName').value = '';
			document.getElementById('inputUserLastName').value = '';
			document.getElementById('inputUserEmail').value = '';
			document.getElementById('inputUserEmailCheck').value = ''
			document.getElementById('inputUserEmail').disabled=false;
			document.getElementById('inputUserEmailCheck').disabled=false;
			
			document.getElementById('fbPhoto').hidden=true;
			document.getElementById('fbWelcome').hidden=true;
			document.getElementById('fbPhoto').innerHTMML='';
			document.getElementById('fbWelcome').innerHTML='';
			enableRegisterForm();
  } else {
    // the user isn't logged in to Facebook.
			console.log('NOT LOGGED TO FACEBOOK');
			//document.getElementById('with_no_FB_link').hidden=true;
			//document.getElementById('with_FB_link').hidden=true;
			
			document.getElementById('inputUserFirstName').value = '';
			document.getElementById('inputUserLastName').value = '';
			document.getElementById('inputUserEmail').value = '';
			document.getElementById('inputUserEmailCheck').value = ''
			document.getElementById('inputUserEmail').disabled=false;
			document.getElementById('inputUserEmailCheck').disabled=false;
			
			document.getElementById('fbPhoto').hidden=true;
			document.getElementById('fbWelcome').hidden=true;
			document.getElementById('fbPhoto').innerHTMML='';
			document.getElementById('fbWelcome').innerHTML='';
			enableRegisterForm();
  }
 });
 }
  
	function adduser(){
	
		console.log('Calling JS function adduser()');
		event.preventDefault();
		//console.log('event.preventDefault()');
		var myemail = $("#inputUserEmail").val();
		var mypassword = $("#inputUserPassword").val();
		var myfirstname = $("#inputUserFirstName").val();
		var mylastname =$("#inputUserLastName").val();
		var myfbid =$("#facebookid").val();
		console.log('variables assigned, now Ajax');
		console.log('MYEMAIL' + myemail);
		console.log('MYPASSWORD' + mypassword);
		console.log('myfirstname' + myfirstname);
		var addUser = $.ajax({
			url: 'func_adduser.php',		
			method : 'POST',
			data:
			{
				email: myemail,
				password : mypassword,
				firstname: myfirstname,
				lastname : mylastname,
				fbid : myfbid,

			},
			
			success: function(response)
			{
				console.log('success');	
				console.log(response);
document.getElementById('myModalLabel').innerHTML = 'El usario esta registrado';
$('#myModal').modal('show');			
			}, 
			error: function(response)
			{
				console.log('error');
				console.log(response);

				$('#myModal').modal('show');	

			document.getElementById('myModalLabel').innerHTML = 'Un error ha ocurido ...';		
			}, 
		});
		console.log('Out of Ajax');
	
	}
