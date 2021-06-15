<template>
    <div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Coupon No</label>
                    <input type="text" class="form-control" name="coupon_no" v-model="coupon_no" placeholder="">
                    <label class="isCoupon" v-if="isCoupon">{{isCoupon}}</label>
                    <label class="coupon_message" v-if="grand_total">{{ "Pay total "+grand_total+" TK" }}</label>
                </div>
                <div class="col-md-6">
                    <label>Alternative Phone No</label>
                    <input type="text" class="form-control" name="alt_mobile" v-model="alt_mobile" placeholder="Alternative Phone No">
                </div>
            </div>
        </div>
        <div class="form-group row">

            <div class="col-md-6">
                <label>District <span class="text-danger">*</span></label>
                <select name="district_id" class="form-control m-0" v-model="district_id">
                    <option v-for="district in districts" :value="district.id">{{ district.name }}</option>
                </select>
            </div>


            <div class="col-md-6">
                <label>Area <span class="text-danger">*</span></label>
                <i v-if="area_check" class="fas fa-spinner fa-pulse fa-1x fa-fw"></i>
                <select name="upazilla_id" class="form-control m-0" v-model="upazilla_id">
                    <option :value="user_upazilla.id">{{ user_upazilla.name }}</option>
                    <option v-for="upazilla in upazillas" :value="upazilla.id">{{ upazilla.name }}</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Payment By</label>
                    <select name="payment_gateway_id" class="form-control m-0" v-model="gateway_id">
                        <option v-for="gateway in payment_gateway" :value="gateway.id">{{ gateway.title }}</option>
                    </select>
                    <span v-if="payment_mobile_no" style="color:red;padding: 5px;"><strong>{{ payment_mobile_no }}</strong></span>
                </div>
                <div class="col-md-6" v-if="payment_mobile_no">
                    <div class="row px-3">
                        <div class="col-md-5 p-0 pr-1">
                            <label>TxnId</label>
                            <input type="txnid" class="form-control" name="txnid" v-model="txnid" placeholder="TxnId">
                        </div>
                        <div class="col-md-7 p-0">
                            <label>Amount</label>
                            <input type="text" class="form-control" name="tx_amount" v-model="tx_amount" placeholder="Send Amount">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Shipping Address</label>
            <textarea type="text" class="form-control" name="address" v-model="address" placeholder="Address"></textarea>
        </div>

        <div class="button-group">
            <input type="button" name="go_to_payment" id="" class="btn btn-success float-right" value="Submit" @click="continuePayment">
        </div>
    </div>
</template>

