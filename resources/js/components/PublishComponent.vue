<template>
    <div class="container">

        <div class="row">
            <div class="col-4" >
                <h2>Dados de Produção ({{ currentYear }})</h2>
            </div>
            <div v-for="(year, key) in years" :key="key" class="col-1">
                <button type="button" 
                    class="btn btn-f" 
                    :style="{'background-color': activeButton === key ? this.bcolor : '#5C636A'}"
                    @click="chengeYear(year, key)">
                    {{ year.year }}
                </button>
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
        :year = year
        @save-product-event="saveProduct"
        @close-modal-event="hideModal"
        ></modal-component>
    </div>
</template>
<style scoped>
    .btn-f{
        color: white;
    }
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
    data() {
        return {
        selectedMonth: Object,
        response: false,
        months: [],
        products: [],
        displayModal: false,
        currentYear: '2023',
        year: {},
        activeButton: 0,
        bcolor: "#039BE5",
        };
    }, 
    methods: {
        chengeYear(year, index){
            this.activeButton = index;
            this.bcolor = '#039BE5';
            this.year = year
            this.currentYear = year.year;
            this.getMonths(year.id);
            this.getProducts(year.id)

        },
        getMonths(year){
            console.log("USER ID: ", this.user_id)
            this.loading = true;
            api.get('/api/get-months/'+ this.user_id+'/'+year)
            .then((response)=>{
                this.loading = false;
                this.months = response.data.months;
            });
        },
        getYear(){
            this.loading = true;
            api.get('/api/get-years')
            .then((response)=>{
                this.loading = false;
                this.years = response.data.years;
                this.year = this.years[0]
                this.getMonths(this.year.id)
                this.getProducts(this.year.id)
                console.log("SELECTED YEAR: "+ this.year.year)

            });
        },
        getProducts(year){
            this.loading = true;
            api.get('/api/get-products/'+ this.user_id+'/'+year)
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
        this.getProducts(this.year.id);
        this.getMonths(this.year.id);
        this.displayModal = false;
      },
    },
    mounted() {
        this.getYear()
        console.log('Component mounted.')
    }
}
</script>
