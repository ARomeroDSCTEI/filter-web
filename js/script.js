var extCode = null;
var minifiz = false;

(function ( window, document){

	getId( "fs-fw" ).addEventListener("click", showBind, false);
	getId( "fs-option" ).addEventListener("click", showOpc, false);
	getId( "fs-msopc" ).addEventListener("click", showOpcMs, false);
	getId( "fs-str" ).addEventListener("keyup", function ( e ) {
		if ( e.keyCode == 13 ) {
			submitUrl();
		}
	}, false);

})( window, document);

function getId ( id ) {
	return document.getElementById( id );
}

function showBind () {
	if ( getId( "cj-1" ).style.display == "block" ) {
		getId( "fs-option" ).src = "img/square.png";
		getId( "cj-1" ).style.display = "none";
		getId( "cj-2" ).style.display = "none";
	} else if ( getId( "fs-str" ).style.display != "block" ) {
		getId( "fs-str" ).style.display = "block";
		getId( "fs-option" ).style.display = "block";
		getId( "fs-fw" ).style.opacity = "1";
		getId( "fs-fw" ).style.background  = "#EC6060";
	} else {
		getId( "fs-str" ).style.display = "none";
		getId( "fs-option" ).style.display = "none";
		getId( "fs-fw" ).style.opacity = "0.6";
		getId( "fs-fw" ).style.background  = "#A3F3F3";
	}
}

function showOpc () {
	if ( getId( "cj-1" ).style.display != "block" ) {
		getId( "cj-1" ).style.display = "block";
		getId( "fs-str" ).style.display = "none";
		getId( "fs-option" ).src = "img/interface.png";
	} else {
		getId( "cj-1" ).style.display = "none";
		getId( "cj-2" ).style.display = "none";
		getId( "fs-str" ).style.display = "block";
		getId( "fs-option" ).src = "img/square.png";
	}
}

function showOpcMs () {
	if ( getId( "cj-2" ).style.display != "block" ) {
		getId( "cj-2" ).style.display = "block";
	} else {
		getId( "cj-2" ).style.display = "none";
	}
}

function loadDoc () {
	var xhttp = false;
	if ( window.XMLHttpRequest ) {
    	// code for modern browsers
		xhttp = new XMLHttpRequest();
	} else {
    	// code for IE6, IE5
    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xhttp;
}

function submitUrl () {
	var ajax = false;
	var prm = null;

	prm = "url=" + getId( "fs-str" ).value.trim() + "&excluir=" + extCode + "&minifiz=" + minifiz;

	alert( prm );
/*
	ajax = loadDoc ();

	ajax.onreadystatechange = function () {
		if ( ajax.readyState == 4 && ajax.status == 200 ) {
			getId( "view_recurso" ).innerHTML = ajax.responseText;
		}
	}

	ajax.open( "GET", "php/filter_web.php", true );
	ajax.send();
*/
}
