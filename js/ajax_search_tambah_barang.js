// ambil elemen HTML
var keyword = document.getElementById('keyword');
var hasil = document.getElementById('hasil');


keyword.addEventListener('keyup', function () {
	
	//instansiasi Ajax
	var xhr = new XMLHttpRequest();

	// cek kesiapan ajax
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			hasil.innerHTML = xhr.responseText;
		}
	}

// ekesekusai ajax
xhr.open('GET', 'ajax/hasil_tambah_barang.php?keyword=' + keyword.value, true);
xhr.send();

});

