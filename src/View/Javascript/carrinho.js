//estilização da quantidade
document.addEventListener("click", e => {
  if (!e.target.matches(".mais, .menos")) return;
  e.preventDefault();

  const input = e.target.closest(".quantidade").querySelector(".QTDE");
  let valor = +input.value;

  if (e.target.classList.contains("mais")) valor++;
  else if (valor > 1) valor--;

  input.value = valor;
});
