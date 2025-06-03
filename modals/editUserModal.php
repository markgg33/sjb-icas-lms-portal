<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editUserForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editUserId" />
        <div class="row">
          <div class="col-md-4">
            <label>First Name</label>
            <input type="text" name="first_name" id="editFirstName" class="form-control" required />
          </div>
          <div class="col-md-4">
            <label>Middle Name</label>
            <input type="text" name="middle_name" id="editMiddleName" class="form-control" />
          </div>
          <div class="col-md-4">
            <label>Last Name</label>
            <input type="text" name="last_name" id="editLastName" class="form-control" required />
          </div>
          <div class="col-md-6 mt-2">
            <label>Gender</label>
            <select name="gender" id="editGender" class="form-control" required>
              <option value="">Select gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="col-md-6 mt-2">
            <label>Email</label>
            <input type="email" name="email" id="editEmail" class="form-control" required />
          </div>
          <div class="col-md-6 mt-2">
            <label>Role</label>
            <select name="role" id="editRole" class="form-control" required>
              <option value="admin">Admin</option>
              <option value="faculty">Faculty</option>
            </select>
          </div>
          <div class="col-md-6 mt-2">
            <label>New Password (optional)</label>
            <div class="input-group">
              <input type="password" name="password" id="editPassword" class="form-control" />
              <span class="input-group-text toggle-password" onclick="togglePassword('editPassword')">
                <i class="fa fa-eye"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">💾 Save Changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Cancel</button>
      </div>
    </form>
  </div>
</div>
