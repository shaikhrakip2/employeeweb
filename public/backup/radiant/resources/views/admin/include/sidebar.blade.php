  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('admin.dashboard') }}" class="brand-link">
          <img src="{{ asset($site_settings['logo']) }}" alt="{{ $site_settings['application_name'] }}" class="brand-image"
              style="opacity: .8">
          <span class="brand-text font-weight-light">&nbsp;</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  @if (Auth::guard('admin')->check())
                      <img src="{{ asset(Auth::guard('admin')->user()->image) }}" class="img-circle elevation-2"
                          alt="User Image">
                      <span
                          class="brand-text font-weight-light col-white">&nbsp;{{ Auth::guard('admin')->user()->name }}</span>
                  @endif
              </div>
              <div class="info">
                  <a href="#" class="d-block"></a>
              </div>
          </div>




          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar  flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">

                  @if (userCan(102))
                      <li class="nav-item">
                          <a href="{{ route('admin.dashboard') }}" class="nav-link">
                              <i class="nav-icon fas fa-tachometer-alt"></i>
                              <p> Dashboard </p>
                          </a>
                      </li>
                  @endif


                  @if (userCan([108, 109]))
                      <li class="nav-item ">
                          <a href="#" class="nav-link ">
                              <i class="fa fa-tags  nav-icon"></i>
                              <p> Users <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if (userCan(108))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/role') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Role & Permissions</p>
                                      </a>
                                  </li>
                              @endif

                              @if (userCan(109))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/subadmin') }}" class="nav-link ms-2">
                                          <i class="nav-icon fas fa-user"></i>
                                          <p> Sub Admin </p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif

                  @if (userCan([103, 104, 105, 106, 107, 108, 120]))
                      <li class="nav-item ">
                          <a href="#" class="nav-link ">
                              <i class="nav-icon fas fa-cog"></i>
                              <p> Masters <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">

                              @if (userCan(103))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/banner') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Banners</p>
                                      </a>
                                  </li>
                              @endif


                              @if (userCan(104))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/cms') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Cms</p>
                                      </a>
                                  </li>
                              @endif

                              @if (userCan(105))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/home_cms') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Home Cms</p>
                                      </a>
                                  </li>
                              @endif

                              @if (userCan(107))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/news-letter') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>News Letters</p>
                                      </a>
                                  </li>
                              @endif

                              @if (userCan(106))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/testimonials') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Testimonials </p>
                                      </a>
                                  </li>
                              @endif

                              @if (userCan(120))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/save-littles') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Save Littles</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif
                  @if (userCan([110, 111]))
                      <li class="nav-item ">
                          <a href="#" class="nav-link">
                              <i class="fa-solid fa-circle-question mx-2"></i>
                              <p> FAQ's <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if (userCan(110))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/faq-categories') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>FAQ Category</p>
                                      </a>
                                  </li>
                              @endif

                              @if (userCan(111))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/faq') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>FAQ</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif

                  @if (userCan([112, 113]))
                      <li class="nav-item ">
                          <a href="#" class="nav-link ">
                              <i class="fa-solid fa-calendar-days mx-2"></i>
                              <p>Events <i class="fas fa-angle-left right"></i> </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if (userCan(112))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/event_categories') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Event Category</p>
                                      </a>
                                  </li>
                              @endif
                              @if (userCan(113))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/event') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Event</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif

                  @if (userCan([114, 115]))
                      <li class="nav-item ">
                          <a href="#" class="nav-link ">
                              <i class="fa-solid fa-blog nav-icon"></i>
                              <p>Blogs <i class="fas fa-angle-left right"></i> </p>
                          </a>
                          <ul class="nav nav-treeview">
                              @if (userCan(114))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/blog_categories') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Blog Category</p>
                                      </a>
                                  </li>
                              @endif
                              @if (userCan(115))
                                  <li class="nav-item">
                                      <a href="{{ url('admin/blog') }}" class="nav-link ms-2">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p>Blog</p>
                                      </a>
                                  </li>
                              @endif
                          </ul>
                      </li>
                  @endif


                  @if (userCan(116))
                      <li class="nav-item">
                          <a href="{{ url('admin/doctor-descriptions') }}" class="nav-link">
                              <i class="fa-solid fa-file-medical mx-2"></i>
                              <p>Doctor Descriptions</p>
                          </a>
                      </li>
                  @endif

                  @if (userCan(117))
                      <li class="nav-item">
                          <a href="{{ url('admin/team') }}" class="nav-link">
                              <i class="fa-solid fa-users mx-2"></i>
                              <p>Team</p>
                          </a>
                      </li>
                  @endif

                  @if (userCan(118))
                      <li class="nav-item">
                          <a href="{{ url('admin/awards') }}" class="nav-link">
                              <i class="fa-solid fa-trophy mx-2"></i>
                              <p>Awards</p>
                          </a>
                      </li>
                  @endif

                  @if (userCan(121))
                      <li class="nav-item">
                          <a href="{{ url('admin/newsletter-notifications') }}" class="nav-link">
                              <i class="fa-solid fa-comments mx-2"></i>
                              <p>Newsletter Notifications</p>
                          </a>
                      </li>
                  @endif

                 <!--  @if (userCan(122))
                      <li class="nav-item">
                          <a href="{{ url('admin/become-member') }}" class="nav-link ">
                              <i class="fas fa-envelope nav-icon"></i>
                              <p>Become Member Inquiries </p>
                          </a>
                      </li>
                  @endif -->

                  @if (userCan(119))
                      <li class="nav-item">
                          <a href="{{ url('admin/general_inquires') }}" class="nav-link ">
                              <i class="fas fa-envelope nav-icon"></i>
                              <p>General Inquiries </p>
                          </a>
                      </li>
                  @endif

                  @if (userCan(101))
                      <li class="nav-item">
                          <a href="{{ url('admin/general_settings') }}" class="nav-link ">
                              <i class="fas fa-gear nav-icon"></i>
                              <p>General Settings </p>
                          </a>
                      </li>
                  @endif
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
