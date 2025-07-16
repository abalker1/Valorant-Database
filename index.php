<!DOCTYPE html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<title>Valorant Agents</title>
</head>
<body>

	<div id = "nav" style="z-index:1000;">
	<button type="button" onclick="selection();">Display All</button>
	<button type = "button" onclick = "prev()">Previous</button>
	<button type = "button" onclick ="next()">Next</button>
	<button type = "button" onclick = "toggleEdit()">Edit</button>
	<button type = "button" onclick = "insert()">Insert</button>
	<button type = "button" onclick = "deleteAgent()">Delete</button>
	<button type = "button" onclick = "save()">Save</button>
	<select id = "roleSortingSelectBox" onchange="sortByRole(this.value)">
			<option value="StartRoleSelection">Sort by Role</option>
			<option value = "Duelist">Duelist</option>
			<option value = "Initiator">Initiator</option>
			<option value = "Sentinel">Sentinel</option>
			<option value = "Controller">Controller</option>
		</select>
	<button type = "button" onclick = "sortByName()" id = "nameSorting">Sort by Name</button>
	<br>
	<button type="button" style="display:none;" id = "insertButton">Submit New Agent</button>
	<br><br>
	</div>
	
<div id = "displayScreen">
	<p>Agent: <input type = "text" id = "agentNameInput" value = "" readonly></input></p>
	<p>Real Name: <input type = "text" id = "realNameInput" value = "" readonly></input></p>
	<p>Gender: <input type = "text" id = "genderInput" value = "" readonly></input></p>
	<p>Age: <input type = "text" id = "ageInput" value = "" readonly></input></p>
	<p>Role: <input type = "text" id = "roleInput" value = "" readonly></input></p>
	<img id="img" src="" alt="Agent Image" style="display: none;"><br>
	
	<div id = "uploadSection" style="display:none">
	<form enctype="multipart/form-data" id = "agentForm">
		<input type = "file" id="imgUpload" accept="image/*">
		<button type = "button" onclick = "submitImage()">Submit Image</button>
		</form>
	</div>
	
	<div id = "Counter">
	<span id = "position"></span>/<span id = "length"></span>
	</div>
		<button type = "button" onclick = "navToFirst()" id = "firstButton">First Agent</button>
	<button type = "button" onclick = "navToLast()" id = "lastButton">Last Agent</button>
	<br>
</div>
<script>
let index = 1;
let newIndex = 0;
let indexMax;
var mydata = [];
var newId;
let displayAll = true;

let agentNameElement = document.getElementById("agentNameInput");
let realNameElement = document.getElementById("realNameInput");
let genderElement = document.getElementById("genderInput");
let ageElement = document.getElementById("ageInput");
let roleElement = document.getElementById("roleInput");
let imgElement = document.getElementById("img");
let imgUploadElement = document.getElementById("imgUpload");
let uploadSection = document.getElementById("uploadSection");
let sortingNameElement = document.getElementById("nameSorting");

let positionElement = document.getElementById("position");
let lengthElement = document.getElementById("length");

let roleInputElement = document.getElementById("roleInput");
let SortByRoleElement = document.getElementById("StartRoleSelection");

var requestURL = "getAgent.php?index="+index;
httpRequest = new XMLHttpRequest();
httpRequest.open('GET', requestURL);

httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState == 4) {
                if (httpRequest.status == 200) {
                    if (httpRequest.responseText.trim() !== "") {
                        mydata = JSON.parse(httpRequest.responseText);
                        getMaxIndex();
               
                    } else {
                        console.log("No agents found.");
                    }
                } else {
                    console.error("Error:", httpRequest.status, httpRequest.statusText);
                }
            }
        };

httpRequest.send();



function parseData() {
    try {
        if (httpRequest2.readyState === XMLHttpRequest.DONE) {
            if (httpRequest2.status === 200) {
                if (httpRequest2.responseText.trim() !== "") {
                    mydata = JSON.parse(httpRequest2.responseText);
                    loadElements();
                } else {
                    console.log("No agents found.");
                }
            } else {
                console.error("Error:", httpRequest2.status, httpRequest2.statusText);
            }
        }
    } catch (e) {
        alert('Caught Exceptionparse: ' + e.description);
    }
}


