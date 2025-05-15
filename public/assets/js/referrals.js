document.addEventListener("DOMContentLoaded", () => {
  const idValue = document.querySelector(".id-value");

  // Add hover effect
  idValue.addEventListener("mouseover", () => {
    idValue.style.transform = "scale(1.1)";
    idValue.style.transition = "transform 0.3s ease";
  });

  idValue.addEventListener("mouseout", () => {
    idValue.style.transform = "scale(1)";
  });

  // Add click effect
  idValue.addEventListener("click", () => {
    idValue.style.color = "#FF4081";
    setTimeout(() => {
      idValue.style.color = "#2196F3";
    }, 500);
  });
});
