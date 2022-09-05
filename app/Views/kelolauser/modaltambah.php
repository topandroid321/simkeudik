  <!-- Modal -->
  <div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modaltitle">Tambah Data User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body form">
                  <form id="formData">
                      <?= csrf_field(); ?>
                      <div class="form-group">
                          <label for="nama_lengkap">Nama Lengkap</label>
                          <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukan Nama Lengkap">
                          <div class="invalid-feedback errornama"></div>
                      </div>

                      <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" name="username" id="username" placeholder="Masukan Username">
                          <div class="invalid-feedback errorusername"></div>

                      </div>

                      <div class="form-group">
                          <label for="nama_lengkap">Role</label>
                          <select class="form-control" name="role" id="role">
                              <option value="1">Admin</option>
                              <option value="2">Bendahara</option>
                              <option value="3">Kepala Program</option>
                          </select>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button id="btnsave" type="button" class="btn btn-primary" onclick="save()">Save changes</button>
              </div>
              </form>
          </div>
      </div>
  </div>