<template>
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center">
            <pulse-loader :loading="this.loading" ></pulse-loader>
        </div>
        <div class="row justify-content-center">
            <table class="table table-bordered">
                <thead>
                    <tr scope="col"  class="table-secondary">
                        <th scope="col">Produto</th>
                        <th scope="col">Unidade</th>
                        <th scope="col">Total</th>
                        <th class="toFor" v-for="(month, key) in months" :key="key">   
                            <span class="badge bg-success spn" v-if="month.publications_count == 0" @click="showAddModal(month)">                           
                                <div class="months">{{month.month}}</div>
                            </span>
                            <span v-else class="badge bg-danger spn">                           
                                <div class="months">{{month.month}}</div>
                            </span>
                        </th>
                    </tr>
                   
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products" :key="index">                       
                        <td class="title">{{product.name}}</td>   
                        <td>{{product.unity}}</td>   
                        <td>{{product.quantity}}</td>   
                        <td class="values" v-for="(pub, key) in product.publications" :key="key">    
                            {{pub.quantity + " ID "+ pub.month_id}}
                        </td>  
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- MODAL-->
        <modal-component
        v-if="displayModal"
        :products="products"
        :month="selectedMonth"
        @save-product-event="saveProduct"
        @close-modal-event="hideModal"
        ></modal-component>
    </div>
</template>
<style scoped>
.spn {
    width: 70px;
}
.month {
        color: blue;
    }
    .title {
        font-weight: bold; 
    }
    .values {
        background-color: azure;
    }
</style>

<script>
    import ModalComponent from '../components/ModalComponent.vue';
    import PulseLoader from "vue-spinner/src/PulseLoader.vue"; //https://www.npmjs.com/package/vue-spinner
    import axios from 'axios';

    export default {
    name: "Tests",
    components : {
        ModalComponent,
        PulseLoader
    },
    data() {
        return {
        selectedMonth: Object,
        response: false,
        months: [],
        products: [],
        displayModal: false
        };
    }, 
    methods: {
        getMonths(){
            this.loading = true;
            axios.get('http://localhost/companymanage/public/api/get-months')
            .then((response)=>{
                this.loading = false;
                this.months = response.data.months;
                console.log("RESP: " + JSON.stringify(response.data.months))
            });
        },
        getProducts(){
            this.loading = true;
            axios.get('http://localhost/companymanage/public/api/get-products')
            .then((response)=>{
                this.loading = false;
                this.products = response.data.products
                console.log("RESP: " + JSON.stringify(response.data.products)) 
            });
        },
      showAddModal(month) {
        console.log("TOTAL: "+month.publications_count)
        this.selectedMonth = month;
        this.displayModal = true;
      },
      hideModal() {
        this.getProducts();
        this.getMonths();
        this.displayModal = false;
      },
    },
    mounted() {
        this.getMonths()
        this.getProducts()
        console.log('Component mounted.')
    }
}
</script>
