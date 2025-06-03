<!-- REVISED editStudentModal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editStudentForm" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="editStudentId" />

                <!-- Photo -->
                <div class="text-center mb-3">
                    <img id="editStudentPhotoPreview" src="" class="rounded-circle" width="100" height="100" style="object-fit: cover;" />
                    <div class="mt-2">
                        <input type="file" name="photo" id="editStudentPhoto" class="form-control form-control-sm" />
                    </div>
                </div>

                <div class="mb-2">
                    <label>First Name</label>
                    <input type="text" name="first_name" id="studentFirstName" class="form-control" required />
                </div>
                <div class="mb-2">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" id="studentMiddleName" class="form-control" />
                </div>
                <div class="mb-2">
                    <label>Last Name</label>
                    <input type="text" name="last_name" id="studentLastName" class="form-control" required />
                </div>
                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" id="studentEmail" class="form-control" required />
                </div>
                <div class="mb-2">
                    <label>Password (leave blank to keep current)</label>
                    <div class="input-group">
                        <input type="password" name="password" id="studentPassword" class="form-control" />
                        <span class="input-group-text toggle-password" onclick="togglePassword('studentPassword')">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">💾 Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Cancel</button>
            </div>
        </form>
    </div>
</div>