<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


  <div class="row">
    <div class="col-lg">
      <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>

      <?= $this->session->flashdata('message'); ?>
      <a href="" class="btn btn-primary mb-3 add" data-toggle="modal" data-target="#addModal">Add New Sub Menu</a>
      <table class="table table-hover table-light">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Menu</th>
            <th scope="col">URL</th>
            <th scope="col">Icon</th>
            <th scope="col">Active</th>
            <th scope="col"><i class="fas fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($subMenus as $subMenu) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $subMenu['title']; ?></td>
              <td><?= $subMenu['menu']; ?></td>
              <td><?= $subMenu['url']; ?></td>
              <td><?= $subMenu['icon']; ?></td>
              <td><?= $subMenu['is_active']; ?></td>
              <td>
                <a href="<?= base_url('menu/editsubmenu/') . $subMenu['id'] ?>" class="badge badge-success">Edit</a>
                <a href="<?= base_url('menu/deletesubmenu/') . $subMenu['id'] ?>" class="badge badge-danger delete-submenu">Delete</a>
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
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="subMenuModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="subMenuModal">Add New SubMenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="<?= base_url('menu/submenu') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="SubMenu Title">
          </div>
          <div class="form-group">
            <select class="form-control" id="menu_id" name="menu_id">
              <option value="">-- Pilih Menu --</option>
              <?php foreach ($sbMenus as $sb) : ?>
                <option value="<?= $sb['id']; ?>"><?= $sb['menu']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="url" name="url" placeholder="SubMenu URL">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="icon" name="icon" placeholder="SubMenu Icon">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
              <label class="form-check-label" for="is_active">
                Active
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add SubMenu</button>
        </div>
      </form>
    </div>
  </div>
</div>