var tglAwal 		= document.getElementById('awal');
var tglAkhir 		= document.getElementById('akhir');
var minimumSupport 	= document.getElementById('minimumSupport');
var hasil 			= document.getElementById('relativeSupport');


minimumSupport.addEventListener('keyup', function () {
	
	
	var xhr = new XMLHttpRequest();

	
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			hasil.innerHTML = xhr.responseText;
		}
	}

xhr.open('GET', 'metode/hasil_supportRelative.php?tglAwal='+tglAwal.value+'&tglAkhir='+tglAkhir.value+'&minimumSupport='+minimumSupport.value, true);
xhr.send();

});

