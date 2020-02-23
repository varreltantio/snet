$(document).ready(function () {
  $('.delete').on('click', function (e) {
    e.preventDefault();

    const href = $(this).attr('href');

    Swal.fire({
      title: 'Are you sure',
      text: "to deleted this menu?",
      type: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#3085d6',
      confirmButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        document.location.href = href;
      }
    });
  });

  $('.delete-submenu').on('click', function (e) {
    e.preventDefault();

    const href = $(this).attr('href');

    Swal.fire({
      title: 'Are you sure',
      text: "to deleted this submenu?",
      type: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#3085d6',
      confirmButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        document.location.href = href;
      }
    });
  });

  $('.delete-item').on('click', function (e) {
    e.preventDefault();

    const href = $(this).attr('href');

    Swal.fire({
      title: 'Are you sure',
      text: "to deleted this item?",
      type: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#3085d6',
      confirmButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        document.location.href = href;
      }
    });
  });

  $('.custom-file-input').on('change', function () {
    const fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });

  $('.form-check-input').on('click', function () {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "http://localhost/snet/admin/changeaccess/",
      type: 'post',
      data: {
        menuId: menuId,
        roleId: roleId
      },
      success: function () {
        document.location.href = "http://localhost/snet/admin/access/" + roleId;
      }
    });
  });
});