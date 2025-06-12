<!-- candidate_form.php (partial only, no <html><head><body>) -->
<div id="candidateFormModal" class="modal" style="display: none;">
  <div class="modal-content large-form">
    <span class="close" onclick="closeCandidateForm()">&times;</span>
    <h2>New Candidate</h2>

    <form id="candidateForm" enctype="multipart/form-data">
      <!-- ...isi form seperti sebelumnya... -->
       <form id="candidateForm" enctype="multipart/form-data">
      <div class="form-group">
        <label>Position</label>
        <select name="position" required>
          <option value="">Please select</option>
          <?php
          // Load posisi dari database (contoh statis)
          $positions = ["Frontend Developer", "Backend Developer", "UI/UX Designer"];
          foreach ($positions as $pos) {
            echo "<option value=\"$pos\">$pos</option>";
          }
          ?>
        </select>
      </div>

      <div class="form-row">
        <input type="text" name="first_name" placeholder="First Name" required />
        <input type="text" name="middle_name" placeholder="Middle Name" />
        <input type="text" name="last_name" placeholder="Last Name" required />
      </div>

      <div class="form-row">
        <select name="gender">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
        <input type="email" name="email" placeholder="Email" required />
        <input type="text" name="contact" placeholder="Contact Number" required />
      </div>

      <div class="form-group">
        <textarea name="address" placeholder="Address" required></textarea>
      </div>

      <div class="form-group">
        <textarea name="cover_letter" placeholder="Cover Letter (Optional)"></textarea>
      </div>

      <div class="form-group">
        <label>Resume</label>
        <input type="file" name="resume" required />
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" onclick="closeCandidateForm()" class="btn btn-secondary">Cancel</button>
      </div>
    </form>


    </form>
  </div>
</div>






    