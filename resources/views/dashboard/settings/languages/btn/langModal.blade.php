<div class="modal fade" id="langModal{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title white" id="langModal{{ $key }}">
                    <strong>Language Details</strong> {{ $language['native'] }}
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Start Language Informations -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-bold">
                            <div class="text-bolder badge badge-pill badge-{{ $language['status'] ? 'success' : 'danger' }}">{{ $key }}</div>
                        </h5>
                        <p class="text-center">
                            <strong class="text-primary">Name:</strong> {{ $language['name'] }}
                            <span style="margin: 0 5px;"></span>
                            <strong class="text-primary">Regional Name:</strong> {{ $language['regional'] }}
                            <span style="margin: 0 5px;"></span>
                            <strong class="text-primary">Native:</strong> {{ $language['native'] }}
                        </p>
                        <p class="text-center">
                            <strong class="text-primary">Language Script:</strong> {{ $language['script'] }}
                            <span style="margin: 0 10px;"></span>
                            <strong class="text-primary">Status:</strong>
                            {!! $language['status'] ? ' <i class="fa fa-check-circle text-success"></i> '. 'Active' : ' <i class="fa fa-times-circle text-danger"></i> '. 'Inactive' !!}
                            <span style="margin: 0 10px;"></span>
                            <strong class="text-primary">Code:</strong> {{ $key }}
                        </p>
                    </div>
                </div>
                <!-- End Language Informations -->
                <!-- Start Second Div For Language Fearures -->
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="form-group text-center">
                            @if ($language['status'] == 1)
                                <form action="{{ route('languages.check' , $key) }}" method="GET">
                                    @csrf
                                    <button class="btn btn-dark mb-1 mr-1 waves-effect waves-light">
                                        <i class="fa fa-check"></i>
                                        Sync
                                    </button>
                                </form>
                            @endif

                                <!-- start Loader -->
                                <div class="loader-wrapper d-none">
                                    <div class="loader-container">
                                        <div class="chasing-dots loader-brown">
                                            <div class="child dot1"></div>
                                            <div class="child dot2"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- End Second Div For Language Fearures -->
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-warning" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
