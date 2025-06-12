// candidates.js

function openCandidateForm() {
  fetch('candidate_form.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('candidateFormWrapper').innerHTML = html;
      document.getElementById('candidateFormModal').style.display = 'flex';
    })
    .catch(err => console.error("Error loading candidate form:", err));
}

function closeCandidateForm() {
  const modal = document.getElementById('candidateFormModal');
  if (modal) {
    modal.style.display = 'none';
    modal.remove(); // bersihkan dari DOM
  }
}
// candidates.js
function addCandidateForm() {
  fetch('candidate_form.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('candidateFormWrapper').innerHTML = html;
      const modal = document.getElementById('candidateFormModal');
      if (modal) {
        modal.style.display = 'flex';
      }
    })
    .catch(err => console.error("Error loading candidate form:", err));
}

function addCandidateForm() {
  console.log("Trying to fetch candidate form...");
  fetch('candidates/candidate_form.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('candidateFormWrapper').innerHTML = html;
      const modal = document.getElementById('candidateFormModal');
      if (modal) {
        modal.style.display = 'flex';
      } else {
        console.warn("Modal not found in response!");
      }
    });
}

