/**
	Returns the names of all the obj's
	 variables and functions in a sorted
	 array
*/
function getMembers(obj) {
	var members = new Array();
	var i = 0;

	for (var member in obj) {
		members[i] = member;
		i++;
	}

	return members.sort();
}

/**
	Print the names of all the obj's variables
	 and functions in an HTML element with id
*/
function printMembers(obj, id) {
	var members = getMembers(obj);
	var display = document.getElementById(id);

	for (var i = 0; i < members.length; i++) {
		var member = members[i];
		var value = obj[member];
		display.innerHTML += member + ' = ';
		display.innerHTML += value + '<br>';
	}
}

function inspect(obj){
	printMembers(obj,"logo")
}
