@if ($paginator->onFirstPage())
    <div class="pagination--first">
@else
    <div class="pagination">
@endif
        @if (!$paginator->onFirstPage())
            <a class="button__paginator" href="{{$paginator->previousPageUrl()}}" rel="next"><i class="bi bi-arrow-left button__paginator--inner"></i>{{ucfirst(__("Previous"))}}</a>
        @endif
        @if (!$paginator->onLastPage())
        <a class="button__paginator" href="{{$paginator->nextPageUrl()}}" rel="next">{{ucfirst(__("Next"))}} <i class="bi bi-arrow-right button__paginator--inner"></i></a>
        @endif
    </div>
