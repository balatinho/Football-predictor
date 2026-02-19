document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("predictionForm");
  const home = document.getElementById("home_team");
  const away = document.getElementById("away_team");
  const error = document.getElementById("teamError");

  function showError(msg) {
    error.textContent = msg;
    error.style.display = "block";
  }

  function clearError() {
    error.textContent = "";
    error.style.display = "none";
  }

  function validateTeams() {
    if (home.value && away.value && home.value === away.value) {
      showError("Home and Away teams must be different.");
      return false;
    }
    clearError();
    return true;
  }

  home.addEventListener("change", validateTeams);
  away.addEventListener("change", validateTeams);

  form.addEventListener("submit", (e) => {
    if (!validateTeams()) {
      e.preventDefault();
    }
  });

  form.addEventListener("reset", () => {
    setTimeout(() => {
      clearError();
    }, 0);
  });
});
