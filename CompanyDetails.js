let companyName = document.getElementById('companyName');
let companyLogo = document.getElementById('companyLogo');
let companyEmail = document.getElementById('companyEmail');
let companyWebsite = document.getElementById('companyWebsite');

function packageData() {
	let formData = new FormData();
	if (companyName.value != '') {
		formData.append('name', companyName.value);
	}
	if (companyEmail.value != '') {
		formData.append('email', companyEmail.value);
	}
	if (companyLogo.value != '') {
		formData.append('logo', (companyLogo.files != undefined) ? companyLogo.files[0] : '');
	}
	if (companyWebsite.value != '') {
		formData.append('website', companyWebsite.value);
	}
	return formData;
}

function resetMessages() {
	document.getElementById('nameMessage').innerHTML = '';
	document.getElementById('emailMessage').innerHTML = '';
	document.getElementById('logoMessage').innerHTML = '';
	document.getElementById('websiteMessage').innerHTML = '';
}