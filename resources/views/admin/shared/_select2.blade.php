<script>
    $(document).ready(function () {
        $('select.tags').select2({
            "language": {
                "noResults": function () {
                    return "None";
                }
            }
        })
    });
</script>
