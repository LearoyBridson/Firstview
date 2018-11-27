let edit = document.getElementById('edit');
let cancel = document.getElementById('cancel');
let save = document.getElementById('save');
let submitAsset = document.getElementById('submitAsset');
submitAsset.addEventListener('click', submitAssetCreate);
let assetDescription = document.getElementById('description');
let assetModel = document.getElementById('model');
let assetValue = document.getElementById('value');
let companyID = document.getElementById('companyID');


function setEditMode(on) {
	if (!on) {
		document.getElementById('companyName').value = '';
		document.getElementById('companyEmail').value = '';
		document.getElementById('companyLogo').files[0] = undefined;
		document.getElementById('companyWebsite').value = '';
		
		document.getElementById('nameMessage').innerHTML = '';
		document.getElementById('emailMessage').innerHTML = '';
		document.getElementById('logoMessage').innerHTML = '';
		document.getElementById('websiteMessage').innerHTML = '';
	}
	
	document.getElementById('companyName').style.display = (on) ? 'block' : 'none';
	document.getElementById('companyEmail').style.display = (on) ? 'block' : 'none';
	document.getElementById('companyLogo').style.display = (on) ? 'block' : 'none';
	document.getElementById('companyWebsite').style.display = (on) ? 'block' : 'none';
	cancel.style.display = (on) ? 'block' : 'none';
	save.style.display = (on) ? 'block' : 'none';
	edit.style.display = (on) ? 'none' : 'block';
}

setEditMode(false);
edit.addEventListener('click', function() { setEditMode(true); });
cancel.addEventListener('click', function() { 
	setEditMode(false);
});
save.addEventListener('click', function() { 
	submitCompanyUpdate();
});

function submitCompanyUpdate() {
	let metaTag = document.getElementsByTagName('meta')[1];
	let data = packageData();
	data.append('companyID', companyID.value);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			let response = JSON.parse(this.responseText);
			
			if (response.name != undefined) {
				document.getElementById('nameMessage').innerHTML = '';
				document.getElementById('emailMessage').innerHTML = '';
				document.getElementById('logoMessage').innerHTML = '';
				document.getElementById('websiteMessage').innerHTML = '';
				
				let originalName = document.getElementById('originalName');
				let originalEmail = document.getElementById('originalEmail');
				let originalLogo = document.getElementById('originalLogo');
				let originalWebsite = document.getElementById('originalWebsite');
				
				originalName.innerHTML = response.name;
				originalEmail.innerHTML = response.email;
				originalLogo.src = response.logo;
				originalWebsite.innerHTML = response.website;
				
				setEditMode(false);
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
	xhttp.open('POST', '/editCompany');
	xhttp.setRequestHeader('X-CSRF-TOKEN', metaTag.getAttribute('content'));
	xhttp.send(data);
}


function packageAssetData() {
	let formData = new FormData();
	if (assetDescription.value != '') {
		formData.append('description', assetDescription.value);
	}
	if (assetModel.value != '') {
		formData.append('model', assetModel.value);
	}
	if (assetValue.value != '') {
		formData.append('value', assetValue.value);
	}
	return formData;
}

function resetAssetMessages() {
	document.getElementById('descriptionMessage').innerHTML = '';
	document.getElementById('modelMessage').innerHTML = '';
	document.getElementById('valueMessage').innerHTML = '';
}

function submitAssetCreate() {
	let metaTag = document.getElementsByTagName('meta')[1];
	let data = packageAssetData();
	let table = document.getElementsByClassName('tableBody')[0];
	data.append('companyID', companyID.value);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			let response = JSON.parse(this.responseText);
			if (response.model != undefined) {
				document.getElementById('descriptionMessage').innerHTML = '';
				document.getElementById('modelMessage').innerHTML = '';
				document.getElementById('valueMessage').innerHTML = '';
				
				if (table.children.length < 10) {
					let row = document.createElement('tr');
					let col1 = document.createElement('td');
					let col2 = document.createElement('td');
					let col3 = document.createElement('td');
					let col4 = document.createElement('td');
					
					let val1 = document.createTextNode(response.description);
					let val2 = document.createTextNode(response.model);
					let val3 = document.createTextNode('R' + response.value);
					let val4 = document.createElement('input');
					let att1 = document.createAttribute('type');
					att1.value = 'button';
					let att2 = document.createAttribute('class');
					att2.value = 'deleteButton';
					let att3 = document.createAttribute('value');
					att3.value = 'Delete';
					val4.setAttributeNode(att1);
					val4.setAttributeNode(att2);
					val4.setAttributeNode(att3);
					
					col1.appendChild(val1);
					col2.appendChild(val2);
					col3.appendChild(val3);
					col4.appendChild(val4);
					
					row.append(col1);
					row.append(col2);
					row.append(col3);
					row.append(col4);
				
					table.append(row);
				} else {
					if (right.style.display == 'none') {
						right.style.display = 'block';
					}
				}
				
				document.getElementById('addedAsset').style.display = 'block';
			} else {
				if (response.errors.hasOwnProperty('description')) {
					document.getElementById('descriptionMessage').innerHTML = response.errors.description;
				}
				if (response.errors.hasOwnProperty('model')) {
					document.getElementById('modelMessage').innerHTML = response.errors.model;
				}
				if (response.errors.hasOwnProperty('value')) {
					document.getElementById('valueMessage').innerHTML = response.errors.value;
				}
				document.getElementById('addedAsset').style.display = 'none';
			}
		}
	};
	xhttp.open('POST', '/insertAsset');
	xhttp.setRequestHeader('X-CSRF-TOKEN', metaTag.getAttribute('content'));
	xhttp.send(data);
}



