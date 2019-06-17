<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <ul class="navigation-menu">
                <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}"><i class="zmdi  zmdi-dialpad"></i><span>Tableau de bord</span></a>
                </li>
                <li class="{{ Request::is('sale*') ? 'active' : '' }}">
                    <a href="{{ route('sale.index') }}"><i class="zmdi  zmdi-paypal-alt"></i><span>Ventes</span></a>
                </li>
                <li class="{{ Request::is('brand*') ? 'active' : '' }}">
                    <a href="{{ route('brand.index') }}"><i class="zmdi zmdi-wrench"></i><span>Fabricants</span></a>
                </li>
                <li class="{{ Request::is('product*') ? 'active' : '' }}">
                    <a href="{{ route('product.index') }}"><i class="zmdi  zmdi-invert-colors"></i><span>Produits</span></a>
                </li>
                <li class="{{ Request::is('derive*') ? 'active' : '' }}">
                    <a href="{{ route('derive.index') }}"><i class="zmdi  zmdi-battery"></i><span>Déclinaisons</span></a>
                </li>
                <li class="{{ Request::is('filter*') ? 'active' : '' }}">
                    <a href="{{ route('filter.index') }}"><i class="zmdi  zmdi-delicious"></i><span>Filtres</span></a>
                </li>
                <li class="{{ Request::is('movement*') ? 'active' : '' }}">
                    <a href="{{ route('movement.index') }}"><i class="zmdi  zmdi-collection-item-9"></i><span>Mouvements - infos</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>