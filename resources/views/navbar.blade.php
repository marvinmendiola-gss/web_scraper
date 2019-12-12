<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="{{ route('dashboard') }}">Web Scraper</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
        <form class="form-inline mt-2 mt-md-0 ml-auto" action="{{ route('scrape') }}" method="post">
            @csrf
            <label class="navbar navbar-brand">Page: </label>
            <input class="form-control mr-sm-2" type="text" placeholder="From" name="page_first">
            <input class="form-control mr-sm-2" type="text" placeholder="To" name="page_last">
            <button class="btn btn-outline-success m-2 my-sm-0" type="submit">Get It</button>
            @if(!empty($result))
                <a href="#collapseExample" class="btn btn-outline-info my-2 my-sm-0" data-toggle="collapse">Export</a>
                <div class="collapse ml-2" id="collapseExample">
                        <a href="{{ route('export', ['extension' => 'csv']) }}" class="btn btn-outline-primary my-2 my-sm-0">CSV</a>
                        <a href="{{ route('export', ['extension' => 'xlsx'])}}" class="btn btn-outline-primary my-2 my-sm-0">xlsx</a>
                </div>
            @endif
		</form>
	</div>
</nav>
