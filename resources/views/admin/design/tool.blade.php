@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Design')


<style>
    #changeDesignOption {
      display: none;
    }
  </style>

<!-- ========== App Menu ========== -->

<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($design)) Edit @else Add @endif Design</h4>
                        </div>

                        {{---
                        <div class="live-preview p-3">
                            <div class="button-container" style="display: flex;">
                                <a class="btn btn-info" href="" style="margin-right: 10px;">Page</a>
                                <a class="btn btn-info" href="javascript:void(0)" onclick="addToolText()" style="margin-right: 10px;">Tekst</a>
                                <a class="btn btn-info" href="javascript:void(0)" onclick="addToolImage()" style="margin-right: 10px;">Cliparts</a>
                                <a class="btn btn-info" href="javascript:void(0)" onclick="addToolbgImage()" style="margin-right: 10px;">Background</a>
                                <a class="btn btn-info" href="javascript:void(0)" style="margin-right: 10px;">Upload</a>

                            </div>
                        </div>
                        ---}}


                    </div>
                </div>

                <div class="col-lg-3">

                    <div class="sidebar">
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                    <i class="fa-regular fa-file-lines"></i>
                                    <span>Page</span>
                                </button>

                                {{--
                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                    <i class="fa-solid fa-gear"></i>
                                    <span>Item</span>
                                </button>
                                --}}
                                <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                    <i class="fa-solid fa-bars"></i>
                                    <span>Bkgrnd</span>
                                </button>
                                <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                    <i class="fa-solid fa-image"></i>
                                    <span>Cliparts</span>
                                </button>
                                <button class="nav-link" type="button" aria-selected="false" onclick="addToolText()">
                                    <i class="fa fa-pencil"></i>
                                    <span>Tekst</span>
                                </button>
                                <button class="nav-link" onclick="location.href = 'http://165.232.130.162/ekstraskilt/admin/design-gallery/create';" id="v-pills-upload-tab" data-bs-toggle="pill" data-bs-target="#v-pills-upload" type="button" role="tab" aria-controls="v-pills-upload" aria-selected="false">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <span>Upload</span>
                                </button>
                                {{--
                                <button class="nav-link" id="v-pills-search-tab" data-bs-toggle="pill" data-bs-target="#v-pills-search" type="button" role="tab" aria-controls="v-pills-search" aria-selected="false">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <span>Search</span>
                                </button>
                                --}}
                            </div>
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div clss="wrapper">
                                        <p class="fs-5 text-center fw-bold">Pages</p>
                                        <div class="d-flex justify-content-between mb-3">
                                            <button type="button" class="btn btn-secondary"><i class="fa-solid fa-trash"></i></button>
                                            <button type="button" class="btn btn-secondary"><i class="fa-solid fa-copy"></i></button>
                                            <button type="button" class="btn btn-secondary"><i class="fa-solid fa-cloud-arrow-up"></i></button>
                                            <button type="button" class="btn btn-secondary"><i class="fa-solid fa-sort"></i></button>
                                            <button type="button" class="btn btn-secondary"><i class="fa-regular fa-square-plus"></i></button>
                                        </div>

                                        <p class="fs-6 text-center">Current Page</p>
                                        <form>
                                            <div class="input-group mb-3">
                                                <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                                                <input type="text" class="form-control" id="page_title" placeholder="Page title" aria-label="Page title" value="Page 1">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">cm</span>
                                                <input type="text" class="form-control" id="product_width" placeholder="Product width" aria-label="Product width" value="30">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">cm</span>
                                                <input type="text" class="form-control" id="product_height" placeholder="Product height" aria-label="Product height" value="12">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">cm</span>
                                                <input type="text" class="form-control" placeholder="Bleed Lines" aria-label="Bleed Lines">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">cm</span>
                                                <input type="text" class="form-control" placeholder="Margin Lines" aria-label="Margin Lines">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">cm</span>
                                                <input type="text" class="form-control" placeholder="VFold Lines" aria-label="VFold Lines">
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1">cm</span>
                                                <input type="text" class="form-control" placeholder="HFold Lines" aria-label="HFold Lines">
                                            </div>
                                           
                                           {{--
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Page thumbnail" aria-label="Page title">
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Template image" aria-label="Page title">
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Foreground image" aria-label="Page title">
                                            </div>

                                            <div class="input-group mb-3 justify-content-between">
                                                <label class="form-label fw-bold">Smat sizes</label>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Tags" aria-label="Page title">
                                            </div>
                                            <div class="input-group mb-3 justify-content-between">
                                                <label class="form-label fw-bold">Lock page</label>
                                                <label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            --}}
                                            <button type="button" class="btn btn-success" onclick="addPage()">Add Page</button>

                                        </form>
                                    </div>
                                </div>
                                {{--
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <div clss="wrapper">
                                        <p class="fs-5 text-center fw-bold">Items</p>
                                    </div>
                                </div>
                                --}}
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <div clss="wrapper">
                                        <p class="fs-5 text-center fw-bold">Set Page Background</p>
                                        <select class="form-select form-select-sm bg_category_id" aria-label=".form-select-sm example">

                                            @foreach($bg_categories as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="cat mt-3">

                                            <div class="bg-gallery-result">
                                                @include('admin.design.tool-bg-gallery')
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    <div clss="wrapper">
                                        <p class="fs-5 text-center fw-bold">Add picture to your design</p>

                                        <select class="form-select form-select-sm category_id" aria-label=".form-select-sm example">
                                            @foreach($image_categories as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                        <div class="cat mt-3">

                                            <div class="gallery-result">
                                                @include('admin.design.tool-gallery')
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-upload" role="tabpanel" aria-labelledby="v-pills-upload-tab">
                                    <div clss="wrapper">
                                        <p class="fs-5 text-center fw-bold" onclick="location.href = 'http://165.232.130.162/ekstraskilt/admin/design-gallery/create';">Upload Photos</p>
                                    </div>
                                </div>
                                {{--
                                <div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
                                    <div clss="wrapper">
                                        <p class="fs-5 text-center fw-bold">Search</p>
                                    </div>
                                </div>
                                --}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                <div id="changeDesignOption">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="javascript:void(0)" onclick="changeColorButton()">
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="deletTargt(this)">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="undo()">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="redo()">
                                                <i class="fas fa-redo"></i>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="rmvBgImage()">
                                                <i class="fas fa-camera-retro"></i>
                                            </a>
                                        </li>

                                         {{--
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="italianFont()">
                                            <i class="fas fa-italic"></i>
                                            </a>
                                        </li>
                                        ---}}

                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="boldButton()">
                                                <i class="fas fa-bold"></i>
                                            </a>
                                        </li>


                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="unGroupImg()">
                                                <i class="fas fa-object-ungroup"></i>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                        <select onchange="fontSize(this)" id="font_size_data">
                                           <option value="10">10</option> 
                                           <option value="20">20</option> 
                                           <option value="30">30</option> 
                                           <option value="40">40</option> 
                                           <option value="50">50</option> 
                                           <option value="60">60</option> 
                                           <option value="70">70</option> 
                                           <option value="80">80</option> 
                                           <option value="90">90</option> 
                                           <option value="100">100</option> 
                                           <option value="110">110</option> 
                                           <option value="120">120</option> 
                                           <option value="130">130</option> 
                                           <option value="140">140</option> 
                                           <option value="150">150</option> 
                                        </select>
                                        </li>


                                        <li class="nav-item">
                                        <select onchange="fontFmly(this)" id="font_family_data">
                                          <option value="">Font</option> 
                                           <option value="Arial">Arial</option> 
                                           <option value="Verdana">Verdana</option> 
                                           <option value="Courier New">Courier New</option> 
                                           <option value="Brush Script MT">Brush Script MT</option> 
                                        </select>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)">
                                             <input type="color" id="font_color" onchange="changeColorButton(this)">
                                            </a>
                                        </li>
                                    </ul>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills justify-content-end">

                                      

                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="javascript:void(0)" onclick="downloadAsSVG()">
                                                <i class="fas fa-eye"></i> Download
                                            </a>
                                        </li>
                                      
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">
                                                <i class="fas fa-eye"></i> Height <span id="getTextHt"> </span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="#">
                                                <i class="fas fa-eye"></i> Width <span id="getTextWt"> </span>
                                            </a>
                                        </li>

                                      

                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)" onclick="location.reload(true);">
                                                <i class="fas fa-sync-alt"></i>
                                            </a>
                                        </li>
                                        
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card jainul-hw">
                                <div class="card-body">
                                    <div class="live-preview">
                                        
                                        <div>
                                            @if (isset($design->design_data))
                                            <div class="">
                                                <canvas id="designCanvas" height="444" width="1184"></canvas>
                                            </div>
                                            @else
                                            <canvas id="designCanvas" height="444" width="1184"></canvas>
                                            @endif
                                            <input type="hidden" name="design_id" id="did" value="{{$design->id}}">
                                            <br>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="title-ab title--center-line"><small id="getCanvaWidth">30cm</small></div>
                                <div class="title-hb title--center-line2"><small id="getCanvaHeight">12cm</small></div>
                            </div>
                            <button onclick="saveDesign()" data-id="{{$design->id}}" class="btn btn-success w-auto">Save Design</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div><!-- End Page-content -->

    @include('includes.admin.footer')
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<script>
    $(document).ready(function(e) {


        $('.category_id').on('change', function() {
            let category_id = $('.category_id').val();
            $.ajax({
                url: '/ekstraskilt/admin/design/get-tool-images/' + category_id,
                method: "GET",
                data: {
                    category_id: category_id
                },
                success: function(res) {
                    $('.gallery-result').html(res);
                }
            });
        });

        $('.bg_category_id').on('change', function() {
            let category_id = $('.bg_category_id').val();
            $.ajax({
                url: '/ekstraskilt/admin/design/get-tool-bg-images/' + category_id,
                method: "GET",
                data: {
                    category_id: category_id
                },
                success: function(res) {
                    $('.bg-gallery-result').html(res);
                }
            });
        });

    })
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      var canvas = new fabric.Canvas('canvas');
      var canvasHistory = [];

      document.getElementById('undoBtn').addEventListener('click', function() {
        undo();
      });

      // Function to save canvas state
      function saveCanvasState() {
        canvasHistory.push(JSON.stringify(canvas.toJSON()));
      }

      // Function to revert to previous state
      function undo() {
        if (canvasHistory.length > 1) {
          canvasHistory.pop(); // Remove current state
          var prevState = JSON.parse(canvasHistory[canvasHistory.length - 1]);
          canvas.loadFromJSON(prevState, canvas.renderAll.bind(canvas));
        }
      }

      // Save initial canvas state
      saveCanvasState();

      // Add event listeners or other canvas operations here
    });
  </script>

@if (isset($design->design_data)) 
<script>
        document.addEventListener('DOMContentLoaded', function () {
var canvas = new fabric.Canvas("designCanvas");

// Ensure proper JSON encoding and decoding
@php
$decodedData = json_decode($design->design_data, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    throw new\ Exception('Invalid JSON data');
}
@endphp

var designData = @json($decodedData);
console.log(designData);
// Set the canvas data from the retrieved JSON
canvas.loadFromJSON(designData, function() {
    canvas.renderAll();
});
});
    </script>
    @endif

@stop