<script>
    export default {
        name: "Payment",
        props: {
            districts: {
                type: Array,
                required: true
            },
            payment_gateway: {
                type: Array,
                required: true
            },
            user_id: {
                type: Number,
                required: true
            },
            order_total: {
                type: Number,
                required: true
            },
            shipping_cost: {
                type: Number,
                required: true
            },
            user: {
                type: Object,
                required: true
            },
            user_upazilla: {
                type: Object,
                required: true
            },
            user_district: {
                type: Object,
                required: true
            },
        },
        data(){
            return {
                upazillas           : [],
                coupon_no           : '',
                alt_mobile          : this.user.mobile,
                district_id         : this.user_district.id,
                upazilla_id         : this.user_upazilla.id,
                gateway_id          : '',
                txnid               : '',
                address             : (this.user.address != "N/A" ? this.user.address : "") ,
                isCoupon            : false,
                coupon_category     : '',
                grand_total         : '',
                my_total            : '',
                upazilla_shipping_cost: '',
                coupon_discount     : '',
                area_check          : false,
                payment_mobile_no   : '',
                discount_tk         : '',
                tx_amount           : '',
            }
        },
        methods: {
            continuePayment: function(){
                if(this.alt_mobile == ''){
                    this.alt_mobile = this.user.mobile;
                }
                var txnId = (this.payment_mobile_no != null ? (this.txnid!=''?(this.tx_amount!=''?true:false):false) : true);
                if(this.address != null && this.gateway_id != '' && txnId && this.district_id!='' && this.upazilla_id!=''){
                    // this.address = this.user.address;
                    axios.post(this.$store.state.front_url+'/checkout/with/payment', {
                        alt_mobile          : this.alt_mobile,
                        txnid               : this.txnid,
                        tx_amount           : this.tx_amount,
                        payment_gateway_id  : this.gateway_id,
                        district_id         : this.district_id,
                        upazilla_id         : this.upazilla_id,
                        address             : this.address,
                        coupon_category     : this.coupon_category,
                        user_id             : this.user_id,
                        grand_total         : this.grand_total,
                        coupon_discount     : this.coupon_discount,
                        shipping_cost       : this.upazilla_shipping_cost,
                        order_total         : this.order_total
                    })
                    .then((response) => {
                        toastr.success("Order has been placed successfully");
                        window.location.href = this.$store.state.front_url+"/order/detail/"+response.data;
                    })
                    .catch((exception) => {
                       console.log(exception);
                    });

                }
                else if(this.gateway_id == ''){
                    toastr.warning("Select a payment getway ☹ !");
                }
                else if(this.address==''){
                    toastr.warning("Address field must not be empty ☹ !");
                }
                else if(this.txnid==''){
                    toastr.warning("Please Give Your Txn id");
                }
                else if(this.tx_amount==''){
                    toastr.warning("Please Give Your Send Amount");
                }
                else{
                    toastr.warning("Please Check Your All Information!!");                    
                }
            }
        },
        mounted(){
            this.upazilla_shipping_cost = this.shipping_cost;
            this.my_total = this.order_total;
            if(this.upazilla_id != ""){
                axios.post(this.$store.state.front_url+'/get-shipping_cost',{
                    upazilla_id: this.upazilla_id,
                    }).then((response) => {
                        this.grand_total -= parseFloat(this.upazilla_shipping_cost);
                        this.upazilla_shipping_cost = parseFloat(response.data.shipping_cost);
                        this.grand_total = this.my_total + this.upazilla_shipping_cost - this.coupon_discount;
                        
                        this.$store.commit('setShippingCost', {
                            shipping_cost: parseFloat(this.upazilla_shipping_cost)
                        });

                        this.$store.commit('setTotalInCheckout', {
                            total: this.grand_total
                    });
                }).catch((e) => {
                    console.log(e);
                });
            } 
        },
        watch: {
            gateway_id: function()
            {
                let gateway_id = this.gateway_id;
                var payment_gateway = this.payment_gateway;

                for(let i = 0; payment_gateway.length > i; i++){
                    if(payment_gateway[i].id == gateway_id){
                        this.payment_mobile_no = payment_gateway[i].payment_mobile_no;
                    }
                }
            },
            tx_amount:function(){
                this.$store.state.paid = this.tx_amount;
            },
            district_id: function()
            {
                this.area_check = true;
                axios.post(this.$store.state.front_url+'/get-all-upazillas', {
                    district_id: this.district_id
                })
                .then((response) => {
                    this.area_check = false;
                    this.upazillas = response.data;
                })
                .catch((exception) => {
                    console.log(exception);
                });
            },
            coupon_no: function () 
            {
                if(this.coupon_no != null || this.coupon_no != ''){
                    axios.post(this.$store.state.front_url+'/get-coupon',{
                        couponNumber    : this.coupon_no,
                        user_id         : this.user_id,
                        order_total     : this.order_total
                    }).then((response) => {
                        if(response.data == "not available" || response.data == "already used"){
                            this.isCoupon        = "Invalid";
                            this.grand_total     = 0;
                            this.coupon_discount = '';
                            this.$store.state.couponDiscount = 0;
                            this.$store.commit('setShippingCost', {
                                shipping_cost: this.upazilla_shipping_cost
                            });

                            this.$store.commit('setTotalInCheckout', {
                                total: this.order_total + this.upazilla_shipping_cost
                            });
                        }else{
                            this.isCoupon = false;

                            let grand_total  = (this.my_total + this.upazilla_shipping_cost);

                            let discount_tk  = 0;

                            if(response.data.min_amount <= grand_total){
                                discount_tk     = ((grand_total/100)*response.data.discount) + +response.data.taka;
                                this.isCoupon   = false;
                                this.grand_total = (grand_total-discount_tk);
                                this.$store.state.couponDiscount = discount_tk;
                            }else{
                                this.isCoupon    = "You Have To Spend "+response.data.min_amount+" Or More to use it";
                                this.grand_total = grand_total;
                            }

                            this.coupon_discount = parseFloat((discount_tk/grand_total)*100).toFixed(2);

                            this.discount_tk = discount_tk;

                            this.coupon_category = response.data.category;

                            this.$store.commit('setShippingCost', {
                                shipping_cost: this.upazilla_shipping_cost
                            });

                            this.$store.commit('setTotalInCheckout', {
                                total: this.grand_total
                            });
                        }

                    }).catch((e) => {
                        console.log(e);
                    });
                }
                else{
                    this.$store.commit('setShippingCost', {
                        shipping_cost: this.upazilla_shipping_cost
                    });

                    this.$store.commit('setTotalInCheckout', {
                        total: this.order_total + this.upazilla_shipping_cost
                    });
                }
            },
            upazilla_id: function(){
                axios.post(this.$store.state.front_url+'/get-shipping_cost',{
                    upazilla_id: this.upazilla_id,
                }).then((response) => {
                    this.grand_total -= parseFloat(this.upazilla_shipping_cost);

                    this.upazilla_shipping_cost = parseFloat(response.data.shipping_cost);

                    this.grand_total = (this.my_total + this.upazilla_shipping_cost) - this.discount_tk;

                    this.$store.commit('setShippingCost', {
                        shipping_cost: parseFloat(this.upazilla_shipping_cost)
                    });

                    this.$store.commit('setTotalInCheckout', {
                        total: this.grand_total
                    });
                }).catch((e) => {
                    console.log(e);
                });
            }
        }
    }
</script>

<style scoped>
    .isCoupon{
        color: red;
        margin: 5px 0;
    }
    .coupon_message{
        color: green;
        margin: 5px 0;
    }
</style>
