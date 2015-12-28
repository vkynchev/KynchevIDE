$(document).ready(function(){
  $('.home-btn').click(function(){
    window.location.replace(location.protocol + '//' + location.host + '/');
  });

  $('.download-project').click(function(){
    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
      function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
      }

      $_GET[decode(arguments[1])] = decode(arguments[2]);
    });
    
    var filePath = $_GET["path"];
    var project = $('.heading h1 a:first-child').text();
    
    filePath = filePath.split("/");
    
    window.open(location.protocol + '//' + location.host + '/workspaces/' + project + '/?project=' + project + '&fileDownload=' + filePath);
  });
  
  $('.name').click(function(){
    var filePath = $(this).attr('file-path');
    var fileName = filePath.substring(filePath.lastIndexOf("/") + 1, filePath.length);
    var fileExt = $(this).attr('file-extension');
    
    if (isImage(fileName)) {
    	$('.wrap').hide();
    	
    	$('.add-file').remove();
    	
    	$('.remove-file-container').append('<p class="remove remove-file">Remove File</p>');
    	
    	$('.filename span').empty();
        $('.filename span').append(fileName);
        $('.filename').css('display', 'inline-block');
        
    	$('#viewer').append('<img class="inside" src="/'+filePath+'"></img>');
    	$('#viewer').show();
    } else if (isVideo(fileName)) {
    	$('.wrap').hide();
    	
    	$('.add-file').remove();
    	
    	$('.remove-file-container').append('<p class="remove remove-file">Remove File</p>');
    	
    	$('.filename span').empty();
        $('.filename span').append(fileName);
        $('.filename').css('display', 'inline-block');
        
    	$('#viewer').append('<video class="inside" src="/'+filePath+'" controls></video>');
    	$('#viewer').show();
    } else if (typeof filePath !== typeof undefined && filePath !== false) {
      
      $.get( 
        "",
        { loadFile: filePath },
        function(data) {
        $('#editorBuffer').append(data);
        
      $('.wrap').hide();
      $('.add-file').remove();
          
      $('.remove-file-container').append('<p class="remove remove-file">Remove File</p>');
          
      $('.filename span').empty();
      $('.filename span').append(fileName);
      $('.filename').css('display', 'inline-block');
          
      $('#editor').show();
      $('#editor xmp').append($('#editorBuffer').html());
      var editor = ace.edit("editor");
      editor.setTheme("ace/theme/tomorrow");
	  
      var modelist = ace.require("ace/ext/modelist");
      var mode = modelist.getModeForPath(filePath).mode
      editor.session.setMode(mode);
      editor.session.setUseWrapMode(true);
      editor.session.setWrapLimitRange();
    	  
      editor.setOptions({
	enableBasicAutocompletion: true,
	enableSnippets: true,
	enableLiveAutocompletion: true
      });
      
      editor.getSession().on('change', function(){
        $('#editorBuffer').empty();
        var append = encodeHtmlEntities(editor.getSession().getValue());
        $('#editorBuffer').append(append);
      });
        
        }
      );
      
    }
  });
  
  fullscreenMode();
  if($('.user-position').text() != "read_only"){
    addProject();
    addFile();
    removeFile();
    saveFile();
  }
});

function fullscreenMode() {
  var fullscreen = 0;

  
  $('.fullscreen').click(function(){
    var editor = ace.edit("editor");
    $('.fullscreen').empty();
    if(fullscreen == 0) {
      $('.fullscreen').append('<i class="fa fa-compress"></i>');
      $('.page').addClass('fullscreen-mode');
      editor.resize()
      editor.session.setUseWrapMode(true);
      editor.session.setWrapLimitRange();
      fullscreen = 1;
    } else {
      $('.fullscreen').append('<i class="fa fa-expand"></i>');
      $('.page').removeClass('fullscreen-mode');
      editor.resize()
      editor.session.setUseWrapMode(true);
      editor.session.setWrapLimitRange();
      fullscreen = 0;
    }
    
    
  });
}

