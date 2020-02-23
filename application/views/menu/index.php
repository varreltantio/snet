<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg-6">
      <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>') ?>
      <?= $this->session->flashdata('message'); ?>
      <a href="" class="btn btn-primary mb-3 add" data-toggle="modal" data-target="#addModal">Add New Menu</a>
      <table class="table table-hover table-light">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Menu</th>
            <th scope="col"><i class="fas fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($menus as $menu) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $menu['menu']; ?></td>
              <td>
                <a href="<?= base_url('menu/edit/') . $menu['id'] ?>" class="badge badge-success">Edit</a>
                <a href="<?= base_url('menu/delete/') . $menu['id'] ?>" class="badge badge-danger delete">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="menuModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?= base_url('menu') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Menu</button>
        </div>
      </form>
    </div>
  </div>
</div>