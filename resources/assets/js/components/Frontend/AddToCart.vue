<template>
    <div style="position: static;">
        <div class="cart-button">
            <div>
                <!-- <button class="btn btn-success btn-sm float-right mt-1 cursor-pointer w-100" @click="product_details(product)"><i class="fa fa-fw fa-shopping-cart"></i> Product Details </button> -->
                <!-- <button class="cartAnimationStart product_cart_button"><i class="fa fa-fw fa-shopping-cart"></i> Buy Now</button>
                <button class="btn btn-success cr-button cartAnimationStart" title="Add to cart."><i class="fa fa-fw fa-shopping-cart"></i> Buy Now</button> -->
            <a v-bind:data-img="JSON.parse(product.image)[0]" class="btn btn-success btn-sm float-right mt-1 cursor-pointer w-100 text-center" style="text-transform: uppercase;color: #fff;" @click="openCard(product)" v-if="hover_product == 0"> <span>Add To Cart</span></a>
            <a v-bind:data-img="JSON.parse(product.image)[0]" class="product_cart_button" @click="product_details(product)" v-if="hover_product == 1"> <span class="p-details">Product Details</span></a>
            <a v-bind:data-img="JSON.parse(product.image)[0]" class="btn btn-success cr-button" style="color: #fff;"  @click="openCard(product)" v-if="hover_product == 2">Add To Cart</a>
                <!-- cartAnimationStart -->
            </div>
        </div>
        <div style="position: static;"> 
            <a v-bind:data-img="JSON.parse(product.image)[0]" class="____middle_cart___ text-center" style="text-transform: uppercase;" @click="product_details(product)" v-if="hover_product == 2">  <span class="p-details">Product Details</span></a>
        </div>
        <div class="colors-sizes card" v-if="card">
            <div class="card-body">
                <h4>Choice Color And Size</h4>
                <!-- <form class="form-horizontal"> -->
                    <div class="form-group">
                        <select class="form-control m-0 mt-4" v-model="color_id">
                            <option value="">-- Select a Color -- </option>
                            <option value="" v-for="color in colors" :value="color.id" v-if="product_colors ? product_colors.map(x=>+x).indexOf(color.id)>-1 : false"> {{color.title}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control m-0 mt-4" v-model="size_id">
                            <option value="">-- Select a Size --</option>
                            <option value="" v-for="size in sizes" :value="size.id" v-if="product_sizes ? product_sizes.map(x=>+x).indexOf(size.id)>-1 : false">{{size.title}}</option>
                        </select>
                    </div>
                    <div class="btn-group float-right">
                        <button type="submit" class="btn btn-primary" @click="addToCart(product)">Add To Cart</button>
                    </div>
                <!-- </form> -->
              <button class="close_btn" @click="close">&times;</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddToCart",
        props: {
            hover_product: {
                type: Number,
                required: true
            },
            product: {
                type: Object,
                required: true
            }
        },
        data(){
            return {
                color_id: '',
                size_id : '',
                colors  : [],
                sizes   : [],
                product_colors  : [],
                product_sizes   : [],
                card    : false,
            }
        },
        mounted(){
            axios.post(this.$store.state.front_url+'/shop/color')
            .then(response=>{
               this.colors = (response.data);
            })
            .catch((exception) => {
                console.log(exception);
            });
            axios.post(this.$store.state.front_url+'/shop/size')
            .then(response=>{
               this.sizes = (response.data);
            })
            .catch((exception) => {
                console.log(exception);
            });
        },
        methods: {
            addToCart: function(product){
                this.product_colors = (this.product_colors).filter(x=>{
                    if(x!='')
                        return x;
                 });

                 this.product_sizes = (this.product_sizes).filter(x=>{
                    if(x!='')
                        return x;
                 });

                var isSubmit = (this.card ? (((this.product_colors).length == 0 || this.color_id != '') && ((this.product_sizes).length == 0 || this.size_id != '')) :true);
                if(isSubmit){
                    this.card   = false;
                    axios.post(this.$store.state.front_url+'/add-to-cart', {
                        product_id      : product.id,
                        product_name    : product.title,
                        product_price   : (product.regular_price - product.discount_flat),
                        // product_discount: product.discount,
                        product_discount: 0,
                        min_quantity    : product.min_sale_quantity,
                        color_id        : this.color_id,
                        size_id         : this.size_id,
                        product_image   : product.feature_photo,
                        // product_image   : JSON.parse(product.image)[0],
                    })
                    .then((response) => {
                        toastr.success("Item has been added");
                        if(window.innerWidth > 768){
                            this.$store.state.cartButton = true;
                        }else{
                           this.$store.state.cartButton = false;  
                        }
                        // commit for push to vuex
                        this.$store.commit('setCart', {
                            cartItems: response.data.cart,
                            cartCount: response.data.count
                        });

                        this.$store.commit('setTotal', {
                            total: response.data.total
                        });
                    })
                    .catch((exception) => {
                       console.log(exception);
                    });
                }else{
                    if((this.product_colors).length == 0 || this.color_id == ''){
                        toastr.warning('Please Select A Color...!');
                    }
                    if((this.product_sizes).length == 0 || this.size_id == ''){
                        toastr.warning('Please Select A Size....!');
                    }
                }
            },
            product_details:function(product){
                window.location.href=window.location.origin+'/product/'+product.slug;
            },
            openCard:function(product){
                if(product.size_id){
                    this.product_sizes  = (JSON.parse(product.size_id));                    
                }
                else{
                    this.product_sizes  = [];                    
                }
                if(product.color_id){
                    this.product_colors = (JSON.parse(product.color_id)); 
                }
                else{
                    this.product_colors = []; 
                }
                this.product_colors = (this.product_colors).filter(x=>{
                    if(x!='')
                        return x;
                });

                this.product_sizes = (this.product_sizes).filter(x=>{
                    if(x!='')
                        return x;
                });


                let add     = true;
                let myCarts = this.$store.state.myCarts;
                for(const rowId in myCarts)
                {
                    if(myCarts[rowId].id == product.id){

                        axios.post(this.$store.state.front_url + '/update_cart_qty', {
                            rowId   : rowId,
                            qty     : +(myCarts[rowId].qty)+1
                        })
                        .then((response) => {
                            this.$store.commit('setCart', {
                                cartItems: response.data.cart,
                                cartCount: response.data.count
                            });

                            this.$store.commit('setTotal', {
                                total: response.data.total
                            });
                        })
                        .catch((exception) => {
                            console.log(exception);
                        });
                        add = false;
                    }
                }

                if((this.product_sizes.length != 0 || this.product_colors.length!=0) && add){
                    this.card = true;
                }else if(add){
                    this.addToCart(product);
                    this.card = false;
                }
            },
            close:function(){
                this.card = false;
                this.color_id = '';
                this.size_id = '';
            }
        },
        computed: {

        }
    }
</script>

<style scoped>
    .colors-sizes{
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        z-index: 999;
        height: 250px;
        box-shadow: 1px 0px 18px -5px #000;
        width: 25%;
    }
    .close_btn{
        position: absolute;
        top: 5px;
        right: 5px;
        background: #fff;
        border: 1px solid #8e8d8d;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        font-size: 20px;
        line-height: 20px;
        font-weight: bolder;
        cursor: pointer;
    }
    .close_btn:hover{
        color: #f00;
        border-color: #f00;
    }
    @media only screen and (max-width: 992px) {
        .colors-sizes{
            width: 33%;
        }
    }
    @media only screen and (max-width: 768px) {
        .colors-sizes{
            width: 41%;
        }
    }
    @media only screen and (max-width: 580px) {
        .colors-sizes{
            width: 70%;
        }
    }
    @media only screen and (max-width: 360px) {
        .colors-sizes{
            width: 80%;
        }
    }
</style>
