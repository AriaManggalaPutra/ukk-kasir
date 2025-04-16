<div class="mt-2">
    <img id="imagePreview" 
         src="https://via.placeholder.com/100" {{-- src="{{ $product->product_image ? asset('storage/' . $product->product_image) : 'https://via.placeholder.com/100' }}"  --}}
         width="100" height="100" 
         class="rounded-lg border" 
         style="object-fit: cover; display: none;">
</div>

<script>
     function previewImage(event) {
        const image = document.getElementById('imagePreview');
        const file = event.target.files[0];
    
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                image.style.display = 'block';
            };
        reader.readAsDataURL(file);
            }
        }
</script>