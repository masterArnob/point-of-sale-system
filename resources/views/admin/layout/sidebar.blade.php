<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">POS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">POS</a>
        </div>
        <ul class="sidebar-menu">
          
            <li class="dropdown">
                <a href="{{route('dashboard')}}" class="nav-link"><span>Dashboard</span></a>
             
            </li>




        <li><a class="nav-link" href="{{route('supplier.index')}}"><span>Suppliers</span></a></li>
        <li><a class="nav-link" href="{{route('category.index')}}"><span>Categories</span></a></li>


        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
              <span>Product</span></a>
          <ul class="dropdown-menu">
              <li><a class="nav-link" href="{{route('product')}}">Order Products</a></li>
              <li><a class="nav-link" href="{{route('show-products')}}">All Products</a></li>
          </ul>
      </li>



    <li><a class="nav-link" href="{{route('coupon.index')}}"> <span>Coupons</span></a></li>
        

     
      <li><a class="nav-link" href="{{route('orders')}}"> <span>Orders</span></a></li>




        </ul>


    </aside>
</div>
