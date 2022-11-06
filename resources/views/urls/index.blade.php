@extends('layout')

@section('content')
    <div class="col-12">
        <h1 class="text-center mb-5">Short URL</h1>
        @if (session('short_url'))
            <div class="alert alert-success" role="alert">
                Your shortened url has been deleted!
            </div>
        @endif
        <div class="mb-2 text-right">
            <a class="btn btn-sm btn-primary" href="{{ route('url.create') }}" role="button">Add url</a>
        </div>
        <table class="table">
            <tr>
                <th>Url</th>
                <th>Short Url</th>
                <th>Counter</th>
                <th>Status</th>
                <th>User</th>
                <th>Action</th>
            </tr>
            @foreach ($urls as $url)
                <tr>
                    <td>{{ $url->url }}</td>
                    <td><a href="{{ route('url.redirect', $url->code) }}">{{ $url->code }}</a></td>
                    <td>{{ $url->counter }}</td>
                    <td>{{\Carbon\Carbon::parse($url->expires_at)->isFuture() ? 'Online' : 'Link Expired'}}</td>
                    <td>{{ optional($url->user)->name }}</td>
                    <td>
                        <button class="btn btn-sm btn-success" data-clipboard-text="{{ route('url.redirect', $url->code) }}">Copy</button>
                        <a class="btn btn-sm btn-primary" href="{{ route('url.edit', $url->id) }}" role="button">Edit</a>
                        <form method="POST" action="{{ route('url.destroy', $url->id) }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-sm btn-danger" href="#" role="button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection

@push('styles')
    <style>
        form {
            display: inline-block;
        }
        .wrapper {
            min-height: 100vh;
        }
        .pagination {
            justify-content: flex-end;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        let clipboard = new ClipboardJS('.btn-success');

        clipboard.on('success', function(e) {
            e.trigger.innerText = 'Copied!';
        });
    </script>
@endpush
