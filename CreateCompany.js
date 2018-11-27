document.getElementById('submit').style.display = 'none';//only for if js is disabled

let submitButton = document.getElementById('submitButton');
submitButton.addEventListener('click', submitData);
submitButton.style.display = 'none';



function evaluateEmail(email) {
	return /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/.test( email );
}

function evaluateFormInputs(e) {
	if (e.target != e.currentTarget) {
		let formValid = true;
		if (companyName.value == '') {
			formValid = false;
		}
		if (formValid && companyEmail.value != '') {
			if (!evaluateEmail(companyEmail.value)) {
				formValid = false;
			}
		}
		submitButton.style.display = (formValid) ? 'block' : 'none';
	}
}
let inputs = document.getElementById('inputsTable');
inputs.addEventListener('mouseover', evaluateFormInputs);
inputs.addEventListener('mouseout', evaluateFormInputs);


function submitData() {
	let metaTag = document.getElementsByTagName('meta')[1];
	let data = packageData();
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			let response = JSON.parse(this.responseText);
			if (response.success != false) {
				let message = response.success + ' <a href="/company/' + response.companyID + '">here</a>';
				document.getElementById('successMessage').innerHTML = message;
			} else {
				if (response.errors.hasOwnProperty('name')) {
					document.getElementById('nameMessage').innerHTML = response.errors.name;
				}
				if (response.errors.hasOwnProperty('email')) {
					document.getElementById('emailMessage').innerHTML = response.errors.email;
				}
				if (response.errors.hasOwnProperty('logo')) {
					document.getElementById('logoMessage').innerHTML = response.errors.logo;
				}
				if (response.errors.hasOwnProperty('website')) {
					document.getElementById('websiteMessage').innerHTML = response.errors.website;
				}
			}
		}
	};
	xhttp.open('POST', '/insertCompany');
	xhttp.setRequestHeader('X-CSRF-TOKEN', metaTag.getAttribute('content'));
	xhttp.send(data);
}