$(document).ready(function() {

  $(document).on('click', '.delete_class', function() {

    if (!confirm('確定刪除商品？')) {
        return false;
    }
  });
});
