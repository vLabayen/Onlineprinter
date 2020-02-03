function postForm(form_id, endpoint){
	let loadingGif = document.getElementById("scanning");
	let scanButton = document.getElementById("scan");
	loadingGif.style.visibility = "visible";
	scanButton.disabled = true;

	fetch(endpoint, {
		method: 'POST',
		body: new FormData(document.getElementById(form_id))
	})
	.then((response) => response.json())
	.then((data) => {
		console.log('Success:', data);
		loadingGif.style.visibility = "hidden";
		scanButton.disabled = false;
		if (data["success"]) addRow(data["newfile"], data["url"]);
	})
	.catch((error) => {
		console.error('Error:', error);
		loadingGif.style.visibility = "hidden";
		scanButton.disabled = false;
	});
}

function addRow(name, url){
	let el = document.getElementById("scan_table");
	let tables = el.getElementsByTagName("table");

	let table;
	if (tables.length == 0) table = createScanTable(el);
	else table = tables[0];

	createScanRow(table, name, url);
	document.getElementById("download").disabled = false;
}
function createScanTable(parent){
	let table = document.createElement("table");
	let header = document.createElement("tr");
	let name_h = document.createElement("th");
	let preview_h = document.createElement("th");
	let delete_h = document.createElement("th");

	name_h.innerHTML = "Nombre";
	preview_h.innerHTML = "Previsualizar";
	delete_h.innerHTML = "Eliminar";

	header.appendChild(name_h);
	header.appendChild(preview_h);
	header.appendChild(delete_h);
	table.appendChild(header);
	parent.appendChild(table);
	parent.appendChild(document.createElement("br"));

	return table;
}
function createScanRow(table, name, url){
	let row = document.createElement("tr");
	let name_c = document.createElement("td");
	let preview_c = document.createElement("td");
	let delete_c = document.createElement("td");

	let preview_b = document.createElement("button");
	let delete_b = document.createElement("button");

	name_c.innerHTML = name;
	preview_b.innerHTML = "Ver";
	preview_b.onclick = () => window.open(url);
	preview_b.style.background = "#00FFFF";
	delete_b.innerHTML = "Borrar";
	delete_b.onclick = () => {
		let form = new FormData();
		form.append("file", name);

		fetch("php/deleteScan.php", {
			method : 'POST',
			body : form
		})
		.then((response) => response.json())
		.then((data) => {
			console.log(data);
			if (data["success"]) {
				table.removeChild(row);
				if (table.getElementsByTagName("td").length == 0) {
					let parent = document.getElementById("scan_table");
					parent.removeChild(table);
					parent.removeChild(parent.getElementsByTagName("br")[0]);
					document.getElementById("download").disabled = true;
				}
			}
		})
		.catch((error) => {
			conosle.error('Error:', error);
		});
	};
	delete_b.style.background = "#FF0000";

	preview_c.appendChild(preview_b);
	delete_c.appendChild(delete_b);
	row.appendChild(name_c);
	row.appendChild(preview_c);
	row.appendChild(delete_c);
	table.appendChild(row);
}
