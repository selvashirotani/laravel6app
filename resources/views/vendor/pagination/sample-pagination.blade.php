@if ($paginator->hasPages())
<ul class="pagination" role="navigation">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <!-- 最初のページの場合、前へをつけない。 -->
        
    @else
        <!-- 最初のページ以外なら前へをつける。 -->
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><< 前へ</a>
        </li>
    @endif

    <?php
        $start = $paginator->currentPage() - 1; // show 3 pagination links before current
        $end = $paginator->currentPage() + 1; // show 3 pagination links after current
        if($start < 1) {
            $start = 1; // reset start to 1
            $end += 1;
        } 
        if($end > $paginator->lastPage() ){
            if(3 > $paginator->lastPage() ){
                $end = $paginator->lastPage(); // reset end to last page
            }else{
                $start -= 1;
                $end = $paginator->lastPage(); // reset end to last page
            }
        } 
    ?>


        @for ($i = $start; $i <= $end; $i++)
            @if($i == $paginator->currentPage())
                <li class="page-now {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    {{$i}}
                </li>
            @else
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($i) }}">{{$i}}</a>
                </li>
            @endif
        @endfor


    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">次へ >></a>
        </li>
    @else
        
    @endif
</ul>
@endif