function loadElements() {
if (displayAll) {
	agentNameElement.value=mydata[0] || '';
	realNameElement.value=mydata[1] || '';
	genderElement.value = mydata[2] === 'Male' ? 'Female' : 'Male';
	ageElement.value=mydata[3] || '';
	roleElement.value=mydata[4] || '';
	imgElement.src = mydata[5] !== undefined ? mydata[5] : 'Logo.png';
    imgElement.style.display = "block";
	
	positionElement.innerHTML = index;
	lengthElement.innerHTML = indexMax-1;
	
} else {
	agentNameElement.value = newData[newIndex][0];
	realNameElement.value=newData[newIndex][1] || '';
	genderElement.value = newData[newIndex][2] === 'Male' ? 'Female' : 'Male';
	ageElement.value=newData[newIndex][3] || '';
	roleElement.value=newData[newIndex][4] || '';
	imgElement.src = newData[newIndex][5] !== undefined ? newData[newIndex][5] : 'Logo.png';
    imgElement.style.display = "block";
	
	positionElement.innerHTML = newIndex+1;
	lengthElement.innerHTML = newData.length;
}
}

function selection() {
if(displayAll) {
 httpRequest2 = new XMLHttpRequest();
    if (!httpRequest2) { 
      alert('Cannot create an XMLHTTP instance');
      return false;
    }
    httpRequest2.onreadystatechange = function() {
		parseData();
	};
	httpRequest2.open('POST', 'getAgent.php');
    httpRequest2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest2.send('index=' + index);
	
}
else {
	loadElements();
	}
}

function getMaxIndex(callback) {
    let httpRequestMaxIndex = new XMLHttpRequest();
    httpRequestMaxIndex.onreadystatechange = function () {
        if (httpRequestMaxIndex.readyState == 4 && httpRequestMaxIndex.status == 200) {
            // Parse the response and assign it to maxIndex
            maxIndex = parseInt(httpRequestMaxIndex.responseText);
            
            if (callback && typeof callback === 'function') {
                callback(maxIndex);
            }
        }
    };
    httpRequestMaxIndex.open('POST', 'getLength.php');
    httpRequestMaxIndex.send();
}

getMaxIndex(function (maxIndex) {
    // Now you can use maxIndex
    indexMax = maxIndex+1;
    selection();
});

function next() {
    if (displayAll) {
        if (index < indexMax - 1) {
            index = index + 1;
        } else {
            index = 1;
        }
    } else {
        if (newIndex < newData.length - 1) {
            newIndex++;
        } else {
            newIndex = 0;
        }
    }

    selection();
}

function prev() {
    if (displayAll) {
        if (index == 1) {
            index = indexMax - 1;
        } else {
            index = index - 1;
        }
    } else {
        if (newIndex === 0) {
            newIndex = newData.length - 1;
        } else {
            newIndex--;
        }
    }

    selection();
}



function deleteAgent() {
	deleteRequest();
	index--;
	getMaxIndex();
	}
	
var httpRequest4;
function deleteRequest(){
	httpRequest4 = new XMLHttpRequest();
	if (!httpRequest4) { 
	 
      alert('Cannot create an XMLHTTP instance');
      return false;
    }
	httpRequest4.onreadystatechange = deleteCallBack;
	httpRequest4.open('POST', 'deleteAgent.php');
	httpRequest4.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest4.send('index=' + encodeURIComponent(index));
	console.log("Deleted!");
}

function deleteCallBack() {
	try {
        if (httpRequest4.readyState === XMLHttpRequest.DONE) {
          if (httpRequest4.status === 200) {      
              indexMax = indexMax-1;
                 selection();
                console.log(httpRequest4.responseText);
}
			else {
				alert('There was a problem with the request.');
          }
        }
      }
      catch( e ) {
        alert('Caught ExceptionDel: ' + e.description);
      }

    
}

function insert() {
	let insertButtonElement = document.getElementById("insertButton");
	insertButtonElement.style.display = "block";
	index = indexMax++;
	newId = index;
	selection();
	uploadSection.style.display = "block";
	toggleEdit();
	insertButtonElement.onclick = function () {
        collectText(index);
        insertRequest();
        insertButtonElement.style.display = "none";
    };
}



function collectText(index) {
	newAgentName = agentNameElement.value;
    newRealName = realNameElement.value;
    newGender = genderElement.value;
    newAge = ageElement.value;
    newRole = roleElement.value;
    newImg = imgElement.src;

}

