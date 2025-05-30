document.addEventListener("DOMContentLoaded", function () {
  // Filtrage AJAX par catégorie
  document.querySelectorAll(".btn-filtre").forEach((btn) => {
    btn.addEventListener("click", function () {
      const catId = this.dataset.id;

      fetch("index.php?page=filtrer", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "categorieid=" + catId,
      })
        .then((response) => response.text())
        .then((html) => {
          document.getElementById("livres-grid").innerHTML = html;
          updatePagination(catId);
        })
        .catch((error) => console.error("Erreur:", error));
    });
  });
});

// Mise à jour dynamique de la pagination
function updatePagination(catId) {
  const paginationLinks = document.querySelectorAll(".pagination a");
  paginationLinks.forEach((link) => {
    const href = new URL(link.href);
    href.searchParams.set("categorie_id", catId);
    link.href = href.toString();
  });
}
