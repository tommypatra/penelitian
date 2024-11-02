@extends('akun.template')

@section('head')
<title>Akun</title>
@endsection

@section('container')
<div class="page-inner">
  <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    <div>
      <h3 class="fw-bold mb-3">Dashboard Permanen</h3>
      <h6 class="op-7 mb-2">Apps LPPM IAIN Kendari</h6>
    </div>
    {{-- <div class="ms-md-auto py-2 py-md-0">
      <a href="#" class="btn btn-label-info btn-round me-2">Menu1</a>
      <a href="#" class="btn btn-primary btn-round">Menu2</a>
    </div> --}}
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card card-round">
        <div class="card-header">
          <div class="card-head-row card-tools-still-right">
            <h4 class="card-title">Permanen IAIN Kendari</h4>
            <div class="card-tools">
              <button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card">
                <span class="fa fa-sync-alt"></span>
              </button>
            </div>
          </div>
          <p class="card-category">
            Dashboard
          </p>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('modal')
@endsection

@section('script')
@endsection