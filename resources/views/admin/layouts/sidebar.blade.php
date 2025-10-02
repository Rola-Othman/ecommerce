   <div class="main-sidebar sidebar-style-2">
       <aside id="sidebar-wrapper">
           <div class="sidebar-brand">
               <a href="index.html">Stisla</a>
           </div>
           <div class="sidebar-brand sidebar-brand-sm">
               <a href="index.html">St</a>
           </div>
           <ul class="sidebar-menu">
               <li class="menu-header">Dashboard</li>
               <li class="dropdown active">
                   <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                           class="fas fa-fire"></i><span>Dashboard</span></a>
               </li>
               <li class="menu-header">Starter</li>
               <li
                   class="dropdown {{ setActive(['admin.category.*', 'admin.sub-category.*', 'admin.child-category.*']) }}">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                       <span>Manage Categories</span></a>
                   <ul class="dropdown-menu">
                       <li class="{{ setActive(['admin.category.*']) }}"><a class="nav-link"
                               href="{{ route('admin.category.index') }}">Categories</a></li>
                       <li class="{{ setActive(['admin.sub-category.*']) }}"><a class="nav-link"
                               href="{{ route('admin.sub-category.index') }}">Sub Category</a></li>
                       <li class="{{ setActive(['admin.child-category.*']) }}"><a class="nav-link"
                               href="{{ route('admin.child-category.index') }}">Child Category</a></li>
                   </ul>
               </li>

               <li
                   class="dropdown {{ setActive([
                       'admin.order.*',
                       'admin.pending-orders',
                       'admin.processed-orders',
                       'admin.dropped-off-orders',
                       'admin.shipped-orders',
                       'admin.out-for-delivery-orders',
                       'admin.delivered-orders',
                       'admin.canceled-orders',
                   ]) }}">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                           class="fas fa-cart-plus"></i>
                       <span>Orders</span></a>
                   <ul class="dropdown-menu">
                       <li class="{{ setActive(['admin.order.*']) }}"><a class="nav-link"
                               href="{{ route('admin.order.index') }}">All Orders</a></li>
                       <li class="{{ setActive(['admin.pending-orders']) }}"><a class="nav-link"
                               href="{{ route('admin.pending-orders') }}">All Pending Orders</a></li>
                       <li class="{{ setActive(['admin.processed-orders']) }}"><a class="nav-link"
                               href="{{ route('admin.processed-orders') }}">All processed Orders</a></li>
                       <li class="{{ setActive(['admin.dropped-off']) }}"><a class="nav-link"
                               href="{{ route('admin.dropped-off-orders') }}">All Dropped Off Orders</a></li>

                       <li class="{{ setActive(['admin.shipped-orders']) }}"><a class="nav-link"
                               href="{{ route('admin.shipped-orders') }}">All Shipped Orders</a></li>
                       <li class="{{ setActive(['admin.out-for-delivery-orders']) }}"><a class="nav-link"
                               href="{{ route('admin.out-for-delivery-orders') }}">All Out For Delivery Orders</a></li>

                       <li class="{{ setActive(['admin.delivered-orders']) }}"><a class="nav-link"
                               href="{{ route('admin.delivered-orders') }}">All Delivered Orders</a></li>

                       <li class="{{ setActive(['admin.canceled-orders']) }}"><a class="nav-link"
                               href="{{ route('admin.canceled-orders') }}">All Canceled Orders</a></li>

                   </ul>
               </li>

               <li
                   class="dropdown {{ setActive([
                       'admin.brand.*',
                       'admin.products.*',
                       'admin.products-image-gallery.*',
                       'admin.products-variant.*',
                       'admin.products-variant-item.*',
                       'admin.seller-products.*',
                       'admin.seller-pending-products.*',
                   ]) }}">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                       <span>Manage Products</span></a>
                   <ul class="dropdown-menu">
                       <li class="{{ setActive(['admin.brand.*', 'admin.products.*']) }}"><a class="nav-link"
                               href="{{ route('admin.brand.index') }}">Brands</a></li>

                       <li
                           class="{{ setActive([
                               'admin.products.*',
                               'admin.products-image-gallery.*',
                               'admin.products-variant.*',
                               'admin.products-variant-item.*',
                               'admin.reviews.*',
                           ]) }}">
                           <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
                       </li>

                       <li class="{{ setActive(['admin.seller-products.*']) }}"><a class="nav-link"
                               href="{{ route('admin.seller-products.index') }}">Seller Products</a></li>

                       <li class="{{ setActive(['admin.seller-pending-products.*']) }}"><a class="nav-link"
                               href="{{ route('admin.seller-pending-products.index') }}">Seller Pending Products</a>
                       </li>
                   </ul>
               </li>

               <li class="{{ setActive(['admin.transaction']) }}"><a class="nav-link"
                       href="{{ route('admin.transaction') }}"><i class="fas fa-money-bill-alt"></i>
                       <span>Transactions</span></a>
               </li>

               <li
                   class="dropdown {{ setActive(['admin.vendor-profile.*', 'admin.coupons.*', 'admin.shipping-rule.*', 'admin.payment-settings.*']) }}">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                       <span>Ecommerce</span></a>
                   <ul class="dropdown-menu">
                       <li class="{{ setActive(['admin.vendor-profile.*', 'admin.flash-sale.*']) }}">
                           <a class="nav-link" href="{{ route('admin.vendor-profile.index') }}">Vendor Profile</a>
                       </li>

                       <li class="{{ setActive(['admin.flash-sale.*']) }}"><a class="nav-link"
                               href="{{ route('admin.flash-sale.index') }}">Flash Sale</a></li>

                       <li class="{{ setActive(['admin.coupons.*']) }}"><a class="nav-link"
                               href="{{ route('admin.coupons.index') }}">Coupons</a></li>

                       <li class="{{ setActive(['admin.shipping-rule.*']) }}"><a class="nav-link"
                               href="{{ route('admin.shipping-rule.index') }}">Shipping Rule</a></li>

                       <li class="{{ setActive(['admin.payment-settings.*']) }}"><a class="nav-link"
                               href="{{ route('admin.payment-settings.index') }}">Payment settings</a></li>
                   </ul>
               </li>
               <li class="dropdown {{ setActive(['admin.slider.*', 'admin.home-page-setting.*']) }}">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                           class="fas fa-columns"></i>
                       <span>Manage Website</span></a>
                   <ul class="dropdown-menu">
                       <li class="{{ setActive(['admin.slider.*']) }}"><a class="nav-link"
                               href="{{ route('admin.slider.index') }}">Slider</a></li>

                       <li class="{{ setActive(['admin.home-page-setting.*']) }}"><a class="nav-link"
                               href="{{ route('admin.home-page-setting') }}">Home Page Setting</a></li>
                   </ul>
               </li>
               <li
                   class="dropdown {{ setActive([
                       'admin.footer-info.index',
                       'admin.footer-socials.index',
                       'admin.footer-grid-two.index',
                       'admin.ooter-grid-three.index',
                   ]) }}">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                           class="fas fa-th-large"></i><span>Footer</span></a>
                   <ul class="dropdown-menu">
                       <li class="{{ setActive(['admin.footer-info.index']) }}"><a class="nav-link"
                               href="{{ route('admin.footer-info.index') }}">Footer Info</a></li>

                       <li class="{{ setActive(['admin.footer-socials.*']) }}"><a class="nav-link"
                               href="{{ route('admin.footer-socials.index') }}">Footer Socials</a></li>

                       <li class="{{ setActive(['admin.footer-grid-two.*']) }}"><a class="nav-link"
                               href="{{ route('admin.footer-grid-two.index') }}">Footer Grid Two</a></li>

                       <li class="{{ setActive(['admin.footer-grid-three.*']) }}"><a class="nav-link"
                               href="{{ route('admin.footer-grid-three.index') }}">Footer Grid Three</a></li>

                   </ul>
               </li>

               {{-- <li class="dropdown">
                   <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                       <span>Layout</span></a>
                   <ul class="dropdown-menu">
                       <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                       <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                       <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                   </ul>
               </li> --}}
               <li><a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="far fa-square"></i>
                       <span>Settings</span></a></li>
           </ul>
           <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
               <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                   <i class="fas fa-rocket"></i> Documentation
               </a>
           </div>
       </aside>
   </div>