var httpRequest3;
function insertRequest(newId) {
	httpRequest3 = new XMLHttpRequest();
	httpRequest3.onreadystatechange = function () {
        insertCallBack(newId);
    };
	
	httpRequest3.open('POST', 'insert.php');
	httpRequest3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest3.send('newAgentName=' + encodeURIComponent(newAgentName) +
                '&newRealName=' + encodeURIComponent(newRealName) +
                '&newGender=' + encodeURIComponent(newGender) +
                '&newAge=' + encodeURIComponent(newAge) +
                '&newRole=' + encodeURIComponent(newRole) +
                '&newImg=' + encodeURIComponent(newImg) +
                '&id=' + newId); 
    console.log("insert");
}

function insertCallBack(newId) {
    try {
        if (httpRequest3.readyState === XMLHttpRequest.DONE) {
            if (httpRequest3.status === 200) {
                // Update mydata array with the new agent information
                mydata[index] = {
					'id':newId,
                    'agentName': newAgentName,
                    'realName': newRealName,
                    'gender': newGender,
                    'age': newAge,
                    'role': newRole,
                    'img': newImg
                };

                alert(httpRequest3.responseText);
            } else {
                alert('There was a problem with the request.');
            }
        }
    } catch (e) {
        alert('Caught Exception: ' + e.description);
    }
}

