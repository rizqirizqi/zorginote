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
	CKEDITOR.plugins.add( 'dividerBar', {
		init: function( editor ) {
			editor.addCommand( 'insertDividerBar', {
				exec: function( editor ) {
					editor.insertHtml( '___________________________________________________' );
				}
			});
			editor.ui.addButton( 'DividerBar', {
				label: '_',
				command: 'insertDividerBar',
				toolbar: 'insert'
			});
		}
	});
	
    var editor = CKEDITOR.replace('note', {
		extraPlugins: 'dividerBar'
	});
	
	editor.on("instanceReady",function() {
		editor.addCommand( "save", {
			modes : { wysiwyg:1, source:1 },
			exec : function () {
				var content = editor.getData();
				saveNote(content);
			}
		});
	});
	
	function saveNote(content) {
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
