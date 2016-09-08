<!DOCTYPE html>
<html>
<head>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('my-apps/note/css/styles.css') }}">
  <title>Zorginote</title>
</head>
<body>
  <textarea id="note" name="note" rows="20" cols="80">
    {{ $notes }}
  </textarea>
  <script src="{{ asset('my-apps/note/ckeditor.min.js') }}"></script>
  <script src="{{ asset('my-apps/note/config.js') }}"></script>
  <script>
    var editor = CKEDITOR.replace('note', {
		
	});
	var saveTimeout = null;
	editor.on( 'change', function( evt ) {
		clearTimeout(saveTimeout);
		saveTimeout = setTimeout(function(){ saveNote(); }, 5000);
		console.log( 'Data: ' + evt.editor.getData() );
		console.log( 'Total bytes: ' + evt.editor.getData().length );
	});
	
    function saveNote() {
      var content = editor.getData()
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
         console.log(this.responseText)
       }
     };
     xhr.open("POST", "{{ url('save') }}", true);
     var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
     xhr.setRequestHeader("X-CSRF-TOKEN", token);
     xhr.setRequestHeader('Content-type', 'application/json');
     xhr.send(JSON.stringify({'notes':content}));
   }
 </script>
</body>
</html>
