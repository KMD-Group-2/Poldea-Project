@if ($paginator->hasPages())
    <div class="d-flex align-items-center ml-3">
        @if ($paginator->onFirstPage())
        <a href="javascript:void(0)" class="mr-1" rel="prev" style="width: 20px; height:20px;">
                <svg width="20" height="20" viewBox="0 0 20 20" class="mr-1" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0C4.48 0 0 4.48 0 10ZM10 9H14V11H10V14L6 10L10 6V9Z"
                        fill="#CECFD8" />
                </svg>
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="mr-1" rel="prev" style="width: 20px; height:20px;">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0C4.48 0 0 4.48 0 10ZM10 9H14V11H10V14L6 10L10 6V9Z"
                        fill="#B6B6BB" />
                </svg>
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="ml-1" rel="next" style="width: 20px; height:20px;">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 10C20 15.52 15.52 20 10 20C4.48 20 0 15.52 0 10C0 4.48 4.48 0 10 0C15.52 0 20 4.48 20 10ZM10 9H6V11H10V14L14 10L10 6V9Z"
                        fill="#B6B6BB" />
                </svg>
            </a>
        @else
        <a href="javascript:void(0)" class="ml-1" rel="next" style="width: 20px; height:20px;">
                <svg width="20" height="20" class="ml-1" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20 10C20 15.52 15.52 20 10 20C4.48 20 0 15.52 0 10C0 4.48 4.48 0 10 0C15.52 0 20 4.48 20 10ZM10 9H6V11H10V14L14 10L10 6V9Z"
                        fill="#CECFD8" />
                </svg>
            </a>
        @endif
    </div>
@endif
