<template>
    <div>
        <div class="container pb-5 pt-5">

            <ul class="nav nav-tabs">
                <li class="nav-item" @click="visibleProfile">
                    <a class="nav-link active cursor-pointer">My Profile</a>
                </li>
                <li class="nav-item" @click="visibleOrder">
                    <a class="nav-link cursor-pointer">My Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link cursor-pointer" @click="visibleWishList">My Wishlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link cursor-pointer" @click="visibleReturned">Returned products</a>
                </li>
            </ul>

            <div class="col-md-12 border border-top-0 pt-3 pb-3 bg-white" v-if="active == 'profile'">
                <Profile :auth="auth"></Profile>
            </div>

            <div class="col-md-12 border border-top-0 pt-3 pb-3 bg-white" v-if="active == 'order'">
                <Order :auth="auth"></Order>
            </div>

            <div class="col-md-12 border border-top-0 pt-3 pb-3 bg-white" v-if="active == 'wish_list'">
                <WishList></WishList>
            </div>

            <div class="col-md-12 border border-top-0 pt-3 pb-3 bg-white" v-if="active == 'return_list'">
                <ReturnedProduct></ReturnedProduct>
            </div>

            <!-- <div class="col-md-12" style="margin-top: 65px;" v-if="active == 'order_track'">
                <OrderTrack></OrderTrack>
            </div> -->

        </div>
    </div>
</template>

<script>
import Profile from './Profile';
import Order from './Order';
// import OrderTrack from './OrderTrack';
import List from './List';
import WishList from './WishList';
import ReturnedProduct from './ReturnedProduct';

export default {
    name: "Parent",
    props: {
        auth: {
            type: Object,
            required: true
        }
    },
    data(){
        return {
            active: 'profile'
        }
    },
    methods: {
        visibleProfile: function(){
            this.active = "profile";
        },
        visibleOrder: function(){
            this.active = "order";
        },
        visibleList: function(){
            this.active = "list";
        },
        visibleWishList: function(){
            this.active = "wish_list";
        },
        visibleReturned: function(){
            this.active = "return_list";
        },
        // visibleOrderTrack: function(){
        //     this.active = "order_track";
        // }
    },
    mounted(){
        this.url = this.$store.state.front_url;
    },
    components: {
        Profile,
        Order,
        // OrderTrack,
        List,
        WishList,
        ReturnedProduct
    }
}
</script>

<style scoped>

</style>
