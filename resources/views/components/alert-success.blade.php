@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Menghilangkan alert setelah 3 detik
        let successAlert = document.getElementById("success-alert");
        if (successAlert) {
            setTimeout(() => {
                let fadeEffect = setInterval(() => {
                    if (!successAlert.style.opacity) {
                        successAlert.style.opacity = "1";
                    }
                    if (successAlert.style.opacity > "0") {
                        successAlert.style.opacity -= "0.1";
                    } else {
                        clearInterval(fadeEffect);
                        successAlert.remove();
                    }
                }, 50);
            }, 3000);
        }
    });
    </script>