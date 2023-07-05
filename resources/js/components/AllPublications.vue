<template>
    <div>
        <div class="row">
            <div class="col-5" >
                <h2>Dados de Produção Mensal ({{ currentYear }})</h2>
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
        <hr>

        <div style="height: 20px;"></div>
        <div class="d-flex flex-wrap justify-content-center" v-if="this.loading">
            Carregando Publicações <pulse-loader :loading="this.loading" ></pulse-loader>
        </div>
        <div v-for="(product, key) in productsCompanies" :key="key">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th width="200" class="thProd">{{product.name}} ({{product.unity}})</th>
                        <th>Total Anual {{product.created_at}}</th>
                        <th width="83" class="thFor" v-for="(month, key) in months" :key="key">                           
                            <div class="months">{{month.month}}</div>
                        </th>
                        <!--th class="text-center" colspan="3" style="width:15%">Acções</th-->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(companies, key) in product.users" :key="key">
                        <td>{{companies.name }}</td>
                        <td></td>
                        <td v-for="(pubs, key) in companies.publications" :key="key"> 
                            <b>{{ pubs.quantity }}</b>
                        </td>      
                    </tr>
                    <tr>
                        <td><b>Total Mensal</b></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        

    </div>
</template>
<script>
import api from '../api';
import PulseLoader from "vue-spinner/src/PulseLoader.vue"; //https://www.npmjs.com/package/vue-spinner
import Swal from 'sweetalert2' //https://sweetalert2.github.io/#usage

//const currentDate = new Date();
export default {
      components: {
        PulseLoader,
        Swal
      },
      mounted() {
        this.getYear()
      },
      data() {
        return {
          activeButton: 0,
          bcolor: "#039BE5",
          loading: false,
          productsCompanies: [],
          months: [],
          rows: [],
          //currentYear: currentDate.getFullYear(),
          currentYear: '2023',
          years : []
        }
      },
      computed: {
       
      },
      methods: {
        chengeYear(year, index){
            this.activeButton = index;
            this.bcolor = '#039BE5';
            this.year = year
            this.currentYear = year.year;
            this.getMonths(year.id);
            this.getPublications(year.id)
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
                this.getPublications()
                console.log("SELECTED YEAR: "+ this.year.year)

            });
        },
        getPublications(){
            this.loading = true;
            api.get('/api/get-allpublications')
            .then((response)=>{
                this.loading = false;
                this.productsCompanies = response.data.publications
               //console.log("RESP publications: " + JSON.stringify(response.data.publications)) 

                this.productsCompanies.forEach((company =>{
                    //console.log("PRODUCT: " + JSON.stringify(item.users)) 

                    company.users.forEach((async user =>{
                        //console.log("USER: " + JSON.stringify(user)) 
                        user.publications = []
                        await this.getEachPublication(user.id, company.id)
                        .then((response)=>{
                            response.forEach((async pub =>{
                                if( user.id == pub.user_id){
                                    user.publications.push(pub)
                                }
                            }));

                        });
                    }));
                }));


            });

            

        },
       async getEachPublication(user_id, product_id){
            var response = await api.get('/api/get-publications/'+user_id+"/"+product_id+"/"+this.year.id);
            console.log("PUB PER PRODUCT: " + JSON.stringify(response.data.publicationsProduct)) 

            return response.data.publicationsProduct;
        },
        showAlert(title, text, more, type){
            Swal.fire({
            title: title,
            text: `${text}\n${more}`,
            icon: type,
            confirmButtonText: 'OK'
            })
        }
      },
       
    }
</script>
<style scoped>
    th {
        text-align: center;
        vertical-align: middle;
    }
    .thFor{
        background-color: #5c636a;
        color: #ffff;
    }
    .thProd{
        background-color: #e6eaee;
    }
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