let assetTable = document.getElementsByClassName('assetTable')[0];
assetTable.addEventListener('click', isDeleteButton);

function isDeleteButton(e) {
	if (e.target != e.currentTarget) {
		if (e.target.value == 'Delete') {
			submitAssetDelete(e.target.parentNode);
		}
	}
}

function packageAssetDeleteData(rowElement) {
	let formData = new FormData();
	formData.append('description', rowElement.children[0].innerHTML.trim());
	formData.append('model', rowElement.children[1].innerHTML.trim());
	return formData;
}

function submitAssetDelete(assetRow) {
	let metaTag = document.getElementsByTagName('meta')[1];
	let data = packageAssetDeleteData(assetRow);
	data.append('companyID', companyID.value);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			let response = JSON.parse(this.responseText);
			let row = document.getElementById(parseInt(response.id));
			row.parentNode.removeChild(row);
		}
	};
	xhttp.open('POST', '/deleteAsset');
	xhttp.setRequestHeader('X-CSRF-TOKEN', metaTag.getAttribute('content'));
	xhttp.send(data);
}

function assignRows(dataRows) {
	let table = document.getElementsByClassName('tableBody')[0];
	table.innerHTML = '';
	let arrayEnd = (dataRows.length > 10) ? 10 : dataRows.length;
	
	for (let i = 0; i < arrayEnd; i++) {
		if (i == 0) {
			firstID = dataRows[i].id;
		} else if (i == (arrayEnd - 1)) {
			lastID = dataRows[i].id;
		}
		let row = document.createElement('tr');
		let rowID = document.createAttribute('id');
		rowID.value = dataRows[i].id;
		row.setAttributeNode(rowID);
		
		let col1 = document.createElement('td');
		let col2 = document.createElement('td');
		let col3 = document.createElement('td');
		
		let val1 = document.createTextNode(dataRows[i].description);
		let val2 = document.createTextNode(dataRows[i].model);
		let val3 = document.createTextNode('R' + dataRows[i].value);
		
		col1.appendChild(val1);
		col2.appendChild(val2);
		col3.appendChild(val3);
		
		let deleteButton = document.createElement('input');
		let att1 = document.createAttribute('type');
		att1.value = 'button';
		let att2 = document.createAttribute('class');
		att2.value = 'deleteButton';
		let att3 = document.createAttribute('value');
		att3.value = 'Delete';
		deleteButton.setAttributeNode(att1);
		deleteButton.setAttributeNode(att2);
		deleteButton.setAttributeNode(att3);
		
		row.append(col1);
		row.append(col2);
		row.append(col3);
		row.append(deleteButton);
		
		table.append(row);
	}
}

GetNextRows('assets', true, document.getElementsByTagName('meta')[1], companyID.value, 0);


document.getElementById('left').addEventListener('click', function() {
	let metaTag = document.getElementsByTagName('meta')[1];
	let rows = GetNextRows('assets', false, metaTag, companyID.value, firstID);
});

document.getElementById('right').addEventListener('click', function() {
	let metaTag = document.getElementsByTagName('meta')[1];
	let table = document.getElementsByClassName('tableBody')[0];
	if (table.children.length < 10) {
		GetNextRows('assets', true, metaTag, companyID.value, firstID);
	} else {
		GetNextRows('assets', true, metaTag, companyID.value, lastID);
	}
});