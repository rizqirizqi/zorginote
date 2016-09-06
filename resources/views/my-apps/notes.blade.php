<!DOCTYPE html>
<html>
<head>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Max Online Notes</title>
</head>
<body>
  <textarea id="notes" name="notes" onchange="onChange()">
    {{ $notes }}
  </textarea>
  <button id="notesSave" onClick="saveNotes()">Save</input>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector:'#notes',
      theme:'modern',
      height:500,
      max_height:500,
      plugins:'save',
      menubar: false,
      toolbar1: 'undo, redo, bold, italic, underline, strikethrough, alignleft, aligncenter, alignright, alignjustify',
      toolbar2: 'bullist, numlist, outdent, indent, subscript, superscript, removeformat',
      content_style: "body {height:400px}",
      setup :
      function(ed) {
        ed.on('init', function() {
          this.getDoc().body.style.fontSize = '1em';
        });
      }
    });
  </script>
  <script>
    function saveNotes() {
      var content = tinymce.get('notes').getContent();
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
         console.log(this.responseText)
       }
     };
     xhr.open("POST", "{{ url('x/save') }}", true);
     var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
     xhr.setRequestHeader("X-CSRF-TOKEN", token);
     xhr.setRequestHeader('Content-type', 'application/json');
     xhr.send(JSON.stringify({'notes':content}));
   }
 </script>
</body>
</html>