function addProject() {
  $('.add-project').click(function(){
    $('.overlay').addClass('visible');
  });
  
  $('.remove-project').click(function(){
    $('.overlay2').addClass('visible');
  });
  
  $('.project-form').submit(function() {
   return false;
  });
  
  $('.check-pass').submit(function() {
   return false;
  });
  
  $('.exit-btn').click(function(){
    $('.overlay').removeClass('visible');
    $('.overlay2').removeClass('visible');
  });
  
  $('.project-name-btn').click(function(){
    var nameVal = $('.project-name').val();
    $.get( 
                  "add-project/",
                  { createProject: nameVal },
                  function(data) {
                     location.reload();
                  }
               );
  });
    
  $('.password-check-btn').click(function(){
    var passwordVal = $('.password-check').val();
    var nameVal = $('.password-check').prop('project');
    $.get( 
                  "/",
                  { passwordCheck: passwordVal },
                  function(data) {
                     if(data == "true"){
                     var nameVal = $('.password-check').attr('project');
                       $.get( 
	                  "remove-project/",
	                  { removeProject: nameVal },
	                  function(data) {
	                     location.href = "?path=";
	                  }
	               );
                     } else {
                       $('.password-check').css('background-color', 'rgba(231, 76, 60, 0.1)');
                     }
                  }
               );
    });
    
}

function addFile() {
  $('.add-file').click(function(){
    $('.filename span form').css('display', 'inline-block');
    $('.filename').css('display', 'inline-block');
  });
  
  $('.upload-file').click(function(){
    //$('.overlay2').addClass('visible');
  });
  
  $('.filename-add').submit(function() {
   return false;
  });
  
  $('.file-name-btn').click(function(){
    var nameVal = $('.file-name').val();
    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
      function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
      }

      $_GET[decode(arguments[1])] = decode(arguments[2]);
    });
    
    $.get( 
                  "add-file/",
                  { createFile: nameVal,
                    inPath: $_GET["path"] },
                  function(data) {
                     location.reload();
                  }
               );
  });
    
}

function removeFile() {
  $('.remove-file-container').click(function(){
    var nameVal = $('.filename span').html();
    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
      function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
      }

      $_GET[decode(arguments[1])] = decode(arguments[2]);
    });
    
    $.get( 
                  "remove-file/",
                  { removeFile: nameVal,
                    inPath: $_GET["path"] },
                  function(data) {
                     location.reload();
                  }
               );
    
  });
}

function saveFile() {
   $('#editor').keyup(function(){
    var nameVal = $('.filename span').html();
    var $_GET = {};

    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
      function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
      }

      $_GET[decode(arguments[1])] = decode(arguments[2]);
    });
    
    $.get( 
                  "save-file/",
                  { saveFile: nameVal,
                    inPath: $_GET["path"],
                    filedata: decodeHtmlEntities($('#editorBuffer').html()) },
                  function(data) {
                     //location.reload();
                  }
               );
  });
}


$(function(){

	var dropbox = $('.upload-file');
	
	var $_GET = {};

	    document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
	      function decode(s) {
	        return decodeURIComponent(s.split("+").join(" "));
	      }
	
	      $_GET[decode(arguments[1])] = decode(arguments[2]);
	    });

	dropbox.filedrop({
		// The name of the $_FILES entry:
		paramname:'file',
		
		data: {
			inPath : $_GET["path"]
		},
		
		maxfiles: 1,
    		maxfilesize: 100, // in mb
		url: 'upload-file/',

    	error: function(err, file) {
			switch(err) {
				case 'BrowserNotSupported':
					alert('Your browser does not support HTML5 file uploads!');
					$('.upload-file').removeClass('visible');
					break;
				case 'TooManyFiles':
					alert('Too many files! Please select only one!');
					$('.upload-file').removeClass('visible');
					break;
				case 'FileTooLarge':
					alert(file.name+' is too large! Please upload files up to 100mb.');
					$('.upload-file').removeClass('visible');
					break;
				default:
					break;
			}
		},
		
		globalProgressUpdated: function(progress) {
                  $('.upload-file .progresss').css('width', progress+"%");
                },
		
		docOver: function() {
	          $('.upload-file').addClass('visible');
	        },
	        
	        dragLeave: function() {
	          $('.upload-file').removeClass('visible');
	        },
	        
	        afterAll: function() {
	          location.reload();
	        }

	});

});

function encodeHtmlEntities(str) {
    return $("<div/>").text(str).html();
}

function decodeHtmlEntities(str) {
    return $("<div/>").html(str).text();
}

function isImage(file) {
    var extension = file.substr( (file.lastIndexOf('.') +1) );
    switch(extension) {
        case 'jpg':
	case 'png':
	case 'gif':
	case 'svg':
	case 'tiff':
	case 'bmp':
	case 'webp':
	    return(true);
	    break;
	default:
	    return(false);
    }
};

function isVideo(file) {
    var extension = file.substr( (file.lastIndexOf('.') +1) );
    switch(extension) {
        case 'mp4':
        case 'mov':
        case 'avi':
        case 'mkv':
        case 'ogg':
        case 'webm':
	    return(true);
	    break;
	default:
	    return(false);
    }
};