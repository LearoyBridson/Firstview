
let left = document.getElementById('left');
let right = document.getElementById('right');
left.style.display = 'none';
right.style.display = 'none';

let firstID = 0;
let lastID = 0;


function GetNextRows(table, toRight, metaTag, ID, lastRowID) {
	let direction = (toRight) ? 'r' : 'l';
	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			let response = JSON.parse(this.responseText);
			
			if (response[0] != undefined) {
				if (toRight) {
					if (response.length > 10) {
						if (right.style.display == 'none') {
							right.style.display = 'block';
						}
					} else {
						if (right.style.display == 'block') {
							right.style.display = 'none';
						}
					}
					if (lastRowID > 0 && left.style.display == 'none') {
						left.style.display = 'block';
					}
				} else {
					if (response.length > 10) {
						if (left.style.display == 'none') {
							left.style.display = 'block';
						}
					} else {
						if (left.style.display == 'block') {
							left.style.display = 'none';
						}
					}
					if (right.style.display == 'none') {
						right.style.display = 'block';
					}
				}
				assignRows(response);
			} else {
				if (toRight) {
					right.style.display = 'none';
				} else {
					left.style.display = 'none';
				}
			}
		}
	};
	xhttp.open('GET', '/table/' + table + '/direction/' + direction + '/ID/' + ID + '/lastRowID/' + lastRowID);
	xhttp.setRequestHeader('X-CSRF-TOKEN', metaTag.getAttribute('content'));
	xhttp.send();
}