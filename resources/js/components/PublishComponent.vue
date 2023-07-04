<template>
    <div class="container">

        <div class="row">
            <div class="col-5" >
                <h2>Dados de Produção ({{ currentYear }})</h2>
            </div>
            <div v-for="(year, key) in years" :key="key" class="col-1">
                <button type="button" class="btn btn-secondary" @click="chengeYear(year)">{{ year }}</button>
            </div>
        </div>
        <div style="height: 20px;"></div>
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
                            {{pub.quantity}}
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
        :user_id="this.user_id"
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
    import api from '../api';

    export default {
    name: "Tests",
    components : {
        ModalComponent,
        PulseLoader
    },
    props: {
        user_id: Number,
    },
    /*async created() {
        //const response =  api.get('/sanctum/csrf-cookie');
        //console.log("USER: ", response)
        
        try {
            // Make an API request to get the authenticated user
            //api.get('/sanctum/csrf-cookie');
            const response =  api.get('/api/user');
            var user = response.data;

            console.log("USER: ",response.data )
        } catch (error) {
            console.error(error);
        }
    },*/
    data() {
        return {
        selectedMonth: Object,
        response: false,
        months: [],
        products: [],
        displayModal: false,
        currentYear: '2023',
        years : ['2023','2022','2021','2020','2019']
        };
    }, 
    methods: {
        chengeYear(year){
            this.currentYear = year;
        },
        getMonths(){
            console.log("USER ID: ", this.user_id)

            this.loading = true;
            api.get('/api/get-months/'+ this.user_id)
            .then((response)=>{
                this.loading = false;
                this.months = response.data.months;
                //console.log("RESP: " + JSON.stringify(response.data.months))
            });
        },
        getProducts(){
            this.loading = true;
            api.get('/api/get-products/'+ this.user_id)
            .then((response)=>{
                this.loading = false;
                this.products = response.data.products
               // console.log("RESP: " + JSON.stringify(response.data.products)) 
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