function submitImage() {
	
    const fileInput = imgUploadElement;
    const file = fileInput.files[0];
    const formData = new FormData();

	if (!file) {
    alert('No file selected');
    return;
}
	console.log('File Input:', fileInput);
    console.log('Selected File:', file);


    formData.append('imgUpload', file);

	console.log('form data: ', formData);

    fetch('uploadImage.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
		console.log("Upload response: ", data);
        if (data.success) {
            // Update the image source on success
            imgElement.src = data.filePath;
            imgElement.style.display = "block";
            uploadSection.style.display = "none";
        } else {
            alert('Error uploading file');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


var updateHttpRequest;
function updateRequest(index) {
	
	let agentName = agentNameElement.value;
    let realName = realNameElement.value;
    let gender = genderElement.value;
    let age = ageElement.value;
    let role = roleElement.value;
	
	updateHttpRequest = new XMLHttpRequest();
	updateHttpRequest.onreadystatechange = function () {
        updateCallBack(index);
    };
	
	updateHttpRequest.open('POST', 'updateAgent.php');
	updateHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    updateHttpRequest.send('agentName=' + encodeURIComponent(agentName) +
                '&realName=' + encodeURIComponent(realName) +
                '&gender=' + encodeURIComponent(gender) +
                '&age=' + encodeURIComponent(age) +
                '&role=' + encodeURIComponent(role) +
                '&id=' + index);
	
    console.log("Updated!");
}

function updateCallBack(index) {
    try {
        if (updateHttpRequest.readyState === XMLHttpRequest.DONE) {
            if (updateHttpRequest.status === 200) {
                // Update mydata array with the new agent information
                mydata[index] = {
					'id':index,
                    'agentName': agentName,
                    'realName': realName,
                    'gender': gender,
                    'age': age,
                    'role': role
                };
				loadElements();
                alert(updateHttpRequest.responseText);
            } else {
                alert('There was a problem with the request.');
            }
        }
    } catch (e) {
		console.error('Caught Exception:', e);
    }
}

function save(){
	updateRequest(index);
	toggleEdit();
	refreshPage();
}


var saverequest;
function saveAll() {
	saverequest = new XMLHttpRequest();	
	saverequest.onreadystatechange = alertContents;
	saverequest.open('GET', 'savefile.php');
	saverequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	saverequest.send('mynewdata=' + encodeURIComponent(JSON.stringify(mydata)));
}

function alertContents() {
  try {
    if (saverequest.readyState === XMLHttpRequest.DONE) {
      if (saverequest.status === 200) {
			alert('Saved file');
	  } else {
        alert('There was a problem with the request.');
      }
    }
  }
  catch( e ) {
    alert('Caught Exception: ' + e.description);
  }
}

let isEditable = true;
function toggleEdit() {
	isEditable = !isEditable;
	agentNameInput.readOnly = isEditable;
	realNameInput.readOnly = isEditable;
	genderInput.readOnly = isEditable;
	ageInput.readOnly = isEditable;
	roleInput.readOnly = isEditable;
}


let newData = [];
let newOriginalData = [];
var httpRequestAllAgents = new XMLHttpRequest();
httpRequestAllAgents.onreadystatechange = function () {
    if (httpRequestAllAgents.readyState == 4 && httpRequestAllAgents.status == 200) {
        newData = JSON.parse(httpRequestAllAgents.responseText);
    }
};
httpRequestAllAgents.open('GET', 'getAllAgents.php');
httpRequestAllAgents.send();

function refreshPage() {
	location.reload();
}

function sortByName() {
	
	newData.sort((a,b) => a[0].localeCompare(b[0]));
	newOriginalData = newData;
	displayAll = !displayAll;
	if(displayAll == false) {
		sortingNameElement.textContent = "Revert";
		//newIndex=0;
		sortingNameElement.addEventListener("click", function() {
			refreshPage();
		});
	}
	else {
		sortingNameElement.textContent = "Sort by Name";
		index=1;
	}
	loadElements();
	
}

let duelistRef = "Duelist";
let initatorRef = "Initiator";
let sentinelRef = "Sentinel";
let controllerRef = "Controller";

let duelData;




function sortByRole(selectedValue) {
	if (selectedValue.toLowerCase() == duelistRef.toLowerCase()) {
		duelData = newData.filter(function(agent) {
			return agent[4].toLowerCase() === 'Duelist'.toLowerCase();
		});
		if (duelData == 0) {
			alert("No agents of that category!");
		}
		newData = duelData;
		displayAll = false;
		newIndex = 0;
		loadElements();
	}
	else if (selectedValue.toLowerCase() == initatorRef.toLowerCase()) {
		duelData = newData.filter(function(agent) {
			return agent[4].toLowerCase() === 'Initiator'.toLowerCase();
		});
		if (duelData == 0) {
			alert("No agents of that category!");
		}
		newData = duelData;
		displayAll = false;
		newIndex = 0;
		loadElements();
	}
	else if (selectedValue.toLowerCase() == sentinelRef.toLowerCase()) {
		duelData = newData.filter(function(agent) {
			return agent[4].toLowerCase() === 'Sentinel'.toLowerCase();
		});
		if (duelData == 0) {
			alert("No agents of that category!");
		}
		newData = duelData;
		displayAll = false;
		newIndex = 0;
		loadElements();
	}
	
	else if (selectedValue.toLowerCase() == controllerRef.toLowerCase()) {
		duelData = newData.filter(function(agent) {
			return agent[4].toLowerCase() === 'Controller'.toLowerCase();
		});
		if (duelData == 0) {
			alert("No agents of that category!");
		}
		newData = duelData;
		displayAll = false;
		newIndex = 0;
		loadElements();
	}
	else if(selectedValue.toLowerCase() === "startroleselection"){
		refreshPage();
	}
}

function navToFirst() {
	index = 1;
	newIndex = 0;
	selection();
}

function navToLast() {
	index = maxIndex;
	newIndex = maxIndex-1;
	selection();
}

</script>

<style>
 img {
	display:block;
	position:fixed;
	right:0px;
	top:auto;
	bottom:0px;
	width:auto;
	height:90%;
	max-width:50%;
	z-index:0;
}

input {
	font-size: 40px;
	font-weight:bold;
	size:400px;
	border:none;
	background-color:black;
	color:white;
	text-shadow: 3px 1px grey;
	background:transparent;
}

#displayScreen {
	position:relative;
	display:block;
	z-index:0;
	
}

input:hover {
	background-color:grey;
}

@font-face {
	font-family:Valorant;
	src: url(Valorant.ttf);
}

* {
	font-family:Valorant;
}

button, select{
	background-color:black;
	color:white;
	border:none;
	padding: 15px;
	font-size:20px;
}

button:hover, select:hover {
	background-color:grey;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); 
    z-index: -6;
}

body {
	background-image: url("mainBackground.png");
	background-size:cover;
	background-repeat: no-repeat;
	background-attachment:fixed;
	color:white;
	text-shadow: 3px 1px grey;
}


#uploadSection input {
	font-size:20px;
	width:400px;
}

#uploadSection button {
	font-size:20px;
	padding:5px;
	font-family:Valorant;
	border:none;
}

#Counter {
	font-size:40px;
}

img[src="Logo.png"] {
    width: 20%; 
	height:auto;
	top:0;
	right:0;
}

#nav {
	max-width:1100px;
	display:block;
	position:relative;
	z-index:500;
}

</style>

</body>
</html>