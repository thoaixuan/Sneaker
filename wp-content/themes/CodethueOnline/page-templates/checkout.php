<?php
/**
 * template name: Checkout
 */
get_header(); ?>
<div class="container">
    <div class="row-codethue cart-checkout">
        <div class="col-codethue-12">
            <div class="modal-body">
                <div><h1>Xác nhận đơn hàng</h1></div>
                <table class="show-cart table">   
                </table>
                <form>
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Mã ưu đãi :</label>
                        <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Mã ưu đãi nếu có">
                        </div>
                        <div class="col-sm-3"><button type="submit" class="btn btn-primary mg-bot-20">Xác nhận <i class="fa fa-gift"></i></button></div>
                    </div>
                    
                </form>
                <div>Tổng: <span class="total-cart"></span> VNĐ</div>
            </div>
            <hr/>
            <div><h1>Thông tin giao hàng</h1>
            <form>
                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Họ tên *</label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control form-control-sm" placeholder="Họ và tên">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="colFormLabel" class="col-sm-2 col-form-label">Email </label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control" id="colFormLabel" placeholder="Email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Số điện thoại *</label>
                    <div class="col-sm-10">
                    <input type="email" class="form-control form-control-lg" placeholder="Số điện thoại">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Địa chỉ *</label>
                    <div class="col-sm-10">
                    <textarea class="form-control form-control-lg" placeholder="Địa chỉ giao hàng"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Ghi chú thêm</label>
                    <div class="col-sm-10">
                    <textarea class="form-control form-control-lg" placeholder="Thông tin thêm"></textarea>
                    </div>
                </div>
                <div class="mg-bot-20 text-right"><button type="submit" class="btn hover--primary__Color btn-success btn-lg">ĐẶT HÀNG<i class="ps-icon-next"></i></button></div>
            </form>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>