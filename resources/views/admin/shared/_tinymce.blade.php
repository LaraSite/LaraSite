<script type="text/javascript">
    tinymce.init({
        selector: ".tinymce",

        // Download language pack from http://www.tinymce.com/i18n/
        // language: "ja",

        menu: { // this is the complete default configuration
            // file   : {title : 'File'  , items : 'newdocument'},
            edit   : {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall'},
            insert : {title : 'Insert', items : 'link hr pagebreak | image media'},
            view   : {title : 'View'  , items : 'visualaid visualchars'},
            format : {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            table  : {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
            tools  : {title : 'Tools' , items : 'code'}
        },

        toolbar: "undo redo | styleselect | bold italic fontsizeselect forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | pagebreak",

        fontsize_formats: "10pt 12pt 14pt 18pt 24pt 36pt",

        plugins: [
            "autolink code hr image link lists media pagebreak paste",
            "table textcolor visualblocks visualchars"
        ],

        // image_advtab: true,
        pagebreak_separator: "<!--more-->"
    });
</script>