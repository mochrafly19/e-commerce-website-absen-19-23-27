$(document).ready(function(){
    // Ketika opsi kategori dipilih
    $('select[name="search"]').change(function(){
      // Ambil nilai kategori yang dipilih
      var selectedCategory = $(this).val();
      
      // Perbarui nilai input pencarian dengan kategori yang dipilih
      $('input[name="search"]').val(selectedCategory);
      
      // Submit formulir pencarian secara otomatis
      $('#search-form').submit();
    });
  });

  $(document).ready(function(){
    $('#search-icon').click(function(){
      // Submit formulir pencarian secara otomatis
      $('#search-form').submit();
    });
  });


  $(document).ready(function(){
    // Tambahkan event listener ke setiap kategori di dalam carousel
    $('.category-item').click(function(e){
      // Dapatkan URL dari kategori yang diklik
      var categoryUrl = $(this).attr('href');
      
      // Lakukan navigasi ke halaman kategori yang sesuai
      window.location.href = categoryUrl;
      
      // Menghentikan default behavior dari link
      e.preventDefault();
    });
  });

  document.getElementById("user-menu-toggle").addEventListener("click", function() {
    var userMenu = document.getElementById("user-menu");
    if (userMenu.style.display === "none") {
        userMenu.style.display = "block";
    } else {
        userMenu.style.display = "none";
    }
});
