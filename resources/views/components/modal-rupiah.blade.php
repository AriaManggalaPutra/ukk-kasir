<script>
     function formatRupiah(input) {
            let angka = input.value.replace(/[^,\d]/g, '').toString();
            let split = angka.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
    
            input.value = rupiah ? 'Rp ' + rupiah : '';
        }

        function cleanPriceBeforeSubmit() {
    let priceInput = document.getElementById("price");
    priceInput.value = priceInput.value.replace(/[^\d]/g, '');
}

function previewImage(event) {
        const image = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
        
</script>