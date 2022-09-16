function formatRupiah(angka, prefix) {
    
    isMinus = 0;
    if(angka < 0) {
        isMinus = 1;
        angka *= -1;
    }

    var number_string = angka.toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

    rupiah = isMinus == 1 ? '-' + rupiah : rupiah;

    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
