<div>
    <div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-3 py-2">
                <div class="modal-header border-0 p-0 pt-2">
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-2">
                    <h1 class="fw-bold" id="exampleModalLabel">
                        <i class="{{ $icon }} pe-2" style="font-size: 32px;"></i>
                    </h1>
                    <h4 class="py-2">{{ $title }}</h4>
                    {!! $body !!}
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    {!! $slot !!}
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal " id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <i class="{{ $icon }} pe-2 fs-4"></i>
                    <span>{{ $title }}</span>
                 </h5>
                 <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">{{ $body }}</div>
            <div class="modal-footer d-flex justify-content-between">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                {!! $slot !!}
            </div>
            </div>
        </div>
    </div> --}}
</div>