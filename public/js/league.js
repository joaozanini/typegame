  const selectBox = document.getElementById("custom-select");
  const selected = selectBox.querySelector(".select-selected");
  const selectedText = selectBox.querySelector(".selected-text");
  const options = selectBox.querySelector(".select-items");
  const hiddenInput = document.getElementById("grupoSelecionado");
  const form = document.getElementById("groupForm");


  selected.addEventListener("click", () => {
    options.classList.toggle("select-hide");
    selectBox.classList.toggle("active");
  });


  options.querySelectorAll("div").forEach(option => {
    option.addEventListener("click", () => {
      const value = option.dataset.value;
      selectedText.textContent = option.textContent;
      hiddenInput.value = value;

      options.classList.add("select-hide");
      selectBox.classList.remove("active");

      form.submit();
    });
  });

  document.addEventListener("click", (e) => {
    if (!selectBox.contains(e.target)) {
      options.classList.add("select-hide");
      selectBox.classList.remove("active");
    }
  });

document.querySelectorAll("th.sort").forEach(header => {
  let ascending = true;

  header.addEventListener("click", () => {
    const table = header.closest("table");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    const index = Array.from(header.parentNode.children).indexOf(header);

    const isNumericColumn = !isNaN(rows[0].children[index].textContent.trim());

    rows.sort((a, b) => {
      let aText = a.children[index].textContent.trim();
      let bText = b.children[index].textContent.trim();

      if (isNumericColumn) {
        aText = parseFloat(aText);
        bText = parseFloat(bText);
      }

      return ascending ? aText - bText : bText - aText;
    });

    rows.forEach(row => tbody.appendChild(row));

    document.querySelectorAll("th.sort .ordem").forEach(span => {
      span.innerHTML = "&#9662;";
    });

    const arrowSpan = header.querySelector(".ordem");
    arrowSpan.innerHTML = ascending ? "&#9652;" : "&#9662;";

    ascending = !ascending;
  });
});