<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="createModalLabe" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabe">
              @if (request()->routeIs('user.create.product'))
                  {{ __('Thêm sản phẩm')}}
              @else
                  {{ __('Chỉnh sửa sản phẩm')}}
              @endif
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container-fluid">
            <div class="row row-cols-2">
              <div class="col mt-3">Avatar</div>
              <div class="col mt-3">
                  <img alt="avatar" id="modal-avatar" class="img-product" width="70px" height="70px">
              </div>
              <div class="col mt-3">Name</div>
              <div class="col mt-3" id="modal-name"></div>
              <div class="col mt-3">Sku</div>
              <div class="col mt-3" id="modal-sku"></div>
              <div class="col mt-3">Stock</div>
              <div class="col mt-3"id="modal-stock"></div>
              <div class="col mt-3">Exprired at</div>
              <div class="col mt-3" id="modal-exprired-at"></div>
              <div class="col mt-3">Category</div>
              <div class="col mt-3" id="modal-category"></div>
            </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

