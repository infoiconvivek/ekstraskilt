<style>
    .adm_active {
        background-color: #404643;
    }
</style>
@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
@endphp
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{url('admin/dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{URL::asset('front/images/logo.svg')}}" alt="" height="56">
            </span>
            <span class="logo-lg">
                <img src="{{URL::asset('front/images/logo.svg')}}" alt="" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{url('admin/dashboard')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{URL::asset('front/images/logo.svg')}}" alt="" height="56">
            </span>
            <span class="logo-lg">
                <img src="{{URL::asset('front/images/logo.svg')}}" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item {{ ($prefix == 'admin/dashboard') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="{{url('admin/dashboard')}}">
                        <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/banner') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#bannerData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="bannerData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Banner {{request()->is('banner')}}</span>
                    </a>
                    <div class="collapse menu-dropdown" id="bannerData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/banner/create')}}" class="nav-link"> Create Banner </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/banner')}}" class="nav-link"> Banner List </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/category') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#categoryData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoryData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Category</span>
                    </a>
                    <div class="collapse menu-dropdown" id="categoryData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/category/create')}}" class="nav-link"> Create Category </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/category')}}" class="nav-link"> Category List </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/attribute') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#attributeData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="attributeData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Attribute</span>
                    </a>
                    <div class="collapse menu-dropdown" id="attributeData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/attribute/create')}}" class="nav-link"> Create Attribute </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/attribute')}}" class="nav-link"> Attribute List </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/attribute-value') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#attributeValData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="attributeValData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Attribute value</span>
                    </a>
                    <div class="collapse menu-dropdown" id="attributeValData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/attribute-value/create')}}" class="nav-link"> Create Attribute </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/attribute-value')}}" class="nav-link"> Attribute List </a>
                            </li>

                        </ul>
                    </div>
                </li>




                <li class="nav-item {{ ($prefix == 'admin/product') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#productData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="productData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Product</span>
                    </a>
                    <div class="collapse menu-dropdown" id="productData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/product/create')}}" class="nav-link"> Create Product </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/product')}}" class="nav-link"> Product List </a>
                            </li>

                        </ul>
                    </div>
                </li>



                <li class="nav-item {{ ($prefix == 'admin/design') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#designData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="designData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Design</span>
                    </a>
                    <div class="collapse menu-dropdown" id="designData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/design/create')}}" class="nav-link"> Create Design </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/design')}}" class="nav-link"> Design List </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/tool') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#toolData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="toolData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Tool</span>
                    </a>
                    <div class="collapse menu-dropdown" id="toolData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/materiale')}}" class="nav-link"> Manage Materiale </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/storrelse')}}" class="nav-link"> Manage Størrelse </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/form')}}" class="nav-link"> Manage Form </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/festemetode')}}" class="nav-link"> Manage Festemetode </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/ramme')}}" class="nav-link"> Manage Ramme </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/bilde')}}" class="nav-link"> Manage Bilde </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/design-category') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#designCatData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="designCatData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Clipart Bibliotek</span>
                    </a>
                    <div class="collapse menu-dropdown" id="designCatData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/design-category/create')}}" class="nav-link"> Create Bibliotek </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/design-category')}}" class="nav-link"> Bibliotek List </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ ($prefix == 'admin/design-gallery') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#designGalleryData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="designGalleryData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Bilde Bibliotek</span>
                    </a>
                    <div class="collapse menu-dropdown" id="designGalleryData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/design-gallery/create')}}" class="nav-link"> Create Bibliotek </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/design-gallery')}}" class="nav-link"> Bibliotek List </a>
                            </li>

                        </ul>
                    </div>
                </li>





                <li class="nav-item {{ ($prefix == 'admin/user') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#userData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="userData">
                        <i class="mdi mdi-account-circle-outline"></i> <span data-key="t-authentication">Manage Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="userData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/user')}}" class="nav-link"> User List </a>
                            </li>
                        </ul>
                    </div>
                </li>




                <li class="nav-item {{ ($prefix == 'admin/order') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#bookingData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="bookingData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Orders</span>
                    </a>
                    <div class="collapse menu-dropdown" id="bookingData">
                        <ul class="nav nav-sm flex-column">


                            <li class="nav-item">
                                <a href="{{url('admin/order')}}" class="nav-link"> Orders List </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ ($prefix == 'admin/payment') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#payData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="payData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Payment</span>
                    </a>
                    <div class="collapse menu-dropdown" id="payData">
                        <ul class="nav nav-sm flex-column">


                            <li class="nav-item">
                                <a href="{{url('admin/payment')}}" class="nav-link"> Payment List </a>
                            </li>
                        </ul>
                    </div>
                </li>




                <li class="nav-item {{ ($prefix == 'admin/page') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#cmsData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="cmsData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage CMS</span>
                    </a>
                    <div class="collapse menu-dropdown" id="cmsData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/page')}}" class="nav-link"> Page List </a>
                            </li>



                            <li class="nav-item">
                                <a href="{{url('admin/menu')}}" class="nav-link"> Menu List </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ ($prefix == 'admin/blog') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#blogData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="blogData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Blog</span>
                    </a>
                    <div class="collapse menu-dropdown" id="blogData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/blog/create')}}" class="nav-link"> Create Blog </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/blog')}}" class="nav-link"> Blog List </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ ($prefix == 'admin/faq') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#faqData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="faqData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Faq</span>
                    </a>
                    <div class="collapse menu-dropdown" id="faqData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/faq/create')}}" class="nav-link"> Create Faq </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/faq')}}" class="nav-link"> Faq List </a>
                            </li>

                        </ul>
                    </div>
                </li>



                <li class="nav-item {{ ($prefix == 'admin/partner') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#partnerData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="partnerData">
                        <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-authentication">Manage Partner</span>
                    </a>
                    <div class="collapse menu-dropdown" id="partnerData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/partner/create')}}" class="nav-link"> Create Partner </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{url('admin/partner')}}" class="nav-link"> Partner List </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/enquiry') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="{{url('admin/enquiry')}}">
                        <i class="mdi mdi-account-circle-outline"></i> <span data-key="t-widgets">Manage Enquiries</span>
                    </a>
                </li>


                <li class="nav-item {{ ($prefix == 'admin/subscriber') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="{{url('admin/subscriber')}}">
                        <i class="mdi mdi-account-circle-outline"></i> <span data-key="t-widgets">Manage Subscribers</span>
                    </a>
                </li>



                <li class="nav-item {{ ($prefix == 'admin/setting') ? 'adm_active' : '' }}">
                    <a class="nav-link menu-link" href="#settingData" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="settingData">
                        <i class="mdi mdi-puzzle-outline"></i> <span data-key="t-authentication">Setting</span>
                    </a>
                    <div class="collapse menu-dropdown" id="settingData">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{url('admin/setting')}}" class="nav-link"> My Profile </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{url('admin/admin-logout')}}" class="nav-link"> Logout </a>
                            </li>

                        </ul>
                    </div>
                </li>





            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>