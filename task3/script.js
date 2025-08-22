// Example: confirmation before form submission
document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll("form");
  forms.forEach(form => {
    form.addEventListener("submit", function (e) {
      if (!confirm("Are you sure you want to submit this form?")) {
        e.preventDefault();
      }
    });
  });
});
