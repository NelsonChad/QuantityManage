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
                            <div class="month" @click="showAddModal(month)">{{month.name}}</div>
                        </th>
                    </tr>
                   
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products" :key="index">                       
                        <td class="title">{{product.name}}</td>   
                        <td>{{product.unity}}</td>   
                        <td>{{product.quantity}}</td>   
                        <td class="values"  @click="showAddModal(month)" v-for="(month, key) in months" :key="key">    
                            {{month.id*(index+2)}}
                        </td>  
                    </tr>
                </tbody>
            </table>
        </div>
        <button class="btn btn-secondary" @click="showAddModal">Show Add Modal</button>
        <modal-component
        v-if="displayModal"
        :month="selectedMonth"
        @save-product-event="saveProduct"
        @close-modal-event="hideModal"
        ></modal-component>
    </div>
</template>
<style scoped>
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
        ModalComponent
    },
    data() {
        return {
        selectedMonth: Object,
        response: false,
        months: [
        { id: 1, name: 'January' },
            { id: 2, name: 'February' },
            { id: 3, name: 'March' },
            { id: 4, name: 'April' },
            { id: 5, name: 'May' },
            { id: 6, name: 'June' },
            { id: 7, name: 'July' },
            { id: 8, name: 'August' },
            { id: 9, name: 'September' },
            { id: 10, name: 'October' },
            { id: 11, name: 'November' },
            { id: 12, name: 'December' }
        ],
        products: [
            { id: 1, name: 'Ovos', quantity: 10, unity: 'Unit' },
            { id: 2, name: 'Racao A2', quantity: 5, unity: 'Kg' },
            { id: 3, name: 'Pintos de abate', quantity: 15, unity: 'Box' },
        ],
        displayModal: false
        };
    }, 
    methods: {
        getMonths(){
            this.loading = true;
            axios.get('http://localhost/companymanage/public/api/get-months')
            .then((response)=>{
                this.loading = false;
                
                console.log("RESP: " + JSON.stringify(response.data.months))
            });
        },
        getPubs(){
            this.loading = true;
            axios.get('http://localhost/companymanage/public/api/get-publications')
            .then((response)=>{
                this.loading = false;
                
                console.log("RESP: " + JSON.stringify(response.data))
            });
        },
      showAddModal(month) {
        this.selectedMonth = month;
        this.displayModal = true;
      },
      hideModal() {
        this.displayModal = false;
      },
    },
    mounted() {
        this.getMonths()
        console.log('Component mounted.')
    }
}
</script>
