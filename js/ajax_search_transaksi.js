// Produk 
var keyword = document.getElementById('keyword_cari_produk');
var hasil = document.getElementById('cari_produk');


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
xhr.open('GET', 'ajax/hasil_cari_produk_transaksi.php?keyword=' + keyword.value, true);
xhr.send();

});




// Transaksi
var keyword2 = document.getElementById('keyword_cari_transaksi');
var hasil2 = document.getElementById('cari_transaksi');


keyword2.addEventListener('keyup', function () {
	
	//instansiasi Ajax
	var xhr = new XMLHttpRequest();

	// cek kesiapan ajax
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			hasil2.innerHTML = xhr.responseText;
		}
	}

// ekesekusai ajax
xhr.open('GET', 'ajax/hasil_cari_transaksi.php?keyword=' + keyword2.value, true);
xhr.send();

});

