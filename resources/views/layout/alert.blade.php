@if (Session::has('success'))
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
              title: "Berhasil!",
              text: "{{ Session::get('success') }}",
              icon: "success",
              position: "top-start",
              showConfirmButton: false,
              timer: 2500,
              timerProgressBar: true,
              toast: true,
              customClass: {
                  popup: 'animated fadeInRight'
              }
          });
      });
  </script>
@endif

@if (Session::has('failed'))
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
              title: "Oops...",
              text: "{{ Session::get('failed') }}",
              icon: "error",
              position: "top-start",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              toast: true,
              customClass: {
                  popup: 'animated fadeInRight'
              }
          });
      });
  </script>
@endif