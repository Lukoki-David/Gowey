let slideIndex = 0;
showSlides();

function showSlides() {
  let slides = document.getElementsByClassName("carousel-slide");
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  slides[slideIndex-1].style.display = "block";  
  setTimeout(showSlides, 4000); // Avança automaticamente a cada 4 segundos
}

document.addEventListener("DOMContentLoaded", () => {
  const boxes = document.querySelectorAll(".feature-box");
  boxes.forEach((box, i) => {
    box.style.opacity = 0;
    setTimeout(() => {
      box.style.transition = "opacity 0.6s ease";
      box.style.opacity = 1;
    }, i * 200);
  });
});