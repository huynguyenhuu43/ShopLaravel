                           
                                <!-- Form-Fields /- -->
                                <h4 class="section-h4 deliveryText">Thêm địa chỉ giao hàng</h4>
                                <div class="u-s-m-b-24">
                                    <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
                                    @if(count($deliveryAddresses)>0)
                                    <label class="label-text newAddress" for="ship-to-different-address">Ship to a different address?</label>
                                    @else
                                    <label class="label-text newAddress" for="ship-to-different-address">Check to add Delivery Address</label>
                                    @endif
                                </div>
                                <div class="collapse" id="showdifferent">
                                    <!-- Form-Fields -->
                                    <form id="addressAddEditForm" action="javascript:;" method="post">@csrf
                                        <input type="hidden" name="delivery_id">
                                        <div class="group-inline u-s-m-b-13">
                                            <div class="group-1 u-s-p-r-16">
                                                <label for="first-name-extra">Tên
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="delivery_name" id="delivery_name" class="text-field">
                                            </div>
                                            <div class="group-2">
                                                <label for="last-name-extra">Địa chỉ
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="delivery_address" id="delivery_address" class="text-field">
                                            </div>
                                        </div>
                                    
                                            <div class="group-1 u-s-p-r-16">
                                                <label for="first-name-extra">Quận/Huyện
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="delivery_state" id="delivery_state" class="text-field">
                                            </div>
                                            <div class="group-2">
                                                <label for="last-name-extra">Tỉnh/Thành phố
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="delivery_city" id="delivery_city" class="text-field">
                                            </div>
                                            <div class="group-2">
                                                <label for="last-name-extra">Quốc gia
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="delivery_country" id="delivery_country" class="text-field">
                                            </div>
                                        <div class="group-inline u-s-m-b-13">     
                                        <div class="group-2">
                                                <label for="phone-extra">Mã vùng
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="delivery_zipcode" id="delivery_zipcode" class="text-field">
                                            </div>
                                            <div class="group-2">
                                                <label for="phone-extra">Số điện thoại
                                                    <span class="astk">*</span>
                                                </label>
                                                <input type="text" name="delivery_mobile" id="delivery_mobile" class="text-field">
                                            </div>
                                            
                                        </div>
                                        <div class="group-2">
                                                <button type="submit" class="button button-outline-secondary">Lưu</button>
                                            </div><br>
                                    </form>
                                    <!-- Form-Fields /- -->
                                    
                                </div>
                                <div>
                                    <label for="order-notes">Order Notes</label>
                                    <textarea class="text-area" id="order-notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>
                          