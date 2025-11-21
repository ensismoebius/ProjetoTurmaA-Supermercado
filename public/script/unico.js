//estilização da quantidade
document.addEventListener("click", e => {
  const input = e.target.closest(".quantidade")?.querySelector(".QTDE");
  if (!input) return;
  if (e.target.classList.contains("mais")) input.value++;
  if (e.target.classList.contains("menos") && input.value > 1) input.value--;
});
