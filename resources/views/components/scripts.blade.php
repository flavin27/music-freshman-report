<script src="https://unpkg.com/tablesort@5.2.1/dist/tablesort.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Tablesort(document.getElementById('sortableTable'));
    });
    function normalizeText(text) {
        return text
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase();
    }

    document.getElementById("searchInput").addEventListener("input", function () {
        const filter = normalizeText(this.value);
        const rows = document.querySelectorAll("#tableBody tr");

        rows.forEach(row => {
            const text = normalizeText(row.textContent);
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });

</script>
