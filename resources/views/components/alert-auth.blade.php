<div>
    <div class="col-md-6 col-lg-4 mx-sm-0 alert alert-dismissible shadow-lg text-wrap fade show action-alert hstack g-2 align-items-start" style="position: fixed; bottom: 0px; right: 22px; margin-left: 28px; background-color: #fff9a6" role="alert" id="myAlert">
        <i class="bi bi-check-circle-fill header-color text-warning fs-5 me-2"></i>
        <div class="ps-1">
            <strong class="header-message text-warning">Warning!</strong>
            <p class="m-0 text-dark body-alert">{{ session('errorAuth') }}</p>
        </div>
        <button type="button" class="btn-close small" data-dismiss="alert" aria-label="Close"></button>
    </div>
</div>