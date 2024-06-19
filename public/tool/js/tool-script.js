

document.addEventListener('DOMContentLoaded', function () {
    var canvas = new fabric.Canvas('designCanvas');
    var changeDesignOption = document.getElementById('changeDesignOption');
    var canvasHistory = [];
    var currentStateIndex = -1;
    var stateHistory = [];

    ///var svg = fabric.util.groupSVGElements(objects, options);
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

    canvas.on('object:scaling', function (e) {
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


    function addBorderToObject(obj) {
        obj.set({
            stroke: 'red', // Border color
            strokeWidth: 2 // Border width
        });
    }

    // Function to remove border from unselected objects
    function removeBorderFromObjects() {
        canvas.getObjects().forEach(function (obj) {
            if (!obj.active) {
                obj.set({ stroke: null }); // Remove border
            }
        });
    }

    window.addToolBorder = function (e) {
        console.log('test');
        canvas.on('selection:created', function (e) {
            addBorderToObject(e.target); // Add border to selected object
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
        fabric.loadSVGFromURL(image_path, function (objects, options) {
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
                movable: true, // Show borders
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
        fabric.loadSVGFromURL(url, function (objects, options) {
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

    function createHexagonPoints(centerX, centerY, radius) {
        const points = [];
        for (let i = 0; i < 6; i++) {
            const angle = (Math.PI / 3) * i;
            points.push({
                x: centerX + radius * Math.cos(angle),
                y: centerY + radius * Math.sin(angle)
            });
        }
        return points;
    }


    $('.popupSubModal').click(function () {

        var $popupSubModal = $(this);
        var $popupSubMenu = $popupModal.closest('li').find('.popup_submenu');
        $popupSubModal.toggleClass('open');
        $popupSubMenu.toggleClass('show');

        $('.popup_menu').not($popupSubMenu).removeClass('show');
        $('.popupModal').not($popupSubModal).removeClass('open');
        $('.popup_menu2').removeClass('show');

    });

    $('.toolForm').click(function () {
        var canvas = new fabric.Canvas('designCanvas');
        var form_id = $(this).attr("data-id");

        if (form_id == 1) {
            const roundedRect = new fabric.Rect({
                left: 100,
                top: 100,
                fill: '#fff',  // White transparent background
                stroke: 'black',  // Border color
                strokeWidth: 3,   // Border width
                width: 650,
                height: 350,
                rx: 20,  // Horizontal radius
                ry: 20   // Vertical radius
            });
            canvas.add(roundedRect);
        } else if (form_id == 2) {
            const square = new fabric.Rect({
                left: 100,
                top: 100,
                fill: '#fff',  // Transparent background
                stroke: 'black',  // Border color
                strokeWidth: 3,   // Border width
                width: 650,
                height: 350,
                rx: 20,  // Horizontal radius for rounded corners
                ry: 20   // Vertical radius for rounded corners
            });
            canvas.add(square);
        } else if (form_id == 3) {
            const oval = new fabric.Ellipse({
                left: 100,
                top: 100,
                fill: '#fff',  // Transparent background
                stroke: 'black',  // Border color
                strokeWidth: 3,   // Border width
                rx: 345,          // Horizontal radius
                ry: 168            // Vertical radius
            });
            canvas.add(oval);
        } else if (form_id == 4) {
            const rotatedSquare = new fabric.Rect({
                left: 100,
                top: 100,
                fill: '#fff',  // Transparent background
                stroke: 'black',  // Border color
                strokeWidth: 3,   // Border width
                width: 300,       // Width of the square
                height: 180,      // Height of the square
                angle: 45         // Rotation angle in degrees
            });

            // Add the square to the canvas
            canvas.add(rotatedSquare);
        } else if (form_id == 5) {
            // Hexagon center coordinates and radius
            const centerX = 250;
            const centerY = 250;
            const radius = 250;

            // Create a hexagon with white background and 3px border
            const hexagon = new fabric.Polygon(createHexagonPoints(centerX, centerY, radius), {
                fill: 'white',         // White background
                stroke: 'black',       // Border color
                strokeWidth: 3,        // Border width
                left: centerX - radius,
                top: centerY - radius,
                originX: 'left',
                originY: 'top'
            });

            // Add the hexagon to the canvas
            canvas.add(hexagon);
        } else if (form_id == 6) {
            const triangle = new fabric.Triangle({
                left: 100,
                top: 100,
                fill: 'white',     // White background
                stroke: 'black',   // Border color
                strokeWidth: 3,    // Border width
                width: 350,
                height: 350
            });
    
            // Add the triangle to the canvas
            canvas.add(triangle);
        } else if (form_id == 7) {
             // Initialize canvas
        // Define a path for a rectangle with curved top and bottom edges
        const pathData = 'M 100 100 Q 150 50 200 100 L 300 100 Q 350 50 400 100 L 400 200 Q 350 250 300 200 L 200 200 Q 150 250 100 200 Z';

        // Create a path object with the specified path data
        const curvedRect = new fabric.Path(pathData, {
            fill: 'white',  // White background
            stroke: 'black',  // Border color
            strokeWidth: 3,   // Border width
            left: 50,
            top: 50,
            scaleX: 1,
            scaleY: 1
        });

        // Add the path object to the canvas
        canvas.add(curvedRect);
        } else if (form_id == 8) {
          
       } else if (form_id == 9) {
          
       } else if (form_id == 10) {
          
       } else {
            const roundedRect = new fabric.Rect({
                left: 100,
                top: 100,
                fill: 'rgba(255, 255, 255, 0.5)',  // White transparent background
                stroke: 'black',  // Border color
                strokeWidth: 3,   // Border width
                width: 650,
                height: 350,
                rx: 20,  // Horizontal radius
                ry: 20   // Vertical radius
            });
            canvas.add(roundedRect);
        }


        // Add the rectangle to the canvas

    });


});