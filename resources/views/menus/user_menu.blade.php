<div class="col-md-2 mb-md-0 mb-4">
    <div class="d-flex flex-column justify-content-start align-items-center h-100">
        <ul class="list-group text-center">
            {{-- <li class="list-group-item list-group-item-action bg-light">
                <a href="{{ route('user.projects') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Projecten</a>
            </li> --}}
            <li class="list-group-item list-group-item-action bg-light">
                <a href="{{ route('cars.overview') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Alle Auto's</a>
            </li>
            <li class="list-group-item list-group-item-action bg-light">
                <a href="{{ route('user.myCars') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Mijn Auto's</a>
            </li>
            {{-- <li class="list-group-item list-group-item-action bg-light">
                <a href="{{ route('user.myOrders') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Bestellingen</a>
            </li> --}}
            {{-- <li class="list-group-item list-group-item-action bg-light">
                <a href="{{ route('user.myRecipes') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Recepten</a>
            </li> --}}
            <li class="list-group-item list-group-item-action bg-light">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit"
                        class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Uitloggen</button>
                </form>
            </li>
        </ul>
    </div>
</div>
