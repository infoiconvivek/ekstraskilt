

document.addEventListener('DOMContentLoaded', function () {
    var canvas = new fabric.Canvas('designCanvas');
    var changeDesignOption = document.getElementById('changeDesignOption');
    var canvasHistory = [];
    var currentStateIndex = -1;
    var stateHistory = [];


    // Show change design option when object is selected
    canvas.on('selection:created', function (e) {
        var selectedObject = e.target;
        changeDesignOption.style.display = 'block';
        // if (selectedObject) {
        //     console.log("Width:", selectedObject.width);
        //     console.log("Height:", selectedObject.height);
        // }

    });

    // Hide change design option when selection is cleared
    canvas.on('selection:cleared', function () {
        changeDesignOption.style.display = 'none';
    });

    canvas.on('object:scaling', function(e) {
        var scaledObject = e.target;
        if (scaledObject) {
            var width = scaledObject.getScaledWidth() / 37.795275591; // Get the scaled width
            var height = scaledObject.getScaledHeight() / 37.795275591; // Get the scaled height
            // console.log("Width:", width);
            // console.log("Height:", height);

           get_new_width = (Math.round(width * 100) / 100).toFixed(2);
           get_new_height = (Math.round(height * 100) / 100).toFixed(2);

            $('#getTextHt').text(get_new_width + 'cm');
            $('#getTextWt').text(get_new_height + 'cm');
        }
    });


    window.addPage = function () {
        var product_width = $("#product_width").val() * 37.795275591;
        var product_height = $("#product_height").val() * 37.795275591;
        var canvasWidth = product_width; // Set your desired width here
        var canvasHeight = product_height; // Set your desired height here

        pwl = $("#product_width").val();
        pwh = $("#product_height").val();
        $('#getCanvaWidth').text(pwl + 'cm');
        $('#getCanvaHeight').text(pwh + 'cm');

        canvas.setWidth(canvasWidth);
        canvas.setHeight(canvasHeight);

    };

    function saveCanvasState() {
        var json = JSON.stringify(canvas);
        // Remove redo states
        stateHistory = stateHistory.slice(0, currentStateIndex + 1);
        stateHistory.push(json);
        currentStateIndex = stateHistory.length - 1;
    }

    // Function to undo the last action
    window.undo = function (e) {
        ///console.log('undo change' + currentStateIndex);
        // if (currentStateIndex > 0) {
        currentStateIndex--;
        canvas.loadFromJSON(stateHistory[currentStateIndex], canvas.renderAll.bind(canvas));
        console.log('done' + currentStateIndex);
        //}
    }

    // Function to redo the last undone action
    window.redo = function (e) {
        console.log('redo change' + currentStateIndex);
        //if (currentStateIndex < stateHistory.length - 1) {
        currentStateIndex++;
        canvas.loadFromJSON(stateHistory[currentStateIndex], canvas.renderAll.bind(canvas));
        console.log('done' + currentStateIndex);
        //}
    }

    window.deletTargt = function () {
        var selectedObject = canvas.getActiveObject();
        if (selectedObject) {
            // Remove the selected object from the canvas
            canvas.remove(selectedObject);
            canvas.requestRenderAll();
        } else {
            alert('No object selected!');
        }
    }




    window.changeColorButton = function (colorInput) {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            var selectedColor = colorInput.value;
            // var font_color = $("#font_color").val();
            activeObject.set('fill', selectedColor);
            canvas.renderAll();
        }
    };


    window.boldButton = function (e) {
        var activeObject = canvas.getActiveObject();
        ///alert(activeObject);
        if (activeObject && activeObject.type === 'i-text') {
            var isBold = activeObject.get('fontWeight') === 'bold';
            activeObject.set('fontWeight', isBold ? 'normal' : 'bold').setCoords();
            canvas.requestRenderAll();
        }
    };

    window.italianFont = function () {
        var font_fmly = 'italic';
        var activeObject = canvas.getActiveObject();
        ///alert(this.value);
        if (activeObject && activeObject.type === 'i-text') {
            console.log(font_fmly);
            activeObject.set('fontFamily', font_fmly);
            canvas.requestRenderAll();
        }
    };

    window.fontSize = function (font_sizes) {
        var font_size = $("#font_size_data").val();
        var activeObject = canvas.getActiveObject();
        ///alert(this.value);
        if (activeObject && activeObject.type === 'i-text') {
            ///activeObject.set('fontSize', parseInt(this.value, font_size)).setCoords();
            activeObject.set('fontSize', font_size);
            canvas.requestRenderAll();
        }
    };


    window.fontFmly = function (font_fmy) {
        var font_fmly = $("#font_family_data").val();
        var activeObject = canvas.getActiveObject();
        ///alert(this.value);
        if (activeObject && activeObject.type === 'i-text') {
            activeObject.set('fontFamily', font_fmly);
            canvas.requestRenderAll();
        }
    };

    window.addToolText = function () {
        var itext = new fabric.IText("Din tekst her", {
            width: 100,
            left: 160,
            top: 190,
            fill: "black",
            fontSize: 30,
        });

        canvas.add(itext);
        canvas.on("object:selected", function (e) {
            var selectedObject = e.target;
            if (selectedObject) {
                canvas.bringToFront(itext);
            }
        });
    };

    window.addToolbgImage = function (img) {
        var image_path = img;
        ///alert(image_path);
        var img = new Image();
        img.onload = function () {
            var f_img = new fabric.Image(img);
            canvas.setBackgroundImage(f_img);
            canvas.renderAll();
        };

        ///var myDataURL = "https://pitchprint.io/thumbs/c8afda8b60ea9e6323ecb19780094128.jpg"
        img.src = image_path;

    };

    window.rmvBgImage = function (e) {
        canvas.setBackgroundImage(null, canvas.renderAll.bind(canvas));
    };

    window.addToolImageOld = function (img) {
        var image_path = img;
        var pugImg = new Image();
        pugImg.onload = function (img) {
            var pug = new fabric.Image(pugImg, {
                // angle: 45,
                // width: 500,
                // height: 500,
                // left: 50,
                // top: 70,
                // scaleX: .25,
                // scaleY: .25
            });
            canvas.add(pug);
        };
        pugImg.src = image_path;
    };


    window.addToolImage = function (img) {
        var image_path = img;
        fabric.loadSVGFromURL(image_path, function(objects, options) {
            var svgObject = fabric.util.groupSVGElements(objects, options);
      
            // Adjust SVG object properties if necessary
            svgObject.set({
              left: 100,
              top: 100,
              scaleX: 0.5,
              scaleY: 0.5
            });
      
            // Add SVG object to canvas
            canvas.add(svgObject);
      
            // Enable editing functionalities
            svgObject.set({
              selectable: true, // Allow selection
              hasControls: true, // Show controls (like resize handles)
              hasBorders: true, // Show borders
              perPixelTargetFind: true // Enable per-pixel click detection
            });
      
            // Render canvas
            canvas.renderAll();
          });
       
    };


    window.unGroupImg = function () {
        var image_path = 'http://165.232.130.162/ekstraskilt/storage/design/24022050539svg-viewer.svg';
        ///var url = e.target.value;
        loadSVGFromURL(image_path);

        var activeObject = canvas.getActiveObject();
        ///console.log(activeObject.type);
        if (activeObject && activeObject.type === 'group') {
          ungroupObject(activeObject);
        }
       
    };

    function loadSVGFromURL(url) {
        fabric.loadSVGFromURL(url, function(objects, options) {
          var svgObject = fabric.util.groupSVGElements(objects, options);
  
          // Add SVG object to canvas
          canvas.clear(); // Clear existing canvas
          canvas.add(svgObject);
  
          // Render canvas
          canvas.renderAll();
        });
      }

      function ungroupObject(group) {
        group._restoreObjectsState();
        canvas.remove(group);
        canvas.renderAll();
      }

    $("#testAjax").click(function (event) {
        alert('test')
        event.preventDefault();

        $.ajax({
            type: "post",
            url: "{{ url('addFavorites') }}",
            dataType: "json",
            data: $('#ajax').serialize(),
            success: function (data) {
                alert("Data Save: " + data);
            },
            error: function (data) {
                alert("Error")
            }
        });
    });

    // Function to save the design
    window.saveDesign = function () {
        ///alert('test data');
        var designData = JSON.stringify(canvas);
        var design_data = designData;
        var did = $("#did").val();
        saveCanvasState();
        $.ajax({
            type: 'post',
            url: "../tool-save",
            data: { design_data: design_data, design_id: did },
            success: function (data) {
                alert(data.success);
            }
        });

    };


    window.downloadDesign = function () {
        var dataURL = canvas.toDataURL('image/png');
        var link = document.createElement('a');
        link.href = dataURL;
        link.download = 'design.png';
        link.click();
    };


    window.downloadAsSVG = function () {
        console.log('test');
        var svgContent = canvas.toSVG();
        var blob = new Blob([svgContent], { type: 'image/svg+xml' });
        var url = window.URL.createObjectURL(blob);
    
        var link = document.createElement('a');
        link.href = url;
        link.download = 'canvas_content.svg';
        link.click();
    
        window.URL.revokeObjectURL(url);
    };


});