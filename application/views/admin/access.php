<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800"><?= $title . $roles['role']; ?></h1>


  <div class="row">
    <div class="col-lg-4">
      <?= $this->session->flashdata('message'); ?>
      <table class="table table-hover table-light">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Role</th>
            <th scope="col"><i class="fas fa-lock-open"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($menus as $menu) : ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $menu['menu']; ?></td>
              <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" <?= check_access($roles['id'], $menu['id']); ?> data-role="<?= $roles['id']; ?>" data-menu="<?= $menu['id']; ?>">
                </div>
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