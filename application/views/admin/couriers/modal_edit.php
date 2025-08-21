 <div class="modal-header">
     <h4 class="modal-title">Edit Courier</h4>
     <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
         <i data-feather="x"></i>
     </button>
 </div>

 <!-- Action akan diganti lewat JS -->
 <form action="<?= base_url('admin/couriers/edit/' . $courier->id) ?>" id="editCourierForm" method="POST">
     <div class="modal-body">
         <input type="hidden" name="id" id="edit_id">

         <div class="form-group form-floating">
             <input type="text" class="form-control" name="name" id="edit_name" placeholder=" " value="<?= set_value('name', $courier->name) ?>">
             <label for="edit_name">Courier Name</label>
         </div>

         <div class="form-group form-floating">
             <textarea class="form-control" name="description" id="edit_description" style="height: 100px; resize: none;"><?= $courier->description ?></textarea>
             <label for="edit_description">Description (Optional)</label>
         </div>

         <div class="form-group">
             <div class="input-group">
                 <label class="input-group-text" for="edit_status">Status</label>
                 <select class="form-select" id="edit_status" name="status">
                     <option value="1">Active</option>
                     <option value="0">Inactive</option>
                 </select>
             </div>
         </div>
     </div>

     <div class="modal-footer">
         <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-primary ms-1">Save Changes</button>
     </div>
 </form>