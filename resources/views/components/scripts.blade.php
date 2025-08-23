<script src="https://unpkg.com/tablesort@5.2.1/dist/tablesort.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Tablesort(document.getElementById('sortableTable'));
    });
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#tableBody tr");

        rows.forEach(row => {
            let text = row.querySelector("td").textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
