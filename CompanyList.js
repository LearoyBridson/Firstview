let userID = document.getElementById('userID');
let table = document.getElementsByClassName('tableBody')[0];
table.addEventListener('click', isDeleteButton);

function isDeleteButton(e) {
	if (e.target != e.currentTarget) {
		if (e.target.value == 'Delete') {
			submitDelete(e.target.parentNode);
		}
	}
}

function packageDeleteData(rowElement) {
	let formData = new FormData();
	formData.append('companyID', rowElement.id);
	return formData;
}

function submitDelete(row) {
	let metaTag = document.getElementsByTagName('meta')[1];
	let data = packageDeleteData(row);
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			let response = JSON.parse(this.responseText);
			let row = document.getElementById(parseInt(response.id));
			row.parentNode.removeChild(row);
		}
	};
	xhttp.open('POST', '/deleteCompany');
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
		
		let prot = window.location.protocol;
		let host = window.location.hostname;
		let port = window.location.port;
		let address = '/company/' + dataRows[i].id;
		let a = document.createElement('a');
		let dest = document.createAttribute('href');
		dest.value = address;
		a.setAttributeNode(dest);
		
		let col1 = document.createElement('td');
		let col2 = document.createElement('td');
		let col3 = document.createElement('td');
		let col4 = document.createElement('td');
		
		a.append(document.createTextNode(dataRows[i].name));
		let val2 = document.createTextNode(dataRows[i].email);
		let val3 = document.createTextNode(dataRows[i].logo);
		let val4 = document.createTextNode(dataRows[i].website);
		
		col1.appendChild(a);
		col2.appendChild(val2);
		col3.appendChild(val3);
		col4.appendChild(val4);
		
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
		row.append(col4);
		row.append(deleteButton);
		
		table.append(row);
	}
}


GetNextRows('companies', true, document.getElementsByTagName('meta')[1], userID.value, 0);


document.getElementById('left').addEventListener('click', function() {
	let metaTag = document.getElementsByTagName('meta')[1];
	let rows = GetNextRows('companies', false, metaTag, userID.value, firstID);
});

document.getElementById('right').addEventListener('click', function() {
	let metaTag = document.getElementsByTagName('meta')[1];
	if (table.children.length < 10) {
		GetNextRows('companies', true, metaTag, userID.value, firstID);
	} else {
		GetNextRows('companies', true, metaTag, userID.value, lastID);
	}
});