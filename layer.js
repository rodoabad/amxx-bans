function ToggleLayer(obj) {
	if(document.all) {
	  if(document.all[obj].style.display == 'none') {
			document.all[obj].style.display = 'block';
		} else {
			document.all[obj].style.display = 'none';
		}
	} else{
		if(document.getElementById(obj).style.display == 'none') {
			document.getElementById(obj).style.display = 'table-row';
		} else {
			document.getElementById(obj).style.display = 'none';
		}
  }
}

function openURI() {
	var control = document.navigator.nav;
	if (control.options[control.selectedIndex].value != 'no-url') {
		location.href = control.options[control.selectedIndex].value;
	}
}
