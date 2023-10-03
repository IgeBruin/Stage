<div class="col-md-2 mb-md-0 mb-4">
    <div class="d-flex flex-column justify-content-start align-items-center h-100">
        <ul class="list-group text-center">
            <li class="list-group-item bg-light">
                <a href="{{ route('dashboard.articles.index') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Artikelen</a>
            </li>
            <li class="list-group-item bg-light">
                <a href="{{ route('dashboard.products.index') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Producten</a>
            </li>
            <li class="list-group-item bg-light">
                <a href="{{ route('dashboard.categories.index') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Categorieën</a>
            </li>
            <li class="list-group-item bg-light">
                <a href="{{ route('dashboard.projects.index') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Projecten</a>
            </li>
            <li class="list-group-item bg-light">
                <a href="{{ route('dashboard.roles.index') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Rollen</a>
            </li>
            <li class="list-group-item bg-light">
                <a href="{{ route('dashboard.statuses.index') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Status</a>
            </li>
            <li class="list-group-item bg-light">
                <a href="{{ route('dashboard.specifications.index') }}"
                    class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Specificaties</a>
            </li>
            <li class="list-group-item bg-light">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit"
                        class="btn btn-light btn-block text-decoration-none fw-bold fs-5 text-dark menu-item">Uitloggen</button>
                </form>
            </li>
        </ul>
    </div>
</div>
