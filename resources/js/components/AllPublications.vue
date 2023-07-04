<template>
    <div>
        <div class="row">
            <div class="col-5" >
                <h2>Dados de Produção Mensal ({{ currentYear }})</h2>
            </div>
            <div v-for="(year, key) in years" :key="key" class="col-1">
                <button type="button" class="btn btn-secondary" @click="chengeYear(year)">{{ year }}</button>
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="d-flex flex-wrap justify-content-center" v-if="this.loading">
            Carregando Publicações <pulse-loader :loading="this.loading" ></pulse-loader>
        </div>
        <div v-for="(product, key) in productsCompanies" :key="key">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>{{product.name}}</th>
                        <th>Total Anual {{product.created_at}}</th>
                        <th class="toFor" v-for="(month, key) in months" :key="key">
                            <span class="badge bg-primary spn">                           
                                <div class="months">{{month.month}}</div>
                            </span>
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
        this.getPublications();
        this.getMonths()
      },
      data() {
        return {
          loading: false,
          productsCompanies: [],
          months: [],
          rows: [],
          //currentYear: currentDate.getFullYear(),
          currentYear: '2023',
          years : ['2023','2022','2021','2020','2019']
        }
      },
      computed: {
       
      },
      methods: {
        chengeYear(year){
            this.currentYear = year;
        },
        getMonths(){
            this.loading = true;
            api.get('/api/get-allmonths')
            .then((response)=>{
                this.loading = false;
                this.months = response.data.months;
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
            var response = await api.get('/api/get-publications/'+user_id+"/"+product_id);
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